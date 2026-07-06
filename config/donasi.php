<?php

return [
    // Rekening tujuan donasi (tampil di halaman /donasi)
    'banks' => [
        [
            'bank' => 'BCA',
            'no' => '1234567890',
            'atas_nama' => 'Yayasan Terate Mekar Memayu Nusantara',
        ],
        [
            'bank' => 'Bank Mandiri',
            'no' => '0987654321',
            'atas_nama' => 'Yayasan Terate Mekar Memayu Nusantara',
        ],
    ],

    // Gambar QRIS. Taruh file di public/img/qris.png (atau ubah path di sini).
    // Jika file belum ada, blok QRIS otomatis disembunyikan.
    'qris' => '/img/qris.png',

    // Peruntukan donasi (dropdown)
    'progs' => ['Umum', 'Pendidikan', 'Bisnis & SDM', 'Cakra Buana', 'Sosial & Budaya', 'Sarana Prasarana'],

    // Status donasi
    'statuses' => ['Menunggu Pembayaran', 'Menunggu Verifikasi', 'Terverifikasi', 'Batal'],

    /*
     | ------------------------------------------------------------------
     | Pembayaran Online (Midtrans Snap)
     | ------------------------------------------------------------------
     | Aktifkan dengan mengisi kredensial di .env lalu set DONASI_GATEWAY=true.
     | Selama enabled=false, alur donasi tetap manual (transfer/QRIS/tunai)
     | dan tombol "Bayar Online" tidak ditampilkan.
     |
     | .env contoh:
     |   DONASI_GATEWAY=true
     |   MIDTRANS_SERVER_KEY=SB-Mid-server-xxxx
     |   MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxx
     |   MIDTRANS_PRODUCTION=false
     */
    'gateway' => [
        'enabled'    => env('DONASI_GATEWAY', false),
        'provider'   => env('DONASI_PROVIDER', 'midtrans'),
        'server_key' => env('MIDTRANS_SERVER_KEY', ''),
        'client_key' => env('MIDTRANS_CLIENT_KEY', ''),
        'production' => env('MIDTRANS_PRODUCTION', false),
    ],
];
