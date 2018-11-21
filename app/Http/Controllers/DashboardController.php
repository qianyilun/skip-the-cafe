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
        $delivery_count= count(Order::whereDate('created_at', $day)->where('taker', $user->id)->get());
        $weekly_delivery_count[6-$i] = $delivery_count;
      };

      $weekly_delivery_earn = [0,1,2,3,4,5,6];
      foreach ($weekly_delivery_earn as $i){
        $day = Carbon::now()->subDays($i);
        $order = Order::whereDate('created_at', $day)->where('taker', $user->id)->get();
        $order_earn= $order->sum('price');
        $weekly_delivery_earn[6-$i] = $order_earn;
      };

      $stores=["Starbuck", "Tim Hortons", "Waves Coffe", "Renaissance", "Other"];

      $weekly_store_count = [0,0,0,0,0];
      for($i=0; $i<7; $i++){
        $day = Carbon::now()->subDays($i);
        $orders = Order::whereDate('created_at', $day)->where('owner', $user->name)->get();
        
        foreach ($orders as $key => $order) {
          $flag=true;
          for($j=0; $j<4; $j++){
            if ( strpos( strtolower($order->item), strtolower($stores[$j]) ) !== false) {
              $weekly_store_count[$j] += 1;
              $flag=false;
            }
          }
          if ($flag){
            $weekly_store_count[4] += 1;
            $flag=true;
          }
        }
      };


      $ordersPostedByUser = Order::where('owner', $user->name)->get();
      $ordersDeliveriedByUser = Order::where('taker', $user->id)->get();


      $completedOrdersPostByUser = Order::where('owner', $user->name)->where('completed', true)->get();

      $incompletedOrdersTakenByUser = Order::where('taker', $user->id)->where('completed', false)->get();

      $completedOrdersTakenByUser = Order::where('taker', $user->id)->where('completed', true)->get();


      return view('dashboard.index',
             compact('user', "ordersPostedByUser", "ordersDeliveriedByUser",
                     'weekly_order_count','weekly_order_spend',
                     'weekly_delivery_count','weekly_delivery_earn',
                     'weekly_store_count'));

    }
}
