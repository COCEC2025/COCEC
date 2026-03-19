<?php

namespace App\Http\Controllers;

use App\Models\DigitalFinanceUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\DigitalFinanceUpdateMail;
use App\Mail\DigitalFinanceUpdateNotificationMail;

class DigitalFinanceUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer les formulaires avec pagination
        $updates = DigitalFinanceUpdate::latest()->paginate(15);

        // Calculer les statistiques
        $totalUpdates = DigitalFinanceUpdate::count();
        $pendingUpdates = DigitalFinanceUpdate::where('status', 'pending')->count();
        $approvedUpdates = DigitalFinanceUpdate::where('status', 'approved')->count();
        $rejectedUpdates = DigitalFinanceUpdate::where('status', 'rejected')->count();

        return view('admin.digitalfinance.updates.index', compact(
            'updates',
            'totalUpdates',
            'pendingUpdates',
            'approvedUpdates',
            'rejectedUpdates'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('main.digitalfinance.updatesheet');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_number' => 'required|string|max:255',
            'cni_number' => 'required|string|max:255',
            'cni_type' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'togocel' => 'nullable|string|max:255',
            'tmoney' => 'nullable|string|max:255',
            'whatsapp_togocel' => 'nullable|string|max:255',
            'moov' => 'nullable|string|max:255',
            'flooz' => 'nullable|string|max:255',
            'whatsapp_moov' => 'nullable|string|max:255',
            'mobile_banking_togocel' => 'nullable|in:on,1,true',
            'mobile_banking_moov' => 'nullable|in:on,1,true',
            'mobile_money_togocel' => 'nullable|in:on,1,true',
            'mobile_money_moov' => 'nullable|in:on,1,true',
            'web_banking_togocel' => 'nullable|in:on,1,true',
            'web_banking_moov' => 'nullable|in:on,1,true',
            'sms_banking_togocel' => 'nullable|in:on,1,true',
            'sms_banking_moov' => 'nullable|in:on,1,true',
            'notes' => 'nullable|string',
        ], [
            'account_number.required' => 'Le numéro de compte est obligatoire.',
            'account_number.max' => 'Le numéro de compte ne peut pas dépasser 255 caractères.',
            'cni_number.required' => 'Le numéro CNI ou autre document est obligatoire.',
            'cni_number.max' => 'Le numéro CNI ne peut pas dépasser 255 caractères.',
            'cni_type.required' => 'Le type de document est obligatoire.',
            'cni_type.max' => 'Le type de document ne peut pas dépasser 255 caractères.',
            'full_name.required' => 'Le nom et prénoms sont obligatoires.',
            'full_name.max' => 'Le nom et prénoms ne peuvent pas dépasser 255 caractères.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.max' => 'L\'adresse email ne peut pas dépasser 255 caractères.',
            'togocel.max' => 'Le numéro Togocel ne peut pas dépasser 255 caractères.',
            'tmoney.max' => 'Le numéro Tmoney ne peut pas dépasser 255 caractères.',
            'whatsapp_togocel.max' => 'Le numéro WhatsApp Togocel ne peut pas dépasser 255 caractères.',
            'moov.max' => 'Le numéro Moov ne peut pas dépasser 255 caractères.',
            'flooz.max' => 'Le numéro Flooz ne peut pas dépasser 255 caractères.',
            'whatsapp_moov.max' => 'Le numéro WhatsApp Moov ne peut pas dépasser 255 caractères.',
            'notes.max' => 'Les notes ne peuvent pas dépasser 255 caractères.',
        ]);

        $data = $request->all();

        // Forcer la conversion en booléen pour les checkboxes
        $data['mobile_banking_togocel'] = (bool) $request->input('mobile_banking_togocel');
        $data['mobile_banking_moov'] = (bool) $request->input('mobile_banking_moov');
        $data['mobile_money_togocel'] = (bool) $request->input('mobile_money_togocel');
        $data['mobile_money_moov'] = (bool) $request->input('mobile_money_moov');
        $data['web_banking_togocel'] = (bool) $request->input('web_banking_togocel');
        $data['web_banking_moov'] = (bool) $request->input('web_banking_moov');
        $data['sms_banking_togocel'] = (bool) $request->input('sms_banking_togocel');
        $data['sms_banking_moov'] = (bool) $request->input('sms_banking_moov');

        $update = DigitalFinanceUpdate::create($data);

        // Envoyer le mail de confirmation au client (si email fourni)
        if ($request->email) {
            try {
                Mail::to($request->email)->send(new DigitalFinanceUpdateMail($request->full_name, $request->email));
            } catch (\Exception $e) {
                // Log l'erreur mais ne pas bloquer le processus
                Log::error('Erreur envoi mail confirmation: ' . $e->getMessage());
            }
        }

        // Envoyer le mail de notification à l'admin
        try {
            Mail::to(['info@cocectogo.org', 'finance-digitale@cocectogo.org'])->send(new DigitalFinanceUpdateNotificationMail(
                $request->full_name,
                $request->account_number,
                $request->cni_number,
                $request->email
            ));
        } catch (\Exception $e) {
            // Log l'erreur mais ne pas bloquer le processus
            Log::error('Erreur envoi mail notification admin: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Formulaire soumis avec succès !']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $update = DigitalFinanceUpdate::findOrFail($id);
        return view('admin.digitalfinance.updates.show', compact('update'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $update = DigitalFinanceUpdate::findOrFail($id);
        return view('admin.digitalfinance.updates.edit', compact('update'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update = DigitalFinanceUpdate::findOrFail($id);

        $request->validate([
            'account_number' => 'nullable|string|max:255',
            'cni_number' => 'nullable|string|max:255',
            'cni_type' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'togocel' => 'nullable|string|max:255',
            'tmoney' => 'nullable|string|max:255',
            'whatsapp_togocel' => 'nullable|string|max:255',
            'moov' => 'nullable|string|max:255',
            'flooz' => 'nullable|string|max:255',
            'whatsapp_moov' => 'nullable|string|max:255',
            'mobile_banking_togocel' => 'nullable|in:on,1,true',
            'mobile_banking_moov' => 'nullable|in:on,1,true',
            'mobile_money_togocel' => 'nullable|in:on,1,true',
            'mobile_money_moov' => 'nullable|in:on,1,true',
            'web_banking_togocel' => 'nullable|in:on,1,true',
            'web_banking_moov' => 'nullable|in:on,1,true',
            'sms_banking_togocel' => 'nullable|in:on,1,true',
            'sms_banking_moov' => 'nullable|in:on,1,true',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $data = $request->all();

        // Forcer la conversion en booléen pour les checkboxes
        $data['mobile_banking_togocel'] = (bool) $request->input('mobile_banking_togocel');
        $data['mobile_banking_moov'] = (bool) $request->input('mobile_banking_moov');
        $data['mobile_money_togocel'] = (bool) $request->input('mobile_money_togocel');
        $data['mobile_money_moov'] = (bool) $request->input('mobile_money_moov');
        $data['web_banking_togocel'] = (bool) $request->input('web_banking_togocel');
        $data['web_banking_moov'] = (bool) $request->input('web_banking_moov');
        $data['sms_banking_togocel'] = (bool) $request->input('sms_banking_togocel');
        $data['sms_banking_moov'] = (bool) $request->input('sms_banking_moov');

        $update->update($data);

        // Si c'est une mise à jour depuis la page de détail, rester sur cette page
        if ($request->has('from_show')) {
            return redirect()->route('admin.digitalfinance.updates.show', $update->id)
                ->with('success', 'Statut mis à jour avec succès !');
        }

        return redirect()->route('admin.digitalfinance.updates.index')->with('success', 'Formulaire mis à jour avec succès !');
    }

    /**
     * Mettre à jour le statut depuis la page de détail
     */
    public function updateStatus(Request $request, string $id)
    {
        $update = DigitalFinanceUpdate::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string',
        ]);

        $update->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.digitalfinance.updates.show', $update->id)
            ->with('success', 'Statut mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $update = DigitalFinanceUpdate::findOrFail($id);
        $update->delete();

        return redirect()->route('admin.digitalfinance.updates.index')->with('success', 'Formulaire supprimé avec succès !');
    }

    /**
     * Approuver un formulaire
     */
    public function approve(string $id)
    {
        $update = DigitalFinanceUpdate::findOrFail($id);
        $update->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Formulaire approuvé avec succès !');
    }

    /**
     * Rejeter un formulaire
     */
    public function reject(string $id)
    {
        $update = DigitalFinanceUpdate::findOrFail($id);
        $update->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Formulaire rejeté avec succès !');
    }

    /**
     * Générer le PDF du formulaire
     */
    public function generatePdf(string $id)
    {
        $update = DigitalFinanceUpdate::findOrFail($id);

        $data = [
            'update' => $update,
        ];

        $pdf = \PDF::loadView('admin.digitalfinance.updates.pdf', $data);

        $fileName = \App\Helpers\FileHelper::generatePdfFileName(
            'formulaire_mise_a_jour', 
            $update->id, 
            $update->full_name
        );
        return $pdf->download($fileName);
    }
}
