<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CategorySeeder extends Seeder
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
        ])->get('https://readerscorner.co/public/api/categories');
        foreach (json_decode($response->body()) as $cat) {
            Category::create(['id' => $cat->id , 'name' => $cat->name , 'slug' => $cat->slug , 'parent_id' => $cat->parent_id ]);
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->get('https://readerscorner.co/public/api/categories/children');
        foreach (json_decode($response->body()) as $cat) {
            Category::create(['id' => $cat->id , 'name' => $cat->name , 'slug' => $cat->slug , 'parent_id' => $cat->parent_id ]);
        }
        
    }
}
