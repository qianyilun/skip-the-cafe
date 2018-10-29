@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Orders</h1>
        <h2>TODO: This Page should display all orders submitted by the current user</h2>
        <ul>
            @foreach($orders as $order)
                <li><a href="{{route('orders.show', $order->id)}}">{{$order->title}}</a></li>
                @endforeach
        </ul>
        <a href="{{route('orders.create')}}">New Order</a>
    </div>
@endsection