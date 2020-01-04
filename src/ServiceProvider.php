<?php
/**
 *
 */
namespace Atlasman\LaravelCallback;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as DefaultServiceProvider;

class ServiceProvider extends DefaultServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/laracallback.php' => config_path('laracallback.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../stubs/LaravelCallbackServiceProvider.stub' => app_path('Providers/LaravelCallbackServiceProvider.php'),
            ], 'provider');

        }

        // register commands
        $this->commands([
            Console\CreateProcessorCommand::class
        ]);

        // register routes
        Route::any(config('laracallback.path'), 'Atlasman\LaravelCallback\Http\Controllers\CallbackController@execute');

    }
}