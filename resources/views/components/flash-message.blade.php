@props([
    'type' => 'success',
    'message' => null,
    'duration' => 4000,
])

@php
    $classes = match ($type) {
        'success'
            => 'bg-green-100 border-green-300 text-green-800 dark:bg-green-800 dark:border-green-700 dark:text-green-100',
        'warning'
            => 'bg-yellow-100 border-yellow-300 text-yellow-800 dark:bg-yellow-800 dark:border-yellow-700 dark:text-yellow-100',
        'info' => 'bg-blue-100 border-blue-300 text-blue-800 dark:bg-blue-800 dark:border-blue-700 dark:text-blue-100',
        'danger',
        'error'
            => 'bg-red-100 border-red-300 text-red-800 dark:bg-red-800 dark:border-red-700 dark:text-red-100',
        default
            => 'bg-gray-100 border-gray-300 text-gray-800 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100',
    };
@endphp

@if ($message)
    <div x-data="{
        show: true,
        close() {
            this.show = false;
    
            setTimeout(() => {
                this.$el.remove();
            }, 250);
        }
    }" x-init="setTimeout(() => close(), {{ $duration }})" x-show="show" x-transition.opacity.duration.200ms
        {{ $attributes->merge(['class' => "flex items-center justify-between gap-4 border px-4 py-3 rounded-md {$classes}"]) }}>
        <div class="text-sm font-medium">
            {{ $message }}
        </div>

        <button type="button" class="text-current opacity-70 hover:opacity-100" @click="close()" aria-label="Close">
            <span class="text-lg leading-none">&times;</span>
        </button>
    </div>
@endif
