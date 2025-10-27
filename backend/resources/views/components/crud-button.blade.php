@props([
    'type' => 'edit',
    'href' => null, // edit, delete, confirm
    'label' =>null,
])

@php
    $buttons = [
        'edit' => [
            'color' => 'rgb(220,125, 10)',
            'shadow' => 'rgb(220,125,10)',
            'label' => 'Modifica',
            'icon' =>
                '<svg class="svg" viewBox="0 0 512 512"><path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path></svg>',
        ],
        'delete' => [
            'color' => 'rgb(220, 38, 38)',
            'shadow' => 'rgb(180, 32, 32)',
            'label' => 'Elimina',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg">
  <path fill="white" d="M135.2 17.7C138.4 7.4 147.7 0 158.4 0H289.6c10.7 0 20 7.4 23.2 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32h-16v352c0 35.3-28.7 64-64 64H112c-35.3 0-64-28.7-64-64V96H32C14.3 96 0 81.7 0 64s14.3-32 32-32h96l7.2-14.3zM128 96v352h192V96H128zm64 64c8.8 0 16 7.2 16 16v192c0 8.8-7.2 16-16 16s-16-7.2-16-16V176c0-8.8 7.2-16 16-16zm64 0c8.8 0 16 7.2 16 16v192c0 8.8-7.2 16-16 16s-16-7.2-16-16V176c0-8.8 7.2-16 16-16z"/>
</svg>',
        ],
        'confirm' => [
            'color' => 'rgb(34, 197, 94)',
            'shadow' => 'rgb(22, 155, 72)',
            'label' => 'Conferma',
            'icon' =>
                '<svg class="svg" viewBox="0 0 512 512"><path d="M173.898 439.404l-166.4-166.4c-12.497-12.497-12.497-32.758 0-45.255l22.627-22.627c12.497-12.497 32.758-12.497 45.255 0L192 312.69 436.12 68.574c12.497-12.497 32.758-12.497 45.255 0l22.627 22.627c12.497 12.497 12.497 32.758 0 45.255L211.153 439.404c-12.497 12.497-32.758 12.497-45.255 0z"></path></svg>',
        ],
    ];
    $type = (string) $type;
    $btn = $buttons[$type] ?? $buttons['edit'];

   $finalLabel = $label ?? $btn['label'];
@endphp

<button class="btn" style="background-color: {{ $btn['color'] }}; box-shadow: 5px 5px 0px {{ $btn['shadow'] }};">
    {!! $finalLabel !!}
    {!! $btn['icon'] !!}
</button>
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
