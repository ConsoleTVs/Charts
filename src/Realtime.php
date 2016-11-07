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

/**
 * This is the realtime class.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
class Realtime extends Chart
{
    public $url;
    public $interval;
    public $value_name;
    public $max_values;

    /**
     * Create a new realtime instance.
     *
     * @param string $url
     * @param int    $interval
     * @param string $type
     * @param string $library
     */
    public function __construct($url, $interval, $type = null, $library = null)
    {
        parent::__construct($type, $library);

        // Set the data
        $this->url = $url;
        $this->interval = $interval;
        $this->sufix = 'realtime';
        $this->value_name = 'value';
        $this->max_values = 20;
    }

    /**
     * Set the max values in the chart.
     *
     * @param int $number
     */
    public function setMaxValues($number)
    {
        $this->max_values = $number;

        return $this;
    }

    /**
     * Set json value name.
     *
     * @param string $string
     */
    public function setValueName($string)
    {
        $this->value_name = $string;

        return $this;
    }

    /**
     * Set json data streaming url.
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set the update interval in ms.
     *
     * @param string $url
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;

        return $this;
    }
}
