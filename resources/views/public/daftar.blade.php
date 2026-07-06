@extends('layouts.app')
@section('content')
<?php $progs = config('donasi.progs', ['Umum']); ?>
<main id="pub">
<div class="page-hero" style="background-image:url('<?php echo e(img_setting('daftar_hero_img', 'https://images.pexels.com/photos/34046709/pexels-photo-34046709.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap"><span class="eyebrow"><?php echo txt('daftar_hero_eyebrow', 'Pendaftaran Peserta'); ?></span><h1><?php echo txt('daftar_hero_title', 'Daftar Program &amp; Pelatihan'); ?></h1><p class="lead"><?php echo txt('daftar_hero_lead', 'Isi formulir berikut untuk mendaftar sebagai peserta program yayasan.'); ?></p></div></div>
<div class="page-pad page-tint"><div class="wrap"><div class="ff-wrap"><div class="ff-card reveal">
@if(session('ok'))<div class="ff-ok"><?php echo e(session('ok')); ?></div>@endif
@if($errors->any())<div class="ff-err"><ul style="margin:0;padding-left:18px"><?php foreach($errors->all() as $e): ?><li><?php echo e($e); ?></li><?php endforeach; ?></ul></div>@endif
<form method="POST" action="<?php echo e(route('daftar.store')); ?>">
<?php echo csrf_field(); ?>
<input type="text" name="website" class="ff-hp" tabindex="-1" autocomplete="off">
<div class="ff-field"><label>Nama Lengkap <span style="color:#c00">*</span></label><input type="text" name="nama" value="<?php echo e(old('nama')); ?>" required></div>
<div class="ff-field"><label>Program</label><select name="program"><option value="">- Pilih Program -</option><?php foreach($progs as $p): ?><option value="<?php echo e($p); ?>" <?php echo old('program') === $p ? 'selected' : ''; ?>><?php echo e($p); ?></option><?php endforeach; ?></select></div>
<div class="ff-field"><label>WhatsApp</label><input type="text" name="wa" value="<?php echo e(old('wa')); ?>" placeholder="08xxxxxxxxxx"></div>
<div class="ff-field"><label>Email</label><input type="email" name="email" value="<?php echo e(old('email')); ?>"></div>
<div class="ff-field"><label>Asal Sekolah / Instansi</label><input type="text" name="asal" value="<?php echo e(old('asal')); ?>"></div>
<div class="ff-field"><label>Catatan</label><textarea name="catatan" rows="4"><?php echo e(old('catatan')); ?></textarea></div>
<button type="submit" class="btn btn-gold" style="width:100%;border-radius:50px;padding:.8rem 1.5rem">Daftar Sekarang</button>
</form>
</div></div></div></div>
</main>
@endsection
