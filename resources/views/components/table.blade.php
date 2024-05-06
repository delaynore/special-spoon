@props(['headers', 'rows', 'names'])

<div class="overflow-x-auto overflow-y-scroll shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-gray-500 dark:text-gray-400 text-center">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                @foreach ($headers as $header)
                <th scope="col" class="px-2 py-3">
                    {{ $header}}
                </th>
                @endforeach
                <th scope="col" class="px-2 py-3">
                    <span class="sr-only">Редактировать</span>
                </th>
                <th scope="col" class="px-2 py-3">
                    <span class="sr-only">Удалить</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                @foreach ($names as $name)
                <th scope="row" class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $row->$name }}
                </th>
                @endforeach

                <td class="px-2 py-2">
                    <a href="{{route('attribute.edit', $row->id)}}" class="font-medium text-green-600 dark:text-green-500 hover:underline">{{ __('Изменить')}}</a>
                </td>
                <td class="px-2 py-2">
                    <form action="{{route('attribute.destroy', $row->id)}}" method="post">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">{{ __('Удалить')}}</button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if ($rows->links() != null)
    <div class="my-2 mx-4">
        {{ $rows->links() }}
    </div>

    @endif
</div>
