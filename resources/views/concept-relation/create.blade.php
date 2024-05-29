@props(['dictionary', 'concept', 'relationTypes', 'concepts'])

<x-layout.main>
    <x-slot name="navigation"></x-slot>
    <x-slot:title>{{ __('dashboard.relation.create.title') }}</x-slot:title>

    <div class="flex items-center justify-center w-full overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-2xl p-4 md:h-auto">
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <div class="flex items-center justify-between pb-4 mb-4 border-b rounded-t sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ __('dashboard.relation.create.form.title', ['concept' => $concept->name]) }}
                    </h3>
                    <a href="{{ route('concept.show', [$dictionary, $concept]) }}" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">{{ __('screen-reader.modal.close')}}</span>
                    </a>
                </div>
                <form method="post" action="{{route('concept.relation.store', [$dictionary, $concept])}}">
                    @csrf
                    <input hidden readonly name="fk_concept_1_id" value="{{ $concept->id }}">
                    <div class="grid gap-4 mb-4">
                        <div class="col-span-2">
                            <label for="fk_relation_type_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('dashboard.relation.create.form.type')}}</label>
                            <select autofocus required name="fk_relation_type_id" class="bg-gray-50 cursor-pointer border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @foreach($relationTypes as $type)
                                <option value="{{ $type->id }}" @selected(old('fk_relation_type_id') === $type->id)>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('fk_relation_type_id')" class="mt-2" />
                        </div>
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('dashboard.relation.create.form.concept') }}</label>
                            <select required name="fk_concept_2_id" class="bg-gray-50 cursor-pointer border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @foreach($concepts as $c)
                                    @continue($c->id === $concept->id)
                                    <option value="{{ $c->id }}" @selected(old('fk_concept_2_id') === $c->id)>{{ $c->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('fk_concept_2_id')" class="mt-2" />
                        </div>
                    </div>
                    <button type="submit" class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        <svg class="w-6 h-6 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ __('shared.add') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

</x-layout.main>
