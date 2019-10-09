<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCnjlDXASsyIUKAd1QANakIHIM8jjWWyNU&callback=initMap" async defer></script> -->

<!-- <script type="text/javascript">
	var directionsDisplay;
	var directionsService;

	function initMap() {
		directionsService = new google.maps.DirectionsService();
		directionsDisplay = new google.maps.DirectionsRenderer();
		var myLatlng = new google.maps.LatLng(<?php echo $lokasi->lat; ?>,<?php echo $lokasi->lng; ?>);
		var mapOptions = {
			zoom: 13,
			center: myLatlng
		};

		var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
		directionsDisplay.setMap(map);

		var marker = new google.maps.Marker({
			position: myLatlng,
			title:"Hello World!"
		});

		var infoWindow = new google.maps.InfoWindow({map: map});

		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				var pos = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
				};

				infoWindow.setPosition(pos);
				infoWindow.setContent('Kamu Di sini');

				calculateAndDisplayRoute(directionsService, directionsDisplay, infoWindow.position, marker.position);
			}, function() {
				handleLocationError(true, infoWindow, map.getCenter());

				calculateAndDisplayRoute(directionsService, directionsDisplay, infoWindow.position, marker.position);
			});
		} else {
			handleLocationError(false, infoWindow, map.getCenter());
		}

		function handleLocationError(browserHasGeolocation, infoWindow, pos) {
		infoWindow.setPosition(pos);
		infoWindow.setContent(browserHasGeolocation ?
								'Error: The Geolocation service failed.' :
								'Error: Your browser doesn\'t support geolocation.');
		}
	}

	function calculateAndDisplayRoute(directionsService, directionsDisplay, infoWindow, marker) {
		directionsService.route({
			origin: infoWindow,
			destination: marker,
			avoidTolls: true,
			avoidHighways: false,
			travelMode: google.maps.TravelMode.DRIVING
		}, function (response, status) {
			console.log("AAA");
			if (status == google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(response);
			} else {
				window.alert('Directions request failed due to ' + status);
			}
		});

		directionsDisplay.setPanel(document.getElementById('directions-panel'));

		var trafficLayer = new google.maps.TrafficLayer();
		trafficLayer.setMap(map);
	}
</script> -->
<!-- <div class="row">
	<div class="col-md-6">
		<div class="panel panel-info panel-dashboard">
			<div class="panel-heading centered">
				<h2 class="panel-title"><strong> - Lokasi - </strong></h4>
			</div>
			<div class="panel-body">
				<div id="map-canvas" style="width:100%;height:500px;"></div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-info panel-dashboard">
			<div class="panel-heading centered">
				<h2 class="panel-title"><strong> - Rute - </strong></h4>
			</div>
			<div class="panel-body">
				<div id ="directions-panel" style ="width:100%;"></div>
			</div>
		</div>
	</div>
</div> -->
<!-- <script src="https://d3js.org/d3.v3.min.js"></script>
<script src="https://d3js.org/topojson.v0.min.js"></script> -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
<link rel="stylesheet" href="<?= base_url(); ?>/node_modules/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/perliedman-leaflet-control-geocoder/1.5.5/Control.Geocoder.min.css" />
<script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
<script src="<?= base_url(); ?>/node_modules/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/perliedman-leaflet-control-geocoder/1.5.5/Control.Geocoder.min.js"></script>
<div style="height: 400px;" id="mapid">
</div>
<script>
	var mymap = L.map('mapid').setView([<?= $this->session->userdata('lokasi'); ?>], 13);
	console.log(mymap);
	L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(mymap);
	var control = L.Routing.control({
	waypoints: [
		// L.LatLng(location.coords.latitude, location.coords.longitude),
		L.latLng(<?= $this->session->userdata('lokasi'); ?>),
		L.latLng(<?php echo $lokasi->lat; ?>,<?php echo $lokasi->lng; ?>)
	],
	router: new L.Routing.osrmv1({
		language: 'en',
		profile: 'car'
	}),
	geocoder: L.Control.Geocoder.nominatim({})
	}).addTo(mymap);
</script>
<!-- <script>
	navigator.geolocation.getCurrentPosition(function(location) {
		var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);

		var mymap = L.map('mapid').setView(latlng, 13)
		L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
			attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://mapbox.com">Mapbox</a>',
			maxZoom: 18,
			id: 'mapbox.streets',
			accessToken: 'pk.eyJ1IjoiYmJyb29rMTU0IiwiYSI6ImNpcXN3dnJrdDAwMGNmd250bjhvZXpnbWsifQ.Nf9Zkfchos577IanoKMoYQ'
		}).addTo(mymap);

		var marker = L.marker(latlng).addTo(mymap);
	});
</script> -->