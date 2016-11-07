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

        $this->sufix = 'multi';
    }

    /**
     * Set the dataset values.
     *
     * @param array $values
     * @param int   $dataset
     */
    public function setDataset($element_label, $values)
    {
        $this->datasets[$element_label]['values'] = $values;

        return $this;
    }
}
