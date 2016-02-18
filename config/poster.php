<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Save directory IMG/PDF
    |--------------------------------------------------------------------------
    |
    | Please specify the directory where to save images/pdfs
    | Note that this directory is relative from the
    | public folder
    |
    */

    'saveDirectory' => '/cache',

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