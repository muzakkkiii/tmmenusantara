@extends('layouts.app')
@section('content')
<main id="pub">

  <!-- ============ HERO ============ -->
  <div class="page-hero" style="background-image:url('<?php echo e(img_setting('laporan_hero_img', 'https://images.pexels.com/photos/33072534/pexels-photo-33072534.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap"><span class="eyebrow"><?php echo txt('laporan_hero_eyebrow', 'Laporan Kegiatan'); ?></span><h1><?php echo txt('laporan_hero_title', 'Sistem Laporan Kegiatan'); ?></h1><p class="lead"><?php echo txt('laporan_hero_lead', 'Rangkuman pelaksanaan program dan kegiatan yayasan sebagai bentuk akuntabilitas.'); ?></p></div></div>

  <div class="page-pad"><div class="wrap">

    <!-- ============ INTRO ============ -->
    <div class="sec-head-n reveal">
      <span class="eyebrow">Rekap Pelaksanaan</span>
      <h2>Bukti nyata dari setiap kegiatan.</h2>
      <p class="lead">Rangkuman program dan kegiatan yang telah terlaksana &mdash; lengkap dengan waktu, lokasi, dan jumlah peserta.</p>
    </div>

@if($reports->isEmpty())
  <p class="empty-state">Belum ada laporan kegiatan yang dipublikasikan.</p>
@else
    <div class="lap-list">
    @foreach($reports as $r)
      <article class="lap-item reveal">
        <img src="<?php echo e($r->img ? img_url($r->img) : 'https://images.pexels.com/photos/6646923/pexels-photo-6646923.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1200&h=900'); ?>" alt="<?php echo e($r->judul); ?>" loading="lazy" class="lap-img">
        <div class="lap-body">
          <h3><?php echo e($r->judul); ?></h3>
          <p class="lap-meta"><?php if($r->tanggal): ?><svg class="lap-ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14" style="vertical-align:-2px;margin-right:3px"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg><?php echo e($r->tanggal->format('d M Y')); ?><?php endif; ?><?php if($r->lokasi): ?> &nbsp;&bull;&nbsp; <svg class="lap-ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14" style="vertical-align:-2px;margin-right:3px"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg><?php echo e($r->lokasi); ?><?php endif; ?><?php if($r->peserta): ?> &nbsp;&bull;&nbsp; <svg class="lap-ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14" style="vertical-align:-2px;margin-right:3px"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg><?php echo e($r->peserta); ?> peserta<?php endif; ?></p>
          <?php if($r->ringkasan): ?>
            <details class="lap-det"><summary>Baca ringkasan kegiatan</summary><p class="lap-ringkasan"><?php echo e($r->ringkasan); ?></p></details>
          <?php endif; ?>
        </div>
      </article>
    @endforeach
    </div>
@endif

  </div></div>
</main>
@endsection
