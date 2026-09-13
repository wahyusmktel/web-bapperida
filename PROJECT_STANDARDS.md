# DOKUMEN STANDAR DAN KRITERIA PENGEMBANGAN
## PORTAL RESMI BAPPERIDA KABUPATEN PRINGSEWU
*(Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah)*

Dokumen ini merupakan panduan resmi arsitektur, keamanan, desain UI/UX, dan alur kerja pengembangan ulang (redesign) website `https://bapperida.pringsewukab.go.id/`.

---

## 1. Identitas & Visi Proyek

- **Nama Instansi**: BAPPERIDA (Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah) Kabupaten Pringsewu, Provinsi Lampung.
- **Tujuan Redesign**:
  - Menghadirkan portal representatif pemerintahan daerah masa kini yang **fresh, smooth, light, profesional, dan berwibawa**.
  - Memberikan kemudahan akses informasi perencanaan, riset, inovasi, dan akuntabilitas bagi seluruh masyarakat Kabupaten Pringsewu.
  - Menghadirkan sistem yang **kebal serangan siber (anti-hacker)**, andal, dan siap menangani lalu lintas data tinggi dengan arsitektur modern.
  - Membangun antarmuka kelas dunia yang **otentik, artisanal, dan tidak berpenampilan seperti template AI/generik**.

---

## 2. Standar Arsitektur & Stack Teknologi

| Komponen | Teknologi | Keterangan |
| :--- | :--- | :--- |
| **Backend Framework** | Laravel 12 (PHP 8.3+) | Modern, modular, scalable |
| **Frontend Framework** | Vue 3 (Composition API + `<script setup>`) | Reaktif, efisien, SPA |
| **Adapter SPA** | Inertia.js v3 | Seamless backend-frontend tanpa reload |
| **Styling Engine** | Tailwind CSS v4 | Utility-first, clean design token |
| **Type Safety** | TypeScript | Menghindari bug runtime frontend |
| **Database** | MySQL | Primary storage data terstruktur |
| **Primary Key** | **UUID (Universally Unique Identifier)** | `HasUuids` pada seluruh model Eloquent |
| **Cache & Queue** | **Redis** | Caching dataset publik & background processing data berat |
| **Otentikasi Admin** | Multi-Layer Auth + 2FA Ready + JWT/Sanctum | Tingkat keamanan tinggi |
| **Feedback UI** | Toast (Vue-Sonner) + SweetAlert2 | Real-time toasts & modal konfirmasi aksi krusial |

---

## 3. Standar Kunci Non-Negosiasi

### A. Wajib UUID pada Seluruh Tabel
- Tidak ada ID integer auto-increment yang diekspos keluar.
- Seluruh model wajib mengimplementasikan `Illuminate\Database\Eloquent\Concerns\HasUuids`.
- Semua migrasi menggunakan:
  ```php
  $table->uuid('id')->primary();
  $table->foreignUuid('foreign_table_id')->constrained();
  ```

### B. Keamanan Siber Standar Pemerintahan (Anti-Hacker Hardening)
1. **Perlindungan Injeksi & Penetrasi**:
   - Sanitasi input ketat via Laravel FormRequests.
   - Parameterized query wajib (zero raw SQL concatenation).
   - Penggunaan HTML Purifier / DOMPurify untuk konten berita dan dokumen publik.
2. **Security Headers Middleware**:
   - `Content-Security-Policy` (CSP) yang terkonfigurasi aman.
   - `X-Frame-Options: SAMEORIGIN` (mencegah Clickjacking).
   - `X-Content-Type-Options: nosniff` (mencegah MIME-sniffing).
   - `Referrer-Policy: strict-origin-when-cross-origin`.
   - `Permissions-Policy: camera=(), microphone=(), geolocation=()`.
