@props(['dictionary', 'concepts', 'concept'])

<x-layout.dashboard :dictionary="$dictionary" :concepts="$concepts">
    @include('components.dashboard.tabs.tabs')
    <div class="w-full p-2.5">
        <p>{{ $concept->id }}</p>
        <h5 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white text-wrap break-words">{{$concept->name}}</h5>
        <div class="block w-full min-h-12 text-sm p-2.5 text-gray-900 bg-gray-50 rounded-lg border border-gray-300  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{!! $concept->definition !!}</div>
    </div>
</x-layout.dashboard>
