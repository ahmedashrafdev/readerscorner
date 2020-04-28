<?php

namespace App\Http\Controllers;

use App\Age;
use App\Author;
use App\Banner;
use App\Category;
use App\Language;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function getBanners(){
        $banners = Banner::select('image')->orderBy('orderBy')->get();
        return json_encode($banners);
    }

    public function getCategories($category = null){
        $categories = Category::select('name' , 'slug' , 'id')->where('parent_id' , $category)->orderBy('orderBy')->get();
        return json_encode($categories);
    }

    public function getAuthors(){
        $authors = Author::select('name' , 'slug' , 'id')->where('active' , true)->get();
        return json_encode($authors);
    }

    public function getLanguages(){
        $languages = Language::select('name' , 'slug' )->get();
        return json_encode($languages);
    }
    public function getAges(){
        $ages = Age::select('name' , 'slug' )->get();
        return json_encode($ages);
    }

    
}
