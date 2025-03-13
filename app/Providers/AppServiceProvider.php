<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Task;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
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
        });
    }
}
