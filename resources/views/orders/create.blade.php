@extends('layouts.app')

@section('content')
<div>
    <h1>New Order</h1>
    <div class="row">
      <div class="col-md-6">
        <form method="post" action="/orders">
          <div class="form-group">
            <input type="text" name="title" placeholder="Title">
          </div>
          <div class="form-group">
            <input type="text" name="item" placeholder="item">
          </div>
          <textarea class="form-control" name="description" id="" cols="30" rows="10"  placeholder="description"></textarea>
          <div class="form-group">
              <input type="textarea" name="address" placeholder="address(be specific)">
          </div>
          <div class="form-group">
              <input type="number" name="price" placeholder="price" step="0.01">
          </div>
          <input type="hidden" id="hiddenLongitude" value="" name="longitude" />
          <input type="hidden" id="hiddenLatitude" value="" name="latitude" />
          {{csrf_field()}}
          <input type="submit" name="submit">
        </form>
      </div>
    </div>
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
          // output the "capital" object inside "location"
          console.log('longitude', json.longitude);
          console.log('latitude', json.latitude);
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
