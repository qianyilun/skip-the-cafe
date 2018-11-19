<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
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

      return view('dashboard.index', compact('user'));

    }
}
