<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Task;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // Gate::policy(Label::class, LabelPolicy::class);
        /*
        Gate::define('create-task', function (User $user) {
            return $user !== null;
        });

        Gate::define('create-taskStatus', function (User $user) {
            return $user !== null;
        });

        Gate::define('create-label', function (User $user) {
            return $user !== null;
        });

        Gate::define('edit-task', function (User $user) {
            return $user !== null;
        });

        Gate::define('edit-taskStatus', function (User $user) {
            return $user !== null;
        });

        Gate::define('edit-label', function (User $user) {
            return $user !== null;
        });

        Gate::define('store-task', function (User $user) {

            return  $user !== null;
        });

        Gate::define('update-task', function (User $user) {

            return $user !== null;
        });

        Gate::define('delete-task', function (User $user, Task $task) {

            return $user->id === $task->created_by_id;
        });

        Gate::define('store-taskStatus', function (User $user) {

            return  $user !== null;
        });

        Gate::define('update-taskStatus', function (User $user) {

            return $user !== null;
        });

        Gate::define('delete-taskStatus', function (User $user) {

            return $user !== null;
        });

        Gate::define('store-label', function (User $user) {

            return  $user !== null;
        });

        Gate::define('update-label', function (User $user) {

            return $user !== null;
        });

        Gate::define('delete-label', function (User $user) {

            return $user !== null;
        });*/
    }
}
