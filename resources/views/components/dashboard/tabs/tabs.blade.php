<div class="mb-4 border-b border-gray-200 dark:border-gray-700">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center cursor-pointer dark:text-gray-100">
        <li class="me-2">
            <a href="{{Route::currentRouteName() == 'concept.show' ? "#" : route('concept.show', ['dictionary' => $dictionary, 'concept' => $concept->id])}}" class="dark:border-gray-700 dark:border-b inline-block p-4 border-b-2 rounded-t-lg hover:text-blue-600 hover:border-blue-400 dark:hover:text-blue-500 dark:hover:border-blue-800">{{__('Понятие')}}</a>
        </li>
        <li class="me-2">
            <a href="{{Route::currentRouteName() == 'concept.examples' ? "#" :route('concept.examples', ['dictionary' => $dictionary, 'concept' => $concept])}}" class="dark:border-gray-700 dark:border-b inline-block p-4 border-b-2 rounded-t-lg hover:text-blue-600 hover:border-blue-400 dark:hover:text-blue-500 dark:hover:border-blue-800">{{ __('Экземпляры')}}</a>
        </li>
        <li class="me-2">
            <a class="inline-block p-4 border-b-2 rounded-t-lg dark:border-gray-700 dark:border-b hover:text-blue-600 hover:border-blue-400 dark:hover:text-blue-500 dark:hover:border-blue-800">{{ __('Вложения')}}</a>
        </li>
    </ul>
</div>
