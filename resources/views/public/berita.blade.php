@extends('layouts.app')
@section('content')
<main id="pub">

  <!-- ============ HERO ============ -->
  <div class="page-hero" style="background-image:url('<?php echo e(img_setting('berita_hero_img', 'https://images.pexels.com/photos/6646923/pexels-photo-6646923.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap"><span class="eyebrow"><?php echo txt('berita_hero_eyebrow', 'Berita &amp; Kegiatan'); ?></span><h1><?php echo txt('berita_hero_title', 'Aktivitas nyata, perkembangan yang terdokumentasi.'); ?></h1><p class="lead"><?php echo txt('berita_hero_lead', 'Dokumentasi program, kegiatan, dan perkembangan terbaru dari yayasan.'); ?></p></div></div>

  <div class="page-pad tint-cream bg-motif"><div class="wrap">

    <!-- ============ INTRO + SEARCH ============ -->
    <div class="sec-head-n reveal">
      <span class="eyebrow">Kabar Terkini</span>
      <h2>Rekam jejak kegiatan yayasan.</h2>
      <p class="lead">Telusuri liputan program, kegiatan sosial, dan momen kebersamaan dari waktu ke waktu.</p>
    </div>

    <form class="searchbar" method="GET" action="<?php echo e(route('berita')); ?>">
      <input type="search" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari berita atau kegiatan..." aria-label="Cari berita">
      <button type="submit" class="btn btn-sm btn-gold">Cari</button>
      @if(request('q'))<a wire:navigate class="pg" href="<?php echo e(route('berita')); ?>">Reset</a>@endif
    </form>
    @if(request('q'))<p class="search-note"><?php echo e($news->total()); ?> hasil untuk &ldquo;<?php echo e(request('q')); ?>&rdquo;</p>@endif

    <!-- ============ POSTS ============ -->
    <div class="posts">
@forelse($news as $n)
<article class="post reveal">
<div class="thumb" style="background:var(--cream) center/cover no-repeat;background-image:url('<?php echo e($n->img ? img_url($n->img) : 'https://images.pexels.com/photos/6647128/pexels-photo-6647128.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1200&h=900'); ?>')"></div>
<div class="body"><div class="date"><?php echo e(fmt_date($n->created_at)); ?></div><h3><?php echo e($n->title); ?></h3><p><?php echo e(\Illuminate\Support\Str::limit(strip_tags($n->body), 130)); ?></p><a wire:navigate class="textlink" href="<?php echo e(route('berita.show', $n)); ?>">Lihat selengkapnya <span class="arw">&rarr;</span></a></div>
</article>
@empty
<p style="color:var(--muted)"><?php if(request('q')): ?>Tidak ada berita yang cocok dengan pencarian Anda.<?php else: ?>Belum ada berita.<?php endif; ?></p>
@endforelse
    </div>

@if($news->hasPages())
<nav class="pager">
<?php if($news->onFirstPage()): ?><span class="pg disabled">&larr; Sebelumnya</span><?php else: ?><a class="pg" href="<?php echo e($news->previousPageUrl()); ?>">&larr; Sebelumnya</a><?php endif; ?>
<span class="pg-info">Halaman <?php echo e($news->currentPage()); ?> dari <?php echo e($news->lastPage()); ?></span>
<?php if($news->hasMorePages()): ?><a class="pg" href="<?php echo e($news->nextPageUrl()); ?>">Berikutnya &rarr;</a><?php else: ?><span class="pg disabled">Berikutnya &rarr;</span><?php endif; ?>
</nav>
@endif

  </div></div>

  <!-- ============ DIVIDER ============ -->
  <div class="sec-div sec-div-alt"><span class="orn-diamond"></span><span class="orn-line"></span><span class="orn-dots"><span></span><span></span><span></span></span><span class="orn-line"></span><span class="orn-diamond"></span></div>

  <!-- ============ CTA BAND ============ -->
  <div class="page-pad" style="padding-top:0"><div class="wrap">
    <div class="cta-band reveal">
      <div><h2 style="color:#fff">Lihat dokumentasi foto kegiatan.</h2><p style="color:rgba(255,255,255,.85)">Kumpulan momen dari berbagai program dan kegiatan yayasan.</p></div>
      <div class="actions"><a wire:navigate class="btn btn-gold" href="<?php echo e(route('galeri')); ?>">Buka Galeri Foto</a><a wire:navigate class="btn btn-oval-line" href="<?php echo e(route('agenda')); ?>">Lihat Agenda <span class="btn-ic-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="12" height="12"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span></a></div>
    </div>
  </div></div>

</main>
@endsection
