<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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

    public function privateChatBox() {
        return view('privateChatBox');
    }
}
