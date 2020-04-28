<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function address()
    {
        return $this->belongsTo('App\Address');
    }
    public function shipping()
    {
        return $this->address->city->shipping_fees;
    }
}
