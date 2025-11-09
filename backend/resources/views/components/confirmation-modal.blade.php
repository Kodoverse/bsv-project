@props([
    'open' => false,
    'type' => 'confirm', // confirm | info | error | warning
])

<div x-data="{ open: @js($open) }" x-cloak>
    {{-- Trigger --}}
    <div @click="open = true">
        {{ $trigger ?? $slot }}
    </div>

    {{-- Overlay --}}
    <div
        x-show="open"
        x-transition.opacity
        class="fixed inset-0 z-40 flex items-center justify-center bg-black/50 backdrop-blur-sm"
        aria-modal="true"
        role="dialog"
    >
        {{-- Dialog --}}
        <div
            x-show="open"
            x-transition
            @click.away="open = false"
            class="relative w-[90%] max-w-md bg-background border border-border rounded-2xl shadow-xl overflow-hidden"
        >
            {{-- HEADER --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-border/60 bg-background/60">
                {{ $header ?? '' }}
                <button
                    @click="open = false"
                    class="transition text-muted-foreground hover:text-foreground"
                    aria-label="Chiudi modale"
                >
                    <i class="text-sm fa fa-times"></i>
                </button>
            </div>

            {{-- BODY --}}
            <div class="p-6 space-y-4">
                {{ $body ?? '' }}
            </div>

            {{-- FOOTER --}}
            <div class="flex justify-end gap-3 px-6 py-4 border-t border-border/60 bg-background/60">
                {{ $footer ?? '' }}
            </div>
        </div>
    </div>
</div>

