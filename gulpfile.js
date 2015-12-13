var elixir = require('laravel-elixir');

elixir(function(mix) {

    mix.sass('app.scss');

    mix.scripts([
        '../../assets/bower/jquery/dist/jquery.min.js',
        '../../assets/bower/bootstrap/dist/js/bootstrap.min.js',
        'toolshed.js',
    ], 'public/js/vendor.js');

    elixir(function(mix) {

        /* CitySDK*/
        mix.copy('citysdk/js/citysdk.js', 'public/js/citysdk.js');
        mix.copy('citysdk/js/citysdk.census.js', 'public/js/citysdk.census.js');
        mix.copy('citysdk/js/citysdk.moduleTemplate.js', 'public/js/citysdk.moduleTemplate.js');

        // mix.copy('citysdk/js/citysdk.ckan.js', 'public/js/citysdk.ckan.js');
        // mix.copy('citysdk/js/citysdk.eia.js', 'public/js/citysdk.eia.js');
        // mix.copy('citysdk/js/citysdk.farmersMarket.js', 'public/js/citysdk.farmersMarket.js');
        // mix.copy('citysdk/js/citysdk.fema.js', 'public/js/citysdk.fema.js');
        // mix.copy('citysdk/js/citysdk.socrata.js', 'public/js/citysdk.socrata.js');
    });

});

