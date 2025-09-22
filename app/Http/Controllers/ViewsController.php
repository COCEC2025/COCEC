<?php

namespace App\Http\Controllers;

use App\Models\AgencyLocation;
use App\Models\Announcements;
use App\Models\Blog;
use App\Models\Complaint;
use App\Models\FaqComment;
use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\NewsletterSubscriber;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewsController extends Controller
{
    //
    public function index()
    {
        $blogs = Blog::where('is_published', true)
            ->latest()
            ->take(2)
            ->get();

        $total = Visitor::count();

        $announcement = Announcements::where('status', 'publier')->latest()->first();

        $agencies = AgencyLocation::take(3)->get();

        return view('welcome', [
            'blogs' => $blogs,
            'total' => $total,
            'announcement' => $announcement,
            'agencies' => $agencies
        ]);
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function dashboard()
    {
        // Vérifier que l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder au dashboard.');
        }

        $user = Auth::user();
        
        // Vérifier que l'utilisateur existe toujours en base
        if (!$user) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Session expirée. Veuillez vous reconnecter.');
        }

        // Vérifier que l'utilisateur a un rôle valide
        if (!$user->role) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Rôle utilisateur invalide. Veuillez contacter l\'administrateur.');
        }

        // Total des visiteurs
        $totalVisitors = Visitor::count();

        // Visiteurs par mois (par exemple, sur les 12 derniers mois)
        $visitorsByMonth = Visitor::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->take(12)
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Visiteurs par jour (par exemple, sur les 30 derniers jours)
        $visitorsByDay = Visitor::selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as day, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get()
            ->pluck('count', 'day')
            ->toArray();

        // Visiteurs par semaine (par exemple, sur les 12 dernières semaines)
        $visitorsByWeek = Visitor::selectRaw('YEARWEEK(created_at) as week, COUNT(*) as count')
            ->where('created_at', '>=', now()->subWeeks(12))
            ->groupBy('week')
            ->orderBy('week', 'asc')
            ->get()
            ->pluck('count', 'week')
            ->toArray();

        // Abonnés newsletter par mois (par exemple, sur les 12 derniers mois)
        $subscribersByMonth = NewsletterSubscriber::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->take(12)
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $totalSubscribers = NewsletterSubscriber::count();
        $jobOffers = JobOffer::count();
        $jobApplications = JobApplication::count();
        
        // Statistiques des plaintes
        $totalComplaints = Complaint::count();
        $pendingComplaints = Complaint::where('status', 'pending')->count();
        $processingComplaints = Complaint::where('status', 'processing')->count();
        $resolvedComplaints = Complaint::where('status', 'resolved')->count();

        return view('admin.dashboard', compact(
            'totalVisitors',
            'visitorsByMonth',
            'visitorsByDay',
            'visitorsByWeek',
            'totalSubscribers',
            'subscribersByMonth',
            'jobOffers',
            'jobApplications',
            'totalComplaints',
            'pendingComplaints',
            'processingComplaints',
            'resolvedComplaints'
        ));
    }

    public function blogs()
    {
        // Pour l'interface admin, afficher tous les articles (publiés et non publiés)
        $blogs = Blog::orderBy('created_at', 'desc')
            ->get();
        return view('admin.blog.index', ['blogs' => $blogs]);
    }


    public function agency(Request $request)
    {
        // Récupérer les coordonnées de l'utilisateur depuis la requête
        $userLat = $request->query('lat');
        $userLng = $request->query('lng');

        if ($userLat && $userLng) {
            // Récupérer toutes les agences
            $agencies = AgencyLocation::all();
            
            // Calculer la distance pour chaque agence
            $agencies->each(function ($agency) use ($userLat, $userLng) {
                $agency->distance = $this->calculateDistance($userLat, $userLng, $agency->latitude, $agency->longitude);
            });
            
            // Trier par distance et convertir en tableau
            $agencies = $agencies->sortBy('distance')->values();
        } else {
            // Si pas de géolocalisation, afficher toutes les agences
            $agencies = AgencyLocation::all()->values();
        }

        // Debug: vérifier que les agences sont bien passées
        \Illuminate\Support\Facades\Log::info('Agences passées à la vue:', [
            'count' => $agencies->count(),
            'agencies' => $agencies->toArray()
        ]);
        
        // S'assurer que les agences sont bien une collection
        if (!$agencies) {
            $agencies = collect([]);
        }
        
        // Optimiser les URLs des images
        $agencies->each(function ($agency) {
            if ($agency->image) {
                // Ajouter des paramètres d'optimisation à l'URL
                $agency->optimized_image = $agency->image;
                $agency->webp_image = str_replace(['.jpg', '.jpeg', '.png'], '.webp', $agency->image);
            }
        });
        
        return view('main.agency', compact('agencies'));
    }

    /**
     * Calcule la distance entre deux points géographiques (formule de Haversine)
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Rayon de la Terre en kilomètres
        
        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);
        
        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        return $earthRadius * $c;
    }

    public function about()
    {
        return view('main.about');
    }

    public function faq()
    {
        // On utilise l'eager loading pour éviter le problème N+1
        $comments = FaqComment::whereNull('parent_id')
            ->with('user', 'replies.user') // Charge les utilisateurs des commentaires ET des réponses
            ->latest()
            ->get();

        return view('main.faq', compact('comments'));
    }

    public function contact()
    {
        return view('main.contact');
    }

    public function job()
    {
        // On récupère uniquement les offres ouvertes, les plus récentes en premier
        $jobOffers = JobOffer::where('status', 'open')->latest()->get();

        return view('main.job.index', compact('jobOffers'));
    }

    public function account()
    {
        return view('main.account.index');
    }

    public function products()
    {
        return view('main.product.index');
    }

    public function productDetails(Request $request)
    {
        $slug = $request->get('slug');
        
        // Charger les données des produits depuis le JSON
        $productsJsonPath = public_path('assets/data/products.json');
        $productsData = [];
        
        if (file_exists($productsJsonPath)) {
            $productsData = json_decode(file_get_contents($productsJsonPath), true);
        }
        
        // Trouver le produit correspondant au slug
        $product = null;
        if (isset($productsData['products'])) {
            foreach ($productsData['products'] as $p) {
                if ($p['slug'] === $slug) {
                    $product = $p;
                    break;
                }
            }
        }
        
        // Si le produit n'est pas trouvé, rediriger vers la liste des produits
        if (!$product) {
            return redirect()->route('product.index');
        }
        
        return view('main.product.details', compact('product'));
    }

    public function finance()
    {
        return view('main.digitalfinance.index');
    }

    public function announcements()
    {

        $announcements = Announcements::all();

        return view('admin.announcement.index', ['announcements' => $announcements]);
    }

    public function locality()
    {
        return view('admin.settings.localities');
    }

    public function complaint()
    {
        return view('main.complaint');
    }
}
