<?php

namespace App\Http\Controllers;

use App\Interfaces\BlogInterface;
use App\Models\Blog;
use App\Services\NewsletterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{

    private BlogInterface $blogInterface;
    private NewsletterService $newsletterService;

    public function __construct(BlogInterface $blogInterface, NewsletterService $newsletterService)
    {
        $this->blogInterface = $blogInterface;
        $this->newsletterService = $newsletterService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $blogs = Blog::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('main.blog.index', ['blogs' => $blogs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:30720',
            'short_description' => 'required|string|max:500',
            'long_description' => 'required|string',
            'is_published' => 'required|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blog', 'public');
        }

        $data = [
            "title" => $request->title,
            "short_description" => $request->short_description,
            "long_description" => $request->long_description,
            "author" => auth()->user()->name ?? 'Admin',
            "image" => $imagePath,
            "is_published" => $request->is_published,
        ];

        $response = $this->blogInterface->create($data);
        if (!$response) {
            return back()->with('error', 'Erreur lors de la création du blog !');
        }

        // Envoyer les notifications newsletter si l'article est publié
        if ($request->is_published) {
            try {
                $blog = Blog::latest()->first(); // Récupérer le blog créé
                $notificationResult = $this->newsletterService->notifyNewBlog($blog);
                
                if ($notificationResult) {
                    Log::info("Notifications newsletter envoyées pour le blog: {$blog->title}", $notificationResult);
                }
            } catch (\Exception $e) {
                Log::error("Erreur lors de l'envoi des notifications newsletter: " . $e->getMessage());
                // Ne pas faire échouer la création du blog si l'envoi de notification échoue
            }
        }

        return redirect()->route('admin.blogs')->with('success', 'Blog créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Récupère le blog affiché avec ses commentaires
        $blog = Blog::with(['comments.replies.user', 'comments.user'])->findOrFail($id);

        // Récupère 4 autres blogs récents, excluant celui en cours
        $blogs = Blog::where('id', '!=', $id)
            ->where('is_published', true)
            ->latest() // équivalent à orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Récupère les commentaires du blog
        $comments = $blog->comments()->with(['replies.user', 'user'])->latest()->get();

        return view('main.blog.detail', compact('blog', 'blogs', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:30720',
            'short_description' => 'required|string|max:500',
            'long_description' => 'required|string',
            'is_published' => 'required|boolean',
        ]);

        $imagePath = $blog->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blog', 'public');
        }

        $data = [
            "title" => $request->title,
            "short_description" => $request->short_description,
            "long_description" => $request->long_description,
            "author" => $blog->author ?? (auth()->user()->name ?? 'Admin'),
            "image" => $imagePath,
            "is_published" => $request->is_published,
        ];

        $response = $this->blogInterface->edit($id, $data);
        if (!$response) {
            return back()->with('error', 'Erreur lors de la modification du blog!');
        }

        // Envoyer les notifications newsletter si l'article vient d'être publié
        if ($request->is_published && !$blog->is_published) {
            try {
                $updatedBlog = Blog::findOrFail($id);
                $notificationResult = $this->newsletterService->notifyNewBlog($updatedBlog);
                
                if ($notificationResult) {
                    Log::info("Notifications newsletter envoyées pour le blog modifié: {$updatedBlog->title}", $notificationResult);
                }
            } catch (\Exception $e) {
                Log::error("Erreur lors de l'envoi des notifications newsletter: " . $e->getMessage());
            }
        }

        return redirect()->route('admin.blogs')->with('success', 'Blog modifié avec succès!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $response = $this->blogInterface->destroy($id);
        if (!$response)
            return back()->with('error', 'Erreur lors de la suppression du blog!');

        return back()->with('success', 'Blog supprimé avec succès');
    }
}
