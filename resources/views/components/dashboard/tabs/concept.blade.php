@props(['dictionary', 'concepts', 'concept', 'conceptRelations'])

<x-layout.dashboard :dictionary="$dictionary" :concepts="$concepts">
    @include('components.dashboard.tabs.breadcrumbs', [$concept])
    @include('components.dashboard.tabs.tabs')
    <div class="w-full p-2.5">
        <div class="flex items-center justify-between mb-3">
            <div class="flex-grow-1">
                <h5 class="text-2xl font-bold text-gray-900 break-words dark:text-white text-wrap">{{$concept->name}}</h5>
            </div>
            <div class="">
                @can('must-be-owner', $concept->dictionary)
                <a href="{{route('concept.edit', [$dictionary, $concept])}}" class="px-3 py-2 text-sm font-medium text-center text-green-500 transition-all border border-green-500 rounded-lg hover:text-white hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 dark:border-green-700 dark:text-green-700 dark:hover:text-white dark:hover:bg-green-800 dark:focus:ring-green-800">
                    {{__('shared.edit')}}
                </a>
                @endcan
            </div>
        </div>
        <div class="block w-full min-h-12 text-sm p-2.5 text-gray-900 bg-gray-50 rounded-lg border border-gray-300  dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
            {!! $concept->definition !!}
        </div>
        <div class="w-[calc(100%+2*1.65rem)] -ml-[1.65rem] border-b border-gray-300 dark:border-gray-500 mt-3">
        </div>
        <div class="flex items-center justify-between mt-4">
            <p class="text-2xl text-gray-900 break-words dark:text-gray-500 text-wrap">Отношения</p>
            @can('must-be-owner', $concept->dictionary)
            <a href="{{route('concept.relation.create', [$dictionary, $concept])}}" class="px-3 py-2 text-sm font-medium text-center text-blue-500 transition-all border border-blue-500 rounded-lg hover:text-white hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:border-blue-700 dark:text-blue-700 dark:hover:text-white dark:hover:bg-blue-800 dark:focus:ring-blue-800">
                {{__('shared.add')}}
            </a>
            @endcan
        </div>
        @if($conceptRelations)
        <div class="flex items-center justify-between mt-4 mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                @foreach ($conceptRelations as $k => $conceptRelation)
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="tab{{$k}}" data-tabs-target="#tab-content{{$k}}" role="tab" type="button" role="tab" aria-controls="{{$k}}" aria-selected="false">
                        {{$conceptRelation[0]->name_plural ?? $conceptRelation[0]->name}}
                    </button>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
        <div id="default-tab-content">
            @foreach ($conceptRelations as $k => $conceptRelation)
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="tab-content{{$k}}" role="tabpanel" aria-labelledby="tab{{$k}}">
                @if (empty($conceptRelation[1]))
                <div class="flex items-center justify-center h-40 my-2 text-xl antialiased dark:text-gray-100">
                    {{ __('shared.empty-records') }}
                </div>
                @else
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-2 py-3">
                                    {{ __('entities.concept.singular')}}
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    <span class="sr-only">{{ __('shared.action')}}</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($conceptRelation[1] as $relatedConcept)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-200">
                                    <a href="{{route('concept.show', [$dictionary, $relatedConcept->concept_id])}}" class="hover:underline">{{$relatedConcept->concept_name}}</a>
                                </th>
                                <td class="flex items-center justify-end gap-4 px-6 py-4 ">
                                    @can('must-be-owner', $concept->dictionary)
                                    <a href="{{route('concept.relation.edit',  [$dictionary, $concept, 'relation' => $relatedConcept->relation_id])}}" class="font-medium text-green-600 dark:text-green-500 hover:underline">{{ __('shared.edit')}}</a>
                                    @endcan
                                    @can('must-be-owner', $concept->dictionary)
                                    <div class="flex justify-center">
                                        <button id="delete-{{$relatedConcept->relation_id}}" data-modal-target="delete-entity-{{$relatedConcept->relation_id}}" data-modal-toggle="delete-entity-{{$relatedConcept->relation_id}}" class="font-medium text-red-600 dark:text-red-500 hover:underline" type="button">
                                            {{ __('shared.delete')}}
                                        </button>
                                    </div>
                                    <div id="delete-entity-{{$relatedConcept->relation_id}}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                                        <div class="relative w-full h-full max-w-md p-4 md:h-auto">
                                            <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                                <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="delete-entity-{{$relatedConcept->relation_id}}">
                                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="sr-only">{{ __('screen-reader.modal.close') }}</span>
                                                </button>
                                                <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                <p class="mb-4 text-gray-500 dark:text-gray-300">{{ __('shared.confirm-delete.description', ['name' => $relatedConcept->concept_name, 'type' => Str::lower(__('entities.relation.singular'))]) }}</p>
                                                <div class="flex items-center justify-center space-x-4">
                                                    <button data-modal-toggle="delete-entity-{{$relatedConcept->relation_id}}" type="button" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                        {{ __('shared.confirm-delete.no') }}
                                                    </button>
                                                    <form action="{{route('concept.relation.destroy', [$dictionary, $concept, $relatedConcept->relation_id])}}" method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                            {{ __('shared.confirm-delete.yes') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            @endforeach
        </div>
</x-layout.dashboard>
