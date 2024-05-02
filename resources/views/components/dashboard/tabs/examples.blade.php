@props(['dictionary', 'concepts', 'examples'])

<x-layout.dashboard :dictionary="$dictionary" :concepts="$concepts">
    @include('components.dashboard.tabs.tabs')
    <div class="w-full overflow-hidden">
        @include('components.dashboard.tabs.attributes')

        <div class="examples mt-3">
            @include('components.dashboard.tabs.examples-table')
        </div>
    </div>
</x-layout.dashboard>
