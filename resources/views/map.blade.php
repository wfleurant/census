<html><head><title>Census</title>

    <link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" type="text/css">

    <script src="{{ asset('/js/vendor.js') }}"></script>
    <script src="{{ asset('/js/citysdk.js') }}"></script>
    <script src="{{ asset('/js/citysdk.census.js') }}"></script>

    <script>

        var apiKey, map;

        var sdk         = new CitySDK();
        var mode        = "geometry";
        var census      = sdk.modules.census;
        var url_tracts  = "{{ \URL::action('HomeController@tracts') }}";
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

            var mapOptions = { center: { lat: 42.322639, lng: -71.072849 }, zoom: 9 };

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
            switch(x) {

                /* Unused / D.C. Triangle */
                case 'unused_wip':
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
                    break;

                /* DVC Tract */
                case 'dvc_tract':

                    var acs_variables = [ "population" ];

                    var tag_container = "tract";
                    var level = "tract",

                    var request = {
                        "level": "tract",
                        "address": {
                            "street": "504 Dudley St, ",
                            "city": "Roxbury",
                            "state": " MA "
                        },
                        "container": tag_container,
                        "variables": [ acs_variables ]
                    };

                    break;

                /* State Outline */
                case 'mass_boundaries':
                    var request  = { "state": "MA", "level": "state" };
                    var callback = function(response) { map.data.addGeoJson(response); };
                    census.GEORequest(request, callback);
                    break;

                default:
                    return;
            }

            census.GEORequest(request, function (response) {

                //Outputs the raw JSON text
                jQuery("#rawOutput").append(JSON.stringify(response));

                map.data.forEach(function (feature) {
                    map.data.remove(feature);
                });

                map.data.addGeoJson(response);

                map.setCenter({
                    lat : Number(response.features[0].properties.INTPTLAT),
                    lng : Number(response.features[0].properties.INTPTLON)
                });

            });

            /* other */

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

<div class="page-header">
    <center><h3>DSNI<small> Census</small></h3></center>
</div>

<div class="navbar" id="#navbar">

  <div class="btn-group-vertical">

    <button type="button" class="btn btn-primary"
            onclick="go('dvc_tract')"> DVC Tract </button>

    <button type="button" class="btn btn-primary"
            onclick="go('blockGroup')"> Block Groups </button>

    <button type="button" class="btn btn-primary"
            onclick="go('blockGroup')"> Blocks </button>

    <button type="button" class="btn btn-primary"
            onclick="go('place')"> Churches </button>

    <button type="button" class="btn btn-primary"
            onclick="go('county')"> Businesses </button>

    <button type="button" class="btn btn-primary"
            onclick="go('state')"> Non-Profits </button>

    <button type="button" class="btn btn-primary"
            onclick="georequest(this.name)"> Massachusetts </button>

    <button type="button" class="btn btn-primary"
            onclick="showTriangle()"> Clear Map </button>

  </div>
  <?php for ($br=0; $br <= 20 ; $br++) { echo '<br>'; } ?>
</div>

<?php
$map_canvas_style="height: 100%; width: 93%; display: table-cell;"
                 ." vertical-align: middle; margin: 0; padding: 0;";
?>

<div id="map-canvas-{!! $id !!}" style="<?=$map_canvas_style?>">

  {!! $map->render(); !!}

</div>

</body>
</html>