<?php

use App\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::insert([['name' => 'cairo' , 'shipping_fees' => 40  ] , ['name' => 'alexandria' , 'shipping_fees' => 60  ]]);
    }
}
