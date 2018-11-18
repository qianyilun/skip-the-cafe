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

<script
        src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
        crossorigin="anonymous">
</script>
<script>
    // the following is for the ggoogle map section of our app
    // stage 1: get user's current location, then when user create a new order, the address can be filled in automatically
    $(document).ready(function(){
        // first, get the current client's ip
        var userIp = null;
        var access_key = 'a7d887b9bdaae171366d6b2b284ffa4c';
        $.get("http://ipinfo.io", function(response) {
            userIp = response.ip;
            console.log('ipinfo return s',userIp);
            $.ajax({
                url: 'http://api.ipstack.com/' + userIp + '?access_key=' + access_key,
                dataType: 'jsonp',
                success: function(json) {
                    let longitude = json.longitude;
                    let latitude = json.latitude;
                    $('#hiddenLongitude').val(longitude);
                    $('#hiddenLatitude').val(latitude);
                }
            });
        }, "jsonp");
    });

    // get the API result via jQuery.ajax


    // stage 2: after getting the user's geo location, signal the backend to re-order the available orders list.
</script>
