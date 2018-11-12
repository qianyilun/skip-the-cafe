@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div style="text-align: left;" class="question">
                    Time is cheap?
                </div>
                <div class="title m-b-md">
                    Skip the Cafe
                </div>
                <div class="slogan">
                    <p>Switch "Delivery" | "Receiver" anytime, anywhere.</p>
                </div>
                <div>
                    <br>
                    <a class="btn btn-primary btn-lg btn-block" href="{{route('orders.index')}}">View All Orders</a>
                    <br>
                    <a class="btn btn-primary btn-lg btn-block" href="{{route('orders.create')}}">New Order</a>
                </div>
            </div>
        </div>
    </div>
@endsection