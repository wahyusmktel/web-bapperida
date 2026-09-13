<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use App\Models\NewsCategory;
use App\Models\Official;
use App\Models\PlanningDocument;
use App\Models\RegionalIndex;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Display the official BAPPERIDA homepage.
     */
    public function index(): Response
    {
        $data = Cache::remember('bapperida:public:home', now()->addMinutes(15), function () {
            // Featured Planning Documents (RKPD, RPJMD, Renstra)
            $featuredDocuments = PlanningDocument::with('category:id,name,slug')
                ->where('is_published', true)
                ->orderByDesc('year')
                ->take(4)
                ->get()
                ->map(function ($doc) {
                    return [
                        'id' => $doc->id,
                        'title' => $doc->title,
                        'slug' => $doc->slug,
                        'category_name' => $doc->category?->name ?? 'Perencanaan',
                        'year' => $doc->year,
                        'document_number' => $doc->document_number ?? '-',
                        'file_size' => $doc->formattedFileSize(),
                        'downloads_count' => $doc->downloads_count,
                    ];
                });

            // 6 Bidang Categories
            $categories = NewsCategory::select('id', 'name', 'code', 'slug', 'color')->get();

            // Latest News Articles
            $latestNews = NewsArticle::with('category:id,name,code,slug,color')
                ->where('is_published', true)
                ->latest('published_at')
                ->take(6)
                ->get()
                ->map(function ($art) {
                    return [
                        'id' => $art->id,
                        'title' => $art->title,
                        'slug' => $art->slug,
                        'excerpt' => $art->excerpt,
                        'category_name' => $art->category?->name ?? 'Umum',
                        'category_code' => $art->category?->code ?? 'UMUM',
                        'category_slug' => $art->category?->slug ?? 'umum',
                        'featured_image' => $art->featured_image ? Storage::url($art->featured_image) : null,
                        'published_at' => $art->published_at?->translatedFormat('d F Y') ?? '-',
                        'views_count' => $art->views_count,
                    ];
                });

            // Regional Indexes
            $indexes = RegionalIndex::where('is_active', true)
                ->orderByDesc('year')
                ->take(4)
                ->get()
                ->map(function ($idx) {
                    return [
                        'id' => $idx->id,
                        'name' => $idx->name,
                        'code' => $idx->code,
                        'score' => (string) $idx->score,
                        'predicate' => $idx->predicate,
                        'evaluator' => $idx->evaluator,
                        'year' => $idx->year,
                    ];
                });

            // Leadership
            $head = Official::where('category_code', 'PIMPINAN')->first();

            return [
                'featuredDocuments' => $featuredDocuments,
                'categories' => $categories,
                'latestNews' => $latestNews,
                'indexes' => $indexes,
                'headOfficial' => $head ? [
                    'name' => $head->name,
                    'position' => $head->position,
                    'nip' => $head->nip,
                ] : null,
            ];
        });

        return Inertia::render('Public/Home', $data);
    }
}
