<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');
Route::resource('orders', 'OrdersController');
Route::post('orders/take/{id}', 'OrdersController@takeOrder'); // this route is for receiving ajax call from orders.index view
Route::get('showDirection/{id}', 'DirectionController@showDirection')->name('showDirection');


/*
|--------------------------------------------------------------------------
| Testing Routes
|--------------------------------------------------------------------------
|
| DO NOT enable it for deployment, for testing only
|
*/

//use App\Order;
//Route::get('/allorders', function() {
//    $orders = Order::all();
//    return $orders;
//});