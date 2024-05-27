<x-layout.main>
    <section class="w-full bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <x-shared.logo-title :href="route('home')"/>
            <div class="w-full p-6 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md dark:bg-gray-800 dark:border-gray-700 sm:p-8">
                <h1 class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    {{ __('auth.forgot-password.title')}}
                </h1>
                <p class="font-light text-gray-500 dark:text-gray-400">{{__('auth.forgot-password.description')}}</p>
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" action="{{ route('password.email')}}" method="post">
                    @csrf
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('auth.forgot-password.email.label')}}</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('auth.forgot-password.email.placeholder') }}" value="{{old('email')}}" required autocomplete="email" autofocus>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{ __('auth.forgot-password.button') }}</button>
                </form>
            </div>
        </div>
    </section>
</x-layout.main>
