@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-8">
        <h2>TODO: Here we should be able to display an single order</h2>
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

                <dt class="col-sm-3">Price</dt>
                <dd class="col-sm-9">{{$order->price}}</dd>
            </dl>
        <a class="btn btn-primary btn-block" href="{{route('orders.edit', $order->id)}}">Edit</a>
        </div>
    </div>
@endsection