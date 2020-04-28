<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = [];
    public function city()
    {
        return $this->belongsTo('App\City');
    }
}
