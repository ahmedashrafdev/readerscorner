<?php

use App\Http\Controllers\HomePageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/banners' , 'HomePageController@getBanners');
Route::get('/categories/{category?}' , 'HomePageController@getCategories');
Route::get('/authors' , 'HomePageController@getAuthors');
Route::get('/languages' , 'HomePageController@getLanguages');
Route::get('/ages' , 'HomePageController@getAges');
Route::prefix('product')->group(function(){
    Route::get('/','ProductController@getProducts');
    Route::get('/{slug}','ProductController@getProduct');
    
});


Route::middleware('auth:api')->group(function () {
    //addresses
    Route::prefix('user')->group(function(){
        Route::get('/','UserController@getUser');
        Route::post('address/add' , 'UserController@addAddress');
        Route::get('update','UserController@getUser');
        Route::get('addresses','UserController@getAddresses');
        Route::post('addresses/{id}/update','UserController@updateAddresse');
        Route::post('update','UserController@updateUser');
        Route::delete('addresses/{id}/delete','UserController@deleteAddress');
        
    });

    Route::prefix('cart')->group(function(){
        Route::get('/{instance?}','CartController@getCartItems');
        Route::post('/add/{instance?}','CartController@SetCartItem');
        Route::delete('/remove/{id}','CartController@DeleteCartItem');
        Route::post('/update/{id}','CartController@UpdateCartItem');
        
    });

    Route::prefix('checkout')->group(function(){
        Route::post('/','CheckoutController@checkout');
       
        
    });
});

Route::middleware('guest:api')->group(function () {

    Route::post('/login','UserController@login')->name('api.login');
	Route::post('/register','UserController@register')->name('api.register');
});
