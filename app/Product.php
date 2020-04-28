<?php

namespace App;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    public static function allProduct()
    {
       $products = app(Pipeline::class)
                ->send(\App\Product::query())
                ->through([
                    \App\QueryFilters\Category::class,
                    \App\QueryFilters\Author::class,
                    \App\QueryFilters\Language::class,
                    \App\QueryFilters\Age::class,
                    \App\QueryFilters\Price::class,
                ])
                ->thenReturn()
                ->paginate(10);
        return $products;
    }
}
