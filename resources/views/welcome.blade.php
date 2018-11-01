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
                <div style="text-align: right;" class="slogan">
                    Switch "Delivery" | "Receiver" anytime, anywhere.
                    <br>
                    <a href="{{route('orders.index')}}">View All Orders</a>
                    <br>
                    <a href="{{route('orders.create')}}">New Order</a>
                </div>
            </div>
        </div>
    </div>
@endsection