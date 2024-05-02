<div class="flex justify-end my-2">
    <a href="{{route('concept.attribute.create', [$dictionary, $concept])}}" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
        </svg>
        {{ __('Добавить') }}
    </a>
</div>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-gray-500 dark:text-gray-400 text-center">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-2 py-3">
                    Название атрибута
                </th>
                <th scope="col" class="px-2 py-3">
                    Тип данных
                </th>
                <th scope="col" class="px-2 py-3">
                    <span class="sr-only">Редактировать</span>
                </th>
                <th scope="col" class="px-2 py-3">
                    <span class="sr-only">Удалить</span>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Название
                </th>
                <td class="px-2 py-2">
                    Тип данных
                </td>
                <td class="px-2 py-2">
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __('Изменить')}}</a>
                </td>
                <td class="px-2 py-2">
                    <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">{{ __('Удалить')}}</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
