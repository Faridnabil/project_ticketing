<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AutoLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = session('lastActivityTime');
            $timeout = 10 * 60; // 10 menit dalam detik

            if ($lastActivity && (time() - $lastActivity) > $timeout) {
                Auth::logout();
                return redirect()->route('login')->with('message', 'You have been logged out due to inactivity.');
            }

            session(['lastActivityTime' => time()]);
        }

        return $next($request);
    }
}
