<?php

namespace RBooks\Providers;

use Illuminate\Support\ServiceProvider;

class RBooksServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //git
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Repositories
        foreach(config('rbooks.repositories') as $repository) {
            $this->app->singleton($repository, function($app) use ($repository) {
                return new $repository($app);
            });
        }

        // Singleton for Service
        foreach(config('rbooks.services') as $service) {
            $this->app->singleton($service, function ($app) use ($service) {
                return new $service();
            });
        }
    }
}
