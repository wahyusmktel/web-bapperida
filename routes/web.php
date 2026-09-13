<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\RegionalIndexController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProfileController;
use App\Http\Controllers\Public\PublicAwardController;
use App\Http\Controllers\Public\PublicDocumentController;
use App\Http\Controllers\Public\PublicNewsController;
use App\Http\Controllers\Public\PublicReportController;
use App\Http\Controllers\Public\PublicServiceController;
use Illuminate\Support\Facades\Route;

// Public portal routes
Route::get('/', [HomeController::class, 'index'])->name('home');
// Public Profile Standalone Pages
Route::get('/profil', [ProfileController::class, 'bapperida'])->name('profile');
Route::get('/profil/bapperida', [ProfileController::class, 'bapperida'])->name('profile.bapperida');
Route::get('/profil/visi-misi', [ProfileController::class, 'visiMisi'])->name('profile.visi-misi');
Route::get('/profil/struktur-organisasi', [ProfileController::class, 'strukturOrganisasi'])->name('profile.struktur-organisasi');
Route::get('/profil/tupoksi', [ProfileController::class, 'tupoksi'])->name('profile.tupoksi');
Route::get('/profil/pejabat', [ProfileController::class, 'pejabat'])->name('profile.pejabat');
Route::get('/profil/statistik-pegawai', [ProfileController::class, 'statistikPegawai'])->name('profile.statistik-pegawai');
Route::get('/profil/kontak', [ProfileController::class, 'kontak'])->name('profile.kontak');

// Public Documents (Repository & Standalone Category Pages)
Route::get('/dokumen', [PublicDocumentController::class, 'index'])->name('documents.index');
Route::get('/dokumen/perencanaan', [PublicDocumentController::class, 'perencanaan'])->name('documents.perencanaan');
Route::get('/dokumen/kajian', [PublicDocumentController::class, 'kajian'])->name('documents.kajian');
Route::get('/dokumen/analisis', [PublicDocumentController::class, 'analisis'])->name('documents.analisis');
Route::get('/dokumen/{slug}/unduh', [PublicDocumentController::class, 'download'])->name('documents.download');

// Public News (Magazine Hub & Standalone Bidang Pages)
Route::get('/berita', [PublicNewsController::class, 'index'])->name('news.index');
Route::get('/berita/umum', [PublicNewsController::class, 'umum'])->name('news.umum');
Route::get('/berita/ppe', [PublicNewsController::class, 'ppe'])->name('news.ppe');
Route::get('/berita/ppm', [PublicNewsController::class, 'ppm'])->name('news.ppm');
Route::get('/berita/psda', [PublicNewsController::class, 'psda'])->name('news.psda');
Route::get('/berita/ipw', [PublicNewsController::class, 'ipw'])->name('news.ipw');
Route::get('/berita/rida', [PublicNewsController::class, 'rida'])->name('news.rida');
Route::get('/berita/{slug}', [PublicNewsController::class, 'show'])->name('news.show');

// Public Awards (Penghargaan Daerah & Prestasi)
Route::get('/penghargaan', [PublicAwardController::class, 'index'])->name('awards.index');

// Public Reports (Laporan 4 Sub-Menu: IID, IDSD, IPKD, LAKIP)
Route::get('/laporan/iid', [PublicReportController::class, 'iid'])->name('reports.iid');
Route::get('/laporan/idsd', [PublicReportController::class, 'idsd'])->name('reports.idsd');
Route::get('/laporan/ipkd', [PublicReportController::class, 'ipkd'])->name('reports.ipkd');
Route::get('/laporan/lakip', [PublicReportController::class, 'lakip'])->name('reports.lakip');

// Public Services & Citizen Feedback
Route::get('/layanan', [PublicServiceController::class, 'index'])->name('services.index');
Route::post('/layanan/permohonan-data', [PublicServiceController::class, 'submitDataRequest'])->name('services.data-request');
Route::post('/layanan/survei-ikm', [PublicServiceController::class, 'submitSurvey'])->name('services.survey');

