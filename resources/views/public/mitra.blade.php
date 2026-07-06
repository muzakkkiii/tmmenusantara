@extends('layouts.app')
@section('content')
<?php $jenis = ['Program', 'Sponsorship/CSR', 'Penyediaan SDM', 'Hukum & Perizinan', 'Lainnya']; ?>
<main id="pub">
<div class="page-hero" style="background-image:url('<?php echo e(img_setting('mitra_hero_img', 'https://images.pexels.com/photos/12885861/pexels-photo-12885861.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900')); ?>')"><div class="wrap"><span class="eyebrow"><?php echo txt('mitra_hero_eyebrow', 'Form Kemitraan'); ?></span><h1><?php echo txt('mitra_hero_title', 'Ajukan Kerja Sama'); ?></h1><p class="lead"><?php echo txt('mitra_hero_lead', 'Sampaikan minat kemitraan Anda. Tim kami akan menindaklanjuti melalui kontak yang diberikan.'); ?></p></div></div>
<div class="page-pad page-tint"><div class="wrap"><div class="ff-wrap"><div class="ff-card reveal">
@if(session('ok'))<div class="ff-ok"><?php echo e(session('ok')); ?></div>@endif
@if($errors->any())<div class="ff-err"><ul style="margin:0;padding-left:18px"><?php foreach($errors->all() as $e): ?><li><?php echo e($e); ?></li><?php endforeach; ?></ul></div>@endif
<form method="POST" action="<?php echo e(route('mitra.store')); ?>">
<?php echo csrf_field(); ?>
<input type="text" name="website" class="ff-hp" tabindex="-1" autocomplete="off">
<div class="ff-field"><label>Nama PIC <span style="color:#c00">*</span></label><input type="text" name="nama" value="<?php echo e(old('nama')); ?>" required></div>
<div class="ff-field"><label>Organisasi / Perusahaan</label><input type="text" name="organisasi" value="<?php echo e(old('organisasi')); ?>"></div>
<div class="ff-field"><label>Jenis Kemitraan</label><select name="jenis"><option value="">- Pilih -</option><?php foreach($jenis as $j): ?><option value="<?php echo e($j); ?>" <?php echo old('jenis') === $j ? 'selected' : ''; ?>><?php echo e($j); ?></option><?php endforeach; ?></select></div>
<div class="ff-field"><label>WhatsApp</label><input type="text" name="wa" value="<?php echo e(old('wa')); ?>" placeholder="08xxxxxxxxxx"></div>
<div class="ff-field"><label>Email</label><input type="email" name="email" value="<?php echo e(old('email')); ?>"></div>
<div class="ff-field"><label>Detail / Rencana Kerja Sama</label><textarea name="pesan" rows="5"><?php echo e(old('pesan')); ?></textarea></div>
<button type="submit" class="btn btn-gold" style="width:100%;border-radius:50px;padding:.8rem 1.5rem">Kirim Pengajuan</button>
</form>
</div></div></div></div>
</main>
@endsection
