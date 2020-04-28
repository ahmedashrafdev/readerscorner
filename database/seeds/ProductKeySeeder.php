<?php

use App\ProductKey;
use Illuminate\Database\Seeder;

class ProductKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $keys = [
            ['name' => 'best sellers' , 'slug' => 'bestsellers'],
            ['name' => 'popular' , 'slug' => 'popular'],
            ['name' => 'teens bestseller' , 'slug' => 'teens_bestseller'],
            ['name' => 'arabic bestseller' , 'slug' => 'arabic_bestseller'],
        ];
        ProductKey::insert($keys);
    }
}
