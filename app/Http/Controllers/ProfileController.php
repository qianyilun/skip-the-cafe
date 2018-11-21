<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\User;

class ProfileController extends Controller
{
    public function index()
    {
      if(auth()->user() === null) {
        return redirect('/')->with('error', 'You need to login first.'); 
      }

      $user = null;
      if(auth()->user() !== null) {
        $user = auth()->user();
      }

      $ordersPostedByUser = Order::where('owner', $user->name)->orderBy('created_at', 'desc')->get();
      $completedOrdersPostByUser = Order::where('owner', $user->name)->where('completed', true)->get();
      
      $OrdersTakenByUser = Order::where('taker', $user->id)->get();
      $completedOrdersTakenByUser = Order::where('taker', $user->id)->where('completed', true)->get();

      $total_rating = 0.0;
      $total_rating_count = 0;
      foreach ($OrdersTakenByUser as $order){
        if($order->rating > 0){
          $total_rating += $order->rating;
          $total_rating_count += 1;
        }
      }

      if ($total_rating_count == 0) {
        $average_rating = 0;
      } else {
        $average_rating = $total_rating/$total_rating_count;
      }
      
      return view('profile.index', compact('user', 'ordersPostedByUser','completedOrdersPostByUser',
                  'OrdersTakenByUser', 'completedOrdersTakenByUser','average_rating'));

    }
}
