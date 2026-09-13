<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
    /**
     * Display the admin login view.
     */
    public function showLogin(): Response|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return Inertia::render('Admin/Auth/Login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $throttleKey = Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());

        // Government-grade brute force rate limiting: max 5 attempts per 60 seconds
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            ActivityLog::record(
                action: 'auth.throttled',
                description: "Terlalu banyak percobaan login gagal dari IP {$request->ip()} untuk akun {$request->input('email')}.",
                properties: ['email' => $request->input('email'), 'available_in' => $seconds]
            );

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak upaya masuk yang gagal. Demi keamanan, silakan coba lagi dalam {$seconds} detik.",
            ]);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($throttleKey, 60);

            ActivityLog::record(
                action: 'auth.failed',
                description: "Percobaan login gagal untuk akun {$request->input('email')}.",
                properties: ['email' => $request->input('email')]
            );

            throw ValidationException::withMessages([
                'email' => 'Kredensial yang Anda berikan tidak cocok dengan data kami.',
            ]);
        }

        /** @var User $user */
        $user = Auth::user();

        // Check if account is active
        if (! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            ActivityLog::record(
                action: 'auth.suspended_attempt',
                description: "Akun nonaktif mencoba login: {$user->email}.",
                userId: $user->id
            );

            throw ValidationException::withMessages([
                'email' => 'Akun administrator Anda telah dinonaktifkan. Silakan hubungi Super Administrator.',
            ]);
        }

        // Clear rate limiter upon successful authentication
        RateLimiter::clear($throttleKey);

        // Regenerate session to prevent session fixation attacks
        $request->session()->regenerate();

        // Record last login metadata
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);

        ActivityLog::record(
            action: 'auth.login',
            description: "Administrator {$user->name} ({$user->email}) berhasil masuk ke sistem.",
            userId: $user->id
        );

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            ActivityLog::record(
                action: 'auth.logout',
                description: "Administrator {$user->name} keluar dari sistem.",
                userId: $user->id
            );
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda telah berhasil keluar.');
    }
}
