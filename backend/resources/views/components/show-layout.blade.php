@props([
    'title' => null,
    'subtitle' => null,
    'image' => null,
    'actions' => null,
    'fallback' => asset('images/fallback.png'),
])

<div class="w-full max-w-6xl p-8 mx-auto space-y-10">
    {{-- HEADER --}}

    <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
        <div>
            <h1 class="text-3xl font-semibold text-foreground">{{ $title }}</h1>
            @if($subtitle)
                <p class="text-sm text-muted">{{ $subtitle }}</p>
            @endif
        </div>
    
    {{-- AZIONI --}}
        @if($actions)
            <div class="flex gap-3">
                {{ $actions }}
            </div>
        @endif
    </div>
        <x-widget-group :widgets="[
    ['label' => 'Eventi Associati', 'value' => 27, 'variant' => 'accent'],
    ['label' => 'Categoria Principale', 'value' => 'Cultura', 'variant' => 'default'],
    ['label' => 'Partecipazioni Mensili', 'value' => 46, 'variant' => 'success'],
    ['label' => 'Rewards Totali', 'value' => 386, 'variant' => 'warning'],
    ]" />
    {{-- CONTENUTO PRINCIPALE --}}
    <div class="grid items-start grid-cols-1 gap-10 lg:grid-cols-2">
        {{-- SINISTRA: immagine o fallback --}}
        <div
            class="overflow-hidden rounded-2xl shadow-md border border-border/50 bg-surface dark:bg-[#15161b] flex items-center justify-center ">
            <img 
                src="{{ $image ? asset($image) :  asset($fallback) }}"
                alt="{{ $title }}"
                class="object-cover w-full h-full transition-transform duration-500 hover:scale-105 rounded-2xl">
        </div>

        {{-- DESTRA: contenuto dinamico --}}
        <div
            class="p-6 rounded-2xl bg-surface dark:bg-[#16171C] border border-border/50 shadow-[0_4px_15px_rgba(0,0,0,0.08)] space-y-4">
            {{ $slot }}
        </div>
    </div>

    {{-- BOTTOM --}}
    @if (isset($bottom))
        <div class="space-y-6">
            {{ $bottom }}
        </div>
    @endif
</div>
