<?php

namespace LaravelExceptionReporter;

use Illuminate\Support\ServiceProvider;

class ExceptionReporterServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'laravelExceptionReporter');

        $this->publishes([
            __DIR__.'/config/laravelExceptionReporter.php' => config_path('laravelExceptionReporter.php'),
        ], 'config');
        // $this->publishes([__DIR__.'/views' => resource_path('views/vendor/laravelExceptionReporter')], 'views');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/laravelExceptionReporter.php',
            'laravelExceptionReporter'
        );
    }
}
