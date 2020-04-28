<?php

use App\Author;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class AuthorSeeder extends Seeder
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
            'Accept' => 'application/json',
        ])->get('https://readerscorner.co/api/authors');
        foreach (json_decode($response->body()) as $author) {
            Author::create(['name' => $author->name , 'slug' => $author->slug , 'active' => $author->top ]);
        }
       
    }
}
