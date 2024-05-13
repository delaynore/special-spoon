<aside class="items-center border-r w-full max-w-96 min-w-36 dark:border-gray-500 border-gray-300">
    <div class="flex justify-center mb-2 py-2 px-4 border-b border-gray-300 dark:border-gray-500">
        @if(Auth::check() && Auth::user()->id === $dictionary->user->id)
        @include('components.dashboard.sidebar.menu')
        @endif
    </div>
    <div class="mt-1 text-sm text-black max-h-lvh overflow-x-scroll scroll-smooth w-full px-4" id="concept-tree">
        @includeWhen($concepts, 'components.tree-view.tree-view')
    </div>
</aside>
