@props(['label', 'id', 'textareaClass', 'name', 'value', 'dictionary'])

<div class="container">
    <label for="{{$id}}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{$label}}</label">
        <div class="options my-2">
            <button data-modal-target="concept-link-modal" data-modal-toggle="concept-link-modal" id="concept-link" type="button" class="inline-flex group items-center py-1 px-2 me-2 mb-2 text-xs font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                <span class="mr-2">{{__('Ссылка на понятие')}}</span>
                <svg class="group-hover:animate-spin w-4 h-4 text-gray-800 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.213 9.787a3.391 3.391 0 0 0-4.795 0l-3.425 3.426a3.39 3.39 0 0 0 4.795 4.794l.321-.304m-.321-4.49a3.39 3.39 0 0 0 4.795 0l3.424-3.426a3.39 3.39 0 0 0-4.794-4.795l-1.028.961" />
                </svg>
            </button>
            <button id="special-button" data-modal-target="external-link-modal" data-modal-toggle="external-link-modal" type="button" class="group inline-flex items-center py-1 px-2 me-2 mb-2 text-xs font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                <span class="mr-2">{{__('Внешняя ссылка')}}</span>
                <svg class="group-hover:animate-spin  w-4 h-4 text-gray-800 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 14v4.833A1.166 1.166 0 0 1 16.833 20H5.167A1.167 1.167 0 0 1 4 18.833V7.167A1.166 1.166 0 0 1 5.167 6h4.618m4.447-2H20v5.768m-7.889 2.121 7.778-7.778" />
                </svg>
            </button>
            <div id="concept-link-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{__('Вставка ссылки на понятие')}}
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="concept-link-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">{{__('Закрыть окно')}}</span>
                            </button>
                        </div>
                        <div class="p-4 md:p-5 space-y-4">
                            <label for="concept" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Понятие')}}</label>
                            <select id="concept" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach ($dictionary->concepts as $concept)
                                <option value="{{route('concept.show', [$concept->dictionary, $concept])}}">{{$concept->name}}</option>
                                @endforeach
                            </select>
                            <label for="link-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__("Название ссылки")}}</label>
                            <input type="text" id="link-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button id="insert-concept-link" data-modal-hide="concept-link-modal" type="button" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                {{__('Вставить')}}
                                <svg class="ms-1 w-4 h-4 pt-px text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="external-link-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{__("Вставка ссылки")}}
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="external-link-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">{{__('Закрыть окно')}}</span>
                            </button>
                        </div>
                        <div class="p-4 md:p-5 space-y-4">
                            <label for="elink" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__("Ссылка")}}</label>
                            <input type="text" name="elink" id="elink" class="block w-full p-2.5 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <label for="elink-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__("Название ссылки")}}</label>
                            <input type="text" id="elink-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                        </div>
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button id="insert-elink" type="button" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                {{__('Вставить')}}
                                <svg class="ms-1 w-4 h-4 pt-px text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z" clip-rule="evenodd" />
                                </svg>

                            </button>
                            <button id="close-elink-modal" data-modal-hide="external-link-modal" type="button"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <textarea name="{{$name}}" id="textarea" class="hidden">{{$value}}</textarea>
        <div contenteditable id="{{$id}}" class="{{$textareaClass}} w-full max-w-xl whitespace-pre-wrap overflow-y-auto leading-relaxed break-words">{!! $value !!}</div>

        <script>
            const textarea = document.getElementById("textarea");
            const contenteditable = document.getElementById("{{$id}}");
            const inputLinkName = document.getElementById("link-name");
            const btnInsertConceptLink = document.getElementById("insert-concept-link");
            const conceptSelect = document.getElementById("concept");

            btnInsertConceptLink.addEventListener("click", () => {
                let selected = conceptSelect.options[conceptSelect.selectedIndex];
                let linkText = inputLinkName.value || selected.text;
                let linkURL = selected.value;

                let link = document.createElement("a");
                link.className = 'dl';
                link.href = linkURL;
                link.textContent = linkText;
                inputLinkName.value = "";
                contenteditable.append(link);
                onChange();
            })
            contenteditable.addEventListener('input', onChange);

            function onChange() {
                textarea.textContent = contenteditable.innerHTML;
            }

            const elink = document.getElementById("elink");
            const elinkName = document.getElementById("elink-name");
            const btnInsertElink = document.getElementById("insert-elink");
            btnInsertElink.addEventListener("click", (e) => {
                if (!elinkName.value) {
                    alert("Название ссылки не может быть пустым");
                    return;
                }
                let link = document.createElement("a");
                link.className = 'el';
                link.href = elink.value;
                link.textContent = elinkName.value;
                elink.value = "";
                elinkName.value = "";
                contenteditable.append(link);
                document.getElementById('close-elink-modal').click();
                onChange();
            })
        </script>
