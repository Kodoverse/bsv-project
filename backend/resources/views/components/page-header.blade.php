@props([
    'title',
    'subtitle' => null,
    'icon' => null,
])

<div class="flex items-center justify-center h-40 px-6 pb-3">
            <h1 class="text-4xl font-semibold text-foreground">{{ $title }}</h1>
            @if ($subtitle)
                <p class="text-sm text-gray-500">{{ $subtitle }}</p>
            @endif
    {{-- Slot opzionale per pulsanti aggiuntivi --}}
    <div>
        {{ $slot }}
    </div>
</div>