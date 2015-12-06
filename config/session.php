<?php

return [

    /*
    | "file", "cookie", "database", "apc", "memcached", "redis", "array"
    */
    'driver' => env('database'),

    'lifetime' => 10800,
    'expire_on_close' => true,
    'encrypt' => true,
    'files' => storage_path('framework/sessions'),
    'connection' => 'mysql',
    'table' => 'sessions',
    'lottery' => [2, 100],
    'cookie' => 'laravel_session',
    'path' => '/',
    'domain' => 'census.dsni.org',
    'secure' => true,

];
