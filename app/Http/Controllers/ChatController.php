<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ChatController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function private()
    {
        return view('chats.private');
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
