@php
    $active = 'bg-blue-200 dark:bg-sky-950 hover:bg-blue-200 dark:hover:bg-sky-950 text-black dark:text-white outline-1 outline-blue-500 dark:outline-blue-500 outline';
@endphp

<div id="accordion-nested-parent" data-accordion="open" class="cursor-pointer w-full" data-active-classes="{{ $active }}" data-inactive-classes="text-inherit">
    @foreach ($concepts as $concept)
        @include('components.tree-view.tree-item', ['concept' => $concept])
    @endforeach
</div>
