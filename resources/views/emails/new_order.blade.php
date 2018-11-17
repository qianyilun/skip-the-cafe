Hi {{ Auth::user()->name }},<br>
<br>
Your order <b>{{$orderTitle}}</b> has been successfully posted. <br>
Please click <a href="{{env('MAIN_PAGE_IP')}}">here</a> to view your order. <br>
<br>
Thanks,<br>
Skip-the-Cafe