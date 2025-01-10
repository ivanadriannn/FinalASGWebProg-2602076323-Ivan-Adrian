<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if ($role === 'guest' && Auth::check()) {
            return redirect()->route('homepage');
        }

        if ($role === 'auth' && !Auth::check()) {
            return redirect()->route('homepage');
        }

        return $next($request);
    }
}
