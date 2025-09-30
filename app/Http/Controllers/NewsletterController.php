<?php

namespace App\Http\Controllers;

use App\Mail\NewsLettersMail;
use App\Services\NewsletterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    private NewsletterService $newsletterService;

    public function __construct(NewsletterService $newsletterService)
    {
        $this->newsletterService = $newsletterService;
    }

    // Subscribe to the newsletter
    public function subscribe(Request $request)
    {
        // Vérifier les champs honeypot (détection de bots)
        if ($request->filled('website_url') || $request->filled('phone_number')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Soumission détectée comme spam.'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns|max:255',
            'recaptcha_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Adresse e-mail invalide.'
            ], 422);
        }

        DB::table('newsletter_subscribers')->updateOrInsert(
            ['email' => $request->email],
        );

        Mail::to($request->email)->send(new NewsLettersMail($request->email));


        return response()->json([
            'status' => 'success',
            'message' => 'Merci pour votre inscription !'
        ]);
    }

    // Unsubscribe from the newsletter
    public function unsubscribe(Request $request)
    {
        $token = $request->get('token');
        
        if (!$token) {
            return view('mails.unsubscribe-error', [
                'message' => 'Token de désabonnement invalide ou manquant.'
            ]);
        }

        $success = $this->newsletterService->unsubscribe($token);
        
        if ($success) {
            return view('mails.unsubscribe-success', [
                'message' => 'Vous avez été désabonné avec succès de notre newsletter.'
            ]);
        } else {
            return view('mails.unsubscribe-error', [
                'message' => 'Token de désabonnement invalide ou expiré.'
            ]);
        }
    }
}
