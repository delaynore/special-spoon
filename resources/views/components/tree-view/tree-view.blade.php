<div id="accordion-nested-parent" data-accordion="open" class="cursor-pointer w-full">
    @foreach ($concepts as $concept)
        @include('components.tree-view.tree-item', ['concept' => $concept])
    @endforeach
</div>
