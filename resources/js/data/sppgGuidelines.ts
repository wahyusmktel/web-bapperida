/**
 * Panduan Resmi & Standar Penilaian Checklist Kelayakan Operasional SPPG
 * Satuan Tugas Percepatan Program Makan Bergizi Gratis (MBG) Kabupaten/Kota
 * Sumber: Badan Gizi Nasional (BGN) RI - 14 Indikator (Total 100%)
 */

export interface SppgIndicatorGuide {
    id: number;
    code: string;
    title: string;
    weight: string;
    weightValue: number;
    category: 'keamanan_pangan' | 'legalitas_sdm' | 'lahan_keselamatan';
    categoryLabel: string;
    objective: string;
    docRequirement: string[];
    criteria: Array<{
        condition: string;
        score: string;
        scoreValue: number;
        note?: string;
    }>;
    officialTips: string[];
    imageHint: string;
}

export const SPPG_GUIDELINES: Record<number, SppgIndicatorGuide> = {
    1: {
        id: 1,
        code: 'IND-01',
        title: 'Legalitas Dokumen',
        weight: '12%',
        weightValue: 12,
        category: 'legalitas_sdm',
        categoryLabel: 'Legalitas & SDM (Bobot 23%)',
        objective: 'Memeriksa dua dokumen legal dapur: SLHS (Sertifikat Laik Higiene Sanitasi) dan Sertifikat Halal, beserta masa berlakunya.',
        docRequirement: [
            'Foto dokumen asli SLHS (tampak tanggal masa berlaku)',
            'Foto dokumen asli Sertifikat Halal resmi BPJPH / MUI (tampak tanggal berlaku)',
        ],
        criteria: [
            { condition: 'SLHS Ada (Dokumen asli tersedia, tercantum berlaku s.d tanggal)', score: '6%', scoreValue: 6 },
            { condition: 'SLHS Tidak Ada (Dokumen tidak tersedia/kedaluwarsa)', score: '0%', scoreValue: 0 },
            { condition: 'Sertifikat Halal Ada (Dokumen asli tersedia, tercantum berlaku s.d tanggal)', score: '6%', scoreValue: 6 },
            { condition: 'Sertifikat Halal Tidak Ada (Dokumen tidak tersedia/kedaluwarsa)', score: '0%', scoreValue: 0 },
        ],
        officialTips: [
            'Kedua dokumen wajib berstatus aktif saat pemeriksaan berlangsung.',
            'Jika salah satu belum terbit, verifikasi surat tanda terima pendaftaran resmi dari Dinas Kesehatan / BPJPH.',
        ],
        imageHint: 'slhs_halal',
    },
    2: {
        id: 2,
        code: 'IND-02',
        title: 'Staff di SPPG',
        weight: '5%',
        weightValue: 5,
        category: 'legalitas_sdm',
        categoryLabel: 'Legalitas & SDM (Bobot 23%)',
        objective: 'Memastikan Kepala SPPG, Pengawas Gizi, dan Pengawas Keuangan ada di lokasi saat pemeriksaan dan identitasnya terverifikasi.',
        docRequirement: [
            'Foto Kepala SPPG memegang KTP dengan latar belakang papan nama dapur SPPG',
            'Foto KTP Kepala SPPG jelas terbaca',
            'Ijazah / STR Pengawas Gizi atau bukti kualifikasi Tekpang',
        ],
        criteria: [
            { condition: 'Kepala SPPG: Ada di lokasi saat inspeksi', score: '2%', scoreValue: 2 },
            { condition: 'Kepala SPPG: Tidak ada di lokasi', score: '0%', scoreValue: 0 },
            { condition: 'Pengawas Gizi: Ada di lokasi, lulusan jurusan Ahli Gizi (S.Gz / A.Md.Gz)', score: '2%', scoreValue: 2 },
            { condition: 'Pengawas Gizi: Ada di lokasi, non-ahli gizi yang diperbolehkan (Teknologi Pangan / Tekpang)', score: '1%', scoreValue: 1 },
            { condition: 'Pengawas Gizi: Tidak ada di lokasi', score: '0%', scoreValue: 0 },
            { condition: 'Pengawas Keuangan: Ada di lokasi saat inspeksi', score: '1%', scoreValue: 1 },
            { condition: 'Pengawas Keuangan: Tidak ada di lokasi', score: '0%', scoreValue: 0 },
        ],
        officialTips: [
            'Jam kerja Kepala SPPG & Pengawas Gizi: 02.00–08.00 WIB & 17.00–19.30 WIB.',
            'Jam kerja Pengawas Keuangan: 09.00–15.00 WIB & 17.00–19.30 WIB.',
        ],
        imageHint: 'staff_sppg',
    },
    3: {
        id: 3,
        code: 'IND-03',
        title: 'Chef (Koki Profesional)',
        weight: '6%',
        weightValue: 6,
        category: 'legalitas_sdm',
        categoryLabel: 'Legalitas & SDM (Bobot 23%)',
        objective: 'Memastikan Chef ada di lokasi dan identitasnya terverifikasi. Pengalaman dibuktikan dengan paklaring atau masa kerja minimal 1 (satu) tahun.',
        docRequirement: [
            'Foto Chef memegang KTP dengan latar belakang papan nama dapur SPPG',
            'Foto KTP Chef jelas terbaca',
            'Surat Keterangan Kerja (Paklaring) atau bukti masa kerja minimal 1 tahun di industri boga/restoran/hotel',
        ],
        criteria: [
            { condition: 'Kehadiran Chef: Ada di lokasi saat pemeriksaan', score: '3%', scoreValue: 3 },
            { condition: 'Kehadiran Chef: Tidak ada di lokasi', score: '0%', scoreValue: 0 },
            { condition: 'Paklaring: Ada paklaring atau bukti 1 (satu) tahun telah bekerja', score: '3%', scoreValue: 3 },
            { condition: 'Paklaring: Tidak ada paklaring / bukti 1 tahun bekerja', score: '0%', scoreValue: 0 },
        ],
        officialTips: [
            'Jam kerja Chef: 02.00–08.00 WIB & 17.00–19.30 WIB (waktu masak utama & persiapan).',
            'Chef bertanggung jawab penuh atas cita rasa, higiene proses olah, dan keselamatan kerja dapur.',
        ],
        imageHint: 'chef_paklaring',
    },
    4: {
        id: 4,
        code: 'IND-04',
        title: 'Sumber Air Minum',
        weight: '7%',
        weightValue: 7,
        category: 'keamanan_pangan',
        categoryLabel: 'Keamanan Pangan (Bobot 65%)',
        objective: 'Mencatat jenis sumber air yang dipakai untuk air minum di dapur, beserta foto sumbernya sebagai bukti dokumentasi.',
        docRequirement: [
            'Foto sumber air minum yang digunakan di dapur SPPG (mesin filtrasi RO / dispenser galon / instalasi)',
        ],
        criteria: [
            { condition: 'RO (Reverse Osmosis) - Filtrasi membran semipermeabel teknologi tinggi', score: '7%', scoreValue: 7 },
            { condition: 'Galon Bermerek Resmi (AMDK) atau Depot Isi Ulang Berizin (AMIU)', score: '6%', scoreValue: 6 },
            { condition: 'PDAM (Perusahaan Daerah Air Minum terkelola pemda)', score: '4%', scoreValue: 4 },
            { condition: 'Sumur Gali / Sumur Bor tanpa pengolahan lanjutan', score: '0%', scoreValue: 0 },
        ],
        officialTips: [
            'Jika ada lebih dari satu sumber air minum yang digunakan, pilih opsi dengan skor tertinggi.',
            'Air sumur mentah dilarang disajikan langsung tanpa teknologi Reverse Osmosis bersertifikasi.',
        ],
        imageHint: 'air_minum',
    },
    5: {
        id: 5,
        code: 'IND-05',
        title: 'Sumber Air Masak',
        weight: '9%',
        weightValue: 9,
        category: 'keamanan_pangan',
        categoryLabel: 'Keamanan Pangan (Bobot 65%)',
        objective: 'Mencatat jenis sumber air yang dipakai untuk masak di dapur SPPG, beserta foto sumbernya sebagai bukti dokumentasi.',
        docRequirement: [
            'Foto sumber air masak yang terhubung langsung ke area dapur/tungku kompor',
        ],
        criteria: [
            { condition: 'RO (Reverse Osmosis) - Air murni berpenyaringan ketat', score: '9%', scoreValue: 9 },
            { condition: 'Galon Berizin Edar Resmi (AMDK/AMIU)', score: '8%', scoreValue: 8 },
            { condition: 'PDAM Bersih Terkelola', score: '6%', scoreValue: 6 },
            { condition: 'Sumur Gali / Sumur Bor Dangkal/Dalam', score: '2%', scoreValue: 2 },
        ],
        officialTips: [
            'Jika ada lebih dari satu sumber, masukkan pilihan dengan skor tertinggi.',
            'Air masak digunakan untuk merebus sayur, menanak nasi, kuah kaldu, dan pencucian bahan mentah tahap akhir.',
        ],
        imageHint: 'air_masak',
    },
    6: {
        id: 6,
        code: 'IND-06',
        title: 'Rantai Dingin (Chiller & Freezer)',
        weight: '11%',
        weightValue: 11,
        category: 'keamanan_pangan',
        categoryLabel: 'Keamanan Pangan (Bobot 65%)',
        objective: 'Memeriksa unit penyimpanan dingin: jumlah unit, suhu yang terbaca di display digital, dan status fungsi unit secara menyeluruh.',
        docRequirement: [
            'Foto Chiller dengan angka suhu terbaca jelas pada display digital',
            'Foto Freezer dengan angka suhu terbaca jelas pada display digital beserta kapasitas liter',
        ],
        criteria: [
            { condition: 'Chiller: Unit berfungsi baik, suhu display terbaca ≤ 5°C', score: '5%', scoreValue: 5 },
            { condition: 'Chiller: Unit berfungsi baik, suhu display terbaca > 5°C', score: '3%', scoreValue: 3 },
            { condition: 'Chiller: Tidak berfungsi / suhu tidak tampak di display', score: '0%', scoreValue: 0 },
            { condition: 'Freezer: Unit berfungsi baik, suhu display terbaca ≤ −18°C', score: '6%', scoreValue: 6 },
            { condition: 'Freezer: Unit berfungsi baik, suhu display terbaca > −18°C', score: '3%', scoreValue: 3 },
            { condition: 'Freezer: Tidak berfungsi / suhu tidak tampak di display', score: '0%', scoreValue: 0 },
        ],
        officialTips: [
            'Suhu ≤ 5°C mutlak diperlukan untuk chiller penyimpanan sayur dan bahan siap olah.',
            'Suhu ≤ -18°C mutlak diperlukan untuk membekukan protein hewani (daging ayam/sapi/ikan) guna mencegah perkembangbiakan bakteri patogen.',
        ],
        imageHint: 'rantai_dingin',
    },
    7: {
        id: 7,
        code: 'IND-07',
        title: 'Kompor (High Pressure & Low Pressure)',
        weight: '4%',
        weightValue: 4,
        category: 'keamanan_pangan',
        categoryLabel: 'Keamanan Pangan (Bobot 65%)',
        objective: 'Memeriksa jumlah tungku, keberadaan kompor high pressure, serta rasio kapasitas kompor terhadap jumlah porsi PM yang dilayani hari itu.',
        docRequirement: [
            'Foto keseluruhan area memasak dan kompor yang terpasang di SPPG',
        ],
        criteria: [
            { condition: 'Seluruh kompor berfungsi baik & ADA kompor high pressure (rasio kapasitas ≥ 1.0)', score: '4%', scoreValue: 4 },
            { condition: 'Ada kompor tidak berfungsi TAPI ada kompor high pressure (rasio kapasitas ≥ 1.0)', score: '2%', scoreValue: 2 },
            { condition: 'Seluruh kompor berfungsi baik TAPI TIDAK ADA kompor high pressure (rasio kapasitas ≥ 1.0)', score: '1%', scoreValue: 1 },
            { condition: 'Seluruh kompor berfungsi baik tanpa high pressure dengan rasio kapasitas < 1.0', score: '0%', scoreValue: 0 },
            { condition: 'Ada kompor tidak berfungsi & rasio kapasitas kompor < 1.0', score: '0%', scoreValue: 0 },
        ],
        officialTips: [
            'Standar BGN: 1 tungku kompor berdaya tampung masak setara 450 PM.',
            'Rumus Rasio = (Jumlah kompor berfungsi × 450 PM) / Jumlah PM yang dilayani hari itu.',
            'Jika rasio < 1.0 maka skor otomatis 0%. Jika rasio ≥ 1.0 dan ada unit tidak berfungsi maka skor maksimal 2%.',
        ],
        imageHint: 'kompor_high_pressure',
    },
    8: {
        id: 8,
        code: 'IND-08',
        title: 'Sanitasi Dasar (Wastafel, IPAL & Grease Trap)',
        weight: '12%',
        weightValue: 12,
        category: 'keamanan_pangan',
        categoryLabel: 'Keamanan Pangan (Bobot 65%)',
        objective: 'Memeriksa fasilitas cuci tangan higienis di 5 titik lokasi krusial serta saluran pengolahan limbah dapur (IPAL & Grease Trap).',
        docRequirement: [
            'Foto wastafel & sabun cuci tangan di setiap 5 ruang',
            'Foto IPAL dalam keadaan terbuka (memperlihatkan kondisi aerasi / isi IPAL)',
            'Foto saluran Grease Trap penangkap lemak dalam keadaan berfungsi',
        ],
        criteria: [
            { condition: 'Wastafel Ruang Persiapan: Berfungsi & sabun cair tersedia', score: '1.2%', scoreValue: 1.2 },
            { condition: 'Wastafel Ruang Pemorsian: Berfungsi & sabun cair tersedia', score: '1.2%', scoreValue: 1.2 },
            { condition: 'Wastafel Ruang Pengolahan: Berfungsi & sabun cair tersedia', score: '1.2%', scoreValue: 1.2 },
            { condition: 'Wastafel Kamar Mandi: Berfungsi & sabun cair tersedia', score: '1.2%', scoreValue: 1.2 },
            { condition: 'Wastafel Jalan Masuk: Berfungsi & sabun cair tersedia', score: '1.2%', scoreValue: 1.2 },
            { condition: 'Saluran Limbah IPAL: Berfungsi lancar & tidak meluap', score: '4%', scoreValue: 4 },
            { condition: 'Saluran Limbah Grease Trap: Berfungsi menangkap lemak minyak', score: '2%', scoreValue: 2 },
        ],
        officialTips: [
            'Wastafel cuci tangan dinilai 1.2% per titik (maksimal 6% untuk 5 titik lokasi).',
            'IPAL dan Grease trap wajib beroperasi agar limbah organik dan minyak tidak mencemari lingkungan pemukiman warga sekitar.',
        ],
        imageHint: 'sanitasi_wastafel',
    },
    9: {
        id: 9,
        code: 'IND-09',
        title: 'APAR (Alat Pemadam Api Ringan)',
        weight: '5%',
        weightValue: 5,
        category: 'lahan_keselamatan',
        categoryLabel: 'Lahan & Keselamatan Kerja (Bobot 12%)',
        objective: 'Memeriksa ketersediaan Alat Pemadam Api Ringan (APAR jenis powder minimal 3 kg) dan masa berlakunya.',
        docRequirement: [
            'Foto unit APAR terpasang di dinding/bracket area masak dapur',
            'Foto label inspeksi / tag tanggal kedaluwarsa APAR yang masih berlaku',
        ],
        criteria: [
            { condition: 'APAR Tersedia, tanggal kedaluwarsa ada dan masih berlaku', score: '5%', scoreValue: 5 },
            { condition: 'APAR Tersedia, tapi tanggal kedaluwarsa habis atau label tidak ada', score: '0%', scoreValue: 0 },
            { condition: 'APAR Tidak Tersedia di area dapur SPPG', score: '0%', scoreValue: 0 },
        ],
        officialTips: [
            'Contoh standar: APAR Dry Chemical Powder kapasitas minimal 3 kg.',
            'APAR wajib diletakkan pada posisi mudah dijangkau tanpa terhalang barang tumpukan.',
        ],
        imageHint: 'apar_tabung',
    },
    10: {
        id: 10,
        code: 'IND-10',
        title: 'Label Kemasan Ompreng Makanan',
        weight: '3%',
        weightValue: 3,
        category: 'keamanan_pangan',
        categoryLabel: 'Keamanan Pangan (Bobot 65%)',
        objective: 'Memeriksa apakah label edukasi dan peringatan pada tutup kemasan ompreng sudah sesuai standar resmi BGN.',
        docRequirement: [
            'Foto stiker label yang tertempel nyata pada tutup ompreng stainless SPPG',
        ],
        criteria: [
            { condition: 'Ada informasi "Konsumsi sebelum jam …" / "Batas waktu konsumsi: …"', score: '1.5%', scoreValue: 1.5 },
            { condition: 'Ada informasi "Tidak boleh dibawa pulang"', score: '1.5%', scoreValue: 1.5 },
            { condition: 'Kedua informasi di atas tercantum lengkap pada label kemasan', score: '3%', scoreValue: 3 },
            { condition: 'Ada label, tapi tidak mencantumkan kedua informasi di atas (tidak sesuai standar)', score: '0%', scoreValue: 0 },
        ],
        officialTips: [
            'Kedua informasi sangat krusial untuk mencegah keracunan makanan basi karena konsumsi terlambat.',
            'Jika ada kedua info tersebut, centang kedua klausul untuk mendapatkan poin penuh 3%.',
        ],
        imageHint: 'label_ompreng',
    },
    11: {
        id: 11,
        code: 'IND-11',
        title: 'Jenis & Luasan SPPG',
        weight: '7%',
        weightValue: 7,
        category: 'lahan_keselamatan',
        categoryLabel: 'Lahan & Keselamatan Kerja (Bobot 12%)',
        objective: 'Mencatat jenis SPPG, luas tanah dan bangunan, serta kesesuaiannya terhadap kapasitas Penerima Manfaat (PM).',
        docRequirement: [
            'Foto Lahan & Bangunan SPPG tampak depan penuh',
            'Foto Bangunan SPPG tampak depan dengan plang nama',
        ],
        criteria: [
            { condition: 'Sesuai (Luas bangunan ≥ standar kapasitas PM yang dilayani)', score: '7%', scoreValue: 7 },
            { condition: 'Di Bawah Standar (Luas bangunan < standar range PM)', score: '3%', scoreValue: 3 },
            { condition: 'Tidak Dapat Dinilai (Denah/luas tidak dapat diukur secara presisi)', score: '0%', scoreValue: 0 },
        ],
        officialTips: [
            'Standar Luas Bangunan vs Kapasitas PM (tidak termasuk cuci ompreng, kantor, mess & garasi):',
            '• Luas 160 m²: Maksimal 500 PM',
            '• Luas 161–240 m²: Maksimal 1.500 PM',
            '• Luas 241–320 m²: Maksimal 2.500 PM',
            '• Luas 321–400 m²: Maksimal 3.000 PM',
        ],
        imageHint: 'luasan_bangunan',
    },
    12: {
        id: 12,
        code: 'IND-12',
        title: 'Gudang Kering & Basah (Rak & Palet)',
        weight: '8%',
        weightValue: 8,
        category: 'keamanan_pangan',
        categoryLabel: 'Keamanan Pangan (Bobot 65%)',
        objective: 'Memeriksa material rak dan palet pada gudang kering dan basah. Skor dibedakan berdasarkan ketahanan dan sifat higienis bahan.',
        docRequirement: [
            'Foto Gudang Kering beserta rak penyimpanan',
            'Foto Gudang Basah beserta rak penyimpanan',
            'Foto Palet pada Gudang Kering (dilarang berbahan kayu)',
            'Foto Palet pada Gudang Basah (dilarang berbahan kayu)',
        ],
        criteria: [
            { condition: 'Rak Stainless Steel (Gudang Kering / Basah)', score: '2.0% / unit', scoreValue: 2 },
            { condition: 'Rak Besi / Plastik Tebal / Baja Ringan', score: '1.75% / unit', scoreValue: 1.75 },
            { condition: 'Rak Kayu atau Tidak Tersedia', score: '0%', scoreValue: 0 },
            { condition: 'Palet Stainless Steel (Gudang Kering / Basah)', score: '2.0% / unit', scoreValue: 2 },
            { condition: 'Palet Besi / Plastik Polimer / Baja Ringan', score: '1.75% / unit', scoreValue: 1.75 },
            { condition: 'Palet Kayu (DILARANG KERAS) atau Tidak Ada Palet', score: '0%', scoreValue: 0 },
        ],
        officialTips: [
            'PERINGATAN RESMI: Palet kayu dilarang keras karena menyerap cairan, lembab, dan menjadi sarang rayap/bakteri.',
            'Gudang Kering & Basah masing-masing dinilai pada komponen rak (2%) dan palet (2%) = total 8%.',
        ],
        imageHint: 'gudang_palet',
    },
    13: {
        id: 13,
        code: 'IND-13',
        title: 'Video Alur Proses Produksi',
        weight: '8%',
        weightValue: 8,
        category: 'keamanan_pangan',
        categoryLabel: 'Keamanan Pangan (Bobot 65%)',
        objective: 'Memastikan alur proses produksi di dalam SPPG berjalan satu arah (one-way flow) tanpa kontaminasi silang dan terekam dalam video.',
        docRequirement: [
            'Rekaman video alur produksi dari ruang penerimaan bahan baku, persiapan, pengolahan, pendinginan, pemorsian hingga distribusi',
        ],
        criteria: [
            { condition: 'Sesuai ketentuan alur proses produksi tanpa pengecualian & ADA batas sekat penuh partisi', score: '8%', scoreValue: 8 },
            { condition: 'Sesuai ketentuan alur produksi DENGAN catatan (tidak ada batas sekat penuh partisi antar ruang)', score: '6%', scoreValue: 6 },
            { condition: 'Tidak sesuai ketentuan alur proses produksi DENGAN catatan', score: '4%', scoreValue: 4 },
        ],
        officialTips: [
            'Alur wajib satu arah: Bahan mentah masuk -> Olah -> Matang -> Kemas -> Keluar. Dilarang berpapasan dengan arus sampah.',
            'Sekat penuh antara ruang masak panas dengan ruang pemorsian/pendinginan menjaga suhu higienis makanan.',
        ],
        imageHint: 'alur_produksi',
    },
    14: {
        id: 14,
        code: 'IND-14',
        title: 'CCTV Pengawasan Dapur & Bandwidth Internet',
        weight: '3%',
        weightValue: 3,
        category: 'keamanan_pangan',
        categoryLabel: 'Keamanan Pangan (Bobot 65%)',
        objective: 'Memeriksa keberadaan CCTV di 10 titik kritis dapur serta kestabilan koneksi internet melalui bukti speed test ber-timestamp.',
        docRequirement: [
            'Foto unit CCTV / DVR / NVR yang terpasang (tampak tipe & kabel instalasi)',
            'Screenshot hasil speed test internet dari aplikasi HP (menampilkan angka download, upload, dan timestamp)',
        ],
        criteria: [
            { condition: 'CCTV: Terpasang di SELURUH 10 titik kritis operasional', score: '1.5%', scoreValue: 1.5 },
            { condition: 'CCTV: Tidak terpasang di seluruh 10 titik kritis (ada titik blind spot)', score: '0%', scoreValue: 0 },
            { condition: 'Internet: Hasil speed test ada dan tercatat (download & upload)', score: '1.5%', scoreValue: 1.5 },
            { condition: 'Internet: Hasil speed test tidak ada / tidak tercatat', score: '0%', scoreValue: 0 },
        ],
        officialTips: [
            'Daftar 10 Titik Kritis CCTV Wajib:',
            '1. Lobby Penerimaan Bahan Baku',
            '2. Gudang Kering',
            '3. Gudang Basah',
            '4. Ruang Persiapan Protein Nabati',
            '5. Ruang Persiapan Protein Hewani',
            '6. Ruang Pemasakan (Cooking Area)',
            '7. Ruang Pendinginan (Cooling Area)',
            '8. Ruang Pemorsian (Portioning)',
            '9. Area Distribusi / Pengiriman',
            '10. Ruang Pencucian Ompreng (Washing)',
        ],
        imageHint: 'cctv_internet',
    },
};

