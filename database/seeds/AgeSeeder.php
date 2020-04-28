<?php

use App\Age;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class AgeSeeder extends Seeder
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
        ])->get('https://readerscorner.co/public/api/ages');
        foreach (json_decode($response->body()) as $age) {
            Age::create(['name' => $age->name , 'slug' => $age->slug]);
        }
    }
}
