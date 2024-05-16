@props(['dictionaries'])

<x-layout.main>
    <x-slot:title>{{ __('home-page.title') }}</x-slot:title>
    <x-slot name="navigation"></x-slot>

    <section class="flex items-start w-full mb-4">
        <div class="w-full max-w-screen-xl px-4 mx-auto mt-3 lg:px-12">
            <div class="relative bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center" method="GET">
                            <label for="search" class="sr-only">{{ __('shared.search') }}</label>
                            <div class="relative flex items-center justify-start w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="search" id="search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __('shared.search') }}" value="{{ request('search') }}">
                                <button type="submit" class="block px-3 py-2 text-sm text-gray-900 border border-gray-300 rounded-lg ms-2 bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">{{ __('shared.search') }}</button>
                            </div>
                        </form>
                    </div>
                    <div class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                        <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                            {{ __('shared.filter') }}
                            <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                        <div id="filterDropdown" class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('home-page.filter.type') }}
                            </h6>
                            <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                <li class="flex items-center">
                                    <input id="private" type="checkbox" value="private" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                    <label for="private" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ __('home-page.visibility.private') }}
                                    </label>
                                </li>
                                <li class="flex items-center">
                                    <input id="public" type="checkbox" value="public" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                    <label for="public" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ __('home-page.visibility.public') }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    @empty($dictionaries)
                    <div class="flex items-center justify-center h-40 my-2 text-xl antialiased">
                        {{ __('shared.empty-records') }}
                    </div>
                    @endempty
                    <div class="px-4">
                        @foreach ($dictionaries as $dictionary)
                        <a data-route="{{route('dictionary.show', $dictionary->id)}}" class="flex items-center justify-end px-4 py-2 my-2 bg-white border border-gray-200 rounded-lg shadow dictionary-card hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <div class="flex flex-col justify-between flex-1 leading-normal me-4">
                                @if (Auth::check() && Auth::user()->id === $dictionary->user->id)
                                <p class="mt-1 bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 w-fit">{{__('home-page.your')}}</p>
                                @else
                                <p class="mt-1 bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 w-fit">{{$dictionary->user->name}}</p>
                                @endif
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{$dictionary->name}}</h5>
                                <p class="hidden mb-3 font-normal text-gray-700 md:block dark:text-gray-400">{{$dictionary->description}}</p>
                                @if($dictionary->tags()->count() > 0)
                                <div>
                                    @foreach ($dictionary->tags as $tag)
                                    <span class="{{$loop->iteration > 5 ? 'hidden md:inline' : ''}} bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 w-20 h-3 dark:text-blue-300">{{$tag->name}}</span>
                                    @endforeach
                                </div>
                                @endif()

                            </div>
                            <div class="flex flex-col items-center justify-center">
                                <button id="{{$dictionary->id}}-button" data-dropdown-toggle="{{$dictionary->id}}" class="h-full inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                    <svg class="w-6 h-6 transition-all rotate-90 active:rotate-180" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                            </div>
                        </a>

                        <div id="{{$dictionary->id}}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="text-sm text-gray-700 dark:text-gray-200" aria-labelledby="{{$dictionary->id}}-button">
                                @if (Auth::check())
                                <li>
                                    <a href="{{route('dictionary.show', $dictionary->id)}}" class="flex items-center justify-between w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                        {{ __('shared.submit.open')}}
                                        <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>
                                </li>
                                @if (Auth::user()->id === $dictionary->user->id)
                                <li>
                                    <a href="{{ route('dictionary.edit', $dictionary->id) }}" class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{__('shared.edit')}}
                                        <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                        </svg>
                                    </a>
                                </li>
                                @endif
                                @endif
                            </ul>
                            <div class="py-1">
                                <input id="link-dictionary{{$dictionary->id}}" type="text" class="hidden link-dictionary" value="{{route('dictionary.show', $dictionary->id)}}" disabled readonly>
                                <div data-copy-to-clipboard-target="link-dictionary{{$dictionary->id}}" class="flex items-center justify-between w-full px-4 py-2 text-gray-700 cursor-pointer select-none btn-dictionary hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white active:scale-95">
                                    {{ __('shared.link') }}
                                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.213 9.787a3.391 3.391 0 0 0-4.795 0l-3.425 3.426a3.39 3.39 0 0 0 4.795 4.794l.321-.304m-.321-4.49a3.39 3.39 0 0 0 4.795 0l3.424-3.426a3.39 3.39 0 0 0-4.794-4.795l-1.028.961" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="mb-2">
                            {{$dictionaries->links()}}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>


</x-layout.main>
