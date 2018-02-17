<?php

namespace ConsoleTVs\Charts\Features\Highcharts;

trait Dataset
{
    /**
     * Set the dataset color.
     *
     * @param string|array $color
     *
     * @return self
     */
    public function color($color)
    {
        return $this->options([
            'color' => $color,
        ]);
    }
}
