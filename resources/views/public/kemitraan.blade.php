@extends('layouts.app')
@section('content')
<main id="pub">

  <!-- ============ HERO ============ -->
  <div class="page-hero" style="background-image:url('<?php echo e(img_setting('kemitraan_hero_img', 'https://images.pexels.com/photos/3184465/pexels-photo-3184465.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap"><span class="eyebrow"><?php echo txt('kemitraan_hero_eyebrow', 'Kemitraan &amp; Dukungan'); ?></span><h1><?php echo txt('kemitraan_hero_title', 'Bergerak bersama, tumbuh berkelanjutan.'); ?></h1><p class="lead"><?php echo txt('kemitraan_hero_lead', 'Ada banyak cara untuk berkolaborasi dan mendukung program yayasan &mdash; sebagai mitra strategis, relawan, maupun donatur.'); ?></p></div></div>

  <div class="page-pad page-tint"><div class="wrap">

    <!-- ============ INTRO ============ -->
    <div class="sec-head-n reveal">
      <span class="eyebrow">Tiga Jalur Kolaborasi</span>
      <h2>Pilih cara Anda untuk ikut memberi manfaat.</h2>
      <p class="lead">Setiap kontribusi &mdash; keahlian, waktu, maupun dukungan dana &mdash; dikelola dengan tata kelola yang jelas dan dapat dipertanggungjawabkan.</p>
    </div>

    <!-- ============ SUPPORT GRID ============ -->
    <div class="support-grid">
      <div class="support reveal"><div class="idx">01</div><h3>Mitra Strategis</h3><p>Kerja sama program dengan lembaga, perusahaan, kampus, dan komunitas.</p><ul><li>Kolaborasi program pendidikan &amp; pelatihan</li><li>Pengembangan bisnis &amp; SDM</li><li>Kegiatan sosial dan budaya bersama</li></ul><a x-data @click.prevent="$dispatch('open-mitra')" class="btn btn-sm btn-sharp support-cta" href="<?php echo e(route('mitra')); ?>">Ajukan Kemitraan</a></div>
      <div class="support reveal"><div class="idx">02</div><h3>Relawan</h3><p>Kontribusi tenaga, keahlian, dan waktu untuk program di lapangan.</p><ul><li>Pendampingan pendidikan &amp; kegiatan</li><li>Kepanitiaan acara &amp; dokumentasi</li><li>Pelestarian seni budaya</li></ul><a x-data @click.prevent="$dispatch('open-relawan')" class="btn btn-sm btn-sharp support-cta" href="<?php echo e(route('relawan')); ?>">Daftar Relawan</a></div>
      <div class="support reveal"><div class="idx">03</div><h3>Donasi &amp; Dukungan</h3><p>Dukungan dana dan sarana untuk keberlanjutan program yayasan.</p><ul><li>Donasi program &amp; kegiatan sosial</li><li>Hibah sarana &amp; prasarana</li><li>Dukungan operasional yayasan</li></ul><a wire:navigate class="btn btn-sm btn-sharp support-cta" href="<?php echo e(route('donasi')); ?>">Donasi Sekarang</a></div>
    </div>

  </div></div>

  <!-- ============ DIVIDER ============ -->
  <div class="sec-div sec-div-alt"><span class="orn-diamond"></span><span class="orn-line"></span><span class="orn-dots"><span></span><span></span><span></span></span><span class="orn-line"></span><span class="orn-diamond"></span></div>

  <!-- ============ CTA BAND ============ -->
  <div class="page-pad" style="padding-top:0"><div class="wrap">
    <div class="cta-band reveal">
      <div><h2 style="color:#fff">Siap berkolaborasi bersama kami?</h2><p style="color:rgba(255,255,255,.85)">Unduh proposal untuk detail program, atau tinjau transparansi keuangan kami.</p></div>
      <div class="actions"><a class="btn btn-gold" href="<?php echo e(img_url(setting('proposal_url') ?: '/files/proposal.pdf')); ?>" target="_blank" rel="noopener">Unduh Proposal</a><a wire:navigate class="btn btn-oval-line" href="<?php echo e(route('transparansi')); ?>">Lihat Transparansi <span class="btn-ic-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="12" height="12"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span></a></div>
    </div>
  </div></div>

</main>
@endsection
