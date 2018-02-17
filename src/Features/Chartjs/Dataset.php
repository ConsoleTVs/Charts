<?php

namespace ConsoleTVs\Charts\Features\Chartjs;

trait Dataset
{
    /**
     * Set the dataset border color.
     *
     * @param string|array $color
     *
     * @return self
     */
    public function color($color)
    {
        return $this->options([
            'borderColor' => $color,
        ]);
    }

    /**
     * Set the dataset background color.
     *
     * @param string|array $color
     *
     * @return self
     */
    public function backgroundColor($color)
    {
        return $this->options([
            'backgroundColor' => $color,
        ]);
    }

    /**
     * Determines if the dataset is filled.
     *
     * @param bool $filled
     *
     * @return self
     */
    public function fill(bool $filled)
    {
        return $this->options([
            'fill' => $filled,
        ]);
    }

    /**
     * Set the chart line tension.
     *
     * @param int $tension
     *
     * @return self
     */
    public function lineTension(float $tension)
    {
        return $this->options([
            'lineTension' => $tension,
        ]);
    }

    /**
     * Set the line to a dashed line in the chart options.
     *
     * @param array $dashed
     *
     * @return self
     */
    public function dashed(array $dashed = [5])
    {
        return $this->options([
            'borderDash' => $dashed,
        ]);
    }
}
