@props([
    'href' => '#',
])

<a href="{{ $href }}" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
    <x-application-logo class="w-8 h-8 mr-3 fill-current" />
    {{ env('APP_NAME') }}
</a>
