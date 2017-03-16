<?php

/*
 * This file is part of consoletvs/charts.
 *
 * (c) Erik Campobadal <soc@erik.cat>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ConsoleTVs\Charts;

use ConsoleTVs\Charts\Builder\Math;
use ConsoleTVs\Charts\Builder\Chart;
use ConsoleTVs\Charts\Builder\Multi;
use Illuminate\Support\Facades\File;
use ConsoleTVs\Charts\Builder\Database;
use ConsoleTVs\Charts\Builder\Realtime;
use ConsoleTVs\Charts\Builder\MultiDatabase;

/**
 * This is the charts facade class.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
class Builder
{
    /**
     * Return a new chart instance.
     *
     * @param string $type
     * @param string $library
     *
     * @return Chart
     */
    public static function create($type = null, $library = null)
    {
        return new Chart($type, $library);
    }

    /**
     * Return a new realtime chart instance.
     *
     * @param string $url
     * @param int $interval
     * @param string $type
     * @param string $library
     *
     * @return Realtime
     */
    public static function realtime($url, $interval, $type = null, $library = null)
    {
        return new Realtime($url, $interval, $type, $library);
    }

    /**
     * Return a new database chart instance.
     *
     * @param \Illuminate\Support\Collection $data
     * @param string $type
     * @param string $library
     *
     * @return Database
     */
    public static function database($data, $type = null, $library = null)
    {
        return new Database($data, $type, $library);
    }

    /**
     * Return a new math chart instance.
     *
     * @param string $function
     * @param array  $interval
     * @param int    $amplitude
     * @param string $type
     * @param string $library
     *
     * @return Math
     */
    public static function math($function, $interval, $amplitude, $type = null, $library = null)
    {
        return new Math($function, $interval, $amplitude, $type, $library);
    }

    /**
     * Return a new multi chart instance.
     *
     * @param string $type
     * @param string $library
     *
     * @return Multi
     */
    public static function multi($type = null, $library = null)
    {
        return new Multi($type, $library);
    }

    /**
     * Return a new multi database chart instance.
     *
     * @param string $type
     * @param string $library
     *
     * @return MultiDatabase
     */
    public static function multiDatabase($type = null, $library = null)
    {
        return new MultiDatabase($type, $library);
    }

    /**
     * Return all the libraries available.
     *
     * @param string $type
     *
     * @return array
     */
    public static function libraries($type = null)
    {
        $directories = File::directories(__DIR__.'/../resources/views');

        $results = [ ];
        foreach ($directories as $directory) {
            // type was not defined...
            if (!$type) {
                return collect($directories)->map(function($item, $key) {
                    return basename($item);
                })->toArray();
            }

            // type was defined...
            foreach (File::allFiles($directory) as $library) {
                if (str_contains($library, $type)) {
                    $results[ ] = basename($directory);
                }
            }
        }

        return array_unique($results);
    }

    /**
     * Return all the types available.
     *
     * @param string $library
     *
     * @return array
     */
    public static function types($library = null)
    {
        // library defined...
        if ($library) {
            $files = File::allFiles(__DIR__."/../resources/views/$library");

            return collect($files)->map(function($item, $key) {
                return str_replace('.blade.php', null, $item->getFileName());
            })->toArray();
        }

        // no library defined...
        $libraries = File::directories(__DIR__.'/../resources/views');

        $results = [ ];
        foreach ($libraries as $library) {
            foreach (File::allFiles($library) as $type) {
                $results[ ] = str_replace('.blade.php', null, $type->getFileName());
            }
        }

        return array_unique($results);
    }

        /**
         * Return the library styles.
         *
         * @param array  $libraries
         *
         * @return string
         */
        public function styles($libraries = [])
        {
            $styles = static::getAssets($libraries, 'styles');
            $styles .= view('charts::_partials.loader.css');

            return $styles;
        }

        /**
         * Return the library scripts.
         *
         * @param array  $libraries
         *
         * @return string
         */
        public function scripts($libraries = [])
        {
            $scripts = static::getAssets($libraries, 'scripts');
            $scripts .= view('charts::_partials.loader.js');

            return $scripts;
        }

        /**
         * Return the library styles.
         *
         * @param array  $libraries
         *
         * @return string
         */
        public function assets($libraries = [ ])
        {
            $assets = static::styles($libraries);
            $assets .= static::scripts($libraries);

            return $assets;
        }

    /**
     * Get the library assets.
     *
     * @param array $libraries
     * @param string $type
     *
     * @return string
     */
    private static function getAssets($libraries = [ ], $type = [ ])
    {
        if (!$libraries) {
            $libraries = [ ];
            foreach (config('charts.assets') as $key => $value) {
                array_push($libraries, $key);
            }
        }
        $assets = config('charts.assets');
        $final_assets = $assets;

        if ($libraries && is_string($libraries)) {
            $libraries = explode(',', $libraries);
        }

        if ($type) {
            $final_assets = collect($assets)->map(function($value, $key) use ($libraries, $type) {
                if (in_array($key, $libraries) && array_key_exists($type, $value)) {
                    return $value[ $type ];
                } else {
                    return;
                }
            })->reject(function($value) {
                return $value === null;
            })->toArray();
        } else {
            $final_assets = collect($assets)->map(function($value, $key) use ($libraries) {
                if (in_array($key, $libraries)) {
                    return $value;
                } else {
                    return;
                }
            })->reject(function($value) {
                return $value === null;
            })->toArray();
        }

        // return all libraries
        return static::buildIncludeTags($final_assets);
    }

    /**
     * Build HTML Tags to include.
     *
     * @param array $data
     *
     * @return string
     */
    private static function buildIncludeTags(array $data)
    {
        return collect(array_flatten($data))->map(function($item) {
            if (ends_with($item, '.css')) {
                return '<link rel="stylesheet" href="'.$item.'">';
            }

            if (ends_with($item, '.js') || strpos($item, 'http') !== false) {
                return '<script type="text/javascript" src="'.$item.'"></script>';
            }

            return '<script type="text/javascript">'.$item.'</script>';
        })->implode("\n");
    }
}
