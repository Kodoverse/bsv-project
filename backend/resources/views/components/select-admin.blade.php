@props([
    'options' => [],
    'id' => null,
    'name' => null,
    'placeholder' => null,
    'label' => ' ',
    'value' => null,
    'highlight' => false,
])

<div class="flex flex-col space-y-1">
    <label for="{{ $id }}" class="text-sm font-medium text-foreground/80">{{ $label }}</label>

    <select name="{{ $name }}" id="{{ $id }}"
        {{ $attributes->merge([
            'class' => 'w-full rounded-md border border-gray-200 border-border bg-surface text-foreground placeholder:text-muted px-3 py-2 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[#E65C4F]/50 focus:border-[#E65C4F]/50 dark:focus:ring-[#F4975B]/40 dark:focus:border-[#F4975B]/40',
        ])->class([
            'ring-2 ring-[#E65C4F]/40 border-[#E65C4F]/40 shadow-[0_0_8px_rgba(230,92,79,0.3)] dark:ring-[#F4975B]/30 dark:border-[#F4975B]/30 dark:shadow-[0_0_6px_rgba(244,151,91,0.25)]' => $highlight,
        ]) }}>
        @if (isset($placeholder))
            <option value="" disabled {{ !$value ? 'selected' : '' }} class="border border-gray-300 text-foreground/60 ">
                {{ $placeholder }}
            </option>
        @endif
        @foreach ($options as $option)
            <option value="{{ $option->id }}" {{ (string) $option->id === (string) $value ? 'selected' : '' }}
                @if(!empty($option->disabled)) disabled @endif
            >
                {{ $option->name }}
            </option>
        @endforeach
    </select>
</div>
