<?php

use App\Age;
use App\Stock;
use App\Author;
use App\Product;
use App\Category;
use App\Language;
use App\AgeProduct;
use App\ProductKey;
use App\CategoryProduct;
use App\ProductKeyPivot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ProductSeeder extends Seeder
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
        ])->get('https://readerscorner.co/public/api/products');
        foreach (json_decode($response->body()) as $product) {
            // dd($product);
            $author = Author::where('slug' , $product->authorSlug)->first();
            $author = $author !== null ? $author->id : null;
            $language = Language::where('slug' , $product->languageSlug)->first();
            $language = $language !== null ? $language->id : null;
            
            $categories = Category::whereIn('slug' , $product->categoriesSlugs)->pluck('id');
            $ages = Age::whereIn('slug' , $product->agesSlugs)->pluck('id');
            // dd($product->languageSlug);
    
            $productt = Product::create([
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'details' => $product->details,
                    'description' => $product->description,
                    'image' => $product->image,
                    'price' => $product->price / 100,
                    'language_id' => $language,
                    'author_id' => $author,
                ]);
            if($product->bestseller){
                ProductKeyPivot::create(['product_id' => $productt->id , 'key_id' => ProductKey::where('slug' , 'bestsellers')->first()->id ]);
            }
            if($product->teens_bestseller){
                ProductKeyPivot::create(['product_id' => $productt->id , 'key_id' => ProductKey::where('slug' , 'teens_bestseller')->first()->id ]);
            }
            if($product->arabic_bestseller){
                ProductKeyPivot::create(['product_id' => $productt->id , 'key_id' => ProductKey::where('slug' , 'arabic_bestseller')->first()->id ]);
            }
            if($product->popular){
                ProductKeyPivot::create(['product_id' => $productt->id , 'key_id' => ProductKey::where('slug' , 'popular')->first()->id ]);
            }
            foreach($categories as $cat){
                CategoryProduct::create([
                    'category_id' => $cat,
                    'product_id' => $productt->id
                ]);
            }
            Stock::create([
                'product_id' => $productt->id,
                'qty' => $product->quantity,
            ]);
            foreach($ages as $age){
                AgeProduct::create([
                    'age_id' => $age,
                    'product_id' => $productt->id
                ]);
            }
    
        }
    }
}
