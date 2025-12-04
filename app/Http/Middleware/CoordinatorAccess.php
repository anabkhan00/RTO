<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoordinatorAccess
{
    public function handle(Request $request, Closure $next, $type)
    {
        if (!Auth::check() || Auth::user()->role !== 'coordinator') {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if ($user->coordinator_type !== $type) {
            abort(403, 'Access denied. You do not have permission to access this section.');
        }

        return $next($request);
    }
}