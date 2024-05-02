<!-- Управление словарем -->
@props(['dictionary', 'concepts'])

<x-layout.main>
    <x-slot:title>{{ $dictionary->name }}</x-slot:title>
    <x-slot name="navigation"></x-slot>
    <div class="flex flex-row px-4 mt-2">
        @include('components.dashboard.sidebar.sidebar')
        <section class="flex-grow-10 pl-4 pr-4 w-3/4">
            {{ $slot }}
        </section>
    </div>
</x-layout.main>
