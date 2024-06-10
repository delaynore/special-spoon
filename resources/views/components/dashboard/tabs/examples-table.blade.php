@props(['page' => 1])
@php

$countPages = \App\Models\ConceptAttributeValue::join('concept_attributes', 'concept_attribute_values.fk_concept_attribute_id', '=', 'concept_attributes.id')
->join('concepts', 'concept_attributes.fk_concept_id', '=', 'concepts.id')
->where('concept_attributes.fk_concept_id', $concept->id)
->selectRaw('concept_attribute_values.example_number')
->groupBy('concept_attribute_values.example_number')
->orderBy('concept_attribute_values.example_number')
->pluck('example_number')
->count();

$perPage = 20;
$countPages = (int) ceil($countPages / $perPage);

$page = (int) request('page', 1);
if ($page > $countPages) {
$page = $countPages;
} else if ($page < 1) { $page=1; } $previousPage=$page - 1; $nextPage=$page + 1; $pagingItems=[]; array_push($pagingItems, 1); if ($page> 3) {
    if ($page < $countPages - 2) { array_push($pagingItems, '...' , $previousPage, $page, $nextPage, '...' , $countPages); } else if ($page===$countPages) { array_push($pagingItems, '...' , $previousPage, $page); } else if ($page===$countPages - 1) { array_push($pagingItems, '...' , $previousPage, $page, $nextPage); } else if ($page===$countPages - 2) { array_push($pagingItems, '...' , $previousPage, $page, $nextPage, $countPages); } else { array_push($pagingItems, '...' , $previousPage, $page, $nextPage, '...' , $countPages); } } else if ($page===3) { array_push($pagingItems, $previousPage, $page, $nextPage, '...' , $countPages); } else if ($page===2) { array_push($pagingItems, $page, $nextPage, '...' , $countPages); } else { array_push($pagingItems, $nextPage, '...' , $countPages); } $attributes=\App\Models\Attribute::join('concept_attributes', 'attributes.id' , '=' , 'concept_attributes.fk_attribute_id' )->where('concept_attributes.fk_concept_id', $concept->id)
        ->selectRaw('attributes.name')
        ->orderBy('concept_attributes.created_at')
        ->get();

        $exampleNumbers = \App\Models\ConceptAttributeValue::join('concept_attributes', 'concept_attribute_values.fk_concept_attribute_id', '=', 'concept_attributes.id')
        ->join('concepts', 'concept_attributes.fk_concept_id', '=', 'concepts.id')
        ->where('concept_attributes.fk_concept_id', $concept->id)
        ->selectRaw('concept_attribute_values.example_number')
        ->groupBy('concept_attribute_values.example_number')
        ->orderBy('concept_attribute_values.example_number')
        ->skip($perPage * ($page - 1))
        ->take($perPage)
        ->pluck('example_number');

        $array_examples = [];
        foreach ($exampleNumbers as $exampleNumber) {
        $results = \App\Models\ConceptAttributeValue::join('concept_attributes', 'concept_attribute_values.fk_concept_attribute_id', '=', 'concept_attributes.id')
        ->join('concepts', 'concept_attributes.fk_concept_id', '=', 'concepts.id')
        ->join('attributes', 'concept_attributes.fk_attribute_id', '=', 'attributes.id')
        ->where('concept_attributes.fk_concept_id', $concept->id)
        ->where('concept_attribute_values.example_number', $exampleNumber)
        ->selectRaw('concept_attribute_values.value')
        ->orderBy('concept_attribute_values.example_number')
        ->orderBy('concept_attributes.created_at')
        ->pluck('value');
        $array_examples[$exampleNumber] = $results;
        }

        $dictionary = $concept->dictionary()->first();
        @endphp

        <div class="flex justify-end my-2">
            @can('must-be-owner', $concept->dictionary)
            <a href="{{route('concept.example.create', $concept) }}" class="px-3 py-2 text-sm font-medium text-center text-blue-500 transition-all border border-blue-500 rounded-lg hover:text-white hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:border-blue-700 dark:text-blue-700 dark:hover:text-white dark:hover:bg-blue-800 dark:focus:ring-blue-800">
                {{__('shared.add')}}
            </a>
            <a href="{{route('import.create', [$dictionary, $concept])}}" class="px-3 py-2 ml-2 text-sm font-medium text-center transition-all border rounded-lg border-cyan-500 text-cyan-500 hover:text-white hover:bg-cyan-600 focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:border-cyan-700 dark:text-cyan-700 dark:hover:text-white dark:hover:bg-cyan-800 dark:focus:ring-cyan-800">{{__('shared.import')}}</a>
            @endcan
        </div>
        <div class="overflow-x-auto overflow-y-scroll shadow-md">
            <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                <caption class="px-6 py-2 text-lg font-semibold text-left text-gray-800 bg-white dark:text-gray-200 dark:bg-gray-800">
                    {{__('dashboard.examples.table')}}
                </caption>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-2 py-3">
                            {{ __('shared.number') }}
                        </th>
                        @foreach ($attributes as $attribute)

                        <th scope="col" class="px-2 py-3">
                            {{ $attribute->name }}
                        </th>
                        @endforeach
                        @can('must-be-owner', $concept->dictionary)
                        <th scope="col" class="px-2 py-3">
                            <span class="sr-only">{{ __('shared.edit') }}</span>
                        </th>
                        <th scope="col" class="px-2 py-3">
                            <span class="sr-only">{{ __('shared.delete') }}</span>
                        </th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($array_examples as $k => $v)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $k }}
                        </th>
                        @foreach ($v as $value)
                        <th scope="row" class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $value }}
                        </th>
                        @endforeach
                        @can('must-be-owner', $concept->dictionary)
                        <td class="px-2 py-2">
                            <a href="{{route('concept.example.edit', [$concept, 'exampleNumber' => $k])}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __('shared.edit')}}</a>
                        </td>
                        <td class="px-2 py-2">
                            <form action="{{route('concept.example.destroy', [$concept, 'exampleNumber' => $k])}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">{{ __('shared.delete')}}</button>
                            </form>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>

            </table>
            @if ($countPages > 1)
            <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between my-2 ">
                <div class="flex justify-between flex-1 sm:hidden">
                    @if ($page === 0)
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 rounded-md cursor-default dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
                        {!! __('pagination.previous') !!}
                    </span>
                    @else
                    @php
                    $previousPage = $page - 1;
                    @endphp
                    <a href="{{ route('concept.examples', ['dictionary' => $dictionary->id, 'concept' => $concept->id, 'page' => $previousPage]) }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                        {!! __('pagination.previous') !!}
                    </a>
                    @endif

                    @if ($page < $countPages - 1) @php $nextPage=$page + 1; @endphp <a href="{{ route('concept.examples', ['dictionary' => $dictionary->id, 'concept' => $concept->id, 'page' => $nextPage]) }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                        {!! __('pagination.next') !!}
                        </a>
                        @else
                        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 rounded-md cursor-default dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
                            {!! __('pagination.next') !!}
                        </span>
                        @endif
                </div>

                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">


                    <div>
                        <span class="relative z-0 inline-flex rounded-md shadow-sm rtl:flex-row-reverse">
                            {{-- Previous Page Link --}}
                            @if ($page === 0)
                            <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                                <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md dark:bg-gray-800 dark:border-gray-600" aria-hidden="true">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </span>
                            @else
                            <a href="{{ route('concept.examples', ['dictionary' => $dictionary->id, 'concept' => $concept->id, 'page' => $previousPage]) }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-l-md hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800" aria-label="{{ __('pagination.previous') }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            @endif
                            @foreach ($pagingItems as $link)
                            @if ($link === '...')
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium leading-5 text-gray-700 bg-white border border-gray-300 cursor-default dark:bg-gray-800 dark:border-gray-600">{{ "..." }}</span>
                            </span>
                            @else

                            <a href="{{ route('concept.examples', ['dictionary' => $dictionary->id, 'concept' => $concept->id, 'page' => $link]) }}" class="{{$link === $page ? 'underline' : ''}} relative inline-flex items-center px-2 py-2 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out bg-white border border-gray-300 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800">
                                {{ $link }}
                            </a>
                            @endif

                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($page < $countPages) <a href="{{ route('concept.examples', ['dictionary' => $dictionary->id, 'concept' => $concept->id, 'page' => $nextPage]) }}" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-r-md hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800" aria-label="{{ __('pagination.next') }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                                </a>
                                @else
                                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                                    <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md dark:bg-gray-800 dark:border-gray-600" aria-hidden="true">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </span>
                                @endif
                        </span>
                    </div>
                </div>
            </nav>
            @endif
        </div>
