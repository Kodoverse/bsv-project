@props([
    'id' => null,
    'name' => null,
    'label' => 'Colore Categoria',
    'value' => '#E65C4F',
])

@php
    $initial = old($name, $value ?? '#E65C4F');
@endphp

<div x-data="{ color: '{{ $initial }}' }" class="flex flex-col space-y-1">
    {{-- Etichetta --}}
    @if($label)
        <label for="{{ $id }}" class="text-sm font-medium text-foreground/80">
            {{ $label }}
        </label>
    @endif

    {{-- Wrapper --}}
    <div class="relative flex items-center gap-3">
        {{-- Input colore nativo ma stilizzato --}}
        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="color"
            x-model="color"
            class="h-10 w-16 cursor-pointer rounded-md border border-border bg-surface shadow-sm
                   transition-all duration-200
                   hover:shadow-md hover:-translate-y-[1px]
                   focus:outline-none focus:ring-2 focus:ring-[#E65C4F]/50 focus:border-[#E65C4F]/60
                   dark:focus:ring-[#F4975B]/40 dark:focus:border-[#F4975B]/50
                   color-input-admin"
        />

        {{-- Valore HEX a fianco --}}
        <span
            class="px-3 py-2 text-xs font-mono tracking-wide rounded-md border border-border/70
                   bg-surface/90 dark:bg-[#17181d]/80 text-foreground/90 shadow-sm select-none"
            x-text="color.toUpperCase()"
        ></span>
    </div>

    {{-- Messaggi di errore --}}
    @if($name)
        <x-input-error :messages="$errors->get($name)" class="mt-1 text-sm text-[#E65C4F]" />
    @endif
</div>

@once
    @push('styles')
        <style>
            /* Personalizzazione input color */
            .color-input-admin::-webkit-color-swatch-wrapper {
                padding: 0;
            }
            .color-input-admin::-webkit-color-swatch {
                border-radius: 0.5rem;
                border: none;
            }
            .color-input-admin::-moz-color-swatch {
                border-radius: 0.5rem;
                border: none;
            }
        </style>
    @endpush
@endonce
