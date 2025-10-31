@props([
    'breadcrumbs' => [], // ['Dashboard' => route('admin.dashboard'), 'Eventi' => route('admin.events.index'), 'Registrazioni' => null]
    'backUrl' => null,   // se non passato, torna automaticamente alla pagina precedente
])

@php
    // Se non specificato, torna indietro con history.back()
    $backAction = $backUrl ? "window.location.href='{$backUrl}'" : "history.back()";
@endphp

<div
    class="w-full flex items-center justify-between px-10 py-3 text-sm
           text-zinc-700 dark:text-zinc-300
           sticky top-[80px] z-20">

    {{-- SINISTRA: Pulsante Torna Indietro --}}
<button onclick="{{ $backAction }}"
    class="inline-flex items-center gap-2 px-3 py-[6px] text-sm font-medium rounded-md whitespace-nowrap
           text-[#E65C4F] dark:text-[#F28A4A] hover:text-[#E65C4F] dark:hover:text-[#F28A4A]
           transition-all duration-200">
    <i class="text-xs fa fa-arrow-left"></i>
    <span>Torna indietro</span>
</button>

    {{-- DESTRA: Breadcrumbs --}}
    <nav class="flex items-center gap-1 text-sm select-none">
        @foreach ($breadcrumbs as $label => $url)
            @if ($loop->last || !$url)
                <span class="font-semibold text-[#E65C4F] dark:text-[#F28A4A]">{{ $label }}</span>
            @else
                <a href="{{ $url }}"
                   class="hover:underline hover:text-[#E65C4F] dark:hover:text-[#F28A4A]">
                    {{ $label }}
                </a>
                <span class="text-zinc-400 dark:text-zinc-500">/</span>
            @endif
        @endforeach
    </nav>
</div>
