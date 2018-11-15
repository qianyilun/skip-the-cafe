@extends('layouts.app')
<style>
  #overlay {
    position: absolute;
    width: 100%;
    height: 450px;
    background: black;
    opacity: .8;
    top: 0;
    left: 0;
    overflow: auto;
}
#overlayContent {
    color: white;
    padding: 10px 20px;
}
</style>

@section('content')
<h3>Order ID: {{$id}}</h3>
<h3>Order owner's name: {{$orderOwner}}</h3>
<h3>Ordered item: {{$orderItem}}</h3>
<h3>Address: {{$orderAddress}}</h3>
<h3 id="arriveTime">Estimated arriving time:</h3>
<a href="{{route('notifyOwner', ['id' => $id])}}">
  <button class="btn btn-primary">Complete order, notify the order owner</button>
</a>
<div class="row">
  <div class="col-md-3">
    <div id="overlay">
        <div id="overlayContent">
          <div id='instructions'></div>
        </div>
    </div>
  </div>

  <div class="col-md-9">
    <div id='map' style="height: 500px; width: 100%;"></div>
  </div>
</div>

@endsection
<script
  src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  crossorigin="anonymous">
</script>
<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.51.0/mapbox-gl.css' rel='stylesheet' />
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.51.0/mapbox-gl.js'></script>
<script>
  $(document).ready(function() {

    var orderLongitude = {{$orderLongitude}};
    var orderLatitude = {{$orderLatitude}};
    var currentUserlongitude = {{$currentUserlongitude}};
    var currentUserlatitude = {{$currentUserlatitude}};
    const accessToken = 'pk.eyJ1Ijoia2Vsdmlua2tsIiwiYSI6ImNqb2RhemVvbTB3Mmoza24yMHFlamc4ZG4ifQ.9YopsiI9D9r2PSKjb7nhgQ';
    var directionsRequest = 'https://api.mapbox.com/directions/v5/mapbox/walking/'+ currentUserlongitude + ',' + currentUserlatitude + ';' + orderLongitude + ',' + orderLatitude + '?steps=true&geometries=geojson&access_token=' + accessToken;
    var start = [currentUserlongitude, currentUserlatitude]; // for the marker to be placed on the map
    var end = [orderLongitude, orderLatitude]; // for the marker to be placed on the map
    
    mapboxgl.accessToken = accessToken;
    var map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/streets-v10',
      center: [orderLongitude, orderLatitude],
      zoom: 12
    });
    // load the map and place startting point and ending point as markers on the map
    map.on('load', function() {
      $.ajax({
        method: 'GET',
        url: directionsRequest,
      }).done(function(data) {
        var route = data.routes[0].geometry;
        map.addLayer({
          id: 'route',
          type: 'line',
          source: {
            type: 'geojson',
            data: {
              type: 'Feature',
              geometry: route
            }
          },
          paint: {
            'line-width': 2
          }
        });
        
        map.addLayer({
          id: 'start',
          type: 'circle',
          source: {
            type: 'geojson',
            data: {
              type: 'Feature',
              geometry: {
                type: 'Point',
                coordinates: start
              }
            }
          }
        });
        map.addLayer({
          id: 'end',
          type: 'circle',
          source: {
            type: 'geojson',
            data: {
              type: 'Feature',
              geometry: {
                type: 'Point',
                coordinates: end
              }
            }
          }
        });
        // added slightly modified version of routes instructions
        var instructions = document.getElementById('instructions');
        var steps = data.routes[0].legs[0].steps;
        var counter = 0;
        steps.forEach(function(step) {
          instructions.insertAdjacentHTML('beforeend', '<p>' + counter + '. ' + step.maneuver.instruction + '</p>');
          counter++;
        });
        // display Estimated arrival time
        var arriveTimeNode = document.getElementById('arriveTime');
        var arriveTimeInSec = data.routes[0].legs[0].duration;
        var arriveTimeInMinutes = Math.floor(arriveTimeInSec / 60);
        arriveTimeNode.insertAdjacentHTML('beforeend', '<span> '+ arriveTimeInMinutes +'minutes</span>');
      });
      
    });

    
  });
</script>