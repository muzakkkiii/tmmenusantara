@extends('layouts.app')
@section('content')
<main id="pub">

  <!-- ============ HERO ============ -->
  <div class="page-hero" style="background-image:url('<?php echo e(img_setting('galeri_hero_img', 'https://images.pexels.com/photos/19117454/pexels-photo-19117454.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap"><span class="eyebrow"><?php echo txt('galeri_hero_eyebrow', 'Galeri Foto'); ?></span><h1><?php echo txt('galeri_hero_title', 'Dokumentasi Kegiatan'); ?></h1><p class="lead"><?php echo txt('galeri_hero_lead', 'Momen dari berbagai program dan kegiatan Yayasan Terate Mekar Memayu Nusantara.'); ?></p></div></div>

  <div class="page-pad" x-data="{ q:'', lb:null }">
  <div class="wrap">

    <!-- ============ INTRO ============ -->
    <div class="sec-head-n reveal">
      <span class="eyebrow">Bingkai Kebersamaan</span>
      <h2>Setiap foto menyimpan cerita kebaikan.</h2>
      <p class="lead">Telusuri kumpulan dokumentasi kegiatan dari waktu ke waktu &mdash; klik gambar untuk memperbesar.</p>
    </div>

@if($items->isEmpty())
  <p class="gal-empty">Belum ada foto yang dipublikasikan.</p>
@else
    <div class="searchbar" style="max-width:520px;margin-bottom:26px">
      <input type="search" x-model="q" placeholder="Cari foto berdasarkan judul atau keterangan...">
    </div>
    <div class="gal-grid">
    @foreach($items as $g)
      <figure class="gal-item reveal" data-t="<?php echo e(strtolower($g->title.' '.$g->caption)); ?>" data-src="<?php echo e(img_url($g->img)); ?>" data-cap="<?php echo e($g->title); ?>" x-show="q==='' || $el.dataset.t.includes(q.trim().toLowerCase())" style="cursor:zoom-in" @click="lb={ src:$el.dataset.src, t:$el.dataset.cap }">
        <img src="<?php echo e(img_url($g->img)); ?>" alt="<?php echo e($g->title); ?>" loading="lazy">
        <figcaption><?php echo e($g->title); ?>@if($g->caption)<span><?php echo e($g->caption); ?></span>@endif</figcaption>
      </figure>
    @endforeach
    </div>
@endif

  </div>
  <div class="lightbox" x-show="lb" x-cloak @click="lb=null" @keydown.escape.window="lb=null">
    <img :src="lb && lb.src" :alt="lb && lb.t">
    <div class="lb-cap" x-text="lb && lb.t"></div>
  </div>
  </div>
</main>
@endsection
