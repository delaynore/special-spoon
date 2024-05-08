@props(['dictionary', 'concepts', 'concept'])

<x-layout.dashboard :dictionary="$dictionary" :concepts="$concepts">
    @include('components.dashboard.tabs.tabs')
    <div class="w-full p-2.5">
        <div class="flex justify-between items-center mb-3">
            <div class="flex-grow-1">
                <h5 class="text-2xl font-bold text-gray-900 dark:text-white text-wrap break-words">{{$concept->name}}</h5>
            </div>
            <div class="">
                <a href="{{route('concept.edit', [$dictionary, $concept])}}" class="text-green-500 hover:text-white border border-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-green-700 dark:text-green-700 dark:hover:text-white dark:hover:bg-green-800 dark:focus:ring-green-800 transition-all">{{__('Редактировать')}}</a>
            </div>
        </div>

        <div class="block w-full min-h-12 text-sm p-2.5 text-gray-900 bg-gray-50 rounded-lg border border-gray-300  dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{!! $concept->definition !!}</div>
    </div>
</x-layout.dashboard>
