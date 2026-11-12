/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.1.2-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: bapperida_db
-- ------------------------------------------------------
-- Server version	12.1.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` char(36) NOT NULL,
  `user_id` char(36) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  KEY `activity_logs_action_index` (`action`),
  KEY `activity_logs_created_at_index` (`created_at`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `awards`
--

DROP TABLE IF EXISTS `awards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `awards` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `year` smallint(5) unsigned NOT NULL,
  `award_date` date NOT NULL,
  `category` varchar(255) NOT NULL,
  `organizer` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `awards_slug_unique` (`slug`),
  KEY `awards_year_index` (`year`),
  KEY `awards_award_date_index` (`award_date`),
  KEY `awards_category_index` (`category`),
  KEY `awards_order_index` (`order`),
  KEY `awards_is_published_index` (`is_published`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awards`
--

LOCK TABLES `awards` WRITE;
/*!40000 ALTER TABLE `awards` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `awards` VALUES
('01a09b95-2a45-728b-851f-0c75f04bb142','Penghargaan Pembangunan Daerah (PPD) Terbaik I Tingkat Provinsi Lampung','penghargaan-pembangunan-daerah-ppd-terbaik-i-tingkat-provinsi-lampung',2025,'2025-04-18','Perencanaan Pembangunan','Kementerian PPN / Bappenas & Pemprov Lampung','Apresiasi tertinggi atas keterpaduan, konsistensi, dan inovasi perencanaan pembangunan daerah dalam penyusunan RKPD Kabupaten Pringsewu yang selaras dengan sasaran strategis nasional.','/images/awards/award_ppd_pringsewu.jpg',1,1,'2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a46-7246-bca8-635e14c7c23d','Innovative Government Award (IGA) - Predikat Sangat Inovatif','innovative-government-award-iga-predikat-sangat-inovatif',2025,'2025-12-12','Inovasi Daerah','Kementerian Dalam Negeri Republik Indonesia (BSKDN)','Penghargaan nasional atas capaian skor kematangan indeks inovasi daerah (IID) 62,45 melalui penerapan puluhan aplikasi layanan publik dan tata kelola pemerintahan desa berbasis digital.','/images/awards/award_iga_pringsewu.jpg',2,1,'2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a48-7068-a57f-b88b4ca72021','Akuntabilitas Kinerja Instansi Pemerintah (SAKIP Award) Predikat A','akuntabilitas-kinerja-instansi-pemerintah-sakip-award-predikat-a',2025,'2025-10-06','Akuntabilitas Kinerja','Kementerian Pendayagunaan Aparatur Negara dan Reformasi Birokrasi (KemenPAN-RB)','Pengakuan atas keberhasilan BAPPERIDA dalam efisiensi penggunaan anggaran berbasis kinerja, konsistensi pohon kinerja indikator makro, dan akuntabilitas tata kelola birokrasi.','/images/awards/award_ppd_pringsewu.jpg',3,1,'2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a4a-7346-9031-d6cf19c6ff64','Penghargaan Kinerja Penurunan Prevalensi Stunting Terbaik','penghargaan-kinerja-penurunan-prevalensi-stunting-terbaik',2025,'2025-08-20','Pembangunan Manusia','BKKBN & Tim Percepatan Penurunan Stunting (TPPS) Pusat','Apresiasi komitmen konvergensi lintas sektor intervensi gizi spesifik dan sensitif di 126 pekon dan 5 kelurahan se-Kabupaten Pringsewu menuju zero new stunting.','/images/awards/award_iga_pringsewu.jpg',4,1,'2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a4b-7100-b232-40e18a0e38bc','Opini Wajar Tanpa Pengecualian (WTP) 9 Kali Berturut-turut','opini-wajar-tanpa-pengecualian-wtp-9-kali-berturut-turut',2024,'2024-05-15','Pengelolaan Keuangan','Badan Pemeriksa Keuangan Republik Indonesia (BPK RI)','Opini audit tertinggi atas Laporan Keuangan Pemerintah Daerah (LKPD) yang menunjukkan transparansi, kepatuhan regulasi, dan akurasi pencatatan aset daerah.','/images/awards/award_ppd_pringsewu.jpg',5,1,'2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a4c-7375-a99a-035fe93296fe','TPID Award - Tim Pengendalian Inflasi Daerah Berprestasi Kawasan Sumatera','tpid-award-tim-pengendalian-inflasi-daerah-berprestasi-kawasan-sumatera',2024,'2024-06-14','Daya Saing & Perekonomian','Kementerian Koordinator Bidang Perekonomian & Bank Indonesia','Penghargaan atas inovasi penguatan rantai pasok pangan lokal, operasi pasar murah terpadu, dan kestabilan inflasi daerah yang terjaga di batas aman.','/images/awards/award_iga_pringsewu.jpg',6,1,'2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a4d-7177-8194-10e16e6ad058','Peringkat I Indeks Daya Saing Daerah (IDSD) Klaster Kabupaten Se-Provinsi Lampung','peringkat-i-indeks-daya-saing-daerah-idsd-klaster-kabupaten-se-provinsi-lampung',2024,'2024-11-28','Daya Saing & Perekonomian','Badan Riset dan Inovasi Nasional (BRIN)','Capaian pilar produktivitas tenaga kerja, infrastruktur pendukung ekonomi kerakyatan, dan kemudahan berusaha bagi sentra agribisnis dan UMKM Pringsewu.','/images/awards/award_ppd_pringsewu.jpg',7,1,'2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a4f-710a-9fcd-a24186b169e3','Anugerah Keterbukaan Informasi Publik (KIP) Kategori Informatif','anugerah-keterbukaan-informasi-publik-kip-kategori-informatif',2023,'2023-12-05','Tata Kelola Pemerintahan','Komisi Informasi Provinsi Lampung','Penghargaan tertinggi atas kepatuhan standar layanan informasi publik berkala dan keterbukaan akses dokumen perencanaan melalui portal resmi daerah.','/images/awards/award_iga_pringsewu.jpg',8,1,'2026-09-13 09:23:59','2026-09-13 09:23:59');
/*!40000 ALTER TABLE `awards` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `cache` VALUES
('laravel-cache-bapperida:public:home','a:5:{s:17:\"featuredDocuments\";a:6:{i:0;a:8:{s:2:\"id\";s:36:\"01a09baa-b16f-7353-b40d-6f34be55ac35\";s:5:\"title\";s:62:\"Rencana Kerja (Renja) BAPPERIDA Kabupaten Pringsewu Tahun 2026\";s:4:\"slug\";s:60:\"rencana-kerja-renja-bapperida-kabupaten-pringsewu-tahun-2026\";s:13:\"category_name\";s:19:\"Dokumen Perencanaan\";s:4:\"year\";i:2026;s:15:\"document_number\";s:20:\"Renja-BAPPERIDA-2026\";s:9:\"file_size\";s:7:\"6,39 MB\";s:15:\"downloads_count\";i:140;}i:1;a:8:{s:2:\"id\";s:36:\"01a09a48-7611-7203-afae-a7cd620991ff\";s:5:\"title\";s:69:\"Rencana Kerja Pemerintah Daerah (RKPD) Kabupaten Pringsewu Tahun 2026\";s:4:\"slug\";s:67:\"rencana-kerja-pemerintah-daerah-rkpd-kabupaten-pringsewu-tahun-2026\";s:13:\"category_name\";s:19:\"Dokumen Perencanaan\";s:4:\"year\";i:2026;s:15:\"document_number\";s:24:\"Perbup No. 18 Tahun 2025\";s:9:\"file_size\";s:8:\"13,59 MB\";s:15:\"downloads_count\";i:184;}i:2;a:8:{s:2:\"id\";s:36:\"01a09a48-7614-71ed-a1ab-fa5d1e544be2\";s:5:\"title\";s:73:\"Rencana Strategis (Renstra) BAPPERIDA Kabupaten Pringsewu Tahun 2025-2029\";s:4:\"slug\";s:71:\"rencana-strategis-renstra-bapperida-kabupaten-pringsewu-tahun-2025-2029\";s:13:\"category_name\";s:19:\"Dokumen Perencanaan\";s:4:\"year\";i:2025;s:15:\"document_number\";s:27:\"Kepka Bapperida No. 02/2025\";s:9:\"file_size\";s:7:\"8,20 MB\";s:15:\"downloads_count\";i:96;}i:3;a:8:{s:2:\"id\";s:36:\"01a09a48-7612-705e-bb2f-4feaddae8684\";s:5:\"title\";s:80:\"Rencana Pembangunan Jangka Menengah Daerah (RPJMD) Kabupaten Pringsewu 2025-2029\";s:4:\"slug\";s:78:\"rencana-pembangunan-jangka-menengah-daerah-rpjmd-kabupaten-pringsewu-2025-2029\";s:13:\"category_name\";s:19:\"Dokumen Perencanaan\";s:4:\"year\";i:2025;s:15:\"document_number\";s:23:\"Perda No. 04 Tahun 2025\";s:9:\"file_size\";s:8:\"27,08 MB\";s:15:\"downloads_count\";i:420;}i:4;a:8:{s:2:\"id\";s:36:\"01a09baa-b162-726e-a84a-e0d062545506\";s:5:\"title\";s:79:\"Rencana Pembangunan Jangka Panjang Daerah (RPJPD) Kabupaten Pringsewu 2025-2045\";s:4:\"slug\";s:77:\"rencana-pembangunan-jangka-panjang-daerah-rpjpd-kabupaten-pringsewu-2025-2045\";s:13:\"category_name\";s:19:\"Dokumen Perencanaan\";s:4:\"year\";i:2025;s:15:\"document_number\";s:23:\"Perda No. 01 Tahun 2025\";s:9:\"file_size\";s:8:\"30,99 MB\";s:15:\"downloads_count\";i:310;}i:5;a:8:{s:2:\"id\";s:36:\"01a09baa-b172-7166-88f5-8c1b73945cc6\";s:5:\"title\";s:81:\"Perubahan Rencana Kerja Pemerintah Daerah (P-RKPD) Kabupaten Pringsewu Tahun 2025\";s:4:\"slug\";s:79:\"perubahan-rencana-kerja-pemerintah-daerah-p-rkpd-kabupaten-pringsewu-tahun-2025\";s:13:\"category_name\";s:19:\"Dokumen Perencanaan\";s:4:\"year\";i:2025;s:15:\"document_number\";s:24:\"Perbup No. 24 Tahun 2025\";s:9:\"file_size\";s:8:\"16,02 MB\";s:15:\"downloads_count\";i:195;}}s:10:\"categories\";a:6:{i:0;a:5:{s:2:\"id\";s:36:\"01a09a48-761a-7320-ad8e-864963d3112d\";s:4:\"name\";s:18:\"Sekretariat / Umum\";s:4:\"code\";s:4:\"UMUM\";s:4:\"slug\";s:4:\"umum\";s:5:\"color\";s:5:\"slate\";}i:1;a:5:{s:2:\"id\";s:36:\"01a09a48-761b-71aa-bb17-38c54d183eee\";s:4:\"name\";s:37:\"Perencanaan Pengendalian dan Evaluasi\";s:4:\"code\";s:3:\"PPE\";s:4:\"slug\";s:3:\"ppe\";s:5:\"color\";s:4:\"teal\";}i:2;a:5:{s:2:\"id\";s:36:\"01a09a48-761c-7051-a039-92c78b2c6507\";s:4:\"name\";s:36:\"Pemerintahan dan Pembangunan Manusia\";s:4:\"code\";s:3:\"PPM\";s:4:\"slug\";s:3:\"ppm\";s:5:\"color\";s:4:\"blue\";}i:3;a:5:{s:2:\"id\";s:36:\"01a09a48-761e-736e-aba5-fbf0ded68c98\";s:4:\"name\";s:33:\"Perekonomian dan Sumber Daya Alam\";s:4:\"code\";s:4:\"PSDA\";s:4:\"slug\";s:4:\"psda\";s:5:\"color\";s:7:\"emerald\";}i:4;a:5:{s:2:\"id\";s:36:\"01a09a48-761f-7172-a569-aeeea9cfaa4e\";s:4:\"name\";s:38:\"Infrastruktur dan Pengembangan Wilayah\";s:4:\"code\";s:3:\"IPW\";s:4:\"slug\";s:3:\"ipw\";s:5:\"color\";s:5:\"amber\";}i:5;a:5:{s:2:\"id\";s:36:\"01a09a48-7621-738b-9bb5-18bc1318ab21\";s:4:\"name\";s:24:\"Riset dan Inovasi Daerah\";s:4:\"code\";s:4:\"RIDA\";s:4:\"slug\";s:4:\"rida\";s:5:\"color\";s:6:\"purple\";}}s:10:\"latestNews\";a:18:{i:0;a:10:{s:2:\"id\";s:36:\"01a09baa-b188-728f-a27c-b79d63555ed4\";s:5:\"title\";s:84:\"Diseminasi Hasil Riset Kebijakan Daerah Bersama BRIN dan Kolaborasi Perguruan Tinggi\";s:4:\"slug\";s:84:\"diseminasi-hasil-riset-kebijakan-daerah-bersama-brin-dan-kolaborasi-perguruan-tinggi\";s:7:\"excerpt\";s:123:\"Bidang RIDA memaparkan 10 rekomendasi riset strategis guna mengakselerasi transformasi pelayanan publik dan ekonomi daerah.\";s:13:\"category_name\";s:24:\"Riset dan Inovasi Daerah\";s:13:\"category_code\";s:4:\"RIDA\";s:13:\"category_slug\";s:4:\"rida\";s:14:\"featured_image\";s:92:\"https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80\";s:12:\"published_at\";s:17:\"13 September 2026\";s:11:\"views_count\";i:520;}i:1;a:10:{s:2:\"id\";s:36:\"01a09baa-b187-7138-9b62-300c3b5fb276\";s:5:\"title\";s:86:\"Optimalisasi Jaringan Drainase dan Manajemen Risiko Banjir Kawasan Perkotaan Pringsewu\";s:4:\"slug\";s:86:\"optimalisasi-jaringan-drainase-dan-manajemen-risiko-banjir-kawasan-perkotaan-pringsewu\";s:7:\"excerpt\";s:123:\"Bidang IPW merumuskan masterplan drainase perkotaan terpadu dan revitalisasi sempadan sungai untuk perlindungan lingkungan.\";s:13:\"category_name\";s:38:\"Infrastruktur dan Pengembangan Wilayah\";s:13:\"category_code\";s:3:\"IPW\";s:13:\"category_slug\";s:3:\"ipw\";s:14:\"featured_image\";s:92:\"https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80\";s:12:\"published_at\";s:17:\"13 September 2026\";s:11:\"views_count\";i:360;}i:2;a:10:{s:2:\"id\";s:36:\"01a09baa-b184-7148-955d-d52c3ae17802\";s:5:\"title\";s:85:\"Strategi Penguatan Pasar Komoditas Organik dan Produk Olahan Bambu Unggulan Pringsewu\";s:4:\"slug\";s:85:\"strategi-penguatan-pasar-komoditas-organik-dan-produk-olahan-bambu-unggulan-pringsewu\";s:7:\"excerpt\";s:126:\"Bidang PSDA mendorong hilirisasi ekonomi hijau berbasis kearifan lokal bambu dan sertifikasi pangan organik berskala nasional.\";s:13:\"category_name\";s:33:\"Perekonomian dan Sumber Daya Alam\";s:13:\"category_code\";s:4:\"PSDA\";s:13:\"category_slug\";s:4:\"psda\";s:14:\"featured_image\";s:92:\"https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=800&q=80\";s:12:\"published_at\";s:17:\"13 September 2026\";s:11:\"views_count\";i:450;}i:3;a:10:{s:2:\"id\";s:36:\"01a09baa-b182-708a-8833-da3ced4a7f09\";s:5:\"title\";s:92:\"Peluang Kerja Generasi Muda: Integrasi Pelatihan Vokasi SMK dan Kebutuhan Industri Pringsewu\";s:4:\"slug\";s:91:\"peluang-kerja-generasi-muda-integrasi-pelatihan-vokasi-smk-dan-kebutuhan-industri-pringsewu\";s:7:\"excerpt\";s:107:\"Bidang PPM menyinergikan link and match kurikulum SMK dengan sentra industri kreatif dan agribisnis modern.\";s:13:\"category_name\";s:36:\"Pemerintahan dan Pembangunan Manusia\";s:13:\"category_code\";s:3:\"PPM\";s:13:\"category_slug\";s:3:\"ppm\";s:14:\"featured_image\";s:92:\"https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&w=800&q=80\";s:12:\"published_at\";s:17:\"13 September 2026\";s:11:\"views_count\";i:395;}i:4;a:10:{s:2:\"id\";s:36:\"01a09baa-b180-736d-ac73-b91ef0961d92\";s:5:\"title\";s:86:\"Harmonisasi Target RPJMD 2025-2029 dan Evaluasi Capaian Indikator Sasaran Makro Daerah\";s:4:\"slug\";s:86:\"harmonisasi-target-rpjmd-2025-2029-dan-evaluasi-capaian-indikator-sasaran-makro-daerah\";s:7:\"excerpt\";s:122:\"Bidang PPE mematangkan penyelarasan indikator pertumbuhan ekonomi makro, inflasi terkendali, dan angka kemiskinan ekstrem.\";s:13:\"category_name\";s:37:\"Perencanaan Pengendalian dan Evaluasi\";s:13:\"category_code\";s:3:\"PPE\";s:13:\"category_slug\";s:3:\"ppe\";s:14:\"featured_image\";s:92:\"https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=800&q=80\";s:12:\"published_at\";s:17:\"13 September 2026\";s:11:\"views_count\";i:480;}i:5;a:10:{s:2:\"id\";s:36:\"01a09baa-b17e-70a9-8b79-8c2521216c08\";s:5:\"title\";s:81:\"Penguatan Pelayanan Informasi Publik dan Digitalisasi Arsip Perencanaan BAPPERIDA\";s:4:\"slug\";s:81:\"penguatan-pelayanan-informasi-publik-dan-digitalisasi-arsip-perencanaan-bapperida\";s:7:\"excerpt\";s:121:\"Subbag Umum mempercepat transformasi e-office dan keterbukaan akses dokumen perencanaan melalui portal Satu Data terpadu.\";s:13:\"category_name\";s:18:\"Sekretariat / Umum\";s:13:\"category_code\";s:4:\"UMUM\";s:13:\"category_slug\";s:4:\"umum\";s:14:\"featured_image\";s:92:\"https://images.unsplash.com/photo-1577495508048-b635879837f1?auto=format&fit=crop&w=800&q=80\";s:12:\"published_at\";s:17:\"12 September 2026\";s:11:\"views_count\";i:320;}i:6;a:10:{s:2:\"id\";s:36:\"01a09a61-3ef2-7150-9c8f-fc82af75d60d\";s:5:\"title\";s:91:\"Rembuk Stunting Pringsewu 2025: Penguatan Konvergensi Intervensi Gizi Spesifik dan Sensitif\";s:4:\"slug\";s:90:\"rembuk-stunting-pringsewu-2025-penguatan-konvergensi-intervensi-gizi-spesifik-dan-sensitif\";s:7:\"excerpt\";s:143:\"Bidang PPM menyatukan langkah lintas sektor perangkat daerah, puskesmas, dan kader posyandu untuk menuntaskan stunting hingga ke tingkat pekon.\";s:13:\"category_name\";s:36:\"Pemerintahan dan Pembangunan Manusia\";s:13:\"category_code\";s:3:\"PPM\";s:13:\"category_slug\";s:3:\"ppm\";s:14:\"featured_image\";s:92:\"https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&w=800&q=80\";s:12:\"published_at\";s:17:\"12 September 2026\";s:11:\"views_count\";i:512;}i:7;a:10:{s:2:\"id\";s:36:\"01a09a48-7624-712f-89c5-febc54ef0fdc\";s:5:\"title\";s:74:\"BAPPERIDA Pringsewu Gelar Forum Konsultasi Publik Rancangan Awal RKPD 2026\";s:4:\"slug\";s:74:\"bapperida-pringsewu-gelar-forum-konsultasi-publik-rancangan-awal-rkpd-2026\";s:7:\"excerpt\";s:146:\"Forum konsultasi publik bertujuan menghimpun aspirasi pemangku kepentingan dan menyelaraskan prioritas pembangunan Kabupaten Pringsewu tahun 2026.\";s:13:\"category_name\";s:37:\"Perencanaan Pengendalian dan Evaluasi\";s:13:\"category_code\";s:3:\"PPE\";s:13:\"category_slug\";s:3:\"ppe\";s:14:\"featured_image\";s:92:\"https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=800&q=80\";s:12:\"published_at\";s:17:\"11 September 2026\";s:11:\"views_count\";i:343;}i:8;a:10:{s:2:\"id\";s:36:\"01a09a61-3eeb-702f-b6fa-bf96fe1ab42e\";s:5:\"title\";s:91:\"Penguatan Tata Kelola Reformasi Birokrasi dan Peningkatan Kapasitas SDM Bapperida Pringsewu\";s:4:\"slug\";s:91:\"penguatan-tata-kelola-reformasi-birokrasi-dan-peningkatan-kapasitas-sdm-bapperida-pringsewu\";s:7:\"excerpt\";s:148:\"Sekretariat BAPPERIDA menyelenggarakan lokakarya internal untuk memperkuat integritas aparatur, pengelolaan arsip digital, dan kedisiplinan kinerja.\";s:13:\"category_name\";s:18:\"Sekretariat / Umum\";s:13:\"category_code\";s:4:\"UMUM\";s:13:\"category_slug\";s:4:\"umum\";s:14:\"featured_image\";s:92:\"https://images.unsplash.com/photo-1577495508048-b635879837f1?auto=format&fit=crop&w=800&q=80\";s:12:\"published_at\";s:17:\"10 September 2026\";s:11:\"views_count\";i:286;}i:9;a:10:{s:2:\"id\";s:36:\"01a09a48-7627-7221-a4eb-f532c5c2ad2a\";s:5:\"title\";s:81:\"Kabupaten Pringsewu Raih Predikat Sangat Inovatif pada Indeks Inovasi Daerah 2025\";s:4:\"slug\";s:81:\"kabupaten-pringsewu-raih-predikat-sangat-inovatif-pada-indeks-inovasi-daerah-2025\";s:7:\"excerpt\";s:133:\"Dengan skor 62,45, Kabupaten Pringsewu kembali menorehkan prestasi gemilang dalam penilaian Indeks Inovasi Daerah oleh Kemendagri RI.\";s:13:\"category_name\";s:24:\"Riset dan Inovasi Daerah\";s:13:\"category_code\";s:4:\"RIDA\";s:13:\"category_slug\";s:4:\"rida\";s:14:\"featured_image\";s:92:\"https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80\";s:12:\"published_at\";s:17:\"09 September 2026\";s:11:\"views_count\";i:528;}i:10;a:10:{s:2:\"id\";s:36:\"01a09a61-3ef5-7020-b116-13dfb15dc160\";s:5:\"title\";s:87:\"Peningkatan Indeks Pembangunan Manusia (IPM) Pringsewu Melalui Pemerataan Layanan Dasar\";s:4:\"slug\";s:85:\"peningkatan-indeks-pembangunan-manusia-ipm-pringsewu-melalui-pemerataan-layanan-dasar\";s:7:\"excerpt\";s:136:\"Pringsewu konsisten mencatatkan IPM tertinggi di antara kabupaten se-Provinsi Lampung berkat sinergi pendidikan dan perlindungan sosial.\";s:13:\"category_name\";s:36:\"Pemerintahan dan Pembangunan Manusia\";s:13:\"category_code\";s:3:\"PPM\";s:13:\"category_slug\";s:3:\"ppm\";s:14:\"featured_image\";s:92:\"https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&w=800&q=80\";s:12:\"published_at\";s:17:\"08 September 2026\";s:11:\"views_count\";i:379;}i:11;a:10:{s:2:\"id\";s:36:\"01a09a61-3ef1-73a1-88fc-2030a31f129d\";s:5:\"title\";s:77:\"Rapat Koordinasi Evaluasi Triwulanan Realisasi RKPD dan Capaian Sasaran Makro\";s:4:\"slug\";s:77:\"rapat-koordinasi-evaluasi-triwulanan-realisasi-rkpd-dan-capaian-sasaran-makro\";s:7:\"excerpt\";s:132:\"Bidang PPE memaparkan progres indikator makro pembangunan ekonomi, laju inflasi daerah, dan konsistensi perencanaan anggaran daerah.\";s:13:\"category_name\";s:37:\"Perencanaan Pengendalian dan Evaluasi\";s:13:\"category_code\";s:3:\"PPE\";s:13:\"category_slug\";s:3:\"ppe\";s:14:\"featured_image\";s:92:\"https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=800&q=80\";s:12:\"published_at\";s:17:\"07 September 2026\";s:11:\"views_count\";i:310;}i:12;a:10:{s:2:\"id\";s:36:\"01a09a48-7628-72fe-862a-a297c29c0e26\";s:5:\"title\";s:86:\"Sinkronisasi Rencana Tata Ruang Wilayah (RTRW) Pringsewu Dukung Kawasan Industri Hijau\";s:4:\"slug\";s:84:\"sinkronisasi-rencana-tata-ruang-wilayah-rtrw-pringsewu-dukung-kawasan-industri-hijau\";s:7:\"excerpt\";s:124:\"Bidang IPW mematangkan revisi RTRW untuk menjamin kepastian investasi dan perlindungan lahan pertanian pangan berkelanjutan.\";s:13:\"category_name\";s:38:\"Infrastruktur dan Pengembangan Wilayah\";s:13:\"category_code\";s:3:\"IPW\";s:13:\"category_slug\";s:3:\"ipw\";s:14:\"featured_image\";s:92:\"https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80\";s:12:\"published_at\";s:17:\"06 September 2026\";s:11:\"views_count\";i:210;}i:13;a:10:{s:2:\"id\";s:36:\"01a09a61-3eef-7119-9416-234a0e983543\";s:5:\"title\";s:78:\"Implementasi Sistem Akuntabilitas Kinerja Instansi Pemerintah Berbasis Digital\";s:4:\"slug\";s:78:\"implementasi-sistem-akuntabilitas-kinerja-instansi-pemerintah-berbasis-digital\";s:7:\"excerpt\";s:134:\"Optimalisasi aplikasi e-SAKIP mendorong transparansi pelaporan capaian program dan efisiensi serapan anggaran di lingkungan Bapperida.\";s:13:\"category_name\";s:18:\"Sekretariat / Umum\";s:13:\"category_code\";s:4:\"UMUM\";s:13:\"category_slug\";s:4:\"umum\";s:14:\"featured_image\";s:92:\"https://images.unsplash.com/photo-1577495508048-b635879837f1?auto=format&fit=crop&w=800&q=80\";s:12:\"published_at\";s:17:\"05 September 2026\";s:11:\"views_count\";i:190;}i:14;a:10:{s:2:\"id\";s:36:\"01a09a48-762a-72d9-a3a4-28826ab7a67f\";s:5:\"title\";s:74:\"Penguatan Ketahanan Pangan Melalui Hilirisasi Komoditas Pertanian Unggulan\";s:4:\"slug\";s:74:\"penguatan-ketahanan-pangan-melalui-hilirisasi-komoditas-pertanian-unggulan\";s:7:\"excerpt\";s:127:\"Bidang PSDA merumuskan strategi penguatan rantai pasok komoditas beras, kakao, dan hortikultura di sentra agribisnis Pringsewu.\";s:13:\"category_name\";s:33:\"Perekonomian dan Sumber Daya Alam\";s:13:\"category_code\";s:4:\"PSDA\";s:13:\"category_slug\";s:4:\"psda\";s:14:\"featured_image\";s:92:\"https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=800&q=80\";s:12:\"published_at\";s:17:\"04 September 2026\";s:11:\"views_count\";i:196;}i:15;a:10:{s:2:\"id\";s:36:\"01a09a61-3efb-71dd-ab48-9697e0447291\";s:5:\"title\";s:89:\"Peluncuran Kompetisi Inovasi Daerah (KID) Pringsewu 2026: Ruang Riset dan Gagasan Kreatif\";s:4:\"slug\";s:86:\"peluncuran-kompetisi-inovasi-daerah-kid-pringsewu-2026-ruang-riset-dan-gagasan-kreatif\";s:7:\"excerpt\";s:136:\"Bidang Riset dan Inovasi Daerah mengajak seluruh pelajar, mahasiswa, akademisi, dan ASN untuk melahirkan inovasi solutif bagi Pringsewu.\";s:13:\"category_name\";s:24:\"Riset dan Inovasi Daerah\";s:13:\"category_code\";s:4:\"RIDA\";s:13:\"category_slug\";s:4:\"rida\";s:14:\"featured_image\";s:92:\"https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80\";s:12:\"published_at\";s:17:\"03 September 2026\";s:11:\"views_count\";i:415;}i:16;a:10:{s:2:\"id\";s:36:\"01a09a61-3ef7-7349-ba44-f57aaf2eba6f\";s:5:\"title\";s:79:\"Pengembangan Ekosistem UMKM dan Klaster Industri Kreatif Berbasis Potensi Lokal\";s:4:\"slug\";s:79:\"pengembangan-ekosistem-umkm-dan-klaster-industri-kreatif-berbasis-potensi-lokal\";s:7:\"excerpt\";s:129:\"Fasilitasi permodalan, perizinan berusaha mudah, dan promosi kain Tapis khas Pringsewu diangkat sebagai pilar ekonomi kerakyatan.\";s:13:\"category_name\";s:33:\"Perekonomian dan Sumber Daya Alam\";s:13:\"category_code\";s:4:\"PSDA\";s:13:\"category_slug\";s:4:\"psda\";s:14:\"featured_image\";s:92:\"https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=800&q=80\";s:12:\"published_at\";s:17:\"02 September 2026\";s:11:\"views_count\";i:240;}i:17;a:10:{s:2:\"id\";s:36:\"01a09a61-3ef9-72b0-ab5a-3e0295c7ccc2\";s:5:\"title\";s:79:\"Peningkatan Akses Sanitasi Layak dan Air Bersih Menuju Permukiman Berkelanjutan\";s:4:\"slug\";s:79:\"peningkatan-akses-sanitasi-layak-dan-air-bersih-menuju-permukiman-berkelanjutan\";s:7:\"excerpt\";s:123:\"Bidang IPW mengawal rencana induk penyediaan air minum (RISPAM) dan pembangunan infrastruktur persampahan ramah lingkungan.\";s:13:\"category_name\";s:38:\"Infrastruktur dan Pengembangan Wilayah\";s:13:\"category_code\";s:3:\"IPW\";s:13:\"category_slug\";s:3:\"ipw\";s:14:\"featured_image\";s:92:\"https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80\";s:12:\"published_at\";s:17:\"01 September 2026\";s:11:\"views_count\";i:220;}}s:7:\"indexes\";a:4:{i:0;a:7:{s:2:\"id\";s:36:\"01a09a48-7631-721f-978a-69235d5bf019\";s:4:\"name\";s:65:\"Laporan Akuntabilitas Kinerja Instansi Pemerintah (LAKIP / SAKIP)\";s:4:\"code\";s:5:\"SAKIP\";s:5:\"score\";s:5:\"82.30\";s:9:\"predicate\";s:10:\"Predikat A\";s:9:\"evaluator\";s:11:\"KemenPAN-RB\";s:4:\"year\";i:2025;}i:1;a:7:{s:2:\"id\";s:36:\"01a09a48-762f-7379-9cf6-1f824809d53b\";s:4:\"name\";s:41:\"Indeks Pengelolaan Keuangan Daerah (IPKD)\";s:4:\"code\";s:4:\"IPKD\";s:5:\"score\";s:5:\"84.10\";s:9:\"predicate\";s:4:\"Baik\";s:9:\"evaluator\";s:34:\"Kementerian Dalam Negeri RI & BPKP\";s:4:\"year\";i:2025;}i:2;a:7:{s:2:\"id\";s:36:\"01a09a48-762d-7365-a418-53f6502439b0\";s:4:\"name\";s:31:\"Indeks Daya Saing Daerah (IDSD)\";s:4:\"code\";s:4:\"IDSD\";s:5:\"score\";s:4:\"3.42\";s:9:\"predicate\";s:6:\"Tinggi\";s:9:\"evaluator\";s:39:\"Badan Riset dan Inovasi Nasional (BRIN)\";s:4:\"year\";i:2025;}i:3;a:7:{s:2:\"id\";s:36:\"01a09a48-762c-73f4-aaee-5a4a1207dc3f\";s:4:\"name\";s:27:\"Indeks Inovasi Daerah (IID)\";s:4:\"code\";s:3:\"IID\";s:5:\"score\";s:5:\"62.45\";s:9:\"predicate\";s:15:\"Sangat Inovatif\";s:9:\"evaluator\";s:59:\"Badan Strategi Kebijakan Dalam Negeri (BSKDN) Kemendagri RI\";s:4:\"year\";i:2025;}}s:12:\"headOfficial\";a:3:{s:4:\"name\";s:32:\"Dr. IMAM FATKUROJI, S.STP., M.IP\";s:8:\"position\";s:36:\"Kepala BAPPERIDA Kabupaten Pringsewu\";s:3:\"nip\";s:21:\"19841110 200312 1 001\";}}',1794419618);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `data_requests`
--

DROP TABLE IF EXISTS `data_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_requests` (
  `id` char(36) NOT NULL,
  `ticket_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) NOT NULL,
  `data_description` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `data_requests_ticket_number_unique` (`ticket_number`),
  KEY `data_requests_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_requests`
