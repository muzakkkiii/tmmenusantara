@extends('layouts.app')
@section('content')
<main id="pub">
<div class="page-hero" style="background-image:url('<?php echo e(img_setting('transparansi_hero_img', 'https://images.pexels.com/photos/30535786/pexels-photo-30535786.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap"><span class="eyebrow"><?php echo txt('transparansi_hero_eyebrow', 'Transparansi'); ?></span><h1><?php echo txt('transparansi_hero_title', 'Akuntabel dan terbuka.'); ?></h1><p class="lead"><?php echo txt('transparansi_hero_lead', 'Ringkasan donasi masuk, penyaluran dana, dan saldo yayasan kami sajikan sebagai bentuk pertanggungjawaban kepada publik.'); ?></p></div></div><div class="page-pad page-tint"><div class="wrap">

  <div class="sec-head-n reveal">
    <span class="eyebrow">Pertanggungjawaban Publik</span>
    <h2>Setiap rupiah dicatat dan dilaporkan.</h2>
    <p class="lead">Ringkasan donasi masuk, penyaluran, dan saldo yayasan yang divalidasi pengurus dan diperbarui berkala.</p>
  </div>

  <div class="chip-row reveal" style="margin-bottom:1rem"><span class="chips-label" style="margin:0 .4rem 0 0">Tahun</span><select id="transYear" onchange="location.href='{{ route('transparansi') }}?tahun='+this.value" style="border:1px solid var(--line);border-radius:9px;padding:.45rem .7rem;font-family:var(--sans)">@foreach($years as $y)<option value="{{ $y }}" {{ $y===$year?'selected':'' }}>{{ $y }}</option>@endforeach</select></div>
  <div class="stat-row reveal">
    <div class="stat-card gold"><div class="n" id="trIn">{{ rp($totalIn) }}</div><div class="l">Total donasi masuk</div></div>
    <div class="stat-card"><div class="n" id="trOut">{{ rp($totalOut) }}</div><div class="l">Total penyaluran</div></div>
    <div class="stat-card"><div class="n" id="trBal">{{ rp($saldo) }}</div><div class="l">Saldo tersedia</div></div>
    <div class="stat-card"><div class="n" id="trCount">{{ $count }}</div><div class="l">Transaksi tercatat</div></div>
  </div>
  <div class="tbl-wrap reveal">
    <div class="tbl-head"><h3>Donasi &amp; Dukungan Masuk</h3><span class="cat-pill">Pemasukan</span></div>
    <div class="tbl-scroll"><table class="data sortable"><thead><tr><th>Tanggal</th><th>Donatur</th><th>Program</th><th>Keterangan</th><th class="num">Jumlah</th></tr></thead><tbody>@forelse($ins as $r)<tr><td data-sort="<?php echo e(\Illuminate\Support\Carbon::parse($r->tgl)->format('Y-m-d')); ?>">{{ fmt_date($r->tgl) }}</td><td>{{ $r->nama }}</td><td>{{ $r->prog }}</td><td>{{ $r->ket }}</td><td class="num" data-sort="<?php echo e((int) $r->amt); ?>">{{ rp($r->amt) }}</td></tr>@empty<tr><td colspan="5" style="text-align:center;color:var(--muted)">Belum ada data.</td></tr>@endforelse</tbody><tfoot><tr><td colspan="4">Total Pemasukan</td><td class="num" id="trInFoot">{{ rp($totalIn) }}</td></tr></tfoot></table></div>
  </div>
  <div class="tbl-wrap reveal">
    <div class="tbl-head"><h3>Penyaluran &amp; Penggunaan Dana</h3><span class="cat-pill">Pengeluaran</span></div>
    <div class="tbl-scroll"><table class="data sortable"><thead><tr><th>Tanggal</th><th>Kegiatan</th><th>Program</th><th>Keterangan</th><th class="num">Jumlah</th></tr></thead><tbody>@forelse($outs as $r)<tr><td data-sort="<?php echo e(\Illuminate\Support\Carbon::parse($r->tgl)->format('Y-m-d')); ?>">{{ fmt_date($r->tgl) }}</td><td>{{ $r->nama }}</td><td>{{ $r->prog }}</td><td>{{ $r->ket }}</td><td class="num" data-sort="<?php echo e((int) $r->amt); ?>">{{ rp($r->amt) }}</td></tr>@empty<tr><td colspan="5" style="text-align:center;color:var(--muted)">Belum ada data.</td></tr>@endforelse</tbody><tfoot><tr><td colspan="4">Total Penyaluran</td><td class="num" id="trOutFoot">{{ rp($totalOut) }}</td></tr></tfoot></table></div>
  </div>
  <div class="sec-div sec-div-alt"><span class="orn-diamond"></span><span class="orn-line"></span><span class="orn-dots"><span></span><span></span><span></span></span><span class="orn-line"></span><span class="orn-diamond"></span></div>

  <p class="trans-note reveal">Data disajikan sebagai ringkasan yang telah divalidasi pengurus dan diperbarui berkala melalui dashboard yayasan. Detail dokumen internal tidak ditampilkan sebagai data mentah. Untuk konfirmasi atau laporan lengkap, silakan hubungi kami.</p>
</div></div>
</main>
@endsection
