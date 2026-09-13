---
name: bapperida-standards
description: >-
  Use this skill whenever developing, modifying, or auditing features for the BAPPERIDA Kabupaten Pringsewu web portal (Laravel + Inertia Vue 3 + TypeScript + Tailwind CSS). It enforces UUID primary keys, high-security hardening, anti-AI artisanal UI/UX, Redis caching, toast & SweetAlert2 feedback, and modern government communication standards.
---

# BAPPERIDA Pringsewu Development Skill

This skill contains the authoritative standards, design tokens, coding patterns, and security checklists for building and maintaining the official portal of **BAPPERIDA Kabupaten Pringsewu**.

---

## 1. Core Architecture & Coding Standards

### UUID as Primary Key (Non-Negotiable)
Every single Eloquent model in this application **must** use UUIDs:
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PlanningDocument extends Model
{
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;
}
```
Migrations standard:
```php
Schema::create('planning_documents', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->foreignUuid('category_id')->constrained('document_categories')->cascadeOnDelete();
    $table->string('title');
    $table->string('slug')->unique();
    // ...
    $table->timestamps();
});
```

### Redis Cache & Queue Patterns
- Use tags or clear prefix keys for cached government datasets:
```php
Cache::remember("bapperida:stats:indexes", now()->addHours(6), function () {
    return [
        'iid' => RegionalIndex::getLatestScore('IID'),
        'idsd' => RegionalIndex::getLatestScore('IDSD'),
        'ipkd' => RegionalIndex::getLatestScore('IPKD'),
    ];
});
```
- Heavy processes (document indexing, PDF compilation, email dispatch) must be queued:
```php
ProcessDocumentDownload::dispatch($documentId)->onQueue('default');
```

---

## 2. High-Grade Security Hardening (Government Standard)

1. **Security Headers Middleware**:
   Ensure all responses include:
   - `X-Frame-Options: SAMEORIGIN`
   - `X-Content-Type-Options: nosniff`
   - `Referrer-Policy: strict-origin-when-cross-origin`
   - `Permissions-Policy: camera=(), microphone=(), geolocation=()`
   - Strict `Content-Security-Policy`
2. **Throttling & Rate Limiting**:
   - Admin login: max 5 attempts per minute with exponential backoff.
   - Public submissions (Survei, Pengaduan, Permohonan Data): max 3 requests per 5 minutes per IP + Honeypot / captcha protection.
3. **Admin Authentication**:
   - Guarded routes with multi-role checks (RBAC).
   - 2FA / TOTP capability.
   - Forced session regeneration on privilege escalation.
   - Activity audit trail logging IP, user agent, action timestamp, and mutated payload.
4. **File Upload Hardening**:
   - Verify MIME type via file content inspection (not just file extension).
   - Store documents in private disks; serve downloads through signed/temporary routes with download rate limiting.

---

## 3. UI/UX Design System: "Bespoke & World-Class, Not Generic AI"

### Visual Tokens:
- **Tone**: Fresh, Light, Modern Governance, Dignified, Accessible.
- **Color Palette**:
  - Primary: Deep Emerald (`#0F766E` / `#0D9488`) or Deep Ocean Sapphire (`#0B4F6C` / `#0284C7`) reflecting sustainable development and regional wealth.
  - Accent / Gold: Warm Amber (`#D97706` / `#F59E0B`) for awards, achievements, and notices.
  - Backgrounds: Pristine White (`#FFFFFF`), Soft Porcelain (`#F8FAFC`), and subtle slate border cards (`#E2E8F0`).
  - Dark/Text: Deep Slate (`#0F172A`), Muted Text (`#475569`).
- **Typography**: Clean, geometric, contemporary sans-serif (`Plus Jakarta Sans` or `Inter`).
- **UI Components**:
  - Hero: Asymmetrical layout with live regional achievement metrics & quick search bar.
  - Cards: Crisp borders (`border border-slate-200/80 shadow-xs hover:shadow-md transition-all duration-300`).
  - Mobile UX: Sticky thumb-navigation bar at bottom (`Beranda`, `Layanan`, `Dokumen`, `Berita`, `Menu`), fast touch-response, zero layout shift.

---

## 4. Notifications & User Feedback

- **Toast Notifications**:
  Use lightweight, non-intrusive toast messages for passive updates (e.g. "Tautan disalin ke clipboard", "Data berhasil diperbarui").
- **SweetAlert2 Confirmation**:
  Must be triggered for all consequential actions:
  - Deleting records
  - Revoking administrator privileges
  - Archiving or publishing public documents
  - Unsaved form exit confirmations

---

## 5. Tone of Voice & Copywriting
- **Standard**: Bahasa Indonesia baku, santun, ramah, dan solutif.
- **Sapaan**: "Masyarakat Kabupaten Pringsewu", "Rekan Perencana", "Pengunjung Terhormat".
- **Action Verbs**: Tegas dan langsung ("Unduh Dokumen", "Konsultasikan Inovasi", "Pantau Indeks Pembangunan").
