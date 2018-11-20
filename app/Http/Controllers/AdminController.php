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
        $currentUser = auth()->user();
        $orders = $this->getAllOrders();
        $users = $this->getAllUsers();

        return view('admin.admin', compact('orders', 'users', 'currentUser'));
    }

    public function testAdmin() {
        $currentUser = auth()->user();
        $orders = $this->getAllOrders();
        $users = $this->getAllUsers();

        return view('admin.admin', compact('orders', 'users', 'currentUser'));
    }

    private function getAllOrders() {
        $orders = Order::all();
        return $orders;
    }

    private function getAllUsers() {
        $users = User::all();
        return $users;
    }

    public function grantAdmin($id) {
        $user = User::findOrFail($id);
        $user->type = 'admin';
        $user->save();

        return redirect('/admin');
    }

    public function editUser($id) {
        $user = User::findOrFail($id);

        return view('admin.edituser', compact('user'));
    }
}
