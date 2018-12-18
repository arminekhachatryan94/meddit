<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UserRoleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $db = app()->make('db');
        $db->getSchemaBuilder()->enableForeignKeyConstraints();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Contracts\UserRoleContract', 'App\Services\UserRoleService');
    }
}
