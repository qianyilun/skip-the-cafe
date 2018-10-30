@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-6">
    <h3>All Orders</h3>
    <h4>TODO: This Page should display all orders submitted by the current user</h4>
    <ul>
        @foreach($orders as $order)
          <li>
            <a href="{{route('orders.show', $order->id)}}">{{$order->title}}</a>
          </li>
        @endforeach
    </ul>
    <a href="{{route('orders.create')}}"><button class="btn btn-primary"> New Order</button></a>
  </div>
  <div class="col-md-6">
    <h3>Orders you have posted</h3>
    <br>
    @if ($user !== null)
      <h3>You logged in as <span style="color: red;">{{$user->name}}</span></h3>  
      @if (count($orders) > 0)
        <ul>
            @foreach($orders as $order)
              <li>
                <a href="{{route('orders.show', $order->id)}}">{{$order->title}}</a>
              </li>
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