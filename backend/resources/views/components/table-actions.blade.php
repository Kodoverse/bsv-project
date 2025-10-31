<div class="flex justify-center gap-3">
    {{-- Visualizza --}}
    <a href="{{ route('admin.events.show', $event->id) }}"
        class="flex items-center justify-center transition-all duration-200 rounded-full w-9 h-9 text-accent-orange hover:bg-accent-orange/10 hover:scale-105 dark:hover:bg-accent-orange/20"
        title="Visualizza">
        <i class="fa fa-eye text-[17px]"></i>
    </a>

    {{-- Modifica --}}
    <a href="{{ route('admin.events.edit', $event->id) }}"
        class="flex items-center justify-center transition-all duration-200 rounded-full w-9 h-9 text-accent-yellow hover:bg-accent-yellow/10 hover:scale-105 dark:hover:bg-accent-yellow/20"
        title="Modifica">
        <i class="fa fa-pen text-[15px]"></i>
    </a>

    {{-- Elimina --}}
    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="inline">
        @csrf
        @method('DELETE')
        <button type="submit"
            onclick="return confirm('Eliminare questo evento?')"
            class="flex items-center justify-center transition-all duration-200 rounded-full w-9 h-9 text-accent-red hover:bg-accent-red/10 hover:scale-105 dark:hover:bg-accent-red/20"
            title="Elimina">
            <i class="fa fa-trash text-[16px]"></i>
        </button>
    </form>
</div>
