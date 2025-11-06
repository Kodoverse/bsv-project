@props([
    'title' => 'Conferma operazione',
    'message' => 'Sei sicuro di voler procedere?',
    'confirmText' => 'Conferma',
    'cancelText' => 'Annulla',
    'confirmAction' => null, // es. route('admin.events.destroy', $event)
])

<div x-data="{ open: false }" x-cloak>
    {{-- Trigger --}}
    <button type="button"
        @click="open = true"
        {{ $attributes->merge(['class' => '']) }}>
        {{ $slot }}
    </button>

    {{-- Overlay --}}
    <div x-show="open" 
         x-transition.opacity
         class="fixed inset-0 z-40 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        
        {{-- Modale --}}
        <div x-show="open" 
             x-transition
             @click.away="open = false"
             class="relative w-[90%] max-w-md p-6 bg-background border border-border rounded-2xl shadow-lg">

            {{-- Titolo --}}
            <h2 class="mb-3 text-lg font-semibold text-foreground">
                {{ $title }}
            </h2>

            {{-- Messaggio --}}
            <p class="mb-6 text-sm text-muted-foreground">
                {{ $message }}
            </p>

            {{-- Bottoni --}}
            <div class="flex justify-end gap-3">
                <button @click="open = false"
                    class="px-4 py-2 text-sm font-medium transition rounded-md bg-muted hover:bg-muted/70">
                    {{ $cancelText }}
                </button>

                <form method="POST" action="{{ $confirmAction }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 text-sm font-semibold text-white transition rounded-md bg-accent-orange hover:bg-accent-orange/90">
                        {{ $confirmText }}
                    </button>
                </form>
            </div>

            {{-- Chiudi (icona in alto a destra) --}}
            <button @click="open = false"
                class="absolute transition top-3 right-3 text-muted-foreground hover:text-foreground">
                <i class="text-sm fa fa-times"></i>
            </button>
        </div>
    </div>
</div>
