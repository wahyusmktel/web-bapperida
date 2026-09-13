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
     * Helper to format article items for Inertia props.
     */
    protected function formatArticle(NewsArticle $art): array
    {
        return [
            'id' => $art->id,
            'title' => $art->title,
            'slug' => $art->slug,
            'excerpt' => $art->excerpt,
            'category_name' => $art->category?->name ?? 'Umum',
            'category_code' => $art->category?->code ?? 'UMUM',
            'category_slug' => $art->category?->slug ?? 'umum',
            'category_color' => $art->category?->color ?? 'teal',
            'author_name' => $art->author?->name ?? 'Tim Publikasi BAPPERIDA',
            'featured_image' => $art->featured_image ? Storage::url($art->featured_image) : null,
            'published_at' => $art->published_at?->translatedFormat('d M Y') ?? '-',
            'published_date_full' => $art->published_at?->translatedFormat('l, d F Y') ?? '-',
            'views_count' => $art->views_count,
            'reading_time' => max(2, (int) ceil(str_word_count(strip_tags($art->content ?? $art->excerpt ?? '')) / 180)) . ' menit baca',
        ];
    }

    /**
     * Render a category specific magazine news page.
     */
    protected function renderCategoryNews(Request $request, string $categorySlug, string $componentName, array $meta): Response
    {
        $category = NewsCategory::where('slug', $categorySlug)->first();

        $query = NewsArticle::with(['category:id,name,code,slug,color', 'author:id,name'])
            ->where('is_published', true)
            ->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            })
            ->latest('published_at');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Featured Lead Story (the newest one)
        $featuredArticleModel = (clone $query)->first();
        $featuredArticle = $featuredArticleModel ? $this->formatArticle($featuredArticleModel) : null;

        // Paginated Articles (all articles in category)
        $articles = $query->paginate(6)->withQueryString()->through(function ($art) {
            return $this->formatArticle($art);
        });

        // Top 4 Popular Articles across portal for magazine sidebar
        $popularArticles = NewsArticle::with('category:id,name,code,slug,color')
            ->where('is_published', true)
            ->orderByDesc('views_count')
            ->take(4)
            ->get()
            ->map(fn ($art) => $this->formatArticle($art));

        $categories = NewsCategory::select('id', 'name', 'code', 'slug', 'color')->get();

        return Inertia::render($componentName, [
            'articles' => $articles,
            'featuredArticle' => $featuredArticle,
            'popularArticles' => $popularArticles,
            'category' => $category ? [
                'id' => $category->id,
                'name' => $category->name,
                'code' => $category->code,
                'slug' => $category->slug,
                'description' => $category->description,
                'color' => $category->color,
            ] : null,
            'categories' => $categories,
            'meta' => $meta,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Display listing of public news articles across 6 Bidang (Magazine Hub).
     */
    public function index(Request $request): Response
    {
        $query = NewsArticle::with(['category:id,name,code,slug,color', 'author:id,name'])
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

        $featuredArticleModel = (clone $query)->first();
        $featuredArticle = $featuredArticleModel ? $this->formatArticle($featuredArticleModel) : null;

        $articles = $query->paginate(9)->withQueryString()->through(function ($art) {
            return $this->formatArticle($art);
        });

        $popularArticles = NewsArticle::with('category:id,name,code,slug,color')
            ->where('is_published', true)
            ->orderByDesc('views_count')
            ->take(4)
            ->get()
            ->map(fn ($art) => $this->formatArticle($art));

        $categories = NewsCategory::select('id', 'name', 'code', 'slug', 'color')->get();

        return Inertia::render('Public/News/Index', [
            'articles' => $articles,
            'featuredArticle' => $featuredArticle,
            'popularArticles' => $popularArticles,
            'categories' => $categories,
            'filters' => $request->only(['search', 'bidang']),
            'meta' => [
                'title' => 'Warta & Majalah Informasi 6 Bidang',
                'description' => 'Edisi berita resmi perencanaan, inovasi riset daerah, pembangunan sosial ekonomi, tata ruang, dan kebijakan strategis Kabupaten Pringsewu.',
                'badge' => 'Pemberitaan Resmi Pemerintah Daerah',
                'category_slug' => 'semua',
            ],
        ]);
    }

    /**
     * Submenu 1: Sekretariat / Umum
     */
    public function umum(Request $request): Response
    {
        return $this->renderCategoryNews($request, 'umum', 'Public/News/Umum', [
            'title' => 'Warta Umum & Kesekretariatan',
            'description' => 'Informasi resmi tata kelola birokrasi, reformasi pelayanan, kedisiplinan aparatur, akuntabilitas keuangan, dan kegiatan umum BAPPERIDA Kabupaten Pringsewu.',
            'badge' => 'Bidang Sekretariat & Tata Usaha',
            'category_slug' => 'umum',
        ]);
    }

    /**
     * Submenu 2: Perencanaan Pengendalian dan Evaluasi (PPE)
     */
    public function ppe(Request $request): Response
    {
        return $this->renderCategoryNews($request, 'ppe', 'Public/News/Ppe', [
            'title' => 'Warta Perencanaan, Pengendalian & Evaluasi (PPE)',
            'description' => 'Penyusunan RPJPD, RPJMD, RKPD, Musrenbang berjenjang, pengendalian program strategis, serta evaluasi capaian kinerja makro pembangunan Kabupaten Pringsewu.',
            'badge' => 'Bidang PPE BAPPERIDA',
            'category_slug' => 'ppe',
        ]);
    }

    /**
     * Submenu 3: Pemerintahan dan Pembangunan Manusia (PPM)
     */
    public function ppm(Request $request): Response
    {
        return $this->renderCategoryNews($request, 'ppm', 'Public/News/Ppm', [
            'title' => 'Warta Pemerintahan & Pembangunan Manusia (PPM)',
            'description' => 'Perencanaan strategis bidang pendidikan berkualitas, integrasi pengentasan stunting, peningkatan IPM, pengentasan kemiskinan ekstrem, dan perlindungan sosial.',
            'badge' => 'Bidang PPM BAPPERIDA',
            'category_slug' => 'ppm',
        ]);
    }

    /**
     * Submenu 4: Perekonomian dan Sumber Daya Alam (PSDA)
     */
    public function psda(Request $request): Response
    {
        return $this->renderCategoryNews($request, 'psda', 'Public/News/Psda', [
            'title' => 'Warta Perekonomian & Sumber Daya Alam (PSDA)',
            'description' => 'Pengembangan komoditas pangan unggulan, hilirisasi agribisnis, pemberdayaan klaster UMKM Tapis Pringsewu, ketahanan energi, dan kelestarian lingkungan hidup.',
            'badge' => 'Bidang PSDA BAPPERIDA',
            'category_slug' => 'psda',
        ]);
    }

    /**
     * Submenu 5: Infrastruktur dan Pengembangan Wilayah (IPW)
     */
    public function ipw(Request $request): Response
    {
        return $this->renderCategoryNews($request, 'ipw', 'Public/News/Ipw', [
            'title' => 'Warta Infrastruktur & Pengembangan Wilayah (IPW)',
            'description' => 'Penataan tata ruang wilayah (RTRW), konektivitas jalan antarkecamatan, penyediaan air minum perpipaan, sanitasi pemukiman, dan infrastruktur ramah lingkungan.',
            'badge' => 'Bidang IPW BAPPERIDA',
            'category_slug' => 'ipw',
        ]);
    }

    /**
     * Submenu 6: Riset dan Inovasi Daerah (RIDA)
     */
    public function rida(Request $request): Response
    {
        return $this->renderCategoryNews($request, 'rida', 'Public/News/Rida', [
            'title' => 'Warta Riset & Inovasi Daerah (RIDA)',
            'description' => 'Ekosistem riset terapan, pencapaian Indeks Inovasi Daerah (IID), Kompetisi Inovasi Daerah (KID), kemitraan perguruan tinggi, dan hilirisasi inovasi masyarakat.',
            'badge' => 'Bidang RIDA BAPPERIDA',
            'category_slug' => 'rida',
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
            ->map(fn ($rel) => $this->formatArticle($rel));

        $popularArticles = NewsArticle::with('category:id,name,code,slug,color')
            ->where('is_published', true)
            ->where('id', '!=', $article->id)
            ->orderByDesc('views_count')
            ->take(4)
            ->get()
            ->map(fn ($pop) => $this->formatArticle($pop));

        return Inertia::render('Public/News/Show', [
            'article' => [
                'id' => $article->id,
                'title' => $article->title,
                'slug' => $article->slug,
                'excerpt' => $article->excerpt,
                'content' => $article->content,
                'category_name' => $article->category?->name ?? 'Umum',
                'category_code' => $article->category?->code ?? 'UMUM',
                'category_slug' => $article->category?->slug ?? 'umum',
                'category_color' => $article->category?->color ?? 'teal',
                'author_name' => $article->author?->name ?? 'Tim Publikasi BAPPERIDA',
                'featured_image' => $article->featured_image ? Storage::url($article->featured_image) : null,
                'published_at' => $article->published_at?->translatedFormat('l, d F Y') ?? '-',
                'views_count' => $article->views_count,
                'reading_time' => max(2, (int) ceil(str_word_count(strip_tags($article->content ?? $article->excerpt ?? '')) / 180)) . ' menit baca',
            ],
            'relatedArticles' => $relatedArticles,
            'popularArticles' => $popularArticles,
        ]);
    }
}
