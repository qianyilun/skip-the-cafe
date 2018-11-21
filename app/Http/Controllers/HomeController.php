<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        return view('home')->with(['user' => $user]);
    }

    /**
     * Find a specific users information based on userId
     *
     * @param $id
     * @return array
     */

    public function users($id)
    {
        $result = array();
        $result[] = User::find($id);
        return $result;
    }

    /**
     * Fetch all users
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function allUsers()
    {
        return User::all();
    }

    /**
     * Route for private chat box
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function privateChatBox() {
        return view('chats.privateChatBox');
    }

    /**
     * Find Admin
     *
     * @return array
     */
    public function findAdmin()
    {
        $result = array();
        $admin = DB::table('users')->where('type', 'admin')->where('name', 'admin')->first();
        $result[] = $admin;
        return $result;
    }

    /**
     * Route for chat with admin
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function chatWithAdmin() {
        return view('chats.chatWithAdmin');
    }
}
