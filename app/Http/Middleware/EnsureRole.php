<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Allow the request only if the authenticated user has the given role.
     * Usage in routes: ->middleware('role:admin')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (! $user || $user->role !== $role) {
            abort(403, 'ليس لديك صلاحية الوصول إلى هذه الصفحة.');
        }

        return $next($request);
    }
}
