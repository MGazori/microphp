<?php

namespace App\Middleware;

class GlobalMiddleware
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    public static array $globalMiddleware = [
        \App\Middleware\Global\SanitizeParams::class,
    ];
}
