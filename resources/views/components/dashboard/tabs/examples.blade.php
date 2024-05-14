@props(['dictionary', 'concepts', 'examples'])

<x-layout.dashboard :dictionary="$dictionary" :concepts="$concepts">
    @include('components.dashboard.tabs.tabs')
    <div class="w-full overflow-hidden mt-2">
        <p class="font-bold text-2xl text-gray-800 dark:text-gray-200">{{__('dashboard.examples.header', ['concept' => $concept->name])}}</p>
        @include('components.dashboard.tabs.attributes')

        <div class="examples mt-3">
            @include('components.dashboard.tabs.examples-table')
        </div>
    </div>
</x-layout.dashboard>
