@props([
    'name' => null,
    'eyebrow' => '',
    'title' => '',
    'sub' => '',
    'label' => 'Dialog',
])
{{-- Reusable accessible modal shell. State/focus-trap handled by modal() in public/js/app.js.
     Open with: $dispatch(' $name ') / window event " $name ". --}}
<div class="kontak-modal" x-data="modal(@js($name))" @keydown.escape.window="close()" @keydown.tab="trap($event)" x-cloak>
  <div class="km-scrim" x-show="open" x-transition.opacity @click="close()"></div>
  <aside class="km-panel" x-show="open" x-ref="panel" tabindex="-1"
         x-transition:enter="km-enter" x-transition:enter-start="km-enter-start" x-transition:enter-end="km-enter-end"
         role="dialog" aria-modal="true" aria-label="{{ $label }}">
    <button type="button" class="km-close" @click="close()" aria-label="Tutup">&times;</button>
    @if($eyebrow)<span class="eyebrow">{{ $eyebrow }}</span>@endif
    @if($title)<h3 class="km-title">{{ $title }}</h3>@endif
    @if($sub)<p class="km-sub">{{ $sub }}</p>@endif
    {{ $slot }}
  </aside>
</div>
