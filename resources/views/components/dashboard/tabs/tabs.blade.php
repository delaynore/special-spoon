<div class="flex pt-2 overflow-x-auto border-b border-gray-300 whitespace-nowrap dark:border-gray-500">
    <a href="{{Route::currentRouteName() == 'concept.show' ? "#" : route('concept.show', ['dictionary' => $dictionary, 'concept' => $concept->id])}}" class="hover:text-blue-600 dark:hover:text-blue-500 inline-flex items-center h-10 px-2 py-2 text-center text-gray-700 {{Route::currentRouteName() == 'concept.show' ? 'border border-b-0 rounded-t-md' : 'bg-transparent border-b'}} border-gray-300 sm:px-4 dark:border-gray-500 -px-1 dark:text-gray-200 whitespace-nowrap focus:outline-none">
        <svg class="w-4 h-4 mx-1 sm:w-5 sm:h-5" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 3L5 3C3.89543 3 3 3.89543 3 5L3 19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M7 7L17 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">

            </path>
            <path d="M7 12L17 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M7 17L13 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>

        <span class="mx-1 text-sm sm:text-base">
            {{__('dashboard.tabs.concepts')}}
        </span>
    </a>
    <a href="{{Route::currentRouteName() == 'concept.examples' ? "#" :route('concept.examples', ['dictionary' => $dictionary, 'concept' => $concept])}}" class="{{Route::currentRouteName() == 'concept.examples' ? 'border border-b-0 rounded-t-md' : 'bg-transparent border-b'}} hover:text-blue-600 dark:hover:text-blue-500 inline-flex items-center h-10 px-2 py-2 text-center text-gray-700 bg-transparent border-b border-gray-300 sm:px-4 dark:border-gray-500 -px-1 dark:text-gray-200 whitespace-nowrap cursor-base focus:outline-none hover:border-gray-400 dark:hover:border-gray-300">
        <svg class="w-4 h-4 mx-1 sm:w-5 sm:h-5" data-slot="icon" aria-hidden="true" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>

        <span class="mx-1 text-sm sm:text-base">
            {{ __('dashboard.tabs.examples') }}
        </span>
    </a>
    <a href="{{Route::currentRouteName() == 'concept.attachments' ? "#" :route('concept.attachments', ['dictionary' => $dictionary, 'concept' => $concept])}}" class="{{Route::currentRouteName() == 'concept.attachments' ? 'border border-b-0 rounded-t-md' : 'bg-transparent border-b'}} hover:text-blue-600 dark:hover:text-blue-500 inline-flex items-center h-10 px-2 py-2 text-center text-gray-700 bg-transparent border-b border-gray-300 sm:px-4 dark:border-gray-500 -px-1 dark:text-gray-200 whitespace-nowrap cursor-base focus:outline-none hover:border-gray-400 dark:hover:border-gray-300">
        <svg class="w-4 h-4 mx-1 sm:w-5 sm:h-5" data-slot="icon" aria-hidden="true" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
        <span class="mx-1 text-sm sm:text-base">
            {{ __('dashboard.tabs.attachments')}}
        </span>
    </a>
</div>
