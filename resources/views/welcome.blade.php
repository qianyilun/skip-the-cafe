@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div style="text-align: left;" class="question">
                    Time is cheap?
                </div>
                <div class="title m-b-md">
                    Skip the Cafe
                </div>
                <div style="text-align: right;" class="slogan">
                    Switch "Delivery" | "Receiver" anytime, anywhere.
                </div>
            </div>
        </div>
    </div>
@endsection