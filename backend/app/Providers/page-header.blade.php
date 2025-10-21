@props([
    'title',
    'subtitle' => null,
    'icon' => null,
])

<div class="flex items-center justify-between pb-3 mb-6 border-b border-gray-200">
    <div class="flex items-center gap-3">
        @if ($icon)
            <x-dynamic-component :component="$icon" class="w-6 h-6 text-primary-600" />
        @endif

        <div>
            <h1 class="text-2xl font-semibold text-gray-800">{{ $title }}</h1>
            @if ($subtitle)
                <p class="text-sm text-gray-500">{{ $subtitle }}</p>
            @endif
        </div>
    </div>

    {{-- Slot opzionale per pulsanti aggiuntivi --}}
    <div>
        {{ $slot }}
    </div>
</div>