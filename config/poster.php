<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Temporary storage directory
    |--------------------------------------------------------------------------
    |
    | The directory that will be used to store the temporary capture file.
    | after the capture the file will be moved to the filesystem.
    |
    */

    'tempDirectory' => storage_path('posters'),

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
