<div class="mb-4 border-b border-gray-200 dark:border-gray-700">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center cursor-pointer">
        <li class="me-2">
            <a href="{{Route::currentRouteName() == 'concept.show' ? "#" : route('concept.show', ['dictionary' => $dictionary, 'concept' => $concept->id])}}" class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-400 dark:hover:text-gray-300">{{__('Понятие')}}</a>
        </li>
        <li class="me-2">
            <a href="{{Route::currentRouteName() == 'concept.examples' ? "#" :route('concept.examples', ['dictionary' => $dictionary, 'concept' => $concept])}}" class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-400 dark:hover:text-gray-300">{{ __('Экземпляры')}}</a>
        </li>
        <li class="me-2">
            <a class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-400 dark:hover:text-gray-300">{{ __('Вложения')}}</a>
        </li>
    </ul>
</div>
