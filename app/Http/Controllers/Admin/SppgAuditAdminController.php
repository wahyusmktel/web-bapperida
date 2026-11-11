<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SppgAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SppgAuditAdminController extends Controller
{
    /**
     * Tampilkan data dan analisa laporan audit kelayakan operasional SPPG.
     */
    public function index(Request $request): Response
    {
        $query = SppgAudit::query()->latest('inspection_date');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('sppg_name', 'like', "%{$search}%")
                  ->orWhere('sppg_id_code', 'like', "%{$search}%")
                  ->orWhere('inspector_name', 'like', "%{$search}%")
                  ->orWhere('inspection_number', 'like', "%{$search}%");
            });
        }

        if ($grade = $request->input('grade')) {
            $query->where('grade', $grade);
        }

        if ($recommendation = $request->input('recommendation')) {
            $query->where('recommendation', $recommendation);
        }

        if ($type = $request->input('type')) {
            $query->where('sppg_type', $type);
        }

        $audits = $query->paginate(12)->withQueryString();

        // Data Analitik & Distribusi
        $total = SppgAudit::count();
        $analytics = [
            'total_audits' => $total,
            'total_pm' => SppgAudit::sum('beneficiary_count'),
            'grade_a_count' => SppgAudit::where('grade', 'Grade A')->count(),
            'grade_b_count' => SppgAudit::where('grade', 'Grade B')->count(),
            'grade_d_count' => SppgAudit::where('grade', 'Grade D')->count(),
            'grade_a_percentage' => $total > 0 ? round((SppgAudit::where('grade', 'Grade A')->count() / $total) * 100, 1) : 0,
            'grade_b_percentage' => $total > 0 ? round((SppgAudit::where('grade', 'Grade B')->count() / $total) * 100, 1) : 0,
            'grade_d_percentage' => $total > 0 ? round((SppgAudit::where('grade', 'Grade D')->count() / $total) * 100, 1) : 0,
            'avg_total_score' => round(SppgAudit::avg('total_score') ?? 0, 1),
            'avg_food_safety' => round(SppgAudit::avg('score_keamanan_pangan') ?? 0, 1),
            'avg_legality_hr' => round(SppgAudit::avg('score_legalitas_sdm') ?? 0, 1),
            'avg_safety_land' => round(SppgAudit::avg('score_lahan_keselamatan') ?? 0, 1),
            'verified_count' => SppgAudit::where('status', 'verified')->count(),
            'submitted_count' => SppgAudit::where('status', 'submitted')->count(),
            'by_type' => [
                'BGN' => SppgAudit::where('sppg_type', 'BGN')->count(),
                'Mandiri' => SppgAudit::where('sppg_type', 'Mandiri')->count(),
                'Khusus' => SppgAudit::where('sppg_type', 'Khusus')->count(),
                'Terpencil' => SppgAudit::where('sppg_type', 'Terpencil')->count(),
                'Sekolah Rakyat' => SppgAudit::where('sppg_type', 'Sekolah Rakyat')->count(),
            ],
        ];

        return Inertia::render('Admin/SppgAudit/Index', [
            'audits' => $audits,
            'analytics' => $analytics,
            'filters' => $request->only(['search', 'grade', 'recommendation', 'type']),
        ]);
    }

    /**
     * Tampilkan detail audit untuk analisa mendalam admin.
     */
    public function show(string $id): Response
    {
        $audit = SppgAudit::findOrFail($id);

        return Inertia::render('Admin/SppgAudit/Show', [
            'audit' => $audit,
        ]);
    }

    /**
     * Verifikasi status audit SPPG (misal verifikasi dari Satgas Kabupaten).
     */
    public function toggleVerification(string $id): RedirectResponse
    {
        $audit = SppgAudit::findOrFail($id);
        $audit->status = $audit->status === 'verified' ? 'submitted' : 'verified';
        $audit->save();

        return back()->with('success', "Status audit {$audit->sppg_name} berhasil diperbarui menjadi {$audit->status}.");
    }

    /**
     * Hapus data audit.
     */
    public function destroy(string $id): RedirectResponse
    {
        $audit = SppgAudit::findOrFail($id);
        $name = $audit->sppg_name;
        $audit->delete();

        return back()->with('success', "Data audit {$name} berhasil dihapus dari sistem.");
    }
}
