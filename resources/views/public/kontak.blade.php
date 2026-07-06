@extends('layouts.app')
@section('content')
<main id="pub">
<div class="page-hero" style="background-image:url('<?php echo e(img_setting('kontak_hero_img', 'https://images.pexels.com/photos/7652178/pexels-photo-7652178.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap"><span class="eyebrow"><?php echo txt('kontak_hero_eyebrow', 'Kontak'); ?></span><h1><?php echo txt('kontak_hero_title', 'Terhubung dengan kami.'); ?></h1><p class="lead"><?php echo txt('kontak_hero_lead', 'Sampaikan pertanyaan, pendaftaran, atau minat kemitraan Anda — kami siap menindaklanjuti.'); ?></p></div></div><div class="page-pad page-tint"><div class="wrap">

  <div class="sec-head-n reveal">
    <span class="eyebrow">Mari Terhubung</span>
    <h2>Kami senang mendengar dari Anda.</h2>
    <p class="lead">Sampaikan pertanyaan, pendaftaran, atau minat kemitraan &mdash; tim kami akan menindaklanjuti secepatnya.</p>
  </div>

  <div class="contact-grid">
    <div class="reveal">
      <span class="eyebrow">Informasi</span>
      <h2 style="font-size:clamp(1.6rem,3.4vw,2.2rem);margin:.5rem 0 1.4rem">Detail kontak yayasan.</h2>
      <div class="info-item"><div class="k">WhatsApp Resmi</div><div class="v"><a id="waInfo" href="{{ wa_link(setting('wa','6282332651802')) }}" target="_blank" rel="noopener">0858-1578-2736</a></div></div>
      <div class="info-item"><div class="k">Email</div><div class="v"><a id="emailInfo" href="mailto:{{ setting('email','info@menusantara.org') }}">{{ setting('email','info@menusantara.org') }}</a></div></div>
      <div class="info-item"><div class="k">Alamat</div><div class="v" id="alamatInfo">{{ setting('alamat','Gedung MCC Lt. 1, Kota Malang, Jawa Timur') }}</div></div>
      <div class="info-item"><div class="k">Website</div><div class="v">tmmenusantara.org &middot; menusantara.org</div></div>
    </div>
    <div class="reveal">
      
@if(session('ok'))
<div class="form-note" style="background:#e9f7ef;border:1px solid #b7e0c4;color:#1e7e45;padding:.85rem 1rem;border-radius:10px;margin-bottom:1rem">{{ session('ok') }}</div>
@if(session('wa_url'))
<a class="btn btn-primary btn-block" href="{{ session('wa_url') }}" target="_blank" rel="noopener" style="margin-bottom:1.2rem">Lanjutkan ke WhatsApp &rarr;</a>
@endif
@endif
@if($errors->any())
<div class="form-note" style="background:#fdecea;border:1px solid #f5c2bd;color:#c0392b;padding:.85rem 1rem;border-radius:10px;margin-bottom:1rem">Periksa kembali isian Anda.</div>
@endif
<form method="POST" action="{{ route('kontak.store') }}">
@csrf
<div style="position:absolute!important;left:-9999px;top:-9999px" aria-hidden="true"><label>Website</label><input type="text" name="website" tabindex="-1" autocomplete="off" /></div>
<div class="field"><label for="f_nama">Nama Lengkap</label><input id="f_nama" name="nama" required placeholder="Nama Anda" value="<?php echo e(old('nama', $prefill ?? '')); ?>" /></div>
<div class="field"><label for="f_wa">Nomor WhatsApp</label><input id="f_wa" name="wa" placeholder="08xxxxxxxxxx" inputmode="tel" value="{{ old('wa') }}" /></div>
<div class="field"><label for="f_email">Email <span style="font-weight:400;color:var(--muted)">(opsional)</span></label><input id="f_email" name="email" type="email" placeholder="email@contoh.com" value="{{ old('email') }}" /></div>
<div class="field"><label for="f_kat">Kebutuhan</label><select id="f_kat" name="kategori">@foreach(config('yayasan.cats') as $c)<option value="{{ $c }}" {{ old('kategori',$prefill)===$c?'selected':'' }}>{{ $c }}</option>@endforeach</select></div>
<div class="field"><label for="f_pesan">Pesan</label><textarea id="f_pesan" name="pesan" rows="4" placeholder="Tuliskan pesan Anda...">{{ old('pesan') }}</textarea></div>
<button type="submit" class="btn btn-primary btn-block" data-loading-text="Mengirim...">Kirim &amp; Lanjut ke WhatsApp</button>
<p class="form-note">Data Anda tersimpan untuk admin dan pesan otomatis diteruskan ke WhatsApp resmi untuk ditindaklanjuti.</p>
</form>

      
    </div>
  </div>
  <div class="sec-div sec-div-alt"><span class="orn-diamond"></span><span class="orn-line"></span><span class="orn-dots"><span></span><span></span><span></span></span><span class="orn-line"></span><span class="orn-diamond"></span></div>

  <div class="sec-head-n reveal" style="margin-bottom:1.3rem"><span class="eyebrow">Lokasi</span><h2>Kunjungi kantor kami.</h2><p class="lead">Malang Creative Center, Kota Malang &mdash; pusat kegiatan dan koordinasi yayasan.</p></div>

  <div class="map-wrap reveal">
    <iframe src="<?php echo e(setting('maps_embed', 'https://www.google.com/maps?q=Malang+Creative+Center+Kota+Malang&output=embed')); ?>" width="100%" height="360" style="border:0;border-radius:16px" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Lokasi Yayasan"></iframe>
  </div>
</div></div>
</main>
@endsection
