@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>New Order</h1>
        <form method="post" action="/orders">
            <input type="text" name="title" placeholder="Title">
            {{csrf_field()}}
            <input type="submit" name="submit">
        </form>
    </div>
@endsection