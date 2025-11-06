@props([
    'model' => null, // es: $event
    'routes' => [
        'show' => null,
        'edit' => null,
        'delete' => null,
    ],
    'size' => '9', // puoi cambiare la dimensione (es. 8, 10, 12)
])

<div class="flex justify-center gap-3">
    {{-- Visualizza --}}
    @if ($routes['show'])
        <a href="{{ $routes['show'] }}"
            class="flex items-center justify-center transition-all duration-200 rounded-full w-{{ $size }} h-{{ $size }}
                   text-accent-orange hover:bg-accent-orange/10 hover:scale-105 dark:hover:bg-accent-orange/20"
            title="Visualizza">
            <i class="fa fa-eye text-[17px]"></i>
        </a>
    @endif

    {{-- Modifica --}}
    @if ($routes['edit'])
        <a href="{{ $routes['edit'] }}"
            class="flex items-center justify-center transition-all duration-200 rounded-full w-{{ $size }} h-{{ $size }}
                   text-accent-yellow hover:bg-accent-yellow/10 hover:scale-105 dark:hover:bg-accent-yellow/20"
            title="Modifica">
            <i class="fa fa-pen text-[15px]"></i>
        </a>
    @endif

    {{-- Elimina --}}
    @if ($routes['delete'])
        <form action="{{ $routes['delete'] }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                onclick="return confirm('Eliminare questo elemento?')"
                class="flex items-center justify-center transition-all duration-200 rounded-full w-{{ $size }} h-{{ $size }}
                       text-accent-red hover:bg-accent-red/10 hover:scale-105 dark:hover:bg-accent-red/20"
                title="Elimina">
                <i class="fa fa-trash text-[16px]"></i>
            </button>
        </form>
    @endif
</div>