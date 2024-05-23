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
    @can('must-be-owner', $concept->dictionary)
    <a href="{{route('concept.example.create', $concept) }}" class="px-3 py-2 text-sm font-medium text-center text-blue-500 transition-all border border-blue-500 rounded-lg hover:text-white hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:border-blue-700 dark:text-blue-700 dark:hover:text-white dark:hover:bg-blue-800 dark:focus:ring-blue-800">
        {{__('shared.add')}}
    </a>
    @endcan
</div>
<div class="overflow-x-auto overflow-y-scroll shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
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
                <th scope="row" class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $k }}</th>
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
</div>
