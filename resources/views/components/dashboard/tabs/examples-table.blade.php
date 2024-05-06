@php
$attributes = \App\Models\Attribute::join('concept_attributes', 'attributes.id', '=', 'concept_attributes.fk_attribute_id')
->where('concept_attributes.fk_concept_id', $concept->id)
->selectRaw('attributes.name')
->orderBy('concept_attributes.created_at')
->get();

$exampleNumbers = \App\Models\ConceptAttributeValue::join('concept_attributes', 'concept_attribute_values.fk_concept_attribute_id', '=', 'concept_attributes.id')
->join('concepts', 'concept_attributes.fk_concept_id', '=', 'concepts.id')
->where('concept_attributes.fk_concept_id', $concept->id)
->selectRaw('concept_attribute_values.example_number')
->groupBy('concept_attribute_values.example_number')
->orderBy('concept_attribute_values.example_number')
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
    @if (Auth::check() && Auth::user()->id === $dictionary->user->id)
    <a href="{{route('concept.example.create', $concept) }}" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
        </svg>
        {{ __('Добавить') }}
    </a>
    @endif
</div>
<div class="overflow-x-auto overflow-y-scroll shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-gray-500 dark:text-gray-400 text-center">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-2 py-3">
                    Номер
                </th>
                @foreach ($attributes as $attribute)

                <th scope="col" class="px-2 py-3">
                    {{ $attribute->name }}
                </th>
                @endforeach
                @if (Auth::check() && Auth::user()->id === $dictionary->user->id)
                <th scope="col" class="px-2 py-3">
                    <span class="sr-only">Редактировать</span>
                </th>
                <th scope="col" class="px-2 py-3">
                    <span class="sr-only">Удалить</span>
                </th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($array_examples as $k => $v)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $k }}</th>
                @foreach ($v as $value)
                <th scope="row" class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $value }}
                </th>
                @endforeach
                @if (Auth::check() && Auth::user()->id === $dictionary->user->id)
                <td class="px-2 py-2">
                    <a href="{{route('concept.example.edit', [$concept, 'exampleNumber' => $k])}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __('Изменить')}}</a>
                </td>
                <td class="px-2 py-2">
                    <form action="{{route('concept.example.destroy', [$concept, 'exampleNumber' => $k])}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">{{ __('Удалить')}}</button>
                    </form>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
