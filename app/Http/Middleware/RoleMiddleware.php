<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized.');
        }

        $user = auth()->user();

        foreach ($roles as $role) {
            if ($role === 'admin' && $user->isAdmin()) {
                return $next($request);
            }
            if ($role === 'customer' && $user->isCustomer()) {
                return $next($request);
            }
            if ($user->role === $role) {
                return $next($request);
            }
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized access. Required role: ' . implode(', ', $roles));
    }
}
