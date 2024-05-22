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

<nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:text-inherit" aria-label="Breadcrumb">
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

        <!-- <li class="inline-flex items-center">
      <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
        </svg>
        Home
      </a>
    </li>
    <li>
      <div class="flex items-center">
        <svg class="block w-3 h-3 mx-1 text-gray-400 rtl:rotate-180 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
        </svg>
        <a href="#" class="text-sm font-medium text-gray-700 ms-1 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Templates</a>
      </div>
    </li>
    <li aria-current="page">
      <div class="flex items-center">
        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
        </svg>
        <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2 dark:text-gray-400">Flowbite</span>
      </div>
    </li> -->
    </ol>
</nav>