export const SPPG_CATEGORIES = [
    {
        key: 'legalitas_sdm',
        title: 'Pilar 1: Legalitas & SDM',
        weight: '23%',
        weightValue: 23,
        description: 'Pemeriksaan keabsahan dokumen izin operasional, sertifikasi halal, serta verifikasi fisik Kepala SPPG, Chef, dan Pengawas.',
        indicators: [1, 2, 3],
        color: 'blue',
    },
    {
        key: 'keamanan_pangan',
        title: 'Pilar 2: Keamanan Pangan (Food Safety)',
        weight: '65%',
        weightValue: 65,
        description: 'Standar higienitas paling krusial mencakup sumber air, rantai dingin, kompor, sanitasi wastafel & limbah, label ompreng, gudang, alur produksi satu arah, dan pemantauan CCTV 10 titik kritis.',
        indicators: [4, 5, 6, 7, 8, 10, 12, 13, 14],
        color: 'emerald',
    },
    {
        key: 'lahan_keselamatan',
        title: 'Pilar 3: Lahan & Keselamatan Kerja',
        weight: '12%',
        weightValue: 12,
        description: 'Kesiapsiagaan proteksi kebakaran (APAR) dan kesesuaian luasan fisik dapur terhadap jumlah porsi PM yang dilayani.',
        indicators: [9, 11],
        color: 'amber',
    },
];

