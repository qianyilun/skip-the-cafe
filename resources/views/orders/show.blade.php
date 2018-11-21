@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-8">
        <h2>Order Details</h2>
        <br>
            <dl class="row">
                <dt class="col-sm-3">Title</dt>
                <dd class="col-sm-9">{{$order->title}}</dd>

                <dt class="col-sm-3">Item</dt>
                <dd class="col-sm-9">{{$order->item}}</dd>

                <dt class="col-sm-3">Description</dt>
                <dd class="col-sm-9">{{$order->description}}</dd>

                <dt class="col-sm-3">Address</dt>
                <dd class="col-sm-9">{{$order->address}}</dd>

                <dt class="col-sm-3">longitude</dt>
                <dd class="col-sm-9">{{$order->longitude}}</dd>

                <dt class="col-sm-3">Latitude</dt>
                <dd class="col-sm-9">{{$order->latitude}}</dd>

                <dt class="col-sm-3">Price</dt>
                <dd class="col-sm-9">{{$order->price}}</dd>

                <dt class="col-sm-3">taker</dt>
                <dd class="col-sm-9">{{$order->taker}}</dd>

                @if ($isAdmin)
                    <dt class="col-sm-3">Confirmed</dt>
                    <dd class="col-sm-9">{{$order->confirmed}}</dd>

                    <dt class="col-sm-3">Completed</dt>
                    <dd class="col-sm-9">{{$order->completed}}</dd>

                @endif
            </dl>
            @if ($isAdmin || $isOrderCreator)
            <a class="btn btn-primary btn-block" href="{{route('orders.edit', $order->id)}}">Edit</a>
            @endif
            @if ($isOrderCreator)
                <a class="btn btn-primary btn-block" href="{{route('chatWithAdmin')}}">Chat with Customer Service</a>
            @endif
        </div>
    </div>
@endsection