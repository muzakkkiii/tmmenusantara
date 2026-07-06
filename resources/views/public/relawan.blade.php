@extends('layouts.app')
@section('content')
<?php $peranOpt = ['Relawan', 'Anggota']; ?>
<main id="pub">
<div class="page-hero" style="background-image:url('<?php echo e(img_setting('relawan_hero_img', 'https://images.pexels.com/photos/6647054/pexels-photo-6647054.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap"><span class="eyebrow"><?php echo txt('relawan_hero_eyebrow', 'Anggota &amp; Relawan'); ?></span><h1><?php echo txt('relawan_hero_title', 'Gabung Bersama Kami'); ?></h1><p class="lead"><?php echo txt('relawan_hero_lead', 'Jadilah bagian dari gerakan. Daftar sebagai anggota atau relawan yayasan.'); ?></p></div></div>
<div class="page-pad page-tint"><div class="wrap"><div class="ff-wrap"><div class="ff-card reveal">
@if(session('ok'))<div class="ff-ok"><?php echo e(session('ok')); ?></div>@endif
@if($errors->any())<div class="ff-err"><ul style="margin:0;padding-left:18px"><?php foreach($errors->all() as $e): ?><li><?php echo e($e); ?></li><?php endforeach; ?></ul></div>@endif
<form method="POST" action="<?php echo e(route('relawan.store')); ?>">
<?php echo csrf_field(); ?>
<input type="text" name="website" class="ff-hp" tabindex="-1" autocomplete="off">
<div class="ff-field"><label>Nama Lengkap <span style="color:#c00">*</span></label><input type="text" name="nama" value="<?php echo e(old('nama')); ?>" required></div>
<div class="ff-field"><label>Ingin bergabung sebagai</label><select name="peran"><?php foreach($peranOpt as $p): ?><option value="<?php echo e($p); ?>" <?php echo old('peran') === $p ? 'selected' : ''; ?>><?php echo e($p); ?></option><?php endforeach; ?></select></div>
<div class="ff-field"><label>Bidang / Minat</label><input type="text" name="bidang" value="<?php echo e(old('bidang')); ?>" placeholder="mis. Pendidikan, Dokumentasi, Seni Budaya"></div>
<div class="ff-field"><label>WhatsApp</label><input type="text" name="wa" value="<?php echo e(old('wa')); ?>" placeholder="08xxxxxxxxxx"></div>
<div class="ff-field"><label>Email</label><input type="email" name="email" value="<?php echo e(old('email')); ?>"></div>
<div class="ff-field"><label>Alamat</label><textarea name="alamat" rows="3"><?php echo e(old('alamat')); ?></textarea></div>
<button type="submit" class="btn btn-gold" style="width:100%;border-radius:50px;padding:.8rem 1.5rem">Gabung Sekarang</button>
</form>
</div></div></div></div>
</main>
@endsection
