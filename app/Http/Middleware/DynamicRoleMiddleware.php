<?php

// app/Http/Middleware/DynamicRoleMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class DynamicRoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $user = auth()->user();
        $route = $request->route();
        $routeName = $route->getName();
        
        // If user is superadmin, allow all access
        if ($user->hasRole('superadmin')) {
            return $next($request);
        }

        // Check if user has permission for this route
        if (!$user->hasPermissionTo($routeName)) {
            throw UnauthorizedException::forPermissions([$routeName]);
        }

        return $next($request);
    }
}