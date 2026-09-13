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
                'category_id' => $savedDocCats['dokumen-kajian']->id,
                'user_id' => $superAdmin?->id,
                'title' => 'Kajian Kelayakan Pengembangan Kawasan Sentra Agribisnis Terpadu Pringsewu',
                'slug' => Str::slug('Kajian Kelayakan Pengembangan Kawasan Sentra Agribisnis Terpadu Pringsewu'),
                'year' => 2025,
                'document_number' => 'Kajian Teknis 12/PSDA/2025',
                'description' => 'Studi kelayakan rantai pasok hilirisasi komoditas beras, hortikultura, dan perkebunan terintegrasi di Kabupaten Pringsewu.',
                'file_name' => 'Kajian_Agribisnis_Terpadu_Pringsewu_2025.pdf',
                'file_size' => 7400000,
                'file_mime' => 'application/pdf',
                'downloads_count' => 88,
                'is_published' => true,
                'published_at' => now()->subDays(18),
            ],
            [
                'category_id' => $savedDocCats['dokumen-analisis']->id,
                'user_id' => $superAdmin?->id,
                'title' => 'Analisis Ekonomi Makro dan Proyeksi Pertumbuhan PDRB Kabupaten Pringsewu 2025-2029',
                'slug' => Str::slug('Analisis Ekonomi Makro dan Proyeksi Pertumbuhan PDRB Kabupaten Pringsewu 2025-2029'),
                'year' => 2025,
                'document_number' => 'Analisis-Makro-01/PPE/2025',
                'description' => 'Analisis komparatif laju pertumbuhan ekonomi daerah, tingkat inflasi, penyerapan tenaga kerja, dan proyeksi PDRB sektoral.',
                'file_name' => 'Analisis_Ekonomi_Makro_Pringsewu_2025_2029.pdf',
                'file_size' => 9100000,
                'file_mime' => 'application/pdf',
                'downloads_count' => 143,
                'is_published' => true,
                'published_at' => now()->subDays(12),
            ],
            [
                'category_id' => $savedDocCats['dokumen-analisis']->id,
                'user_id' => $superAdmin?->id,
                'title' => 'Analisis Spasial Daya Dukung Daya Tampung Lingkungan Hidup (D3TLH) Pringsewu',
                'slug' => Str::slug('Analisis Spasial Daya Dukung Daya Tampung Lingkungan Hidup D3TLH Pringsewu'),
                'year' => 2025,
                'document_number' => 'Analisis-Spasial-05/IPW/2025',
                'description' => 'Analisis spasial kesesuaian lahan, ketersediaan air baku, dan daya tampung lingkungan hidup untuk mendukung revisi RTRW.',
                'file_name' => 'Analisis_Spasial_D3TLH_Pringsewu_2025.pdf',
                'file_size' => 11800000,
                'file_mime' => 'application/pdf',
                'downloads_count' => 105,
                'is_published' => true,
                'published_at' => now()->subDays(25),
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

        // 4. Berita / Artikel Publikasi per Bidang (Magazine Style)
        $articles = [
            // UMUM
            [
                'category_id' => $savedNewsCats['UMUM']->id,
                'author_id' => $superAdmin?->id,
                'title' => 'Penguatan Tata Kelola Reformasi Birokrasi dan Peningkatan Kapasitas SDM Bapperida Pringsewu',
                'slug' => Str::slug('Penguatan Tata Kelola Reformasi Birokrasi dan Peningkatan Kapasitas SDM Bapperida Pringsewu'),
                'excerpt' => 'Sekretariat BAPPERIDA menyelenggarakan lokakarya internal untuk memperkuat integritas aparatur, pengelolaan arsip digital, dan kedisiplinan kinerja.',
                'content' => '<p>Sekretariat Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah (BAPPERIDA) Kabupaten Pringsewu terus memacu profesionalisme aparatur perencana melalui serangkaian bimbingan teknis dan implementasi manajemen talenta terpadu.</p><p>Sekretaris BAPPERIDA menekankan bahwa fondasi perencanaan yang kuat berakar dari akuntabilitas tata kelola keuangan, ketepatan administrasi, serta budaya kerja yang berorientasi pada pelayanan prima kepada seluruh OPD dan masyarakat.</p>',
                'views_count' => 285,
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'category_id' => $savedNewsCats['UMUM']->id,
                'author_id' => $superAdmin?->id,
                'title' => 'Implementasi Sistem Akuntabilitas Kinerja Instansi Pemerintah Berbasis Digital',
                'slug' => Str::slug('Implementasi Sistem Akuntabilitas Kinerja Instansi Pemerintah Berbasis Digital'),
                'excerpt' => 'Optimalisasi aplikasi e-SAKIP mendorong transparansi pelaporan capaian program dan efisiensi serapan anggaran di lingkungan Bapperida.',
                'content' => '<p>Dalam upaya mendukung transformasi digital birokrasi pemerintahan, Subbagian Perencanaan dan Keuangan BAPPERIDA mengintegrasikan modul e-SAKIP dalam pemantauan kinerja harian dan bulanan setiap bidang perencanaan.</p><p>Langkah ini menempatkan BAPPERIDA sebagai salah satu pelopor keterbukaan informasi dan akuntabilitas kinerja di tingkat Pemerintah Kabupaten Pringsewu.</p>',
                'views_count' => 190,
                'is_published' => true,
                'published_at' => now()->subDays(8),
            ],

            // PPE
            [
                'category_id' => $savedNewsCats['PPE']->id,
                'author_id' => $superAdmin?->id,
                'title' => 'BAPPERIDA Pringsewu Gelar Forum Konsultasi Publik Rancangan Awal RKPD 2026',
                'slug' => Str::slug('BAPPERIDA Pringsewu Gelar Forum Konsultasi Publik Rancangan Awal RKPD 2026'),
                'excerpt' => 'Forum konsultasi publik bertujuan menghimpun aspirasi pemangku kepentingan dan menyelaraskan prioritas pembangunan Kabupaten Pringsewu tahun 2026.',
                'content' => '<p>Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah (BAPPERIDA) Kabupaten Pringsewu menggelar Forum Konsultasi Publik Rancangan Awal Rencana Kerja Pemerintah Daerah (RKPD) Tahun 2026 secara hibrid yang dihadiri oleh seluruh pimpinan perangkat daerah, akademisi, tokoh masyarakat, dan perwakilan generasi muda.</p><p>Kepala BAPPERIDA menegaskan pentingnya kolaborasi pentahelix untuk memastikan pembangunan yang inklusif, adaptif terhadap perubahan iklim, dan berorientasi pada peningkatan kesejahteraan masyarakat di seluruh kecamatan se-Kabupaten Pringsewu.</p>',
                'views_count' => 442,
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'category_id' => $savedNewsCats['PPE']->id,
                'author_id' => $superAdmin?->id,
                'title' => 'Rapat Koordinasi Evaluasi Triwulanan Realisasi RKPD dan Capaian Sasaran Makro',
                'slug' => Str::slug('Rapat Koordinasi Evaluasi Triwulanan Realisasi RKPD dan Capaian Sasaran Makro'),
                'excerpt' => 'Bidang PPE memaparkan progres indikator makro pembangunan ekonomi, laju inflasi daerah, dan konsistensi perencanaan anggaran daerah.',
                'content' => '<p>Bidang Perencanaan, Pengendalian dan Evaluasi (PPE) memimpin rapat koordinasi pengendalian dan evaluasi pelaksanaan rencana pembangunan daerah bersama tim pengendali perangkat daerah.</p><p>Evaluasi menyeluruh dilakukan guna memitigasi kendala pelaksanaan di lapangan dan memastikan target tahun berjalan tercapai sesuai koridor waktu yang ditetapkan.</p>',
                'views_count' => 310,
                'is_published' => true,
                'published_at' => now()->subDays(6),
            ],

            // PPM
            [
                'category_id' => $savedNewsCats['PPM']->id,
                'author_id' => $superAdmin?->id,
                'title' => 'Rembuk Stunting Pringsewu 2025: Penguatan Konvergensi Intervensi Gizi Spesifik dan Sensitif',
                'slug' => Str::slug('Rembuk Stunting Pringsewu 2025 Penguatan Konvergensi Intervensi Gizi Spesifik dan Sensitif'),
                'excerpt' => 'Bidang PPM menyatukan langkah lintas sektor perangkat daerah, puskesmas, dan kader posyandu untuk menuntaskan stunting hingga ke tingkat pekon.',
                'content' => '<p>Bidang Pemerintahan dan Pembangunan Manusia (PPM) BAPPERIDA memfasilitasi gelaran Rembuk Stunting Tingkat Kabupaten Pringsewu sebagai wujud komitmen zero stunting.</p><p>Fokus utama mencakup pemetaan sasaran keluarga berisiko stunting, penyaluran pangan bergizi, serta sanitasi total berbasis masyarakat (STBM) yang terintegrasi di 126 pekon dan 5 kelurahan.</p>',
                'views_count' => 512,
                'is_published' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'category_id' => $savedNewsCats['PPM']->id,
                'author_id' => $superAdmin?->id,
                'title' => 'Peningkatan Indeks Pembangunan Manusia (IPM) Pringsewu Melalui Pemerataan Layanan Dasar',
                'slug' => Str::slug('Peningkatan Indeks Pembangunan Manusia IPM Pringsewu Melalui Pemerataan Layanan Dasar'),
                'excerpt' => 'Pringsewu konsisten mencatatkan IPM tertinggi di antara kabupaten se-Provinsi Lampung berkat sinergi pendidikan dan perlindungan sosial.',
                'content' => '<p>Dengan angka IPM mencapai 72,85, Kabupaten Pringsewu terus memantapkan posisinya sebagai daerah dengan kualitas manusia yang unggul. Bidang PPM merumuskan langkah afirmasi untuk memastikan angka harapan sekolah dan usia harapan hidup terus meningkat di masa mendatang.</p>',
                'views_count' => 378,
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],

            // PSDA
            [
                'category_id' => $savedNewsCats['PSDA']->id,
                'author_id' => $superAdmin?->id,
                'title' => 'Penguatan Ketahanan Pangan Melalui Hilirisasi Komoditas Pertanian Unggulan',
                'slug' => Str::slug('Penguatan Ketahanan Pangan Melalui Hilirisasi Komoditas Pertanian Unggulan'),
                'excerpt' => 'Bidang PSDA merumuskan strategi penguatan rantai pasok komoditas beras, kakao, dan hortikultura di sentra agribisnis Pringsewu.',
                'content' => '<p>Sebagai lumbung pangan potensial di Provinsi Lampung, Kabupaten Pringsewu terus memacu produktivitas petani lewat program hilirisasi dan digitalisasi pemasaran hasil panen yang diintegrasikan dalam dokumen perencanaan tahunan.</p>',
                'views_count' => 295,
                'is_published' => true,
                'published_at' => now()->subDays(9),
            ],
            [
                'category_id' => $savedNewsCats['PSDA']->id,
                'author_id' => $superAdmin?->id,
                'title' => 'Pengembangan Ekosistem UMKM dan Klaster Industri Kreatif Berbasis Potensi Lokal',
                'slug' => Str::slug('Pengembangan Ekosistem UMKM dan Klaster Industri Kreatif Berbasis Potensi Lokal'),
                'excerpt' => 'Fasilitasi permodalan, perizinan berusaha mudah, dan promosi kain Tapis khas Pringsewu diangkat sebagai pilar ekonomi kerakyatan.',
                'content' => '<p>Bidang Perekonomian dan Sumber Daya Alam (PSDA) menginisiasi program pemberdayaan terpadu bagi kelompok pengrajin tapis dan industri pangan olahan bambu guna memperluas penetrasi pasar regional maupun internasional.</p>',
                'views_count' => 240,
                'is_published' => true,
                'published_at' => now()->subDays(11),
            ],

            // IPW
            [
                'category_id' => $savedNewsCats['IPW']->id,
                'author_id' => $superAdmin?->id,
                'title' => 'Sinkronisasi Rencana Tata Ruang Wilayah (RTRW) Pringsewu Dukung Kawasan Industri Hijau',
                'slug' => Str::slug('Sinkronisasi Rencana Tata Ruang Wilayah RTRW Pringsewu Dukung Kawasan Industri Hijau'),
                'excerpt' => 'Bidang IPW mematangkan revisi RTRW untuk menjamin kepastian investasi dan perlindungan lahan pertanian pangan berkelanjutan.',
                'content' => '<p>Bidang Infrastruktur dan Pengembangan Wilayah (IPW) BAPPERIDA memfasilitasi rapat koordinasi penataan ruang bersama kementerian terkait. Penyesuaian RTRW ini difokuskan pada penguatan koridor ekonomi antardaerah dengan tetap mempertahankan lahan sawah dilindungi (LSD).</p>',
                'views_count' => 310,
                'is_published' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'category_id' => $savedNewsCats['IPW']->id,
                'author_id' => $superAdmin?->id,
                'title' => 'Peningkatan Akses Sanitasi Layak dan Air Bersih Menuju Permukiman Berkelanjutan',
                'slug' => Str::slug('Peningkatan Akses Sanitasi Layak dan Air Bersih Menuju Permukiman Berkelanjutan'),
                'excerpt' => 'Bidang IPW mengawal rencana induk penyediaan air minum (RISPAM) dan pembangunan infrastruktur persampahan ramah lingkungan.',
                'content' => '<p>Melalui perencanaan infrastruktur yang terukur, BAPPERIDA memastikan ketersediaan akses sarana sanitasi dasar dan jaringan pipa air minum perpipaan bagi masyarakat perkotaan dan perdesaan secara berkeadilan.</p>',
                'views_count' => 220,
                'is_published' => true,
                'published_at' => now()->subDays(12),
            ],

            // RIDA
            [
                'category_id' => $savedNewsCats['RIDA']->id,
                'author_id' => $superAdmin?->id,
                'title' => 'Kabupaten Pringsewu Raih Predikat Sangat Inovatif pada Indeks Inovasi Daerah 2025',
                'slug' => Str::slug('Kabupaten Pringsewu Raih Predikat Sangat Inovatif pada Indeks Inovasi Daerah 2025'),
                'excerpt' => 'Dengan skor 62,45, Kabupaten Pringsewu kembali menorehkan prestasi gemilang dalam penilaian Indeks Inovasi Daerah oleh Kemendagri RI.',
                'content' => '<p>Kementerian Dalam Negeri Republik Indonesia secara resmi merilis hasil pengukuran Indeks Inovasi Daerah (IID) tahun 2025. Kabupaten Pringsewu sukses meraih predikat Sangat Inovatif dengan skor 62,45.</p><p>Capaian ini didorong oleh penerapan puluhan inovasi layanan publik berbasis digital, inovasi tata kelola pemerintahan desa, dan kemudahan akses data untuk masyarakat.</p>',
                'views_count' => 588,
                'is_published' => true,
                'published_at' => now()->subDays(4),
            ],
            [
                'category_id' => $savedNewsCats['RIDA']->id,
                'author_id' => $superAdmin?->id,
                'title' => 'Peluncuran Kompetisi Inovasi Daerah (KID) Pringsewu 2026: Ruang Riset dan Gagasan Kreatif',
                'slug' => Str::slug('Peluncuran Kompetisi Inovasi Daerah KID Pringsewu 2026 Ruang Riset dan Gagasan Kreatif'),
                'excerpt' => 'Bidang Riset dan Inovasi Daerah mengajak seluruh pelajar, mahasiswa, akademisi, dan ASN untuk melahirkan inovasi solutif bagi Pringsewu.',
                'content' => '<p>Bidang RIDA BAPPERIDA membuka pendaftaran Kompetisi Inovasi Daerah (KID) 2026 dengan tema "Inovasi Berkelanjutan untuk Pringsewu Sejahtera". Pemenang akan mendapatkan pendanaan riset prototipe dan fasilitasi pendaftaran Hak Kekayaan Intelektual (HAKI).</p>',
                'views_count' => 415,
                'is_published' => true,
                'published_at' => now()->subDays(10),
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

        // 6. Pejabat Struktural & Fungsional BAPPERIDA (Perbup No. 38/2025)
        $officials = [
            [
                'name' => 'Dr. IMAM FATKUROJI, S.STP., M.IP',
                'nip' => '19841110 200312 1 001',
                'position' => 'Kepala BAPPERIDA Kabupaten Pringsewu',
                'category_code' => 'leadership',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'SITI RAHMAH, S.I.Kom., MM',
                'nip' => '19850609 201001 2 014',
                'position' => 'Sekretaris BAPPERIDA',
                'category_code' => 'structural',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'FITRI FAULA, S.I.Kom',
                'nip' => '19880429 201001 2 006',
                'position' => 'Kasubbag Umum dan Kepegawaian',
                'category_code' => 'structural',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'EVY SURYANI SIMATUPANG, MM',
                'nip' => '19830331 201101 2 006',
                'position' => 'JF Perencana Ahli Muda',
                'category_code' => 'functional',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'FEBBY SABEL SUPRIYATNA, SE, MM',
                'nip' => '19860204 201001 2 021',
                'position' => 'JF Analis Keuangan Pusat dan Daerah Ahli Muda',
                'category_code' => 'functional',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'RARA SUKMA, ST., M.P.W.K',
                'nip' => '19850724 201001 2 016',
                'position' => 'Kepala Bidang PPE (Perencanaan, Pengendalian & Evaluasi)',
                'category_code' => 'structural',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Ir. A. ADAM ALTHUSIUS, ST., MURP.',
                'nip' => '19800422 201001 1 009',
                'position' => 'Kepala Bidang IPW (Infrastruktur & Pengembangan Wilayah)',
                'category_code' => 'structural',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'DEBIT ZULIANSYAH, ST',
                'nip' => '19801012 201001 1 023',
                'position' => 'Kepala Bidang PPM (Pemerintahan & Pembangunan Manusia)',
                'category_code' => 'structural',
                'order' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Ir. ERWIN SONI, ST., MM',
                'nip' => '19801208 201001 1 011',
                'position' => 'Kepala Bidang PSDA (Perekonomian & SDA)',
                'category_code' => 'structural',
                'order' => 9,
                'is_active' => true,
            ],
            [
                'name' => 'FENNY APRILIA, S.Sos',
                'nip' => '19840405 201001 2 032',
                'position' => 'Kepala Bidang RIDA (Riset & Inovasi Daerah)',
                'category_code' => 'structural',
                'order' => 10,
                'is_active' => true,
            ],
        ];

        foreach ($officials as $off) {
            Official::updateOrCreate(['nip' => $off['nip']], $off);
        }
    }
}
