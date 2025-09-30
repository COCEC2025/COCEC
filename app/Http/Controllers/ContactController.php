<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class ContactController extends Controller
{
    //
    public function store(Request $request)
    {
        $mail = "info@cocectogo.org";

        // Vérifier les champs honeypot (détection de bots)
        if ($request->filled('website_url') || $request->filled('phone_number')) {
            return back()->with('error', 'Soumission détectée comme spam.');
        }

        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'g-recaptcha-response' => 'required|string',
        ]);

        try {
            Mail::to($mail)->send(new ContactMail($validated['fullname'], $validated['email'], $validated['subject'], $validated['message']));
            return back()->with('success', 'Votre message a été envoyé avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de l\'envoi de votre message. Veuillez réessayer plus tard.');
        }
    }
}
