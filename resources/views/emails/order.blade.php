<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    
    <title>Readers Corner Email</title>
    <style>
        
    </style>
  </head>
  <body style="font-family:sans-serif;  
            color:#333;">
    
    <div id="app" class="container" style="max-width : 800px;
            width:100%;
            margin:auto auto;
            padding:15px;">
        <img style="width:150px;
            height:auto;" width="150" src="http://readerscorner.co/storage/settings/May2019/S3fivD7C4Y2oXfnGaEsa.png" />
    <table  align="center" style="width:100%">
      <tr>
        <th style="text-align:right;"><strong>Order number</strong>:  #{{$order->id}}</th>
      </tr>
      <tr>
        <td style="width:80%">
            <h1 class="heading" style="font-weight:normal;">
                YOUR ORDER 
            </h1>
            <p style="line-height: 23px !important;" class="paragraph ">Dear {{$order->user->fname}}</p>
            <p style="line-height: 23px !important;" class="paragraph">
            Thank you for ordering at Reader’s Corner. We received your order on {{$order->created_at}}. 
            The order will be verified and processed as soon as possible. Your order details are listed below. 
            Once your order is processed, you will receive an email notifying you that your order has been shipped. 
            </p>
            <p style="line-height: 23px !important; color : #a29595 !important;
    }" class="paragraph light">
                Your order should arrive within two to five business days. 
            </p>
        </td>
      </tr>
    </table> 
    <table  align="center" style="width:100%; border-collapse: collapse;">
      <tr style="height: 50px;
            background-color: #CCCCCC;">
        <th style="color: #000;
            font-weight: 400;
            font-size:18px;
            text-align:center;width:50%">Shipping To</th>
        <th style="color: #000;
            font-weight: 400;
            font-size:18px;
            text-align:center;width:50%">Payment Method</th>
      </tr>
      <tr>
       <td style="text-align:center;"><address style="margin: 20px 0;">
                    {!!$order->address!!}
                </address></td>
       <td  style="text-align:center;"><span style="margin: 20px 0;display:block">
                @if($order->gateway == "visa")
                    Credit Card
                @else
                    Cash on Delivery
               @endif
            </span>
        </td>
      </tr>
    </table> 
    
    <table  align="center" style="width:100%; border-collapse: collapse;">
      <tr style="height: 50px;
            background-color: #CCCCCC;">
        <th style="color: #000;
            font-weight: 400;
            font-size:18px;
            text-align:center;width:60%">Item</th>
        <th style="color: #000;
            font-weight: 400;
            font-size:18px;
            text-align:center;width:10%">Quantity</th>
        <th style="color: #000;
            font-weight: 400;
            font-size:18px;
            text-align:center;width:20%">Unit Price</th>
        <th style="color: #000;
            font-weight: 400;
            font-size:18px;
            text-align:center;width:10%">Total</th>
      </tr>
      @foreach($cart as $product)
      <tr>
       <td style="text-align:center;">
           <table style="width: 100%;
margin: 22px 0;">
               <tr>
                   @php
                    $image = str_replace('\\', '/', $product->image);
                   @endphp
                   <th style="width:100px;text-align:center"><img src="{{$image}}" width="100" style="margin-right:5px"></th>
               </tr>
               <tr>
                   <td style="text-align:center"><span >{{$product->name}}</span></td>
               </tr>
           </table>
            
             
           
        </td>
       <td  style="text-align:center;"><span style="margin-top: 20px;display:block">
                {{$product->qty}}
            </span>
        </td>
        <td  style="text-align:center;"><span style="margin-top: 20px;display:block">
            {{$product->price . 'EGP'}}
            </span>
        </td>
        <td  style="text-align:center;"><span style="margin-top: 20px;display:block">
            
                {{$product->subtotal . 'EGP'}}
            
            </span>
        </td>
      </tr>
      @endforeach
      
    </table> 
    <table  align="center" style="width:100%; border-collapse: collapse;">
      <tr style="height: 50px;margin-bottom:1px;
            background-color: #E5E5E5;">
        <th style="color: #000;
            font-weight: 400;
            font-size:18px;
            text-align:left;width:50%;padding:12px">
            <div  style="margin-bottom : 20px">Subtotal</div>
            <div style="font-size:14px;color:#31B09D">Shipping fees</div>
        </th>
        <th style="color: #000;
            font-weight: 400;
            font-size:18px;
            text-align:right;width:50%;padding:12px">
            <div style="margin-bottom : 20px">{{$order->subtotal}}</div>
            <div style="font-size:14px;color:#31B09D">{{$order->shipping()}}</div>
        </th>
      </tr>
      <tr style="height:2px"></tr>
      <tr style="height: 50px;
            background-color: #E5E5E5;">
        <th style="color: #000;
            font-weight: 400;
            font-size:18px;
            text-align:left;width:50%;padding:12px">
            <div  style="margin-bottom : 20px">Total</div>
        </th>
        <th style="color: #000;
            font-weight: 400;
            font-size:18px;
            text-align:right;width:50%;padding:12px">
            <div style="margin-bottom : 20px">{{$order->total}}</div>
        </th>
      </tr>
    </table>
    <table>
        <tr style="width:80%">
              <td>
                  <p>Please confirm your order information is correct. Orders cannot be modified once they are placed. If you have any questions or you would like to track your order, please send us an email at  <a href = "mailto: support@readerscorner.co">support@readerscorner.co</a></p>
                     <p>We look forward to seeing you again soon at Reader’s Corner!
                        Best regards,</p>
                    <p>Your Reader’s Corner Team</p>    
    
              </td>
          </tr>
      </table>
      {{-- <table style="margin-top : 50px">
        <tr>
              <td  style="color:#6F6A6A">
                  <h4 style="font-weight:700">Customer Service</h4>
                  <p> For inquiries and suggestions, which relate to online purchases:</p>
                     <p>24 hours a day, 7 days a week.</p>
                     @if( info_media('phone') !== null)
                    <p>Phone:{{ info_media('phone') }}</p>
                    @endif
                    <p>E-mail: <a href = "mailto: support@readerscorner.co">support@readerscorner.co</a></p>   
                    <p style="margin-top:15px">Please note: This e-mail was sent from a notification-only address that can't accept incoming e-mail. Please do not reply to this message.</p>
    
              </td>
          </tr>
      </table> --}}
        <footer style="text-align:center;margin-top: 35px;color:#6F6A6A">You will find answers to your questions on our online help pages.</footer>
    </div>
    <!-- built files will be auto injected -->
  </body>
</html>
