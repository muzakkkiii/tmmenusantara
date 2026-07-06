@extends('layouts.app')
@section('content')
<main id="pub">

  <!-- ============ 1. HERO ============ -->
  <section class="hero-n">
    <div class="hero-n-bg" style="background-image:url('<?php echo e(img_setting('home_hero_img', 'https://images.pexels.com/photos/32218913/pexels-photo-32218913.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"></div>
    <div class="hero-n-overlay"></div>
    <div class="wrap hero-n-inner">
      <div class="hero-n-copy reveal">
        <span class="eyebrow on-dark"><?php echo txt('home_hero_eyebrow', 'Yayasan Terate Mekar Memayu Nusantara'); ?></span>
        <h1 style="color:#fff"><?php echo txt('home_hero_title', 'Memberi manfaat yang <em>berkelanjutan</em> bagi Nusantara.'); ?></h1>
        <p class="lead" style="color:rgba(255,255,255,.85)"><?php echo txt('home_hero_lead', 'Bergerak di bidang pendidikan, pengabdian, ekonomi, seni budaya, dan sarana prasarana &mdash; menghubungkan gagasan, sumber daya, dan masyarakat menjadi manfaat nyata.'); ?></p>
        <div class="hero-n-cta">
          <a wire:navigate class="btn btn-pill-gold" href="<?php echo e(route('program')); ?>">Lihat Program <span class="btn-pill-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span></a>
          <a wire:navigate class="btn btn-ghost-link" href="<?php echo e(route('kontak')); ?>">Hubungi Kami <span class="arw"></span></a>
        </div>
      </div>
    </div>
    <div class="wrap">
      <div class="hero-n-credbar reveal">
        <div><b>Akta No. 4</b><span>10 Maret 2025</span></div>
        <div class="hc-sep"></div>
        <div><b>AHU-0004497</b><span>SK Kemenkumham</span></div>
        <div class="hc-sep"></div>
        <div><b>Kota Malang</b><span>Jawa Timur</span></div>
        <div class="hc-sep"></div>
        <div><b>5 Bidang</b><span>Program utama</span></div>
      </div>
    </div>
  </section>

  <!-- ============ DIVIDER ============ -->
  <div class="sec-div"><span class="orn-dots"><span></span><span></span><span></span></span><span class="orn-line"></span><span class="orn-diamond"></span><span class="orn-line"></span><span class="orn-dots"><span></span><span></span><span></span></span></div>

  <!-- ============ 2. TENTANG SINGKAT ============ -->
  <section class="band-n"><div class="wrap">
    <div class="about-n-grid">
      <div class="about-n-fig reveal" aria-hidden="true">
        <div class="about-n-frame">
          <img src="<?php echo e(img_setting('home_about_img', 'https://images.pexels.com/photos/6647054/pexels-photo-6647054.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1200&h=900')); ?>" alt="Kegiatan pendidikan komunitas" loading="lazy" decoding="async" width="1200" height="900" />
        </div>
      </div>
      <div class="about-n-text reveal">
        <span class="eyebrow">Sekilas Yayasan</span>
        <h2>Sebuah lembaga pengabdian yang tumbuh dari nilai <em>Memayu Hayuning Nusantara</em>.</h2>
        <p>Yayasan TM Menusantara hadir sebagai ruang kolaborasi bagi masyarakat, profesional, komunitas, pelajar, mahasiswa, dan pelaku usaha untuk bergerak bersama dalam pendidikan, ekonomi, sosial, dan pelestarian budaya.</p>
        <p>Kami percaya kebaikan yang terkelola dengan tata kelola yang jelas akan tumbuh menjadi manfaat yang berkelanjutan dan dapat dipertanggungjawabkan kepada publik.</p>
        <a wire:navigate class="lnk-underline" href="<?php echo e(route('tentang')); ?>">Kenali kami lebih jauh <span class="arw">&rarr;</span></a>
      </div>
    </div>
  </div></section>

  <!-- ============ IMPACT / DAMPAK ============ -->
  <section class="impact-n" aria-labelledby="impact-title">
    <div class="wrap">
      <div class="impact-n-head reveal">
        <span class="eyebrow on-dark">Dampak Kami</span>
        <h2 id="impact-title">Kebaikan yang tumbuh, terukur dan nyata.</h2>
        <p>Angka berikut menggambarkan cakupan gerakan Yayasan TM Menusantara bersama masyarakat dan mitra. Nilai dapat disesuaikan melalui pengaturan situs.</p>
      </div>
      <div class="impact-grid">
        <div class="impact-cell reveal"><span class="impact-num" data-count="<?php echo e(setting('stat_bidang', 5)); ?>">0</span><span class="impact-label">Bidang program utama</span></div>
        <div class="impact-cell reveal"><span class="impact-num" data-count="<?php echo e(setting('stat_penerima', 500)); ?>" data-suffix="+">0</span><span class="impact-label">Penerima manfaat</span></div>
        <div class="impact-cell reveal"><span class="impact-num" data-count="<?php echo e(setting('stat_kegiatan', 30)); ?>" data-suffix="+">0</span><span class="impact-label">Kegiatan terlaksana</span></div>
        <div class="impact-cell reveal"><span class="impact-num" data-count="<?php echo e(setting('stat_mitra', 15)); ?>" data-suffix="+">0</span><span class="impact-label">Mitra &amp; relawan</span></div>
      </div>
    </div>
  </section>

  <!-- ============ DIVIDER ============ -->
  <div class="sec-div sec-div-alt"><span class="orn-diamond"></span><span class="orn-line"></span><span class="orn-dots"><span></span><span></span><span></span></span><span class="orn-line"></span><span class="orn-diamond"></span></div>

  <!-- ============ 3. VISI & MISI ============ -->
  <section class="band-n band-photo" style="background-image:url('<?php echo e(img_setting('home_vm_img', 'https://images.pexels.com/photos/35474230/pexels-photo-35474230.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap">
    <div class="vm-grid">
      <div class="vm-visi reveal">
        <span class="eyebrow">Visi</span>
        <blockquote class="vm-quote">Menjadi yayasan yang memberi manfaat berkelanjutan bagi nusantara melalui pendidikan, pengabdian, ekonomi, seni budaya, dan sarana prasarana.</blockquote>
      </div>
      <div class="vm-misi reveal">
        <span class="eyebrow">Misi</span>
        <ol class="vm-list">
          <li><span class="vm-num">01</span><span>Memberdayakan masyarakat melalui pendidikan dan pelatihan berkualitas.</span></li>
          <li><span class="vm-num">02</span><span>Menguatkan kemandirian ekonomi melalui usaha dan kemitraan berkelanjutan.</span></li>
          <li><span class="vm-num">03</span><span>Melestarikan seni, budaya, dan nilai luhur bangsa.</span></li>
          <li><span class="vm-num">04</span><span>Menyediakan sarana prasarana penunjang kegiatan yayasan dan masyarakat.</span></li>
          <li><span class="vm-num">05</span><span>Menjalankan tata kelola yang transparan dan dapat dipertanggungjawabkan.</span></li>
        </ol>
      </div>
    </div>
  </div></section>

  <!-- ============ DIVIDER ============ -->
  <div class="sec-div"><span class="orn-line"></span><span class="orn-dots"><span></span><span></span><span></span></span><span class="orn-line"></span></div>

  <!-- ============ 4. PROGRAM UNGGULAN ============ -->
  <section class="band-n"><div class="wrap">
    <div class="sec-head-n reveal">
      <span class="eyebrow">Program Unggulan</span>
      <h2>Lima bidang, satu tujuan: manfaat nyata.</h2>
      <p class="lead">Setiap program dirancang terstruktur dan terukur untuk menjawab kebutuhan pendidikan, ekonomi, sosial, budaya, dan sarana masyarakat.</p>
    </div>
    <div class="prog-n-list">
      <a wire:navigate class="prog-n-item reveal" href="<?php echo e(route('program')); ?>">
        <span class="prog-n-idx">01</span>
        <div class="prog-n-body">
          <h3>Pendidikan @ Malang</h3>
          <p>Pendampingan belajar, beasiswa, dan pelatihan untuk meningkatkan kualitas SDM sejak dini.</p>
        </div>
        <span class="prog-n-arrow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
      </a>
      <a wire:navigate class="prog-n-item reveal" href="<?php echo e(route('program')); ?>">
        <span class="prog-n-idx">02</span>
        <div class="prog-n-body">
          <h3>Pengembangan Bisnis</h3>
          <p>Penguatan kemandirian ekonomi melalui usaha, kemitraan, dan pemberdayaan berkelanjutan.</p>
        </div>
        <span class="prog-n-arrow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
      </a>
      <a wire:navigate class="prog-n-item reveal" href="<?php echo e(route('program')); ?>">
        <span class="prog-n-idx">03</span>
        <div class="prog-n-body">
          <h3>Cakra Buana Club</h3>
          <p>Wadah komunitas olahraga dan pengembangan diri yang menumbuhkan sportivitas dan kebersamaan.</p>
        </div>
        <span class="prog-n-arrow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
      </a>
      <a wire:navigate class="prog-n-item reveal" href="<?php echo e(route('program')); ?>">
        <span class="prog-n-idx">04</span>
        <div class="prog-n-body">
          <h3>Sosial, Seni &amp; Budaya</h3>
          <p>Pengabdian sosial serta pelestarian seni dan budaya sebagai wujud nilai luhur bangsa.</p>
        </div>
        <span class="prog-n-arrow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
      </a>
      <a wire:navigate class="prog-n-item reveal" href="<?php echo e(route('program')); ?>">
        <span class="prog-n-idx">05</span>
        <div class="prog-n-body">
          <h3>Sarana &amp; Prasarana</h3>
          <p>Pengadaan dan perawatan sarana penunjang kegiatan yayasan dan masyarakat.</p>
        </div>
        <span class="prog-n-arrow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
      </a>
    </div>
  </div></section>

  <!-- ============ DIVIDER ============ -->
  <div class="sec-div sec-div-alt"><span class="orn-dots"><span></span><span></span><span></span></span><span class="orn-line"></span><span class="orn-diamond"></span><span class="orn-line"></span><span class="orn-dots"><span></span><span></span><span></span></span></div>

  <!-- ============ 5. MENGAPA KAMI ============ -->
  <section class="band-n why-n-section">
    <div class="why-n-bg" style="background-image:url('<?php echo e(img_setting('home_why_img', 'https://images.pexels.com/photos/12949251/pexels-photo-12949251.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1200&h=900')); ?>')"></div>
    <div class="why-n-overlay"></div>
    <div class="wrap">
      <div class="why-n-head reveal">
        <span class="eyebrow on-dark">Mengapa TM Menusantara</span>
        <h2 style="color:#fff">Tata kelola jelas, manfaat nyata.</h2>
      </div>
      <div class="why-n-grid">
        <div class="why-n-item reveal">
          <span class="why-n-num">01</span>
          <h3>Berbasis Komunitas</h3>
          <p>Tumbuh dari dan bersama masyarakat &mdash; setiap program berakar pada kebutuhan nyata di lapangan.</p>
        </div>
        <div class="why-n-item reveal">
          <span class="why-n-num">02</span>
          <h3>Profesional</h3>
          <p>Pengurus, pembina, dan pengawas dengan struktur tata kelola yang jelas dan dapat dipertanggungjawabkan.</p>
        </div>
        <div class="why-n-item reveal">
          <span class="why-n-num">03</span>
          <h3>Terintegrasi</h3>
          <p>Lima bidang program saling mendukung, menciptakan dampak holistik yang berkelanjutan.</p>
        </div>
        <div class="why-n-item reveal">
          <span class="why-n-num">04</span>
          <h3>Berorientasi Manfaat</h3>
          <p>Setiap kegiatan dirancang terukur dan berorientasi pada manfaat nyata bagi penerima.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ DIVIDER ============ -->
  <div class="sec-div"><span class="orn-line"></span><span class="orn-dots"><span></span><span></span><span></span></span><span class="orn-line"></span></div>

  <!-- ============ 6. KEGIATAN TERBARU ============ -->
  <section class="band-n"><div class="wrap">
    <div class="sec-head-n reveal" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:1rem;max-width:none">
      <div><span class="eyebrow">Berita &amp; Kegiatan</span><h2 style="margin-bottom:0">Kabar terbaru dari kami.</h2></div>
      <a wire:navigate class="btn btn-oval-line" href="<?php echo e(route('berita')); ?>">Lihat semua <span class="btn-ic-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="12" height="12"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span></a>
    </div>
    <div class="news-n-grid newspaper reveal">
    @forelse($news as $n)
      <article class="news-n-item">
        @if($n->img)<div class="news-n-thumb" style="background-image:url('<?php echo e(img_url($n->img)); ?>')"></div>@else<div class="news-n-thumb news-n-thumb-placeholder"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" width="40" height="40"><rect x="3" y="3" width="18" height="18" rx="1"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg></div>@endif
        <div class="news-n-body">
          <div class="news-n-date"><?php echo e(fmt_date($n->created_at)); ?></div>
          <h3><?php echo e($n->title); ?></h3>
          <p><?php echo e(\Illuminate\Support\Str::limit(strip_tags($n->body), 120)); ?></p>
          <a wire:navigate class="lnk-underline" href="<?php echo e(route('berita.show', $n)); ?>">Baca selengkapnya <span class="arw">&rarr;</span></a>
        </div>
      </article>
    @empty
      <p style="color:var(--muted)">Belum ada berita. Kegiatan terbaru akan tampil di sini.</p>
    @endforelse
    </div>
  </div></section>

  <!-- ============ DIVIDER ============ -->
  <div class="sec-div sec-div-alt"><span class="orn-diamond"></span><span class="orn-line"></span><span class="orn-dots"><span></span><span></span><span></span></span><span class="orn-line"></span><span class="orn-diamond"></span></div>

  <!-- ============ 7. KEMITRAAN & DUKUNGAN ============ -->
  <section class="band-n band-photo" style="background-image:url('<?php echo e(img_setting('home_kemitraan_img', 'https://images.pexels.com/photos/3184465/pexels-photo-3184465.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap">
    <div class="cta-n reveal">
      <div class="cta-n-text">
        <span class="eyebrow">Kemitraan &amp; Dukungan</span>
        <h2>Mari tumbuh bersama, wujudkan manfaat berkelanjutan.</h2>
        <p class="lead" style="color:var(--muted);margin-top:.6rem">Terbuka untuk kerja sama, sponsorship, donasi, dan relawan. Setiap dukungan Anda menjadi manfaat nyata bagi masyarakat.</p>
      </div>
      <div class="cta-n-actions">
        <a wire:navigate class="btn btn-sharp" href="<?php echo e(route('donasi')); ?>">Dukung Sekarang</a>
        <a wire:navigate class="btn btn-oval-line" href="<?php echo e(route('kemitraan')); ?>">Ajukan Kemitraan <span class="btn-ic-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="12" height="12"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span></a>
      </div>
    </div>
  </div></section>

  <!-- ============ DIVIDER ============ -->
  <div class="sec-div"><span class="orn-dots"><span></span><span></span><span></span></span><span class="orn-line"></span><span class="orn-diamond"></span><span class="orn-line"></span><span class="orn-dots"><span></span><span></span><span></span></span></div>

  <!-- ============ 8. KONTAK CEPAT ============ -->
  <section class="band-n"><div class="wrap">
    <div class="contact-n-grid">
      <div class="contact-n-info reveal">
        <span class="eyebrow">Kontak Cepat</span>
        <h2 style="margin-bottom:1.2rem">Hubungi kami.</h2>
        <ul class="contact-n-list">
          <li><span class="cn-label">WhatsApp</span><a href="<?php echo e(wa_link(setting('wa','6282332651802'),'Halo Yayasan TM Menusantara')); ?>" target="_blank" rel="noopener"><?php echo e(setting('wa_display','0823-3265-1802')); ?></a></li>
          <li><span class="cn-label">Email</span><a href="mailto:<?php echo e(setting('email','info@menusantara.org')); ?>"><?php echo e(setting('email','info@menusantara.org')); ?></a></li>
          <li><span class="cn-label">Alamat</span><span><?php echo e(setting('alamat','Gedung MCC Lt. 1, Kota Malang, Jawa Timur')); ?></span></li>
        </ul>
        <div class="contact-n-social">
          <a href="<?php echo e(wa_link(setting('wa','6282332651802'))); ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12 2a10 10 0 00-8.6 15l-1.4 5 5.1-1.3A10 10 0 1012 2zm0 18a8 8 0 01-4.1-1.1l-.3-.2-3 .8.8-2.9-.2-.3A8 8 0 1112 20zm4.4-6c-.2-.1-1.4-.7-1.6-.8-.2-.1-.4-.1-.5.1-.2.2-.6.8-.8 1-.1.1-.3.1-.5 0-.7-.3-1.4-.6-2-1.3-.5-.5-.8-1.1-1-1.3-.1-.2 0-.3.1-.4l.4-.4c.1-.1.1-.2.2-.4 0-.1 0-.3-.1-.4l-.7-1.7c-.2-.4-.4-.4-.5-.4h-.5c-.2 0-.4.1-.6.3-.2.2-.7.7-.7 1.8s.8 2.1.9 2.2c.1.2 1.5 2.3 3.7 3.2.5.2.9.3 1.3.4.5.1 1 .1 1.4.1.4-.1 1.3-.5 1.5-1 .2-.5.2-1 .1-1z"/></svg></a>
          <a href="mailto:<?php echo e(setting('email','info@menusantara.org')); ?>" aria-label="Email"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20"><rect x="2" y="4" width="20" height="16" rx="1"/><path d="M2 6l10 7L22 6"/></svg></a>
        </div>
      </div>
      <div class="contact-n-map reveal">
        <iframe src="https://www.google.com/maps?q=<?php echo e(urlencode(setting('alamat','Malang, Jawa Timur'))); ?>&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Lokasi Yayasan TM Menusantara"></iframe>
      </div>
    </div>
  </div></section>

</main>

@endsection