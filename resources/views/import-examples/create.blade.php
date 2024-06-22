@props([
'dictionary',
'concept',
'conceptAttributes',
])

@php
    use App\Enums\DataType;
@endphp

<x-layout.main>
    <x-slot name="navigation"></x-slot>
    <x-slot:title>{{ __('import.title') }}</x-slot:title>

    <div class="flex items-center justify-center w-full overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-5xl p-4 md:h-auto">
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <div class="flex items-center justify-between pb-4 mb-2 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ __('import.header', ['concept' => $concept->name]) }}
                    </h3>
                    <a href="{{ route('concept.examples', [$dictionary, $concept]) }}" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">{{ __('screen-reader.modal.close')}}</span>
                    </a>
                </div>
                <div class="py-2 mb-2 border-b border-gray-200 dark:text-gray-200">
                    <p>{{ __('import.description') }}</p>
                    <p class="text-sm p-2.5 text-gray-900 bg-gray-100 rounded-lg border border-gray-300  dark:bg-gray-600 dark:border-gray-800 dark:placeholder-gray-400 dark:text-white">
                        {{join(';', $conceptAttributes->pluck('name')->toArray())}}
                    </p>
                    <p class="mt-2">{{ __('import.unforget-attribute-types') }}</p>
                    <div class="relative overflow-x-auto">
                        <table class="text-sm text-left text-gray-500 w-fit dark:text-gray-400">
                            <thead class="text-xs text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <th class="px-2 py-2">
                                    {{ __('import.table.headers.attribute') }}
                                </th>
                                <th class="px-2 py-2">
                                    {{ __('import.table.headers.type') }}
                                </th>
                                <th class="px-2 py-2">
                                    {{ __('import.table.headers.example') }}
                                </th>
                            </thead>
                            <tbody>
                                @foreach ($conceptAttributes as $conceptAttribute)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-2 py-2">{{ $conceptAttribute->name }}</td>
                                    <td class="px-2 py-2">{{ $conceptAttribute->type }}</td>
                                    @switch(DataType::from($conceptAttribute->type))
                                        @case(DataType::INTEGER)
                                            <td class="px-2 py-2">{{__('import.table.types.integer')}}</td>
                                            @break
                                        @case(DataType::STRING)
                                        <td class="px-2 py-2">{{__('import.table.types.string')}}</td>
                                        @break
                                        @case(DataType::BOOLEAN)
                                        <td class="px-2 py-2">{{__('import.table.types.boolean')}}</td>
                                        @break
                                        @case(DataType::DECIMAL)
                                        <td class="px-2 py-2">{{__('import.table.types.decimal')}}</td>
                                        @break
                                        @case(DataType::DOUBLE)
                                        <td class="px-2 py-2">{{__('import.table.types.double')}}</td>
                                        @break
                                        @default

                                    @endswitch
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <form enctype="multipart/form-data" method="post" action="{{route('import.store', [$dictionary, $concept])}}">
                    @csrf
                    <div class="grid gap-4 mb-4">
                        <div class="col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file">{{ __('attachment-page.create.file.label')}}</label>
                            <input accept=".txt,.csv" value="{{ old('file') }}" name="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file" type="file">
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ __('import.available-file-types') }}</p>
                        </div>
                    </div>
                    <button type="submit" class="text-white inline-flex items-center bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800">
                        {{ __('import.submit') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

</x-layout.main>
