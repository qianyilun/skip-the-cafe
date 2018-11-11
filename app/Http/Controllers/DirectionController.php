<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // this is for writting logging messages to storage/logs. use it like Log::alert('goes through takeOrder action in orderController');
use Illuminate\Support\Facades\DB;
use GuzzleHttp; // this package is used to make HTTP request to external api
use App\Order;
use Response;
use function GuzzleHttp\json_decode;
define("ACCESS_KEY", "a7d887b9bdaae171366d6b2b284ffa4c");

class DirectionController extends Controller
{
    
    public function showDirection($id) {
      // Log::alert('get in showDirection action');
      $order = Order::findOrFail($id);
      $orderLatitude = $order->latitude;
      $orderLongitude = $order->longitude;

       // get user's ip
      if(env('APP_ENV') == 'local') {
        $userIp = env('MY_IP'); // fill in your public IP for development in .env file
      } else {
        // this is for production
        $userIp = \Request::ip();
        if(!$userIp || $userIp == null) {
          return redirect('/orders')->with('error', 'There is a problem with your public IP, we are not able to retrieve your public IP. Are you browsing our site through VPN? If yes, turn it off and try visiting again.');
        }
      }
      $client = new GuzzleHttp\Client();
      $response = $client->get( 'http://api.ipstack.com/'.$userIp . '?access_key=' . ACCESS_KEY);

      $responseBody = $response->getBody();// the response is an PSR-7 object so that we need to call an instance method to get the response body, checkout GuzzleHttp documentation for details
      // convert json to array of strings
      $response = json_decode($responseBody, true);
      // get user's latitude longtitude
      $currentUserlongitude = $response['longitude'];
      $currentUserlatitude = $response['latitude'];
      return view('directions.showDirection', compact('id', 'orderLongitude', 'orderLatitude', 'currentUserlongitude', 'currentUserlatitude'));
    }
}
