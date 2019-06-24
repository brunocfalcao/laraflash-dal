<?php

namespace Laraflash\DAL;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laraflash\DAL\Models\User;

class LaraflashDALServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Schema::defaultStringLength(191);

        $timestamp = date('Y_m_d_His', time());

        $this->publishes([
            __DIR__.'/../Database/Migrations/update_laraflash_schema_001.php.stub' => $this->app->databasePath()."/migrations/{$timestamp}_update_laraflash_schema_001.php",
        ], 'laraflash-update-schema-latest');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        Auth::newGuard('laraflash-wave', User::class);
    }

    public function register()
    {
    }
}