3. **Proteksi Otentikasi & Brute Force**:
   - Throttle ketat pada route login dan formulir publik (`RateLimiter`).
   - Anti-Brute Force dengan exponential backoff dan IP lockout.
   - Session fixation mitigation (`$request->session()->regenerate()`).
   - Pengamanan cookie: `HttpOnly`, `SameSite=Strict`, `Secure`.
   - 2FA (Two-Factor Authentication / TOTP) untuk level Administrator.
   - Dukungan JWT (JSON Web Token) / Sanctum untuk akses API internal dan pihak ketiga.
4. **Keamanan Berkas & Dokumen Publik**:
   - Validasi ganda tipe MIME (pemeriksaan magic bytes, bukan sekadar ekstensi nama file).
   - Berkas diunggah dengan nama acak hash unik ke disk privat/terlindungi.
   - Unduhan dokumen publik dilindungi rate limiter dan streaming aman (mencegah path traversal & direct script execution).
5. **Audit Trail & Logging**:
   - Seluruh mutasi data penting di admin (create, update, delete, status toggle) dicatat ke dalam audit log (User, IP, Perangkat, Timestamp, Payload perubahan).

### C. Redis: Caching & Heavy Data Queue
- **Redis Cache**:
  - Digunakan untuk data publik yang sering diakses: Indeks Daerah (IID, IDSD, IPKD), Dokumen Perencanaan (RPJMD, RKPD), Berita Populer, dan Statistik Pengunjung.
  - Tagging cache untuk kemudahan cache invalidation saat admin melakukan update.
- **Redis Queue**:
  - Pemrosesan dokumen berat (generasi ringkasan, ekspor data, rekap survei IKM, pengiriman notifikasi email/webhook) ditangani di background worker.

---

## 4. Standar UI/UX "Artisanal & Desain Kelas Dunia"

### Filosofi Visual
- **Menolak Tampilan AI Generik**: Hindari layout template AI yang monoton (seperti ungu-gradien khas generator AI, card generik tanpa hirarki, atau tombol tanpa micro-interaction).
- **Kesan Instansi**: Berwibawa, modern, terpercaya, transparan, dan inovatif.
- **Palet Warna**:
  - **Primary**: *Pringsewu Deep Teal & Emerald* (`#0F766E`, `#0D9488`, `#115E59`) – melambangkan pembangunan berkelanjutan, riset terpadu, dan kemakmuran daerah.
  - **Secondary / Accent**: *Warm Heritage Gold / Amber* (`#D97706`, `#F59E0B`) – melambangkan prestasi, penghargaan, dan inovasi unggulan.
  - **Neutral**: *Clean Slate & Warm Pearl* (`#0F172A`, `#334155`, `#F8FAFC`, `#FFFFFF`) – memberikan kesan ruang bersih, ringan, dan kontras tinggi yang nyaman di mata.
- **Tipografi**: Menggunakan font sans-serif berkarakter modern dan bersih (seperti *Plus Jakarta Sans* atau *Inter*) dengan skala hirarki heading yang seimbang.
- **Micro-Interactions**:
  - Transisi halaman halus (Inertia progress bar bernuansa elegan).
  - Hover state interaktif dengan elevasi lembut (`shadow-xs` ke `shadow-md`), bukan shadow hitam tebal kasar.
  - Skeleton loading halus saat menunggu data.

### Mobile-First & Aksesibilitas
- Mayoritas masyarakat Pringsewu mengakses portal melalui perangkat seluler (smartphone).
- **Prinsip Mobile UX**:
  - Navigasi jempol mudah (Thumb-friendly touch target minimal 44x44px).
  - Quick-access bottom navigation bar di versi seluler untuk akses cepat ke: **Beranda**, **Dokumen**, **Layanan**, **Berita**, dan **Kontak/Aspirasi**.
  - Loading super cepat dengan aset teroptimasi, kompresi gambar modern (WebP/AVIF), dan code-splitting Vite.

---

## 5. Sistem Notifikasi & Interaksi Pengguna

- **Toast Notifications (Vue-Sonner)**:
  - Notifikasi ringan, elegan, muncul di sudut layar tanpa mengganggu pandangan pengguna.
  - Digunakan untuk: "Tautan berhasil disalin", "Pencarian ditemukan", "Draft tersimpan", "Notifikasi sukses sistem".
