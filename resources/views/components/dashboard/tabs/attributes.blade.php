@php
$attributes = $attributes = \App\Models\Attribute::join('concept_attributes', 'attributes.id', '=', 'concept_attributes.fk_attribute_id')
->where('concept_attributes.fk_concept_id', $concept->id)
->selectRaw('attributes.id, attributes.name, attributes.type')
->orderBy('concept_attributes.created_at')
->get();
$conceptAttr = \App\Models\ConceptAttribute::where('fk_concept_id', $concept->id)->orderBy('created_at')->get();
@endphp

<div class="flex justify-end my-2">
    @can('must-be-owner', $concept->dictionary)
    <a href="{{route('concept.attribute.create', [$dictionary, $concept])}}" class="px-3 py-2 text-sm font-medium text-center text-blue-500 transition-all border border-blue-500 rounded-lg hover:text-white hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:border-blue-700 dark:text-blue-700 dark:hover:text-white dark:hover:bg-blue-800 dark:focus:ring-blue-800">
        {{ __('shared.add') }}
    </a>
    @endcan
</div>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
        <caption class="px-6 py-2 text-lg font-semibold text-left text-gray-800 bg-white dark:text-gray-200 dark:bg-gray-800">
            {{__('dashboard.examples.attributes')}}
        </caption>
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-2 py-3">
                    {{ __('entities.attribute.props.name') }}
                </th>
                <th scope="col" class="px-2 py-3">
                    {{ __('entities.attribute.props.type') }}
                </th>
                @can('must-be-owner', $concept->dictionary)
                <th scope="col" class="px-2 py-3">
                    <span class="sr-only">{{__('shared.remove')}}</span>
                </th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach ($attributes as $attribute)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $attribute->name }}
                </th>
                <td class="px-2 py-2">
                    {{ $attribute->type->value }}
                </td>
                @can('must-be-owner', $concept->dictionary)
                <td class="px-2 py-2">
                    <form action="{{route('concept.attribute.destroy', [$dictionary, $concept, $conceptAttr->firstOrFail('fk_attribute_id', $attribute->id)->id])}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">{{ __('shared.remove')}}</button>
                    </form>
                </td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
