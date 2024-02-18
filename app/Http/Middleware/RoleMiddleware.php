<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Log::info($roles);
        // dd($roles);
        // dd(auth()->user()->Roles->pluck('name'));

        $canAccessIt = false;

        foreach (auth()->user()->Roles->pluck('name') as $userRole) {
            if (in_array($userRole, $roles)) {
                $canAccessIt = true;
                break;
            }
        }

        return $canAccessIt ? $next($request) : abort(403);
    }
}
