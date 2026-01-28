<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SiteStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $status = Setting::get('site_status', 'live');

        // Always allow if site is live
        if ($status === 'live') {
            return $next($request);
        }

        // Always allow admin access
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            return $next($request);
        }

        // Allow access to splash pages themselves
        if ($request->is('maintenance') || $request->is('coming-soon')) {
            return $next($request);
        }

        // Allow access to admin login/dashboard (in case admin is not logged in)
        if ($request->is('admin*') || $request->is('login') || $request->is('logout')) {
            return $next($request);
        }
        
        // Allow access to compiled assets
        if ($request->is('build/*') || $request->is('storage/*') || $request->is('vendor/*')) {
            return $next($request);
        }

        // Redirect based on status
        if ($status === 'maintenance') {
            return redirect()->route('maintenance');
        }

        if ($status === 'coming_soon') {
            return redirect()->route('coming-soon');
        }

        return $next($request);
    }
}
