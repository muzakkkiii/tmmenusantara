@extends('layouts.app')
@section('content')
<main id="pub">
<div class="page-hero"><div class="wrap" style="text-align:center">
  <span class="eyebrow on-dark">Kode 403</span>
  <h1 style="margin:.4rem 0">Akses ditolak</h1>
  <p class="lead" style="margin-left:auto;margin-right:auto">Anda tidak memiliki izin untuk membuka halaman ini.</p>
  <div class="hero-cta" style="justify-content:center">
    <a class="btn btn-gold" href="<?php echo e(url(chr(47))); ?>">Kembali ke Beranda</a>
  </div>
</div></div>
</main>
@endsection
