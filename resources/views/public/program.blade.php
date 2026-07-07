@extends('layouts.app')
@section('content')
<main id="pub">

  <!-- ============ HERO ============ -->
  <div class="page-hero" style="background-image:url('<?php echo e(img_setting('program_hero_img', 'https://images.pexels.com/photos/34046709/pexels-photo-34046709.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap"><span class="eyebrow"><?php echo txt('program_hero_eyebrow', 'Program Yayasan'); ?></span><h1><?php echo txt('program_hero_title', 'Layanan yang menjawab kebutuhan nyata.'); ?></h1><p class="lead"><?php echo txt('program_hero_lead', 'Empat program unggulan - dari pendampingan pendidikan hingga pembinaan prestasi - dirancang terstruktur, terukur, dan berorientasi manfaat.'); ?></p></div></div>

  <div class="page-pad page-tint"><div class="wrap">

    <!-- ============ INTRO ============ -->
    <div class="sec-head-n reveal">
      <span class="eyebrow">Program Yayasan</span>
      <h2>Dirancang terstruktur, terukur, dan berorientasi manfaat.</h2>
      <p class="lead">Setiap program berdiri di atas tata kelola yang jelas, dengan penanggung jawab dan sasaran yang nyata bagi masyarakat.</p>
    </div>

    <!-- ============ PROGRAM LIST ============ -->
    @foreach($programs as $p)
    <?php
$cr = $p->cta_route ?? 'daftar';
$routes = ['daftar', 'mitra', 'kontak', 'donasi'];
$href = route(in_array($cr, $routes) ? $cr : 'daftar');

$img = property_exists($p, 'img') ? $p->img : null;

$flyer = !empty($img)
    ? img_url($img)
    : 'https://images.pexels.com/photos/12949251/pexels-photo-12949251.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=900&h=1200';
?>
    <div class="program reveal">
      <a class="p-flyer" href="<?php echo e($flyer); ?>" target="_blank" rel="noopener" style="background-image:url('<?php echo e($flyer); ?>')" aria-label="Lihat flyer <?php echo e($p->judul); ?>"><span class="p-flyer-badge"><?php echo e($p->visual_label ?: 'Program'); ?></span><span class="p-flyer-zoom"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg></span></a>
      <div class="p-body">
        <?php if(!empty($p->tag)): ?><span class="tag"><?php echo e($p->tag); ?></span><?php endif; ?>
        <h3><?php echo e($p->judul); ?></h3>
        <ul class="p-list">
          <?php foreach(preg_split('/\R/', trim((string) ($p->poin ?? ''))) as $li): if(trim($li) === '') continue; ?><li><?php echo e(trim($li)); ?></li><?php endforeach; ?>
        </ul>
        <div class="p-meta">
          <?php if(!empty($p->pic_nama)): ?><span>PIC <b><?php echo e($p->pic_nama); ?></b></span><?php endif; ?>
          <?php if(!empty($p->pic_telp)): ?><span>Telp <a href="<?php echo e(wa_link($p->pic_telp)); ?>" target="_blank" rel="noopener"><?php echo e($p->pic_telp); ?></a></span><?php endif; ?>
          <?php if(!empty($p->info)): ?><span><?php echo e($p->info); ?></span><?php endif; ?>
        </div>
        <a wire:navigate class="btn btn-oval-line" href="<?php echo e($href); ?>"><?php echo e($p->cta_label ?: 'Daftar / Konsultasi'); ?> <span class="btn-ic-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="12" height="12"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span></a>
      </div>
    </div>
    @if(!$loop->last)
    <div class="sec-div <?php echo $loop->index % 2 === 0 ? 'sec-div-alt' : ''; ?>"><span class="orn-line"></span><span class="orn-dots"><span></span><span></span><span></span></span><span class="orn-line"></span></div>
    @endif
    @endforeach

  </div></div>

  <!-- ============ DIVIDER ============ -->
  <div class="sec-div sec-div-alt"><span class="orn-diamond"></span><span class="orn-line"></span><span class="orn-dots"><span></span><span></span><span></span></span><span class="orn-line"></span><span class="orn-diamond"></span></div>

  <!-- ============ CTA ============ -->
  <section class="band-n band-photo" style="background-image:url('<?php echo e(img_setting('program_terlibat_img', 'https://images.pexels.com/photos/12949251/pexels-photo-12949251.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap">
    <div class="cta-n reveal">
      <span class="eyebrow">Ingin Terlibat?</span>
      <h2>Punya kebutuhan atau ingin berkolaborasi?</h2>
      <p>Konsultasikan kebutuhan Anda atau ajukan kemitraan dengan yayasan. Tim kami siap mendampingi dari perencanaan hingga pelaksanaan.</p>
      <div style="display:flex;gap:1rem;flex-wrap:wrap;justify-content:center;margin-top:1.6rem">
        <a wire:navigate class="btn btn-pill-gold" href="<?php echo e(route('kontak')); ?>">Konsultasi Gratis <span class="btn-pill-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span></a>
        <a wire:navigate class="btn btn-oval-line" href="<?php echo e(route('kemitraan')); ?>">Ajukan Kemitraan <span class="btn-ic-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="12" height="12"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span></a>
      </div>
    </div>
  </div></section>

</main>
@endsection
