<?php

use App\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class LanguageSeeder extends Seeder
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
        ])->get('https://readerscorner.co/public/api/languages');
        foreach (json_decode($response->body()) as $lang) {
            Language::create(['name' => $lang->name , 'slug' => $lang->slug  ]);
        }
    }
}
