<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'Excel' => Maatwebsite\Excel\Facades\Excel::class,
        ]);
        $middleware->group('api', [
            \App\Http\Middleware\ForceJsonResponse::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $ex) {
            return response()->json([
                'status' => 401,
                'message' => __('auth.unauthorized'),
            ], 401);
        });

        $exceptions->render(function (HttpException $ex) {
            return response()->json([
                'status' => $ex->getStatusCode(),
                'message' => $ex->getMessage(),
            ], $ex->getStatusCode());
        });
    })->create();
