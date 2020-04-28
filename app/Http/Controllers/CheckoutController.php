<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use App\Address;
use App\orderDetail;
use GuzzleHttp\Client;
use App\Mail\OrderPlaced;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CheckoutController extends Controller
{

    public function checkout(Request $request)
    {
        $cart = DB::select('call  getCart (?, ?) ', 
            [
                $request->user()->id,null
            ]
        );
         // return $cart;
         if (count($cart) == 0) {
            return response()->json(['success' => false , 'Sorry! No items on your cart.']);
        }
        // return $this->productsAreNoLongerAvailable($cart);
        if ($this->productsAreNoLongerAvailable($cart)) {
            return response()->json(['success' => false , 'Sorry! One of the items in your cart is no longer avialble.']);
        }
        $subtotal=DB::table('cart')
                    ->Join('users','cart.user_id','users.id')
                    ->Join('products','cart.product_id','products.id')
                    ->select(DB::Raw('SUM(cart.qty * products.price) subtotal'))
                    ->where('cart.user_id',$request->user()->id)
                    ->get()[0]->subtotal;
        $shipping = Address::find($request->address_id)->city->shipping_fees;
        
        $total = $subtotal + $shipping - $request->discount;
       
        
         DB::insert('call addOrder(?, ? , ? , ? , ? , ?) ', 
        [
            $request->address_id,
            $request->user()->id,
            $total,
            $subtotal,
            $request->discount,
            $request->gateway,
            
            ]
        );

        $order = Order::where('user_id' , $request->user()->id)->OrderBy('id' ,'DESC')->first();
        foreach($cart as $item){
           
            orderDetail::create([
                'product_id' => $item->id,
                'order_id' => $order->id,
                'qty' => $item->qty

            ]);
        }
        if($request->gateway == 'visa'){
            $url = $this->accept($order);
            return $url;
        }
        
        
        // Mail::send(new OrderPlaced($order , $cart));
        $this->decreaseQuantities($order->id);
        $this->destroyCart($request->user()->id);

        // Mail::send(new OrderPlacedAdmin($order));
        return response()->json(['success' => 'true' , 'message' => 'order placed successfully']);

    }

    protected function accept($order){
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        
        $client = new Client([
            'headers' => $headers
        ]);

        $url = $this->acceptKeyRequest($client , $order);

        return $url;
        
    }

    protected function acceptAuth($client){
        $url = "https://accept.paymobsolutions.com/api/auth/tokens";
        $token = env('ACCEPT_AUTH_TOKEN');
        $r = $client->request('POST', $url, [
            'body' => '{"api_key": "'.$token.'"}'
        ]);
        try {
            $response = $r->getBody()->getContents();
            $response = json_decode($response, true);
            $auth_token = $response['token'];
            $merchant = $response['profile']['id'];
        
            return ['auth_token' => $auth_token , 'merchant' => $merchant];
        } catch (HttpException $ex) {
            return $ex;
        }

    }
    protected function acceptOrderRegisteration($client , $order){
        //order request
        $auth = $this->acceptAuth($client);
        $auth_token = $auth['auth_token'];
        $merchant = $auth['merchant'];
        $url = 'https://accept.paymobsolutions.com/api/ecommerce/orders';
        
        $merchant_order_id = '#'.$order->id;
        $body ='{
            "auth_token": "'.$auth_token.'",
            "delivery_needed": "false",
            "merchant_id": "'.$merchant.'",
            "merchant_order_id": "'.$merchant_order_id.'",
            "amount_cents": "'.$order->total.'",
            "currency": "EGP",
            "items": []
            
          }';
          $r = $client->request('POST', $url, ['body' => $body]);
      try {
          $response = $r->getBody()->getContents();
          $response = json_decode($response, true);
          $accept_id = $response['id'];
          $order->accept_order_id = $accept_id;
          $order->save();
          return ['accept_id' =>$accept_id , 'auth_token' =>$auth_token];
          
      } catch (HttpException $ex) {
          return $ex;
      } 
    }
    protected function acceptKeyRequest($client ,  $order){
        $orderRegisteration = $this->acceptOrderRegisteration($client , $order);
        $accept_id = $orderRegisteration['accept_id'];
        $auth_token = $orderRegisteration['auth_token'];
        $payment_integration = env('ACCEPT_PAYMENT_INTEGRATION');
        //payment key request
        $billing_data = DB::select('SELECT a.apartment , u.email , u.name first_name , u.name last_name , a.building , u.phone phone_number , "FriendsEXP" shipping_method , a.postal postal_code , c.name city , "EGP" country , a.street , a.floor FROM orders o INNER JOIN addresses a ON a.id = o.address_id INNER JOIN users u ON u.id = a.user_id INNER JOIN cities c ON c.id = a.city_id WHERE o.id = ?' , [$order->id]);
        $billing = json_encode($billing_data[0]);
        $body = '{
            "auth_token": "'.$auth_token.'",
            "amount_cents": "'.$order->total.'", 
            "expiration": 36000, 
            "order_id": "'.$accept_id.'",    
            "billing_data": '.$billing.', 
            "currency": "EGP", 
            "integration_id": '.$payment_integration.',
            "lock_order_when_paid": "false"
          }';
        $r = $client->request('POST', "https://accept.paymobsolutions.com/api/acceptance/payment_keys", [
            'body' => $body,
        ]);

        try {
            $response = $r->getBody()->getContents();
            $response = json_decode($response, true);
            $payment_key = $response['token'];
            $url = 'https://accept.paymobsolutions.com/api/acceptance/iframes/7557?payment_token='.$payment_key;
            return  $url;
        } catch (HttpException $ex) {
            echo $ex;
        } 
    }
    protected function productsAreNoLongerAvailable($cart)
    {
        foreach ($cart as $item) {
            $product = DB::select('SELECT  order_limit FROM product_view WHERE slug = ?' , [$item->slug]);
            if ($product[0]->order_limit < $item->qty) {
                return true;
            }
        }

        return false;
    }

    public function confirm(Request $request)
    {
        $id = $request->merchant_order_id;
        $success = $request->success;
        $errorcode = (int)$request->txn_response_code;
        $errors = [
    	        'There was an error processing the transaction',
    	        'Contact card issuing bank',
    	        '',
    	        'Expired Card',
    	        'Insufficient Funds',
    	        'Payment is already being processed'
    	    ];
    	 if(in_array($errorcode, range(1,5))){
    	     $errormsg = $errors[$errorcode - 1];
    	 }else{
    	     $errormsg = 'Something went wrong and payment cannot be proceeded. Please check the information you have provided or try contacting your bank.';
    	 }
    
        $error = $request->error_occured;
        $order  = Order::find($id);
        if($error == "false" && $success == "true"){
             $this->decreaseQuantities($order->id);
             $this->destroyCart($order->user->id);
        }else{
            $order->error = $errormsg;
    	    $order->save();
        }


       return redirect("https://readerscorner.co/oroder/confirmation");
        // return view('design.confirmation')->with(['order' => $order , 'products' => $products , 'error' => $error , 'success' => $success, 'errormsg' => $errormsg]);
    }

    public function endpoint(Request $request)
    {
        $obj =  $request->obj;
    	$error = $obj['error_occured'];
    	$errorcode = $obj['data']['txn_response_code'];
    	$success = $obj['success'];
    	$order_id = (int)str_replace('#' , '' ,$obj['order']['merchant_order_id']);
    	$order = Order::find($order_id);
    	$errors = [
    	        'There was an error processing the transaction',
    	        'Contact card issuing bank',
    	        'Expired Card',
    	        'Insufficient Funds',
    	        'Payment is already being processed'
    	    ];
    	if($error !== false && $success == true){
          for($i=1;$i <= count($errors) ; $i++)
          
    	  {
    	        if($errorcode == $i){
    	            $order->error = $errors[$i];
    	            $order->save();
    	        }else{
    	            $order->error = 'Something went wrong and payment cannot be proceeded. Please check the information you have provided or try contacting your bank.';
    	            $order->save();
    	        }
    	  }
    	   
    	   
    	}
    	
    	
    	// $request = json_decode($transactionId, true);
    	//return $order;	
    }

    protected function destroyCart($id)
    {
        $cart = DB::delete('call  destroyCart (?, ?) ', 
            [
                $id,null
            ]
        );
    }

    protected function decreaseQuantities($order)
    {
        $data = DB::select('SELECT p.id product_id , s.qty stock_qty , od.qty order_qty  From order_details od INNER JOIN products p ON p.id = od.product_id INNER JOIN stock s ON s.product_id = p.id WHERE od.order_id = ?' ,[$order]) ;
        foreach($data as $d){
            Stock::create([
                'product_id' => $d->product_id,
                'qty' => $d->stock_qty - $d->order_qty,
            ]);
        }
    }

}
