@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Order</h1>
        <form method="post" action="/orders/{{$order->id}}">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PUT">
            <input type="text" name="title" placeholder="Title" value="{{$order->title}}">
            {{csrf_field()}}
            <input type="submit" name="UPDATE">
        </form>
        <form method="post" action="/orders/{{$order->id}}">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="DELETE">
            {{csrf_field()}}
            <input type="submit" value="DELETE">
        </form>
    </div>
@endsection