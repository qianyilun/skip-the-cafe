@extends('layouts.app')
<style>
.modal  {
    /*   display: block;*/
    padding-right: 0px;
    background-color: rgba(4, 4, 4, 0.8); 
    }
   
    .modal-dialog {
            top: 20%;
                width: 100%;
    position: absolute;
        }
      .modal-content {
        border-radius: 0px;
        border: none;
        top: 40%;
    }
    .modal-body {
            background-color: #0f8845;
            color: white;
    }
               
</style>
@section('content')
{{-- Strictly for popup window --}}
<div class="content">
</div>


<div class="row">
  <div class="col-md-7">
    <div class="row">
      <div class="col-md-12">
        <div id="map" style="height:600px; width:100%;"></div>
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
      <h3>We Suggested Orders</h3>      
      <div class="alert alert-primary">
      Skip the cafe has already automatically filtered the orders that are nearby
      </div>
        @if (count($availableOrders) > 0)
          <ul class="list-group" id="listOfTakeButtons">
            @foreach($availableOrders as $availableOrder)
              <li class="list-group-item list-group-item-action">
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
                
      @else
        <p>You need to login to view all orders you have submitted.</p>
    </div>
    @endif
    <div class="row">
        <!-- Large modal -->
      <button type="button" id="modalButton" style="display: none;" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">w</button>

    <div id="{{Session::get('modal')}}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
          
            <div class="modal-body">
          
            <H2>Great news!</H2>
            <h4>Your order has been selected to be a free order. Share this news with your friends!</h4>
              <a href="sendShareEmail"><button class="btn btn-primary">Share this news</button></a>
            </div>
          </div>
        </div>
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
            location.href = `/showDirection/${orderId}`
          },
          error: function(msg) {
            alert('Fail to take the order');
            console.log('ajax call to takeOrder action in order controller error ', msg);
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
            location.href = `/showDirection/${orderId}`
          },
          error: function(msg) {
            alert('Fail to take the order');
            console.log('ajax call to takeOrder action in order controller error ', msg);
          }
      });
    });
});
// if this order is free order, display a pop up
$(document).ready(function() {
  var modal = $('.modal.fade.bs-example-modal-lg').attr('id');
  if(modal == 'hasModal') {
    $('#modalButton').click();
  }
});

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&callback=initMap"
type="text/javascript"></script>