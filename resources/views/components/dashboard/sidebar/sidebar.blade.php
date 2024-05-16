<aside class="items-center w-full border-r border-gray-300 max-w-96 min-w-36 dark:border-gray-500">
    <div class="flex justify-center px-4 py-2 mb-2 border-b border-gray-300 dark:border-gray-500">
        @if(Auth::check() && Auth::user()->id === $dictionary->user->id)
        @include('components.dashboard.sidebar.menu')
        @endif
    </div>
    <div class="w-full px-4 mt-1 overflow-x-scroll text-sm text-black max-h-lvh scroll-smooth" id="concept-tree">
        @includeWhen($concepts, 'components.tree-view.tree-view')
    </div>
</aside>
