<x-layout.main>
    <x-slot name="navigation"></x-slot>
    <x-slot:title>{{ __('dictionary-page.edit.title') }}</x-slot:title>
    <div class="flex items-center justify-center w-full overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-2xl p-4 md:h-auto">
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <div class="flex items-center justify-between pb-4 mb-4 border-b rounded-t sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ __('dictionary-page.edit.title') }}
                    </h3>
                    <a href="{{ route('my') }}" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">{{__('screen-reader.modal.close')}}</span>
                    </a>
                </div>
                <form action="{{route('dictionary.update', $dictionary)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 mb-4">
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('dictionary-page.create.name.label')}}</label>
                            <input maxlength="50" autofocus type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __('dictionary-page.create.name.placeholder') }}" value="{{$dictionary->name}}" required="">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="col-span-2">
                            <label for="visibility" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('dictionary-page.edit.visibility.label')}}</label>
                            <select id="visibility" name="visibility" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option value="public" @selected((old('visibility') ?? $dictionary->visibility->value) == App\Enums\Visibility::PUBLIC->value)>{{ __('dictionary-page.edit.visibility.public') }}</option>
                                <option value="private" @selected((old('visibility') ?? $dictionary->visibility->value) == App\Enums\Visibility::PRIVATE->value)>{{ __('dictionary-page.create.visibility.private') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('visibility')" class="mt-2" />
                        </div>
                        <div class="col-span-2">
                            <label for="tags" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('dictionary-page.edit.tag.label')}}</label>
                            <select multiple name="tags[]" id="tags" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @php
                                $tags = \App\Models\Tag::all();
                                @endphp
                                @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" @selected(in_array($tag->id, old('tags') ?? $dictionary->tags->pluck('id')->toArray())) >{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('dictionary-page.edit.description.label')}}</label>
                            <textarea maxlength="500" id="description" name="description" rows="4" class="block p-2.5 w-full min-h-12 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{__('dictionary-page.edit.description.placeholder')}}">{{old('description') ?? $dictionary->description}}</textarea>
                        </div>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                    <div class="inline-flex space-x-4">
                        <button type="submit" class="text-white text-sm px-5 py-2.5 text-center inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                            <svg class="w-4 h-4 mr-1 -ml-1" fill="currentColor" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <path d="M14,0 L2,0 C0.9,0 0,0.9 0,2 L0,16 C0,17.1 0.9,18 2,18 L16,18 C17.1,18 18,17.1 18,16 L18,4 L14,0 L14,0 Z M9,16 C7.3,16 6,14.7 6,13 C6,11.3 7.3,10 9,10 C10.7,10 12,11.3 12,13 C12,14.7 10.7,16 9,16 L9,16 Z M12,6 L2,6 L2,2 L12,2 L12,6 L12,6 Z" id="Shape" />
                            </svg>
                            {{ __('shared.submit.update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.main>
