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
            // Featured Planning Documents (Perencanaan: RKPD, RPJMD, Renstra, Renja)
            $featuredDocuments = PlanningDocument::with('category:id,name,slug')
                ->where('is_published', true)
                ->whereHas('category', function ($q) {
                    $q->whereIn('slug', ['dokumen-perencanaan', 'perencanaan', 'rkpd', 'rpjmd', 'renstra']);
                })
                ->orderByDesc('year')
                ->orderByDesc('published_at')
                ->take(6)
                ->get();

            if ($featuredDocuments->isEmpty()) {
                $featuredDocuments = PlanningDocument::with('category:id,name,slug')
                    ->where('is_published', true)
                    ->orderByDesc('year')
                    ->take(6)
                    ->get();
            }

            $featuredDocuments = $featuredDocuments->map(function ($doc) {
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

            $categoryImages = [
                'UMUM' => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?auto=format&fit=crop&w=800&q=80',
                'PPE' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=800&q=80',
                'PPM' => 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&w=800&q=80',
                'PSDA' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=800&q=80',
                'IPW' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80',
                'RIDA' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80',
            ];

            // Latest News Articles
            $latestNews = NewsArticle::with('category:id,name,code,slug,color')
                ->where('is_published', true)
                ->orderByDesc('published_at')
                ->take(24)
                ->get()
                ->map(function ($art) use ($categoryImages) {
                    $catCode = $art->category?->code ?? 'UMUM';
                    $featuredImage = null;
                    if ($art->featured_image) {
                        $featuredImage = (str_starts_with($art->featured_image, 'http') || str_starts_with($art->featured_image, '/'))
                            ? $art->featured_image
                            : Storage::url($art->featured_image);
                    } else {
                        $featuredImage = $categoryImages[$catCode] ?? '/images/pringsewu_magazine_bg.jpg';
                    }

                    return [
                        'id' => $art->id,
                        'title' => $art->title,
                        'slug' => $art->slug,
                        'excerpt' => $art->excerpt,
                        'category_name' => $art->category?->name ?? 'Umum',
                        'category_code' => $catCode,
                        'category_slug' => $art->category?->slug ?? 'umum',
                        'featured_image' => $featuredImage,
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
            $head = Official::where('category_code', 'PIMPINAN')
                ->orWhere('category_code', 'leadership')
                ->first();

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
