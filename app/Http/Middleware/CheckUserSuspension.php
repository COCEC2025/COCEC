<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserSuspension
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isSuspended()) {
            auth()->logout();
            
            return redirect()->route('login')
                ->with('error', 'Votre compte a été suspendu. Veuillez contacter l\'administrateur pour plus d\'informations.');
        }

        return $next($request);
    }
}
