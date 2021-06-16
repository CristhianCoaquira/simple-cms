<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class EnsureUserRoleIsAllowedToAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userRole = auth()->user()->role;
        $currentRouteName = Route::currentRouteName();
        if (in_array($currentRouteName, $this->userAccessRole()[$userRole])) {
            return $next($request);
        }
        abort(403, 'You are not allowed to access this page');
    }

    private function userAccessRole()
    {
        return [
            'user' => [
                'dashboard'
            ],
            'admin' => [
                'dashboard',
                'pages',
                'navigation-menus',
                'users',
                'user-permissions',
            ]
        ];
    }
}
