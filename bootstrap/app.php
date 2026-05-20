<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CustomerMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\ViewErrorBag;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role.admin' => AdminMiddleware::class,
            'role.customer' => CustomerMiddleware::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'permission' => \App\Http\Middleware\PermissionMiddleware::class,
        ]);

        $middleware->throttleApi('60,1');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Not found.'], 404);
            }
            return response()->view('errors.404', [], 404);
        });

        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden.'], 403);
            }
            return response()->view('errors.403', ['errors' => new ViewErrorBag], 403);
        });

        $exceptions->render(function (\Throwable $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Server error.'], 500);
            }
            if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
                return response()->view('errors.403', ['errors' => new ViewErrorBag], 403);
            }
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->view('errors.404', ['errors' => new ViewErrorBag], 404);
            }
        });
    })->create();
