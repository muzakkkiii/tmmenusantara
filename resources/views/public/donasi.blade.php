@extends('layouts.app')
@section('content')
<main id="pub">

  <!-- ============ HERO ============ -->
  <div class="page-hero" style="background-image:url('<?php echo e(img_setting('donasi_hero_img', 'https://images.pexels.com/photos/6347730/pexels-photo-6347730.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap"><span class="eyebrow"><?php echo txt('donasi_hero_eyebrow', 'Donasi'); ?></span><h1><?php echo txt('donasi_hero_title', 'Salurkan kebaikan Anda.'); ?></h1><p class="lead"><?php echo txt('donasi_hero_lead', 'Dukung program pendidikan, sosial, budaya, dan pemberdayaan yayasan. Setiap kontribusi dicatat dan dilaporkan secara transparan.'); ?></p></div></div>

  <div class="page-pad page-tint"><div class="wrap">

    <!-- ============ INTRO ============ -->
    <div class="sec-head-n reveal" style="max-width:none;text-align:left">
      <span class="eyebrow">Berdonasi Mudah &amp; Transparan</span>
      <h2>Dua langkah: transfer, lalu konfirmasi.</h2>
      <p class="lead">Pilih metode yang nyaman bagi Anda, lalu isi formulir konfirmasi agar donasi tercatat dalam laporan transparansi kami.</p>
    </div>

    <!-- ============ DONASI GRID ============ -->
    <div class="contact-grid">
      <div class="reveal">
        <span class="eyebrow">Cara Donasi</span>
        <h2 style="font-size:clamp(1.6rem,3.4vw,2.2rem);margin:.5rem 0 1.4rem">Transfer bank atau QRIS.</h2>
        <?php foreach (config('donasi.banks', []) as $b): ?>
        <div class="info-item"><div class="k"><?php echo e($b['bank']); ?></div><div class="v"><strong><?php echo e($b['no']); ?></strong><br><small>a.n. <?php echo e($b['atas_nama']); ?></small></div></div>
        <?php endforeach; ?>
        <?php $qris = setting('qris_img', config('donasi.qris')); $qrisShow = $qris && (\Illuminate\Support\Str::startsWith($qris, ['http', '/storage']) || file_exists(public_path(ltrim($qris, '/'))) || file_exists(storage_path('app/public/'.ltrim($qris, '/')))); if ($qrisShow): ?>
        <div class="info-item"><div class="k">QRIS</div><div class="v"><img src="<?php echo e(img_url($qris)); ?>" alt="QRIS Donasi" style="max-width:300px;width:100%;border-radius:12px;border:1px solid #e5e5e5" /><div style="margin-top:12px"><a href="<?php echo e(img_url($qris)); ?>" download="QRIS-Donasi-TM-Menusantara" class="btn btn-line btn-sm" style="display:inline-flex;align-items:center;gap:.5rem"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="15" height="15"><path d="M12 3v12M7 10l5 5 5-5M5 21h14"/></svg>Unduh QRIS</a></div></div></div>
        <?php endif; ?>
        <p class="form-note" style="margin-top:1rem">Setelah transfer, mohon isi formulir konfirmasi di samping agar donasi Anda dapat kami verifikasi dan catat dalam laporan transparansi.</p>
      </div>
      <div class="reveal">
