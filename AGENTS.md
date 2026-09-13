# BAPPERIDA PRINGSEWU - DEVELOPMENT GUIDELINES & CRITERIA

Proyek ini adalah redesign portal resmi **BAPPERIDA Kabupaten Pringsewu** (Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah).
Website target: `https://bapperida.pringsewukab.go.id/`
Stack: **Laravel 12 + Inertia.js (Vue 3) + Tailwind CSS v4 + TypeScript + MySQL + Redis**.

Setiap interaksi, implementasi fitur, dan modifikasi kode pada proyek ini **WAJIB** mematuhi kriteria dan standar berikut:

---

## 1. Arsitektur & Database
- **Wajib UUID**: Semua tabel Eloquent model **HARUS** menggunakan UUID sebagai primary key (`HasUuids` trait di Laravel).
  - Skema migrasi: `$table->uuid('id')->primary();`
  - Relasi foreign key: `$table->foreignUuid('related_id')->constrained();`
  - Tidak diperbolehkan mengekspos auto-increment integer ID pada URL, state Inertia, maupun API public.
- **SPA (Single Page Application)**: Menggunakan Inertia.js + Vue 3 dengan rendering mulus tanpa reload halaman penuh (smooth page transitions).
- **Redis Integration**:
  - Digunakan untuk caching data publik (indeks inovasi, dokumen perencanaan, berita terpopuler, statistik web).
  - Digunakan untuk queue worker data berat (ekspor dokumen, kalkulasi indeks, pengiriman notifikasi/email).
  - Session & cache driver diarahkan ke Redis saat production.

---

## 2. Keamanan Tingkat Tinggi (Anti Serangan / Government Grade)
- **Otentikasi Admin Berlapis**:
  - Rate limiting ketat pada endpoint login & sensitive routes (mencegah Brute Force & Credential Stuffing).
  - Session regeneration & pengamanan cookie (`HttpOnly`, `Secure`, `SameSite=Strict`).
  - Siap 2FA (Two-Factor Authentication / TOTP) untuk administrator level tinggi.
  - Implementasi JWT / Laravel Sanctum untuk pertukaran token API yang aman.
- **Proteksi Serangan Umum**:
  - Anti-SQL Injection: Hindari raw query tanpa parameter binding.
  - Anti-XSS: Sanitasi semua input dan output HTML (terutama konten berita/dokumen dari WYSIWYG).
  - Anti-CSRF: Seluruh request mutasi (POST/PUT/PATCH/DELETE) harus terlindungi token CSRF Inertia.
  - Security Headers Middleware: CSP (Content Security Policy), X-Frame-Options: SAMEORIGIN/DENY, X-Content-Type-Options: nosniff, Referrer-Policy: strict-origin-when-cross-origin, Permissions-Policy.
  - Upload File Aman: Validasi ekstensi dan MIME type nyata (magic bytes), rename acak file hash, dan cegah eksekusi script di folder upload.
  - Audit Trail: Catat riwayat aktivitas administrator (log login, create, update, delete) untuk akuntabilitas.

---

## 3. UI/UX "Bukan Buatan AI" (Desain Kelas Dunia & Modern Government)
- **Karakter Visual**:
  - Fresh, smooth, light, profesional, berwibawa namun bersahabat.
  - Bukan tampilan generik template bot/AI (hindari palet warna AI ungu-neon murahan atau layout bootstrap kaku).
  - Palet warna identitas Pringsewu: Deep Emerald / Teal / Smart Sapphire Blue dipadukan dengan Slate, Cool Gray, dan Warm Pearl White.
  - Tipografi modern, tegas, dan mudah dibaca (misalnya Plus Jakarta Sans / Inter).
  - Micro-interactions halus: hover state elegan, transisi tab cepat, skeleton loader saat data dimuat, dan glassmorphism lembut pada header/cards.
- **Mobile Friendly Maksimal**:
  - Masyarakat Pringsewu dominan mengakses via ponsel/smartphone.
  - Desain thumb-friendly: tombol mudah dijangkau, navigasi mobile responsif (opsi quick-access bottom bar untuk menu penting: Berita, Dokumen, Layanan, Kontak).
  - Ukuran font dan ruang ketuk (touch target minimal 44x44px) terjaga dengan baik.

---

## 4. Sistem Notifikasi & Konfirmasi
- **Toast Notifications**: Menggunakan Toast yang ringan, modern, dan tidak memblokir layar (misal `vue-sonner` atau toast terintegrasi) untuk notifikasi sukses/info singkat (misal: "Tautan berhasil disalin", "Draft tersimpan").
- **SweetAlert2**: Digunakan untuk setiap tindakan penting dan destruktif (misal: Konfirmasi Hapus Data, Konfirmasi Publikasi Dokumen, Pembatalan Perubahan, Logout).

---

## 5. Gaya Bahasa & Komunikasi Publik
- Bahasa Indonesia yang sopan, santun khas etika pemerintahan, namun komunikatif, lugas, dan relevan dengan masyarakat masa kini.
- Tidak kaku berlebihan (hindari jargon birokrasi yang membingungkan warga), tegas, ramah, dan solutif.
- Tombol aksi jelas dan berorientasi tindakan:
  - Contoh baik: "Unduh Dokumen RKPD", "Ajukan Permohonan Informasi", "Kirim Masukan & Aspirasi".
  - Hindari tombol ambigu seperti: "Klik Sini", "Submit", "Go".

---

## 6. Struktur Menu & Layanan Utama (Sesuai Portal Resmi Bapperida Pringsewu)
1. **Beranda**: Hero interaktif, Quick Stats (Indeks & Capaian), Sorotan Dokumen Utama, Berita Terbaru per Bidang, Tautan Cepat Layanan Publik.
2. **Profil**: Profil Bapperida, Visi & Misi, Struktur Organisasi (Visual Tree Interaktif), Tupoksi, Profil Pejabat, Statistik Pegawai, Kontak Kami.
3. **Dokumen Perencanaan & Riset**: Dokumen Perencanaan (RPJPD, RPJMD, RKPD, Renstra, Renja), Dokumen Kajian, Dokumen Analisis (dengan filter tahun, kategori, pencarian kilat, & preview).
4. **Publikasi & Berita per Bidang**:
   - Sekretariat / Umum
   - PPE (Perencanaan Pengendalian dan Evaluasi)
   - PPM (Pemerintahan dan Pembangunan Manusia)
   - PSDA (Perekonomian dan Sumber Daya Alam)
   - IPW (Infrastruktur dan Pengembangan Wilayah)
   - RIDA (Riset dan Inovasi Daerah)
5. **Layanan & Aspirasi**:
   - Permohonan Data & Informasi Publik
   - Integrasi SPAN-LAPOR! & PPID
   - Survei Kepuasan Masyarakat (IKM) interaktif
6. **Laporan & Dashboard Indeks**:
   - Indeks Inovasi Daerah (IID)
   - Indeks Daya Saing Daerah (IDSD)
   - Indeks Pengelolaan Keuangan Daerah (IPKD)
   - LAKIP / SAKIP & Penghargaan Daerah
7. **Tautan Eksternal Terintegrasi**: Pemkab Pringsewu, LPSE, ePajak, CCTV Pringsewu, Satu Data Pringsewu.
