@props([
'headers',
'rows',
'names',
'editRouteName',
'deleteRouteName',
'isPaginated' => true,
'entityName',
'deleteGateName' => 'admin',
'editGateName' => 'redactor',
])

<div class="overflow-x-auto overflow-y-scroll shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                @foreach ($headers as $header)
                <th scope="col" class="px-2 py-3">
                    {{ $header}}
                </th>
                @endforeach
                <th scope="col" class="px-2 py-3">
                    <span class="sr-only">{{ __('shared.edit')}}</span>
                </th>
                <th scope="col" class="px-2 py-3">
                    <span class="sr-only">{{ __('shared.delete')}}</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                @foreach ($names as $name)
                <th title="{{$row->$name}}" scope="row" class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap max-w-[200px] dark:text-white">
                    <p class="text-3">
                        {{ $row->$name }}
                    </p>
                </th>
                @endforeach
                @can($editGateName)
                <td class="px-2 py-2">
                    <a href="{{route($editRouteName, $row->id)}}" class="font-medium text-green-600 dark:text-green-500 hover:underline">{{ __('shared.edit')}}</a>
                </td>
                @endcan
                @can($deleteGateName)
                <td class="px-2 py-2">
                    <div class="flex justify-center">
                        <button id="delete-{{$row->name}}" data-modal-target="delete-entity-{{$row->id}}" data-modal-toggle="delete-entity-{{$row->id}}" class="font-medium text-red-600 dark:text-red-500 hover:underline" type="button">
                            {{ __('shared.delete')}}
                        </button>
                    </div>
                    <!--  -->
                    <div id="delete-entity-{{$row->id}}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                        <div class="relative w-full h-full max-w-md p-4 md:h-auto">
                            <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="delete-entity-{{$row->id}}">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">{{ __('screen-reader.modal.close') }}</span>
                                </button>
                                <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="mb-4 text-gray-500 dark:text-gray-300">{{ __('shared.confirm-delete.description', ['name' => $row->name, 'type' => Str::lower($entityName)]) }}</p>
                                <div class="flex items-center justify-center space-x-4">
                                    <button data-modal-toggle="delete-entity-{{$row->id}}" type="button" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        {{ __('shared.confirm-delete.no') }}
                                    </button>
                                    <form action="{{route($deleteRouteName, $row)}}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                            {{ __('shared.confirm-delete.yes') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  -->
                </td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
    @if ($isPaginated && $rows->hasPages())
    <div class="mx-4 my-2">
        {{ $rows->links() }}
    </div>
    @endif
</div>