@if(session('donasi_ok'))
<div class="form-note" style="background:#e9f7ef;border:1px solid #b7e0c4;color:#1e7e45;padding:.85rem 1rem;border-radius:10px;margin-bottom:1rem"><?php echo e(session('donasi_ok')); ?></div>
@if(session('wa_url'))
<a class="btn btn-primary btn-block" href="<?php echo e(session('wa_url')); ?>" target="_blank" rel="noopener" style="margin-bottom:1.2rem">Konfirmasi via WhatsApp &rarr;</a>
@endif
@endif
@if($errors->any())
<div class="form-note" style="background:#fdecea;border:1px solid #f5c2bd;color:#c0392b;padding:.85rem 1rem;border-radius:10px;margin-bottom:1rem">Periksa kembali isian Anda.</div>
@endif
<form method="POST" action="<?php echo e(route('donasi.store')); ?>" enctype="multipart/form-data">
@csrf
<div style="position:absolute!important;left:-9999px;top:-9999px" aria-hidden="true"><label>Website</label><input type="text" name="website" tabindex="-1" autocomplete="off" /></div>
<div class="field"><label for="d_nama">Nama Donatur</label><input id="d_nama" name="nama" required placeholder="Nama Anda" value="<?php echo e(old('nama')); ?>" /></div>
<div class="field"><label for="d_wa">Nomor WhatsApp</label><input id="d_wa" name="wa" placeholder="08xxxxxxxxxx" inputmode="tel" pattern="[0-9+\-\s().]{8,20}" title="Masukkan nomor WhatsApp yang valid (8-20 digit)" maxlength="20" value="<?php echo e(old('wa')); ?>" /></div>
<div class="field"><label for="d_email">Email <span style="font-weight:400;color:var(--muted)">(opsional)</span></label><input id="d_email" name="email" type="email" placeholder="email@contoh.com" value="<?php echo e(old('email')); ?>" /></div>
<div class="field"><label for="d_nominal">Nominal Donasi (Rp)</label><input id="d_nominal" name="nominal" type="number" min="1000" step="1000" required placeholder="mis. 100000" value="<?php echo e(old('nominal')); ?>" /></div>
<div class="field"><label for="d_prog">Peruntukan</label><select id="d_prog" name="program">@foreach(config('donasi.progs') as $p)<option value="<?php echo e($p); ?>" <?php echo old('program') === $p ? 'selected' : ''; ?>><?php echo e($p); ?></option>@endforeach</select></div>
<div class="field"><label for="d_metode">Metode</label><select id="d_metode" name="metode"><option value="transfer">Transfer Bank</option><option value="qris">QRIS</option><option value="tunai">Tunai</option></select></div>
<div class="field"><label for="d_bukti">Bukti Transfer <span style="font-weight:400;color:var(--muted)">(opsional, jpg/png maks 2 MB)</span></label><input id="d_bukti" name="bukti" type="file" accept="image/*" /></div>
<div class="field"><label for="d_catatan">Catatan <span style="font-weight:400;color:var(--muted)">(opsional)</span></label><textarea id="d_catatan" name="catatan" rows="3" placeholder="Doa atau pesan Anda..."><?php echo e(old('catatan')); ?></textarea></div>
<button type="submit" class="btn btn-primary btn-block" data-loading-text="Mengirim...">Kirim Konfirmasi Donasi</button>
<p class="form-note">Donasi Anda akan diverifikasi admin lalu tercatat pada laporan transparansi yayasan.</p>
</form>
      </div>
    </div>

  </div></div>

  <!-- ============ DIVIDER ============ -->
  <div class="sec-div sec-div-alt"><span class="orn-diamond"></span><span class="orn-line"></span><span class="orn-dots"><span></span><span></span><span></span></span><span class="orn-line"></span><span class="orn-diamond"></span></div>

  <!-- ============ CTA BAND ============ -->
  <div class="page-pad" style="padding-top:0"><div class="wrap">
    <div class="cta-band reveal">
      <div><h2 style="color:#fff">Ke mana donasi Anda mengalir?</h2><p style="color:rgba(255,255,255,.85)">Kami mencatat dan melaporkan setiap kontribusi secara terbuka. Tinjau laporan dan transparansi keuangan yayasan.</p></div>
      <div class="actions"><a wire:navigate class="btn btn-gold" href="<?php echo e(route('transparansi')); ?>">Lihat Transparansi</a><a wire:navigate class="btn btn-oval-line" href="<?php echo e(route('laporan')); ?>">Laporan Kegiatan <span class="btn-ic-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="12" height="12"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span></a></div>
    </div>
  </div></div>

</main>
@endsection
