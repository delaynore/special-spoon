<!-- Управление словарем -->
@props(['dictionary', 'concepts'])

<x-layout.main>
    <x-slot:title>{{ $dictionary->name }}</x-slot:title>
    <x-slot name="navigation"></x-slot>
    <div class="flex flex-row flex-grow mt-2">
        @include('components.dashboard.sidebar.sidebar')
        <section class="flex-grow px-4 w-3/4">
            {{ $slot }}
        </section>
    </div>
</x-layout.main>
