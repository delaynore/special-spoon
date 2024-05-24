@props(['concept'])

@php
$crumbs = [];
$temp = $concept;
while ($temp) {
$crumbs[$temp->id] = $temp;
$temp = $temp->parent;
}

$crumbs = array_reverse($crumbs);
@endphp

<nav class="flex px-5 py-2 mt-2 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:text-inherit" aria-label="Breadcrumb">
    <ol class="inline-flex items-center md:space-x-2">
        @foreach ($crumbs as $conc)
        <li class="inline-flex items-center">
            <a href="{{url()->current() == route('concept.show', ['dictionary' => $conc->dictionary, 'concept' => $conc]) ? '#' : route('concept.show', ['dictionary' => $conc->dictionary, 'concept' => $conc]) }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                @if($loop->first)
                <svg class="w-4 h-4 me-2.5" data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke="2" clip-rule="evenodd" d="M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262l-10.5 11.25a.75.75 0 0 1-1.272-.71l1.992-7.302H3.75a.75.75 0 0 1-.548-1.262l10.5-11.25a.75.75 0 0 1 .913-.143Z" fill-rule="evenodd"></path>
                </svg>
                @else
                <svg class="block w-4 h-4 mr-1" data-slot="icon" aria-hidden="true" fill="none" stroke-width="3" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="m8.25 4.5 7.5 7.5-7.5 7.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                @endif
                {{$conc->name}}
            </a>
        </li>
        @endforeach
    </ol>
</nav>
