<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Contracts\IPostRepo',
            'App\Repositories\PostRepo'
        );
        $this->app->bind(
            'App\Repositories\Contracts\ITagRepo',
            'App\Repositories\TagRepo'
        );
        $this->app->bind(
            'App\Repositories\Contracts\IAttachmentRepo',
            'App\Repositories\AttachmentRepo'
        );
        $this->app->bind(
            'App\Repositories\Contracts\IProfileRepo',
            'App\Repositories\ProfileRepo'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