export const GRADE_CRITERIA = {
    A: {
        grade: 'Grade A',
        label: 'Layak Dilanjutkan',
        minScore: 85.0,
        badgeClass: 'bg-emerald-100 text-emerald-800 border-emerald-300',
        bgClass: 'bg-emerald-600',
        textClass: 'text-emerald-700',
        desc: 'Memenuhi standar prima operasional BGN. SPPG diperkenankan melanjutkan operasional pelayanan Makan Bergizi Gratis secara penuh.',
    },
    B: {
        grade: 'Grade B',
        label: 'Layak Dilanjutkan dengan Perbaikan',
        minScore: 70.0,
        badgeClass: 'bg-amber-100 text-amber-800 border-amber-300',
        bgClass: 'bg-amber-500',
        textClass: 'text-amber-700',
        desc: 'Memenuhi standar dasar operasional namun memiliki catatan perbaikan teknis yang wajib diselesaikan dalam tenggat waktu yang ditentukan.',
    },
    D: {
        grade: 'Grade D',
        label: 'Tidak Layak Dilanjutkan',
        minScore: 0.0,
        badgeClass: 'bg-rose-100 text-rose-800 border-rose-300',
        bgClass: 'bg-rose-600',
        textClass: 'text-rose-700',
        desc: 'Belum memenuhi batas minimal kelayakan operasional BGN. Kegiatan dihentikan sementara hingga seluruh temuan kritis diperbaiki dan diinspeksi ulang.',
    },
};