// Dynamic SEO XML Sitemap
Route::get('/sitemap.xml', function () {
    $baseUrl = config('app.url', url('/'));

    $staticRoutes = [
        ['loc' => '/', 'priority' => '1.0', 'freq' => 'daily'],
        ['loc' => '/profil', 'priority' => '0.8', 'freq' => 'weekly'],
        ['loc' => '/profil/bapperida', 'priority' => '0.8', 'freq' => 'monthly'],
        ['loc' => '/profil/visi-misi', 'priority' => '0.8', 'freq' => 'monthly'],
        ['loc' => '/profil/struktur-organisasi', 'priority' => '0.8', 'freq' => 'monthly'],
        ['loc' => '/profil/tupoksi', 'priority' => '0.8', 'freq' => 'monthly'],
        ['loc' => '/profil/pejabat', 'priority' => '0.8', 'freq' => 'weekly'],
        ['loc' => '/profil/statistik-pegawai', 'priority' => '0.8', 'freq' => 'monthly'],
        ['loc' => '/profil/kontak', 'priority' => '0.8', 'freq' => 'monthly'],
        ['loc' => '/dokumen', 'priority' => '0.9', 'freq' => 'daily'],
        ['loc' => '/dokumen/perencanaan', 'priority' => '0.9', 'freq' => 'weekly'],
        ['loc' => '/dokumen/kajian', 'priority' => '0.9', 'freq' => 'weekly'],
        ['loc' => '/dokumen/analisis', 'priority' => '0.9', 'freq' => 'weekly'],
        ['loc' => '/berita', 'priority' => '0.9', 'freq' => 'daily'],
        ['loc' => '/berita/umum', 'priority' => '0.8', 'freq' => 'daily'],
        ['loc' => '/berita/ppe', 'priority' => '0.8', 'freq' => 'daily'],
        ['loc' => '/berita/ppm', 'priority' => '0.8', 'freq' => 'daily'],
        ['loc' => '/berita/psda', 'priority' => '0.8', 'freq' => 'daily'],
        ['loc' => '/berita/ipw', 'priority' => '0.8', 'freq' => 'daily'],
        ['loc' => '/berita/rida', 'priority' => '0.8', 'freq' => 'daily'],
        ['loc' => '/penghargaan', 'priority' => '0.8', 'freq' => 'weekly'],
        ['loc' => '/laporan/iid', 'priority' => '0.9', 'freq' => 'weekly'],
        ['loc' => '/laporan/idsd', 'priority' => '0.9', 'freq' => 'weekly'],
        ['loc' => '/laporan/ipkd', 'priority' => '0.9', 'freq' => 'weekly'],
        ['loc' => '/laporan/lakip', 'priority' => '0.9', 'freq' => 'weekly'],
        ['loc' => '/layanan', 'priority' => '0.8', 'freq' => 'weekly'],
    ];

    $articles = \App\Models\NewsArticle::where('is_published', true)
        ->latest('published_at')
        ->get(['slug', 'updated_at']);

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    foreach ($staticRoutes as $r) {
        $xml .= "  <url>\n";
        $xml .= "    <loc>" . rtrim($baseUrl, '/') . $r['loc'] . "</loc>\n";
        $xml .= "    <lastmod>" . now()->toAtomString() . "</lastmod>\n";
        $xml .= "    <changefreq>" . $r['freq'] . "</changefreq>\n";
        $xml .= "    <priority>" . $r['priority'] . "</priority>\n";
        $xml .= "  </url>\n";
    }

    foreach ($articles as $art) {
        $xml .= "  <url>\n";
        $xml .= "    <loc>" . rtrim($baseUrl, '/') . '/berita/' . $art->slug . "</loc>\n";
        $xml .= "    <lastmod>" . ($art->updated_at?->toAtomString() ?? now()->toAtomString()) . "</lastmod>\n";
        $xml .= "    <changefreq>weekly</changefreq>\n";
        $xml .= "    <priority>0.8</priority>\n";
        $xml .= "  </url>\n";
    }

    $xml .= '</urlset>';

    return response($xml, 200, [
        'Content-Type' => 'application/xml; charset=utf-8',
    ]);
})->name('sitemap');

// Administrator routes
Route::prefix('admin')->group(function () {
    // Guest authentication
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
        Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
    });

    // Protected admin area
    Route::middleware('admin.auth')->group(function () {
        Route::get('/', fn () => redirect()->route('admin.dashboard'));
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

        // Modul Dokumen Perencanaan
        Route::get('/documents', [DocumentController::class, 'index'])->name('admin.documents.index');
        Route::post('/documents', [DocumentController::class, 'store'])->name('admin.documents.store');
        Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('admin.documents.update');
        Route::patch('/documents/{document}/toggle-publish', [DocumentController::class, 'togglePublish'])->name('admin.documents.toggle');
        Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('admin.documents.destroy');

        // Modul Publikasi & Berita 6 Bidang
        Route::get('/news', [NewsController::class, 'index'])->name('admin.news.index');
        Route::post('/news', [NewsController::class, 'store'])->name('admin.news.store');
        Route::put('/news/{article}', [NewsController::class, 'update'])->name('admin.news.update');
        Route::delete('/news/{article}', [NewsController::class, 'destroy'])->name('admin.news.destroy');

        // Modul Indeks Capaian Daerah
        Route::get('/indexes', [RegionalIndexController::class, 'index'])->name('admin.indexes.index');
        Route::put('/indexes/{index}', [RegionalIndexController::class, 'update'])->name('admin.indexes.update');
    });
});
