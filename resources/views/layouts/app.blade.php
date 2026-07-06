<!DOCTYPE html>
<html lang="id">
<head>
@include('partials.head')
@if(class_exists(\Livewire\Livewire::class))
@livewireStyles
@endif
</head>
<body>
<a class="skip-link" href="#main">Lewati ke konten utama</a>
@if(session('ok'))
<div class="flash-toast no-print" x-data="{ show:true }" x-show="show" x-init="setTimeout(()=>show=false,6000)" @click="show=false" x-cloak><?php echo e(session('ok')); ?></div>
@endif
<header class="site-head" id="pubHead">
  <div class="wrap">
    <a wire:navigate class="brand" href="<?php echo e(route('beranda')); ?>">
      <?php $__logo = setting('logo_url'); ?>
      <?php if($__logo): ?>
        <img src="<?php echo e(img_url($__logo)); ?>" class="brand-logo" alt="Yayasan TM Menusantara" />
      <?php else: ?>
        <span class="mark">TM</span><span class="brand-txt">Menusantara<small>Yayasan Terate Mekar</small></span>
      <?php endif; ?>
    </a>
    <nav class="nav" id="nav">
      <div class="nav-head"><span class="nav-head-t">Menu</span><button type="button" class="nav-close" id="navClose" aria-label="Tutup menu"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20"><path d="M6 6l12 12M18 6L6 18"/></svg></button></div>
      <a wire:navigate href="<?php echo e(route('beranda')); ?>" class="nav-link <?php echo request()->routeIs('beranda')?'active':''; ?>">Beranda</a>
      <a wire:navigate href="<?php echo e(route('tentang')); ?>" class="nav-link <?php echo request()->routeIs('tentang')?'active':''; ?>">Tentang</a>
      <a wire:navigate href="<?php echo e(route('program')); ?>" class="nav-link <?php echo request()->routeIs('program')?'active':''; ?>">Program</a>
      <div class="nav-item">
        <a wire:navigate href="<?php echo e(route('berita')); ?>" class="nav-link <?php echo (request()->routeIs('berita')||request()->routeIs('berita.show')||request()->routeIs('galeri')||request()->routeIs('agenda'))?'active':''; ?>">Berita &amp; Kegiatan <span class="caret">&#9662;</span></a>
        <div class="dropdown">
          <a wire:navigate href="<?php echo e(route('berita')); ?>">Berita<small>Kabar &amp; publikasi terbaru</small></a>
          <a wire:navigate href="<?php echo e(route('agenda')); ?>">Agenda<small>Jadwal kegiatan mendatang</small></a>
          <a wire:navigate href="<?php echo e(route('galeri')); ?>">Galeri<small>Dokumentasi foto kegiatan</small></a>
        </div>
      </div>
      <div class="nav-item">
        <a wire:navigate href="<?php echo e(route('kemitraan')); ?>" class="nav-link <?php echo (request()->routeIs('kemitraan')||request()->routeIs('donasi')||request()->routeIs('mitra')||request()->routeIs('relawan'))?'active':''; ?>">Kemitraan &amp; Dukungan <span class="caret">&#9662;</span></a>
        <div class="dropdown">
          <a wire:navigate href="<?php echo e(route('kemitraan')); ?>">Kemitraan<small>Kolaborasi &amp; sponsorship</small></a>
          <a wire:navigate href="<?php echo e(route('donasi')); ?>">Donasi<small>Dukung program kami</small></a>
          <a x-data @click.prevent="$dispatch('open-mitra')" href="<?php echo e(route('mitra')); ?>">Jadi Mitra<small>Form kerja sama</small></a>
          <a x-data @click.prevent="$dispatch('open-relawan')" href="<?php echo e(route('relawan')); ?>">Relawan<small>Gabung jadi relawan</small></a>
        </div>
      </div>
      <div class="nav-item">
        <a wire:navigate href="<?php echo e(route('transparansi')); ?>" class="nav-link <?php echo (request()->routeIs('transparansi')||request()->routeIs('laporan')||request()->routeIs('sertifikat'))?'active':''; ?>">Transparansi <span class="caret">&#9662;</span></a>
        <div class="dropdown">
          <a wire:navigate href="<?php echo e(route('transparansi')); ?>">Transparansi Keuangan<small>Donasi, penyaluran &amp; saldo</small></a>
          <a wire:navigate href="<?php echo e(route('laporan')); ?>">Laporan Kegiatan<small>Rekap pelaksanaan kegiatan</small></a>
          <a wire:navigate href="<?php echo e(route('sertifikat')); ?>">Sertifikat Pelatihan<small>Lihat &amp; unduh sertifikat pelatihan</small></a>
        </div>
      </div>
      <a wire:navigate href="<?php echo e(route('kontak')); ?>" class="nav-link <?php echo request()->routeIs('kontak')?'active':''; ?>">Kontak</a>
    </nav>
    <div class="nav-cta">
      <button type="button" class="btn-ic-cta" x-data @click="$dispatch('open-kontak')" aria-label="Kontak Cepat" title="Kontak Cepat"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></button>
      <a wire:navigate class="nav-donate" href="<?php echo e(route('donasi')); ?>"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.7-7.6 1.1-1.1a5.5 5.5 0 0 0 0-7.7z"/></svg><span class="nd-label">Donasi</span></a>
      <button class="burger" id="burger" type="button" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="nav"><span></span><span></span><span></span></button>
    </div>
  </div>
