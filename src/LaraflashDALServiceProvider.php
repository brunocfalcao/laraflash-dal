<?php

namespace Laraflash\DAL;

use Laraflash\DAL\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class LaraflashDALServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Schema::defaultStringLength(191);

        $timestamp = date('Y_m_d_His', time());

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        Auth::newGuard('laraflash-wave', User::class);
    }

    public function register()
    {
    }
}
