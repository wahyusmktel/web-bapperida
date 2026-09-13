<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Primary SEO Meta Tags -->
        <title>{{ config('app.name', 'BAPPERIDA Kabupaten Pringsewu') }} - Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah</title>
        <meta name="title" content="BAPPERIDA Kabupaten Pringsewu - Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah">
        <meta name="description" content="Portal resmi BAPPERIDA Kabupaten Pringsewu. Akses dokumen perencanaan daerah (RPJPD, RPJMD, RKPD), riset tematik, publikasi 6 bidang, indeks inovasi (IID), dan layanan aspirasi publik terpadu.">
        <meta name="keywords" content="BAPPERIDA Pringsewu, Bappeda Pringsewu, Kabupaten Pringsewu, RPJMD Pringsewu, RKPD Pringsewu, Indeks Inovasi Daerah, Perencanaan Pembangunan Lampung, Satu Data Pringsewu, SPAN LAPOR Pringsewu, Riset Inovasi Daerah">
        <meta name="author" content="BAPPERIDA Pemerintah Kabupaten Pringsewu">
        <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
        <meta name="googlebot" content="index, follow">
        <link rel="canonical" href="{{ url()->current() }}">

        <!-- Local Geo Tags for Pringsewu, Lampung -->
        <meta name="geo.region" content="ID-LA">
        <meta name="geo.placename" content="Kabupaten Pringsewu">
        <meta name="geo.position" content="-5.345331;105.004576">
        <meta name="ICBM" content="-5.345331, 105.004576">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="BAPPERIDA Kabupaten Pringsewu - Perencanaan, Riset & Inovasi Daerah">
        <meta property="og:description" content="Portal resmi Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah Kabupaten Pringsewu. Akses produk kebijakan makro, riset terpadu, dan pantau indeks capaian daerah.">
        <meta property="og:image" content="{{ asset('images/hero/hero_welcome_arch.jpg') }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="Gerbang Ikonik Pringsewu - Portal Resmi BAPPERIDA">
        <meta property="og:site_name" content="BAPPERIDA Kabupaten Pringsewu">
        <meta property="og:locale" content="id_ID">

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="{{ url()->current() }}">
        <meta name="twitter:title" content="BAPPERIDA Kabupaten Pringsewu - Perencanaan, Riset & Inovasi Daerah">
        <meta name="twitter:description" content="Portal resmi Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah Kabupaten Pringsewu.">
        <meta name="twitter:image" content="{{ asset('images/hero/hero_welcome_arch.jpg') }}">

        <!-- Official Favicon Kabupaten Pringsewu -->
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo_pringsewu.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo_pringsewu.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo_pringsewu.png') }}">
        <link rel="shortcut icon" href="{{ asset('images/logo_pringsewu.png') }}">
        <meta name="theme-color" content="#134e4a">

        <!-- Structured Data (JSON-LD) for Google Search Rich Results -->
        <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'GovernmentOrganization',
                    '@id' => url('/') . '#organization',
                    'name' => 'BAPPERIDA Kabupaten Pringsewu',
                    'alternateName' => [
                        'Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah Kabupaten Pringsewu',
                        'Bappeda Pringsewu'
                    ],
                    'url' => url('/'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => asset('images/logo_pringsewu.png')
                    ],
                    'image' => asset('images/hero/hero_welcome_arch.jpg'),
                    'description' => 'Perangkat daerah yang bertugas menyelenggarakan fungsi penunjang urusan pemerintahan bidang perencanaan pembangunan makro, riset dan inovasi daerah Kabupaten Pringsewu.',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => 'Jl. Dr. Sugiri Syarief, MPH, Komplek Perkantoran Pemkab, Pekon Way Rejo, Kec. Pagelaran',
                        'addressLocality' => 'Pringsewu',
                        'addressRegion' => 'Lampung',
                        'postalCode' => '35372',
                        'addressCountry' => 'ID'
                    ],
                    'geo' => [
                        '@type' => 'GeoCoordinates',
                        'latitude' => -5.3453305,
                        'longitude' => 105.0045756
                    ],
                    'telephone' => '+62-729-7081363',
                    'email' => 'bapperida@pringsewukab.go.id',
                    'sameAs' => [
                        'https://www.youtube.com/@swarabapperida',
                        'https://www.pringsewukab.go.id/',
                        'https://satudata.pringsewukab.go.id/'
                    ]
                ],
                [
                    '@type' => 'WebSite',
                    '@id' => url('/') . '#website',
                    'url' => url('/'),
                    'name' => 'Portal Resmi BAPPERIDA Kabupaten Pringsewu',
                    'publisher' => [
                        '@id' => url('/') . '#organization'
                    ],
                    'inLanguage' => 'id-ID',
                    'potentialAction' => [
                        '@type' => 'SearchAction',
                        'target' => [
                            '@type' => 'EntryPoint',
                            'urlTemplate' => url('/dokumen?search={search_term_string}')
                        ],
                        'query-input' => 'required name=search_term_string'
                    ]
                ]
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        <x-inertia::head />
    </head>
    <body class="font-sans antialiased text-slate-800 bg-slate-50">
        <x-inertia::app />
    </body>
</html>