</header>
<div class="nav-scrim" id="navScrim"></div>
<div id="main" tabindex="-1">
@yield('content')
<footer id="pubFooter">
  <div class="wrap">
    <div class="foot-grid">
      <div><div class="foot-brand">Yayasan TM Menusantara</div><p style="max-width:38ch;font-size:.92rem">Terate Mekar Memayu Nusantara — memberi manfaat melalui pendidikan, pengabdian, ekonomi, dan seni budaya.</p></div>
      <div><h4>Jelajah</h4><a wire:navigate href="{{ route('tentang') }}">Tentang</a><a wire:navigate href="{{ route('program') }}">Program</a><a wire:navigate href="{{ route('berita') }}">Berita</a><a wire:navigate href="{{ route('kemitraan') }}">Kemitraan</a><a wire:navigate href="<?php echo e(route('galeri')); ?>">Galeri</a><a wire:navigate href="<?php echo e(route('agenda')); ?>">Agenda</a></div>
      <div><h4>Informasi</h4><a wire:navigate href="{{ route('transparansi') }}">Transparansi</a><a wire:navigate href="{{ route('kontak') }}">Kontak</a><a href="{{ wa_link(setting('wa','6282332651802')) }}" target="_blank" rel="noopener">WhatsApp Resmi</a><a href="<?php echo e(img_url(setting('proposal_url') ?: '/files/proposal.pdf')); ?>" target="_blank" rel="noopener">Download Proposal</a><a wire:navigate href="<?php echo e(route('laporan')); ?>">Laporan Kegiatan</a><a wire:navigate href="<?php echo e(route('sertifikat')); ?>">Sertifikat Pelatihan</a></div>
    </div>
    <div class="foot-news"><h4>Newsletter</h4><p style="font-size:.88rem;opacity:.85;margin:.4rem 0 .6rem">Berlangganan buletin kami &mdash; ringkasan program, agenda kegiatan, dan laporan dampak langsung ke email Anda.</p><ul class="news-benefits"><li>Info program &amp; pelatihan</li><li>Jadwal kegiatan</li><li>Laporan &amp; transparansi</li></ul><?php if(session('news_ok')): ?><div class="foot-news-ok"><?php echo e(session('news_ok')); ?></div><?php endif; ?>@if(class_exists(\Livewire\Livewire::class))<livewire:newsletter-form />@else<form method="POST" action="<?php echo e(route('newsletter.store')); ?>" class="foot-news-form"><?php echo csrf_field(); ?><input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off"><input type="email" name="email" placeholder="Email Anda" required><button type="submit" class="btn btn-gold">Langganan</button></form>@endif<small class="news-priv">Gratis, tanpa spam. Anda bisa berhenti berlangganan kapan saja.</small></div><div class="foot-bottom"><span>&copy; 2026 Yayasan Terate Mekar Memayu Nusantara. Memayu Hayuning Nusantara.</span><a class="admin-link" style="cursor:pointer" href="/admin">Masuk Admin</a></div>
  </div>
