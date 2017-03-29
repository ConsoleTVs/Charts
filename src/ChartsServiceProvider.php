<?php

namespace ConsoleTVs\Charts;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ChartsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'charts');

        $this->publishes([
            __DIR__.'/../config/charts.php' => config_path('charts.php'),
        ], 'charts_config');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/consoletvs/charts'),
        ]);

        $this->registerBladeDirectives();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/charts.php', 'charts');

        $this->app->singleton(Builder::class, function($app) {
            return new Builder();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ Builder::class ];
    }

    private function registerBladeDirectives()
    {
        /*
         * php explode() function.
         *
         * Usage: @explode($delimiter, $string)
         */
        Blade::directive('explode', function($argumentString) {
            list($delimiter, $string) = $this->getArguments($argumentString);

            return "<?php echo explode({$delimiter}, {$string}); ?>";
        });

        /*
         * php implode() function.
         *
         * Usage: @implode($delimiter, $array)
         */
        Blade::directive('implode', function($argumentString) {
            list($delimiter, $array) = $this->getArguments($argumentString);

            return "<?php echo implode({$delimiter}, {$array}); ?>";
        });

        /*
         * Set variable.
         *
         * Usage: @set($name, value)
         */
        Blade::directive('set', function($argumentString) {
            list($name, $value) = $this->getArguments($argumentString);

            if (starts_with($name, [ "'", '"' ]) || ends_with($name, [ "'", '"' ])) {
                $name = substr($name, 1, -1);
            }

            if (starts_with($value, [ "'", '"' ]) || ends_with($value, [ "'", '"' ])) {
                $value = substr($value, 1, -1);
            }

            return "<?php \${$name} = '{$value}'; ?>";
        });
    }

    /**
     * Get argument array from argument string.
     *
     * @param string $argumentString
     *
     * @return array
     */
    private function getArguments($argumentString)
    {
        return explode(', ', str_replace([ '(', ')' ], '', $argumentString));
    }
}
