<ul class="pb-12 treeview">
    @foreach ($concepts as $concept)
        @include('components.tree-view.tree-item', ['concept' => $concept])
    @endforeach
</ul>

<div id="contextmenu"
    class="fixed z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
    <div class="py-1 text-gray-700 dark:text-gray-200">
        <a id="contextmenu-title"
            class="block px-4 py-2 overflow-hidden text-ellipsis hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white dark:text-gray-200"></a>
    </div>
    @can('must-be-owner', $dictionary)
        <div class="py-1 text-gray-700 dark:text-gray-200">
            <a id="contextmenu-create-parent"
                class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{__('dashboard.sidebar.concepts.child')}}
                <svg class="w-4 h-4" data-slot="icon" aria-hidden="true" fill="none" stroke-width="2" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </a>
            <a id="contextmenu-create-brother"
                class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{__('dashboard.sidebar.concepts.brother')}}
                <svg class="w-4 h-4" data-slot="icon" aria-hidden="true" fill="none" stroke-width="2" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                </svg>
            </a>
        </div>
    @endcan
    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="-button">
        <li>
            <form id="contextmenu-open" action="" method="get">
                <button type="submit"
                    class="flex items-center justify-between w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                    {{ __('shared.open') }}
                    <svg class="w-4 h-4" data-slot="icon" aria-hidden="true" fill="none" stroke-width="2"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </svg>
                </button>
            </form>
        </li>

        @can('must-be-owner', $dictionary)
            <li>
                <a id="contextmenu-edit"
                    class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                    {{__('shared.edit')}}
                    <svg class="w-4 h-4" data-slot="icon" aria-hidden="true" fill="none" stroke-width="2"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </a>
            </li>
        @endcan
    </ul>
    @can('must-be-owner', $dictionary)
        <div class="py-1 text-gray-700 dark:text-gray-200">
            <button id="deleteButton" data-modal-target="deleteModalConcept" data-modal-toggle="deleteModalConcept"
                class="flex items-center justify-between w-full px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                {{ __('shared.delete') }}
                <svg class="w-4 h-4" data-slot="icon" aria-hidden="true" fill="none" stroke-width="2" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </button>
        </div>
    @endcan
</div>

<div id="deleteModalConcept" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
    <div class="relative w-full h-full max-w-md p-4 md:h-auto">
        <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <button type="button"
                class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-toggle="deleteModalConcept">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">{{ __('screen-reader.modal.close') }}</span>
            </button>
            <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true"
                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                    clip-rule="evenodd"></path>
            </svg>
            <p id="description" class="mb-4 text-gray-500 dark:text-gray-300"></p>
            <div class="flex items-center justify-center space-x-4">
                <button data-modal-toggle="deleteModalConcept" type="button"
                    class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                    {{ __('shared.confirm-delete.no') }}
                </button>
                <form id="contextmenu-delete" action="" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit"
                        class="px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                        {{ __('shared.confirm-delete.yes') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>


@vite(['resources/js/tree.js'])
