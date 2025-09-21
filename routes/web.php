
<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AgencyLocationController;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqCommentController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ViewsController;
use App\Http\Controllers\LocalityController;
use App\Http\Controllers\ErrorController;

use App\Http\Middleware\LogVisitor;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

Route::middleware([LogVisitor::class])->group(function () {
    Route::get('/', [ViewsController::class, 'index'])->name('index');
});

Route::get('/admin', [ViewsController::class, 'login'])->name('login');

Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
Route::get('/admin/blogs', [ViewsController::class, 'blogs'])->name('admin.blogs');
Route::get('/show-agencies', [ViewsController::class, 'agency'])->name('agencies');
Route::get('/about', [ViewsController::class, 'about'])->name('about');
Route::get('/open-account', [ViewsController::class, 'account'])->name('main.account');
Route::get('/digital-finance', [ViewsController::class, 'finance'])->name('main.finance');
Route::get('/faq', [ViewsController::class, 'faq'])->name('main.faq');
Route::post('/faq/comment', [FaqCommentController::class, 'store'])->name('faq.comments.store');
Route::post('/blog/comment', [App\Http\Controllers\BlogCommentController::class, 'store'])->name('blog.comments.store');
Route::get('/create-account/physic', [AccountController::class, 'physic'])->name('account.create.physic');
Route::get('/create-account/morale', [AccountController::class, 'morale'])->name('account.create.morale');
Route::post('/create-account/physical/processing', [AccountController::class, 'storePhysical'])->name('account.store.physical');
Route::post('/create-account/moral/processing', [AccountController::class, 'storeMoral'])->name('account.store.moral');

Route::get('/career', [ViewsController::class, 'job'])->name('career');
Route::get('/career/details/{id}', [JobController::class, 'show'])->name('career.details');
Route::post('/career/apply', [JobController::class, 'store'])->name('career.apply');
Route::post('/career/apply/{id}', [JobController::class, 'applyOffer'])->name('career.apply.offer');
// Routes pour les produits
Route::prefix('products')->group(function () {
    Route::get('/', [ViewsController::class, 'products'])->name('product.index');
    Route::get('/details', [ViewsController::class, 'productDetails'])->name('product.details');
});

