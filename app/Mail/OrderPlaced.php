<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    public $cart;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order , $cart)
    {
        $this->order = $order;
        $this->cart = $cart;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        

        return $this->to($this->order->user->email, $this->order->user->name)
        			 ->subject('Order Confirmation #'.$this->order->id)
        			 ->markdown('emails.order');
    }
}
