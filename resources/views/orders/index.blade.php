@extends('layouts.app')

@section('content')
        <h1>All Orders</h1>
        <h2>TODO: This Page should display all orders submitted by the current user</h2>
        <ul>
            @foreach($orders as $order)
                <li><a href="{{route('orders.show', $order->id)}}">{{$order->title}}</a></li>
                @endforeach
        </ul>
        <a href="{{route('orders.create')}}"><button class="btn btn-primary"> New Order</button></a>
    
@endsection