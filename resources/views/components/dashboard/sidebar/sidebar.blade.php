<aside class="items-center border-r w-96 dark:border-gray-600 border-gray-200 pr-4">
    <div class="flex justify-center mb-2">
        @include('components.dashboard.sidebar.menu')
    </div>
    <div class="mt-1 text-sm text-black max-h-lvh overflow-x-scroll w-full pr-3" id="concept-tree">
        @includeWhen($concepts, 'components.tree-view.tree-view')
    </div>
</aside>