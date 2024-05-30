<div class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
    <a href="{{ route('concept.create', $dictionary) }}" title="{{__('dashboard.sidebar.menu.create')}}" data-tooltip-placement="bottom" data-tooltip-target="tooltip-create-concept" class="px-3 py-1 font-medium text-gray-600 transition-colors duration-200 hover:text-blue-600 dark:hover:text-blue-500 sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
        <svg class="w-5 h-5 sm:w-6 sm:h-6" data-slot="icon" aria-hidden="true" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 10.5v6m3-3H9m4.06-7.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
    </a>
    <div id="tooltip-create-concept" role="tooltip" class="absolute z-10 invisible inline-block px-2 py-1 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
        {{__('dashboard.sidebar.menu.create')}}
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
    <a href="{{ route('dictionary.export', $dictionary) }}" data-tooltip-placement="bottom" data-tooltip-target="tooltip-export-concepts" title="{{ __('dashboard.sidebar.menu.export') }}" class="px-3 py-1 font-medium text-gray-600 transition-colors duration-200 hover:text-blue-600 dark:hover:text-blue-500 sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
        <svg class="w-5 h-5 sm:w-6 sm:h-6" data-slot="icon" aria-hidden="true" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 9.75v6.75m0 0-3-3m3 3 3-3m-8.25 6a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
    </a>
    <div id="tooltip-export-concepts" role="tooltip" class="absolute z-10 invisible inline-block px-2 py-1 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
        {{__('dashboard.sidebar.menu.export')}}
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>

    <div id="collapse-concepts" data-tooltip-placement="bottom" data-tooltip-target="tooltip-collapse-concepts" title="{{ __('dashboard.sidebar.menu.export') }}" class="px-3 py-1 font-medium text-gray-600 transition-colors duration-200 hover:text-blue-600 dark:hover:text-blue-500 sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
        <svg class="w-5 h-5 sm:w-6 sm:h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13.5H9m4.06-7.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
        </svg>
    </div>
    <div id="tooltip-collapse-concepts" role="tooltip" class="absolute z-10 invisible inline-block px-2 py-1 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
        {{__('dashboard.sidebar.menu.collapse')}}
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
</div>
