<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DocumentCategory;
use App\Models\PlanningDocument;
use App\Models\RegionalIndex;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PublicReportController extends Controller
{
    /**
     * Helper to query and render reports in list view.
     */
    protected function renderReportCategory(Request $request, string $categorySlug, string $component, array $meta, ?string $indexCode = null): Response
    {
        $category = DocumentCategory::where('slug', $categorySlug)->first();

        $query = PlanningDocument::with('category')
            ->where('is_published', true)
            ->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            })
            ->orderByDesc('year')
            ->latest('published_at');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('document_number', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('year')) {
            $query->where('year', (int) $request->input('year'));
        }

        $reports = $query->paginate(8)->withQueryString()->through(function ($doc) {
            return [
                'id' => $doc->id,
                'title' => $doc->title,
                'slug' => $doc->slug,
                'year' => $doc->year,
                'document_number' => $doc->document_number ?? '-',
                'description' => $doc->description ?? '-',
                'file_name' => $doc->file_name ?? 'Dokumen_Laporan.pdf',
                'file_size' => $doc->formattedFileSize(),
                'downloads_count' => $doc->downloads_count,
                'published_at' => $doc->published_at?->translatedFormat('d F Y') ?? '-',
            ];
        });

        $years = PlanningDocument::where('is_published', true)
            ->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            })
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        // Optional index achievement metric for the report header card
        $indexMetric = null;
        if ($indexCode) {
            $indexModel = RegionalIndex::where('code', $indexCode)->where('is_active', true)->orderByDesc('year')->first();
            if ($indexModel) {
                $indexMetric = [
                    'name' => $indexModel->name,
                    'code' => $indexModel->code,
                    'year' => $indexModel->year,
                    'score' => (string) $indexModel->score,
                    'predicate' => $indexModel->predicate,
                    'evaluator' => $indexModel->evaluator,
                    'description' => $indexModel->description,
                ];
            }
        }

        return Inertia::render($component, [
            'reports' => $reports,
            'years' => $years,
            'indexMetric' => $indexMetric,
            'meta' => $meta,
            'filters' => $request->only(['search', 'year']),
        ]);
    }

    /**
     * Submenu 1: Indeks Inovasi Daerah (IID)
     */
    public function iid(Request $request): Response
    {
        return $this->renderReportCategory(
            $request,
            'laporan-iid',
            'Public/Reports/Iid',
            [
                'title' => 'Laporan Indeks Inovasi Daerah (IID)',
                'subtitle' => 'Publikasi Hasil Pengukuran & Kematangan Inovasi Daerah',
                'description' => 'Dokumen resmi evaluasi Indeks Inovasi Daerah (IID) Kabupaten Pringsewu oleh Kemendagri RI, memuat rincian indikator inovasi tata kelola pemerintahan dan pelayanan publik.',
                'badge' => 'BSKDN Kemendagri RI',
                'category_slug' => 'iid',
            ],
            'IID'
        );
    }

    /**
     * Submenu 2: Indeks Daya Saing Daerah (IDSD)
     */
    public function idsd(Request $request): Response
    {
        return $this->renderReportCategory(
            $request,
            'laporan-idsd',
            'Public/Reports/Idsd',
            [
                'title' => 'Laporan Indeks Daya Saing Daerah (IDSD)',
                'subtitle' => 'Evaluasi Produktivitas & Pilar Daya Saing Wilayah',
                'description' => 'Dokumen kajian dan laporan komparatif Indeks Daya Saing Daerah (IDSD) Kabupaten Pringsewu oleh BRIN yang mencakup pilar kelembagaan, SDM, pasar, dan ekosistem inovasi.',
                'badge' => 'BRIN RI',
                'category_slug' => 'idsd',
            ],
            'IDSD'
        );
    }

    /**
     * Submenu 3: Indeks Pengelolaan Keuangan Daerah (IPKD)
     */
    public function ipkd(Request $request): Response
    {
        return $this->renderReportCategory(
            $request,
            'laporan-ipkd',
            'Public/Reports/Ipkd',
            [
                'title' => 'Laporan Indeks Pengelolaan Keuangan Daerah (IPKD)',
                'subtitle' => 'Transparansi, Efisiensi & Akuntabilitas Fiskal Daerah',
                'description' => 'Laporan pengukuran kualitas tata kelola keuangan daerah, keselarasan dokumen perencanaan anggaran (RKPD-APBD), serta kemandirian fiskal Pemerintah Kabupaten Pringsewu.',
                'badge' => 'Kemendagri & BPKP',
                'category_slug' => 'ipkd',
            ],
            'IPKD'
        );
    }

    /**
     * Submenu 4: LAKIP (Laporan Akuntabilitas Kinerja Instansi Pemerintah)
     */
    public function lakip(Request $request): Response
    {
        return $this->renderReportCategory(
            $request,
            'laporan-lakip',
            'Public/Reports/Lakip',
            [
                'title' => 'Laporan Akuntabilitas Kinerja (LAKIP / SAKIP)',
                'subtitle' => 'Pertanggungjawaban Kinerja Instansi Pemerintah BAPPERIDA',
                'description' => 'Laporan Akuntabilitas Kinerja Instansi Pemerintah (LAKIP/LKjIP) memuat capaian sasaran strategis, efektivitas penggunaan anggaran, dan evaluasi implementasi SAKIP berpredikat A.',
                'badge' => 'KemenPAN-RB',
                'category_slug' => 'lakip',
            ],
            'SAKIP'
        );
    }
}
