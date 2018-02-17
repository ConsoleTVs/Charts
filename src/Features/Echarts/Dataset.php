<?php

namespace ConsoleTVs\Charts\Features\Echarts;

trait Dataset
{
    /**
     * Set the dataset color.
     *
     * @param string|array $color
     *
     * @return void
     */
    public function color($color)
    {
        return $this->options([
            'color' => $color,
        ]);
    }
}
