@props(['tags'])

@php
$names = ['name'];
@endphp

<x-layout.main>
    <x-slot name="navigation"></x-slot>
    <x-slot:title>{{ __('tag-page.title') }}</x-slot:title>
    <section class="flex items-start w-full">
        <div class="max-w-screen-xl px-4 mx-auto lg:px-12 w-full mt-3">
            <div class="relative bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center" method="GET" action="">
                            <label for="search" class="sr-only">{{ __('shared.search') }}</label>
                            <div class="relative w-full flex justify-start items-center">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="search" name="search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __('shared.search') }}" value="{{ request('search') }}">
                                <button type="submit" class="block py-2 ms-2 px-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">{{ __('shared.search') }}</button>
                            </div>
                        </form>
                    </div>
                    <div class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                        <a href="{{ route('tag.create') }}" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            {{ __('shared.add') }}
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    @if ($tags->isEmpty())
                    <div class="my-2 h-40 flex items-center justify-center text-xl antialiased dark:text-gray-100">
                        {{ __('shared.empty-records') }}
                    </div>
                    @else
                    <x-table :headers="__('entities.tag.props')" :rows="$tags" :names="$names" editRouteName="tag.edit" deleteRouteName="tag.destroy" :entityName="__('entities.tag.singular')"></x-table>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-layout.main>
