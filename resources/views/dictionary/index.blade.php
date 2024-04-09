<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Мои словари') }}
        </h2>
        <a href="{{ route('dictionary.create') }}" class="mt-2 md:mt-0 text-gray-800 dark:text-gray-200 hover:bg-gray-700 hover:text-white active:bg-gray-200 dark:active:bg-gray-800 transition duration-100 rounded-md px-3 py-2 text-sm font-medium">
            {{ __('Создать словарь') }}
        </a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("список тут")}}
                </div>
            </div>
        </div>
    </div>

</x-layouts.app>
