<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // this is for writting logging messages to storage/logs. use it like Log::alert('goes through takeOrder action in orderController');

use App\Order;
use Response;

class OrdersController extends Controller
{
    /**
     * Display available orders (exclued currently logged in user).
     * Display orders that were created by currently logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
      $availableOrders = Order::where('owner', '!=' , $user->name)->whereNull('taker')->get();
      $ordersFromCurrentUsers = Order::where('owner', $user->name)->get();
      return view('orders.index')->with(['user'=>$user, 'availableOrders'=> $availableOrders,'ordersFromCurrentUsers' => $ordersFromCurrentUsers, 'orders' => $orders]);
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
        $order->update($request->all());

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
        $user = auth()->user();
        $order = Order::where('id', $id)->update(['taker'=> $user->name]);
        return \Response::json(['msg' => 'taken'], 200);
    }

}
