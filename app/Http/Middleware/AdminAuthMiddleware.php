<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() && !session('admin_logged_in')) {
            session(['url.intended' => $request->fullUrl()]);
            return redirect()->route('admin.login')->with('error', 'অ্যাডমিন প্যানেলে প্রবেশ করতে অনুগ্রহ করে আগে লগইন করুন।');
        }

        return $next($request);
    }
}
