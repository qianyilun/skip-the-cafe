<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class GroupChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('chats.chat');
    }

    /**
     * Fetch all users
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function users()
    {
        return User::all();
    }
}
