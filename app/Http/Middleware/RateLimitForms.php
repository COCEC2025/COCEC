<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitForms
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $maxAttempts = '5', string $decayMinutes = '15'): Response
    {
        $key = 'form-submissions:' . $request->ip() . ':' . $request->route()->getName();
        
        if (RateLimiter::tooManyAttempts($key, (int) $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Trop de tentatives. Veuillez réessayer dans {$seconds} secondes.",
                    'retry_after' => $seconds
                ], 429);
            }
            
            return back()
                ->withInput()
                ->withErrors(['rate_limit' => "Trop de tentatives. Veuillez réessayer dans {$seconds} secondes."]);
        }

        RateLimiter::hit($key, (int) $decayMinutes * 60);

        return $next($request);
    }
}
