<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Roles
        $rolesData = [
            [
                'name' => 'Super Administrator',
                'slug' => 'super_admin',
                'description' => 'Akses penuh seluruh konfigurasi sistem, audit log, manajemen pengguna, dan konten BAPPERIDA.',
            ],
            [
                'name' => 'Admin Perencanaan & Evaluasi (PPE)',
                'slug' => 'admin_perencanaan',
                'description' => 'Pengelolaan Dokumen Perencanaan Daerah (RPJPD, RPJMD, RKPD, Renstra, Renja, Kajian, Analisis).',
            ],
            [
                'name' => 'Admin Riset & Inovasi (RIDA)',
                'slug' => 'admin_riset',
                'description' => 'Pengelolaan data Riset, Inovasi Daerah, Indeks Inovasi Daerah (IID), dan Indeks Daya Saing Daerah (IDSD).',
            ],
            [
                'name' => 'Admin Bidang Pembangunan',
                'slug' => 'admin_bidang',
                'description' => 'Pengelolaan konten bidang PPM, PSDA, dan IPW.',
            ],
            [
                'name' => 'Operator Berita & Publikasi',
                'slug' => 'operator_berita',
                'description' => 'Pengelolaan rilis berita, agenda pimpinan, artikel publikasi, dan galeri kegiatan.',
            ],
            [
                'name' => 'Petugas Layanan & PPID',
                'slug' => 'petugas_layanan',
                'description' => 'Pengelolaan permohonan data informasi publik, integrasi SPAN-LAPOR!, dan survei IKM.',
            ],
        ];

        $roles = [];
        foreach ($rolesData as $data) {
            $roles[$data['slug']] = Role::firstOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }

        // 2. Permissions
        $permissionsData = [
            // Dokumen
            ['name' => 'Lihat Dokumen', 'slug' => 'documents.view', 'group' => 'Dokumen'],
            ['name' => 'Tambah Dokumen', 'slug' => 'documents.create', 'group' => 'Dokumen'],
            ['name' => 'Ubah Dokumen', 'slug' => 'documents.edit', 'group' => 'Dokumen'],
            ['name' => 'Hapus Dokumen', 'slug' => 'documents.delete', 'group' => 'Dokumen'],
            ['name' => 'Publikasi Dokumen', 'slug' => 'documents.publish', 'group' => 'Dokumen'],

            // Berita
            ['name' => 'Lihat Berita', 'slug' => 'news.view', 'group' => 'Berita'],
            ['name' => 'Tambah Berita', 'slug' => 'news.create', 'group' => 'Berita'],
            ['name' => 'Ubah Berita', 'slug' => 'news.edit', 'group' => 'Berita'],
            ['name' => 'Hapus Berita', 'slug' => 'news.delete', 'group' => 'Berita'],

            // Inovasi & Indeks
            ['name' => 'Kelola Indeks Daerah', 'slug' => 'indexes.manage', 'group' => 'Indeks'],

            // Layanan & PPID
            ['name' => 'Kelola Permohonan Data', 'slug' => 'services.manage', 'group' => 'Layanan'],

            // Pengguna & Sistem
            ['name' => 'Kelola Pengguna', 'slug' => 'users.manage', 'group' => 'Sistem'],
            ['name' => 'Lihat Audit Log', 'slug' => 'audit.view', 'group' => 'Sistem'],
        ];

        foreach ($permissionsData as $perm) {
            Permission::firstOrCreate(
                ['slug' => $perm['slug']],
                $perm
            );
        }

        // 3. Super Admin User Default
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@bapperida.pringsewukab.go.id'],
            [
                'name' => 'Super Administrator BAPPERIDA',
                'password' => Hash::make('PasswordBapperida2026!'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        $superAdmin->assignRole($roles['super_admin']);
    }
}
