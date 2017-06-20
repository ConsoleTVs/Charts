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

    public $plotBandsFrom;
    public $plotBandsTo;
    public $plotBandsColor;

    /**
     * Create a new multi chart instance.
     *
     * @param string $type
     * @param string $library
     */
    public function __construct($type = null, $library = null)
    {
        parent::__construct($type, $library);

        $this->suffix = 'multi';

        $this->plotBandsFrom = config('charts.default.plotBandsFrom');
        $this->plotBandsTo = config('charts.default.plotBandsTo');
        $this->plotBandsColor = config('charts.default.plotBandsColor');
    }

    /**
     * Set the dataset values.
     *
     * @param string $element_label
     * @param array  $values
     *
     * @return Multi
     */
    public function dataset($element_label, $values)
    {
        $this->datasets[] = [
            'label' => $element_label,
            'values' => $values,
        ];

        return $this;
    }

    /**
     * Set chart plot bands from.
     *
     * @param float $from
     *
     * @return Chart
     */
    public function plotBandsFrom($from)
    {
        $this->plotBandsFrom = $from;

        return $this;
    }

    /**
     * Set chart plot bands to.
     *
     * @param float $to
     *
     * @return Chart
     */
    public function plotBandsTo($to)
    {
        $this->plotBandsTo = $to;

        return $this;
    }

    /**
     * Set chart plot bands background color.
     *
     * @param string $color
     *
     * @return Chart
     */
    public function plotBandsColor($color)
    {
        $this->plotBandsColor = $color;

        return $this;
    }
}
