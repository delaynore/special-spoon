<x-layout.main>
    <x-slot:title>{{ __('auth.reset-password.title') }}</x-slot:title>
    <x-slot:navigation></x-slot>
    <section class="flex items-center justify-center w-full bg-gray-50 dark:bg-gray-900">
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('auth.reset-password.email.label')" />
                <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('auth.reset-password.password.label')" />
                <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('auth.reset-password.confirm-password.label')" />

                <x-text-input id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('auth.reset-password.button') }}
                </x-primary-button>
            </div>
        </form>
    </section>
</x-layout.main>
