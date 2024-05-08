@php
$dictionary = $concept->dictionary;
$children = $concept->children()->get();
$unique = Str::random(5);
@endphp

@if ($children->count() > 0)
<h2 id="header-{{$concept->id}} " class="w-full">
    <div data-dropdown-trigger="click" data-dropdown-toggle="dropdown{{$concept->id}}" data-dropdown-placement="right" data-dropdown-offset-skidding="100">
        <button type="button" class="flex border-2 border-gray-100 hover:border-gray-300  items-center justify-between w-full px-2 py-1 font-medium text-gray-500   dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-sm" data-accordion-target="#body-{{$concept->id}}" aria-expanded="false" aria-controls="body-{{$concept->id}}">
            <span class="overflow-hidden text-ellipsis">{{$concept->name}}</span>
            <x-tree-view.icon />
        </button>
    </div>
</h2>
<div id="body-{{$concept->id}}" class="hidden" aria-labelledby="header-{{$concept->id}}">
    <div class="ms-1 border-l-2">
        <!-- Nested accordion -->
        <div id="{{$unique}}" data-accordion="open">

            @each('components.tree-view.tree-item', $children, 'concept')

        </div>
        <!-- End: Nested accordion -->
    </div>
</div>
@else

<h2 class="w-full">
    <div data-dropdown-trigger="click" data-dropdown-toggle="dropdown{{$concept->id}}" data-dropdown-placement="right" data-dropdown-offset-skidding="100" class="flex border-2 border-gray-100 hover:border-gray-300  items-center justify-between w-full px-2 py-1 font-medium text-gray-500  focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-sm">
        {{$concept->name}}
    </div>
</h2>
@endif


<div id="dropdown{{$concept->id}}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
    <div class="py-1">
        <a title="{{$concept->name}}" href="#" class="block overflow-hidden text-ellipsis px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{$concept->name}}</a>
    </div>
    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="-button">
        @if(Auth::check() && Auth::user()->id === $dictionary->user->id)
        <li>
            <a href="{{route('concept.create', ['dictionary' => $dictionary, 'parentId' => $concept->id])}}" class="flex items-center justify-between py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{__('Добавить сына')}}
                <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </a>
        </li>
        @endif
        <li>
            <form action="{{route('concept.show', ['dictionary' => $dictionary, 'concept' => $concept])}}" method="get">
                <button type="submit" class="w-full flex items-center justify-between py-2 px-4 text-sm text-gray-700 hover:bg-gray-100  dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                    Открыть
                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>
            </form>
        </li>

        @if(Auth::check() && Auth::user()->id === $dictionary->user->id)
        <li>
            <a href="{{route('concept.edit', [$dictionary, $concept])}}" class="flex items-center justify-between py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Редактировать
                <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                </svg>
            </a>
        </li>
        @endif
    </ul>
    <div class="py-1">
        <a href="#" class="flex items-center justify-between py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Ссылка
            <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.213 9.787a3.391 3.391 0 0 0-4.795 0l-3.425 3.426a3.39 3.39 0 0 0 4.795 4.794l.321-.304m-.321-4.49a3.39 3.39 0 0 0 4.795 0l3.424-3.426a3.39 3.39 0 0 0-4.794-4.795l-1.028.961" />
            </svg>
        </a>
    </div>
    @if(Auth::check() && Auth::user()->id === $dictionary->user->id)
    <div class="py-1">
        <form action="{{route('concept.destroy', [$dictionary ,$concept->id])}}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="w-full flex items-center justify-between py-2 px-4 text-sm text-gray-700 hover:bg-gray-100  dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                Удалить
                <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd" />
                </svg>
            </button>
        </form>
    </div>
    @endif
</div>
