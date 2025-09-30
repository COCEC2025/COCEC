<?php

namespace App\Http\Controllers;

use App\Interfaces\AccountInterface;
use App\Mail\AccountSubmissionMail;
use App\Models\MoralPersonSubmission;
use App\Models\PhysicalPersonSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;


class AccountController extends Controller
{
    private AccountInterface $accountInterface;

    public function __construct(AccountInterface $accountInterface)
    {
        $this->accountInterface = $accountInterface;
    }

    /**
     * Display a listing of physical person submissions.
     */
    public function indexPhysical(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = PhysicalPersonSubmission::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('last_name', 'like', "%{$search}%")
                    ->orWhere('first_names', 'like', "%{$search}%")
                    ->orWhere('account_number', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('statut', $status);
        }

        $submissions = $query->latest()->paginate(10);

        return view('admin.accounts.physical.index', compact('submissions', 'search', 'status'));
    }

    /**
     * Display the specified physical person submission.
     */
    public function showPhysical($id)
    {
        $submission = PhysicalPersonSubmission::with(['references', 'beneficiaries'])->findOrFail($id);
        return view('admin.accounts.physical.show', compact('submission'));
    }

    /**
     * Update the status of a physical person submission.
     */
    public function updatePhysical(Request $request, $id)
    {
        $validated = $request->validate([
            'statut' => 'required|in:en_attente,accepter,refuser',
            'account_number' => 'nullable|string|max:255',
            'membership_date' => 'nullable|date',
            'account_opening_date' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

        try {
            $submission = PhysicalPersonSubmission::findOrFail($id);
            $submission->update($validated);
            return back()->with('success', 'Statut mis à jour avec succès.');
        } catch (\Exception $e) {
            Log::error("Erreur de mise à jour du statut: {$e->getMessage()}");
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour.');
        }
    }

    /**
     * Generate a PDF for a physical person submission.
     */
    public function generatePhysicalPdf($id)
    {
        $submission = PhysicalPersonSubmission::with(['references', 'beneficiaries'])->findOrFail($id);

        $data = [
            'submission' => $submission,
        ];

        $pdf = Pdf::loadView('admin.accounts.physical.pdf', $data);

        $fileName = \App\Helpers\FileHelper::generatePdfFileName(
            'submission', 
            $submission->id, 
            $submission->first_name . ' ' . $submission->last_name
        );
        return $pdf->download($fileName);
    }

    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('main.account.create');
    }

    /**
     * Display a listing of all accounts for the secretary role.
     */
    public function indexAccounts()
    {
        // Récupérer les comptes physiques et moraux
        $physicalSubmissions = PhysicalPersonSubmission::latest()->take(5)->get();
        $moralSubmissions = MoralPersonSubmission::latest()->take(5)->get();

        // Statistiques
        $totalPhysical = PhysicalPersonSubmission::count();
        $totalMoral = MoralPersonSubmission::count();
        $pendingPhysical = PhysicalPersonSubmission::where('statut', 'en_attente')->count();
        $pendingMoral = MoralPersonSubmission::where('statut', 'en_attente')->count();

        return view('admin.accounts.index', compact(
            'physicalSubmissions',
            'moralSubmissions',
            'totalPhysical',
            'totalMoral',
            'pendingPhysical',
            'pendingMoral'
        ));
    }

    public function physic()
    {
        return view('main.account.physic');
    }

    public function morale()
    {
        return view('main.account.morale');
    }

    /**
     * Store a newly created resource in storage for Physical Person.
     */
    public function storePhysical(Request $request)
    {
        $mail = 'info@cocectogo.org';
        
        // Vérifier les champs honeypot (détection de bots)
        if ($request->filled('website_url') || $request->filled('phone_number')) {
            return back()->with('error', 'Soumission détectée comme spam.');
        }
        
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_names' => 'required|string|max:255',
            'gender' => 'required|in:M,F',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'category' => 'nullable|string|max:255',
            'marital_status' => 'required|string|max:255',
            'spouse_name' => 'nullable|string|max:255',
            'spouse_occupation' => 'nullable|string|max:255',
            'spouse_phone' => 'nullable|string|max:20',
            'spouse_address' => 'nullable|string',
            'occupation' => 'required|string|max:255',
            'company_name_activity' => 'nullable|string|max:255',
            'activity_type' => 'nullable|string|max:255',
            'activity_description' => 'nullable|string',
            'references' => 'required|array|min:1',
            'references.*.name' => 'required|string|max:255',
            'references.*.phone' => 'required|string|max:20',
            'loc_method_residence' => 'required|in:description,map',
            'residence_description' => 'required_if:loc_method_residence,description|nullable|string',
            'residence_lat' => 'required_if:loc_method_residence,map|nullable|numeric',
            'residence_lng' => 'required_if:loc_method_residence,map|nullable|numeric',
            'residence_plan_path' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:30720',
            'loc_method_workplace' => 'nullable|in:description,map',
            'workplace_description' => 'nullable|string',
            'workplace_lat' => 'nullable|numeric',
            'workplace_lng' => 'nullable|numeric',
            'workplace_plan_path' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:30720',
            'id_type' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
            'id_issue_date' => 'nullable|date',
            'photo_path' => 'required|file|image|mimes:jpeg,png,jpg|max:30720',
            'id_scan_path' => 'required|file|mimes:pdf|max:30720',
            'beneficiaries' => 'required|array|min:1',
            'beneficiaries.*.nom' => 'required|string|max:255',
            'beneficiaries.*.contact' => 'required|string|max:20',
            'beneficiaries.*.lien' => 'required|string|max:255',
            'beneficiaries.*.birth_date' => 'nullable|date',
            'signature_method' => 'required|in:draw,upload',
            'signature_data' => 'required_if:signature_method,draw|nullable|string',
            'signature_upload' => 'required_if:signature_method,upload|nullable|file|image|mimes:jpeg,png,jpg|max:30720',
            'initial_deposit' => 'required|numeric|min:0',
            'is_ppe_national' => 'required|boolean',
            'ppe_foreign' => 'required|in:0,1',
            'sanctions' => 'nullable|string|max:255',
            'terrorism_financing' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ], [
            'id_scan_path.mimes' => 'Le scan de la pièce doit être un fichier PDF.',
            'signature_data.required_if' => 'La signature dessinée est requise.',
            'signature_upload.required_if' => "L'import de la signature est requis.",
            'references.*.name.required' => 'Le nom de la référence est requis.',
            'references.*.phone.required' => 'Le téléphone de la référence est requis.',
            'beneficiaries.*.nom.required' => 'Le nom du bénéficiaire est requis.',
            'beneficiaries.*.contact.required' => 'Le contact du bénéficiaire est requis.',
            'beneficiaries.*.lien.required' => 'Le lien du bénéficiaire est requis.',
        ]);

