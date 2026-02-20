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
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;

        if (!in_array($userRole, $roles)) {
            $redirectMap = [
                'admin'   => '/admin/dashboard',
                'officer' => '/officer/dashboard',
                'user'    => '/user/dashboard',
            ];
            return redirect($redirectMap[$userRole] ?? '/');
        }

        return $next($request);
    }
}