- **SweetAlert2 (Konfirmasi Aksi Krusial)**:
  - Digunakan untuk setiap tindakan dengan konsekuensi:
    - Konfirmasi hapus data
    - Konfirmasi penerbitan dokumen resmi
    - Konfirmasi perubahan status layanan
    - Konfirmasi pembatalan atau reset form
  - Didesain dengan tema senada (custom styling konsisten dengan palet Bapperida).

---

## 6. Nada Bahasa & Komunikasi Publik (Etika Pemerintahan Modern)

- Menggunakan Bahasa Indonesia yang baik, santun, dan menghormati etika keprotokolan pemerintahan.
- Tetap relevan, luwes, komunikatif, dan tidak kaku berlebihan sehingga mudah dimengerti oleh generasi muda, akademisi, inovator, maupun masyarakat umum.
- Sapaan yang bersahabat: *"Selamat datang di Portal Resmi BAPPERIDA Kabupaten Pringsewu"*, *"Masyarakat Pringsewu yang kami hormati"*, *"Rekan Perencana & Inovator Daerah"*.
- Label aksi yang solutif:
  - *"Telusuri Dokumen Perencanaan"*
  - *"Ajukan Permohonan Data"*
  - *"Pantau Indeks Pembangunan"*
  - *"Sampaikan Masukan & Pengaduan"*

---

## 7. Rencana Tahapan Pengembangan Bertahap (Development Roadmap)

1. **Tahap 1: Fondasi & Basis Sistem (Foundation Phase)**
   - Setup konfigurasi security middleware, sanitasi, dan rate limiter.
   - Konfigurasi UUID Base Model & Trait.
   - Konfigurasi Redis cache, session, dan queue.
   - Setup integrasi Toast (Vue-Sonner) & SweetAlert2 di Vue 3.
   - Setup Desain Sistem, Palet Warna Tailwind v4, & Tipografi Modern.
2. **Tahap 2: Arsitektur Otentikasi & Panel Admin (High-Security Admin Core)**
   - Sistem login admin terlindungi (Rate limiting, session protection, lockout).
   - Role & Permission (RBAC): Super Admin, Administrator Bidang, Editor Berita, Petugas Layanan/PPID.
   - Dashboard Admin Bapperida yang bersih, informatif, dan intuitif.
   - Audit trail log sistem.
3. **Tahap 3: Modul Data & Konten Utama (Core Modules)**
   - Modul Dokumen Perencanaan & Riset (RPJPD, RPJMD, RKPD, Kajian, Analisis) + Filter Cepat + Download counter.
   - Modul Berita & Publikasi per 6 Bidang (PPE, PPM, PSDA, IPW, RIDA, Umum).
   - Modul Profil & Struktur Organisasi Interaktif.
   - Modul Indeks Pembangunan (IID, IDSD, IPKD, SAKIP/LAKIP) dengan visualisasi grafik metrik yang elegan.
4. **Tahap 4: Front-Office Publik & Portal Interaktif (Public Experience)**
   - Halaman Beranda (Hero interaktif, Quick Action Cards, Indeks Realtime, Berita Terbaru).
   - Halaman Profil Instansi & Tupoksi.
   - Halaman Repository Dokumen Publik dengan preview dan filter instan.
   - Halaman Layanan Publik (Permohonan Data, SPAN LAPOR!, PPID, Form Survei IKM).
   - Halaman Kontak, Lokasi Peta, & Tautan Eksternal Terintegrasi (Pemkab, LPSE, ePajak, CCTV, Satu Data).
   - Navigasi Mobile Responsif + Bottom Navigation Bar.
5. **Tahap 5: Audit Keamanan, Optimasi Performa, & Deployment Ready**
   - Audit celah keamanan (OWASP Top 10 checklist).
   - Optimasi query, caching Redis, dan indexing database.
   - Uji responsivitas di berbagai resolusi layar ponsel dan desktop.
   - Build produksi & sinkronisasi Git.
