<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>My Leaflet Routing Machine Example</title>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
        <link rel="stylesheet" href="<?= base_url(); ?>/node_modules/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
        <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">
        <style>
            .map {
                position: absolute;
                width: 100%;
                height: 100%;
            }

        </style>
    </head>
    <body>
        <div id="map" class="map"></div>
        <script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
        <script src="<?= base_url(); ?>/node_modules/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/perliedman-leaflet-control-geocoder/1.5.5/Control.Geocoder.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>

        <script>
            var map = L.map('map').setView([44.907852, 7.673789],16);

            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {attribution: '© OpenStreetMap contributors'}).addTo(map);

            function button(label, container) {
                var btn = L.DomUtil.create('button', '', container);
                btn.setAttribute('type', 'button');
                btn.innerHTML = label;
                return btn;
            }

            var control = L.Routing.control({
                waypoints: [null],
                routeWhileDragging: true,
                show: true,
                language: 'it',
                geocoder: L.Control.Geocoder.nominatim(),
                autoRoute: true
            }).addTo(map);

            map.on('click', function (e) {
                var container = L.DomUtil.create('div'),
                    startBtn = button('Start from this location', container),
                    destBtn = button('Go to this location', container);

                L.DomEvent.on(startBtn, 'click', function () {
                    control.spliceWaypoints(0, 1, e.latlng);
                    map.closePopup();
                });

                L.DomEvent.on(destBtn, 'click', function () {
                    control.spliceWaypoints(control.getWaypoints().length - 1, 1, e.latlng);
                    map.closePopup();
                });

                L.popup().setContent(container).setLatLng(e.latlng).openOn(map);
            });

            L.easyButton('<span class="fa fa-floppy-o"></span>', function () {
                alert('Save routing coordinates ...');
            }).addTo(map);
        </script>
    </body>
</html>