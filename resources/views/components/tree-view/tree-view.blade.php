<ul class="pb-12 treeview">
    @foreach ($concepts as $concept)
    @include('components.tree-view.tree-item', ['concept' => $concept])
    @endforeach
</ul>
@once
@vite(['resources/js/tree.js'])
@endonce