--

LOCK TABLES `data_requests` WRITE;
/*!40000 ALTER TABLE `data_requests` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `data_requests` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `document_categories`
--

DROP TABLE IF EXISTS `document_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `document_categories` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `document_categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document_categories`
--

LOCK TABLES `document_categories` WRITE;
/*!40000 ALTER TABLE `document_categories` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `document_categories` VALUES
('01a09a48-7604-7281-a6dc-d9c4aa9eb3dd','Dokumen Perencanaan','dokumen-perencanaan','Dokumen perencanaan induk daerah meliputi RPJPD, RPJMD, RKPD, Renstra, dan Renja.','2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-760a-719d-ab0f-385fdf7053b1','Dokumen Kajian','dokumen-kajian','Kajian strategis kebijakan daerah, kelayakan program, dan naskah akademik.','2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-760c-718c-8bfa-0ca7faa47639','Dokumen Analisis','dokumen-analisis','Analisis data spasial, ekonomi makro daerah, dan evaluasi capaian pembangunan.','2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-760d-7102-87c0-e6fe8dd338fd','Laporan Akuntabilitas','laporan-akuntabilitas','Laporan Akuntabilitas Kinerja Instansi Pemerintah (LAKIP) dan evaluasi SAKIP.','2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09b95-2a11-7260-9503-636ef038b256','Indeks Inovasi Daerah (IID)','laporan-iid','Laporan pengukuran kematangan dan dampak ekosistem inovasi daerah oleh Kemendagri RI.','2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a17-7094-8f14-48beb1192a3c','Indeks Daya Saing Daerah (IDSD)','laporan-idsd','Laporan pengukuran produktivitas dan pilar daya saing daerah oleh BRIN.','2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a19-73c4-8c14-604238079472','Indeks Pengelolaan Keuangan Daerah (IPKD)','laporan-ipkd','Laporan evaluasi transparansi, akuntabilitas, dan efisiensi fiskal keuangan daerah.','2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a1a-7391-9c1f-57cb270a8f40','Laporan Akuntabilitas Kinerja Instansi Pemerintah (LAKIP)','laporan-lakip','Laporan tahunan pertanggungjawaban kinerja instansi pemerintah (LAKIP / SAKIP).','2026-09-13 09:23:59','2026-09-13 09:23:59');
/*!40000 ALTER TABLE `document_categories` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `ikm_surveys`
--

DROP TABLE IF EXISTS `ikm_surveys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ikm_surveys` (
  `id` char(36) NOT NULL,
  `respondent_type` varchar(50) NOT NULL,
  `rating_service_ease` tinyint(3) unsigned NOT NULL,
  `rating_speed` tinyint(3) unsigned NOT NULL,
  `rating_transparency` tinyint(3) unsigned NOT NULL,
  `rating_satisfaction` tinyint(3) unsigned NOT NULL,
  `feedback` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ikm_surveys`
--

LOCK TABLES `ikm_surveys` WRITE;
/*!40000 ALTER TABLE `ikm_surveys` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `ikm_surveys` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_09_13_054118_create_personal_access_tokens_table',1),
(5,'2026_09_13_054128_add_auth_fields_to_users_table',1),
(6,'2026_09_13_054129_create_rbac_tables',1),
(7,'2026_09_13_054130_create_activity_logs_table',1),
(8,'2026_09_13_054830_create_planning_documents_tables',1),
(9,'2026_09_13_054831_create_news_tables',1),
(10,'2026_09_13_054832_create_regional_indexes_and_officials_tables',1),
(11,'2026_09_13_055351_create_service_requests_and_surveys_tables',1),
(12,'2026_09_13_060000_create_awards_table',2),
(14,'2026_09_14_000001_create_sppg_audits_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `news_articles`
--

DROP TABLE IF EXISTS `news_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `news_articles` (
  `id` char(36) NOT NULL,
  `category_id` char(36) NOT NULL,
  `author_id` char(36) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text NOT NULL,
  `content` longtext NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `views_count` int(10) unsigned NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `news_articles_slug_unique` (`slug`),
  KEY `news_articles_category_id_foreign` (`category_id`),
  KEY `news_articles_author_id_foreign` (`author_id`),
  KEY `news_articles_views_count_index` (`views_count`),
  KEY `news_articles_is_published_index` (`is_published`),
  KEY `news_articles_published_at_index` (`published_at`),
  CONSTRAINT `news_articles_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `news_articles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `news_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_articles`
--

LOCK TABLES `news_articles` WRITE;
/*!40000 ALTER TABLE `news_articles` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `news_articles` VALUES
('01a09a48-7624-712f-89c5-febc54ef0fdc','01a09a48-761b-71aa-bb17-38c54d183eee',NULL,'BAPPERIDA Pringsewu Gelar Forum Konsultasi Publik Rancangan Awal RKPD 2026','bapperida-pringsewu-gelar-forum-konsultasi-publik-rancangan-awal-rkpd-2026','Forum konsultasi publik bertujuan menghimpun aspirasi pemangku kepentingan dan menyelaraskan prioritas pembangunan Kabupaten Pringsewu tahun 2026.','<p>Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah (BAPPERIDA) Kabupaten Pringsewu menggelar Forum Konsultasi Publik Rancangan Awal Rencana Kerja Pemerintah Daerah (RKPD) Tahun 2026 secara hibrid yang dihadiri oleh seluruh pimpinan perangkat daerah, akademisi, tokoh masyarakat, dan perwakilan generasi muda.</p><p>Kepala BAPPERIDA menegaskan pentingnya kolaborasi pentahelix untuk memastikan pembangunan yang inklusif, adaptif terhadap perubahan iklim, dan berorientasi pada peningkatan kesejahteraan masyarakat di seluruh kecamatan se-Kabupaten Pringsewu.</p>',NULL,343,1,'2026-09-11 03:20:35','2026-09-13 03:20:35','2026-09-13 04:14:50'),
('01a09a48-7627-7221-a4eb-f532c5c2ad2a','01a09a48-7621-738b-9bb5-18bc1318ab21',NULL,'Kabupaten Pringsewu Raih Predikat Sangat Inovatif pada Indeks Inovasi Daerah 2025','kabupaten-pringsewu-raih-predikat-sangat-inovatif-pada-indeks-inovasi-daerah-2025','Dengan skor 62,45, Kabupaten Pringsewu kembali menorehkan prestasi gemilang dalam penilaian Indeks Inovasi Daerah oleh Kemendagri RI.','<p>Kementerian Dalam Negeri Republik Indonesia secara resmi merilis hasil pengukuran Indeks Inovasi Daerah (IID) tahun 2025. Kabupaten Pringsewu sukses meraih predikat Sangat Inovatif dengan skor 62,45.</p><p>Capaian ini didorong oleh penerapan puluhan inovasi layanan publik berbasis digital, inovasi tata kelola pemerintahan desa, dan kemudahan akses data untuk masyarakat.</p>',NULL,528,1,'2026-09-09 03:20:35','2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-7628-72fe-862a-a297c29c0e26','01a09a48-761f-7172-a569-aeeea9cfaa4e',NULL,'Sinkronisasi Rencana Tata Ruang Wilayah (RTRW) Pringsewu Dukung Kawasan Industri Hijau','sinkronisasi-rencana-tata-ruang-wilayah-rtrw-pringsewu-dukung-kawasan-industri-hijau','Bidang IPW mematangkan revisi RTRW untuk menjamin kepastian investasi dan perlindungan lahan pertanian pangan berkelanjutan.','<p>Bidang Infrastruktur dan Pengembangan Wilayah (IPW) BAPPERIDA memfasilitasi rapat koordinasi penataan ruang bersama kementerian terkait. Penyesuaian RTRW ini difokuskan pada penguatan koridor ekonomi antardaerah dengan tetap mempertahankan lahan sawah dilindungi (LSD).</p>',NULL,210,1,'2026-09-06 03:20:35','2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-762a-72d9-a3a4-28826ab7a67f','01a09a48-761e-736e-aba5-fbf0ded68c98',NULL,'Penguatan Ketahanan Pangan Melalui Hilirisasi Komoditas Pertanian Unggulan','penguatan-ketahanan-pangan-melalui-hilirisasi-komoditas-pertanian-unggulan','Bidang PSDA merumuskan strategi penguatan rantai pasok komoditas beras, kakao, dan hortikultura di sentra agribisnis Pringsewu.','<p>Sebagai lumbung pangan potensial di Provinsi Lampung, Kabupaten Pringsewu terus memacu produktivitas petani lewat program hilirisasi dan digitalisasi pemasaran hasil panen yang diintegrasikan dalam dokumen perencanaan tahunan.</p>',NULL,196,1,'2026-09-04 03:20:35','2026-09-13 03:20:35','2026-09-13 09:13:08'),
('01a09a61-3eeb-702f-b6fa-bf96fe1ab42e','01a09a48-761a-7320-ad8e-864963d3112d',NULL,'Penguatan Tata Kelola Reformasi Birokrasi dan Peningkatan Kapasitas SDM Bapperida Pringsewu','penguatan-tata-kelola-reformasi-birokrasi-dan-peningkatan-kapasitas-sdm-bapperida-pringsewu','Sekretariat BAPPERIDA menyelenggarakan lokakarya internal untuk memperkuat integritas aparatur, pengelolaan arsip digital, dan kedisiplinan kinerja.','<p>Sekretariat Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah (BAPPERIDA) Kabupaten Pringsewu terus memacu profesionalisme aparatur perencana melalui serangkaian bimbingan teknis dan implementasi manajemen talenta terpadu.</p><p>Sekretaris BAPPERIDA menekankan bahwa fondasi perencanaan yang kuat berakar dari akuntabilitas tata kelola keuangan, ketepatan administrasi, serta budaya kerja yang berorientasi pada pelayanan prima kepada seluruh OPD dan masyarakat.</p>',NULL,286,1,'2026-09-10 03:47:39','2026-09-13 03:47:39','2026-09-13 04:14:29'),
('01a09a61-3eef-7119-9416-234a0e983543','01a09a48-761a-7320-ad8e-864963d3112d',NULL,'Implementasi Sistem Akuntabilitas Kinerja Instansi Pemerintah Berbasis Digital','implementasi-sistem-akuntabilitas-kinerja-instansi-pemerintah-berbasis-digital','Optimalisasi aplikasi e-SAKIP mendorong transparansi pelaporan capaian program dan efisiensi serapan anggaran di lingkungan Bapperida.','<p>Dalam upaya mendukung transformasi digital birokrasi pemerintahan, Subbagian Perencanaan dan Keuangan BAPPERIDA mengintegrasikan modul e-SAKIP dalam pemantauan kinerja harian dan bulanan setiap bidang perencanaan.</p><p>Langkah ini menempatkan BAPPERIDA sebagai salah satu pelopor keterbukaan informasi dan akuntabilitas kinerja di tingkat Pemerintah Kabupaten Pringsewu.</p>',NULL,190,1,'2026-09-05 03:47:39','2026-09-13 03:47:39','2026-09-13 03:47:39'),
('01a09a61-3ef1-73a1-88fc-2030a31f129d','01a09a48-761b-71aa-bb17-38c54d183eee',NULL,'Rapat Koordinasi Evaluasi Triwulanan Realisasi RKPD dan Capaian Sasaran Makro','rapat-koordinasi-evaluasi-triwulanan-realisasi-rkpd-dan-capaian-sasaran-makro','Bidang PPE memaparkan progres indikator makro pembangunan ekonomi, laju inflasi daerah, dan konsistensi perencanaan anggaran daerah.','<p>Bidang Perencanaan, Pengendalian dan Evaluasi (PPE) memimpin rapat koordinasi pengendalian dan evaluasi pelaksanaan rencana pembangunan daerah bersama tim pengendali perangkat daerah.</p><p>Evaluasi menyeluruh dilakukan guna memitigasi kendala pelaksanaan di lapangan dan memastikan target tahun berjalan tercapai sesuai koridor waktu yang ditetapkan.</p>',NULL,310,1,'2026-09-07 03:47:39','2026-09-13 03:47:39','2026-09-13 03:47:39'),
('01a09a61-3ef2-7150-9c8f-fc82af75d60d','01a09a48-761c-7051-a039-92c78b2c6507',NULL,'Rembuk Stunting Pringsewu 2025: Penguatan Konvergensi Intervensi Gizi Spesifik dan Sensitif','rembuk-stunting-pringsewu-2025-penguatan-konvergensi-intervensi-gizi-spesifik-dan-sensitif','Bidang PPM menyatukan langkah lintas sektor perangkat daerah, puskesmas, dan kader posyandu untuk menuntaskan stunting hingga ke tingkat pekon.','<p>Bidang Pemerintahan dan Pembangunan Manusia (PPM) BAPPERIDA memfasilitasi gelaran Rembuk Stunting Tingkat Kabupaten Pringsewu sebagai wujud komitmen zero stunting.</p><p>Fokus utama mencakup pemetaan sasaran keluarga berisiko stunting, penyaluran pangan bergizi, serta sanitasi total berbasis masyarakat (STBM) yang terintegrasi di 126 pekon dan 5 kelurahan.</p>',NULL,512,1,'2026-09-12 03:47:39','2026-09-13 03:47:39','2026-09-13 03:47:39'),
('01a09a61-3ef5-7020-b116-13dfb15dc160','01a09a48-761c-7051-a039-92c78b2c6507',NULL,'Peningkatan Indeks Pembangunan Manusia (IPM) Pringsewu Melalui Pemerataan Layanan Dasar','peningkatan-indeks-pembangunan-manusia-ipm-pringsewu-melalui-pemerataan-layanan-dasar','Pringsewu konsisten mencatatkan IPM tertinggi di antara kabupaten se-Provinsi Lampung berkat sinergi pendidikan dan perlindungan sosial.','<p>Dengan angka IPM mencapai 72,85, Kabupaten Pringsewu terus memantapkan posisinya sebagai daerah dengan kualitas manusia yang unggul. Bidang PPM merumuskan langkah afirmasi untuk memastikan angka harapan sekolah dan usia harapan hidup terus meningkat di masa mendatang.</p>',NULL,379,1,'2026-09-08 03:47:39','2026-09-13 03:47:39','2026-09-13 04:15:08'),
('01a09a61-3ef7-7349-ba44-f57aaf2eba6f','01a09a48-761e-736e-aba5-fbf0ded68c98',NULL,'Pengembangan Ekosistem UMKM dan Klaster Industri Kreatif Berbasis Potensi Lokal','pengembangan-ekosistem-umkm-dan-klaster-industri-kreatif-berbasis-potensi-lokal','Fasilitasi permodalan, perizinan berusaha mudah, dan promosi kain Tapis khas Pringsewu diangkat sebagai pilar ekonomi kerakyatan.','<p>Bidang Perekonomian dan Sumber Daya Alam (PSDA) menginisiasi program pemberdayaan terpadu bagi kelompok pengrajin tapis dan industri pangan olahan bambu guna memperluas penetrasi pasar regional maupun internasional.</p>',NULL,240,1,'2026-09-02 03:47:39','2026-09-13 03:47:39','2026-09-13 03:47:39'),
('01a09a61-3ef9-72b0-ab5a-3e0295c7ccc2','01a09a48-761f-7172-a569-aeeea9cfaa4e',NULL,'Peningkatan Akses Sanitasi Layak dan Air Bersih Menuju Permukiman Berkelanjutan','peningkatan-akses-sanitasi-layak-dan-air-bersih-menuju-permukiman-berkelanjutan','Bidang IPW mengawal rencana induk penyediaan air minum (RISPAM) dan pembangunan infrastruktur persampahan ramah lingkungan.','<p>Melalui perencanaan infrastruktur yang terukur, BAPPERIDA memastikan ketersediaan akses sarana sanitasi dasar dan jaringan pipa air minum perpipaan bagi masyarakat perkotaan dan perdesaan secara berkeadilan.</p>',NULL,220,1,'2026-09-01 03:47:39','2026-09-13 03:47:39','2026-09-13 03:47:39'),
('01a09a61-3efb-71dd-ab48-9697e0447291','01a09a48-7621-738b-9bb5-18bc1318ab21',NULL,'Peluncuran Kompetisi Inovasi Daerah (KID) Pringsewu 2026: Ruang Riset dan Gagasan Kreatif','peluncuran-kompetisi-inovasi-daerah-kid-pringsewu-2026-ruang-riset-dan-gagasan-kreatif','Bidang Riset dan Inovasi Daerah mengajak seluruh pelajar, mahasiswa, akademisi, dan ASN untuk melahirkan inovasi solutif bagi Pringsewu.','<p>Bidang RIDA BAPPERIDA membuka pendaftaran Kompetisi Inovasi Daerah (KID) 2026 dengan tema \"Inovasi Berkelanjutan untuk Pringsewu Sejahtera\". Pemenang akan mendapatkan pendanaan riset prototipe dan fasilitasi pendaftaran Hak Kekayaan Intelektual (HAKI).</p>',NULL,415,1,'2026-09-03 03:47:39','2026-09-13 03:47:39','2026-09-13 03:47:39'),
('01a09baa-b17e-70a9-8b79-8c2521216c08','01a09a48-761a-7320-ad8e-864963d3112d',NULL,'Penguatan Pelayanan Informasi Publik dan Digitalisasi Arsip Perencanaan BAPPERIDA','penguatan-pelayanan-informasi-publik-dan-digitalisasi-arsip-perencanaan-bapperida','Subbag Umum mempercepat transformasi e-office dan keterbukaan akses dokumen perencanaan melalui portal Satu Data terpadu.','<p>Sekretariat BAPPERIDA Kabupaten Pringsewu terus membenahi standar layanan informasi publik. Pemanfaatan sistem digitalisasi arsip memungkinkan masyarakat mengakses ringkasan eksekutif dokumen perencanaan secara cepat, transparan, dan terverifikasi.</p>',NULL,320,1,'2026-09-12 15:47:30','2026-09-13 09:47:30','2026-09-13 09:47:30'),
('01a09baa-b180-736d-ac73-b91ef0961d92','01a09a48-761b-71aa-bb17-38c54d183eee',NULL,'Harmonisasi Target RPJMD 2025-2029 dan Evaluasi Capaian Indikator Sasaran Makro Daerah','harmonisasi-target-rpjmd-2025-2029-dan-evaluasi-capaian-indikator-sasaran-makro-daerah','Bidang PPE mematangkan penyelarasan indikator pertumbuhan ekonomi makro, inflasi terkendali, dan angka kemiskinan ekstrem.','<p>Penyusunan kerangka target 5 tahunan RPJMD Kabupaten Pringsewu 2025-2029 memasuki tahap uji publik. Bidang PPE menegaskan seluruh program perangkat daerah harus inline dengan tema pembangunan Lampung Maju dan Mandiri.</p>',NULL,480,1,'2026-09-12 21:47:30','2026-09-13 09:47:30','2026-09-13 09:47:30'),
('01a09baa-b182-708a-8833-da3ced4a7f09','01a09a48-761c-7051-a039-92c78b2c6507',NULL,'Peluang Kerja Generasi Muda: Integrasi Pelatihan Vokasi SMK dan Kebutuhan Industri Pringsewu','peluang-kerja-generasi-muda-integrasi-pelatihan-vokasi-smk-dan-kebutuhan-industri-pringsewu','Bidang PPM menyinergikan link and match kurikulum SMK dengan sentra industri kreatif dan agribisnis modern.','<p>Dalam upaya menekan tingkat pengangguran terbuka (TPT), Bidang PPM BAPPERIDA menginisiasi forum pentahelix bersama dunia usaha, dunia industri, dan sekolah kejuruan di Pringsewu untuk mencetak SDM berdaya saing global.</p>',NULL,395,1,'2026-09-13 01:47:30','2026-09-13 09:47:30','2026-09-13 09:47:30'),
('01a09baa-b184-7148-955d-d52c3ae17802','01a09a48-761e-736e-aba5-fbf0ded68c98',NULL,'Strategi Penguatan Pasar Komoditas Organik dan Produk Olahan Bambu Unggulan Pringsewu','strategi-penguatan-pasar-komoditas-organik-dan-produk-olahan-bambu-unggulan-pringsewu','Bidang PSDA mendorong hilirisasi ekonomi hijau berbasis kearifan lokal bambu dan sertifikasi pangan organik berskala nasional.','<p>Kabupaten Pringsewu memiliki potensi besar sebagai sentra kerajinan bambu dan pertanian ramah lingkungan. Bidang PSDA merancang fasilitasi sertifikasi organik serta kemitraan ritel modern demi menembus pasar ekspor.</p>',NULL,450,1,'2026-09-13 05:47:30','2026-09-13 09:47:30','2026-09-13 09:47:30'),
('01a09baa-b187-7138-9b62-300c3b5fb276','01a09a48-761f-7172-a569-aeeea9cfaa4e',NULL,'Optimalisasi Jaringan Drainase dan Manajemen Risiko Banjir Kawasan Perkotaan Pringsewu','optimalisasi-jaringan-drainase-dan-manajemen-risiko-banjir-kawasan-perkotaan-pringsewu','Bidang IPW merumuskan masterplan drainase perkotaan terpadu dan revitalisasi sempadan sungai untuk perlindungan lingkungan.','<p>Mengantisipasi perubahan iklim ekstrem, Bidang Infrastruktur dan Pengembangan Wilayah memetakan titik resapan air dan saluran primer perkotaan guna menjamin kenyamanan aktivitas warga dan ketahanan ruang kota.</p>',NULL,360,1,'2026-09-13 07:47:30','2026-09-13 09:47:30','2026-09-13 09:47:30'),
('01a09baa-b188-728f-a27c-b79d63555ed4','01a09a48-7621-738b-9bb5-18bc1318ab21',NULL,'Diseminasi Hasil Riset Kebijakan Daerah Bersama BRIN dan Kolaborasi Perguruan Tinggi','diseminasi-hasil-riset-kebijakan-daerah-bersama-brin-dan-kolaborasi-perguruan-tinggi','Bidang RIDA memaparkan 10 rekomendasi riset strategis guna mengakselerasi transformasi pelayanan publik dan ekonomi daerah.','<p>Kolaborasi riset antara BAPPERIDA Pringsewu dengan BRIN menghasilkan serangkaian rekomendasi berbasis bukti (evidence-based policy). Kebijakan ini diharapkan mampu mendongkrak efektivitas program pembangunan daerah tahun 2026.</p>',NULL,520,1,'2026-09-13 08:17:30','2026-09-13 09:47:30','2026-09-13 09:47:30');
/*!40000 ALTER TABLE `news_articles` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `news_categories`
--

DROP TABLE IF EXISTS `news_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `news_categories` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(20) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(30) NOT NULL DEFAULT 'teal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `news_categories_code_unique` (`code`),
  UNIQUE KEY `news_categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_categories`
--

LOCK TABLES `news_categories` WRITE;
/*!40000 ALTER TABLE `news_categories` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `news_categories` VALUES
('01a09a48-761a-7320-ad8e-864963d3112d','Sekretariat / Umum','UMUM','umum','Kegiatan kesekretariatan, kepegawaian, keuangan, dan tata usaha Bapperida.','slate','2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-761b-71aa-bb17-38c54d183eee','Perencanaan Pengendalian dan Evaluasi','PPE','ppe','Penyusunan RPJMD, RKPD, Musrenbang, dan evaluasi berkala capaian pembangunan.','teal','2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-761c-7051-a039-92c78b2c6507','Pemerintahan dan Pembangunan Manusia','PPM','ppm','Perencanaan bidang pendidikan, kesehatan, sosial, ketenagakerjaan, dan aparatur.','blue','2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-761e-736e-aba5-fbf0ded68c98','Perekonomian dan Sumber Daya Alam','PSDA','psda','Pengembangan sentra UMKM, pertanian, perikanan, perdagangan, dan lingkungan hidup.','emerald','2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-761f-7172-a569-aeeea9cfaa4e','Infrastruktur dan Pengembangan Wilayah','IPW','ipw','Tata ruang kota, konektivitas jalan, sanitasi, perumahan, dan utilitas daerah.','amber','2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-7621-738b-9bb5-18bc1318ab21','Riset dan Inovasi Daerah','RIDA','rida','Inovasi daerah, ekosistem riset, lomba kreativitas inovasi, dan indeks IID/IDSD.','purple','2026-09-13 03:20:35','2026-09-13 03:20:35');
/*!40000 ALTER TABLE `news_categories` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `officials`
--

DROP TABLE IF EXISTS `officials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `officials` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `position` varchar(255) NOT NULL,
  `category_code` varchar(20) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `officials_category_code_index` (`category_code`),
  KEY `officials_order_index` (`order`),
  KEY `officials_is_active_index` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `officials`
--

LOCK TABLES `officials` WRITE;
/*!40000 ALTER TABLE `officials` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `officials` VALUES
('01a09a48-7636-71d3-8174-1e153c948587','Dr. IMAM FATKUROJI, S.STP., M.IP','19841110 200312 1 001','Kepala BAPPERIDA Kabupaten Pringsewu','leadership',NULL,1,1,'2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-7638-722c-bb53-78d7c740f27f','SITI RAHMAH, S.I.Kom., MM','19850609 201001 2 014','Sekretaris BAPPERIDA','structural',NULL,2,1,'2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-763a-72ad-9842-100624b75031','FITRI FAULA, S.I.Kom','19880429 201001 2 006','Kasubbag Umum dan Kepegawaian','structural',NULL,3,1,'2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-763c-70e0-83bc-8de6bb32cb88','EVY SURYANI SIMATUPANG, MM','19830331 201101 2 006','JF Perencana Ahli Muda','functional',NULL,4,1,'2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-763d-739d-b758-31b0e27dbab1','FEBBY SABEL SUPRIYATNA, SE, MM','19860204 201001 2 021','JF Analis Keuangan Pusat dan Daerah Ahli Muda','functional',NULL,5,1,'2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-763f-72b1-bcb5-92a56907ff58','RARA SUKMA, ST., M.P.W.K','19850724 201001 2 016','Kepala Bidang PPE (Perencanaan, Pengendalian & Evaluasi)','structural',NULL,6,1,'2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-7640-7153-b480-bc44587f7cd0','Ir. A. ADAM ALTHUSIUS, ST., MURP.','19800422 201001 1 009','Kepala Bidang IPW (Infrastruktur & Pengembangan Wilayah)','structural',NULL,7,1,'2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-7643-739f-9bef-3eeead8069b2','DEBIT ZULIANSYAH, ST','19801012 201001 1 023','Kepala Bidang PPM (Pemerintahan & Pembangunan Manusia)','structural',NULL,8,1,'2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-7648-715c-be0a-e766de1db6d6','Ir. ERWIN SONI, ST., MM','19801208 201001 1 011','Kepala Bidang PSDA (Perekonomian & SDA)','structural',NULL,9,1,'2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-764a-7026-8ded-6ebe11c561ef','FENNY APRILIA, S.Sos','19840405 201001 2 032','Kepala Bidang RIDA (Riset & Inovasi Daerah)','structural',NULL,10,1,'2026-09-13 03:20:35','2026-09-13 03:20:35');
/*!40000 ALTER TABLE `officials` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `permissions` VALUES
('01a1d1ea-3919-7380-841c-25e4bd07d91d','Lihat Dokumen','documents.view','Dokumen','2026-11-12 15:39:10','2026-11-12 15:39:10'),
('01a1d1ea-391a-72d1-98be-073c9c24f62f','Tambah Dokumen','documents.create','Dokumen','2026-11-12 15:39:10','2026-11-12 15:39:10'),
('01a1d1ea-391c-72ce-87c2-27a676111906','Ubah Dokumen','documents.edit','Dokumen','2026-11-12 15:39:10','2026-11-12 15:39:10'),
('01a1d1ea-391d-7063-a343-9ed12600c9b5','Hapus Dokumen','documents.delete','Dokumen','2026-11-12 15:39:10','2026-11-12 15:39:10'),
('01a1d1ea-391e-7359-b6e3-4119ef67f97e','Publikasi Dokumen','documents.publish','Dokumen','2026-11-12 15:39:10','2026-11-12 15:39:10'),
('01a1d1ea-3920-7297-b10a-6a971a9a6cf1','Lihat Berita','news.view','Berita','2026-11-12 15:39:10','2026-11-12 15:39:10'),
('01a1d1ea-3921-73a3-baa7-e04dd7f6eae1','Tambah Berita','news.create','Berita','2026-11-12 15:39:10','2026-11-12 15:39:10'),
('01a1d1ea-3922-7215-b839-2d27d1007d30','Ubah Berita','news.edit','Berita','2026-11-12 15:39:10','2026-11-12 15:39:10'),
('01a1d1ea-3924-7201-8d17-d6e467ed188e','Hapus Berita','news.delete','Berita','2026-11-12 15:39:10','2026-11-12 15:39:10'),
('01a1d1ea-3925-721a-abe5-ffc34c0c3b4d','Kelola Indeks Daerah','indexes.manage','Indeks','2026-11-12 15:39:10','2026-11-12 15:39:10'),
('01a1d1ea-3926-70e8-80ba-c66ee05b2db2','Kelola Permohonan Data','services.manage','Layanan','2026-11-12 15:39:10','2026-11-12 15:39:10'),
('01a1d1ea-3928-71ad-9877-6b03e99b624b','Kelola Pengguna','users.manage','Sistem','2026-11-12 15:39:10','2026-11-12 15:39:10'),
('01a1d1ea-392a-7096-8ec8-09153be1a310','Lihat Audit Log','audit.view','Sistem','2026-11-12 15:39:10','2026-11-12 15:39:10');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` char(36) NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` char(36) NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `planning_documents`
--

DROP TABLE IF EXISTS `planning_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `planning_documents` (
  `id` char(36) NOT NULL,
  `category_id` char(36) NOT NULL,
  `user_id` char(36) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `year` smallint(5) unsigned NOT NULL,
  `document_number` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_size` bigint(20) unsigned DEFAULT NULL,
  `file_mime` varchar(100) DEFAULT NULL,
  `downloads_count` int(10) unsigned NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `planning_documents_slug_unique` (`slug`),
  KEY `planning_documents_category_id_foreign` (`category_id`),
  KEY `planning_documents_user_id_foreign` (`user_id`),
  KEY `planning_documents_year_index` (`year`),
  KEY `planning_documents_downloads_count_index` (`downloads_count`),
  KEY `planning_documents_is_published_index` (`is_published`),
  KEY `planning_documents_published_at_index` (`published_at`),
  CONSTRAINT `planning_documents_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `document_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `planning_documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planning_documents`
--

LOCK TABLES `planning_documents` WRITE;
/*!40000 ALTER TABLE `planning_documents` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `planning_documents` VALUES
('01a09a48-7611-7203-afae-a7cd620991ff','01a09a48-7604-7281-a6dc-d9c4aa9eb3dd',NULL,'Rencana Kerja Pemerintah Daerah (RKPD) Kabupaten Pringsewu Tahun 2026','rencana-kerja-pemerintah-daerah-rkpd-kabupaten-pringsewu-tahun-2026',2026,'Perbup No. 18 Tahun 2025','Dokumen RKPD memuat rancangan kerangka ekonomi daerah, prioritas pembangunan daerah, serta rencana kerja dan pendanaan untuk tahun 2026.',NULL,'RKPD_Kabupaten_Pringsewu_2026.pdf',14250000,'application/pdf',184,1,'2026-09-03 03:20:35','2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-7612-705e-bb2f-4feaddae8684','01a09a48-7604-7281-a6dc-d9c4aa9eb3dd',NULL,'Rencana Pembangunan Jangka Menengah Daerah (RPJMD) Kabupaten Pringsewu 2025-2029','rencana-pembangunan-jangka-menengah-daerah-rpjmd-kabupaten-pringsewu-2025-2029',2025,'Perda No. 04 Tahun 2025','Arah kebijakan dan strategi pembangunan lima tahunan Kabupaten Pringsewu menuju daerah yang berdaya saing, agraris mandiri, dan berkeadaban.',NULL,'RPJMD_Pringsewu_2025_2029.pdf',28400000,'application/pdf',420,1,'2026-08-14 03:20:35','2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-7614-71ed-a1ab-fa5d1e544be2','01a09a48-7604-7281-a6dc-d9c4aa9eb3dd',NULL,'Rencana Strategis (Renstra) BAPPERIDA Kabupaten Pringsewu Tahun 2025-2029','rencana-strategis-renstra-bapperida-kabupaten-pringsewu-tahun-2025-2029',2025,'Kepka Bapperida No. 02/2025','Renstra BAPPERIDA memuat visi teknis perencanaan, target indeks inovasi, dan roadmap riset daerah.',NULL,'Renstra_Bapperida_Pringsewu_2025_2029.pdf',8600000,'application/pdf',96,1,'2026-08-24 03:20:35','2026-09-13 03:20:35','2026-09-13 03:41:18'),
('01a09a48-7616-7178-b9f3-800e9e3a09f7','01a09a48-760a-719d-ab0f-385fdf7053b1',NULL,'Kajian Strategis Penanganan Kemiskinan Ekstrem dan Stunting Berbasis Spasial','kajian-strategis-penanganan-kemiskinan-ekstrem-dan-stunting-berbasis-spasial',2025,'Naskah Akademik 08/RIDA/2025','Kajian kolaboratif Bapperida bersama akademisi untuk pemetaan intervensi gizi terpadu di 9 kecamatan.',NULL,'Kajian_Stunting_Kemiskinan_Pringsewu_2025.pdf',5200000,'application/pdf',113,1,'2026-08-29 03:20:35','2026-09-13 03:20:35','2026-09-13 03:44:18'),
('01a09a48-7618-730e-a90b-ee5550265a17','01a09a48-760d-7102-87c0-e6fe8dd338fd',NULL,'Laporan Akuntabilitas Kinerja Instansi Pemerintah (LAKIP) BAPPERIDA 2025','laporan-akuntabilitas-kinerja-instansi-pemerintah-lakip-bapperida-2025',2025,'LAKIP-BAPPERIDA-2025','Laporan pertanggungjawaban pencapaian sasaran strategis, efisiensi anggaran, dan realisasi kinerja BAPPERIDA.',NULL,'LAKIP_BAPPERIDA_2025.pdf',6700000,'application/pdf',76,1,'2026-09-08 03:20:35','2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a5a-86fe-70c2-938e-26556dc955bf','01a09a48-760a-719d-ab0f-385fdf7053b1',NULL,'Kajian Kelayakan Pengembangan Kawasan Sentra Agribisnis Terpadu Pringsewu','kajian-kelayakan-pengembangan-kawasan-sentra-agribisnis-terpadu-pringsewu',2025,'Kajian Teknis 12/PSDA/2025','Studi kelayakan rantai pasok hilirisasi komoditas beras, hortikultura, dan perkebunan terintegrasi di Kabupaten Pringsewu.',NULL,'Kajian_Agribisnis_Terpadu_Pringsewu_2025.pdf',7400000,'application/pdf',88,1,'2026-08-26 03:40:19','2026-09-13 03:40:19','2026-09-13 03:40:19'),
('01a09a5a-8703-72b5-96e8-5356d9916148','01a09a48-760c-718c-8bfa-0ca7faa47639',NULL,'Analisis Ekonomi Makro dan Proyeksi Pertumbuhan PDRB Kabupaten Pringsewu 2025-2029','analisis-ekonomi-makro-dan-proyeksi-pertumbuhan-pdrb-kabupaten-pringsewu-2025-2029',2025,'Analisis-Makro-01/PPE/2025','Analisis komparatif laju pertumbuhan ekonomi daerah, tingkat inflasi, penyerapan tenaga kerja, dan proyeksi PDRB sektoral.',NULL,'Analisis_Ekonomi_Makro_Pringsewu_2025_2029.pdf',9100000,'application/pdf',143,1,'2026-09-01 03:40:19','2026-09-13 03:40:19','2026-09-13 03:40:19'),
('01a09a5a-8704-706c-a839-96bdf4e388b9','01a09a48-760c-718c-8bfa-0ca7faa47639',NULL,'Analisis Spasial Daya Dukung Daya Tampung Lingkungan Hidup (D3TLH) Pringsewu','analisis-spasial-daya-dukung-daya-tampung-lingkungan-hidup-d3tlh-pringsewu',2025,'Analisis-Spasial-05/IPW/2025','Analisis spasial kesesuaian lahan, ketersediaan air baku, dan daya tampung lingkungan hidup untuk mendukung revisi RTRW.',NULL,'Analisis_Spasial_D3TLH_Pringsewu_2025.pdf',11800000,'application/pdf',105,1,'2026-08-19 03:40:19','2026-09-13 03:40:19','2026-09-13 03:40:19'),
('01a09b95-2a22-72bf-b37f-d59533cae1cb','01a09b95-2a11-7260-9503-636ef038b256',NULL,'Laporan Hasil Pengukuran Indeks Inovasi Daerah (IID) Kabupaten Pringsewu Tahun 2025','laporan-hasil-pengukuran-indeks-inovasi-daerah-iid-kabupaten-pringsewu-tahun-2025',2025,'Kepmendagri No. 100.4.3-128/2025','Dokumen resmi hasil evaluasi dan penetapan Kabupaten Pringsewu berpredikat Sangat Inovatif dengan capaian skor 62,45 beserta rincian 58 proposal inovasi daerah.',NULL,'Laporan_Indeks_Inovasi_Daerah_Pringsewu_2025.pdf',9850000,'application/pdf',234,1,'2026-08-29 09:23:59','2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a24-7284-a362-159509f26b8f','01a09b95-2a11-7260-9503-636ef038b256',NULL,'Laporan Kematangan Ekosistem Riset dan Inovasi Daerah Pringsewu Tahun 2024','laporan-kematangan-ekosistem-riset-dan-inovasi-daerah-pringsewu-tahun-2024',2024,'Laporan-IID-2024/RIDA','Evaluasi penerapan inovasi tata kelola pemerintahan desa dan inovasi digital pelayanan publik Kabupaten Pringsewu tahun 2024.',NULL,'Laporan_IID_Pringsewu_2024.pdf',8400000,'application/pdf',189,1,'2025-09-13 09:23:59','2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a26-73ae-82d0-07c284aac5d3','01a09b95-2a11-7260-9503-636ef038b256',NULL,'Buku Profil Inovasi Pelayanan Publik dan Tata Kelola Pekon Pringsewu 2023','buku-profil-inovasi-pelayanan-publik-dan-tata-kelola-pekon-pringsewu-2023',2023,'Buku-Inovasi-Pringsewu-2023','Kompilasi inovasi unggulan berbasis kearifan lokal bambu, agribisnis pekon, dan kemudahan layanan administrasi kependudukan.',NULL,'Buku_Profil_Inovasi_Pringsewu_2023.pdf',12300000,'application/pdf',143,1,'2024-09-13 09:23:59','2026-09-13 09:23:59','2026-09-13 09:29:05'),
('01a09b95-2a29-71ec-9e57-381be6d306b3','01a09b95-2a17-7094-8f14-48beb1192a3c',NULL,'Laporan Analisis Indeks Daya Saing Daerah (IDSD) Kabupaten Pringsewu Tahun 2025','laporan-analisis-indeks-daya-saing-daerah-idsd-kabupaten-pringsewu-tahun-2025',2025,'BRIN-IDSD/PSW/2025','Laporan pengukuran komprehensif Badan Riset dan Inovasi Nasional (BRIN) dengan skor IDSD 3,42 (Kategori Tinggi) meliputi 4 komponen dan 12 pilar daya saing.',NULL,'Laporan_IDSD_Kabupaten_Pringsewu_2025.pdf',11200000,'application/pdf',178,1,'2026-08-26 09:23:59','2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a2a-7103-aea0-cceee7b648fb','01a09b95-2a17-7094-8f14-48beb1192a3c',NULL,'Laporan Pengukuran Produktivitas dan Daya Saing Wilayah Pringsewu Tahun 2024','laporan-pengukuran-produktivitas-dan-daya-saing-wilayah-pringsewu-tahun-2024',2024,'IDSD-PSW-2024','Analisis komparatif pilar ekosistem bisnis, dinamika pasar tenaga kerja, dan adopsi TIK di Kabupaten Pringsewu.',NULL,'Laporan_IDSD_Pringsewu_2024.pdf',7600000,'application/pdf',155,1,'2025-10-13 09:23:59','2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a2c-723a-816b-e94aca47e830','01a09b95-2a17-7094-8f14-48beb1192a3c',NULL,'Kajian Pilar Lingkungan Pendukung Daya Saing Ekonomi Pringsewu 2023','kajian-pilar-lingkungan-pendukung-daya-saing-ekonomi-pringsewu-2023',2023,'IDSD-Kajian-2023','Kajian mendalam stabilitas kelembagaan, infrastruktur dasar, dan kesiapan sektor ekonomi kerakyatan menghadapi pasar bebas.',NULL,'Kajian_Daya_Saing_Pringsewu_2023.pdf',6900000,'application/pdf',110,1,'2024-11-13 09:23:59','2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a2d-7044-a453-bee736fb52b2','01a09b95-2a19-73c4-8c14-604238079472',NULL,'Laporan Hasil Pengukuran Indeks Pengelolaan Keuangan Daerah (IPKD) Tahun 2025','laporan-hasil-pengukuran-indeks-pengelolaan-keuangan-daerah-ipkd-tahun-2025',2025,'Kepka-IPKD-PSW-2025','Laporan evaluasi Kemendagri dan BPKP atas kualitas pengelolaan keuangan Pringsewu dengan skor 84,10 (Kategori Baik) mencakup keselarasan dokumen perencanaan dan penganggaran.',NULL,'Laporan_IPKD_Kabupaten_Pringsewu_2025.pdf',10500000,'application/pdf',205,1,'2026-08-22 09:23:59','2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a30-7279-92fb-104365d177b9','01a09b95-2a19-73c4-8c14-604238079472',NULL,'Laporan Evaluasi Keselarasan Anggaran dan Efisiensi Fiskal Daerah Pringsewu 2024','laporan-evaluasi-keselarasan-anggaran-dan-efisiensi-fiskal-daerah-pringsewu-2024',2024,'IPKD-Fiskal-2024','Pengukuran dimensi transparansi pengelolaan keuangan, penyerapan anggaran belanja modal, dan kondisi keuangan daerah.',NULL,'Evaluasi_Fiskal_IPKD_2024.pdf',8100000,'application/pdf',160,1,'2025-11-13 09:23:59','2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a31-735e-8717-3334cb94c6dc','01a09b95-2a19-73c4-8c14-604238079472',NULL,'Laporan Keterbukaan dan Alokasi Belanja Modal Pembangunan Pringsewu 2023','laporan-keterbukaan-dan-alokasi-belanja-modal-pembangunan-pringsewu-2023',2023,'IPKD-Transparansi-2023','Laporan kinerja pemenuhan belanja wajib (mandatory spending) urusan pendidikan, kesehatan, dan infrastruktur.',NULL,'Laporan_Transparansi_IPKD_2023.pdf',7400000,'application/pdf',125,1,'2024-12-13 09:23:59','2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a32-72e8-a1c3-079eceefd018','01a09b95-2a1a-7391-9c1f-57cb270a8f40',NULL,'Laporan Akuntabilitas Kinerja Instansi Pemerintah (LAKIP) BAPPERIDA Tahun 2025','laporan-akuntabilitas-kinerja-instansi-pemerintah-lakip-bapperida-tahun-2025',2025,'LAKIP-BAPPERIDA-2025-FINAL','Laporan resmi akuntabilitas kinerja BAPPERIDA Pringsewu dengan predikat A (Nilai 82,30) berdasarkan evaluasi KemenPAN-RB.',NULL,'LAKIP_BAPPERIDA_Pringsewu_2025.pdf',14800000,'application/pdf',312,1,'2026-09-03 09:23:59','2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a34-734c-9555-78a5e5f4cf29','01a09b95-2a1a-7391-9c1f-57cb270a8f40',NULL,'Laporan Kinerja Instansi Pemerintah (LKjIP) BAPPERIDA Kabupaten Pringsewu Tahun 2024','laporan-kinerja-instansi-pemerintah-lkjip-bapperida-kabupaten-pringsewu-tahun-2024',2024,'LKjIP-BAPPERIDA-2024','Pertanggungjawaban sasaran strategis, efisiensi pagu anggaran, serta capaian indikator kinerja utama Bapperida tahun 2024.',NULL,'LKjIP_BAPPERIDA_Pringsewu_2024.pdf',11900000,'application/pdf',220,1,'2025-10-13 09:23:59','2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09b95-2a35-71c1-9ddc-f8e01f08dd71','01a09b95-2a1a-7391-9c1f-57cb270a8f40',NULL,'Laporan Evaluasi Perjanjian Kinerja dan Capaian Target Renstra BAPPERIDA 2023','laporan-evaluasi-perjanjian-kinerja-dan-capaian-target-renstra-bapperida-2023',2023,'LAKIP-PK-2023','Realisasi perjanjian kinerja aparatur perencana dan capaian target rencana strategis lima tahunan Bapperida.',NULL,'Laporan_PK_LAKIP_2023.pdf',9100000,'application/pdf',175,1,'2024-10-13 09:23:59','2026-09-13 09:23:59','2026-09-13 09:23:59'),
('01a09baa-b162-726e-a84a-e0d062545506','01a09a48-7604-7281-a6dc-d9c4aa9eb3dd',NULL,'Rencana Pembangunan Jangka Panjang Daerah (RPJPD) Kabupaten Pringsewu 2025-2045','rencana-pembangunan-jangka-panjang-daerah-rpjpd-kabupaten-pringsewu-2025-2045',2025,'Perda No. 01 Tahun 2025','Visi haluan besar pembangunan Pringsewu 20 tahun ke depan menuju Kabupaten Berdaya Saing, Harmonis, dan Berkelanjutan.',NULL,'RPJPD_Kabupaten_Pringsewu_2025_2045.pdf',32500000,'application/pdf',310,1,'2026-08-04 09:47:30','2026-09-13 09:47:30','2026-09-13 09:47:30'),
('01a09baa-b16f-7353-b40d-6f34be55ac35','01a09a48-7604-7281-a6dc-d9c4aa9eb3dd',NULL,'Rencana Kerja (Renja) BAPPERIDA Kabupaten Pringsewu Tahun 2026','rencana-kerja-renja-bapperida-kabupaten-pringsewu-tahun-2026',2026,'Renja-BAPPERIDA-2026','Matriks target program kerja teknis operasional 5 bidang perencana dan kesekretariatan BAPPERIDA tahun anggaran 2026.',NULL,'Renja_BAPPERIDA_Pringsewu_2026.pdf',6700000,'application/pdf',140,1,'2026-09-08 09:47:30','2026-09-13 09:47:30','2026-09-13 09:47:30'),
('01a09baa-b172-7166-88f5-8c1b73945cc6','01a09a48-7604-7281-a6dc-d9c4aa9eb3dd',NULL,'Perubahan Rencana Kerja Pemerintah Daerah (P-RKPD) Kabupaten Pringsewu Tahun 2025','perubahan-rencana-kerja-pemerintah-daerah-p-rkpd-kabupaten-pringsewu-tahun-2025',2025,'Perbup No. 24 Tahun 2025','Penyesuaian target indikator kinerja makro, realokasi belanja prioritas daerah, dan evaluasi capaian semester I tahun 2025.',NULL,'P-RKPD_Kabupaten_Pringsewu_2025.pdf',16800000,'application/pdf',195,1,'2026-07-15 09:47:30','2026-09-13 09:47:30','2026-09-13 09:47:30');
/*!40000 ALTER TABLE `planning_documents` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `regional_indexes`
--

DROP TABLE IF EXISTS `regional_indexes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `regional_indexes` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(20) NOT NULL,
  `year` smallint(5) unsigned NOT NULL,
  `score` decimal(8,2) NOT NULL,
  `predicate` varchar(255) NOT NULL,
  `evaluator` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `regional_indexes_code_index` (`code`),
  KEY `regional_indexes_year_index` (`year`),
  KEY `regional_indexes_is_active_index` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regional_indexes`
--

LOCK TABLES `regional_indexes` WRITE;
/*!40000 ALTER TABLE `regional_indexes` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `regional_indexes` VALUES
('01a09a48-762c-73f4-aaee-5a4a1207dc3f','Indeks Inovasi Daerah (IID)','IID',2025,62.45,'Sangat Inovatif','Badan Strategi Kebijakan Dalam Negeri (BSKDN) Kemendagri RI','Penilaian tahunan terhadap kematangan dan dampak ekosistem inovasi pelayanan publik dan tata kelola pemerintah daerah.',NULL,1,'2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-762d-7365-a418-53f6502439b0','Indeks Daya Saing Daerah (IDSD)','IDSD',2025,3.42,'Tinggi','Badan Riset dan Inovasi Nasional (BRIN)','Pengukuran produktivitas dan pilar daya saing daerah yang mencakup lingkungan pendukung, SDM, pasar, dan inovasi.',NULL,1,'2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-762f-7379-9cf6-1f824809d53b','Indeks Pengelolaan Keuangan Daerah (IPKD)','IPKD',2025,84.10,'Baik','Kementerian Dalam Negeri RI & BPKP','Evaluasi transparansi, akuntabilitas, dan efektivitas alokasi belanja modal serta pendapatan daerah.',NULL,1,'2026-09-13 03:20:35','2026-09-13 03:20:35'),
('01a09a48-7631-721f-978a-69235d5bf019','Laporan Akuntabilitas Kinerja Instansi Pemerintah (LAKIP / SAKIP)','SAKIP',2025,82.30,'Predikat A','KemenPAN-RB','Penilaian efektivitas penggunaan anggaran berbasis kinerja dan pencapaian target sasaran RPJMD.',NULL,1,'2026-09-13 03:20:35','2026-09-13 03:20:35');
/*!40000 ALTER TABLE `regional_indexes` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_permissions` (
  `role_id` char(36) NOT NULL,
  `permission_id` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `role_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_permissions`
--

LOCK TABLES `role_permissions` WRITE;
/*!40000 ALTER TABLE `role_permissions` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `role_permissions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `roles` VALUES
('01a1d1ea-3909-7373-9ab6-0a6e5a327c6e','Super Administrator','super_admin','Akses penuh seluruh konfigurasi sistem, audit log, manajemen pengguna, dan konten BAPPERIDA.','2026-11-12 15:39:10','2026-11-12 15:39:10'),
('01a1d1ea-390f-7144-a17f-b6b6323277ad','Admin Perencanaan & Evaluasi (PPE)','admin_perencanaan','Pengelolaan Dokumen Perencanaan Daerah (RPJPD, RPJMD, RKPD, Renstra, Renja, Kajian, Analisis).','2026-11-12 15:39:10','2026-11-12 15:39:10'),
('01a1d1ea-3910-7130-8222-87054f0123fb','Admin Riset & Inovasi (RIDA)','admin_riset','Pengelolaan data Riset, Inovasi Daerah, Indeks Inovasi Daerah (IID), dan Indeks Daya Saing Daerah (IDSD).','2026-11-12 15:39:10','2026-11-12 15:39:10'),
('01a1d1ea-3911-720e-9044-d572668f6cf2','Admin Bidang Pembangunan','admin_bidang','Pengelolaan konten bidang PPM, PSDA, dan IPW.','2026-11-12 15:39:10','2026-11-12 15:39:10'),
('01a1d1ea-3912-70fd-b7c1-412814ac1527','Operator Berita & Publikasi','operator_berita','Pengelolaan rilis berita, agenda pimpinan, artikel publikasi, dan galeri kegiatan.','2026-11-12 15:39:10','2026-11-12 15:39:10'),
('01a1d1ea-3914-7091-8609-64740e37a30a','Petugas Layanan & PPID','petugas_layanan','Pengelolaan permohonan data informasi publik, integrasi SPAN-LAPOR!, dan survei IKM.','2026-11-12 15:39:10','2026-11-12 15:39:10');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` char(36) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `sessions` VALUES
('11f8kP1rhEozPn3u1s0sBLMEhnvagqYmbL8v0LLb',NULL,'127.0.0.1','curl/8.22.0','eyJfdG9rZW4iOiI5UGwyWjFseHFvUXRoSktkU1VFMXRMejhNUGpjUjJRMjhwSnFOMlZWIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hdWRpdC1zcHBnIiwicm91dGUiOiJwdWJsaWMuYXVkaXQtc3BwZy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1794418718),
('3LKLRupAcE3e01cETJpIDwstl9jXsG8YiwKXmHb6',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJpVERnaEhESGliNkJBa0xuOVAyMG9YOGRHM093V1VQWnZZUUNWbmg1IiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluIn0sIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMCIsInJvdXRlIjoiaG9tZSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1789318207),
('bSfHcoVs4vXVhAWixGcG1xmJsSGy2y4g1mTD0CsZ',NULL,'127.0.0.1','curl/8.22.0','eyJfdG9rZW4iOiJEdGhSS2lhVGthajVQbVloNUhCTlFHSUt2a2NUSmU4WEVJUWxOWERnIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1794418718),
('fKzblEVh45Venez05zgKXBRIIft59IRdBJbGJxsB',NULL,'127.0.0.1','curl/8.22.0','eyJfdG9rZW4iOiJXbjNKRGhiREVPY3RBU3VZNWpZa2Qzbk9FVXZzMThTcDU0NndibXp2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hdWRpdC1zcHBnXC9mb3JtIiwicm91dGUiOiJwdWJsaWMuYXVkaXQtc3BwZy5jcmVhdGUifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794418718),
('l0BUu0D2UrdAZNAs9aPX3fxQx43zEHXpNF7gpBRH',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI3Rkwxbm4wYzJkZFFmU0I1U0hrVVI2bEhCRE5ad0pwd2JyM3k4UmRhIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1789317340),
('OfjLT0uTq6TBLtunwO7wFXbfNSCJjhO26Sy8uRzs',NULL,'127.0.0.1','curl/8.22.0','eyJfdG9rZW4iOiJidDZyMm01MVdCOWJ2bmlhVDYxTUtQMXFhaGVxMGdUQlVPa0JZNzc1IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hdWRpdC1zcHBnIiwicm91dGUiOiJwdWJsaWMuYXVkaXQtc3BwZy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1794522537),
('ofQsA3PxGxmSEO9dvAtGgTUFH9SU3X1aDcfIVoGG',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJXUXhkRnBmbnlBNzZTYlVPSDRxV0lnZFZNZ2QzNmVJVzR2WUNMd0JNIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hdWRpdC1zcHBnXC9mb3JtIiwicm91dGUiOiJwdWJsaWMuYXVkaXQtc3BwZy5jcmVhdGUifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794418944),
('WdkF0QtMvIcZLF5c5x55tlogxze6NPt0SfZW3Rdy',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJmUzNqRFpGYnVMc3gwYlRrV3JjamxDV2ZuTjU1SWVxY2doeEFpRHJRIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1794418828),
('XhJfHEnWCBH3EDNUYtwOTamgzfTz5XDyMIpn5B2h',NULL,'127.0.0.1','curl/8.22.0','eyJfdG9rZW4iOiJuNFBrZTV4T3oxQzJzVHhNZDZ3THZ5YlhqSlVoOTYzUHZzUmRGOUh2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hdWRpdC1zcHBnXC8wMWExY2I5ZC0xMzEyLTcyZmMtYTUxMy0yNmMxMDFhNDE3ZmYiLCJyb3V0ZSI6InB1YmxpYy5hdWRpdC1zcHBnLnNob3cifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794418729),
('YN7yTT1npunnH03kldQGraTopwrF5AsCjRihrsdF',NULL,'127.0.0.1','curl/8.22.0','eyJfdG9rZW4iOiJpODl6dU9hbERxSkN4RVNuZHdjdzQzcEdPN0ZiZWxXVGZJVWZxbUNqIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9zcHBnLWF1ZGl0cyJ9LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9zcHBnLWF1ZGl0cyIsInJvdXRlIjoiYWRtaW4uc3BwZy1hdWRpdHMuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794418718);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sppg_audits`
--

DROP TABLE IF EXISTS `sppg_audits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sppg_audits` (
  `id` char(36) NOT NULL,
  `inspection_number` varchar(50) DEFAULT NULL,
  `inspection_date` date NOT NULL,
  `sppg_id_code` varchar(8) NOT NULL,
  `sppg_name` varchar(255) NOT NULL,
  `sppg_type` varchar(30) NOT NULL DEFAULT 'BGN',
  `regency_city` varchar(255) NOT NULL DEFAULT 'Kabupaten Pringsewu',
  `inspector_name` varchar(255) NOT NULL,
  `beneficiary_count` int(11) NOT NULL DEFAULT 0,
  `has_slhs` tinyint(1) NOT NULL DEFAULT 0,
  `slhs_expiry_date` date DEFAULT NULL,
  `slhs_doc_path` varchar(255) DEFAULT NULL,
  `score_slhs` decimal(5,2) NOT NULL DEFAULT 0.00,
  `has_halal` tinyint(1) NOT NULL DEFAULT 0,
  `halal_expiry_date` date DEFAULT NULL,
  `halal_doc_path` varchar(255) DEFAULT NULL,
  `score_halal` decimal(5,2) NOT NULL DEFAULT 0.00,
  `score_legalitas_dokumen` decimal(5,2) NOT NULL DEFAULT 0.00,
  `head_present` tinyint(1) NOT NULL DEFAULT 0,
  `head_name` varchar(255) DEFAULT NULL,
  `head_nik` varchar(20) DEFAULT NULL,
  `head_phone` varchar(25) DEFAULT NULL,
  `head_photo_path` varchar(255) DEFAULT NULL,
  `head_ktp_path` varchar(255) DEFAULT NULL,
  `score_head` decimal(5,2) NOT NULL DEFAULT 0.00,
  `nutritionist_status` varchar(30) NOT NULL DEFAULT 'tidak_ada',
  `nutritionist_name` varchar(255) DEFAULT NULL,
  `nutritionist_nik` varchar(20) DEFAULT NULL,
  `nutritionist_phone` varchar(25) DEFAULT NULL,
  `nutritionist_education` varchar(255) DEFAULT NULL,
  `score_nutritionist` decimal(5,2) NOT NULL DEFAULT 0.00,
  `finance_present` tinyint(1) NOT NULL DEFAULT 0,
  `finance_name` varchar(255) DEFAULT NULL,
  `finance_nik` varchar(20) DEFAULT NULL,
  `finance_phone` varchar(25) DEFAULT NULL,
  `score_finance` decimal(5,2) NOT NULL DEFAULT 0.00,
  `score_staff_sppg` decimal(5,2) NOT NULL DEFAULT 0.00,
  `chef_present` tinyint(1) NOT NULL DEFAULT 0,
  `chef_name` varchar(255) DEFAULT NULL,
  `chef_nik` varchar(20) DEFAULT NULL,
  `chef_phone` varchar(25) DEFAULT NULL,
  `chef_photo_path` varchar(255) DEFAULT NULL,
  `chef_ktp_path` varchar(255) DEFAULT NULL,
  `score_chef_presence` decimal(5,2) NOT NULL DEFAULT 0.00,
  `chef_has_experience` tinyint(1) NOT NULL DEFAULT 0,
  `chef_paklaring_number` varchar(255) DEFAULT NULL,
  `chef_paklaring_doc_path` varchar(255) DEFAULT NULL,
  `score_chef_experience` decimal(5,2) NOT NULL DEFAULT 0.00,
  `score_chef` decimal(5,2) NOT NULL DEFAULT 0.00,
  `drinking_water_source` varchar(30) NOT NULL DEFAULT 'sumur',
  `drinking_water_photo_path` varchar(255) DEFAULT NULL,
  `score_air_minum` decimal(5,2) NOT NULL DEFAULT 0.00,
  `cooking_water_source` varchar(30) NOT NULL DEFAULT 'sumur',
  `cooking_water_photo_path` varchar(255) DEFAULT NULL,
  `score_air_masak` decimal(5,2) NOT NULL DEFAULT 0.00,
  `chiller_unit_count` int(11) NOT NULL DEFAULT 0,
  `chiller_temp_celsius` decimal(4,1) DEFAULT NULL,
  `chiller_status` varchar(30) NOT NULL DEFAULT 'not_working',
  `chiller_photo_path` varchar(255) DEFAULT NULL,
  `score_chiller` decimal(5,2) NOT NULL DEFAULT 0.00,
  `freezer_unit_count` int(11) NOT NULL DEFAULT 0,
  `freezer_temp_celsius` decimal(4,1) DEFAULT NULL,
  `freezer_capacity_liters` int(11) DEFAULT NULL,
  `freezer_status` varchar(30) NOT NULL DEFAULT 'not_working',
  `freezer_photo_path` varchar(255) DEFAULT NULL,
  `score_freezer` decimal(5,2) NOT NULL DEFAULT 0.00,
  `score_rantai_dingin` decimal(5,2) NOT NULL DEFAULT 0.00,
  `stove_high_pressure_count` int(11) NOT NULL DEFAULT 0,
  `stove_low_pressure_count` int(11) NOT NULL DEFAULT 0,
  `stove_all_working` tinyint(1) NOT NULL DEFAULT 0,
  `stove_ratio` decimal(5,2) NOT NULL DEFAULT 0.00,
  `stove_condition` varchar(255) NOT NULL DEFAULT 'none',
  `stove_photo_path` varchar(255) DEFAULT NULL,
  `score_kompor` decimal(5,2) NOT NULL DEFAULT 0.00,
  `sink_persiapan` tinyint(1) NOT NULL DEFAULT 0,
  `sink_pemorsian` tinyint(1) NOT NULL DEFAULT 0,
  `sink_pengolahan` tinyint(1) NOT NULL DEFAULT 0,
  `sink_kamar_mandi` tinyint(1) NOT NULL DEFAULT 0,
  `sink_jalan_masuk` tinyint(1) NOT NULL DEFAULT 0,
  `sink_photo_path` varchar(255) DEFAULT NULL,
  `score_sink` decimal(5,2) NOT NULL DEFAULT 0.00,
  `ipal_functioning` tinyint(1) NOT NULL DEFAULT 0,
  `ipal_photo_path` varchar(255) DEFAULT NULL,
  `score_ipal` decimal(5,2) NOT NULL DEFAULT 0.00,
  `grease_trap_functioning` tinyint(1) NOT NULL DEFAULT 0,
  `grease_trap_photo_path` varchar(255) DEFAULT NULL,
  `score_grease_trap` decimal(5,2) NOT NULL DEFAULT 0.00,
  `score_sanitasi_dasar` decimal(5,2) NOT NULL DEFAULT 0.00,
  `apar_available` tinyint(1) NOT NULL DEFAULT 0,
  `apar_expiry_date` date DEFAULT NULL,
  `apar_is_valid` tinyint(1) NOT NULL DEFAULT 0,
  `apar_photo_path` varchar(255) DEFAULT NULL,
  `score_apar` decimal(5,2) NOT NULL DEFAULT 0.00,
  `label_has_time_limit` tinyint(1) NOT NULL DEFAULT 0,
  `label_has_no_takeaway` tinyint(1) NOT NULL DEFAULT 0,
  `label_photo_path` varchar(255) DEFAULT NULL,
  `score_label_ompreng` decimal(5,2) NOT NULL DEFAULT 0.00,
  `land_area_sqm` decimal(8,2) NOT NULL DEFAULT 0.00,
  `building_area_sqm` decimal(8,2) NOT NULL DEFAULT 0.00,
  `area_compliance` varchar(30) NOT NULL DEFAULT 'sesuai',
  `area_front_photo_path` varchar(255) DEFAULT NULL,
  `building_front_photo_path` varchar(255) DEFAULT NULL,
  `score_luasan` decimal(5,2) NOT NULL DEFAULT 0.00,
  `rack_dry_material` varchar(30) NOT NULL DEFAULT 'tidak_ada',
  `pallet_dry_material` varchar(30) NOT NULL DEFAULT 'tidak_ada',
  `rack_wet_material` varchar(30) NOT NULL DEFAULT 'tidak_ada',
  `pallet_wet_material` varchar(30) NOT NULL DEFAULT 'tidak_ada',
  `warehouse_dry_photo_path` varchar(255) DEFAULT NULL,
  `warehouse_wet_photo_path` varchar(255) DEFAULT NULL,
  `score_gudang` decimal(5,2) NOT NULL DEFAULT 0.00,
  `production_flow_status` varchar(50) NOT NULL DEFAULT 'sesuai_tanpa_catatan',
  `production_flow_video_url` varchar(255) DEFAULT NULL,
  `production_flow_notes` text DEFAULT NULL,
  `score_alur_produksi` decimal(5,2) NOT NULL DEFAULT 0.00,
  `cctv_all_critical_points` tinyint(1) NOT NULL DEFAULT 0,
  `cctv_unit_count` int(11) NOT NULL DEFAULT 0,
  `cctv_type` varchar(30) DEFAULT NULL,
  `cctv_photo_path` varchar(255) DEFAULT NULL,
  `score_cctv` decimal(5,2) NOT NULL DEFAULT 0.00,
  `internet_speed_test_available` tinyint(1) NOT NULL DEFAULT 0,
  `internet_download_mbps` decimal(6,2) DEFAULT NULL,
  `internet_upload_mbps` decimal(6,2) DEFAULT NULL,
  `internet_provider` varchar(255) DEFAULT NULL,
  `internet_speed_test_photo_path` varchar(255) DEFAULT NULL,
  `score_internet` decimal(5,2) NOT NULL DEFAULT 0.00,
  `score_cctv_internet` decimal(5,2) NOT NULL DEFAULT 0.00,
  `score_keamanan_pangan` decimal(5,2) NOT NULL DEFAULT 0.00,
  `score_legalitas_sdm` decimal(5,2) NOT NULL DEFAULT 0.00,
  `score_lahan_keselamatan` decimal(5,2) NOT NULL DEFAULT 0.00,
  `total_score` decimal(5,2) NOT NULL DEFAULT 0.00,
  `grade` varchar(10) NOT NULL DEFAULT 'Grade D',
  `recommendation` varchar(50) NOT NULL DEFAULT 'tidak_layak',
  `recommendation_reason` text DEFAULT NULL,
  `satgas_leader_name` varchar(255) NOT NULL DEFAULT 'Ketua Satgas MBG Pringsewu',
  `satgas_leader_signature` text DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'submitted',
  `created_by_ip` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sppg_audits_sppg_id_code_index` (`sppg_id_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sppg_audits`
--

LOCK TABLES `sppg_audits` WRITE;
/*!40000 ALTER TABLE `sppg_audits` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `sppg_audits` VALUES
('01a1cb9d-1312-72fc-a513-26c101a417ff','ST-SATGAS/PSW/2026/014','2026-11-09','18020101','SPPG Sentra Dapur Mandiri Pringsewu Kota','Mandiri','Kabupaten Pringsewu','Ahmad Fadillah, S.Tr.Gz & Tim Satgas MBG',2500,1,'2028-05-11',NULL,6.00,1,'2028-11-11',NULL,6.00,12.00,1,'Bambang Sutejo, S.E.','1810011504820003','081273928192',NULL,NULL,2.00,'ada_gizi','Siti Aminah, S.Gz.','1810016508930002','082188291029','S1 Ilmu Gizi (Ahli Gizi Terdaftar)',2.00,1,'Dewi Rahmawati, A.Md.Ak.','1810014502950001','085278192039',1.00,5.00,1,'Chef Hardianto Saputra','1810012209880004','081399281720',NULL,NULL,3.00,1,'PKL-CHEF/HOTEL-BDL/2024-08',NULL,3.00,6.00,'ro',NULL,7.00,'ro',NULL,9.00,2,3.5,'optimal_le_5',NULL,5.00,2,-20.0,1200,'optimal_le_minus18',NULL,6.00,11.00,4,3,1,1.26,'Seluruh kompor berfungsi baik & ada kompor high pressure (rasio >= 1)',NULL,4.00,1,1,1,1,1,NULL,6.00,1,NULL,4.00,1,NULL,2.00,12.00,1,'2027-09-11',1,NULL,5.00,1,1,NULL,3.00,450.00,280.00,'sesuai',NULL,NULL,7.00,'stainless','stainless','stainless','stainless',NULL,NULL,8.00,'sesuai_tanpa_catatan','https://drive.google.com/file/d/sppg-pringsewu-flow-sample',NULL,8.00,1,12,'IP Cam NVR 4K',NULL,1.50,1,85.50,42.20,'IndiHome Fiber 100 Mbps',NULL,1.50,3.00,65.00,23.00,12.00,100.00,'Grade A','layak_dilanjutkan','Fasilitas sangat higienis, rantai dingin optimal, seluruh 10 titik kritis CCTV ter-cover dengan baik dan tenaga koki serta ahli gizi terverifikasi.','Drs. Akhmad Pratama, M.Si.',NULL,'verified',NULL,'2026-11-11 10:17:11','2026-11-11 10:17:11'),
('01a1cb9d-131f-7376-bb26-a7891a20b6b2','ST-SATGAS/PSW/2026/015','2026-11-07','18020202','SPPG Sentra Gizi Sejahtera Gadingrejo','BGN','Kabupaten Pringsewu','dr. Hendra Kusuma & Tim Satgas MBG',1800,1,'2027-07-11',NULL,6.00,1,'2028-01-11',NULL,6.00,12.00,1,'H. Suryadi, S.Sos.','1810022003750001','082190827361',NULL,NULL,2.00,'ada_tekpang','Rina Marlina, S.T.P.','1810025107960003','081298371928','S1 Teknologi Pangan (Tekpang)',1.00,1,'Arif Wicaksono, S.E.','1810021406900002','085718293019',1.00,4.00,1,'Chef M. Yusuf Ansori','1810020803870005','081377281920',NULL,NULL,3.00,1,'PKL-RESTO-PRINGSEWU/2025/11',NULL,3.00,6.00,'galon',NULL,6.00,'galon',NULL,8.00,1,4.2,'optimal_le_5',NULL,5.00,1,-16.5,800,'above_minus18',NULL,3.00,8.00,2,3,1,1.25,'Seluruh kompor berfungsi baik & ada kompor high pressure (rasio >= 1)',NULL,4.00,1,1,1,1,0,NULL,4.80,1,NULL,4.00,1,NULL,2.00,10.80,1,'2027-04-11',1,NULL,5.00,1,1,NULL,3.00,350.00,210.00,'sesuai',NULL,NULL,7.00,'besi_plastik','besi_plastik','besi_plastik','besi_plastik',NULL,NULL,7.00,'sesuai_dengan_catatan','https://drive.google.com/file/d/sppg-gadingrejo-flow','Terdapat tirai plastik pemisah ruang pengolahan dan pemorsian, disarankan sekat partisi penuh.',6.00,1,10,'DVR 16 CH 1080P',NULL,1.50,1,45.10,18.30,'Biznet Home 50 Mbps',NULL,1.50,3.00,55.80,22.00,12.00,89.80,'Grade A','layak_dilanjutkan','Perlu kalibrasi suhu freezer agar konsisten di bawah -18°C dan penambahan 1 wastafel di area pintu masuk utama.','Drs. Akhmad Pratama, M.Si.',NULL,'verified',NULL,'2026-11-11 10:17:11','2026-11-11 10:17:11'),
('01a1cb9d-1321-7262-83b8-f7536106c881','ST-SATGAS/PSW/2026/016','2026-11-04','18020303','SPPG Komunitas Tani Berkah Pagelaran','Khusus','Kabupaten Pringsewu','Ir. Muhammad Ridwan & Tim Satgas MBG',1200,0,NULL,NULL,0.00,1,'2027-05-11',NULL,6.00,6.00,1,'Wahyudi, S.Pd.','1810031105800001','085269182736',NULL,NULL,2.00,'tidak_ada',NULL,NULL,NULL,NULL,0.00,0,NULL,NULL,NULL,0.00,2.00,1,'Budi Santoso','1810031908850002','082281920394',NULL,NULL,3.00,0,NULL,NULL,0.00,3.00,'pdam',NULL,4.00,'sumur',NULL,2.00,1,7.0,'above_5',NULL,3.00,1,-12.0,500,'above_minus18',NULL,3.00,6.00,0,2,0,0.75,'Rasio kompor di bawah kapasitas PM (< 1)',NULL,0.00,1,0,1,1,0,NULL,3.60,0,NULL,0.00,1,NULL,2.00,5.60,0,NULL,0,NULL,0.00,0,0,NULL,0.00,200.00,130.00,'di_bawah_standar',NULL,NULL,3.00,'kayu','kayu','tidak_ada','tidak_ada',NULL,NULL,0.00,'tidak_sesuai',NULL,'Alur lalu lintas bahan baku bersilangan dengan sisa sampah/limbah.',4.00,0,2,'Stand Alone WiFi Cam',NULL,0.00,0,NULL,NULL,NULL,NULL,0.00,0.00,21.60,11.00,3.00,35.60,'Grade D','tidak_layak','Belum memiliki dokumen SLHS, palet kayu dilarang digunakan, IPAL belum berfungsi, dan belum ada tenaga ahli gizi tersertifikasi.','Drs. Akhmad Pratama, M.Si.',NULL,'submitted',NULL,'2026-11-11 10:17:11','2026-11-11 10:17:11'),
('01a1cb9d-1323-728e-a6e6-89463ded7cf4','ST-SATGAS/PSW/2026/017','2026-11-10','18020404','SPPG Satgas Gizi Sukoharjo Makmur','BGN','Kabupaten Pringsewu','Nurmala Sari, S.KM. & Tim Satgas MBG',2200,1,'2027-11-11',NULL,6.00,1,'2028-07-11',NULL,6.00,12.00,1,'Dra. Hj. Nurjanah, M.Pd.','1810044501780002','081272819203',NULL,NULL,2.00,'ada_gizi','Fadhil Pratama, S.Gz.','1810042104950004','082177391029','S1 Gizi Kesehatan',2.00,1,'Tri Wulandari, S.Ak.','1810045903930001','085288192039',1.00,5.00,1,'Chef Agus Salim','1810041806840003','081399182736',NULL,NULL,3.00,1,'SK-CHEF/CATERING-MBG/2025-03',NULL,3.00,6.00,'ro',NULL,7.00,'ro',NULL,9.00,2,4.0,'optimal_le_5',NULL,5.00,2,-19.0,1000,'optimal_le_minus18',NULL,6.00,11.00,4,2,1,1.23,'Seluruh kompor berfungsi baik & ada kompor high pressure (rasio >= 1)',NULL,4.00,1,1,1,1,1,NULL,6.00,1,NULL,4.00,1,NULL,2.00,12.00,1,'2027-08-11',1,NULL,5.00,1,1,NULL,3.00,400.00,260.00,'sesuai',NULL,NULL,7.00,'stainless','stainless','stainless','stainless',NULL,NULL,8.00,'sesuai_tanpa_catatan','https://drive.google.com/file/d/sppg-sukoharjo-flow',NULL,8.00,1,11,'IP Cam 4MP PoE',NULL,1.50,1,78.40,38.60,'IndiHome 100 Mbps',NULL,1.50,3.00,65.00,23.00,12.00,100.00,'Grade A','layak_dilanjutkan','Standar higienitas dan sanitasi dapur sangat baik, penanganan rantai dingin memuaskan, dokumen legalitas lengkap.','Drs. Akhmad Pratama, M.Si.',NULL,'verified',NULL,'2026-11-11 10:17:11','2026-11-11 10:17:11'),
('01a1cb9d-1324-717a-b646-27aad91481e4','ST-SATGAS/PSW/2026/018','2026-11-06','18020505','SPPG Gotong Royong Adiluwih','Mandiri','Kabupaten Pringsewu','Faisal Tanjung, S.T. & Tim Satgas MBG',1500,1,'2027-10-11',NULL,6.00,0,NULL,NULL,0.00,6.00,1,'Kurniawan, S.E.','1810052102830002','081273918201',NULL,NULL,2.00,'ada_tekpang','Dian Permata, S.T.P.','1810055208970001','082188273619','S1 Teknologi Industri Pertanian',1.00,1,'Agus Priyono','1810051103890003','085277182930',1.00,4.00,1,'Chef Danu Subroto','1810051907860004','081399281720',NULL,NULL,3.00,1,'PKL-RESTO-ADILUWIH/2025/09',NULL,3.00,6.00,'galon',NULL,6.00,'galon',NULL,8.00,1,4.5,'optimal_le_5',NULL,5.00,1,-15.0,600,'above_minus18',NULL,3.00,8.00,2,2,0,1.20,'Ada kompor tidak berfungsi tapi ada kompor high pressure (rasio >= 1)',NULL,2.00,1,1,1,1,0,NULL,4.80,1,NULL,4.00,1,NULL,2.00,10.80,1,'2027-05-11',1,NULL,5.00,1,1,NULL,3.00,300.00,180.00,'sesuai',NULL,NULL,7.00,'besi_plastik','besi_plastik','besi_plastik','besi_plastik',NULL,NULL,7.00,'sesuai_dengan_catatan',NULL,'Tirai sekat ruang pemorsian perlu diganti partisi aluminium permanen.',6.00,1,10,'DVR 16 CH',NULL,1.50,1,35.00,15.00,'Iconnet 35 Mbps',NULL,1.50,3.00,53.80,16.00,12.00,81.80,'Grade B','layak_dengan_perbaikan','Percepatan penerbitan Sertifikat Halal, perbaikan 1 unit tungku kompor bertekanan tinggi, dan penyesuaian suhu freezer hingga -18°C.','Drs. Akhmad Pratama, M.Si.',NULL,'verified',NULL,'2026-11-11 10:17:11','2026-11-11 10:17:11');
/*!40000 ALTER TABLE `sppg_audits` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles` (
  `user_id` char(36) NOT NULL,
  `role_id` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `user_roles_role_id_foreign` (`role_id`),
  CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `user_roles` VALUES
('01a1d1ea-39f4-738a-92e3-9acca94b0993','01a1d1ea-3909-7373-9ab6-0a6e5a327c6e',NULL,NULL);
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `users` VALUES
('01a1d1ea-39f4-738a-92e3-9acca94b0993','Super Administrator BAPPERIDA','admin@bapperida.pringsewukab.go.id','2026-11-12 15:39:10','$2y$12$9UUpgeekQyyuSgPqZ3emPOW9Nkm1zACP8El8Xaeu7XGmSuOOCM6Dm',NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-11-12 15:39:10','2026-11-12 15:39:10');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
commit;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-11-13  5:39:23
