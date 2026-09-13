<?php

namespace Database\Seeders;

use App\Models\DocumentCategory;
use App\Models\NewsArticle;
use App\Models\NewsCategory;
use App\Models\Official;
use App\Models\PlanningDocument;
use App\Models\RegionalIndex;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BapperidaDataSeeder extends Seeder
{
    /**
     * Seed core BAPPERIDA domain data.
     */
    public function run(): void
    {
        $superAdmin = User::first();

        // 1. Kategori Dokumen
        $docCategories = [
            [
                'name' => 'Dokumen Perencanaan',
                'slug' => 'dokumen-perencanaan',
                'description' => 'Dokumen perencanaan induk daerah meliputi RPJPD, RPJMD, RKPD, Renstra, dan Renja.',
            ],
            [
                'name' => 'Dokumen Kajian',
                'slug' => 'dokumen-kajian',
                'description' => 'Kajian strategis kebijakan daerah, kelayakan program, dan naskah akademik.',
            ],
            [
                'name' => 'Dokumen Analisis',
                'slug' => 'dokumen-analisis',
                'description' => 'Analisis data spasial, ekonomi makro daerah, dan evaluasi capaian pembangunan.',
            ],
            [
                'name' => 'Laporan Akuntabilitas',
                'slug' => 'laporan-akuntabilitas',
                'description' => 'Laporan Akuntabilitas Kinerja Instansi Pemerintah (LAKIP) dan evaluasi SAKIP.',
            ],
        ];

        $savedDocCats = [];
        foreach ($docCategories as $cat) {
            $savedDocCats[$cat['slug']] = DocumentCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 2. Dokumen Perencanaan Riil/Contoh
        $documents = [
            [
                'category_id' => $savedDocCats['dokumen-perencanaan']->id,
                'user_id' => $superAdmin?->id,
                'title' => 'Rencana Kerja Pemerintah Daerah (RKPD) Kabupaten Pringsewu Tahun 2026',
                'slug' => Str::slug('Rencana Kerja Pemerintah Daerah (RKPD) Kabupaten Pringsewu Tahun 2026'),
                'year' => 2026,
                'document_number' => 'Perbup No. 18 Tahun 2025',
                'description' => 'Dokumen RKPD memuat rancangan kerangka ekonomi daerah, prioritas pembangunan daerah, serta rencana kerja dan pendanaan untuk tahun 2026.',
                'file_name' => 'RKPD_Kabupaten_Pringsewu_2026.pdf',
                'file_size' => 14250000,
                'file_mime' => 'application/pdf',
                'downloads_count' => 184,
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'category_id' => $savedDocCats['dokumen-perencanaan']->id,
                'user_id' => $superAdmin?->id,
                'title' => 'Rencana Pembangunan Jangka Menengah Daerah (RPJMD) Kabupaten Pringsewu 2025-2029',
                'slug' => Str::slug('Rencana Pembangunan Jangka Menengah Daerah (RPJMD) Kabupaten Pringsewu 2025-2029'),
                'year' => 2025,
                'document_number' => 'Perda No. 04 Tahun 2025',
                'description' => 'Arah kebijakan dan strategi pembangunan lima tahunan Kabupaten Pringsewu menuju daerah yang berdaya saing, agraris mandiri, dan berkeadaban.',
                'file_name' => 'RPJMD_Pringsewu_2025_2029.pdf',
                'file_size' => 28400000,
                'file_mime' => 'application/pdf',
                'downloads_count' => 420,
                'is_published' => true,
                'published_at' => now()->subDays(30),
            ],
            [
                'category_id' => $savedDocCats['dokumen-perencanaan']->id,
                'user_id' => $superAdmin?->id,
                'title' => 'Rencana Strategis (Renstra) BAPPERIDA Kabupaten Pringsewu Tahun 2025-2029',
                'slug' => Str::slug('Rencana Strategis (Renstra) BAPPERIDA Kabupaten Pringsewu Tahun 2025-2029'),
                'year' => 2025,
                'document_number' => 'Kepka Bapperida No. 02/2025',
                'description' => 'Renstra BAPPERIDA memuat visi teknis perencanaan, target indeks inovasi, dan roadmap riset daerah.',
                'file_name' => 'Renstra_Bapperida_Pringsewu_2025_2029.pdf',
                'file_size' => 8600000,
                'file_mime' => 'application/pdf',
                'downloads_count' => 95,
                'is_published' => true,
                'published_at' => now()->subDays(20),
            ],
            [
                'category_id' => $savedDocCats['dokumen-kajian']->id,
                'user_id' => $superAdmin?->id,
                'title' => 'Kajian Strategis Penanganan Kemiskinan Ekstrem dan Stunting Berbasis Spasial',
                'slug' => Str::slug('Kajian Strategis Penanganan Kemiskinan Ekstrem dan Stunting Berbasis Spasial'),
                'year' => 2025,
                'document_number' => 'Naskah Akademik 08/RIDA/2025',
                'description' => 'Kajian kolaboratif Bapperida bersama akademisi untuk pemetaan intervensi gizi terpadu di 9 kecamatan.',
                'file_name' => 'Kajian_Stunting_Kemiskinan_Pringsewu_2025.pdf',
                'file_size' => 5200000,
                'file_mime' => 'application/pdf',
                'downloads_count' => 112,
                'is_published' => true,
                'published_at' => now()->subDays(15),
            ],
            [
                'category_id' => $savedDocCats['laporan-akuntabilitas']->id,
                'user_id' => $superAdmin?->id,
                'title' => 'Laporan Akuntabilitas Kinerja Instansi Pemerintah (LAKIP) BAPPERIDA 2025',
                'slug' => Str::slug('Laporan Akuntabilitas Kinerja Instansi Pemerintah (LAKIP) BAPPERIDA 2025'),
                'year' => 2025,
                'document_number' => 'LAKIP-BAPPERIDA-2025',
                'description' => 'Laporan pertanggungjawaban pencapaian sasaran strategis, efisiensi anggaran, dan realisasi kinerja BAPPERIDA.',
                'file_name' => 'LAKIP_BAPPERIDA_2025.pdf',
                'file_size' => 6700000,
                'file_mime' => 'application/pdf',
                'downloads_count' => 76,
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
        ];

        foreach ($documents as $doc) {
            PlanningDocument::firstOrCreate(['slug' => $doc['slug']], $doc);
        }

        // 3. Kategori Berita 6 Bidang Resmi
        $newsCategories = [
            [
                'name' => 'Sekretariat / Umum',
                'code' => 'UMUM',
                'slug' => 'umum',
                'description' => 'Kegiatan kesekretariatan, kepegawaian, keuangan, dan tata usaha Bapperida.',
                'color' => 'slate',
            ],
            [
                'name' => 'Perencanaan Pengendalian dan Evaluasi',
                'code' => 'PPE',
                'slug' => 'ppe',
                'description' => 'Penyusunan RPJMD, RKPD, Musrenbang, dan evaluasi berkala capaian pembangunan.',
                'color' => 'teal',
            ],
            [
                'name' => 'Pemerintahan dan Pembangunan Manusia',
                'code' => 'PPM',
                'slug' => 'ppm',
                'description' => 'Perencanaan bidang pendidikan, kesehatan, sosial, ketenagakerjaan, dan aparatur.',
                'color' => 'blue',
            ],
            [
                'name' => 'Perekonomian dan Sumber Daya Alam',
                'code' => 'PSDA',
                'slug' => 'psda',
                'description' => 'Pengembangan sentra UMKM, pertanian, perikanan, perdagangan, dan lingkungan hidup.',
                'color' => 'emerald',
            ],
            [
                'name' => 'Infrastruktur dan Pengembangan Wilayah',
                'code' => 'IPW',
                'slug' => 'ipw',
                'description' => 'Tata ruang kota, konektivitas jalan, sanitasi, perumahan, dan utilitas daerah.',
                'color' => 'amber',
            ],
            [
                'name' => 'Riset dan Inovasi Daerah',
                'code' => 'RIDA',
                'slug' => 'rida',
                'description' => 'Inovasi daerah, ekosistem riset, lomba kreativitas inovasi, dan indeks IID/IDSD.',
                'color' => 'purple',
            ],
        ];

        $savedNewsCats = [];
        foreach ($newsCategories as $cat) {
            $savedNewsCats[$cat['code']] = NewsCategory::firstOrCreate(['code' => $cat['code']], $cat);
        }

        // 4. Berita / Artikel Publikasi per Bidang
        $articles = [
            [
                'category_id' => $savedNewsCats['PPE']->id,
                'author_id' => $superAdmin?->id,
                'title' => 'BAPPERIDA Pringsewu Gelar Forum Konsultasi Publik Rancangan Awal RKPD 2026',
                'slug' => Str::slug('BAPPERIDA Pringsewu Gelar Forum Konsultasi Publik Rancangan Awal RKPD 2026'),
                'excerpt' => 'Forum konsultasi publik bertujuan menghimpun aspirasi pemangku kepentingan dan menyelaraskan prioritas pembangunan Kabupaten Pringsewu tahun 2026.',
                'content' => '<p>Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah (BAPPERIDA) Kabupaten Pringsewu menggelar Forum Konsultasi Publik Rancangan Awal Rencana Kerja Pemerintah Daerah (RKPD) Tahun 2026 secara hibrid yang dihadiri oleh seluruh pimpinan perangkat daerah, akademisi, tokoh masyarakat, dan perwakilan generasi muda.</p><p>Kepala BAPPERIDA menegaskan pentingnya kolaborasi pentahelix untuk memastikan pembangunan yang inklusif, adaptif terhadap perubahan iklim, dan berorientasi pada peningkatan kesejahteraan masyarakat di seluruh kecamatan se-Kabupaten Pringsewu.</p>',
                'views_count' => 342,
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'category_id' => $savedNewsCats['RIDA']->id,
                'author_id' => $superAdmin?->id,
                'title' => 'Kabupaten Pringsewu Raih Predikat Sangat Inovatif pada Indeks Inovasi Daerah 2025',
                'slug' => Str::slug('Kabupaten Pringsewu Raih Predikat Sangat Inovatif pada Indeks Inovasi Daerah 2025'),
                'excerpt' => 'Dengan skor 62,45, Kabupaten Pringsewu kembali menorehkan prestasi gemilang dalam penilaian Indeks Inovasi Daerah oleh Kemendagri RI.',
                'content' => '<p>Kementerian Dalam Negeri Republik Indonesia secara resmi merilis hasil pengukuran Indeks Inovasi Daerah (IID) tahun 2025. Kabupaten Pringsewu sukses meraih predikat Sangat Inovatif dengan skor 62,45.</p><p>Capaian ini didorong oleh penerapan puluhan inovasi layanan publik berbasis digital, inovasi tata kelola pemerintahan desa, dan kemudahan akses data untuk masyarakat.</p>',
                'views_count' => 528,
                'is_published' => true,
                'published_at' => now()->subDays(4),
            ],
            [
                'category_id' => $savedNewsCats['IPW']->id,
                'author_id' => $superAdmin?->id,
                'title' => 'Sinkronisasi Rencana Tata Ruang Wilayah (RTRW) Pringsewu Dukung Kawasan Industri Hijau',
                'slug' => Str::slug('Sinkronisasi Rencana Tata Ruang Wilayah RTRW Pringsewu Dukung Kawasan Industri Hijau'),
                'excerpt' => 'Bidang IPW mematangkan revisi RTRW untuk menjamin kepastian investasi dan perlindungan lahan pertanian pangan berkelanjutan.',
                'content' => '<p>Bidang Infrastruktur dan Pengembangan Wilayah (IPW) BAPPERIDA memfasilitasi rapat koordinasi penataan ruang bersama kementerian terkait. Penyesuaian RTRW ini difokuskan pada penguatan koridor ekonomi antardaerah dengan tetap mempertahankan lahan sawah dilindungi (LSD).</p>',
                'views_count' => 210,
                'is_published' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'category_id' => $savedNewsCats['PSDA']->id,
                'author_id' => $superAdmin?->id,
                'title' => 'Penguatan Ketahanan Pangan Melalui Hilirisasi Komoditas Pertanian Unggulan',
                'slug' => Str::slug('Penguatan Ketahanan Pangan Melalui Hilirisasi Komoditas Pertanian Unggulan'),
                'excerpt' => 'Bidang PSDA merumuskan strategi penguatan rantai pasok komoditas beras, kakao, dan hortikultura di sentra agribisnis Pringsewu.',
                'content' => '<p>Sebagai lumbung pangan potensial di Provinsi Lampung, Kabupaten Pringsewu terus memacu produktivitas petani lewat program hilirisasi dan digitalisasi pemasaran hasil panen yang diintegrasikan dalam dokumen perencanaan tahunan.</p>',
                'views_count' => 195,
                'is_published' => true,
                'published_at' => now()->subDays(9),
            ],
        ];

        foreach ($articles as $art) {
            NewsArticle::firstOrCreate(['slug' => $art['slug']], $art);
        }

        // 5. Indeks Pembangunan Daerah Resmi
        $indexes = [
            [
                'name' => 'Indeks Inovasi Daerah (IID)',
                'code' => 'IID',
                'year' => 2025,
                'score' => 62.45,
                'predicate' => 'Sangat Inovatif',
                'evaluator' => 'Badan Strategi Kebijakan Dalam Negeri (BSKDN) Kemendagri RI',
                'description' => 'Penilaian tahunan terhadap kematangan dan dampak ekosistem inovasi pelayanan publik dan tata kelola pemerintah daerah.',
                'is_active' => true,
            ],
            [
                'name' => 'Indeks Daya Saing Daerah (IDSD)',
                'code' => 'IDSD',
                'year' => 2025,
                'score' => 3.42,
                'predicate' => 'Tinggi',
                'evaluator' => 'Badan Riset dan Inovasi Nasional (BRIN)',
                'description' => 'Pengukuran produktivitas dan pilar daya saing daerah yang mencakup lingkungan pendukung, SDM, pasar, dan inovasi.',
                'is_active' => true,
            ],
            [
                'name' => 'Indeks Pengelolaan Keuangan Daerah (IPKD)',
                'code' => 'IPKD',
                'year' => 2025,
                'score' => 84.10,
                'predicate' => 'Baik',
                'evaluator' => 'Kementerian Dalam Negeri RI & BPKP',
                'description' => 'Evaluasi transparansi, akuntabilitas, dan efektivitas alokasi belanja modal serta pendapatan daerah.',
                'is_active' => true,
            ],
            [
                'name' => 'Laporan Akuntabilitas Kinerja Instansi Pemerintah (LAKIP / SAKIP)',
                'code' => 'SAKIP',
                'year' => 2025,
                'score' => 82.30,
                'predicate' => 'Predikat A',
                'evaluator' => 'KemenPAN-RB',
                'description' => 'Penilaian efektivitas penggunaan anggaran berbasis kinerja dan pencapaian target sasaran RPJMD.',
                'is_active' => true,
            ],
        ];

        foreach ($indexes as $idx) {
            RegionalIndex::firstOrCreate(
                ['code' => $idx['code'], 'year' => $idx['year']],
                $idx
            );
        }

        // 6. Pejabat Struktural BAPPERIDA
        $officials = [
            [
                'name' => 'Imam Santiko Raharjo, S.Si., M.S.E.',
                'nip' => '19750812 200212 1 003',
                'position' => 'Kepala BAPPERIDA Kabupaten Pringsewu',
                'category_code' => 'PIMPINAN',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Drs. Supriyanto, M.M.',
                'nip' => '19710315 199803 1 005',
                'position' => 'Sekretaris BAPPERIDA',
                'category_code' => 'UMUM',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Ahmad Fathoni, S.T., M.T.',
                'nip' => '19820510 200604 1 008',
                'position' => 'Kepala Bidang PPE (Perencanaan Pengendalian & Evaluasi)',
                'category_code' => 'PPE',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Siti Rohani, S.Sos., M.Si.',
                'nip' => '19800922 200501 2 006',
                'position' => 'Kepala Bidang PPM (Pemerintahan & Pembangunan Manusia)',
                'category_code' => 'PPM',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Hendra Kurniawan, S.P., M.M.',
                'nip' => '19790414 200801 1 012',
                'position' => 'Kepala Bidang PSDA (Perekonomian & SDA)',
                'category_code' => 'PSDA',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Budi Prasetyo, S.T.',
                'nip' => '19850120 201001 1 015',
                'position' => 'Kepala Bidang IPW (Infrastruktur & Pengembangan Wilayah)',
                'category_code' => 'IPW',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Dian Kusuma, S.Kom., M.T.I.',
                'nip' => '19861105 201101 2 018',
                'position' => 'Kepala Bidang RIDA (Riset & Inovasi Daerah)',
                'category_code' => 'RIDA',
                'order' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($officials as $off) {
            Official::firstOrCreate(['name' => $off['name']], $off);
        }
    }
}