</footer>
</div>
<a class="wa-float" id="waFloat" href="{{ wa_link(setting('wa','6282332651802')) }}" aria-label="WhatsApp" target="_blank" rel="noopener"><svg viewBox="0 0 32 32"><path d="M16 .5C7.4.5.5 7.4.5 16c0 2.8.8 5.5 2.2 7.9L.5 31.5l7.8-2.1c2.3 1.3 4.9 1.9 7.7 1.9 8.6 0 15.5-6.9 15.5-15.5S24.6.5 16 .5zm0 28.2c-2.5 0-4.9-.7-7-1.9l-.5-.3-4.6 1.2 1.2-4.5-.3-.5c-1.4-2.2-2.1-4.7-2.1-7.2C2.6 8.6 8.6 2.6 16 2.6S29.4 8.6 29.4 16 23.4 28.7 16 28.7zm7.6-9.5c-.4-.2-2.5-1.2-2.8-1.4-.4-.1-.7-.2-.9.2-.3.4-1 1.4-1.3 1.6-.2.3-.5.3-.9.1-.4-.2-1.8-.6-3.4-2.1-1.2-1.1-2.1-2.5-2.3-2.9-.2-.4 0-.6.2-.8.2-.2.4-.5.6-.7.2-.3.3-.4.4-.7.1-.3.1-.5 0-.7-.1-.2-.9-2.2-1.3-3-.3-.8-.7-.7-.9-.7h-.8c-.3 0-.7.1-1 .5-.4.4-1.4 1.3-1.4 3.3s1.4 3.8 1.6 4.1c.2.3 2.8 4.3 6.8 6 .9.4 1.7.7 2.3.9.9.3 1.8.2 2.5.2.8-.1 2.5-1 2.8-2 .4-1 .4-1.8.3-2-.1-.2-.4-.3-.8-.5z"/></svg></a>
<!-- Scroll to top button (global) -->
<button type="button" class="scroll-top" id="scrollTop" aria-label="Kembali ke atas" onclick="window.scrollTo({top:0,behavior:'smooth'})"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="20" height="20"><path d="M12 19V5M5 12l7-7 7 7"/></svg></button>
<!-- ===== Modal Kontak Cepat (overlay, Alpine) ===== -->
<x-modal name="open-kontak" eyebrow="Kontak Cepat" title="Ada yang bisa kami bantu?" sub="Kirim pesan singkat — kami tindak lanjuti lewat WhatsApp atau email." label="Kontak Cepat">
    @if(class_exists(\Livewire\Livewire::class))<livewire:public-form type="kontak" />@else<form method="POST" action="<?php echo e(route('kontak.store')); ?>">
      <?php echo csrf_field(); ?>
      <input type="text" name="website" class="km-hp" tabindex="-1" autocomplete="off">
      <div class="field"><label for="km_nama">Nama</label><input id="km_nama" name="nama" required placeholder="Nama Anda"></div>
      <div class="field"><label for="km_wa">WhatsApp</label><input id="km_wa" name="wa" required inputmode="tel" placeholder="08xxxxxxxxxx"></div>
      <div class="field"><label for="km_email">Email <span class="opt" style="font-weight:400;color:var(--muted)">(opsional)</span></label><input id="km_email" name="email" type="email" placeholder="email@contoh.com"></div>
      <div class="field"><label for="km_pesan">Pesan</label><textarea id="km_pesan" name="pesan" rows="3" required placeholder="Tuliskan pesan Anda..."></textarea></div>
      <input type="hidden" name="kategori" value="Lainnya">
      <button type="submit" class="btn btn-gold btn-block">Kirim &amp; Lanjut ke WhatsApp</button>
    </form>@endif
    <a class="km-wa" href="<?php echo e(wa_link(setting('wa','6282332651802'),'Halo Yayasan TM Menusantara, saya ingin bertanya.')); ?>" target="_blank" rel="noopener">atau chat langsung via WhatsApp &rarr;</a>
  </x-modal>