// Redirection de l'ancienne route vers la nouvelle
Route::get('/products-old', function() {
    return redirect()->route('product.index');
})->name('products');
Route::post('/contact/store', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact', [ViewsController::class, 'contact'])->name('contact');
Route::get('/complaint', [ViewsController::class, 'complaint'])->name('complaint');
Route::post('/complaint/store', [ComplaintController::class, 'store'])->name('complaint.store');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

Route::prefix('admin/jobList')->controller(JobController::class)->group(function () {
    Route::get('/', 'index')->name('jobList.index');
    Route::delete('/destroy/{id}', 'destroy')->name('jobList.destroy');
    Route::get('/download/{id}/{type}', 'downloadFile')->name('jobList.download');
});

Route::get('/blogs/{id}', [BlogController::class, 'show'])->name('blogs.show');

Route::middleware(['auth', 'check.suspension'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [ViewsController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/localities', [LocalityController::class, 'index'])->name('settings.localities');
    Route::post('/localities', [LocalityController::class, 'store'])->name('admin.locality.store');
    Route::delete('/localities/{id}', [LocalityController::class, 'destroy'])->name('admin.locality.delete');
    Route::put('/localities/{id}', [LocalityController::class, 'update'])->name('admin.locality.update');

    Route::prefix('blog')->controller(BlogController::class)->group(function () {
        Route::get('/create', 'create')->name('blog.create');
        Route::post('/store', 'store')->name('blog.store');
        Route::patch('/edit/{id}', 'edit')->name('blog.edit');
        Route::delete('/destroy/{id}', 'destroy')->name('blog.destroy');
    });

    Route::delete('/faq/comments/{id}', [FaqCommentController::class, 'destroy'])->name('faq.comments.destroy');
    Route::delete('/blog/comments/{id}', [App\Http\Controllers\BlogCommentController::class, 'destroy'])->name('blog.comments.destroy');

    Route::prefix('accounts/physical')->controller(AccountController::class)->group(function () {
        Route::get('/', 'indexPhysical')->name('accounts.physical.index');
        Route::get('/{id}', 'showPhysical')->name('accounts.physical.show');
        Route::put('/update/{id}', 'updatePhysical')->name('accounts.physical.update');
        Route::get('/pdf/{id}', 'generatePhysicalPdf')->name('accounts.physical.pdf');
    });

    Route::prefix('accounts/moral')->controller(AccountController::class)->group(function () {
        Route::get('/', 'indexMoral')->name('accounts.moral.index');
        Route::get('/{id}', 'showMoral')->name('accounts.moral.show');
        Route::put('/update/{id}', 'updateMoral')->name('accounts.moral.update');
        Route::get('/pdf/{id}', 'generateMoralPdf')->name('accounts.moral.pdf');
    });

    // Route pour la secrétaire - Vue d'ensemble des comptes
    Route::get('/accounts', [AccountController::class, 'indexAccounts'])->name('admin.accounts.index');

    // Routes du profil admin
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('admin.profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('admin.profile.update');
    Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('admin.profile.password');
    Route::put('/profile/image', [AuthController::class, 'updateProfileImage'])->name('admin.profile.image');

    // Routes de gestion des utilisateurs (création de comptes)
    Route::prefix('users')->controller(\App\Http\Controllers\Admin\UserManagementController::class)->group(function () {
        Route::get('/', 'index')->name('admin.users.index');
        Route::get('/create', 'create')->name('admin.users.create');
        Route::post('/', 'store')->name('admin.users.store');
        Route::get('/{user}', 'show')->name('admin.users.show');
        Route::get('/{user}/edit', 'edit')->name('admin.users.edit');
        Route::put('/{user}', 'update')->name('admin.users.update');
        Route::delete('/{user}', 'destroy')->name('admin.users.destroy');
        Route::post('/{user}/reset-password', 'resetPassword')->name('admin.users.reset-password');
        Route::post('/{user}/suspend', 'suspend')->name('admin.users.suspend');
        Route::post('/{user}/unsuspend', 'unsuspend')->name('admin.users.unsuspend');
        Route::post('/{user}/toggle-suspension', 'toggleSuspension')->name('admin.users.toggle-suspension');
    });
});

Route::prefix('admin/career')->controller(JobOfferController::class)->group(function () {
    Route::get('/', 'index')->name('career.index');
    Route::get('/create', 'create')->name('career.create');
    Route::post('/store', 'store')->name('career.store');
    Route::get('/show/{id}', 'show')->name('career.show');
    Route::get('/edit/{id}', 'edit')->name('career.edit');
    Route::put('/update/{id}', 'update')->name('career.update');
    Route::delete('/destroy/{id}', 'destroy')->name('career.destroy');
});

Route::prefix('admin/jobOffer')->controller(JobOfferController::class)->group(function () {
    Route::get('/details/{id}', 'jobDetail')->name('jobOffer.details');
});

Route::prefix('admin/agency')->controller(AgencyLocationController::class)->group(function () {
    Route::get('/', 'index')->name('agency.index');
    Route::get('/create', 'create')->name('agency.create');
    Route::post('/store', 'store')->name('agency.store');
    Route::put('/update/{id}', 'update')->name('agency.update');
    Route::delete('/destroy/{id}', 'destroy')->name('agency.destroy');
});

Route::prefix('admin/announcement')->controller(AnnouncementsController::class)->group(function () {
    Route::get('/', 'index')->name('announcement.index');
    Route::get('/create', 'create')->name('announcement.create');
    Route::post('/store', 'store')->name('announcement.store');
    Route::put('/update/{id}', 'update')->name('announcement.update');
    Route::delete('/destroy/{id}', 'destroy')->name('announcement.destroy');
});

Route::post('/login/processing', [AuthController::class, 'login'])->name('login.process');

// Routes pour la Finance Digitale
Route::prefix('digitalfinance')->group(function () {
    Route::get('/updates/create', [App\Http\Controllers\DigitalFinanceUpdateController::class, 'create'])->name('digitalfinance.updates.create');
    Route::post('/updates', [App\Http\Controllers\DigitalFinanceUpdateController::class, 'store'])->name('digitalfinance.updates.store');

    // Routes pour les contrats
    Route::get('/contracts/create', [App\Http\Controllers\DigitalFinanceContractController::class, 'create'])->name('digitalfinance.contracts.create');
    Route::post('/contracts', [App\Http\Controllers\DigitalFinanceContractController::class, 'store'])->name('digitalfinance.contracts.store');
});

// Routes admin pour la Finance Digitale
Route::middleware('auth:sanctum')->prefix('admin/digitalfinance')->group(function () {
    Route::prefix('updates')->controller(App\Http\Controllers\DigitalFinanceUpdateController::class)->group(function () {
        Route::get('/', 'index')->name('admin.digitalfinance.updates.index');
        Route::get('/{id}', 'show')->name('admin.digitalfinance.updates.show');
        Route::get('/{id}/edit', 'edit')->name('admin.digitalfinance.updates.edit');
        Route::put('/{id}', 'update')->name('admin.digitalfinance.updates.update');
        Route::delete('/{id}', 'destroy')->name('admin.digitalfinance.updates.destroy');
        Route::patch('/{id}/approve', 'approve')->name('admin.digitalfinance.updates.approve');
        Route::patch('/{id}/reject', 'reject')->name('admin.digitalfinance.updates.reject');
        Route::put('/{id}/status', 'updateStatus')->name('admin.digitalfinance.updates.updateStatus');
        Route::get('/{id}/pdf', 'generatePdf')->name('admin.digitalfinance.updates.pdf');
    });

    // Routes admin pour les contrats
    Route::prefix('contracts')->controller(App\Http\Controllers\DigitalFinanceContractController::class)->group(function () {
        Route::get('/', 'index')->name('admin.digitalfinance.contracts.index');
        Route::get('/{id}', 'show')->name('admin.digitalfinance.contracts.show');
        Route::get('/{id}/edit', 'edit')->name('admin.digitalfinance.contracts.edit');
        Route::put('/{id}', 'update')->name('admin.digitalfinance.contracts.update');
        Route::delete('/{id}', 'destroy')->name('admin.digitalfinance.contracts.destroy');
        Route::patch('/{id}/activate', 'activate')->name('admin.digitalfinance.contracts.activate');
        Route::patch('/{id}/terminate', 'terminate')->name('admin.digitalfinance.contracts.terminate');
        Route::put('/{id}/status', 'updateStatus')->name('admin.digitalfinance.contracts.updateStatus');
        Route::get('/{id}/pdf', 'generatePdf')->name('admin.digitalfinance.contracts.pdf');
    });
});

    // Routes admin pour la gestion des plaintes
    Route::middleware('auth:sanctum')->prefix('admin/complaint')->controller(App\Http\Controllers\ComplaintController::class)->group(function () {
        Route::get('/', 'adminIndex')->name('admin.complaint.index');
        Route::get('/{id}', 'adminShow')->name('admin.complaint.show');
        Route::put('/{id}/status', 'updateStatus')->name('admin.complaint.updateStatus');
        Route::put('/{id}/notes', 'updateNotes')->name('admin.complaint.updateNotes');
        Route::delete('/{id}', 'destroy')->name('admin.complaint.destroy');
    });

    // Routes pour les pages d'erreur personnalisées
    Route::get('/404', [ErrorController::class, 'notFound'])->name('error.404');
    Route::get('/500', [ErrorController::class, 'serverError'])->name('error.500');
    Route::get('/error/{code}', [ErrorController::class, 'error'])->name('error.generic');

// Route pour servir les fichiers du storage (solution pour PlanetHoster)
Route::get('/storage/{path}', function ($path) {
    // Le chemin complet du fichier dans storage/app/public
    $filePath = 'public/' . $path;

    // Vérifier si le fichier existe
    if (!Storage::exists($filePath)) {
        abort(404, 'Fichier non trouvé.');
    }

    // Obtenir le contenu du fichier
    $file = Storage::get($filePath);

    // Déterminer le type MIME du fichier (image/jpeg, image/png, etc.)
    $mimeType = Storage::mimeType($filePath);

    // Renvoyer le fichier avec le bon en-tête Content-Type
    return Response::make($file, 200)->header("Content-Type", $mimeType);
})->where('path', '.*'); // Le '.where('path', '.*')' permet de capturer tout le reste du chemin après /storage/
