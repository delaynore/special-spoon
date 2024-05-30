@php
$dictionary = $concept->dictionary;
$children = $concept->children()->get();
@endphp

<li data-id="concept-{{$concept->id}}" class="cursor-pointer">
    <div class="mb-[1px] inline-flex items-center justify-between w-full p-1 transition-transform delay-100 border-r border-gray-100 dark:border-gray-900 hover:bg-gray-200 dark:hover:bg-gray-700 toggle">
        <div data-open-concept-route="{{route('concept.show',[$dictionary, $concept])}}" class="inline-flex items-start flex-grow text-left open-concept" data-dropdown-trigger="click" data-dropdown-toggle="dropdown{{$concept->id}}" data-dropdown-placement="right" data-dropdown-offset-skidding="100">
            @if ($concept->fk_parent_concept_id)
            <span class="text-gray-400 -ml-[5px] mr-1">-</span>
            @endif
            <span class="overflow-hidden text-gray-900 select-text dark:text-gray-200">{{$concept->name}}</span>
        </div>
        @if ($children->count() > 0)
        <x-tree-view.icon></x-tree-view.icon>
        @endif
    </div>
    @if ($children->count() > 0)
    <ul class="hidden border-l-2 border-gray-400 select-text ms-1">
        @each('components.tree-view.tree-item', $children, 'concept')
    </ul>
    @endif
</li>



<div id="dropdown{{$concept->id}}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
    <div class="py-1 text-gray-700 dark:text-gray-200">
        <a title="{{$concept->name}}" href="#" class="block px-4 py-2 overflow-hidden text-ellipsis hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white dark:text-gray-200">{{$concept->name}}</a>
    </div>
    @can('must-be-owner', $dictionary)
    <div class="py-1 text-gray-700 dark:text-gray-200">
        <a href="{{route('concept.create', ['dictionary' => $dictionary, 'parentId' => $concept->id])}}" class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{__('dashboard.sidebar.concepts.child')}}
            <svg class="w-4 h-4" data-slot="icon" aria-hidden="true" fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </a>
        <a href="{{route('concept.create', ['dictionary' => $dictionary, 'parentId' => $concept->fk_parent_concept_id])}}" class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{__('dashboard.sidebar.concepts.brother')}}
            <svg class="w-4 h-4" data-slot="icon" aria-hidden="true" fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </a>
    </div>
    @endcan
    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="-button">
        <li>
            <form action="{{route('concept.show', ['dictionary' => $dictionary, 'concept' => $concept])}}" method="get">
                <button type="submit" class="flex items-center justify-between w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                    {{ __('shared.open') }}
                    <svg class="w-4 h-4" data-slot="icon" aria-hidden="true" fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
            </form>
        </li>

        @can('must-be-owner', $dictionary)
        <li>
            <a href="{{route('concept.edit', [$dictionary, $concept])}}" class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                {{__('shared.edit')}}
                <svg class="w-4 h-4" data-slot="icon" aria-hidden="true" fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </a>
        </li>
        @endcan
    </ul>
    @can('must-be-owner', $dictionary)
    <div class="py-1 text-gray-700 dark:text-gray-200">
        <form action="{{route('concept.destroy', [$dictionary ,$concept->id])}}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="flex items-center justify-between w-full px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                {{ __('shared.delete') }}
                <svg class="w-4 h-4" data-slot="icon" aria-hidden="true" fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </button>
        </form>
    </div>
    @endcan
</div>
