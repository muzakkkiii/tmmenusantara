@extends('layouts.app')
@section('content')
<main id="pub">
<div class="page-hero no-print" style="background-image:url('<?php echo e(img_setting('sertifikat_hero_img', 'https://images.pexels.com/photos/36781105/pexels-photo-36781105.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap"><span class="eyebrow"><?php echo txt('sertifikat_hero_eyebrow', 'Sertifikat Pelatihan'); ?></span><h1><?php echo txt('sertifikat_hero_title', 'Sertifikat Pelatihan'); ?></h1><p class="lead"><?php echo txt('sertifikat_hero_lead', 'Masukkan nomor sertifikat pelatihan untuk menampilkan dan mengunduh sertifikat Anda.'); ?></p></div></div>
<div class="page-pad page-tint"><div class="wrap">
  <div class="cert-search no-print">
    <form method="GET" action="<?php echo e(url('/sertifikat')); ?>" onsubmit="if(this.kode.value){window.location.href='<?php echo e(url('/sertifikat')); ?>/'+encodeURIComponent(this.kode.value.trim());return false}return false">
      <input type="text" name="kode" value="<?php echo e($kode); ?>" placeholder="mis. CERT-ABCD1234" required>
      <button type="submit" class="btn btn-gold" style="border-radius:50px;padding:.6rem 1.2rem">Tampilkan Sertifikat</button>
    </form>
  </div>

  @if($notFound)
    <div class="cert-alert no-print">Sertifikat dengan kode <b><?php echo e($kode); ?></b> tidak ditemukan. Pastikan kode yang dimasukkan benar.</div>
  @endif

  @if($cert)
    <div id="certprint" class="cert-card reveal">
      <div class="cert-badge">&#10004; SERTIFIKAT RESMI</div>
      <div class="cert-inner">
        <p class="cert-org">Yayasan Terate Mekar Memayu Nusantara</p>
        <p class="cert-title">SERTIFIKAT</p>
        <p class="cert-sub">Diberikan kepada</p>
        <p class="cert-name"><?php echo e($cert->nama); ?></p>
        <p class="cert-sub">atas partisipasinya dalam</p>
        <p class="cert-course"><?php echo e($cert->pelatihan); ?></p>
        <?php if($cert->tanggal): ?><p class="cert-date"><?php echo e($cert->tanggal->format('d F Y')); ?></p><?php endif; ?>
        <div class="cert-sign">
          <div><span class="line"></span><b><?php echo e($cert->penandatangan ?: '-'); ?></b><small><?php echo e($cert->jabatan_ttd ?: ''); ?></small></div>
        </div>
        <p class="cert-code">Nomor Sertifikat: <b><?php echo e($cert->kode); ?></b></p>
      </div>
    </div>
    <div class="cert-actions no-print"><button onclick="window.print()" class="btn btn-gold">&#128424; Cetak / Simpan PDF</button></div>
  @endif
</div></div>
</main>
@endsection
