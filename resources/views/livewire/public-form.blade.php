<div>
@if($done)
    <div class="form-ok-card">
        <span class="fo-ic">&#10003;</span>
        <p><?php echo e($okMessage); ?></p>
        @if($waUrl)
        <a href="<?php echo e($waUrl); ?>" target="_blank" rel="noopener" class="btn btn-gold btn-block">Lanjut ke WhatsApp &rarr;</a>
        @endif
        <button type="button" wire:click="resetForm" class="btn btn-line btn-block" style="margin-top:.6rem">Kirim lagi</button>
    </div>
@else
    <form wire:submit.prevent="submit" novalidate>
        <input type="text" wire:model="website" class="km-hp" tabindex="-1" autocomplete="off" aria-hidden="true">

        <div class="field">
            <label for="pf_nama">Nama<span class="req">*</span></label>
            <input id="pf_nama" wire:model.blur="nama" placeholder="Nama Anda" maxlength="120" autocomplete="name" aria-required="true" <?php if($errors->has('nama')): ?>aria-invalid="true"<?php endif; ?>>
            @error('nama') <span class="err" role="alert"><?php echo e($message); ?></span> @enderror
        </div>

        @if($type === 'mitra')
        <div class="field">
            <label>Organisasi / Lembaga <span class="opt">(opsional)</span></label>
            <input wire:model="organisasi" placeholder="Nama organisasi Anda">
        </div>
        <div class="field">
            <label>Jenis Kerja Sama</label>
            <select wire:model="jenis">
                <option value="">&mdash; Pilih &mdash;</option>
                @foreach($jenisOptions as $o)<option value="<?php echo e($o); ?>"><?php echo e($o); ?></option>@endforeach
            </select>
        </div>
        @endif

        @if($type === 'relawan')
        <div class="field">
            <label>Peran</label>
            <select wire:model="peran">
                @foreach($peranOptions as $o)<option value="<?php echo e($o); ?>"><?php echo e($o); ?></option>@endforeach
            </select>
        </div>
        <div class="field">
            <label>Bidang Minat <span class="opt">(opsional)</span></label>
            <input wire:model="bidang" placeholder="mis. Pendidikan, Sosial, Seni Budaya">
        </div>
        @endif

        @if($type === 'daftar')
        <div class="field">
            <label>Program</label>
            <select wire:model="program">
                <option value="">&mdash; Pilih program &mdash;</option>
                @foreach($progOptions as $o)<option value="<?php echo e($o); ?>"><?php echo e($o); ?></option>@endforeach
            </select>
        </div>
        @endif

        <div class="field">
            <label for="pf_wa">WhatsApp<?php if($type === 'kontak'): ?><span class="req">*</span><?php endif; ?></label>
            <input id="pf_wa" wire:model.blur="wa" inputmode="tel" placeholder="08xxxxxxxxxx" maxlength="20" autocomplete="tel" <?php if($type === 'kontak'): ?>aria-required="true"<?php endif; ?> <?php if($errors->has('wa')): ?>aria-invalid="true"<?php endif; ?>>
            @error('wa') <span class="err" role="alert"><?php echo e($message); ?></span> @enderror
        </div>

        <div class="field">
            <label for="pf_email">Email <span class="opt">(opsional)</span></label>
            <input id="pf_email" wire:model.blur="email" type="email" placeholder="email@contoh.com" maxlength="120" autocomplete="email" <?php if($errors->has('email')): ?>aria-invalid="true"<?php endif; ?>>
            @error('email') <span class="err" role="alert"><?php echo e($message); ?></span> @enderror
        </div>

        @if($type === 'relawan')
        <div class="field">
            <label>Alamat / Domisili <span class="opt">(opsional)</span></label>
            <input wire:model="alamat" placeholder="Kota / kabupaten">
        </div>
        @endif

        @if($type === 'daftar')
        <div class="field">
            <label>Asal / Instansi <span class="opt">(opsional)</span></label>
            <input wire:model="asal" placeholder="Sekolah / komunitas / instansi">
        </div>
        <div class="field">
            <label>Catatan <span class="opt">(opsional)</span></label>
            <textarea wire:model="catatan" rows="2" placeholder="Catatan tambahan"></textarea>
        </div>
        @endif

        @if($type === 'kontak' || $type === 'mitra')
        <div class="field">
            <label for="pf_pesan"><?php if($type === 'kontak'): ?>Pesan<span class="req">*</span><?php else: ?>Detail Kebutuhan <span class="opt">(opsional)</span><?php endif; ?></label>
            <textarea id="pf_pesan" wire:model.blur="pesan" rows="3" maxlength="3000" placeholder="Tuliskan pesan Anda..." <?php if($type === 'kontak'): ?>aria-required="true"<?php endif; ?>></textarea>
            @error('pesan') <span class="err" role="alert"><?php echo e($message); ?></span> @enderror
        </div>
        @endif

        <button type="submit" class="btn btn-gold btn-block" wire:loading.attr="disabled" wire:target="submit">
            <span wire:loading.remove wire:target="submit"><?php echo e($submitLabel); ?></span>
            <span wire:loading wire:target="submit">Mengirim&hellip;</span>
        </button>
    </form>
@endif
</div>
