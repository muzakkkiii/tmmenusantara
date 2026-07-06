@extends('layouts.app')
@section('content')
<main id="pub">
<nav class="crumbs" aria-label="breadcrumb"><div class="wrap"><a wire:navigate href="<?php echo e(route('beranda')); ?>">Beranda</a> <span class="sep">/</span> <a wire:navigate href="<?php echo e(route('berita')); ?>">Berita</a> <span class="sep">/</span> <span>Detail</span></div></nav>
<div class="page-hero" style="background-image:url('<?php echo e(img_setting('beritashow_hero_img', 'https://images.pexels.com/photos/6646923/pexels-photo-6646923.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap"><span class="eyebrow">Berita &amp; Kegiatan</span><h1>{{ $news->title }}</h1><p class="lead">{{ $news->label }}</p></div></div>
<div class="page-pad page-tint"><div class="wrap" style="max-width:760px;margin:0 auto">
@if($news->img)
<div class="thumb" style="height:340px;border-radius:var(--radius);background:var(--cream) center/cover no-repeat;margin-bottom:1.6rem;background-image:url('<?php echo e(img_url($news->img)); ?>')"></div>
@endif
<div class="prose article-body" style="white-space:pre-line">{{ $news->full ?: $news->body }}</div>
@if($others->count())
<div class="sec-head reveal" style="margin-top:clamp(40px,6vw,70px)"><span class="eyebrow">Lainnya</span><h2>Berita lainnya.</h2></div>
<div class="posts">@foreach($others as $n)<article class="post"><div class="body"><div class="date">{{ $n->label }}</div><h3>{{ $n->title }}</h3><a class="textlink" href="{{ route('berita.show',$n) }}">Baca <span class="arw">&rarr;</span></a></div></article>@endforeach</div>
@endif
<p style="margin-top:2rem"><a class="textlink" href="{{ route('berita') }}"><span class="arw">&larr;</span> Kembali ke Berita</a></p>
</div></div>
</main>
@endsection
