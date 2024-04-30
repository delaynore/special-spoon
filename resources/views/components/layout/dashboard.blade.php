<!-- Управление словарем -->
@props(['dictionary', 'concepts'])

<x-layout.main>
    <x-slot:title>{{ $dictionary->name }}</x-slot:title>
    <x-slot name="navigation"></x-slot>
    <div class="flex flex-row px-4 mt-2">
        @include('components.dashboard.sidebar.sidebar')
        <section class="flex-grow-10 pl-4 pr-4 w-full">
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                    <li class="me-2">
                        <a class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-400 dark:hover:text-gray-300" >{{__('Понятие')}}</a>
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
            <div id="default-tab-content w-full">
                {{ $slot }}
            </div>
        </section>
    </div>
</x-layout.main>
