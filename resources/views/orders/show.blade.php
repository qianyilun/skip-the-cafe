@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>TODO: Here we should be able to display an single order</h2>
        <br>
        <h3><a href="{{route('orders.edit', $order->id)}}">{{$order->title}}</a></h3>
    </div>
@endsection