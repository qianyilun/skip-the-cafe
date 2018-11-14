<?php

namespace App\Http\Controllers;

use App\MyMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Order;

class MailController extends Controller
{
    /**
     * @param $orderTitle
     */

    public function sendEmailWhenCreateNewOrder($orderTitle) {
        $userId = auth()->user()->id;
        $user = DB::table('users')->where('id', "$userId")->first();

        $sendTo = $user->email;
        $userName = $user->name;
        $data = [
            'orderTitle' => $orderTitle
        ];

        Mail::send('emails.new_order', $data, function($message) use ($sendTo, $userName){
            $message->to($sendTo, $userName)->subject('You order is posted successfully');
        });
    }

    /**
     * A sample function for sending a hardcode email when necessary
     */
    public function send() {
        $data = [
           'title' => 'Order submitted and posted',
           'content' => 'This is content'
        ];
        Mail::send('emails.test', $data, function($message) {
            $message->to('qianyiluntemp@gmail.com', 'yilun qian TEST')->subject('hey tester');
        });
    }

    public function sendEmailToNotifyOrderOwner($ownerId, $orderTitle) {
        $owner = DB::table('users')->where('id', "$ownerId")->first();
        $takerName = auth()->user()->name;

        $sendTo = $owner->email;
        $userName = $owner->name;
        $data = [
            'userName' => $userName,
            'orderTitle' => $orderTitle,
        ];

        Mail::send('emails.take_order', $data, function($message) use ($sendTo, $userName, $takerName){
            $message->to($sendTo, $userName)->subject("You order has been taken by $takerName");
        });
    }

    public function sendEmailToNotifyOwnerOrderCompleted($id) {
        $order = Order::findOrFail($id);

        $owner = DB::table('users')->where('id', "$order->user_id")->first();
        $takerName = auth()->user()->name;
        $orderTitle = $order->title;
        $sendTo = $owner->email;
        $userName = $owner->name;
        $data = [
            'userName' => $userName,
            'orderTitle' => $orderTitle,
        ];

        Mail::send('emails.delivery_order', $data, function($message) use ($sendTo, $userName, $takerName){
            $message->to($sendTo, $userName)->subject("You order has been delivered by $takerName");
        });

        return redirect('/orders');
    }
}
