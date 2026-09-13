<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Official;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the official profile of BAPPERIDA Pringsewu.
     */
    public function bapperida(): Response
    {
        return Inertia::render('Public/Profile', [
            'officials' => $this->getOfficials(),
        ]);
    }

    /**
     * Display Visi & Misi.
     */
    public function visiMisi(): Response
    {
        return Inertia::render('Public/Profile/VisiMisi');
    }

    /**
     * Display Struktur Organisasi.
     */
    public function strukturOrganisasi(): Response
    {
        return Inertia::render('Public/Profile/StrukturOrganisasi', [
            'officials' => $this->getOfficials(),
        ]);
    }

    /**
     * Display Tugas Pokok dan Fungsi.
     */
    public function tupoksi(): Response
    {
        return Inertia::render('Public/Profile/Tupoksi');
    }

    /**
     * Display Profil Pejabat.
     */
    public function pejabat(): Response
    {
        return Inertia::render('Public/Profile/Pejabat', [
            'officials' => $this->getOfficials(),
        ]);
    }

    /**
     * Display Statistik Pegawai.
     */
    public function statistikPegawai(): Response
    {
        return Inertia::render('Public/Profile/StatistikPegawai');
    }

    /**
     * Display Kontak Kami.
     */
    public function kontak(): Response
    {
        return Inertia::render('Public/Profile/Kontak');
    }

    /**
     * Helper to fetch active officials.
     */
    private function getOfficials()
    {
        return Official::where('is_active', true)
            ->orderBy('order')
            ->get()
            ->map(function ($off) {
                return [
                    'id' => $off->id,
                    'name' => $off->name,
                    'nip' => $off->nip ?? '-',
                    'position' => $off->position,
                    'category_code' => $off->category_code,
                ];
            });
    }
}
