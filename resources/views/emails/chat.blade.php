Hi {{$userName}},<br>
<br>
<b>{{Auth::user()->name}}</b> has sent you a chat from order <b>{{$orderTitle}}</b>.<br>
Please click <a href="{{env('CHATBOX_PAGE_IP')}}">here</a> to view your chat message. <br>
<br>
Thanks,<br>
Skip-the-Cafe