<?php

namespace PrinceJohn\LaravelConfigBuilder;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use PrinceJohn\LaravelConfigBuilder\Commands\BuildConfig;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/config-builder.php' => config_path('config-builder.php'),
        ]);

        $this->commands([
            BuildConfig::class,
        ]);

    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config-builder.php', 'config-builder');
    }
}
