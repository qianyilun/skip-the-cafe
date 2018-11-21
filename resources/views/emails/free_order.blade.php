Hi {{ Auth::user()->name }},<br>
<br>
Congratulation! Your order is selected a free order during the two weeks period. <br>
Please click <a href="{{env('MAIN_PAGE_IP')}}">here</a> to view your order. <br>
Or, why not tell your friends? Share them a link to <a href="{{env('JOIN_US_PAGE_IP')}}">join us!</a>
<br>
Thanks,<br>
Skip-the-Cafe