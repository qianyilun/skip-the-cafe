@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="row">
      <div class="col-md-12">
        Area reserved for google map api
        <br>
        <br>
        <br>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
          
          <a href="{{route('orders.create')}}">
            <button class="btn btn-primary btn-block"> New Order</button>
          </a>
      </div>
    </div>
    
  </div>
  <div class="col-md-4">
    @if ($user !== null)
      <h3>All available orders</h3>
          <h6>TODO: This Page should display all orders submitted by the current user</h6>
          <ul>
              @foreach($orders as $order)
                <li>
                  <a href="{{route('orders.show', $order->id)}}">{{$order->title}}</a>
                <span>Order owner: {{$order->owner}}</span>
                </li>
              @endforeach
          </ul>
      <hr style="border-top: 3px solid rgba(0,0,0,.1);">  
      <h3>Orders you have posted</h3>
      @if (count($orders) > 0)
        <ul>
            @foreach($orders as $order)
              @if ($order->owner === $user->name)
                <li>
                  <a href="{{route('orders.show', $order->id)}}">{{$order->title}}</a>
                </li>
              @endif
            @endforeach
        </ul>
      @else
        <h4>You currently have not placed any orders. Try to Create one.
        </h4>
      @endif
      @else
        <p>You need to login to view all orders you have submitted.</p>
    </div>
    @endif
</div>
    
@endsection