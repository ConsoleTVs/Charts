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

use jlawrence\eos\Parser;

/**
 * This is the math class.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
class Math extends Chart
{
    public $function;
    public $interval;
    public $amplitude;

    /**
     * Create a new math chart instance.
     *
     * @param string $function
     * @param array  $interval
     * @param int    $amplitude
     * @param string $type
     * @param string $library
     */
    public function __construct($function, $interval, $amplitude, $type = null, $library = null)
    {
        parent::__construct($type, $library);

        $this->function = $function;
        $this->interval = $interval;
        $this->amplitude = $amplitude;

        // Calculate the chart
        $this->calculate();
    }

    /**
     * Set the chart function.
     *
     * @param string $function
     */
    public function setFunction($function)
    {
        $this->function = $function;

        $this->calculate();

        return $this;
    }

    /**
     * Set the function interval.
     *
     * @param array $interval
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;

        $this->calculate();

        return $this;
    }

    /**
     * Set the function amplitude.
     *
     * @param int $amplitude
     */
    public function setAmplitude($amplitude)
    {
        $this->amplitude = $amplitude;

        $this->calculate();

        return $this;
    }

    /**
     * Calculates the values.
     *
     * @param int $amplitude
     */
    public function calculate()
    {
        // Get the function data
        $function = $this->function;
        $interval = $this->interval;
        $amplitude = $this->amplitude;

        $this->element_label = $this->element_label." - $function";

        // Reset the values / labels
        $this->values = [];
        $this->labels = [];

        for ($i = $interval[0]; $i <= $interval[1]; $i = $i + $amplitude) {
            $result = Parser::solve($function, round($i, 2));

            array_push($this->values, $result);
            array_push($this->labels, round($i, 2));
        }

        return $this;
    }
}
