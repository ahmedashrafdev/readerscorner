<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getProducts(Request $request)
    {
       
        //offset , limit , sortby , search ,  sort func , category , author , language , age
        $products = DB::select('call getProducts(?, ?, ?, ? , ? , ? , ? , ? , ?) ', 
                        [
                           isset($request->offset) ? $request->offset :  0,
                            isset($request->limit) ? $request->limit : 10,
                            isset($request->sortBy) ? $request->sortBy : null,
                            isset($request->search) ? $request->search : null,
                            isset($request->sortFunc) ? $request->sortFunc : null,
                            isset($request->category) ? $request->category : null,
                            isset($request->author) ? $request->author : null,
                            isset($request->language) ? $request->language : null,
                            isset($request->age) ? $request->age : null
                        ]
                    );
        
        return response()->json($products);
    }

    public function getProduct($slug)
    {
        $product = DB::select('select * from product_view WHERE slug = ?' , [$slug]);
        return response()->json($product);
    }
}
