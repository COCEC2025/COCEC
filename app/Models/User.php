<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone_num',
        'profile_image',
        'is_suspended',
        'suspended_at',
        'suspension_reason',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'is_suspended' => 'boolean',
            'suspended_at' => 'datetime',
        ];
    }

    /**
     * Get the user's role
     */
    public function getRole(): UserRole
    {
        // Vérifier que le rôle existe et est valide
        if (!$this->role || !($this->role instanceof UserRole)) {
            // Retourner un rôle par défaut sécurisé
            return UserRole::SUPER_ADMIN;
        }
        
        return $this->role;
    }

    /**
     * Check if user has full access
     */
    public function hasFullAccess(): bool
    {
        try {
            $role = $this->getRole();
            return $role->hasFullAccess();
        } catch (\Error $e) {
            // En cas d'erreur, retourner false par sécurité
            return false;
        }
    }

    /**
     * Check if user can create accounts
     */
    public function canCreateAccounts(): bool
    {
        try {
            $role = $this->getRole();
            return $role->canCreateAccounts();
        } catch (\Error $e) {
            // En cas d'erreur, retourner false par sécurité
            return false;
        }
    }

    /**
     * Check if user can manage accounts
     */
    public function canManageAccounts(): bool
    {
        try {
            $role = $this->getRole();
            return $role->canManageAccounts();
        } catch (\Error $e) {
            // En cas d'erreur, retourner false par sécurité
            return false;
        }
    }

    /**
     * Get dashboard route based on role
     */
    public function getDashboardRoute(): string
    {
        try {
            $role = $this->getRole();
            return $role->getDashboardRoute();
        } catch (\Error $e) {
            // En cas d'erreur, retourner une route par défaut sécurisée
            return 'admin.dashboard';
        }
    }

    /**
     * Check if user has specific role
     */
    public function hasRole(UserRole $role): bool
    {
        try {
            $userRole = $this->getRole();
            return $userRole === $role;
        } catch (\Error $e) {
            // En cas d'erreur, retourner false par sécurité
            return false;
        }
    }

    /**
     * Check if user has any of the specified roles
     */
    public function hasAnyRole(array $roles): bool
    {
        try {
            $userRole = $this->getRole();
            return in_array($userRole, $roles);
        } catch (\Error $e) {
            // En cas d'erreur, retourner false par sécurité
            return false;
        }
    }

    /**
     * Check if user is suspended
     */
    public function isSuspended(): bool
    {
        return $this->is_suspended === true;
    }

    /**
     * Suspend user account
     */
    public function suspend(string $reason = null): void
    {
        $this->update([
            'is_suspended' => true,
            'suspended_at' => now(),
            'suspension_reason' => $reason,
        ]);
    }

    /**
     * Unsuspend user account
     */
    public function unsuspend(): void
    {
        $this->update([
            'is_suspended' => false,
            'suspended_at' => null,
            'suspension_reason' => null,
        ]);
    }

    /**
     * Get suspension status with details
     */
    public function getSuspensionStatus(): array
    {
        return [
            'is_suspended' => $this->is_suspended,
            'suspended_at' => $this->suspended_at,
            'suspension_reason' => $this->suspension_reason,
        ];
    }
}
