@props([
    'action',
    'method' => 'POST',
    'title' => null,
    'submitLabel' => '',
    'enctype' => null,
])

<form
    action="{{ $action }}"
    method="{{ in_array(strtoupper($method), ['GET', 'POST']) ? $method : 'POST' }}"
    @if($enctype) enctype="{{ $enctype }}" @endif
    class="space-y-8"
>
    @csrf
    @if(!in_array(strtoupper($method), ['GET', 'POST']))
        @method($method)
    @endif

    {{-- Titolo opzionale --}}
    {{-- @if($title)
        <h2 class="mb-4 text-2xl font-semibold text-foreground">{{ $title }}</h2>
    @endif --}}

    <div class="space-y-8">
        {{ $slot }}
    </div>

    {{-- Bottone di submit --}}
    {{-- <div class="flex justify-end pt-4">
        <button type="submit"
            class="px-6 py-2 font-medium text-white transition-colors rounded-lg shadow
                   bg-[#E65C4F] hover:bg-[#d44e41] focus:ring-2 focus:ring-offset-2 focus:ring-[#F4975B]">
            {{ $submitLabel }}
        </button>
    </div> --}}
</form>