@if(class_exists(\Livewire\Livewire::class))
@livewireScripts
@else
@if(!class_exists(\Livewire\Livewire::class))<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>@endif
@endif
<script src="/js/app.js"></script>
<?php $jenisMitra=['Program','Sponsorship/CSR','Penyediaan SDM','Hukum & Perizinan','Lainnya']; $progsDaftar=config('donasi.progs',['Umum']); $peranRelawan=['Relawan','Anggota']; ?>
<!-- ===== Modal Jadi Mitra ===== -->
<x-modal name="open-mitra" eyebrow="Form Kemitraan" title="Ajukan Kerja Sama" sub="Sampaikan minat kemitraan Anda. Tim kami akan menindaklanjuti melalui kontak yang diberikan." label="Form Kemitraan">
    @if(class_exists(\Livewire\Livewire::class))<livewire:public-form type="mitra" />@else<form method="POST" action="<?php echo e(route('mitra.store')); ?>">
      <?php echo csrf_field(); ?>
      <input type="text" name="website" class="km-hp" tabindex="-1" autocomplete="off">
      <div class="field"><label>Nama PIC <span class="req" aria-hidden="true">*</span></label><input name="nama" required></div>
      <div class="field"><label>Organisasi / Perusahaan</label><input name="organisasi"></div>
      <div class="field"><label>Jenis Kemitraan</label><select name="jenis"><option value="">- Pilih -</option><?php foreach($jenisMitra as $j): ?><option value="<?php echo e($j); ?>"><?php echo e($j); ?></option><?php endforeach; ?></select></div>
      <div class="field"><label>WhatsApp</label><input name="wa" placeholder="08xxxxxxxxxx"></div>
      <div class="field"><label>Email</label><input type="email" name="email"></div>
      <div class="field"><label>Detail / Rencana Kerja Sama</label><textarea name="pesan" rows="4"></textarea></div>
      <button type="submit" class="btn btn-gold btn-block">Kirim Pengajuan</button>
    </form>@endif
  </x-modal>
<!-- ===== Modal Relawan / Anggota ===== -->
<x-modal name="open-relawan" eyebrow="Anggota & Relawan" title="Gabung Bersama Kami" sub="Jadilah bagian dari gerakan. Daftar sebagai anggota atau relawan yayasan." label="Gabung Relawan">
    @if(class_exists(\Livewire\Livewire::class))<livewire:public-form type="relawan" />@else<form method="POST" action="<?php echo e(route('relawan.store')); ?>">
      <?php echo csrf_field(); ?>
      <input type="text" name="website" class="km-hp" tabindex="-1" autocomplete="off">
      <div class="field"><label>Nama Lengkap <span class="req" aria-hidden="true">*</span></label><input name="nama" required></div>
      <div class="field"><label>Ingin bergabung sebagai</label><select name="peran"><?php foreach($peranRelawan as $p): ?><option value="<?php echo e($p); ?>"><?php echo e($p); ?></option><?php endforeach; ?></select></div>
      <div class="field"><label>Bidang / Minat</label><input name="bidang" placeholder="mis. Pendidikan, Dokumentasi, Seni Budaya"></div>
      <div class="field"><label>WhatsApp</label><input name="wa" placeholder="08xxxxxxxxxx"></div>
      <div class="field"><label>Email</label><input type="email" name="email"></div>
      <div class="field"><label>Alamat</label><textarea name="alamat" rows="3"></textarea></div>
      <button type="submit" class="btn btn-gold btn-block">Gabung Sekarang</button>
    </form>@endif
  </x-modal>
<!-- ===== Modal Daftar Program ===== -->
<x-modal name="open-daftar" eyebrow="Pendaftaran Peserta" title="Daftar Program & Pelatihan" sub="Isi formulir berikut untuk mendaftar sebagai peserta program yayasan." label="Daftar Program">
    @if(class_exists(\Livewire\Livewire::class))<livewire:public-form type="daftar" />@else<form method="POST" action="<?php echo e(route('daftar.store')); ?>">
      <?php echo csrf_field(); ?>
      <input type="text" name="website" class="km-hp" tabindex="-1" autocomplete="off">
      <div class="field"><label>Nama Lengkap <span class="req" aria-hidden="true">*</span></label><input name="nama" required></div>
      <div class="field"><label>Program</label><select name="program"><option value="">- Pilih Program -</option><?php foreach($progsDaftar as $p): ?><option value="<?php echo e($p); ?>"><?php echo e($p); ?></option><?php endforeach; ?></select></div>
      <div class="field"><label>WhatsApp</label><input name="wa" placeholder="08xxxxxxxxxx"></div>
      <div class="field"><label>Email</label><input type="email" name="email"></div>
      <div class="field"><label>Asal Sekolah / Instansi</label><input name="asal"></div>
      <div class="field"><label>Catatan</label><textarea name="catatan" rows="3"></textarea></div>
      <button type="submit" class="btn btn-gold btn-block">Daftar Sekarang</button>
    </form>@endif
  </x-modal>
</body>
</html>
