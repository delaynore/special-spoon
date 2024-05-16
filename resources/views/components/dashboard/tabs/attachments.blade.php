@props(['dictionary', 'concept', 'concepts', 'attachments'])

<x-layout.dashboard :dictionary="$dictionary" :concepts="$concepts">
    @include('components.dashboard.tabs.tabs')
    <div class="w-full overflow-hidden">
        <div class="flex items-center justify-between gap-2 mt-2">
            <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{__('dashboard.attachments.header', ['concept' => $concept->name])}}</p>
            @can('must-be-owner', $dictionary)
            <a href="{{route('attachment.create', [$dictionary, $concept])}}" class="flex items-center justify-center gap-1 px-4 py-2 text-sm font-medium text-white rounded-lg cursor-pointer w-fit bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                <svg class="w-4 h-4 sm:w-6 sm:h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                </svg>
                <span class="">{{ __('shared.add') }}</span>
            </a>
            @endcan

        </div>
        <div class="grid grid-cols-2 gap-3 mt-3 attachments md:grid-cols-3 xl:grid-cols-6">

            @foreach ($attachments as $attach)

            <div class="max-w-xs overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 dark:border dark:border-gray-500">
                <div class="px-4 pt-2">
                    <h1 class="text-xl font-bold text-gray-800 uppercase dark:text-white">{{ $attach->name}}</h1>
                </div>
                <img class="object-contain w-full h-48 mt-2" src="{{asset('storage/'.$attach->path)}}" alt="{{ $attach->name }}">

                <div class="flex items-center justify-between gap-2 px-4 py-2 bg-gray-400 dark:bg-gray-900">
                    <a target="_blank" href="{{asset('storage/'.$attach->path)}}" class="px-2 py-1 text-xs font-semibold text-gray-900 uppercase transition-colors duration-300 transform bg-white rounded dark:bg-gray-800 dark:border dark:border-gray-200 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white hover:bg-gray-200 focus:bg-gray-400 focus:outline-none">{{ __('shared.open') }}</a>
                    @can('must-be-owner', $dictionary)
                    <div class="flex justify-center">
                        <button id="delete-{{$attach->name}}" data-modal-target="delete-attach-{{$attach->id}}" data-modal-toggle="delete-attach-{{$attach->id}}" class="px-2 py-1 text-xs font-semibold text-gray-900 uppercase transition-colors duration-300 transform bg-white rounded dark:hover:bg-gray-700 dark:hover:text-white dark:bg-gray-800 dark:border dark:border-gray-200 dark:text-gray-200 hover:bg-gray-200 focus:bg-gray-400 focus:outline-none" type="button">
                            {{ __('shared.delete')}}
                        </button>
                    </div>
                    <!--  -->
                    <div id="delete-attach-{{$attach->id}}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                        <div class="relative w-full h-full max-w-md p-4 md:h-auto">
                            <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="delete-attach-{{$attach->id}}">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">{{ __('screen-reader.modal.close') }}</span>
                                </button>
                                <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="mb-4 text-gray-500 dark:text-gray-300">{{ __('shared.confirm-delete.description', ['name' => $attach->name, 'type' => Str::lower(__('entities.attachments.singular'))]) }}</p>
                                <div class="flex items-center justify-center space-x-4">
                                    <button data-modal-toggle="delete-attach-{{$attach->id}}" type="button" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        {{ __('shared.confirm-delete.no') }}
                                    </button>
                                    <form action="{{route('attachment.destroy', [$dictionary, $concept, $attach])}}" method="post">
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
                    @endcan
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-layout.dashboard>
