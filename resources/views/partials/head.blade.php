@php
    $siteName = 'Yayasan TM Menusantara';
    $rn = optional(request()->route())->getName();
    $map = [
        'beranda'      => ['', 'Yayasan Terate Mekar Memayu Nusantara: pendidikan, pengabdian, ekonomi, seni budaya, dan sarana prasarana.'],
        'tentang'      => ['Tentang Kami', 'Profil, visi-misi, legalitas, dan struktur pengurus Yayasan TM Menusantara.'],
        'program'      => ['Program', 'Program pendidikan, bisnis & SDM, Cakra Buana, sosial budaya, dan sarana prasarana Yayasan TM Menusantara.'],
        'berita'       => ['Berita & Kegiatan', 'Kabar dan dokumentasi kegiatan terbaru Yayasan TM Menusantara.'],
        'kemitraan'    => ['Kemitraan', 'Peluang kolaborasi, donasi, dan kemitraan bersama Yayasan TM Menusantara.'],
        'transparansi' => ['Transparansi Keuangan', 'Laporan pemasukan dan penyaluran dana Yayasan TM Menusantara secara terbuka.'],
        'kontak'       => ['Kontak', 'Hubungi Yayasan TM Menusantara untuk informasi, kemitraan, atau donasi.'],
    ];
    [$pageTitle, $pageDesc] = $map[$rn] ?? ['', ''];
    $ogImage = asset('img/og-default.jpg');
    if ($rn === 'berita.show' && isset($news)) {
        $pageTitle = $news->title;
        $pageDesc = \Illuminate\Support\Str::limit(strip_tags($news->body), 155);
        if (!empty($news->img)) {
            $ogImage = \Illuminate\Support\Str::startsWith($news->img, 'http') ? $news->img : url($news->img);
        }
    }
    $fullTitle = $pageTitle ? ($pageTitle . ' — ' . $siteName) : ($siteName . ' — Memayu Hayuning Nusantara');
    $desc = $pageDesc ?: 'Yayasan Terate Mekar Memayu Nusantara (TM Menusantara): pendidikan, pengabdian, ekonomi, seni budaya, dan sarana prasarana.';
    $canonical = url()->current();
@endphp
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo e($fullTitle); ?></title>
<meta name="description" content="<?php echo e($desc); ?>" />
<link rel="canonical" href="<?php echo e($canonical); ?>" />
<meta name="theme-color" content="#0b2e22" />
<meta name="robots" content="index, follow" />

<!-- Open Graph -->
<meta property="og:type" content="website" />
<meta property="og:site_name" content="<?php echo e($siteName); ?>" />
<meta property="og:title" content="<?php echo e($fullTitle); ?>" />
<meta property="og:description" content="<?php echo e($desc); ?>" />
<meta property="og:url" content="<?php echo e($canonical); ?>" />
<meta property="og:image" content="<?php echo e($ogImage); ?>" />
<meta property="og:locale" content="id_ID" />

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="<?php echo e($fullTitle); ?>" />
<meta name="twitter:description" content="<?php echo e($desc); ?>" />
<meta name="twitter:image" content="<?php echo e($ogImage); ?>" />

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;1,9..144,400;1,9..144,500&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
@if(file_exists(public_path('build/manifest.json')))
@vite('resources/css/app.css')
@else
<link rel="stylesheet" href="/css/app.css">
@endif

@if($rn === 'beranda')
<link rel="preload" as="image" fetchpriority="high" href="<?php echo e(img_setting('home_hero_img', 'https://images.pexels.com/photos/32218913/pexels-photo-32218913.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>">
@endif

<!-- JSON-LD -->
<script type="application/ld+json">
<?php echo json_encode(array_filter([
    '@context'      => 'https://schema.org',
    '@type'         => 'NGO',
    'name'          => 'Yayasan Terate Mekar Memayu Nusantara',
    'alternateName' => 'TM Menusantara',
    'url'           => url('/'),
    'logo'          => asset('img/logo.png'),
    'image'         => $ogImage,
    'description'   => $desc,
    'email'         => setting('email', 'info@menusantara.org'),
    'telephone'     => setting('wa', '6282332651802'),
    'foundingDate'  => '2025-03-10',
    'address'       => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => setting('alamat', 'Gedung MCC Lt. 1'),
        'addressLocality' => 'Kota Malang',
        'addressRegion'   => 'Jawa Timur',
        'addressCountry'  => 'ID',
    ],
    'contactPoint'  => [
        '@type'       => 'ContactPoint',
        'contactType' => 'customer support',
        'telephone'   => setting('wa', '6282332651802'),
        'email'       => setting('email', 'info@menusantara.org'),
    ],
    'sameAs'        => array_values(array_filter([
        setting('fb'), setting('ig'), setting('yt'), setting('tiktok'),
    ])),
], fn($v) => $v !== null && $v !== '' && $v !== []), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
</script>

