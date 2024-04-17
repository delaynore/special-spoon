<x-layout.main>
    <div class="min-h-screen flex items-center justify-center">
        <section class=" select-none rounded-xl">
            <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                <div class="mx-auto max-w-screen-sm text-center">
                    <h1 class="mb-4 text-7xl tracking-tight font-extrabold lg:text-9xl text-primary-600 dark:text-primary-500">404</h1>
                    <p class="mb-4 text-3xl tracking-tight font-bold text-gray-900 md:text-4xl dark:text-white">{{ __('Что-то пошло не так')}}</p>
                    <p class="mb-4 text-lg font-light text-gray-500 dark:text-gray-400">{{ __('Простите, но такой страницы не существует')}}</p>
                    <a href="{{ route('home') }}" class="inline-flex text-white bg-primary-600 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-primary-900 my-4">{{ __('Вернуться на главную')}}</a>
                </div>
            </div>
        </section>
    </div>
</x-layout.main>
