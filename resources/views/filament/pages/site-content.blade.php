<x-filament-panels::page>
    <form wire:submit="save">
        <?php echo $this->form; ?>

        <div style="margin-top:1.5rem">
            <x-filament::button type="submit">Simpan Konten</x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
