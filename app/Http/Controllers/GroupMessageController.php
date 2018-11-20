<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use App\GroupMessage;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Events\PrivateMessageSent;

class GroupMessageController extends Controller
{
    /**
     * MessageController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Fetch all messages from database
     *
     * @return Message[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function fetchMessages()
    {
        return GroupMessage::with('user')->get();
    }

    /**
     * Send group messages and record to database
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function sendMessage(Request $request)
    {
        $message=auth()->user()->messages()->create(['message'=>$request->message]);

        broadcast(new MessageSent(auth()->user(),$message->load('user')))->toOthers();

        return response(['status'=>'Message sent successfully','message'=>$message]);

    }
}
