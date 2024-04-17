<x-layout.main>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Спасибо за регистрацию! Прежде чем начать, могли бы вы подтвердить свой адрес электронной почты, нажав на ссылку, которую мы только что отправили вам? Если вы не получили письмо, мы с радостью отправим вам еще одно.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('На адрес электронной почты, который вы указали при регистрации, выслана новая ссылка для подтверждения.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Отправить письмо с подтверждением повторно') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Выйти') }}
            </button>
        </form>
    </div>
</x-layout.main>
