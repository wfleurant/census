var elixir = require('laravel-elixir');

elixir(function(mix) {

    mix.sass('app.scss');

    mix.scripts([
        '../../assets/bower/jquery/dist/jquery.min.js',
        '../../assets/bower/bootstrap/dist/js/bootstrap.min.js',
    ], 'public/js/vendor.js');

    mix.scriptsIn("citysdk/js");

});

