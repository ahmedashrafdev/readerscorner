<?php

use App\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->get('https://readerscorner.co/public/api/stores');
        foreach (json_decode($response->body()) as $store) {
      
            Store::create(['name' => $store->name , 'email' =>null ,'address' =>$store->address , 'phone' => $store->phone ,'map' => $store->map ]);
        }
    }
}
