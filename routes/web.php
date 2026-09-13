<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\RegionalIndexController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProfileController;
use App\Http\Controllers\Public\PublicDocumentController;
use App\Http\Controllers\Public\PublicNewsController;
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

// Public Documents
Route::get('/dokumen', [PublicDocumentController::class, 'index'])->name('documents.index');
Route::get('/dokumen/{slug}/unduh', [PublicDocumentController::class, 'download'])->name('documents.download');

// Public News
Route::get('/berita', [PublicNewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [PublicNewsController::class, 'show'])->name('news.show');

// Public Services & Citizen Feedback
Route::get('/layanan', [PublicServiceController::class, 'index'])->name('services.index');
Route::post('/layanan/permohonan-data', [PublicServiceController::class, 'submitDataRequest'])->name('services.data-request');
Route::post('/layanan/survei-ikm', [PublicServiceController::class, 'submitSurvey'])->name('services.survey');

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
