<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        'web' => [
            // ...existing middleware...
            \App\Http\Middleware\CheckRole::class,
        ],

        'api' => [
            // ...existing middleware...
        ],
    ];

    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'checkrole' => \App\Http\Middleware\CheckRole::class,
    ];
}
