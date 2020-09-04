<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            'App\Services\Contracts\IProfileService',
            'App\Services\ProfileService'
        );
        $this->app->bind(
            'App\Services\Contracts\IPostService',
            'App\Services\PostService'
        );
    }
}
