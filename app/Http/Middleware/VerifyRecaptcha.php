<?php

namespace App\Http\Middleware;

use App\Services\RecaptchaService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyRecaptcha
{
    protected $recaptchaService;

    public function __construct(RecaptchaService $recaptchaService)
    {
        $this->recaptchaService = $recaptchaService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $action): Response
    {
        // Si reCAPTCHA n'est pas configuré, passer la requête
        if (!$this->recaptchaService->isConfigured()) {
            return $next($request);
        }

        $token = $request->input('g-recaptcha-response');

        if (!$this->recaptchaService->verify($token, $action)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vérification de sécurité échouée. Veuillez réessayer.',
                    'errors' => ['recaptcha' => ['Vérification de sécurité échouée']]
                ], 422);
            }

            return back()
                ->withInput()
                ->withErrors(['recaptcha' => 'Vérification de sécurité échouée. Veuillez réessayer.']);
        }

        return $next($request);
    }
}
