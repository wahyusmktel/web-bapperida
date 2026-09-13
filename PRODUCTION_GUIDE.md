# PANDUAN DEPLOYMENT & OPERASIONAL PRODUKSI
## PORTAL RESMI BAPPERIDA KABUPATEN PRINGSEWU

Dokumen ini berisi instruksi teknis dan panduan operasional untuk mempublikasikan portal web resmi **BAPPERIDA Kabupaten Pringsewu** ke server produksi (*production environment*) dengan standar keamanan tinggi (*government grade*).

---

## 1. Persyaratan Server Produksi

- **Sistem Operasi**: Linux (Ubuntu 22.04 LTS / 24.04 LTS / Debian 12 direkomendasikan).
- **Web Server**: Nginx (direkomendasikan) atau Apache 2.4+ dengan `mod_rewrite` aktif.
- **PHP**: Versi 8.3+ dengan ekstensi:
  - `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `filter`, `mbstring`, `openssl`, `pcre`, `pdo_mysql`, `tokenizer`, `xml`.
- **Database**: MySQL 8.0+ atau MariaDB 10.6+.
- **In-Memory Cache & Queue**: **Redis 6.x / 7.x** (aktif pada port default `6379`).
- **SSL Certificate**: Sertifikat SSL/TLS aktif (Let's Encrypt / DigiCert Pemerintah) untuk HTTPS wajib.
- **Node.js**: Node 20.x+ / 22.x+ & NPM (untuk proses build aset front-end).

---

## 2. Konfigurasi Lingkungan (`.env` Produksi)

Salin berkas `.env.example` ke `.env` pada server produksi dan sesuaikan nilai kunci berikut:

```dotenv
APP_NAME="BAPPERIDA Kabupaten Pringsewu"
APP_ENV=production
APP_KEY=base64:... (generate dengan: php artisan key:generate)
APP_DEBUG=false
APP_URL=https://bapperida.pringsewukab.go.id

# Konfigurasi Database MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bapperida_db
DB_USERNAME=nama_user_mysql_aman
DB_PASSWORD=kata_sandi_mysql_kompleks

# Konfigurasi Cache, Session, dan Queue Menggunakan Redis
CACHE_STORE=redis
SESSION_DRIVER=redis
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
QUEUE_CONNECTION=redis

# Driver Redis (Menggunakan Predis yang sudah terpasang)
REDIS_CLIENT=predis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

---

## 3. Langkah-Langkah Deployment (Urutan Perintah)

Jalankan perintah berikut di direktori proyek pada server produksi:

```bash
# 1. Unduh pustaka PHP tanpa dependensi pengembangan
composer install --no-dev --optimize-autoloader

# 2. Instal dependensi frontend dan kompilasi aset Vite
npm ci
npm run build

# 3. Jalankan migrasi database
php artisan migrate --force

# 4. Hubungkan direktori storage publik untuk dokumen dan gambar
php artisan storage:link

# 5. Optimasi cache Laravel untuk performa maksimal
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

---

## 4. Konfigurasi Queue Worker (Supervisor)

Untuk menjalankan tugas antrean Redis (ekspor dokumen, kalkulasi indeks, pengiriman email) di latar belakang secara berkelanjutan, gunakan Supervisor:

Buat berkas `/etc/supervisor/conf.d/bapperida-worker.conf`:

```ini
[program:bapperida-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/bapperida/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/bapperida/storage/logs/worker.log
stopwaitsecs=3600
```

Aktifkan konfigurasi supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start bapperida-worker:*
```

---

## 5. Konfigurasi Keamanan Web Server Nginx

Berikut contoh blok server Nginx dengan pengamanan khusus pencegahan eksekusi berkas di folder upload:

```nginx
server {
    listen 80;
    server_name bapperida.pringsewukab.go.id;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name bapperida.pringsewukab.go.id;
    root /var/www/bapperida/public;

    ssl_certificate /etc/letsencrypt/live/bapperida.pringsewukab.go.id/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/bapperida.pringsewukab.go.id/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    index index.php index.html;
    charset utf-8;

    # Mencegah akses file tersembunyi (.env, .git)
    location ~ /\.(?!well-known).* {
        deny all;
    }

    # KEAMANAN KRUSIAL: Cegah eksekusi skrip PHP di folder storage/upload
    location ~* /storage/.*\.php$ {
        deny all;
        return 404;
    }

    # Penanganan route Inertia SPA
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Penanganan PHP-FPM
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    # Optimasi aset statis
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff2|svg)$ {
        expires 30d;
        add_header Cache-Control "public, no-transform";
    }
}
```

---

## 6. Akun Administrator BAPPERIDA

Setelah migrasi dan seeder awal dijalankan, akun administrator terdaftar secara bawaan:

- **Halaman Masuk**: `https://bapperida.pringsewukab.go.id/admin/login`
- **Email**: `admin@bapperida.pringsewukab.go.id`
- **Kata Sandi Default**: `PasswordBapperida2026!`

> [!CAUTION]
> **Tindakan Wajib Pasca-Deploy**:
> Segera ubah kata sandi administrator default melalui menu profil administrator atau perintah `php artisan tinker` setelah sistem dipublikasikan ke server daring.

---

## 7. Pemeliharaan & Monitoring Rutin

1. **Pembersihan Log**:
   Jalankan pembersihan log berkala via cron job:
   ```bash
   # Tambahkan ke crontab server
   * * * * * cd /var/www/bapperida && php artisan schedule:run >> /dev/null 2>&1
   ```
2. **Audit Keamanan Otomatis**:
   Dapat dijalankan kapan saja di server pementasan (*staging*):
   ```bash
   php artisan test --filter=SecurityAuditTest
   ```
3. **Backup Database Rutin**:
   Lakukan backup dump MySQL harian menggunakan `mysqldump` terenkripsi ke media penyimpanan terpisah.
