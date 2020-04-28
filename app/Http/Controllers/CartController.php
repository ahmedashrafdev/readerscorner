<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function getCartItems(Request $request , $instance = null)
    {
        $cart = DB::select('call getCart(?, ?) ', 
        [
            $request->user()->id,$instance
        ]
    );
        

        return response()->json($cart);
    }
    public function SetCartItem(Request $request , $instance = null)
    {

        $cart = DB::insert('call addToCart(?, ? , ? , ?) ', 
        [
            $request->product,
            $request->user()->id,
            isset($request->qty) ? $request->qty :  1,
            $instance

        ]
    );

        return response()->json(['success' => 'true' , 'message' => 'added to cart successfully']);
    }
    public function DeleteCartItem($id)
    {
        $cart = DB::delete('call deleteFromCart(?) ', 
            [
            $id
            ]
        );

        return response()->json(['success' => 'true' , 'message' => 'deleted from cart successfully']);
    }
    public function UpdateCartItem(Request $request ,$id)
    {
        $cart = DB::delete('call updateCartItem(? , ?) ', 
            [
                $id,
                $request->qty
            ]
        );

        return response()->json(['success' => 'true' , 'message' => 'quantity updated successfully']);
    }
}
