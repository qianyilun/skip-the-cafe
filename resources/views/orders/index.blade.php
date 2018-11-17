@extends('layouts.app')

@section('content')
{{-- Strictly for popup window --}}

<div id="modal-container">
  <div class="modal-background">
    <div class="modal">
      <h2>I'm a Modal</h2>
      <p>Hear me roar.</p>
      <svg class="modal-svg" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="none">
								<rect x="0" y="0" fill="none" width="226" height="162" rx="3" ry="3"></rect>
							</svg>
    </div>
  </div>
</div>
<div class="content">
  <h1>Modal Animations</h1>
  <div class="buttons">
    <div id="one" class="button">Unfolding</div>
    <div id="two" class="button">Revealing</div>
    <div id="three" class="button">Uncovering</div>
    <div id="four" class="button">Blow Up</div><br>
    <div id="five" class="button">Meep Meep</div>
    <div id="six" class="button">Sketch</div>
    <div id="seven" class="button">Bond</div>
  </div>
</div>


<div class="row">
  <div class="col-md-7">
    <div class="row">
      <div class="col-md-12">
        <div id="map" style="height:300px; width:100%;"></div>
        <br>
        <br>
        <br>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
          <a href="{{route('orders.create')}}">
            <button class="btn btn-primary btn-lg btn-block"> New Order</button>
          </a>
      </div>
    </div>
    
  </div>
  <div class="col-md-5">
    @if ($user !== null)
      <h3>All available orders</h3>
        {{-- <h6>TODO: This Page should display all orders submitted by the current user</h6> --}}
        @if (count($availableOrders) > 0)
          <ul class="list-group list-group-flush" id="listOfTakeButtons">
            @foreach($availableOrders as $availableOrder)
              <li class="list-group-item list-group-item-action">
                {{-- <a href="{{route('orders.show', $order->id)}}">{{$order->title}}</a>
                <span>Order owner: {{$order->owner}}</span>
                @if ($order->owner !== $user->name)
                <a href="" class="btn btn-default">
                <button class="btn btn-primary" id="{{$order->id}}">Take</button>
                </a>
                @endif --}}
                <span>Order title: <b>{{$availableOrder->title}}</b> </span><br>
                <span>Order item: <b>{{$availableOrder->item}}</b> </span><br>
                <span>Address: <b>{{$availableOrder->address}}</b> </span><br>
                <span>Order owner: <b>{{$availableOrder->owner}}</b> </span>
                <a class="btn btn-default">
                  <button class="btn btn-primary" id="{{$availableOrder->id}}">Take</button>
                </a>
              </li>
            @endforeach
          </ul>
        @else
        <h5>You are late~ No available order.</h5>
        @endif
          
      <hr style="border-top: 3px solid rgba(0,0,0,.1);">  
      <h3>Orders you have posted</h3>
      @if (count($ordersFromCurrentUsers) > 0)
        <ul class="list-group list-group-flush">
            {{-- this is for displaying the orders that are created by the currently logged in user --}}
            @foreach($ordersFromCurrentUsers as $ordersFromCurrentUser)
              @if ($ordersFromCurrentUser->owner === $user->name)
                <li class="list-group-item list-group-item-action">
                  <a href="{{route('orders.show', $ordersFromCurrentUser->id)}}">{{$ordersFromCurrentUser->title}}</a>
                </li>
              @endif
            @endforeach
        </ul>
      @else
        <h4>You currently have not placed any orders. Try to Create one.
        </h4>
      @endif
      @else
        <p>You need to login to view all orders you have submitted.</p>
    </div>
    @endif
</div>

<div class="row" style="width: 100%; margin-top: 30px;">
  <div class="col-md-12">
    <table style="width: 100%;">
      <h4>The following table is solely for debugging purpose.</h4>
      <h4>When we do final demo, this table will be removed.</h4>
      <tr>
        <th>order id</th>
        <th>title</th>
        <th>item</th>
        <th>owner</th>
        <th>taker</th>
        <th>latitude</th>
        <th>longtitude</th>
      </tr>
      @foreach ($orders as $order)
      <tr>
        <td style="margin-right: 5px;">{{$order->id}}</td>
        <td>{{$order->title}}</td>
        <td style="margin-right: 5px;">{{$order->item}}</td>
        <td style="margin-right: 5px;">{{$order->owner}}</td>
        <td style="margin-right: 5px;">{{$order->taker}}</td>
        <td style="margin-right: 5px;">{{$order->latitude}}</td>
        <td style="margin-right: 5px;">{{$order->longitude}}</td>
      </tr>
      @endforeach
    </table>
  </div>
</div>

@endsection
<script
  src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  crossorigin="anonymous">
</script>

<script>
  function myFunction(orderId) {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
          type: 'post',
          url: `orders/take/${orderId}`,
          success: function(msg) {
            console.log(msg);
            location.href = `/showDirection/${orderId}`
          },
          error: function(msg) {
            alert('Fail to take the order');
            console.log('ajax call to takeOrder action in order controller error ', msg);
            // window.location.reload(true);
          }
      });
  }
  function initMap() {
    var options = {
      zoom: 13,
      center: {
        lat: {{$currentUserlatitude}},
        lng: {{$currentUserlongitude}}
      }
    };
    var map = new google.maps.Map(document.getElementById('map'), options);
    var markers = [];
    @foreach ($availableOrders as $order)
      @if ($order->taker == null && $order->owner != $user->name)
        markers.push({
          coords: {lat: {{$order->latitude}},lng: {{$order->longitude}}},
          iconImage: 'http://maps.google.com/mapfiles/ms/micons/dollar.png',
          content: '<p>Title: {{$order->title}}</p> <p>Item: {{$order->item}}</p> <p>Price: ${{$order->price}}</p><button onclick="myFunction({{$order->id}})" class="btn btn-primary" id="{{$order->id}}">take this order</button>'
        })
      @endif
    @endforeach
    
    for(var i = 0; i<markers.length; i++) {
      addMarker(markers[i]);
    }

    function addMarker(props) {
      var marker = new google.maps.Marker({
        position: props.coords,
        map: map,
        icon: props.iconImage
      });
      if(props.iconImage){
        // Set marker icon image
        marker.setIcon(props.iconImage);
      }
      if(props.content){
        var infoWindow = new google.maps.InfoWindow({
          content:props.content
        });

        marker.addListener('click', function(){
          infoWindow.open(map, marker);
        });
      }
    }

  
  }
  $(document).ready(function(){
    $("#listOfTakeButtons button").click(function(e){
      e.preventDefault(); 
      let orderId = this.id; // first, get the id of the order, which is wriiten as ID of the button element
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
          type: 'post',
          url: `orders/take/${orderId}`,
          success: function(msg) {
            console.log(msg);
            location.href = `/showDirection/${orderId}`
          },
          error: function(msg) {
            alert('Fail to take the order');
            console.log('ajax call to takeOrder action in order controller error ', msg);
            // window.location.reload(true);
          }
      });
    });
    
});

//The following code is for bringing up the popup window when a free order is given
@if(session()->has('modal'))
  alert('has modal');
@endif
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&callback=initMap"
type="text/javascript"></script>