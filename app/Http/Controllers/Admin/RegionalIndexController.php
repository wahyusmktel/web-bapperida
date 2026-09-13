<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\RegionalIndex;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

class RegionalIndexController extends Controller
{
    /**
     * Display a listing of regional development indexes.
     */
    public function index(): Response
    {
        $indexes = RegionalIndex::orderBy('year', 'desc')->get()->map(function ($idx) {
            return [
                'id' => $idx->id,
                'name' => $idx->name,
                'code' => $idx->code,
                'year' => $idx->year,
                'score' => (string) $idx->score,
                'predicate' => $idx->predicate,
                'evaluator' => $idx->evaluator,
                'description' => $idx->description,
                'is_active' => $idx->is_active,
                'updated_at' => $idx->updated_at->translatedFormat('d M Y H:i'),
            ];
        });

        return Inertia::render('Admin/Indexes/Index', [
            'indexes' => $indexes,
        ]);
    }

    /**
     * Update the specified regional index.
     */
    public function update(Request $request, RegionalIndex $index): RedirectResponse
    {
        $validated = $request->validate([
            'year' => ['required', 'integer', 'min:2020', 'max:2099'],
            'score' => ['required', 'numeric', 'min:0', 'max:100'],
            'predicate' => ['required', 'string', 'max:100'],
            'evaluator' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $index->update($validated);

        Cache::forget('bapperida:stats:overview');
        Cache::forget('bapperida:stats:indexes');

        ActivityLog::record(
            action: 'index.update',
            description: "Memperbarui skor {$index->name} menjadi {$index->score} ({$index->predicate})",
            properties: ['index_id' => $index->id, 'score' => $index->score, 'predicate' => $index->predicate]
        );

        return back()->with('success', 'Skor Indeks Capaian Daerah berhasil diperbarui.');
    }
}
