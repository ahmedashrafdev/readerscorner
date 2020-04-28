<?php

use App\Age;
use App\User;
use App\Order;
use App\Stock;
use App\Store;
use App\Author;
use App\Product;
use App\Category;
use App\Language;
use App\AgeProduct;
use GuzzleHttp\Client;
use App\CategoryProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::post('/paymob_notification_callback' , 'CheckoutController@callback');
Route::get('/oroder/confirmation' , 'CheckoutController@confirm')->name('order.confirmation');
Route::get('/', function () {
     $order = 1;
     $d = DB::select('SELECT p.id product_id , s.qty stock_qty , od.qty order_qty  From order_details od INNER JOIN products p ON p.id = od.product_id INNER JOIN stock s ON s.product_id = p.id WHERE od.order_id = ?' ,[$order]) ;
     dd($d);
     return view(('welcome'));
});
