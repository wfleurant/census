<html>
    <head>
        <title>Census</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <script src="{{ asset('/js/vendor.js') }}"></script>


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
    </head>
    <body>

        <div class="navbar">
            <div class="title">DSNI Census</div>
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="#">Item 1</a>
                </li>
                <li>
                    <a href="#">Item 2</a>
                </li>
            </ul>
        </div>

        <div id="map-canvas-{!! $id !!}"
          style="height: 100%; width: 93%; display: table-cell; vertical-align: middle; margin: 0; padding: 0;">

            {!! $map->render(); !!}


        </div>
    </body>
</html>