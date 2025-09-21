<?php

namespace App\Providers;

use App\Interfaces\JobOfferInterface;
use App\Repositories\JobOfferRepository;
use App\Helpers\FileHelper;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(JobOfferInterface::class, JobOfferRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Directive Blade pour les images avec fallback
        Blade::directive('image', function ($expression) {
            return "<?php echo \App\Helpers\FileHelper::getStorageImageUrl($expression); ?>";
        });
        
        // Directive Blade pour les images avec placeholder personnalisé
        Blade::directive('imageWithPlaceholder', function ($expression) {
            return "<?php echo \App\Helpers\FileHelper::getStorageImageUrl($expression); ?>";
        });
        
        // Directive Blade pour vérifier l'authentification et les permissions
        Blade::directive('authCheck', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()): ?>";
        });
        
        Blade::directive('endauthCheck', function ($expression) {
            return "<?php endif; ?>";
        });
        
        Blade::directive('hasFullAccess', function ($expression) {
            return "<?php if(auth()->check() && auth()->user() && auth()->user()->hasFullAccess()): ?>";
        });
        
        Blade::directive('endhasFullAccess', function ($expression) {
            return "<?php endif; ?>";
        });
        
        Blade::directive('canCreateAccounts', function ($expression) {
            return "<?php if(auth()->check() && auth()->user() && auth()->user()->canCreateAccounts()): ?>";
        });
        
        Blade::directive('endcanCreateAccounts', function ($expression) {
            return "<?php endif; ?>";
        });
    }
}
