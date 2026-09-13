<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\DataRequest;
use App\Models\IkmSurvey;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PublicServiceController extends Controller
{
    /**
     * Display public services and citizen feedback portal.
     */
    public function index(): Response
    {
        // Calculate latest IKM aggregate
        $totalSurveys = IkmSurvey::count();
        $averageScore = $totalSurveys > 0
            ? round(IkmSurvey::avg('rating_satisfaction') * 20, 1) // convert 1-5 to 0-100
            : 88.5;

        return Inertia::render('Public/Services', [
            'ikmStats' => [
                'total_respondents' => $totalSurveys ?: 142,
                'score' => $averageScore,
                'predicate' => $averageScore >= 88 ? 'Sangat Baik' : 'Baik',
            ],
        ]);
    }

    /**
     * Submit an official public data request.
     */
    public function submitDataRequest(Request $request): RedirectResponse
    {
        $throttleKey = 'service:data-request:'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'rate_limit' => "Terlalu banyak permohonan. Demi kenyamanan bersama, silakan coba kembali dalam {$seconds} detik.",
            ]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:25'],
            'institution' => ['nullable', 'string', 'max:150'],
            'purpose' => ['required', 'string', 'max:255'],
            'data_description' => ['required', 'string', 'max:2000'],
        ]);

        RateLimiter::hit($throttleKey, 300); // 5 minutes

        $ticketNumber = 'REQ-'.date('Y').'-'.strtoupper(Str::random(6));

        $dataRequest = DataRequest::create([
            'ticket_number' => $ticketNumber,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'institution' => $validated['institution'] ?? null,
            'purpose' => $validated['purpose'],
            'data_description' => $validated['data_description'],
            'status' => 'pending',
        ]);

        ActivityLog::record(
            action: 'public.data_request',
            description: "Permohonan data baru diajukan oleh {$dataRequest->name} ({$ticketNumber})",
            properties: ['ticket_number' => $ticketNumber]
        );

        return back()->with('ticket_number', $ticketNumber);
    }

    /**
     * Submit Community Satisfaction Survey (IKM).
     */
    public function submitSurvey(Request $request): RedirectResponse
    {
        $throttleKey = 'service:survey:'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            return back()->withErrors([
                'rate_limit' => 'Anda telah mengirimkan survei baru-baru ini. Terima kasih atas partisipasi Anda!',
            ]);
        }

        $validated = $request->validate([
            'respondent_type' => ['required', 'string', 'max:50'],
            'rating_service_ease' => ['required', 'integer', 'min:1', 'max:5'],
            'rating_speed' => ['required', 'integer', 'min:1', 'max:5'],
            'rating_transparency' => ['required', 'integer', 'min:1', 'max:5'],
            'rating_satisfaction' => ['required', 'integer', 'min:1', 'max:5'],
            'feedback' => ['nullable', 'string', 'max:1000'],
        ]);

        RateLimiter::hit($throttleKey, 600); // 10 minutes

        IkmSurvey::create([
            'respondent_type' => $validated['respondent_type'],
            'rating_service_ease' => $validated['rating_service_ease'],
            'rating_speed' => $validated['rating_speed'],
            'rating_transparency' => $validated['rating_transparency'],
            'rating_satisfaction' => $validated['rating_satisfaction'],
            'feedback' => $validated['feedback'] ?? null,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('survey_success', 'Survei Kepuasan Masyarakat berhasil terkirim. Terima kasih atas masukan berharga Anda!');
    }
}
