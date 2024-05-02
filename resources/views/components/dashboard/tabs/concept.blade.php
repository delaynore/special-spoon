@props(['dictionary', 'concepts', 'concept'])

<x-layout.dashboard :dictionary="$dictionary" :concepts="$concepts">
    @include('components.dashboard.tabs.tabs')
    <div class="w-full">
        <p>{{ $concept->id }}</p>
        <h5 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white text-wrap break-words">{{$concept->name}}</h5>
        <p class="font-normal text-gray-700 dark:text-gray-400 text-wrap break-words">{!! $concept->definition !!}</p>
    </div>
</x-layout.dashboard>
