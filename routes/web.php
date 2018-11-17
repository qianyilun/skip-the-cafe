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

use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Mail;

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
Route::get('/sendTestEmails', 'MailController@sendEmailWhenCreateNewOrder');
Route::get('notifyOwner/{id}', 'MailController@sendEmailToNotifyOwnerOrderCompleted')->name('notifyOwner');


/**
 * A test router for sending emails, also with an anonymous function
 */
Route::get('/sendTestEmails', function () {
   $data = [
       'title' => 'Order submitted and posted',
       'content' => 'This is content'
   ];

   Mail::send('emails.test', $data, function($message) {
       $message->to('qianyiluntemp@gmail.com', 'yilun qian')->subject('hey');
   });
});

//Route::get('/sendNewOrderEmail', 'MailController@send');
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