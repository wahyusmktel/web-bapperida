<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class PublicNewsController extends Controller
{
    /**
     * Display listing of public news articles across 6 Bidang.
     */
    public function index(Request $request): Response
    {
        $query = NewsArticle::with('category:id,name,code,slug,color')
            ->where('is_published', true)
            ->latest('published_at');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($request->filled('bidang')) {
            $bidangSlug = $request->input('bidang');
            $query->whereHas('category', function ($q) use ($bidangSlug) {
                $q->where('slug', $bidangSlug);
            });
        }

        $articles = $query->paginate(9)->withQueryString()->through(function ($art) {
            return [
                'id' => $art->id,
                'title' => $art->title,
                'slug' => $art->slug,
                'excerpt' => $art->excerpt,
                'category_name' => $art->category?->name ?? 'Umum',
                'category_code' => $art->category?->code ?? 'UMUM',
                'category_slug' => $art->category?->slug ?? 'umum',
                'category_color' => $art->category?->color ?? 'teal',
                'featured_image' => $art->featured_image ? Storage::url($art->featured_image) : null,
                'published_at' => $art->published_at?->translatedFormat('d F Y') ?? '-',
                'views_count' => $art->views_count,
            ];
        });

        $categories = NewsCategory::select('id', 'name', 'code', 'slug', 'color')->get();

        return Inertia::render('Public/News/Index', [
            'articles' => $articles,
            'categories' => $categories,
            'filters' => $request->only(['search', 'bidang']),
        ]);
    }

    /**
     * Display a specific news article and increment views.
     */
    public function show(string $slug): Response
    {
        $article = NewsArticle::with(['category:id,name,code,slug,color', 'author:id,name'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment view count
        $article->increment('views_count');

        // Related articles
        $relatedArticles = NewsArticle::with('category:id,name,code,slug,color')
            ->where('is_published', true)
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->latest('published_at')
            ->take(3)
            ->get()
            ->map(function ($rel) {
                return [
                    'id' => $rel->id,
                    'title' => $rel->title,
                    'slug' => $rel->slug,
                    'excerpt' => $rel->excerpt,
                    'category_name' => $rel->category?->name,
                    'category_code' => $rel->category?->code,
                    'published_at' => $rel->published_at?->translatedFormat('d F Y') ?? '-',
                ];
            });

        return Inertia::render('Public/News/Show', [
            'article' => [
                'id' => $article->id,
                'title' => $article->title,
                'slug' => $article->slug,
                'excerpt' => $article->excerpt,
                'content' => $article->content,
                'category_name' => $article->category?->name ?? 'Umum',
                'category_code' => $article->category?->code ?? 'UMUM',
                'author_name' => $article->author?->name ?? 'Tim Publikasi BAPPERIDA',
                'featured_image' => $article->featured_image ? Storage::url($article->featured_image) : null,
                'published_at' => $article->published_at?->translatedFormat('l, d F Y') ?? '-',
                'views_count' => $article->views_count,
            ],
            'relatedArticles' => $relatedArticles,
        ]);
    }
}
