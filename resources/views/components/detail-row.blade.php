@props(['label', 'value'])

<div class="flex flex-col justify-between sm:flex-row sm:items-center pb-2">
    <span class="text-sm font-medium min-w-[120px]">
        {{ $label }}
    </span>
    <span class="text-sm mt-1 sm:mt-0">
        {{ $value }}
    </span>
</div>
