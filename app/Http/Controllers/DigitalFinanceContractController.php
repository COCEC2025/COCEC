<?php

namespace App\Http\Controllers;

use App\Models\DigitalFinanceContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\DigitalFinanceContractMail;
use App\Mail\DigitalFinanceContractNotificationMail;
use Barryvdh\DomPDF\Facade\Pdf;

class DigitalFinanceContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $contracts = DigitalFinanceContract::latest()->paginate(10);
            
            // Calculer les statistiques
            $totalContracts = DigitalFinanceContract::count();
            $pendingContracts = DigitalFinanceContract::where('status', 'pending')->count();
            $activeContracts = DigitalFinanceContract::where('status', 'active')->count();
            $terminatedContracts = DigitalFinanceContract::where('status', 'terminated')->count();
            
            return view('admin.digitalfinance.contracts.index', compact(
                'contracts', 
                'totalContracts', 
                'pendingContracts', 
                'activeContracts', 
                'terminatedContracts'
            ));
        } catch (\Exception $e) {
            // Log l'erreur
            Log::error('Erreur dans DigitalFinanceContractController@index: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Retourner une vue d'erreur ou rediriger
            return back()->with('error', 'Une erreur est survenue lors du chargement des contrats: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('main.digitalfinance.contract');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'cni_type' => 'nullable|string|max:255',
            'cni_number' => 'required|string|max:255',
            'address' => 'required|string',
            'account_number' => 'required|string|max:255',
            'mobile_money' => 'nullable|in:on,1,true',
            'mobile_banking' => 'nullable|in:on,1,true',
            'web_banking' => 'nullable|in:on,1,true',
            'sms_banking' => 'nullable|in:on,1,true',
            'notes' => 'nullable|string',
        ], [
            'full_name.required' => 'Le nom et prénoms sont obligatoires.',
            'full_name.max' => 'Le nom et prénoms ne peuvent pas dépasser 255 caractères.',
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'phone.max' => 'Le numéro de téléphone ne peut pas dépasser 255 caractères.',
            'cni_type.max' => 'Le type de document ne peut pas dépasser 255 caractères.',
            'cni_number.required' => 'Le numéro CNI ou autre document est obligatoire.',
            'cni_number.max' => 'Le numéro CNI ne peut pas dépasser 255 caractères.',
            'address.required' => 'L\'adresse est obligatoire.',
            'account_number.required' => 'Le numéro de compte est obligatoire.',
            'account_number.max' => 'Le numéro de compte ne peut pas dépasser 255 caractères.',
            'notes.max' => 'Les notes ne peuvent pas dépasser 255 caractères.',
        ]);

        $data = $request->all();
        
        // Convertir les checkboxes en booléens
        $data['mobile_money'] = (bool) $request->input('mobile_money');
        $data['mobile_banking'] = (bool) $request->input('mobile_banking');
        $data['web_banking'] = (bool) $request->input('web_banking');
        $data['sms_banking'] = (bool) $request->input('sms_banking');
        
        // Ajouter la date du contrat et le statut par défaut
        $data['contract_date'] = now();
        $data['status'] = 'pending';

        $contract = DigitalFinanceContract::create($data);

        // Envoyer le mail de confirmation au client (si email fourni)
        if ($request->email) {
            try {
                Mail::to($request->email)->send(new DigitalFinanceContractMail($request->full_name, $request->email));
            } catch (\Exception $e) {
                // Log l'erreur mais ne pas bloquer le processus
                Log::error('Erreur envoi mail confirmation contrat: ' . $e->getMessage());
            }
        }

        // Envoyer le mail de notification à l'admin
        try {
            Mail::to(['info@cocectogo.org', 'finance-digitale@cocectogo.org'])->send(new DigitalFinanceContractNotificationMail(
                $request->full_name,
                $request->account_number,
                $request->phone,
                $request->email
            ));
        } catch (\Exception $e) {
            // Log l'erreur mais ne pas bloquer le processus
            Log::error('Erreur envoi mail notification admin contrat: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Contrat soumis avec succès !']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contract = DigitalFinanceContract::findOrFail($id);
        return view('admin.digitalfinance.contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contract = DigitalFinanceContract::findOrFail($id);
        return view('admin.digitalfinance.contracts.edit', compact('contract'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $contract = DigitalFinanceContract::findOrFail($id);
        
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'cni_type' => 'nullable|string|max:255',
            'cni_number' => 'required|string|max:255',
            'address' => 'required|string',
            'account_number' => 'required|string|max:255',
            'mobile_money' => 'nullable|in:on,1,true',
            'mobile_banking' => 'nullable|in:on,1,true',
            'web_banking' => 'nullable|in:on,1,true',
            'sms_banking' => 'nullable|in:on,1,true',
            'status' => 'required|in:pending,active,terminated',
            'notes' => 'nullable|string',
        ], [
            'full_name.required' => 'Le nom et prénoms sont obligatoires.',
            'full_name.max' => 'Le nom et prénoms ne peuvent pas dépasser 255 caractères.',
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'phone.max' => 'Le numéro de téléphone ne peut pas dépasser 255 caractères.',
            'cni_type.max' => 'Le type de document ne peut pas dépasser 255 caractères.',
            'cni_number.required' => 'Le numéro CNI ou autre document est obligatoire.',
            'cni_number.max' => 'Le numéro CNI ne peut pas dépasser 255 caractères.',
            'address.required' => 'L\'adresse est obligatoire.',
            'account_number.required' => 'Le numéro de compte est obligatoire.',
            'account_number.max' => 'Le numéro de compte ne peut pas dépasser 255 caractères.',
            'status.required' => 'Le statut est obligatoire.',
            'status.in' => 'Le statut doit être : en attente, actif ou terminé.',
            'notes.max' => 'Les notes ne peuvent pas dépasser 255 caractères.',
        ]);

        $data = $request->all();
        
        // Convertir les checkboxes en booléens
        $data['mobile_money'] = (bool) $request->input('mobile_money');
        $data['mobile_banking'] = (bool) $request->input('mobile_banking');
        $data['web_banking'] = (bool) $request->input('web_banking');
        $data['sms_banking'] = (bool) $request->input('sms_banking');

        $contract->update($data);

        return redirect()->route('admin.digitalfinance.contracts.index')
            ->with('success', 'Contrat mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contract = DigitalFinanceContract::findOrFail($id);
        $contract->delete();

        return redirect()->route('admin.digitalfinance.contracts.index')
            ->with('success', 'Contrat supprimé avec succès !');
    }

    /**
     * Activer un contrat
     */
    public function activate(string $id)
    {
        $contract = DigitalFinanceContract::findOrFail($id);
        $contract->update(['status' => 'active']);

        return redirect()->back()->with('success', 'Contrat activé avec succès !');
    }

    /**
     * Terminer un contrat
     */
    public function terminate(string $id)
    {
        $contract = DigitalFinanceContract::findOrFail($id);
        $contract->update(['status' => 'terminated']);

        return redirect()->back()->with('success', 'Contrat terminé avec succès !');
    }

    /**
     * Mettre à jour le statut depuis la page de détail
     */
    public function updateStatus(Request $request, string $id)
    {
        $contract = DigitalFinanceContract::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,active,terminated',
            'notes' => 'nullable|string',
        ]);

        $contract->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.digitalfinance.contracts.show', $contract->id)
            ->with('success', 'Statut mis à jour avec succès !');
    }

    /**
     * Générer le PDF du contrat
     */
    public function generatePdf(string $id)
    {
        $contract = DigitalFinanceContract::findOrFail($id);

        $data = [
            'contract' => $contract,
        ];

        $pdf = Pdf::loadView('admin.digitalfinance.contracts.pdf', $data);

        $fileName = \App\Helpers\FileHelper::generatePdfFileName(
            'contrat_adhesion', 
            $contract->id, 
            $contract->full_name
        );
        return $pdf->download($fileName);
    }
}
