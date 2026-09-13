<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\NewsArticle;
use App\Models\NewsCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    /**
     * Display a listing of news articles.
     */
    public function index(Request $request): Response
    {
        $query = NewsArticle::with(['category:id,name,code,color', 'author:id,name'])
            ->latest('published_at');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $articles = $query->paginate(10)->withQueryString()->through(function ($article) {
            return [
                'id' => $article->id,
                'title' => $article->title,
                'slug' => $article->slug,
                'excerpt' => $article->excerpt,
                'content' => $article->content,
                'category_name' => $article->category?->name ?? 'Umum',
                'category_code' => $article->category?->code ?? 'UMUM',
                'category_color' => $article->category?->color ?? 'teal',
                'category_id' => $article->category_id,
                'author_name' => $article->author?->name ?? 'Administrator',
                'featured_image' => $article->featured_image ? Storage::url($article->featured_image) : null,
                'views_count' => $article->views_count,
                'is_published' => $article->is_published,
                'published_at' => $article->published_at?->translatedFormat('d M Y') ?? '-',
            ];
        });

        $categories = NewsCategory::select('id', 'name', 'code', 'color')->get();

        return Inertia::render('Admin/News/Index', [
            'articles' => $articles,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category_id']),
        ]);
    }

    /**
     * Store a newly created news article in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:news_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,webp,jpg', 'max:4096'],
            'is_published' => ['boolean'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news/images', 'public');
        }

        $excerpt = $validated['excerpt'] ?: Str::limit(strip_tags($validated['content']), 180);

        // Basic XSS sanitization for content: strip dangerous tags
        $cleanContent = strip_tags($validated['content'], '<p><br><strong><em><u><h2><h3><h4><ul><ol><li><a><blockquote><img>');

        $article = NewsArticle::create([
            'category_id' => $validated['category_id'],
            'author_id' => Auth::id(),
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::lower(Str::random(6)),
            'excerpt' => $excerpt,
            'content' => $cleanContent,
            'featured_image' => $imagePath,
            'is_published' => $request->boolean('is_published', true),
            'published_at' => now(),
        ]);

        Cache::forget('bapperida:stats:overview');
        Cache::forget('bapperida:public:home');

        ActivityLog::record(
            action: 'news.create',
            description: "Menerbitkan rilis berita: {$article->title}",
            properties: ['article_id' => $article->id, 'title' => $article->title]
        );

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diterbitkan.');
    }

    /**
     * Update the specified news article.
     */
    public function update(Request $request, NewsArticle $article): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:news_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,webp,jpg', 'max:4096'],
            'is_published' => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($article->featured_image && Storage::disk('public')->exists($article->featured_image)) {
                Storage::disk('public')->delete($article->featured_image);
            }

            $article->featured_image = $request->file('image')->store('news/images', 'public');
        }

        $excerpt = $validated['excerpt'] ?: Str::limit(strip_tags($validated['content']), 180);
        $cleanContent = strip_tags($validated['content'], '<p><br><strong><em><u><h2><h3><h4><ul><ol><li><a><blockquote><img>');

        $article->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'excerpt' => $excerpt,
            'content' => $cleanContent,
            'is_published' => $request->boolean('is_published'),
        ]);

        Cache::forget('bapperida:stats:overview');
        Cache::forget('bapperida:public:home');

        ActivityLog::record(
            action: 'news.update',
            description: "Memperbarui artikel berita: {$article->title}",
            properties: ['article_id' => $article->id]
        );

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified news article.
     */
    public function destroy(NewsArticle $article): RedirectResponse
    {
        $title = $article->title;
        $id = $article->id;

        if ($article->featured_image && Storage::disk('public')->exists($article->featured_image)) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        Cache::forget('bapperida:stats:overview');
        Cache::forget('bapperida:public:home');

        ActivityLog::record(
            action: 'news.delete',
            description: "Menghapus artikel berita: {$title}",
            properties: ['article_id' => $id]
        );

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }
}
