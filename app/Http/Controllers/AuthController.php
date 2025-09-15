<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Interfaces\AuthInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Str;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{

    private AuthInterface $authInterface;
    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function register(RegistrationRequest $registrationRequest)
    {

        $password = Str::random(10); 
        
        $data = [
            "email" => $registrationRequest->email,
            "name" => $registrationRequest->name,
            "password" => $password,
            "phone_num" => $registrationRequest->phoneNum,
            "passwordConfirm" => $registrationRequest->passwordConfirm,
        ];

   

        DB::beginTransaction();

        try {

            $user = $this->authInterface->register($data);

            DB::commit();

            Mail::to($registrationRequest->email)->send(new NewAccountMail($registrationRequest->email, $registrationRequest->name, $password, $registrationRequest->phoneNum));

            return $user;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Erreur lors de la création de l'utilisateur: " . $th->getMessage());
            return false;
        }
    }


    public function login(LoginRequest $loginRequest)
    {
        $data = [
            'email' => $loginRequest->email,
            'password' => $loginRequest->password,
        ];

        DB::beginTransaction();

        try {
            $result = $this->authInterface->login($data);

            DB::commit();

            if (!$result) {
                return back()->with('error', 'Email ou mot de passe incorrect(s).');
            }

            // Redirection selon le rôle de l'utilisateur
            $user = auth()->user();
            $dashboardRoute = $user->getDashboardRoute();
            
            return redirect()->route($dashboardRoute)->with('success', 'Connexion réussie.');
        } catch (\Throwable $th) {

            DB::rollBack();
            return false;
        }
    }

    public function logout()
    {
        $result = $this->authInterface->logout();
        if ($result) {
            return redirect()->route('index')->with('success', 'Déconnexion réussie.');
        }
        return back()->with('error', 'Déconnexion échouée.');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
     * Display the admin profile page.
     */
    public function profile()
    {
        // Vérifier que l'utilisateur est authentifié
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à votre profil.');
        }

        $user = auth()->user();
        
        // Vérifier que l'utilisateur existe toujours en base
        if (!$user) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Session expirée. Veuillez vous reconnecter.');
        }

        return view('admin.profile.index', compact('user'));
    }

    /**
     * Update the admin profile information.
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone_num' => 'nullable|string|max:20',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
        ]);

        try {
            $user = auth()->user();
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_num' => $request->phone_num,
            ]);

            return back()->with('success', 'Profil mis à jour avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour.');
        }
    }

    /**
     * Update the admin password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Le mot de passe actuel est obligatoire.',
            'password.required' => 'Le nouveau mot de passe est obligatoire.',
            'password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        try {
            $user = auth()->user();
            
            // Vérifier le mot de passe actuel
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
            }
            
            // Mettre à jour le mot de passe
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return back()->with('success', 'Mot de passe mis à jour avec succès.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Erreur lors de la mise à jour du mot de passe.');
        }
    }

    /**
     * Update the admin profile image.
     */
    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'profile_image.required' => 'Veuillez sélectionner une image.',
            'profile_image.image' => 'Le fichier doit être une image.',
            'profile_image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG ou GIF.',
            'profile_image.max' => 'L\'image ne doit pas dépasser 2MB.',
        ]);

        try {
            $user = auth()->user();
            
            // Supprimer l'ancienne image si elle existe
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }
            
            // Stocker la nouvelle image
            $imagePath = $request->file('profile_image')->store('profile-images', 'public');
            
            // Mettre à jour le profil
            $user->update([
                'profile_image' => $imagePath
            ]);

            return back()->with('success', 'Photo de profil mise à jour avec succès.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Erreur lors de la mise à jour de la photo de profil.');
        }
    }
}
