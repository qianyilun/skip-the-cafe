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

// Routes for order CRUD
Route::resource('orders', 'OrdersController');
Route::get('allOrders', 'OrdersController@allOrders')->name('allOrders');

Route::post('orders/take/{id}', 'OrdersController@takeOrder'); // this route is for receiving ajax call from orders.index view
Route::get('comment/{id}', 'OrdersController@displayCommentForm')->name('comment'); // this route is for displaying comment form
Route::post('comment', 'OrdersController@submitCommentForm'); // this route is for submitting comment form to an order
Route::get('showDirection/{id}', 'DirectionController@showDirection')->name('showDirection');
Route::get('/sendTestEmails', 'MailController@sendEmailWhenCreateNewOrder');
Route::get('notifyOwner/{id}', 'MailController@sendEmailToNotifyOwnerOrderCompleted')->name('notifyOwner');
Route::post('/autocomplete/fetch', 'AutocompleteController@fetch')->name('autocomplete.fetch');

Route::get('/chat', 'GroupChatController@index')->name('chat');
Route::get('messages', 'GroupMessageController@fetchMessages');
Route::post('messages', 'GroupMessageController@sendMessage');

Route::get('/private/{id}', 'DirectionController@private')->name('private');
Route::get('/users/{id}', 'HomeController@users')->name('users');
Route::get('/allUsers', 'HomeController@allUsers')->name('allUsers');
Route::get('/privateChatBox', 'HomeController@privateChatBox')->name('privateChatBox');

Route::get('/private-messages/{user}', 'MessageController@privateMessages')->name('privateMessages');
Route::post('/private-messages/{user}', 'MessageController@sendPrivateMessage')->name('privateMessages.store');

/****************
 * Admin Routes *
 ****************/
// entry point for admin page
Route::get('/admin', 'AdminController@admin')
    ->middleware('is_admin')
    ->name('admin');
// entry point for admin page (for testing only)
Route::get('/testadmin', 'AdminController@testAdmin')->name('testAdmin');
// shows all orders of a user
Route::get('admin/user/{id}/orders', 'OrdersController@getUserOrders');
// grant a user admin privilege
Route::get('admin/user/{id}/grantadmin', 'AdminController@grantAdmin');
// update user info
Route::get('admin/user/{id}/edit', 'AdminController@editUser');
Route::post('admin/user/{id}/update', 'AdminController@updateUser');
// delete a user
Route::post('admin/user/{id}/delete', 'AdminController@deleteUser');
// create a new user
Route::get('admin/user/create', 'AdminController@createUser');
Route::post('admin/user/store', 'AdminController@storeUser');

// user profile
Route::get('/profile', 'ProfileController@index')->name('profile');

// dashboard
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');



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