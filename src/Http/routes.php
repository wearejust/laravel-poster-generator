<?php

Route::post('postergenerator', [
    'middleware' => 'poster.render',
    'as' => 'package.postergenerator',
    'uses' => '\Just\PosterGenerator\Http\Controllers\PosterController@render'
]);