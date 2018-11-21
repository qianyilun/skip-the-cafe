@extends('layouts.app')

@section('content')
<h2>All Orders</h2>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        @foreach ($uncompletedOrdersPostByUser as $order)
        <div class="card">    
            <div class="card-header">
                <div class="d-flex w-100 justify-content-between">
                    <h4 class="mb-1">
                        <a href="{{route('orders.show', $order->id)}}">{{$order->title}}</a>
                    </h4>
                    <h6>
                        @if ($order->completed == 0)
                        <span class="badge badge-pill badge-info">Not Dleivery yet</span>
                        @endif 
                        @if ($order->taker == NULL)
                            <span class="badge badge-pill badge-info">No taker</span>
                        @endif
                        {{$order->created_at}}
                    </h6>
                </div>
            </div>

            <div class="card-body">
                <div class="d-flex w-150 justify-content-between">
                    <p class="mb-1">Description: {{$order->description}}</p>
                    <h5>${{$order->price}}</h5>
                </div>
            </div>
        </div>
        <br>
        @endforeach
    </div>
    <div class="col-md-1"></div>
</div>
@endsection