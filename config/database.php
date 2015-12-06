<?php

return [

    'fetch' => PDO::FETCH_CLASS,

    'default' => 'mysql',

    'connections' => [
        /* primary connection */
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => 'mysql',
            'database'  => env('MYSQL_ENV_MYSQL_DATABASE'),
            'username'  => env('MYSQL_ENV_MYSQL_USERNAME'),
            'password'  => env('MYSQL_ENV_MYSQL_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],

        /* admin conneciton for database migrations, user creation */
        'mysql-root' => [
            'driver'    => 'mysql',
            'host'      => 'mysql',
            'database'  => env('MYSQL_ENV_MYSQL_DATABASE'),
            'username'  => 'root',
            'password'  => env('MYSQL_ENV_MYSQL_ROOT_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],

    ],

    'migrations' => 'migrations',

];
