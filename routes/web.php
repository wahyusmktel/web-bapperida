<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\RegionalIndexController;
use Illuminate\Support\Facades\Route;

// Public portal routes
Route::inertia('/', 'Welcome')->name('home');

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
