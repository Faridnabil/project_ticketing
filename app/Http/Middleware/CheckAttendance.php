<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAttendance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->hasRole('Helpdesk')) {
            $today = \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d');
            
            // Cek apakah sudah ada absen masuk (Shift 1, 2, atau 3) hari ini ATAU punya absen yang belum check-out
            $hasAbsen = \App\Models\Attendance::where('user_id', Auth::id())
                ->where(function ($query) use ($today) {
                    $query->whereDate('date_check_in', $today)
                          ->orWhereNull('check_out');
                })
                ->whereIn('check_in', ['Shift 1', 'Shift 2', 'Shift 3'])
                ->exists();

            if (!$hasAbsen &&
                !$request->routeIs('helpdesk.attendance.*') &&
                !$request->is('logout') &&
                !$request->ajax() &&
                !$request->expectsJson()
            ) {
                return redirect()->route('helpdesk.attendance.index')
                    ->with('error', 'Anda belum absen hari ini. Silakan masuk terlebih dahulu.');
            }
        }

        return $next($request);
    }
}
