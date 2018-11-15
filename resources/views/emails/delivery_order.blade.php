Hi {{$userName}},<br>
<br>
Your order <b>{{$orderTitle}}</b> has been delivered successfully by {{Auth::user()->name}}. <br>
Please click <a href="{{env('MAIN_PAGE_IP')}}">here</a> to view your order. <br>
<br>
Thanks,<br>
Skip-the-Cafe