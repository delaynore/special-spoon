<ul class="flex flex-col items-center p-4 mt-4 font-medium border border-gray-100 rounded-lg md:p-0 bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 dark:border-gray-700">
    <x-navigation.primary-item href="{{route('home')}}" class="py-2.5">
        {{ __('navigation.home') }}
    </x-navigation.primary-item>
    <x-navigation.primary-item href="{{route('my')}}" class="py-2.5">
        {{ __('navigation.my-dictionaries') }}
    </x-navigation.primary-item>


    @auth
        <li>
            <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" class="flex items-center justify-between w-full px-3 py-2 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">{{ __('Личный кабинет') }} <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg></button>

            <!-- Dropdown menu -->
            <div id="dropdownNavbar" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                    <x-navigation.secondary-item href="{{route('profile.edit')}}">
                        {{ __('shared.settings') }}
                    </x-navigation.secondary-item>
                    <x-navigation.secondary-item href="{{route('attribute.index')}}">
                        {{ __('entities.attribute.plural') }}
                    </x-navigation.secondary-item>
                    <x-navigation.secondary-item href="{{route('tag.index')}}">
                        {{ __('entities.tag.plural') }}
                    </x-navigation.secondary-item>
                    <x-navigation.secondary-item href="{{route('relation-type.index')}}">
                        {{ __('entities.relation-types.plural') }}
                    </x-navigation.secondary-item>
                </ul>
                <div class="w-full py-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button onclick="event.preventDefault();this.closest('form').submit();" class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:text-red-500 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">{{ __('Выйти')}}</м>
                    </form>
                </div>
            </div>
        </li>
    @endauth

    @guest
        <x-navigation.primary-item href="{{ route('login') }}" :sign="true">{{ __('auth.login.button-login') }}</x-navigation.primary-item>
    @endguest

    <x-theme-toggle></x-theme-toggle>
</ul>
