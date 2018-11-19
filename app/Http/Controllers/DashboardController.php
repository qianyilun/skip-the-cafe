<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

      return view('dashboard.index', compact('user'));

    }
}
