<?php

return [
    /*
    |--------------------------------------------------------------------------
    | CSRF Protection
    |--------------------------------------------------------------------------
    |
    | The URIs that should be excluded from CSRF verification.
    |
    */

    'except' => [
        '/login',
        '/register',
        '/logout',
        '/payment/result',
        '/payment/notify',
        '/test-csrf',
    ],
];
