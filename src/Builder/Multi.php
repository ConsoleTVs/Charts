<?php

/*
 * This file is part of consoletvs/charts.
 *
 * (c) Erik Campobadal <soc@erik.cat>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ConsoleTVs\Charts\Builder;

/**
 * This is the multi class.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
class Multi extends Chart
{
    public $datasets;

    /**
     * Create a new multi chart instance.
     *
     * @param string $function
     * @param array  $interval
     * @param int    $amplitude
     * @param string $type
     * @param string $library
     */
    public function __construct($type = null, $library = null)
    {
        parent::__construct($type, $library);

        $this->suffix = 'multi';
    }

    /**
     * Set the dataset values.
     *
     * @param array $values
     * @param int   $dataset
     */
    public function dataset($elementLabel, $values, $fillColor = true)
    {
        $this->datasets[] = [
            'label' => $elementLabel,
            'values' => $values,
        	'fillColor' => $fillColor
        ];

        return $this;
    }
}