        try {
            DB::beginTransaction();

            $photoPath = $request->file('photo_path')->store('photos/identite', 'public');
            $idScanPath = $request->file('id_scan_path')->store('scans/pieces', 'public');
            $residencePlanPath = $request->hasFile('residence_plan_path')
                ? $request->file('residence_plan_path')->store('plans/residence', 'public')
                : null;
            $workplacePlanPath = $request->hasFile('workplace_plan_path')
                ? $request->file('workplace_plan_path')->store('plans/workplace', 'public')
                : null;
            $signatureBase64 = $request->signature_method === 'draw' ? $request->signature_data : null;
            $signatureUploadPath = $request->signature_method === 'upload' && $request->hasFile('signature_upload')
                ? $request->file('signature_upload')->store('signatures', 'public')
                : null;

            $data = [
                'last_name' => $request->last_name,
                'first_names' => $request->first_names,
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
                'birth_place' => $request->birth_place,
                'nationality' => $request->nationality,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'phone' => $request->phone,
                'category' => $request->category,
                'marital_status' => $request->marital_status,
                'spouse_name' => $request->spouse_name,
                'spouse_occupation' => $request->spouse_occupation,
                'spouse_phone' => $request->spouse_phone,
                'spouse_address' => $request->spouse_address,
                'occupation' => $request->occupation,
                'company_name_activity' => $request->company_name_activity,
                'activity_type' => $request->activity_type,
                'activity_description' => $request->activity_description,
                'residence_description' => $request->loc_method_residence === 'description' ? $request->residence_description : null, // Change ici                
                'residence_lat' => $request->residence_lat,
                'residence_lng' => $request->residence_lng,

                'workplace_description' => $request->workplace_description ? $request->workplace_description : null,
                'workplace_lat' => $request->workplace_lat,
                'workplace_lng' => $request->workplace_lng,
                'residence_plan_path' => $residencePlanPath,
                'workplace_plan_path' => $workplacePlanPath,
                'id_type' => $request->id_type,
                'id_number' => $request->id_number,
                'id_issue_date' => $request->id_issue_date,
                'photo_path' => $photoPath,
                'id_scan_path' => $idScanPath,
                'signature_method' => $request->signature_method,
                'signature_base64' => $signatureBase64,
                'signature_upload_path' => $signatureUploadPath,
                'initial_deposit' => $request->initial_deposit,
                'is_ppe_national' => $request->is_ppe_national,
                'ppe_foreign' => $request->ppe_foreign,
                'sanctions' => $request->sanctions,
                'terrorism_financing' => $request->terrorism_financing,
                'remarks' => $request->remarks,
            ];

            $submission = PhysicalPersonSubmission::create($data);

            foreach ($request->references as $referenceData) {
                $submission->references()->create([
                    'name' => $referenceData['name'],
                    'phone' => $referenceData['phone'],
                ]);
            }

            foreach ($request->beneficiaries as $beneficiaryData) {
                $submission->beneficiaries()->create([
                    'nom' => $beneficiaryData['nom'],
                    'contact' => $beneficiaryData['contact'],
                    'lien' => $beneficiaryData['lien'],
                    'birth_date' => $beneficiaryData['birth_date'] ?? null,
                ]);
            }

            DB::commit();
            // Récupérer les références et bénéficiaires
            $references = $submission->references()->get();
            $beneficiaries = $submission->beneficiaries()->get();

            Mail::to($mail)->send(new AccountSubmissionMail($submission, $data, $references, $beneficiaries, 'physique'));
            return redirect()->route('account.create.physic')->with('success', "Votre demande d'ouverture de compte (Personne Physique) a été soumise avec succès !");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur de soumission (Physique): {$e->getMessage()} Ligne: {$e->getLine()} Fichier: {$e->getFile()}");
            return back()->withInput()->with('error', "Une erreur critique est survenue. L'administrateur a été notifié.");
        }
    }

    /**
     * Store a newly created resource in storage for Moral Person.
     */
    public function storeMoral(Request $request)
    {
        $mail = 'info@cocectogo.org';
        
        // Vérifier les champs honeypot (détection de bots)
        if ($request->filled('website_url') || $request->filled('phone_number')) {
            return back()->with('error', 'Soumission détectée comme spam.');
        }
        
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'company_id_type' => 'nullable|string|max:255',
            'company_id_number' => 'nullable|string|max:255',
            'company_id_date' => 'nullable|date',
            'creation_date' => 'required|date',
            'creation_place' => 'required|string|max:255',
            'activity_sector' => 'required|string|max:255',
            'activity_description' => 'nullable|string',
            'company_nationality' => 'required|string|max:255',
            'company_phone' => 'required|string|max:20',
            'company_postal_box' => 'nullable|string|max:255',
            'company_city' => 'nullable|string|max:255',
            'company_neighborhood' => 'nullable|string|max:255',
            'loc_method_company' => 'required|in:description,map',
            'company_address' => 'required_if:loc_method_company,description|nullable|string',
            'company_plan_path' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:30720',
            'company_lat' => 'required_if:loc_method_company,map|nullable|numeric',
            'company_lng' => 'required_if:loc_method_company,map|nullable|numeric',
            'director_name' => 'required|string|max:255',
            'director_first_name' => 'nullable|string|max:255',
            'director_position' => 'required|string|max:255',
            'director_gender' => 'required|in:M,F',
            'director_nationality' => 'required|string|max:255',
            'director_birth_date' => 'required|date',
            'director_birth_place' => 'required|string|max:255',
            'director_id_number' => 'required|string|max:255',
            'director_id_issue_date' => 'nullable|date',
            'director_phone' => 'required|string|max:20',
            'director_father_name' => 'nullable|string|max:255',
            'director_mother_name' => 'nullable|string|max:255',
            'director_postal_box' => 'nullable|string|max:255',
            'director_city' => 'nullable|string|max:255',
            'director_neighborhood' => 'nullable|string|max:255',
            'director_address' => 'nullable|string',
            'director_spouse_name' => 'nullable|string|max:255',
            'director_spouse_occupation' => 'nullable|string|max:255',
            'director_spouse_phone' => 'nullable|string|max:20',
            'director_spouse_address' => 'nullable|string',
            'minutes_members' => 'required|string|max:255',
            'minutes_meeting' => 'required|string|max:255',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'emergency_contact_address' => 'nullable|string',
            'co_directors' => 'nullable|array',
            'co_directors.*.name' => 'required_with:co_directors|string|max:255',
            'co_directors.*.first_name' => 'nullable|string|max:255',
            'co_directors.*.gender' => 'required_with:co_directors|in:M,F',
            'co_directors.*.nationality' => 'required_with:co_directors|string|max:255',
            'co_directors.*.birth_date' => 'required_with:co_directors|date',
            'co_directors.*.birth_place' => 'required_with:co_directors|string|max:255',
            'co_directors.*.id_number' => 'required_with:co_directors|string|max:255',
            'co_directors.*.id_issue_date' => 'nullable|date',
            'co_directors.*.postal_box' => 'nullable|string|max:255',
            'co_directors.*.city' => 'nullable|string|max:255',
            'co_directors.*.neighborhood' => 'nullable|string|max:255',
            'co_directors.*.address' => 'nullable|string',
            'co_directors.*.phone' => 'required_with:co_directors|string|max:20',
            'account_signatories' => 'required|array|min:2',
            'account_signatories.*.name' => 'required|string|max:255',
            'account_signatories.*.signature_type' => 'required|in:unique,conjointe',
            'account_signatories.*.id_number' => 'nullable|string|max:255',
            'company_document_path' => 'required|file|mimes:pdf|max:30720',
            'responsible_persons_photo_path' => 'required|file|image|mimes:jpeg,png,jpg|max:30720',
            'signature_method' => 'required|in:draw,upload',
            'signature_data' => 'required_if:signature_method,draw|nullable|string',
            'signature_upload' => 'required_if:signature_method,upload|nullable|file|image|mimes:jpeg,png,jpg|max:30720',
            'beneficiaries' => 'required|array|min:1',
            'beneficiaries.*.nom' => 'required|string|max:255',
            'beneficiaries.*.contact' => 'required|string|max:20',
            'beneficiaries.*.lien' => 'required|string|max:255',
            'beneficiaries.*.birth_date' => 'nullable|date',
            'initial_deposit' => 'required|numeric|min:0',
            'membership_date' => 'nullable|date',
            'account_number' => 'nullable|string|max:255',
            'account_opening_date' => 'nullable|date',
            'is_ppe_national' => 'required|boolean',
            'ppe_foreign' => 'nullable|string|required_if:is_ppe_national,false|max:255',
            'sanctions' => 'nullable|string|max:255',
            'terrorism_financing' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ], [
            'company_document_path.mimes' => 'Le document de l’entreprise doit être un fichier PDF.',
            'responsible_persons_photo_path.mimes' => 'La photo des responsables doit être une image (JPEG, PNG, JPG).',
            'signature_data.required_if' => 'La signature dessinée est requise.',
            'signature_upload.required_if' => "L'import de la signature est requis.",
            'account_signatories.*.name.required' => 'Le nom du signataire est requis.',
            'account_signatories.*.signature_type.required' => 'Le type de signature est requis.',
        ]);

        try {
            DB::beginTransaction();

            $companyDocumentPath = $request->file('company_document_path')->store('documents/company', 'public');
            $responsiblePersonsPhotoPath = $request->file('responsible_persons_photo_path')->store('photos/responsible_persons', 'public');
            $companyPlanPath = $request->hasFile('company_plan_path')
                ? $request->file('company_plan_path')->store('plans/company', 'public')
                : null;
            $signatureBase64 = $request->signature_method === 'draw' ? $request->signature_data : null;
            $signatureUploadPath = $request->signature_method === 'upload' && $request->hasFile('signature_upload')
                ? $request->file('signature_upload')->store('signatures', 'public')
                : null;

            $data = [
                'company_name' => $request->company_name,
                'category' => $request->category,
                'rccm' => $request->rccm,
                'company_id_type' => $request->company_id_type,
                'company_id_number' => $request->company_id_number,
                'company_id_date' => $request->company_id_date,
                'creation_date' => $request->creation_date,
                'creation_place' => $request->creation_place,
                'activity_sector' => $request->activity_sector,
                'activity_description' => $request->activity_description,
                'company_nationality' => $request->company_nationality,
                'company_phone' => $request->company_phone,
                'company_postal_box' => $request->company_postal_box,
                'company_city' => $request->company_city,
                'company_neighborhood' => $request->company_neighborhood,
                'company_address' => $request->loc_method_company === 'description' ? $request->company_address : null,
                'company_plan_path' => $companyPlanPath,
                'company_lat' => $request->company_lat,
                'company_lng' => $request->company_lng,
                'director_name' => $request->director_name,
                'director_first_name' => $request->director_first_name,
                'director_position' => $request->director_position,
                'director_gender' => $request->director_gender,
                'director_nationality' => $request->director_nationality,
                'director_birth_date' => $request->director_birth_date,
                'director_birth_place' => $request->director_birth_place,
                'director_id_number' => $request->director_id_number,
                'director_id_issue_date' => $request->director_id_issue_date,
                'director_phone' => $request->director_phone,
                'director_father_name' => $request->director_father_name,
                'director_mother_name' => $request->director_mother_name,
                'director_postal_box' => $request->director_postal_box,
                'director_city' => $request->director_city,
                'director_neighborhood' => $request->director_neighborhood,
                'director_address' => $request->director_address,
                'director_spouse_name' => $request->director_spouse_name,
                'director_spouse_occupation' => $request->director_spouse_occupation,
                'director_spouse_phone' => $request->director_spouse_phone,
                'director_spouse_address' => $request->director_spouse_address,
                'minutes_members' => $request->minutes_members,
                'minutes_meeting' => $request->minutes_meeting,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'emergency_contact_address' => $request->emergency_contact_address,
                'company_document_path' => $companyDocumentPath,
                'responsible_persons_photo_path' => $responsiblePersonsPhotoPath,
                'signature_method' => $request->signature_method,
                'signature_base64' => $signatureBase64,
                'signature_upload_path' => $signatureUploadPath,
                'initial_deposit' => $request->initial_deposit,
                'membership_date' => $request->membership_date,
                'account_number' => $request->account_number,
                'account_opening_date' => $request->account_opening_date,
                'is_ppe_national' => $request->is_ppe_national,
                'ppe_foreign' => $request->ppe_foreign,
                'sanctions' => $request->sanctions,
                'terrorism_financing' => $request->terrorism_financing,
                'remarks' => $request->remarks,
            ];

            $submission = MoralPersonSubmission::create($data);

            if ($request->has('co_directors')) {
                foreach ($request->co_directors as $coDirectorData) {
                    $submission->coDirectors()->create($coDirectorData);
                }
            }

            foreach ($request->account_signatories as $signatoryData) {
                $submission->accountSignatories()->create([
                    'name' => $signatoryData['name'],
                    'signature_type' => $signatoryData['signature_type'],
                    'id_number' => $signatoryData['id_number'] ?? null,
                ]);
            }

            foreach ($request->beneficiaries as $beneficiaryData) {
                $submission->beneficiaries()->create([
                    'nom' => $beneficiaryData['nom'],
                    'contact' => $beneficiaryData['contact'],
                    'lien' => $beneficiaryData['lien'],
                    'birth_date' => $beneficiaryData['birth_date'] ?? null,
                ]);
            }

            DB::commit();

            // Récupérer les références et bénéficiaires
            $references = collect(); // Pas de références pour les personnes morales
            $beneficiaries = $submission->beneficiaries()->get();

            Mail::to($mail)->send(new AccountSubmissionMail($submission, $data, $references, $beneficiaries, 'morale'));
            return back()->with('success', "Votre demande d'ouverture de compte (Personne Morale) a été soumise avec succès !");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur de soumission (Morale): {$e->getMessage()} Ligne: {$e->getLine()} Fichier: {$e->getFile()}");
            return back()->withInput()->with('error', "Une erreur critique est survenue. L'administrateur a été notifié.");
        }
    }

    /**
     * Update an existing Physical Person submission.
     */
    public function editPhysical(Request $request, $id)
    {
        $submission = PhysicalPersonSubmission::findOrFail($id);

        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_names' => 'required|string|max:255',
            'gender' => 'required|in:M,F',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'category' => 'nullable|string|max:255',
            'marital_status' => 'required|string|max:255',
            'spouse_name' => 'nullable|string|max:255',
            'spouse_occupation' => 'nullable|string|max:255',
            'spouse_phone' => 'nullable|string|max:20',
            'spouse_address' => 'nullable|string',
            'occupation' => 'required|string|max:255',
            'company_name_activity' => 'nullable|string|max:255',
            'activity_type' => 'nullable|string|max:255',
            'activity_description' => 'nullable|string',
            'references' => 'required|array|min:1',
            'references.*.name' => 'required|string|max:255',
            'references.*.phone' => 'required|string|max:20',
            'loc_method_residence' => 'required|in:description,map',
            'residence_description' => 'required_if:loc_method_residence,description|nullable|string',
            'residence_lat' => 'required_if:loc_method_residence,map|nullable|numeric',
            'residence_lng' => 'required_if:loc_method_residence,map|nullable|numeric',
            'residence_plan_path' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:30720',
            'loc_method_workplace' => 'nullable|in:description,map',
            'workplace_description' => 'nullable|string',
            'workplace_lat' => 'nullable|numeric',
            'workplace_lng' => 'nullable|numeric',
            'workplace_plan_path' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:30720',
            'id_type' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
            'id_issue_date' => 'nullable|date',
            'photo_path' => 'nullable|file|image|mimes:jpeg,png,jpg|max:30720',
            'id_scan_path' => 'nullable|file|mimes:pdf|max:30720',
            'beneficiaries' => 'required|array|min:1',
            'beneficiaries.*.nom' => 'required|string|max:255',
            'beneficiaries.*.contact' => 'required|string|max:20',
            'beneficiaries.*.lien' => 'required|string|max:255',
            'beneficiaries.*.birth_date' => 'nullable|date',
            'signature_method' => 'required|in:draw,upload',
            'signature_data' => 'required_if:signature_method,draw|nullable|string',
            'signature_upload' => 'required_if:signature_method,upload|nullable|file|image|mimes:jpeg,png,jpg|max:30720',
            'initial_deposit' => 'required|numeric|min:0',
            'membership_date' => 'nullable|date',
            'account_number' => 'nullable|string|max:255',
            'account_opening_date' => 'nullable|date',
            'is_ppe_national' => 'required|boolean',
            'ppe_foreign' => 'nullable|string|required_if:is_ppe_national,false|max:255',
            'sanctions' => 'nullable|string|max:255',
            'terrorism_financing' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ], [
            'id_scan_path.mimes' => 'Le scan de la pièce doit être un fichier PDF.',
            'signature_data.required_if' => 'La signature dessinée est requise.',
            'signature_upload.required_if' => "L'import de la signature est requis.",
            'references.*.name.required' => 'Le nom de la référence est requis.',
            'references.*.phone.required' => 'Le téléphone de la référence est requis.',
            'beneficiaries.*.nom.required' => 'Le nom du bénéficiaire est requis.',
            'beneficiaries.*.contact.required' => 'Le contact du bénéficiaire est requis.',
            'beneficiaries.*.lien.required' => 'Le lien du bénéficiaire est requis.',
        ]);

        try {
            DB::beginTransaction();

            $photoPath = $request->hasFile('photo_path')
                ? $request->file('photo_path')->store('photos/identite', 'public')
                : $submission->photo_path;
            $idScanPath = $request->hasFile('id_scan_path')
                ? $request->file('id_scan_path')->store('scans/pieces', 'public')
                : $submission->id_scan_path;
            $residencePlanPath = $request->hasFile('residence_plan_path')
                ? $request->file('residence_plan_path')->store('plans/residence', 'public')
                : $submission->residence_plan_path;
            $workplacePlanPath = $request->hasFile('workplace_plan_path')
                ? $request->file('workplace_plan_path')->store('plans/workplace', 'public')
                : $submission->workplace_plan_path;
            $signatureBase64 = $request->signature_method === 'draw'
                ? $request->signature_data
                : ($request->signature_method === 'upload' ? null : $submission->signature_base64);
            $signatureUploadPath = $request->signature_method === 'upload' && $request->hasFile('signature_upload')
                ? $request->file('signature_upload')->store('signatures', 'public')
                : ($request->signature_method === 'draw' ? null : $submission->signature_upload_path);

            $data = [
                'last_name' => $request->last_name,
                'first_names' => $request->first_names,
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
                'birth_place' => $request->birth_place,
                'nationality' => $request->nationality,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'phone' => $request->phone,
                'category' => $request->category,
                'marital_status' => $request->marital_status,
                'spouse_name' => $request->spouse_name,
                'spouse_occupation' => $request->spouse_occupation,
                'spouse_phone' => $request->spouse_phone,
                'spouse_address' => $request->spouse_address,
                'occupation' => $request->occupation,
                'company_name_activity' => $request->company_name_activity,
                'activity_type' => $request->activity_type,
                'activity_description' => $request->activity_description,
                'residence_description' => $request->loc_method_residence === 'description' ? $request->residence_description : 'Adresse via carte',
                'residence_lat' => $request->residence_lat,
                'residence_lng' => $request->residence_lng,
                'workplace_description' => $request->loc_method_workplace === 'description' ? $request->workplace_description : 'Adresse via carte',
                'workplace_lat' => $request->workplace_lat,
                'workplace_lng' => $request->workplace_lng,
                'residence_plan_path' => $residencePlanPath,
                'workplace_plan_path' => $workplacePlanPath,
                'id_type' => $request->id_type,
                'id_number' => $request->id_number,
                'id_issue_date' => $request->id_issue_date,
                'photo_path' => $photoPath,
                'id_scan_path' => $idScanPath,
                'signature_method' => $request->signature_method,
                'signature_base64' => $signatureBase64,
                'signature_upload_path' => $signatureUploadPath,
                'initial_deposit' => $request->initial_deposit,
                'membership_date' => $request->membership_date,
                'account_number' => $request->account_number,
                'account_opening_date' => $request->account_opening_date,
                'is_ppe_national' => $request->is_ppe_national,
                'ppe_foreign' => $request->ppe_foreign,
                'sanctions' => $request->sanctions,
                'terrorism_financing' => $request->terrorism_financing,
                'remarks' => $request->remarks,
            ];

            $submission->update($data);

            $submission->references()->delete();
            foreach ($request->references as $referenceData) {
                $submission->references()->create([
                    'name' => $referenceData['name'],
                    'phone' => $referenceData['phone'],
                ]);
            }

            $submission->beneficiaries()->delete();
            foreach ($request->beneficiaries as $beneficiaryData) {
                $submission->beneficiaries()->create([
                    'nom' => $beneficiaryData['nom'],
                    'contact' => $beneficiaryData['contact'],
                    'lien' => $beneficiaryData['lien'],
                    'birth_date' => $beneficiaryData['birth_date'] ?? null,
                ]);
            }

            DB::commit();
            return back()->with('success', "Votre demande d'ouverture de compte (Personne Physique) a été mise à jour avec succès !");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur de mise à jour (Physique): {$e->getMessage()} Ligne: {$e->getLine()} Fichier: {$e->getFile()}");
            return back()->withInput()->with('error', "Une erreur critique est survenue. L'administrateur a été notifié.");
        }
    }

    /**
     * Update an existing Moral Person submission.
     */
    public function editMoral(Request $request, $id)
    {
        $submission = MoralPersonSubmission::findOrFail($id);

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'company_id_type' => 'nullable|string|max:255',
            'company_id_number' => 'nullable|string|max:255',
            'company_id_date' => 'nullable|date',
            'creation_date' => 'required|date',
            'creation_place' => 'required|string|max:255',
            'activity_sector' => 'required|string|max:255',
            'activity_description' => 'nullable|string',
            'company_nationality' => 'required|string|max:255',
            'company_phone' => 'required|string|max:20',
            'company_postal_box' => 'nullable|string|max:255',
            'company_city' => 'nullable|string|max:255',
            'company_neighborhood' => 'nullable|string|max:255',
            'loc_method_company' => 'required|in:description,map',
            'company_address' => 'required_if:loc_method_company,description|nullable|string',
            'company_plan_path' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:30720',
            'company_lat' => 'required_if:loc_method_company,map|nullable|numeric',
            'company_lng' => 'required_if:loc_method_company,map|nullable|numeric',
            'director_name' => 'required|string|max:255',
            'director_first_name' => 'nullable|string|max:255',
            'director_position' => 'required|string|max:255',
            'director_gender' => 'required|in:M,F',
            'director_nationality' => 'required|string|max:255',
            'director_birth_date' => 'required|date',
            'director_birth_place' => 'required|string|max:255',
            'director_id_number' => 'required|string|max:255',
            'director_id_issue_date' => 'nullable|date',
            'director_phone' => 'required|string|max:20',
            'director_father_name' => 'nullable|string|max:255',
            'director_mother_name' => 'nullable|string|max:255',
            'director_postal_box' => 'nullable|string|max:255',
            'director_city' => 'nullable|string|max:255',
            'director_neighborhood' => 'nullable|string|max:255',
            'director_address' => 'nullable|string',
            'director_spouse_name' => 'nullable|string|max:255',
            'director_spouse_occupation' => 'nullable|string|max:255',
            'director_spouse_phone' => 'nullable|string|max:20',
            'director_spouse_address' => 'nullable|string',
            'minutes_members' => 'required|string|max:255',
            'minutes_meeting' => 'required|string|max:255',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'emergency_contact_address' => 'nullable|string',
            'co_directors' => 'nullable|array',
            'co_directors.*.name' => 'required_with:co_directors|string|max:255',
            'co_directors.*.first_name' => 'nullable|string|max:255',
            'co_directors.*.gender' => 'required_with:co_directors|in:M,F',
            'co_directors.*.nationality' => 'required_with:co_directors|string|max:255',
            'co_directors.*.birth_date' => 'required_with:co_directors|date',
            'co_directors.*.birth_place' => 'required_with:co_directors|string|max:255',
            'co_directors.*.id_number' => 'required_with:co_directors|string|max:255',
            'co_directors.*.id_issue_date' => 'nullable|date',
            'co_directors.*.postal_box' => 'nullable|string|max:255',
            'co_directors.*.city' => 'nullable|string|max:255',
            'co_directors.*.neighborhood' => 'nullable|string|max:255',
            'co_directors.*.address' => 'nullable|string',
            'co_directors.*.phone' => 'required_with:co_directors|string|max:20',
            'account_signatories' => 'required|array|min:2',
            'account_signatories.*.name' => 'required|string|max:255',
            'account_signatories.*.signature_type' => 'required|in:unique,conjointe',
            'account_signatories.*.id_number' => 'nullable|string|max:255',
            'company_document_path' => 'nullable|file|mimes:pdf|max:30720',
            'responsible_persons_photo_path' => 'nullable|file|image|mimes:jpeg,png,jpg|max:30720',
            'signature_method' => 'required|in:draw,upload',
            'signature_data' => 'required_if:signature_method,draw|nullable|string',
            'signature_upload' => 'required_if:signature_method,upload|nullable|file|image|mimes:jpeg,png,jpg|max:30720',
            'beneficiaries' => 'required|array|min:1',
            'beneficiaries.*.nom' => 'required|string|max:255',
            'beneficiaries.*.contact' => 'required|string|max:20',
            'beneficiaries.*.lien' => 'required|string|max:255',
            'beneficiaries.*.birth_date' => 'nullable|date',
            'initial_deposit' => 'required|numeric|min:0',
            'membership_date' => 'nullable|date',
            'account_number' => 'nullable|string|max:255',
            'account_opening_date' => 'nullable|date',
            'is_ppe_national' => 'required|boolean',
            'ppe_foreign' => 'nullable|string|required_if:is_ppe_national,false|max:255',
            'sanctions' => 'nullable|string|max:255',
            'terrorism_financing' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ], [
            'company_document_path.mimes' => 'Le document de l’entreprise doit être un fichier PDF.',
            'responsible_persons_photo_path.mimes' => 'La photo des responsables doit être une image (JPEG, PNG, JPG).',
            'signature_data.required_if' => 'La signature dessinée est requise.',
            'signature_upload.required_if' => "L'import de la signature est requis.",
            'account_signatories.*.name.required' => 'Le nom du signataire est requis.',
            'account_signatories.*.signature_type.required' => 'Le type de signature est requis.',
        ]);

        try {
            DB::beginTransaction();

            $companyDocumentPath = $request->hasFile('company_document_path')
                ? $request->file('company_document_path')->store('documents/company', 'public')
                : $submission->company_document_path;
            $responsiblePersonsPhotoPath = $request->hasFile('responsible_persons_photo_path')
                ? $request->file('responsible_persons_photo_path')->store('photos/responsible_persons', 'public')
                : $submission->responsible_persons_photo_path;
            $companyPlanPath = $request->hasFile('company_plan_path')
                ? $request->file('company_plan_path')->store('plans/company', 'public')
                : $submission->company_plan_path;
            $signatureBase64 = $request->signature_method === 'draw'
                ? $request->signature_data
                : ($request->signature_method === 'upload' ? null : $submission->signature_base64);
            $signatureUploadPath = $request->signature_method === 'upload' && $request->hasFile('signature_upload')
                ? $request->file('signature_upload')->store('signatures', 'public')
                : ($request->signature_method === 'draw' ? null : $submission->signature_upload_path);

            $data = [
                'company_name' => $request->company_name,
                'category' => $request->category,
                'rccm' => $request->rccm,
                'company_id_type' => $request->company_id_type,
                'company_id_number' => $request->company_id_number,
                'company_id_date' => $request->company_id_date,
                'creation_date' => $request->creation_date,
                'creation_place' => $request->creation_place,
                'activity_sector' => $request->activity_sector,
                'activity_description' => $request->activity_description,
                'company_nationality' => $request->company_nationality,
                'company_phone' => $request->company_phone,
                'company_postal_box' => $request->company_postal_box,
                'company_city' => $request->company_city,
                'company_neighborhood' => $request->company_neighborhood,
                'company_address' => $request->loc_method_company === 'description' ? $request->company_address : null,
                'company_plan_path' => $companyPlanPath,
                'company_lat' => $request->company_lat,
                'company_lng' => $request->company_lng,
                'director_name' => $request->director_name,
                'director_first_name' => $request->director_first_name,
                'director_position' => $request->director_position,
                'director_gender' => $request->director_gender,
                'director_nationality' => $request->director_nationality,
                'director_birth_date' => $request->director_birth_date,
                'director_birth_place' => $request->director_birth_place,
                'director_id_number' => $request->director_id_number,
                'director_id_issue_date' => $request->director_id_issue_date,
                'director_phone' => $request->director_phone,
                'director_father_name' => $request->director_father_name,
                'director_mother_name' => $request->director_mother_name,
                'director_postal_box' => $request->director_postal_box,
                'director_city' => $request->director_city,
                'director_neighborhood' => $request->director_neighborhood,
                'director_address' => $request->director_address,
                'director_spouse_name' => $request->director_spouse_name,
                'director_spouse_occupation' => $request->director_spouse_occupation,
                'director_spouse_phone' => $request->director_spouse_phone,
                'director_spouse_address' => $request->director_spouse_address,
                'minutes_members' => $request->minutes_members,
                'minutes_meeting' => $request->minutes_meeting,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'emergency_contact_address' => $request->emergency_contact_address,
                'company_document_path' => $companyDocumentPath,
                'responsible_persons_photo_path' => $responsiblePersonsPhotoPath,
                'signature_method' => $request->signature_method,
                'signature_base64' => $signatureBase64,
                'signature_upload_path' => $signatureUploadPath,
                'initial_deposit' => $request->initial_deposit,
                'membership_date' => $request->membership_date,
                'account_number' => $request->account_number,
                'account_opening_date' => $request->account_opening_date,
                'is_ppe_national' => $request->is_ppe_national,
                'ppe_foreign' => $request->ppe_foreign,
                'sanctions' => $request->sanctions,
                'terrorism_financing' => $request->terrorism_financing,
                'remarks' => $request->remarks,
            ];

            $submission->update($data);

            $submission->coDirectors()->delete();
            if ($request->has('co_directors')) {
                foreach ($request->co_directors as $coDirectorData) {
                    $submission->coDirectors()->create($coDirectorData);
                }
            }

            $submission->accountSignatories()->delete();
            foreach ($request->account_signatories as $signatoryData) {
                $submission->accountSignatories()->create([
                    'name' => $signatoryData['name'],
                    'signature_type' => $signatoryData['signature_type'],
                    'id_number' => $signatoryData['id_number'] ?? null,
                ]);
            }

            $submission->beneficiaries()->delete();
            foreach ($request->beneficiaries as $beneficiaryData) {
                $submission->beneficiaries()->create([
                    'nom' => $beneficiaryData['nom'],
                    'contact' => $beneficiaryData['contact'],
                    'lien' => $beneficiaryData['lien'],
                    'birth_date' => $beneficiaryData['birth_date'] ?? null,
                ]);
            }

            DB::commit();
            return redirect()->route('account.create.morale')->with('success', "Votre demande d'ouverture de compte (Personne Morale) a été mise à jour avec succès !");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur de mise à jour (Morale): {$e->getMessage()} Ligne: {$e->getLine()} Fichier: {$e->getFile()}");
            return back()->withInput()->with('error', "Une erreur critique est survenue. L'administrateur a été notifié.");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Display a listing of moral person submissions.
     */
    public function indexMoral(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = MoralPersonSubmission::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                    ->orWhere('director_name', 'like', "%{$search}%")
                    ->orWhere('account_number', 'like', "%{$search}%")
                    ->orWhere('rccm', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('statut', $status);
        }

        $submissions = $query->latest()->paginate(10);

        return view('admin.accounts.moral.index', compact('submissions', 'search', 'status'));
    }

    /**
     * Display the specified moral person submission.
     */
    public function showMoral($id)
    {
        $submission = MoralPersonSubmission::with(['coDirectors', 'accountSignatories', 'beneficiaries'])->findOrFail($id);
        return view('admin.accounts.moral.show', compact('submission'));
    }

    /**
     * Update the status of a moral person submission.
     */
    public function updateMoral(Request $request, $id)
    {
        $validated = $request->validate([
            'statut' => 'required|in:en_attente,accepter,refuser',
            'account_number' => 'nullable|string|max:255',
            'membership_date' => 'nullable|date',
            'account_opening_date' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

        try {
            $submission = MoralPersonSubmission::findOrFail($id);
            $submission->update($validated);
            return back()->with('success', 'Statut mis à jour avec succès.');
        } catch (\Exception $e) {
            Log::error("Erreur de mise à jour du statut moral: {$e->getMessage()}");
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour.');
        }
    }

    /**
     * Generate a PDF for a moral person submission.
     */
    public function generateMoralPdf($id)
    {
        $submission = MoralPersonSubmission::with(['coDirectors', 'accountSignatories', 'beneficiaries'])->findOrFail($id);

        $data = [
            'submission' => $submission,
        ];

        $pdf = Pdf::loadView('admin.accounts.moral.pdf', $data);

        $fileName = \App\Helpers\FileHelper::generatePdfFileName(
            'moral_submission', 
            $submission->id, 
            $submission->company_name
        );
        return $pdf->download($fileName);
    }
}
