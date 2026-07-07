@extends('layouts.app')
@section('content')
<main id="pub">

  <!-- ============ HERO ============ -->
  <div class="page-hero" style="background-image:url('<?php echo e(img_setting('tentang_hero_img', 'https://images.pexels.com/photos/32327259/pexels-photo-32327259.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap"><span class="eyebrow"><?php echo txt('tentang_hero_eyebrow', 'Profil Yayasan'); ?></span><h1><?php echo txt('tentang_hero_title', 'Tentang TM Menusantara'); ?></h1><p class="lead"><?php echo txt('tentang_hero_lead', 'Wadah pengabdian, pemberdayaan, pendidikan, ekonomi, dan pelestarian seni budaya yang berkelanjutan.'); ?></p></div></div>

  <!-- ============ DIVIDER ============ -->
  <!-- <div class="sec-div sec-div-alt"><span class="orn-diamond"></span><span class="orn-line"></span><span class="orn-dots"><span></span><span></span><span></span></span><span class="orn-line"></span><span class="orn-diamond"></span></div> -->

  <!-- ============ 2. VISI & MISI ============ -->
  <section class="band-n vm-bg" style="background-image:url('<?php echo e(img_setting('tentang_img3', 'https://images.pexels.com/photos/35474230/pexels-photo-35474230.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap">
    <div class="vm-grid">
      <div class="vm-visi reveal">
        <span class="eyebrow">Visi</span>
        <blockquote class="vm-quote"><?php echo e(setting('tentang_visi', 'Menjadi yayasan yang terus memberi manfaat melalui pendidikan, pengabdian, ekonomi, dan seni budaya, guna mewujudkan kesejahteraan melalui eksistensi Memayu Hayuning Nusantara.')); ?></blockquote>
      </div>
      <div class="vm-misi reveal">
        <span class="eyebrow">Misi</span>
        <ol class="vm-list">
          <li><span class="vm-num">01</span><span>Mengembangkan pendidikan dan pelatihan untuk meningkatkan kualitas sumber daya manusia yang berdaya dan bermanfaat bagi masyarakat.</span></li>
          <li><span class="vm-num">02</span><span>Melaksanakan pengabdian sosial serta pelestarian seni dan budaya sebagai wujud kepedulian dan nilai luhur Memayu Hayuning Nusantara.</span></li>
          <li><span class="vm-num">03</span><span>Memperkuat kemandirian ekonomi masyarakat melalui kegiatan usaha dan pemberdayaan yang berkelanjutan.</span></li>
          <li><span class="vm-num">04</span><span>Menyediakan dan mengelola sarana prasarana yang memadai guna mendukung kelancaran kegiatan dan pelayanan yayasan.</span></li>
        </ol>
      </div>
    </div>
  </div></section>

  <!-- ============ 1. SEKILAS YAYASAN ============ -->
  <!-- <section class="band-n"><div class="wrap">
    <div class="about-n-grid">
      <div class="about-n-fig reveal">
        <div class="about-n-frame">
          <img src="<?php echo e(img_setting('tentang_img2', 'https://images.pexels.com/photos/35548841/pexels-photo-35548841.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1200&h=900')); ?>" alt="Kegiatan komunitas dan pemberdayaan yayasan" loading="lazy" />
        </div>
        <div class="seal">&ldquo;Membangun manusia, memperkuat masyarakat, menjaga budaya.&rdquo;<small>Terate Mekar Memayu Nusantara</small></div>
      </div>
      <div class="about-n-text reveal">
        <span class="eyebrow">Sekilas Yayasan</span>
        <h2><?php echo e(setting('tentang_intro_head', 'Wadah pengabdian, pemberdayaan, dan kolaborasi.')); ?></h2>
        <p><?php echo e(setting('tentang_p1', 'Yayasan Terate Mekar Memayu Nusantara - dikenal sebagai Yayasan TM Menusantara - adalah lembaga pengabdian, pemberdayaan, pendidikan, penguatan ekonomi, pelestarian seni budaya, serta kegiatan sosial kemasyarakatan yang berkelanjutan.')); ?></p>
        <p><?php echo e(setting('tentang_p2', 'Dibangun dengan semangat Memayu Hayuning Nusantara - nilai untuk terus memberi manfaat, menjaga harmoni kehidupan, dan memperkuat karakter - yayasan menjadi ruang kolaborasi lintas kalangan.')); ?></p>
        <div class="legal-note"><b>Legalitas.</b> Akta Notaris Elisatin Ernawati, S.H., M.Kn. No. 4 tanggal 10 Maret 2025 &middot; SK Menkumham AHU-0004497.AH.01.04.Tahun 2025 tertanggal 11 Maret 2025.</div>
      </div>
    </div>
  </div></section> -->


  <!-- ============ DIVIDER ============ -->
  <div class="sec-div"><span class="orn-line"></span><span class="orn-dots"><span></span><span></span><span></span></span><span class="orn-line"></span></div>

  <!-- ============ 3. STRUKTUR ORGANISASI ============ -->
  <section class="band-n"><div class="wrap">
    <div class="sec-head-n reveal">
      <span class="eyebrow">Struktur Organisasi</span>
      <h2>Organ Organisasi 2025&ndash;2030.</h2>
      <p class="lead">Tata kelola yang jelas untuk menjaga akuntabilitas dan kepercayaan publik.</p>
    </div>
    <div class="org-tiers reveal">
      <div class="tier" style="border-top:3px solid var(--gold-500)"><div class="role">Pembina</div><div class="people">S.P. Hendro Haryoko, S.Hut. <span>(Ketua)</span> &middot; Dadang Krisdianto, S.Sos., M.Si. &middot; Abu Kasan</div></div>
      <div class="tier" style="border-top:3px solid var(--brick-500)"><div class="role">Pengawas</div><div class="people">Dr. Yunus Handoko <span>(Ketua)</span> &middot; H. Johan Effendy</div></div>
      <div class="tier" style="border-top:3px solid var(--gold-500)"><div class="role">Ketua</div><div class="people">Dr. Ahmad Syaifudin, S.H., M.H.</div></div>
      <div class="tier" style="border-top:3px solid var(--brick-500)"><div class="role">Sekretaris &amp; Bendahara</div><div class="people">Bahroin Budiya, S.Pd., M.Pd.I <span>(Sekretaris)</span> &middot; Slamet Suryadi, S.H., CHFI <span>(Bendahara)</span></div></div>
    </div>
    <div class="fields reveal">
      <div class="f"><h4>Usaha &amp; Ekonomi</h4><p>Ernanto Djoko Purnomo</p></div>
      <div class="f"><h4>Penelitian, Pendidikan &amp; Pengabdian</h4><p>Dr. H. Akhdiyat Sabril Ulum, S.Kom., M.M.</p></div>
      <div class="f"><h4>Seni, Prestasi &amp; Budaya</h4><p>Totok Sutopo, S.E.</p></div>
      <div class="f"><h4>Umum, Humas &amp; Sarpras</h4><p>Agung Budi Herdianto, S.Hut.</p></div>
    </div>
  </div></section>

  <!-- ============ DIVIDER ============ -->
  <!-- <div class="sec-div sec-div-alt"><span class="orn-diamond"></span><span class="orn-line"></span><span class="orn-dots"><span></span><span></span><span></span></span><span class="orn-line"></span><span class="orn-diamond"></span></div> -->

  <!-- ============ 4. CTA ============ -->
  <!-- <section class="band-n band-photo" style="background-image:url('<?php echo e(img_setting('tentang_join_img', 'https://images.pexels.com/photos/6647054/pexels-photo-6647054.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap">
    <div class="cta-n reveal">
      <span class="eyebrow">Bergabung Bersama</span>
      <h2>Mari bergerak bersama membangun nusantara.</h2>
      <p>Terbuka bagi masyarakat, komunitas, profesional, pelajar, dan pelaku usaha untuk berkolaborasi dalam pendidikan, ekonomi, sosial, dan pelestarian budaya.</p>
      <div style="display:flex;gap:1rem;flex-wrap:wrap;justify-content:center;margin-top:1.6rem">
        <a wire:navigate class="btn btn-pill-gold" href="<?php echo e(route('kemitraan')); ?>">Ajukan Kemitraan <span class="btn-pill-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span></a>
        <a wire:navigate class="btn btn-oval-line" href="<?php echo e(route('program')); ?>">Lihat Program <span class="btn-ic-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="12" height="12"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span></a>
      </div>
    </div>
  </div></section> -->

</main>
@endsection
