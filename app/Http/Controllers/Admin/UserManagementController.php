<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use App\Mail\NewAccountMail;
use Illuminate\Support\Facades\Log;

class UserManagementController extends Controller
{
    public function __construct()
    {
        // Pas de middleware dans le constructeur pour Laravel 11
    }

    /**
     * Vérifier les permissions avant chaque action
     */
    private function checkPermissions()
    {
        if (!auth()->user() || !auth()->user()->canCreateAccounts()) {
            abort(403, 'Accès non autorisé');
        }
    }

    /**
     * Display a listing of users
     */
    public function index()
    {
        $this->checkPermissions();
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $this->checkPermissions();
        $roles = UserRole::cases();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $this->checkPermissions();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string', 'in:' . implode(',', array_column(UserRole::cases(), 'value'))],
            'phone_num' => ['nullable', 'string', 'max:20'],
        ]);

        // Générer un mot de passe aléatoire
        $password = Str::random(12);
        
        // Créer l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => $request->role,
            'phone_num' => $request->phone_num,
        ]);

        // Envoyer l'email avec les identifiants
        $this->sendCredentialsEmail($user, $password);

        return redirect()->route('admin.users.index')
            ->with('success', 'Compte créé avec succès. Les identifiants ont été envoyés par email.');
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        $this->checkPermissions();
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        $this->checkPermissions();
        $roles = UserRole::cases();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $this->checkPermissions();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:' . implode(',', array_column(UserRole::cases(), 'value'))],
            'phone_num' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone_num' => $request->phone_num,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        $this->checkPermissions();
        // Empêcher la suppression de son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Reset user password
     */
    public function resetPassword(User $user)
    {
        $this->checkPermissions();
        $password = Str::random(12);
        
        $user->update([
            'password' => Hash::make($password)
        ]);

        // Envoyer le nouveau mot de passe par email
        $this->sendCredentialsEmail($user, $password);

        return redirect()->route('admin.users.index')
            ->with('success', 'Mot de passe réinitialisé et envoyé par email.');
    }

    /**
     * Send credentials email to user
     */
    private function sendCredentialsEmail(User $user, string $password)
    {
        try {
            // Envoyer l'email avec les identifiants
            Mail::to($user->email)->send(new NewAccountMail(
                $user->email,
                $user->name,
                $password,
                $user->phone_num,
                $user->role->getLabel()
            ));

            Log::info("Email envoyé avec succès pour {$user->email}");
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de l'email pour {$user->email}: " . $e->getMessage());
            
            // En cas d'erreur, on log quand même les identifiants
            Log::info("Nouveau compte créé pour {$user->email}", [
                'email' => $user->email,
                'password' => $password,
                'role' => $user->role->getLabel()
            ]);
        }
    }

    /**
     * Suspend a user account
     */
    public function suspend(Request $request, User $user)
    {
        $this->checkPermissions();
        
        // Ne pas permettre de suspendre son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas suspendre votre propre compte.');
        }

        $request->validate([
            'suspension_reason' => 'nullable|string|max:500',
        ], [
            'suspension_reason.max' => 'La raison ne peut pas dépasser 500 caractères.',
        ]);

        $user->suspend($request->suspension_reason);

        return redirect()->back()->with('success', "Le compte de {$user->name} a été suspendu avec succès.");
    }

    /**
     * Unsuspend a user account
     */
    public function unsuspend(User $user)
    {
        $this->checkPermissions();
        
        $user->unsuspend();

        return redirect()->back()->with('success', "Le compte de {$user->name} a été réactivé avec succès.");
    }

    /**
     * Toggle suspension status
     */
    public function toggleSuspension(Request $request, User $user)
    {
        $this->checkPermissions();
        
        // Ne pas permettre de suspendre son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas suspendre votre propre compte.');
        }

        if ($user->isSuspended()) {
            $user->unsuspend();
            $message = "Le compte de {$user->name} a été réactivé avec succès.";
        } else {
            $request->validate([
                'suspension_reason' => 'nullable|string|max:500',
            ], [
                'suspension_reason.max' => 'La raison ne peut pas dépasser 500 caractères.',
            ]);

            $user->suspend($request->suspension_reason);
            $message = "Le compte de {$user->name} a été suspendu avec succès.";
        }

        return redirect()->back()->with('success', $message);
    }
}
