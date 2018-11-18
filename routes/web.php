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

Route::get('/chat', 'ChatController@index')->name('chat');
Route::get('/private/{id}', 'DirectionController@private')->name('private');
Route::get('/users/{id}', 'HomeController@users')->name('users');

Route::get('messages', 'MessageController@fetchMessages');
Route::post('messages', 'MessageController@sendMessage');
Route::get('/private-messages/{user}', 'MessageController@privateMessagesm')->name('privateMessages');
Route::post('/private-messages/{user}', 'MessageController@sendPrivateMessage')->name('privateMessages.store');
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