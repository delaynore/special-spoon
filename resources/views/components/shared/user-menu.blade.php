<button type="button" class="flex px-2 py-1 text-sm rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
    <span class="sr-only">{{ __('screen-reader.modal.open') }}</span>
    <span class="block text-sm text-gray-900 dark:text-white">{{Auth::user()->name}}</span>
</button>
<!-- Dropdown menu -->
@auth
<div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
    <div class="px-4 py-3">
        <span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{Auth::user()->email}}</span>
    </div>

    <ul class="py-2" aria-labelledby="user-menu-button">
        <li>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">{{ __('shared.settings')}}</a>
        </li>

        <li>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">{{ __('auth.verify.logout')}}</a>
        </li>
    </ul>
</div>
@endauth
