<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\User;
use Carbon\Carbon;

class DashboardController extends Controller
{    
    public function index()
    {
      if(auth()->user() === null) {
        return redirect('/')->with('error', 'Please login first'); 
      }

      $user = null;
      if(auth()->user() !== null) {
        $user = auth()->user();
      }

      $weekly_order_count = [0,1,2,3,4,5,6];
      foreach ($weekly_order_count as $i){
        $day = Carbon::now()->subDays($i);
        $order_count= count(Order::whereDate('created_at', $day)->where('owner', $user->name)->get());
        $weekly_order_count[6-$i] = $order_count;
      };

      $weekly_order_spend = [0,1,2,3,4,5,6];
      foreach ($weekly_order_spend as $i){
        $day = Carbon::now()->subDays($i);
        $order = Order::whereDate('created_at', $day)->where('owner', $user->name)->get();
        $order_spend= $order->sum('price');
        $weekly_order_spend[6-$i] = $order_spend;
      };

      $weekly_delivery_count = [0,1,2,3,4,5,6];
      foreach ($weekly_delivery_count as $i){
        $day = Carbon::now()->subDays($i);
        $order_count= count(Order::whereDate('created_at', $day)->where('taker', $user->id)->get());
        $weekly_delivery_count[6-$i] = $order_count;
      };





      $ordersPostedByUser = Order::where('owner', $user->name)->get();
      $ordersDeliveriedByUser = Order::where('taker', $user->id)->get();


      $completedOrdersPostByUser = Order::where('owner', $user->name)->where('completed', true)->get();

      $incompletedOrdersTakenByUser = Order::where('taker', $user->id)->where('completed', false)->get();

      $completedOrdersTakenByUser = Order::where('taker', $user->id)->where('completed', true)->get();


      return view('dashboard.index',
             compact('user', "ordersPostedByUser", "ordersDeliveriedByUser",
                     'weekly_order_count','weekly_order_spend',
                     'weekly_delivery_count'));

    }
}
