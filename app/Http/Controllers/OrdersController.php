<?php

namespace App\Http\Controllers;

use App\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // this is for writting logging messages to storage/logs. use it like Log::alert('goes through takeOrder action in orderController');
use Illuminate\Support\Facades\DB;
use GuzzleHttp; // this package is used to make HTTP request to external api
use App\Order;
use Response;
use function GuzzleHttp\json_decode;
// define constants
define("ACCESS_KEY", "a7d887b9bdaae171366d6b2b284ffa4c"); // this is access key for ipStack api, which is used to get current user's geo location

class OrdersController extends Controller
{
    /**
     * Display nearest available orders (exclued currently logged in user).
     * Display orders that were created by currently logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if(auth()->user() === null) {
        // if gets in this statement meaning the user is not logged in
        return redirect('/')->with('error', 'You need to login in order to view/create order.'); 
      }
      $orders = Order::all(); // this is for the debugging purpose, to print all records of order
      $user = null;
      if(auth()->user() !== null) {
        $user = auth()->user();
      }

      // availableOrders contain the orders that do not belong to currently logged in user, also it is sored by longtitude and latitude

      // get user's ip
      if(env('APP_ENV') == 'local') {
        $userIp = env('MY_IP'); // fill in your public IP for development in .env
      } else {
        // this is for production
        $userIp = \Request::ip();
        if(!$userIp || $userIp == null) {
          return redirect('/orders')->with('error', 'There is a problem with your public IP, we are not able to retrieve your public IP. Are you browsing our site through VPN? If yes, turn it off and try visiting again.');
        }
      }

      // use GuzzleHttp( a package to make HTTP request in server) to make api call
      $client = new GuzzleHttp\Client();
      $response = $client->get( 'http://api.ipstack.com/'.$userIp . '?access_key=' . ACCESS_KEY);

      $responseBody = $response->getBody();// the response is an PSR-7 object so that we need to call an instance method to get the response body, checkout GuzzleHttp documentation for details
      // convert json to array of strings
      $response = json_decode($responseBody, true);
      // get user's latitude longtitude
      $currentUserlongitude = $response['longitude'];
      $currentUserlatitude = $response['latitude'];

      // sql query to return nearest available orders
      $availableOrders = Order::select(DB::raw('*, ( 6367 * acos( cos( radians('.$currentUserlatitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$currentUserlongitude.') ) + sin( radians('.$currentUserlatitude.') ) * sin( radians( latitude ) ) ) ) AS distance'))
        ->where('owner', '!=' , $user->name)->whereNull('taker')
        ->having('distance', '<', 10000)
        ->orderBy('distance')
        ->take(5)
        ->get();
      
      // $availableOrders = Order::where('owner', '!=' , $user->name)->whereNull('taker')->get();
      $ordersFromCurrentUsers = Order::where('owner', $user->name)->get();
      return view('orders.index')->with(['user'=>$user, 'availableOrders'=> $availableOrders,'ordersFromCurrentUsers' => $ordersFromCurrentUsers, 'orders' => $orders, 'currentUserlongitude' => $currentUserlongitude, 'currentUserlatitude' => $currentUserlatitude]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // we also need to all current user's id and address here (address can be taken from form as well)
        $request->validate([
          'title' => 'required',
          'item' => 'required',
          'address' => 'required',
          'price' => 'required',
          'longitude' => 'required',
          'latitude' => 'required'
        ]);
        
        $order = new Order;
        // store the current logged in user as owner of the order
        if(auth()->user() !== null) {
          $user = auth()->user();
          $order->owner = $user->name;
        } else {
          return redirect('/orders')->with('error', 'You need to login in order to create order'); 
        }
        $order->title = $request->title;
        $order->item = $request->item;
        $order->description = $request->description;
        $order->address = $request->address;
        $order->price = $request->price;
        $order->longitude = $request->longitude;
        $order->latitude = $request->latitude;
        $order->user_id = auth()->user()->id; // this is how you access logged in user's id

        $order->save();

        // send emails to poster to notify their order has been posted
        $mailController = new MailController();
        $mailController->sendEmailWhenCreateNewOrder($order->title);

        return redirect('/orders');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        // store the current logged in user as owner of the order
        if(auth()->user() !== null) {
            $user = auth()->user();
            $order->owner = $user->name;
        } else {
            return redirect('/orders')->with('error', 'You need to login in order to create order');
        }
        $order->title = $request->title;
        $order->item = $request->item;
        $order->description = $request->description;
        $order->address = $request->address;
        $order->price = $request->price;
        $order->longitude = $request->longitude;
        $order->latitude = $request->latitude;
        $order->user_id = auth()->user()->id; // this is how you access logged in user's id
        $order->save();

        return redirect('/orders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        // a shorter version
        // Order::whereId($id).delete();
        $order->delete();
        return redirect('/orders');
    }


    /**
     * assign the specified order to the currently logged in user.
     * this action is for responding to the ajax call from orders.index view
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function takeOrder($id)
    {
      try{
        $takerId = auth()->user()->id;
        $order = Order::where('id', $id)->update(['taker'=> $takerId]);
        if(!$order || $order == null) {
          return \Response::json(['msg' => 'failed to take order, failed in updating DB record'], 400);
        }

        $ownerId = Order::where('id', $id)->first()->user_id;
        $orderTitle = Order::where('id', $id)->first()->title;
        $mailController = new MailController();
        $mailController->sendEmailToNotifyOrderOwner($ownerId, $orderTitle);

      } catch ( \Exception $e ) {
        return \Response::json(['msg' => "failed to take order, unknown error: $e"], 500);
      }
      return \Response::json(['msg' => 'successfully taken', 'takenId' => $id], 200);
    }
}
