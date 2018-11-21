<?php

namespace App\Http\Controllers;

use App\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // this is for writting logging messages to storage/logs. use it like Log::alert('goes through takeOrder action in orderController');
use Illuminate\Support\Facades\DB;
use GuzzleHttp; // this package is used to make HTTP request to external api
use App\Order;
use App\User;
use Response;
use function GuzzleHttp\json_decode;
// define constants
// define("ACCESS_KEY", "a7d887b9bdaae171366d6b2b284ffa4c"); // this is access key for ipStack api, which is used to get current user's geo location

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
      $response = $client->get( 'http://api.ipstack.com/'.$userIp . '?access_key=' . config('app.ACCESS_KEY'));

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

      $ordersPostedByUser = Order::where('owner', $user->name)->get();
      $completedOrdersPostByUser = Order::where('owner', $user->name)->where('completed', true)->get();

      $incompletedOrdersTakenByUser = Order::where('taker', $user->id)->where('completed', false)->get();

      $completedOrdersTakenByUser = Order::where('taker', $user->id)->where('completed', true)->get();

      return view('orders.index', compact('user','availableOrders', 'ordersPostedByUser', 'completedOrdersPostByUser', 'incompletedOrdersTakenByUser', 'completedOrdersTakenByUser', 'orders', 'currentUserlongitude', 'currentUserlatitude'));
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
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

        // update order owner's wallet
        $user = User::where('id', $order->user_id)->first();
        $userWalletBefore = $user->wallet;
        $remainWallet = $user->wallet - $order->price;
        if($remainWallet < 0) {
          return redirect('/')->with('error', 'Insufficient funds in your wallet, there is no free meal in this world:)');
        }
        $user->wallet = $remainWallet;

        // randomly choose a number from 1 to n ( n = total number of records in Order table)
        // for demo purpose
        $bingoNumber = 2;
        $randomNumber = random_int(1,2);
        // $randomNumber = 2; // uncomment this to see how a pop up looks like
        // if a random free order is the order we just saved, display a pop up window to ask users to share this news with their friends to promopt our site
        if($bingoNumber == $randomNumber) {
          $user->wallet = $userWalletBefore; // if the order is free then no charge for the order
        }
        $user->save();
        $order->save();

        // send emails to poster to notify their order has been posted
        $mailController = new MailController();
        $mailController->sendEmailWhenCreateNewOrder($order->title);

        
        if($bingoNumber == $randomNumber) {
          return redirect('/orders')->with('modal', 'hasModal');
        }

        return redirect('/orders')->with('modal', 'hasNoModal');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();
        $isAdmin = $user->type === "admin" ? true : false;
        $order = Order::findOrFail($id);

        $isOrderCreator = $order->user->id === $user->id ? true : false;

        return view('orders.show', compact('order', 'isAdmin', 'isOrderCreator'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = auth()->user();
        $isAdmin = $user->type === "admin" ? true : false;
        $order = Order::findOrFail($id);
        $isOrderCreator = $order->user->id === $user->id ? true : false;
        if (!$isOrderCreator && !$isAdmin) {
            return redirect('orders.show');
        }
        return view('orders.edit', compact('order', 'isAdmin', 'isOrderCreator'));
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

        $order->title = $request->title;
        $order->item = $request->item;
        $order->description = $request->description;
        $order->address = $request->address;
        $order->price = $request->price;
        $order->longitude = $request->longitude;
        $order->latitude = $request->latitude;

        // for admin edit only
        if (isset($request->taker)) {
            $order->taker = $request->taker;
        }
        if (isset($request->confirmed)) {
            $order->confirmed = $request->confirmed === "1" ? true : false;
        }
        if (isset($request->completed)) {
            $order->completed = $request->completed === "1" ? true : false;
        }

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
        $order->delete();
        return redirect('/orders');
    }


    /**
     * This action is for displaying orders.comment view
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function displayCommentForm(Request $request, $id)
    {
      if(auth()->user() == null) {
        return redirect('/')->with('error', 'You need to login in order to leave comment'); 
      }
      // the input $id is refering to the order id
      $order = Order::findOrFail($id);
      $takerId = $order->taker;
      $userName = User::where('id', $takerId)->first()->name;
      // Log::alert('message!!! '.$user);
      // Log::alert('message2222 '.$user->name);
      // $userName = $user->name;
      return view('orders.comment', compact('order', 'userName'));
    }

    /**
     * this action is for handling the comment form submission
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitCommentForm(Request $request)
    {
      // the input $id is refering to the order id
      $request->validate([
        'comment' => 'required',
        'orderId' => 'required',
        'rating' => 'required'
      ]);
      
      // if user is not authorized, then kick him out of the site.
      if(auth()->user() == null) {
        return redirect('/')->with('error', 'You need to login in order to leave comment'); 
      }
      try {
        $order = Order::where('id', $request->orderId)->update(['comment'=> $request->comment, 'rating' => $request->rating]);
      } catch( \Exception $e) {
        return redirect('/profile')->with('error', 'Fail to update comment Error: '.$e);
      }
      
      return redirect('/profile')->with('success', 'Comment submitted! Thank you for taking the time, your comment is important to both the platform and the taker:)');
    }


    /**
     * Assign the specified order to the currently logged in user.
     * this action is for responding to the ajax call from orders.index view
     *
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

    /**
     * Get users orders based on user id
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getUserOrders($id) {
        $viewer = auth()->user();
        $user = User::findOrFail($id);

        if ($viewer->type != 'admin') {
            return redirect('/');
        }

        $orders = $user->orders;
        return view('admin.userorders', compact('orders', 'user'));
    }
}
