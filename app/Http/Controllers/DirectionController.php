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
    // helper function to calculate the distance between two coordinates
    // refer to :stackoverflow.com/questions/10053358/measuring-the-distance-between-two-coordinates-in-php
    private function distance($lat1, $lon1, $lat2, $lon2, $unit) {
      $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      $unit = strtoupper($unit);
    
      if ($unit == "K") {
          return ($miles * 1.609344);
      } else if ($unit == "N") {
          return ($miles * 0.8684);
      } else {
          return $miles;
      }
    }
    
    public function showDirection($id) {
      // Log::alert('get in showDirection action');
      $order = Order::findOrFail($id);
      $orderAddress = $order->address;
      $orderItem = $order->item;
      $orderOwner = $order->owner;
      $orderPrice = $order->price;
      $orderDescription = $order->description;
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

      // calculate distance and store it because dashboard needs distance to calculate calorie
      $distance = $this->distance($currentUserlatitude, $currentUserlongitude ,$orderLatitude,$orderLongitude, "K");
      $distance = preg_replace('/(\.\d\d).*/', '$1', $distance); // reserve last two digits of the decimals
      Order::where('id', $id)->update(['distance' => $distance]);
      return view('directions.showDirection', compact('id', 'orderLongitude', 'orderLatitude', 'currentUserlongitude', 'currentUserlatitude', 'orderAddress', 'orderItem', 'orderOwner', 'orderPrice','orderDescription'));
    }

    public function private($id)
    {
        $order = Order::findOrFail($id);
        $ownerId = $order->user_id;

        $mailController = new MailController();
        $mailController->sendEmailToRemindUserChatMessage($order->id);

        return view('private')->with(['id'=> $ownerId]);
    }
}
