<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $roleId = match($role) {
            'admin' => 1,
            'user' => 2,
            'servicer' => 3,
            default => null
        };

        if ($roleId === null) {
            abort(500, 'Invalid role specified.');
        }

        if ($request->user()->role_id !== $roleId) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
} 