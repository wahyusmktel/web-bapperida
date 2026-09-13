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
    public function index(): Response
    {
        $officials = Official::where('is_active', true)
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

        return Inertia::render('Public/Profile', [
            'officials' => $officials,
        ]);
    }
}
