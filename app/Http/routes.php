<?php

Route::get('/', [ 'uses' => 'HomeController@index' ]);
Route::get('/tracts', [ 'uses' => 'HomeController@tracts' ]);
