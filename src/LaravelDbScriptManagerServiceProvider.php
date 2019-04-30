<?php

namespace Karlerss\LaravelDbScriptManager;

use Illuminate\Database\MigrationServiceProvider;
use Karlerss\LaravelDbScriptManager\Commands\MakeScriptCommand;
use Karlerss\LaravelDbScriptManager\Commands\MigrateCommand;
use Karlerss\LaravelDbScriptManager\Commands\MigrateScriptsCommand;

class LaravelDbScriptManagerServiceProvider extends MigrationServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-db-script-manager.php', 'laravel-db-script-manager');

        $this->app->singleton('command.migrate', function ($app) {
            return new MigrateCommand($app['migrator']);
        });


    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-db-script-manager'];
    }

    /**
     * Commands-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/laravel-db-script-manager.php' => config_path('laravel-db-script-manager.php'),
        ], 'laravel-db-script-manager.config');

        $this->commands([
            MakeScriptCommand::class,
        ]);
    }
}
