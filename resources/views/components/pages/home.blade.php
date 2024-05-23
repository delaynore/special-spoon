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
                                @auth
                                <li>
                                    <a href="{{route('dictionary.show', $dictionary->id)}}" class="flex items-center justify-between w-full px-4 py-2 text-sm text-gray-700 group hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                        {{ __('shared.submit.open')}}
                                        <svg class="w-4 h-4" data-slot="icon" aria-hidden="true" fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path class="text-transparent transition-all delay-200 group-hover:text-inherit" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                </li>
                                @can('must-be-owner', $dictionary)
                                <li>
                                    <a href="{{ route('dictionary.edit', $dictionary->id) }}" class="flex items-center justify-between px-4 py-2 group hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{__('shared.edit')}}
                                        <svg class="w-4 h-4 text-gray-800 dark:text-white group-hover:animate-pulse" data-slot="icon" aria-hidden="true" fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                </li>
                                @endif
                                @endauth
                            </ul>
                            <div class="py-1">
                                <input id="link-dictionary{{$dictionary->id}}" type="text" class="hidden link-dictionary" value="{{route('dictionary.show', $dictionary->id)}}" disabled readonly>
                                <div data-copy-to-clipboard-target="link-dictionary{{$dictionary->id}}" class="flex items-center justify-between w-full px-4 py-2 text-sm text-gray-700 cursor-pointer select-none group btn-dictionary hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white active:scale-95">
                                    {{ __('shared.link') }}
                                    <svg class="w-4 h-4 text-gray-800 dark:text-white group-hover:animate-pulse" data-slot="icon" aria-hidden="true" fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" stroke-linecap="round" stroke-linejoin="round"></path>
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
