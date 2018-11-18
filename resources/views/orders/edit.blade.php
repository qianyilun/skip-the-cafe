@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Order</h1>
        <form method="post" action="/orders/{{$order->id}}">

            {{csrf_field()}}

            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
                <input class="form-control" type="text" name="title" placeholder="Title">
            </div>
            <div class="form-group">
                <input class="form-control" type="text" name="item" placeholder="Item (e.g. a coffee)">
            </div>
            <div class="form-group">
                <textarea class="form-control" name="description" id="" rows="5"  placeholder="Order Description"></textarea>
            </div>
            <div class="form-group">
                <input class="form-control" type="textarea" name="address" placeholder="Address (Please be specific, e.g. SFU Burnaby campus library first floor)">
            </div>
            <div class="form-group">
                <input class="form-control" type="number" name="price" placeholder="Price" step="0.01">
            </div>

            <input type="hidden" id="hiddenLongitude" value="" name="longitude" />
            <input type="hidden" id="hiddenLatitude" value="" name="latitude" />

            {{csrf_field()}}
            <input class="btn btn-primary" type="submit" name="UPDATE">
        </form>

        <form method="post" action="/orders/{{$order->id}}">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="DELETE">
            {{csrf_field()}}
            <input type="submit" value="DELETE">
        </form>
    </div>
@endsection