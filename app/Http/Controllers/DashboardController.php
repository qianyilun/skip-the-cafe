<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\User;

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


      $ordersPostedByUser = Order::where('owner', $user->name)->get();
      $completedOrdersPostByUser = Order::where('owner', $user->name)->where('completed', true)->get();

      $incompletedOrdersTakenByUser = Order::where('taker', $user->id)->where('completed', false)->get();

      $completedOrdersTakenByUser = Order::where('taker', $user->id)->where('completed', true)->get();


      return view('dashboard.index', compact('user', 'ordersPostedByUser', 'completedOrdersPostByUser', 'incompletedOrdersTakenByUser', 'completedOrdersTakenByUser', 'orders', 'currentUserlongitude', 'currentUserlatitude'));

    }
}
