@extends('layouts.app')

@section('content')
<div>
    <h1>New Order</h1>
    <div class="row">
      <div class="col-md-8">
        <form method="post" action="/orders">
          <div class="form-group">
            <label style="font-weight: bold;" class="control-label" for="email">Title</label>
            <input class="form-control" type="text" name="title" placeholder="An 'attractive' title gives your order higher chance to be taken">
          </div>
          <div class="form-group">
            <label style="font-weight: bold;" class="control-label" for="email">Item</label>
            <input class="form-control" type="text" name="item" id="inputItem" placeholder="(e.g. a coffee)">
            <div id="autocompleteItem"></div>
          </div>
          <div class="form-group">
              <label style="font-weight: bold;" class="control-label" for="email">Detail description of your order</label>
              <textarea  class="form-control" name="description" id="" rows="5"  placeholder="Order Description: more cream on the coffee...etc"></textarea>
          </div>
          <div class="form-group">
              <label style="font-weight: bold;" class="control-label" for="email">Your location</label>
              <input class="form-control" type="textarea" name="address" placeholder="(Please be specific, e.g. SFU Burnaby campus library first floor)">
          </div>
          <div class="form-group">
              <label style="font-weight: bold;" class="control-label" for="email">Price</label>
              <input class="form-control" type="number" name="price" placeholder="Up to 2 decimals." step="0.01">
              <small id="passwordHelpBlock" class="form-text text-muted">
                  Price should include the <b>price you pay to the taker</b> and cost of the items.
              </small>
          </div>
          <input type="hidden" id="hiddenLongitude" value="" name="longitude" />
          <input type="hidden" id="hiddenLatitude" value="" name="latitude" />
          {{csrf_field()}}
          <input class="btn btn-primary" type="submit" name="submit">
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

  $(document).ready(function(){

  $('#inputItem').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
        var _token = $('input[name="_token"]').val();
        $.ajax({
          url:"{{ route('autocomplete.fetch') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
            $('#autocompleteItem').fadeIn();  
                      $('#autocompleteItem').empty().append(data['html']);
          }

        });
        }
    });

    $(document).on('click', 'li', function(){  
        $('#inputItem').val($(this).text());  
        $('#autocompleteItem').fadeOut();  
    });  

  });

  

// stage 2: after getting the user's geo location, signal the backend to re-order the available orders list.
</script>
