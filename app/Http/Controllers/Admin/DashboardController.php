<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\NewsArticle;
use App\Models\PlanningDocument;
use App\Models\RegionalIndex;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the BAPPERIDA administration dashboard.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();

        // Recent activity logs for live audit trail
        $recentActivities = ActivityLog::with('user:id,name,email')
            ->latest('created_at')
            ->take(8)
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'action' => $log->action,
                    'description' => $log->description,
                    'user_name' => $log->user?->name ?? 'Sistem / Tamu',
                    'ip_address' => $log->ip_address,
                    'created_at' => $log->created_at->diffForHumans(),
                ];
            });

        // Statistics overview with Redis Cache
        $stats = Cache::remember('bapperida:stats:overview', now()->addMinutes(15), function () {
            $iid = RegionalIndex::where('code', 'IID')->orderByDesc('year')->first();
            $idsd = RegionalIndex::where('code', 'IDSD')->orderByDesc('year')->first();
            $ipkd = RegionalIndex::where('code', 'IPKD')->orderByDesc('year')->first();

            return [
                'total_users' => User::count(),
                'total_documents' => PlanningDocument::count(),
                'total_news' => NewsArticle::count(),
                'total_services' => 12,
                'indexes' => [
                    'iid' => [
                        'name' => 'Indeks Inovasi Daerah (IID)',
                        'score' => (string) ($iid?->score ?? '62.45'),
                        'category' => $iid?->predicate ?? 'Sangat Inovatif',
                        'year' => $iid?->year ?? 2025,
                    ],
                    'idsd' => [
                        'name' => 'Indeks Daya Saing Daerah (IDSD)',
                        'score' => (string) ($idsd?->score ?? '3.42'),
                        'category' => $idsd?->predicate ?? 'Tinggi',
                        'year' => $idsd?->year ?? 2025,
                    ],
                    'ipkd' => [
                        'name' => 'Indeks Pengelolaan Keuangan Daerah (IPKD)',
                        'score' => (string) ($ipkd?->score ?? '84.10'),
                        'category' => $ipkd?->predicate ?? 'Baik',
                        'year' => $ipkd?->year ?? 2025,
                    ],
                ],
                'system' => [
                    'php_version' => PHP_VERSION,
                    'laravel_version' => app()->version(),
                    'db_driver' => DB::connection()->getDriverName(),
                    'server_time' => now()->translatedFormat('l, d F Y H:i:s T'),
                ],
            ];
        });

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recentActivities' => $recentActivities,
            'currentUser' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->primaryRoleName(),
                'last_login_at' => $user->last_login_at?->diffForHumans() ?? 'Sesi Pertama',
            ],
        ]);
    }
}
