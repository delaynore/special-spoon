@php
$dictionary = $concept->dictionary;
$children = $concept->children()->get();
@endphp

<li data-el="concept" data-id="concept-{{$concept->id}}" class="cursor-pointer"
data-owner="{{$dictionary->fk_user_id === auth()->user()->id ? 'true' : 'false'}}"
data-name="{{$concept->name}}"
data-create-parent="{{route('concept.create', ['dictionary' => $dictionary, 'parentId' => $concept->id])}}"
data-create-brother="{{route('concept.create', ['dictionary' => $dictionary, 'parentId' => $concept->fk_parent_concept_id, 'brotherId' => $concept->id])}}"
data-open="{{route('concept.show', ['dictionary' => $dictionary, 'concept' => $concept])}}"
data-edit={{route('concept.edit', [$dictionary, $concept])}}
data-delete="{{route('concept.destroy', [$dictionary ,$concept->id])}}"
>
    <div class="lidiv mb-[1px] inline-flex items-center justify-between w-full p-1 transition-transform delay-100 border-r border-gray-100 dark:border-gray-900 hover:bg-gray-200 dark:hover:bg-gray-700 toggle">
        <div data-open-concept-route="{{route('concept.show',[$dictionary, $concept])}}" class="inline-flex items-start flex-grow text-left open-concept">
            @if ($concept->fk_parent_concept_id)
            <span class="text-gray-400 -ml-[5px] mr-1">-</span>
            @endif
            <span class="overflow-hidden text-gray-900 select-text dark:text-gray-200">{{$concept->name}}</span>
        </div>
        @if ($children->count() > 0)
        <div class="pl-[10px] toggler hover:text-green-600 dark:text-gray-200 dark:hover:text-emerald-500">
            <x-tree-view.icon></x-tree-view.icon>
        </div>
        @endif
    </div>
    @if ($children->count() > 0)
    <ul class="hidden border-l-2 border-gray-400 select-text ms-1">
        @each('components.tree-view.tree-item', $children, 'concept')
    </ul>
    @endif
</li>




