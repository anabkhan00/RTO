<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized access');
        }

        $roles = explode('|', $role);
        
        foreach ($roles as $singleRole) {
            if (auth()->user()->hasRole(trim($singleRole))) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized access');
    }
}