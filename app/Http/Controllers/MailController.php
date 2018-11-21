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
     * Send confirmation email after a new order is created
     *
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
     * Send email to notify order owner his order has been taken by taker
     *
     * @param $ownerId
     * @param $orderTitle
     */
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

    /**
     * Send email to notify owner his order has been completed
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

        try {
          DB::table('orders')->where('id', $id)->update(['completed' => true]);
        } catch (\Illuminate\Database\QueryException $e) {
            throw $e;
        }

        Mail::send('emails.delivery_order', $data, function($message) use ($sendTo, $userName, $takerName){
            $message->to($sendTo, $userName)->subject("You order has been delivered by $takerName");
        });

        try {
          // add the money that taker makes from finishing this order
          $user = User::where('id', $order->taker)->first();
          $remainWallet = $user->wallet + $order->price;
          
          $user->wallet = $remainWallet;
          $user->save();
        } catch (\Illuminate\Database\QueryException $e) {
          throw $e;
        }

        return redirect('/profile');
    }

    /**
     * Send email to order owner that his has unread message
     *
     * @param $id
     */
    public function sendEmailToRemindUserChatMessage($id) {
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

        try {
            DB::table('orders')->where('id', $id)->update(['completed' => true]);
        } catch (\Illuminate\Database\QueryException $e) {
            throw $e;
        }

        Mail::send('emails.chat', $data, function($message) use ($sendTo, $userName, $takerName){
            $message->to($sendTo, $userName)->subject("You order has been delivered by $takerName");
        });

        return ;
    }

    /**
     * Send email to order owner that his has unread message
     *
     * @param $id
     */
    public function sendEmailToShareFreeOrder() {
        $data = [
            'userName' => '',
            'orderTitle' => '',
        ];

        Mail::send('emails.chat', $data, function($message) {
            $message->to()->subject("You order is free!");
        });

        return ;
    }
}
