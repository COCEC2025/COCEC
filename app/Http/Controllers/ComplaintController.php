<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ComplaintNotificationMail;
use App\Models\Complaint;

class ComplaintController extends Controller
{
    /**
     * Afficher le formulaire de plainte
     */
    public function index()
    {
        return view('main.complaint');
    }

    /**
     * Traiter la soumission d'une plainte
     */
    public function store(Request $request)
    {
        $mail = "gestiondesplaintes@cocectogo.org";

        // Validation des données
        $validator = Validator::make($request->all(), [
            'member_name' => 'nullable|string|max:255',
            'member_number' => 'nullable|string|max:100',
            'member_phone' => 'nullable|string|max:20',
            'member_email' => 'nullable|email|max:255',
            'complaint_subject' => 'required|string|max:255',
            'complaint_category' => 'required|string|in:service,credit,epargne,technique,autre',
            'complaint_description' => 'required|string|max:2000',
            'complaint_attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // 5MB max
            'data_consent' => 'required|accepted',
        ], [
            'member_email.email' => 'L\'adresse email doit être valide.',
            'complaint_subject.required' => 'L\'objet de la plainte est obligatoire.',
            'complaint_category.required' => 'La catégorie de la plainte est obligatoire.',
            'complaint_description.required' => 'La description de la plainte est obligatoire.',
            'complaint_description.max' => 'La description ne peut pas dépasser 2000 caractères.',
            'complaint_attachments.*.file' => 'Les pièces jointes doivent être des fichiers valides.',
            'complaint_attachments.*.mimes' => 'Les formats acceptés sont : JPG, PNG, PDF, DOC, DOCX.',
            'complaint_attachments.*.max' => 'Chaque fichier ne peut pas dépasser 5MB.',
            'data_consent.required' => 'Vous devez accepter le traitement de vos données.',
            'data_consent.accepted' => 'Vous devez accepter le traitement de vos données.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Créer la plainte
            $complaint = new Complaint();
            $complaint->member_name = $request->member_name;
            $complaint->member_number = $request->member_number;
            $complaint->member_phone = $request->member_phone;
            $complaint->member_email = $request->member_email;
            $complaint->subject = $request->complaint_subject;
            $complaint->category = $request->complaint_category;
            $complaint->description = $request->complaint_description;
            $complaint->status = 'pending';
            $complaint->reference = 'PLAINT-' . date('Y') . '-' . str_pad(Complaint::count() + 1, 4, '0', STR_PAD_LEFT);
            $complaint->save();

            // Traitement des pièces jointes
            if ($request->hasFile('complaint_attachments')) {
                foreach ($request->file('complaint_attachments') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('complaints/' . $complaint->id, $filename, 'public');

                    // Ici vous pourriez créer un modèle Attachment si nécessaire
                    // Pour l'instant, on stocke juste le chemin
                    $complaint->attachments = $complaint->attachments ? $complaint->attachments . ',' . $path : $path;
                }
                $complaint->save();
            }

            // Envoyer un email de notification (optionnel)
            if (config('mail.default') !== 'log') {
                try {
                    Mail::to($mail)
                        ->send(new ComplaintNotificationMail($complaint));
                } catch (\Exception $e) {
                    // Log l'erreur mais ne pas faire échouer la soumission
                    Log::error('Erreur lors de l\'envoi de l\'email de plainte: ' . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Votre plainte a été déposée avec succès. Référence: ' . $complaint->reference,
                'reference' => $complaint->reference
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de la plainte: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors du traitement de votre plainte. Veuillez réessayer.'
            ], 500);
        }
    }

    /**
     * Afficher la liste des plaintes (admin)
     */
    public function adminIndex(Request $request)
    {
        // Debug: Vérifier si des plaintes existent
        $totalComplaints = Complaint::count();
        Log::info('Total complaints in database: ' . $totalComplaints);
        
        $query = Complaint::query();
        
        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('member_name', 'like', "%{$search}%")
                  ->orWhere('member_number', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }
        
        $perPage = $request->get('per_page', 10);
        $complaints = $query->latest()->paginate($perPage);
        
        // Debug: Vérifier la pagination
        Log::info('Complaints pagination: ' . $complaints->total() . ' total, ' . $complaints->count() . ' current page');
        
        // Statistiques
        $stats = [
            'total' => $totalComplaints,
            'pending' => Complaint::where('status', 'pending')->count(),
            'processing' => Complaint::where('status', 'processing')->count(),
            'resolved' => Complaint::where('status', 'resolved')->count(),
            'closed' => Complaint::where('status', 'closed')->count(),
        ];
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'data' => $complaints->items(),
                'current_page' => $complaints->currentPage(),
                'last_page' => $complaints->lastPage(),
                'per_page' => $complaints->perPage(),
                'total' => $complaints->total(),
                'stats' => $stats
            ]);
        }
        
        return view('admin.complaint.index', compact('complaints', 'stats'));
    }

    /**
     * Afficher les détails d'une plainte (admin)
     */
    public function adminShow($id)
    {
        $complaint = Complaint::findOrFail($id);
        return view('admin.complaint.show', compact('complaint'));
    }

    /**
     * Mettre à jour le statut d'une plainte (admin)
     */
    public function updateStatus(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,processing,resolved,closed',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $complaint->status = $request->status;
        $complaint->admin_notes = $request->admin_notes;
        $complaint->resolved_at = $request->status === 'resolved' ? now() : null;
        $complaint->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Le statut de la plainte a été mis à jour avec succès.',
                'complaint' => $complaint
            ]);
        }

        return redirect()->back()->with('success', 'Le statut de la plainte a été mis à jour avec succès.');
    }

    /**
     * Mettre à jour les notes administratives d'une plainte (admin)
     */
    public function updateNotes(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'admin_notes' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $complaint->admin_notes = $request->admin_notes;
        $complaint->save();

        return response()->json([
            'success' => true,
            'message' => 'Les notes administratives ont été mises à jour avec succès.',
            'complaint' => $complaint
        ]);
    }

    /**
     * Supprimer une plainte (admin)
     */
    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->delete();

        return response()->json([
            'success' => true,
            'message' => 'La plainte a été supprimée avec succès.'
        ]);
    }
}
