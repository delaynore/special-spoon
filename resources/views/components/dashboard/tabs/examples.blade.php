@props(['dictionary', 'concepts', 'examples'])

<x-layout.dashboard :dictionary="$dictionary" :concepts="$concepts">
    @include('components.dashboard.tabs.breadcrumbs', [$concept])
    @include('components.dashboard.tabs.tabs')
    <div class="w-full mt-2 overflow-hidden">
        <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{__('dashboard.examples.header', ['concept' => $concept->name])}}</p>
        @include('components.dashboard.tabs.attributes')

        <div class="mt-3 examples">
            @include('components.dashboard.tabs.examples-table')
        </div>
    </div>
</x-layout.dashboard>
