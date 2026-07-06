@extends('layouts.app')
@section('content')
<main id="pub">

  <!-- ============ HERO ============ -->
  <div class="page-hero" style="background-image:url('<?php echo e(img_setting('agenda_hero_img', 'https://images.pexels.com/photos/8117476/pexels-photo-8117476.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap"><span class="eyebrow"><?php echo txt('agenda_hero_eyebrow', 'Agenda Kegiatan'); ?></span><h1><?php echo txt('agenda_hero_title', 'Kalender Kegiatan Yayasan'); ?></h1><p class="lead"><?php echo txt('agenda_hero_lead', 'Jadwal kegiatan mendatang dan rekam jejak kegiatan yang telah berlangsung.'); ?></p></div></div>

  <div class="page-pad" x-data="{ tab:'<?php echo request()->query('bulan') ? 'kalender' : 'upcoming'; ?>' }">
  <div class="wrap">

    <!-- ============ INTRO ============ -->
    <div class="sec-head-n reveal">
      <span class="eyebrow">Jadwal &amp; Rekam Jejak</span>
      <h2>Ikuti kegiatan yayasan dari waktu ke waktu.</h2>
      <p class="lead">Saring berdasarkan kegiatan mendatang, terdahulu, atau lihat keseluruhan agenda.</p>
    </div>

    <div class="ag-tabs no-print">
      <button type="button" class="ag-tab" :class="tab==='upcoming' && 'active'" @click="tab='upcoming'">Mendatang</button>
      <button type="button" class="ag-tab" :class="tab==='past' && 'active'" @click="tab='past'">Terdahulu</button>
      <button type="button" class="ag-tab" :class="tab==='all' && 'active'" @click="tab='all'">Semua</button>
      <button type="button" class="ag-tab" :class="tab==='kalender' && 'active'" @click="tab='kalender'">Kalender</button>
    </div>

    <!-- ============ KALENDER BULANAN ============ -->
    <div x-show="tab==='kalender'" x-data="{ open:false, ev:{} }">
      <?php
        $bulanLabelId = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
        $curY = $cursor->format('Y');
        $curM = $cursor->format('m');
        $namaBulan = $bulanLabelId[$curM] . ' ' . $curY;
        $daysInMonth = (int) $cursor->format('t');
        $startWeekday = (int) $cursor->copy()->startOfMonth()->format('N');
        $leading = $startWeekday - 1;
        $todayStr = \Illuminate\Support\Carbon::now()->format('Y-m-d');
      ?>
      <div class="cal-head no-print">
        <a href="<?php echo e(route('agenda', ['bulan' => $prevBulan]) . '#kal'); ?>" class="cal-nav" aria-label="Bulan sebelumnya">&larr;</a>
        <h2 class="cal-title"><?php echo e($namaBulan); ?></h2>
        <a href="<?php echo e(route('agenda', ['bulan' => $nextBulan]) . '#kal'); ?>" class="cal-nav" aria-label="Bulan berikutnya">&rarr;</a>
      </div>
      <div id="kal" class="cal-grid">
        <div class="cal-dow">Sen</div><div class="cal-dow">Sel</div><div class="cal-dow">Rab</div><div class="cal-dow">Kam</div><div class="cal-dow">Jum</div><div class="cal-dow">Sab</div><div class="cal-dow">Min</div>
        <?php for ($i = 0; $i < $leading; $i++): ?><div class="cal-cell cal-empty"></div><?php endfor; ?>
        <?php for ($d = 1; $d <= $daysInMonth; $d++):
          $dateKey = $curY . '-' . $curM . '-' . sprintf('%02d', $d);
          $dayEvents = $calEvents[$dateKey] ?? collect();
          $isToday = ($dateKey === $todayStr);
        ?>
          <div class="cal-cell<?php echo $isToday ? ' cal-today' : ''; ?><?php echo count($dayEvents) ? ' cal-has' : ''; ?>">
            <span class="cal-num"><?php echo $d; ?></span>
            <?php foreach ($dayEvents as $e): ?>
              <button type="button" class="cal-ev" title="<?php echo e($e->judul); ?>" @click="ev = <?php echo \Illuminate\Support\Js::from(['judul' => $e->judul, 'waktu' => $e->mulai->format('d M Y, H:i') . ' WIB', 'lokasi' => $e->lokasi, 'desk' => $e->deskripsi, 'status' => $e->status]); ?>; open=true"><span class="cal-ev-t"><?php echo e($e->mulai->format('H:i')); ?></span> <?php echo e($e->judul); ?></button>
            <?php endforeach; ?>
          </div>
        <?php endfor; ?>
      </div>
      <p class="cal-legend"><span class="cal-dot"></span> Ada kegiatan pada tanggal tersebut &mdash; klik untuk detail.</p>

      <div class="cal-modal" x-show="open" x-cloak @click.self="open=false" @keydown.escape.window="open=false" style="display:none">
        <div class="cal-modal-in">
          <button type="button" class="cal-x" @click="open=false" aria-label="Tutup">&times;</button>
          <h3 x-text="ev.judul"></h3>
          <p class="cal-modal-meta" x-text="ev.waktu"></p>
          <template x-if="ev.lokasi"><p class="cal-modal-loc" x-text="ev.lokasi"></p></template>
          <template x-if="ev.desk"><p class="cal-modal-desk" x-text="ev.desk"></p></template>
        </div>
      </div>
    </div>

    <div x-show="tab==='upcoming' || tab==='all'">
      <h2 class="sec-title">Kegiatan Mendatang</h2>
      @if($mendatang->isEmpty())
        <p style="color:var(--muted);padding:8px 0 24px">Belum ada kegiatan mendatang yang dijadwalkan.</p>
      @else
        <div class="ag-list">
        @foreach($mendatang as $e)
          <div class="ag-item reveal">
            <div class="ag-date"><span class="d"><?php echo e($e->mulai->format('d')); ?></span><span class="m"><?php echo e($e->mulai->format('M Y')); ?></span></div>
            <div class="ag-body">
              <h3><?php echo e($e->judul); ?> <span class="ag-badge ag-<?php echo e(strtolower($e->status)); ?>"><?php echo e($e->status); ?></span></h3>
              <p class="ag-meta"><svg class="ag-ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14" style="vertical-align:-2px;margin-right:3px"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg><?php echo e($e->mulai->format('H:i')); ?> WIB<?php if($e->lokasi): ?> &nbsp;&bull;&nbsp; <svg class="ag-ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14" style="vertical-align:-2px;margin-right:3px"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg><?php echo e($e->lokasi); ?><?php endif; ?></p>
              <?php if($e->deskripsi): ?><p><?php echo e($e->deskripsi); ?></p><?php endif; ?>
            </div>
          </div>
        @endforeach
        </div>
      @endif
    </div>

    <div x-show="tab==='all'" class="sec-div"><span class="orn-line"></span><span class="orn-dots"><span></span><span></span><span></span></span><span class="orn-line"></span></div>

    <div x-show="tab==='past' || tab==='all'" style="margin-top:38px">
      <h2 class="sec-title">Kegiatan Terdahulu</h2>
      @if($lampau->isEmpty())
        <p style="color:var(--muted);padding:8px 0 24px">Belum ada rekam kegiatan terdahulu.</p>
      @else
        <div class="ag-list">
        @foreach($lampau as $e)
          <div class="ag-item ag-past reveal">
            <div class="ag-date"><span class="d"><?php echo e($e->mulai->format('d')); ?></span><span class="m"><?php echo e($e->mulai->format('M Y')); ?></span></div>
            <div class="ag-body">
              <h3><?php echo e($e->judul); ?></h3>
              <p class="ag-meta"><svg class="ag-ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14" style="vertical-align:-2px;margin-right:3px"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg><?php echo e($e->mulai->format('H:i')); ?> WIB<?php if($e->lokasi): ?> &nbsp;&bull;&nbsp; <svg class="ag-ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14" style="vertical-align:-2px;margin-right:3px"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg><?php echo e($e->lokasi); ?><?php endif; ?></p>
            </div>
          </div>
        @endforeach
        </div>
      @endif
    </div>

  </div>
  </div>
</main>
@endsection
