@extends('layouts.app')

@section('content')

<h3>show direction page ID: {{$id}}</h3>
<h3>show direction page orderLongitude: {{$orderLongitude}}</h3>
<h3>show direction page orderLatitude: {{$orderLatitude}}</h3>
<h3>show direction page currentUserlongitude: {{$currentUserlongitude}}</h3>
<h3>show direction page currentUserlatitude: {{$currentUserlatitude}}</h3>
<button class="btn btn-primary">Complete order, notify the order owner</button>
<div id='map' style="height: 500px; width: 100%;"></div>
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
    var directionsRequest = 'https://api.mapbox.com/directions/v5/mapbox/walking/'+ currentUserlongitude + ',' + currentUserlatitude + ';' + orderLongitude + ',' + orderLatitude + '?geometries=geojson&access_token=' + accessToken;
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
      });
      
    });
  });
</script>