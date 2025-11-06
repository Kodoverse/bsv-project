<x-admin-layout title="Gestione Categorie Eventi">

{{-- <x-widget-group :widgets="[
    ['label' => 'Eventi Associati', 'value' => 27, 'variant' => 'accent'],
    ['label' => 'Categoria Principale', 'value' => 'Cultura', 'variant' => 'default'],
    ['label' => 'Partecipazioni Mensili', 'value' => 46, 'variant' => 'success'],
    ['label' => 'Rewards Totali', 'value' => 386, 'variant' => 'warning'],
]" /> --}}

<div class="grid grid-cols-1 gap-12 p-8 lg:gap-32 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 2xl:gap-">
        @forelse ($eventCategories as $eventCategory)
<a href="{{ route('admin.event-categories.show', $eventCategory->id) }}"
   class="flex flex-col items-center justify-start py-2 overflow-hidden transition-transform duration-300 border shadow-md cursor-pointer aspect-square rounded-2xl bg-background border-border hover:shadow-lg hover:scale-105 group">
    
    {{-- Immagine --}}
    <div class="relative h-full overflow-hidden w-7/8 rounded-xl">
        <img   src="{{ asset('images/cinema-card-light.svg') }}"  
             alt="{{ $eventCategory->name }}"
             class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105">
             <img   src="{{ asset('images/cinema-card-dark.svg') }}"  
             alt="{{ $eventCategory->name }}"
             class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105">
        <div class="absolute inset-0 transition-colors duration-300"></div>
    </div>

    {{-- Titolo sotto l'immagine --}}
    <h2 class="mt-4 text-lg font-semibold text-center text-foreground">
        {{ $eventCategory->name }}
    </h2>
</a>
        @empty
            <p class="text-center col-span-full text-muted-foreground">
                Nessuna categoria disponibile.
            </p>
        @endforelse
    </div>

    {{-- Paginazione --}}
    <div class="flex justify-center mt-10">
        {{ $eventCategories->links('pagination::tailwind') }}
    </div>

</x-admin-layout>
