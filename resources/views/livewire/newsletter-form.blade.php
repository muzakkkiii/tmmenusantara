<div>
@if($done)
    <div class="foot-news-ok"><?php echo e($okMessage); ?></div>
@else
    <form wire:submit.prevent="submit" class="foot-news-form" novalidate>
        <input type="text" wire:model="website" style="display:none" tabindex="-1" autocomplete="off">
        <input type="email" wire:model.blur="email" placeholder="Email Anda" required maxlength="160" autocomplete="email">
        <button type="submit" class="btn btn-gold" wire:loading.attr="disabled">
            <span wire:loading.remove>Langganan</span>
            <span wire:loading>&hellip;</span>
        </button>
    </form>
    @error('email') <span class="news-err"><?php echo e($message); ?></span> @enderror
@endif
</div>
