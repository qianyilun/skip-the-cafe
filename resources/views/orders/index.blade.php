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

      <h3>Order Posted By You</h3>
      @if (count($ordersPostedByUser) > 0)
        <h5>All Orders you have posted</h5>
        <ul class="list-group list-group-flush">
            {{-- this is for displaying the orders that are created by the currently logged in user --}}
            @foreach($ordersPostedByUser as $order)
              @if ($order->owner === $user->name)
                <li class="list-group-item list-group-item-action">
                  <a href="{{route('orders.show', $order->id)}}">{{$order->title}}</a>
                  
                  <a href="{{url('comment/' . $order->id)}}"><button class="btn btn-success">Leave a comment for the taker</button></a>
                  
                </li>
              @endif
            @endforeach
        </ul>
      @else
        <h5>You currently have not placed any orders. Try to Create one.</h5>
      @endif

      {{--@if (count($completedOrdersPostByUser) > 0)--}}
        {{--<h5>Orders you have posted and is completed</h5>--}}
        {{--<ul class="list-group list-group-flush">--}}
          {{--@foreach($completedOrdersPostByUser as $order)--}}
              {{--<li class="list-group-item list-group-item-action">--}}
                {{--<a href="{{route('orders.show', $order->id)}}">{{$order->title}}</a>--}}
                {{--<a href="" class="btn btn-primary">Leave a review</a>--}}
              {{--</li>--}}
          {{--@endforeach--}}
        {{--</ul>--}}
      {{--@endif--}}

      {{--<hr style="border-top: 3px solid rgba(0,0,0,.1);">--}}

      {{--<h3>Order Taken By You</h3>--}}

      {{--@if (count($incompletedOrdersTakenByUser) > 0)--}}
        {{--<h5>Order taken by you and is in progress</h5>--}}
        {{--<ul class="list-group list-group-flush">--}}
          {{--@foreach($incompletedOrdersTakenByUser as $order)--}}
            {{--<li class="list-group-item list-group-item-action">--}}
              {{--<a href="{{route('orders.show', $order->id)}}">{{$order->title}}</a>--}}
              {{--<a href="" class="btn btn-primary">Complete</a>--}}
            {{--</li>--}}
          {{--@endforeach--}}
        {{--</ul>--}}
      {{--@endif--}}

      {{--@if (count($completedOrdersTakenByUser) > 0)--}}
        {{--<h5>Order Completed by you</h5>--}}
        {{--<ul class="list-group list-group-flush">--}}
          {{--@foreach($completedOrdersTakenByUser as $order)--}}
            {{--<li class="list-group-item list-group-item-action">--}}
              {{--<a href="{{route('orders.show', $order->id)}}">{{$order->title}}</a>--}}
            {{--</li>--}}
          {{--@endforeach--}}
        {{--</ul>--}}
      {{--@endif--}}

      @else
        <p>You need to login to view all orders you have submitted.</p>
    </div>
    @endif
    <div class="row">
        <!-- Large modal -->
      <button type="button" id="modalButton" style="display: none;" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Windows 8 modal - Click to View</button>

    <div id="{{Session::get('modal')}}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
          
            <div class="modal-body">
          
            <H2>Great news!</H2>
            <h4>Your order has been selected to be free a order. Share this news with your friends!</h4>
          
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
//   var freeOrNot = "{{session('modal')}}";
  var modal = $('.modal.fade.bs-example-modal-lg').attr('id');
  if(modal == 'hasModal') {
    $('#modalButton').click();
  }
});

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&callback=initMap"
type="text/javascript"></script>