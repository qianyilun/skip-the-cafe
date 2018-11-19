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
        return redirect('/')->with('error', 'You need to login in order to view/create order.'); 
      }

      $user = null;
      if(auth()->user() !== null) {
        $user = auth()->user();
      }

      $completedOrdersPostByUser = Order::where('owner', $user->name)->where('completed', true)->get();
      $completedOrdersTakenByUser = Order::where('taker', $user->id)->where('completed', true)->get();

      return view('profile.index', compact('user', 'completedOrdersPostByUser','completedOrdersTakenByUser'));

    }
}
