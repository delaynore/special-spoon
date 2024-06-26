<!-- Управление словарем -->
@props(['dictionary', 'concepts'])

<x-layout.main>
    <x-slot:title>{{ $dictionary->name }}</x-slot:title>
    <x-slot name="navigation"></x-slot>
    <div class="flex flex-row flex-grow">
        @include('components.dashboard.sidebar.sidebar')
        <section class="flex-grow w-3/4 px-4">
            {{ $slot }}
        </section>
    </div>
</x-layout.main>
