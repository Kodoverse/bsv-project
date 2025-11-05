@props([
    'title' => null,
    'columns' => 2, // numero di colonne
])

<section class="p-4 border border-border rounded-xl bg-surface/50 dark:bg-[#1b1d23]/60">
    @if($title)
        <h3 class="mb-4 text-lg font-semibold text-[#E65C4F] dark:text-[#F4975B]">
            {{ $title }}
        </h3>
    @endif

    <div class="grid gap-6 md:grid-cols-{{ $columns }}">
        {{ $slot }}
    </div>
</section>
