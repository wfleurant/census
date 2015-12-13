<html><head><title>Census</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <script src="{{ asset('/js/vendor.js') }}"></script>
    <script src="{{ asset('/js/citysdk.js') }}"></script>
    <script src="{{ asset('/js/citysdk.census.js') }}"></script>

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 32px;
        }

    </style>

    <script>

        var apiKey, map;
        var sdk = new CitySDK();
        var census = sdk.modules.census;
        var mode = "geometry";


        var url_tracts = "{{ \URL::action('HomeController@tracts') }}";
        var dsni_tracts = tracts(url_tracts);

        function getApiKey() { return "{{{ $census_apikey }}}"; }
        apiKey = getApiKey();



        function clearMap() {
            map.data.forEach(function(feature) {
                map.data.remove(feature);
            });
        }

        census.enable(apiKey);
        $(document).ready(function() {

            var mapOptions = { center: { lat: 42.322639, lng: -71.072849 }, zoom: 7 };

            map = new google.maps.Map(document.getElementById('map-canvas-{!! $id !!}'), mapOptions);
            map.data.setStyle({ fillColor: 'green' });
            georequest({state: "MA", level: "state"});

            // map.data.addGeoJson(triangleGeojson);

            /* The info window (bubble/popup) associated with
                a marker (icon) or waypoint/trackpoint (blip) */
            var infowindow = new google.maps.InfoWindow();
            var info_content =  "<h2>" +
                    event.feature.getProperty("NAME") + "</h2><p>Median age: " +
                    event.feature.getProperty("age") + "<br/>Population: " +
                    event.feature.getProperty("population") + "<br/>Median income: " +
                    event.feature.getProperty("income") + "</p>";

            map.data.addListener('click', function(event) {
                infowindow.setContent(info_content);
                infowindow.setPosition(event.latLng);
                infowindow.setOptions({pixelOffset: new google.maps.Size(0,-30)});
                infowindow.open(map);
            });

        });

        function georequest(obj) {

            if (obj == "mass_boundaries") { georequest({state: "MA", level: "state"}); }

            var state = (obj.state) ? obj.state : "MA";
            var level = (obj.level) ? obj.level : "state";

            var request = { "state": state, "level": level };

            var callback = function(response) {
                map.data.addGeoJson(response);
            };

            census.GEORequest(request, callback);

            return;
        }

        function go(x) {

            /* State Outline */
            var request  = { "state": "MA", "level": "state" };
            var callback = function(response) { map.data.addGeoJson(response); };
            census.GEORequest(request, callback);
            return;

            /* other */
            var request = {
                variables: [
                    "age",
                    "population",
                    "income"
                ],
                level: x,
                sublevel: true,
                container: mode,
                containerGeometry: census.GEOtoESRI(triangleGeojson)[0].geometry
            };

            census.GEORequest(request, function(response) {
                clearMap();
                map.data.addGeoJson(response);
            });
        }

        function showTriangle() {
            clearMap();
            map.data.addGeoJson(triangleGeojson);
        }

    </script>

</head>
<body>

    <div class="navbar">
        <div class="title">DSNI Census</div>
        <ul class="nav navbar-nav">
            <li class="active">
                <a href="#">Item 1</a>
                <div class="container">

                    <input type="submit" value="Clear and Draw Triangle" onclick="showTriangle()"/>
                    <input type="submit" value="Block Groups" onclick="go('blockGroup')"/>
                    <input type="submit" value="Tracts" onclick="go('tract')"/>

                    <input type="submit" value="Get Places" onclick="go('place')"/>
                    <input type="submit" value="Get Counties" onclick="go('county')"/>
                    <input type="submit" value="Get States" onclick="go('state')"/>

                    <input type="submit" name="mass_boundaries" value="Mass Boundaries" onclick="georequest(this.name)"/>

                    {{--
                    <input type="submit" value="Set container 'geometry'" onclick="setContainer('geometry')"/>
                    <input type="submit" value="Set container 'geometry_within'" onclick="setContainer('geometry_within')"/>
                    --}}
                </div>
            </li>
            <li>
                <a href="#">Item 2</a>
                <div class="container">
                    <input type="submit" value="Block2 Groups" onclick="go('blockGroup')"/>
                    <input type="submit" value="Tracts2" onclick="go('tract')"/>
                </div>
            </li>
        </ul>
    </div> {{-- end of navbar --}}

    <div id="map-canvas-{!! $id !!}"
      style="height: 100%; width: 93%; display: table-cell; vertical-align: middle; margin: 0; padding: 0;">

        {!! $map->render(); !!}

    </div>

</body></html>