<?php

namespace App\Providers;

use App\Enums\Visibility;
use App\Models\Dictionary;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        #region Dictionary gates
        Gate::define('index-dictionary', function () {
            return Auth::check();
        });
        Gate::define('destroy-dictionary', function (User $user, Dictionary $dictionary) {
            return $user->id === $dictionary->fk_user_id;
        });
        Gate::define('edit-dictionary', function (User $user, Dictionary $dictionary) {
            return $user->id === $dictionary->fk_user_id;
        });
        Gate::define('update-dictionary', function (User $user, Dictionary $dictionary) {
            return $user->id === $dictionary->fk_user_id;
        });
        Gate::define('show-dictionary', function (User $user, Dictionary $dictionary) {
            return $user->id === $dictionary->fk_user_id || ($dictionary->visibility === Visibility::PUBLIC && Auth::check());
        });
        Gate::define('export-dictionary', function (User $user, Dictionary $dictionary) {
            return $user->id === $dictionary->fk_user_id || ($dictionary->visibility === Visibility::PUBLIC && Auth::check());
        });
        Gate::define('store-dictionary', function () {
            return Auth::check();
        });
        Gate::define('create-dictionary', function () {
            return Auth::check();
        });
        #endregion
    }
}
