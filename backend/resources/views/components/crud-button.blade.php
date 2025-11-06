@props([
    'type' => 'edit',
    'href' => null, // edit, delete, confirm
    'label' =>null,
])

@php
    $buttons = [
        'edit' => [
            'color' => '#F28A4A',
            'shadow' => '#d67130',
            'label' => 'Modifica',
            'icon' => '<svg class="svg" viewBox="0 0 512 512"><path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231z"/></svg>',
        ],
        'delete' => [
            'color' => '#E65C4F',
            'shadow' => '#C04A3E',
            'label' => 'Elimina',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg"><path d="M135.2 17.7C138.4 7.4 147.7 0 158.4 0H289.6c10.7 0 20 7.4 23.2 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32h-16v352c0 35.3-28.7 64-64 64H112c-35.3 0-64-28.7-64-64V96H32C14.3 96 0 81.7 0 64s14.3-32 32-32h96l7.2-14.3z"/></svg>',
        ],
        'confirm' => [
            'color' => '#22C55E',
            'shadow' => '#179245',
            'label' => 'Conferma',
            'icon' => '<svg class="svg" viewBox="0 0 512 512"><path d="M173.9 439.4l-166.4-166.4c-12.5-12.5-12.5-32.8 0-45.3l22.6-22.6c12.5-12.5 32.8-12.5 45.3 0L192 312.7 436.1 68.6c12.5-12.5 32.8-12.5 45.3 0l22.6 22.6c12.5 12.5 12.5 32.8 0 45.3L211.2 439.4c-12.5 12.5-32.8 12.5-45.3 0z"/></svg>',
        ],
        'add' => [
            'color' => '#F8C145',
            'shadow' => '#E5A12D',
            'label' => 'Aggiungi',
            'icon' => '<svg class="svg" viewBox="0 0 512 512"><path d="M256 112c17.7 0 32 14.3 32 32v80h80c17.7 0 32 14.3 32 32s-14.3 32-32 32h-80v80c0 17.7-14.3 32-32 32s-32-14.3-32-32v-80h-80c-17.7 0-32-14.3-32-32s14.3-32 32-32h80v-80c0-17.7 14.3-32 32-32z"/></svg>',
        ],
    ];
    $type = (string) $type;
    $btn = $buttons[$type] ?? $buttons['edit'];

   $finalLabel = $label ?? $btn['label'];
@endphp


@if ($href)
    {{-- LINK --}}
    <a href="{{ $href }}"
       {{ $attributes->merge(['class' => 'btn inline-flex items-center justify-center']) }}
       style="background-color: {{ $btn['color'] }}; box-shadow: 4px 4px 0 {{ $btn['shadow'] }};">
        {!! $finalLabel !!}
        {!! $btn['icon'] !!}
    </a>
@else
    {{-- BUTTON --}}
    @php
        // se è usato dentro una modale di conferma, il tipo deve essere 'button'
        $type = $attributes->has('data-confirm') ? 'button' : 'submit';
    @endphp

    <button type="{{ $type }}"
        {{ $attributes->merge(['class' => 'btn inline-flex items-center justify-center']) }}
        style="background-color: {{ $btn['color'] }}; box-shadow: 4px 4px 0 {{ $btn['shadow'] }};">
        {!! $finalLabel !!}
        {!! $btn['icon'] !!}
    </button>
@endif

<style>
    .btn {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        width: 130px;
        height: 40px;
        border: none;
        padding: 0px 20px;
        color: white;
        font-weight: 500;
        cursor: pointer;
        border-radius: 10px;
        transition-duration: .3s;
    }

    .svg {
        width: 13px;
        position: absolute;
        right: 0;
        margin-right: 20px;
        fill: white;
        transition-duration: .3s;
    }

    .btn:hover {
        color: transparent;
    }

    .btn:hover .svg {
        right: 43%;
        margin: 0;
        padding: 0;
        transition-duration: .3s;
    }

    .btn:active {
        transform: translate(3px, 3px);
        transition-duration: .3s;
    }
</style>
