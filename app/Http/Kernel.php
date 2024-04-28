<?php

namespace App\Http;

use App\Http\Middleware\CalculateUserDataMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        'web' => [
            CalculateUserDataMiddleware::class,
        ],

        'api' => [
            CalculateUserDataMiddleware::class,
        ],
    ];

}
