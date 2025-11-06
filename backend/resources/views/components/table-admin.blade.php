@props([
    'columns' => [], // es: ['title' => 'Titolo', 'description' => 'Descrizione', 'is_volunteer_event' => 'Evento Volontario']
    'rows' => [],
    'actions' => false,
])

@php
    $gridColumns = count($columns) + ($actions ? 1 : 0);
    $gridTemplateStyle = "grid-template-columns: repeat({$gridColumns}, minmax(0, 1fr));";
@endphp

<div
    class="w-full mx-auto overflow-hidden rounded-xl shadow-[0_5px_15px_rgba(0,0,0,0.35)]
    bg-surface text-foreground dark:bg-[#16171C]">
    
    <div class="hidden lg:grid text-sm font-semibold tracking-wide border-b
        border-[#E8E3DD] dark:border-[#2B2C31]
        bg-gradient-to-r from-white/80 via-white/60 to-[#FFF8F4]
        dark:from-[#23252b] dark:via-[#1a1c22] dark:to-[#1a1c22]
        text-[#E65C4F] dark:text-[#F4975B]"
        style="{{ $gridTemplateStyle }}" role="row">
        @foreach ($columns as $label)
            <div class="px-6 py-4">{{ $label }}</div>
        @endforeach
        @if ($actions)
            <div class="px-6 py-4 text-center">Azioni</div>
        @endif
    </div>

    {{-- Rows --}}
    <div class="overflow-y-auto max-h-[610px] scroll-pb-6 custom-scrollbar">
        @forelse ($rows as $row)
            <div class="flex flex-col gap-3 transition-all duration-200 lg:grid lg:gap-0
                odd:bg-[#FDFBF8] even:bg-[#F7F5F2]
                dark:odd:bg-[#1A1B21] dark:even:bg-[#202127]
                hover:bg-[#FFF6F4]/90 dark:hover:bg-[#25262D]/80 hover:shadow-sm"
                style="{{ $gridTemplateStyle }}" role="row">
                @foreach ($columns as $key => $label)
                    <div class="px-6 py-5 text-[15px] text-foreground lg:truncate" role="cell">
                        <span class="block mb-1 text-[11px] font-semibold tracking-wide text-muted lg:hidden">
                            {{ $label }}
                        </span>

                        @php
                            $value = $row->$key;
                            $isBooleanLike = in_array($value, [0, 1, '0', '1'], true) || is_bool($value);
                        @endphp

                        <div>
                            @if ($isBooleanLike)
                                <span class="{{ (bool) $value
                                        ? 'bg-[#F8E8C2] text-[#8B5D00] dark:bg-[#3B2C0B] dark:text-[#FFD579]'
                                        : 'bg-[#F5C8C4] text-[#782C28] dark:bg-[#3C1E1C] dark:text-[#FF8B7F]' }}
                                        px-3 py-[5px] rounded-full text-xs font-semibold tracking-wide shadow-inner">
                                    {{ (bool) $value ? 'Sì' : 'No' }}
                                </span>
                            @else
                                {{ $value }}
                            @endif
                        </div>
                    </div>
                @endforeach

                @if ($actions)
    <div class="flex items-center justify-center px-6 py-5 text-sm text-center lg:py-4 lg:px-6"
        role="cell">
        <span class="block mb-1 text-[11px] font-semibold tracking-wide uppercase text-muted lg:hidden">
            Azioni
        </span>
        {!! $actions($row) !!}
    </div>
@endif
            </div>
        @empty
            <div class="p-8 text-sm text-center text-muted bg-surface dark:bg-[#1b1d23]/80">
                Nessun dato disponibile
            </div>
        @endforelse
    </div>

{{-- Stile opzionale per scrollbar personalizzata --}}
<style>
.custom-scrollbar {
  scrollbar-gutter: stable;
  scrollbar-width: thin;
  scrollbar-color: transparent transparent;
  transition: scrollbar-color 0.2s ease;
}
@supports not (scrollbar-gutter: stable) {
  .custom-scrollbar {
    padding-right: 6px;
  }
}
.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: transparent;
  border-radius: 4px;
  transition: background-color 0.2s ease;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background-color: transparent;
}
.custom-scrollbar:hover {
  scrollbar-color: rgba(100, 100, 100, 0.3) transparent;
}
.custom-scrollbar:hover::-webkit-scrollbar-thumb {
  background-color: rgba(100, 100, 100, 0.5);
}
</style>
