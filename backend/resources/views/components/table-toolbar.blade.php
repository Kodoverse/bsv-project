@props([
    'filters' => null,
    'actions' => null,
])

<div
    class="flex flex-col justify-between gap-4 mb-6 mx-8 sm:flex-row sm:items-center 
           bg-[#FDFBF8]/60 dark:bg-[#1A1B21]/60 
           border border-[#E8E3DD]/50 dark:border-[#2B2C31]/50 
           rounded-xl p-4 shadow-sm backdrop-blur-sm transition-all">

    {{-- Sezione filtri (sinistra) --}}
    <div class="flex flex-wrap items-center gap-3">
        {{ $filters }}
    </div>

    {{-- Sezione azioni (destra) --}}
    <div class="flex flex-wrap items-center justify-end gap-3">
        {{ $actions }}
    </div>
</div>