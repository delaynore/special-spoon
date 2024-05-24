@props(['dictionary'])

<tr class="border-b last:border-b-0 dark:border-gray-700">
    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
        <span>{{ $dictionary->name}}</span>
        @if ($dictionary->visibility == \App\Enums\Visibility::PRIVATE)
        <span class="inline-flex items-center justify-center bg-gray-900 rounded-full dark:bg-gray-200">
            <svg class="inline w-3 h-3 m-1 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z" clip-rule="evenodd" />
            </svg>
        </span>

        @endif
    </th>
    <td class="px-4 py-3 max-w-48" title="{{ $dictionary->description}}">
        <p class="text-3">{{ $dictionary->description}}</p>
    </td>
    <td class="px-4 py-3 text-center">{{ $dictionary->created_at->timezone('Europe/Samara')->translatedFormat('j F Y H:i')}}</td>
    <td class="px-4 py-3 text-center">
        <a class="cursor-pointer inline-flex items-center py-2.5 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" href="{{ route('dictionary.show', $dictionary)}}">
            <svg class="w-4 h-4 text-gray-800 me-2 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M11 4.717c-2.286-.58-4.16-.756-7.045-.71A1.99 1.99 0 0 0 2 6v11c0 1.133.934 2.022 2.044 2.007 2.759-.038 4.5.16 6.956.791V4.717Zm2 15.081c2.456-.631 4.198-.829 6.956-.791A2.013 2.013 0 0 0 22 16.999V6a1.99 1.99 0 0 0-1.955-1.993c-2.885-.046-4.76.13-7.045.71v15.081Z" clip-rule="evenodd" />
            </svg>

            {{ __('shared.submit.open')}}
        </a>
    </td>
    <td class="px-4 py-3 text-center">
        <button id="{{$dictionary->id}}-button" data-dropdown-toggle="{{$dictionary->id}}" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
            </svg>
        </button>
        <div id="{{$dictionary->id}}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="{{$dictionary->id}}-button">
                <li>
                    <form action="{{route('dictionary.show', $dictionary)}}" method="GET">
                        @csrf
                        <button type="submit" class="flex items-center justify-between w-full px-4 py-2 text-sm text-gray-700 group hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                            {{__('shared.submit.open')}}
                            <svg class="w-4 h-4 text-gray-800 dark:text-white" data-slot="icon" aria-hidden="true" fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path class="text-transparent transition-all delay-200 group-hover:text-inherit" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </form>
                </li>

                <li>
                    <a href="{{ route('dictionary.edit', $dictionary) }}" class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{__('shared.edit')}}
                        <svg class="w-4 h-4 text-gray-800 dark:text-white" data-slot="icon" aria-hidden="true" fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </a>
                </li>
            </ul>
            <div class="py-1">
                <input id="link-dictionary{{$dictionary->id}}" type="text" class="hidden link-dictionary" value="{{route('dictionary.show', $dictionary->id)}}" disabled readonly>
                <div data-copy-to-clipboard-target="link-dictionary{{$dictionary->id}}" class="flex items-center justify-between w-full px-4 py-2 text-gray-700 cursor-pointer select-none group btn-dictionary hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white active:scale-95">
                    {{ __('shared.link')}}
                    <svg class="w-4 h-4 group-hover:animate-pulse" data-slot="icon" aria-hidden="true" fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
            </div>
            <div class="py-1">
                <div class="flex justify-center">
                    <button id="delete-{{$dictionary->name}}" data-modal-target="delete-dict-{{$dictionary->id}}" data-modal-toggle="delete-dict-{{$dictionary->id}}" type="button" class="flex items-center justify-between w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                        {{ __('shared.submit.delete')}}
                        <svg class="w-4 h-4" data-slot="icon" aria-hidden="true" fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>
            </div>
    </td>
</tr>
