@props(['dictionary', 'concepts', 'concept'])

<x-layout.dashboard :dictionary="$dictionary" :concepts="$concepts">
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
            <li class="me-2">
                <a class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-400 dark:hover:text-gray-300">{{__('Понятие')}}</a>
            </li>
            <li class="me-2">
                <a class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-400 dark:hover:text-gray-300">{{ __('Экземпляры')}}</a>
            </li>
            <li class="me-2">
                <a class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-400 dark:hover:text-gray-300">{{ __('Вложения')}}</a>
            </li>
            <li class="me-2">
                <a class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-400 dark:hover:text-gray-300">{{ __('Атрибуты')}}</a>
            </li>
        </ul>
    </div>
    <div class="w-full">
        <p>{{ $concept->id }}</p>
        <h5 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white text-wrap break-words">{{$concept->name}}</h5>
        <p class="font-normal text-gray-700 dark:text-gray-400 text-wrap break-words">{!! $concept->definition !!}</p>
    </div>
</x-layout.dashboard>
