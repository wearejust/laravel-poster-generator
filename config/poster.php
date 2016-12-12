<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default filesystem
    |--------------------------------------------------------------------------
    |
    | The filesystems on which to store added files and derived images by default.
    | one of the filesystems you configured in app/config/filesystems.php
    |
    */

    'defaultFilesystem' => 'posters',

    /*
    |--------------------------------------------------------------------------
    | Middleware token
    |--------------------------------------------------------------------------
    |
    | Please specify a middleware token to protect your
    | view from rendering from other then PhantomJS
    |
    */

    'middleware_token'  => md5('just')
];
