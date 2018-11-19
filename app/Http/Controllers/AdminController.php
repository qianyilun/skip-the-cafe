<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function admin() {
        $orders = $this->getAllOrders();
        $users = $this->getAllUsers();

        return view('admin')->with(['orders' => $orders, 'users' => $users]);
    }

    public function testAdmin() {
        $orders = $this->getAllOrders();
        $users = $this->getAllUsers();

        // `run "User::where('email', 'youremail.com')->update(['type'=>'admin']);" in tinker to make a user administrator`
        return view('admin')->with(['orders' => $orders, 'users' => $users]);
    }

    private function getAllOrders() {
        $orders = Order::all();
        return $orders;
    }

    private function getAllUsers() {
        $users = User::all();
        return $users;
    }
}
