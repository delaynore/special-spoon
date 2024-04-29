<!-- Управление словарем -->
@props(['dictionary', 'concepts'])

@php
    session()->push('dictionary', $dictionary);
@endphp

<x-layout.main>
    <x-slot:title>{{ $dictionary->name }}</x-slot:title>
    <x-slot name="navigation"></x-slot>
    <div class="flex flex-row px-4">
        @include('components.dashboard.sidebar.sidebar')
        <section class="flex-grow-10 pl-4 pr-4">
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="dictionaryionary-tab" data-tabs-target="#dictionaryionary" type="button" role="tab" aria-controls="dictionaryionary" aria-selected="false">dictionaryionary</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="concept-tab" data-tabs-target="#concept" type="button" role="tab" aria-controls="concept" aria-selected="false">{{ __('Понятия')}}</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="settings-tab" data-tabs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Settings</button>
                    </li>
                    <li role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="export-tab" data-tabs-target="#export" type="button" role="tab" aria-controls="export" aria-selected="false">{{ __('Экспорт')}}</button>
                    </li>
                </ul>
            </div>
            <div id="default-tab-content">
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dictionaryionary" role="tabpanel" aria-labelledby="dictionaryionary-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">dictionaryionary tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="concept" role="tabpanel" aria-labelledby="concept-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">concept tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure doloremque vero recusandae reprehenderit rem voluptates quas sint possimus nostrum at, facilis quisquam dignissimos. Modi illum velit assumenda vitae dictionarya! Illo.</p>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="export" role="tabpanel" aria-labelledby="export-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Здесь будет экспорт списка понятий...
                    </p>
                </div>
            </div>
        </section>
    </div>
</x-layout.main>
