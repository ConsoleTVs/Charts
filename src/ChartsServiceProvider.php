<?php

namespace ConsoleTVs\Charts;

use Illuminate\Support\ServiceProvider;

class ChartsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/charts.php' => config_path('charts.php'),
        ], 'charts_config');

        $this->publishes([
            __DIR__.'/Assets' => public_path('vendor/consoletvs/charts'),
        ], 'charts_assets');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/charts.php', 'charts'
        );
    }
}
