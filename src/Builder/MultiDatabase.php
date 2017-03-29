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
 * This is the database class.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
class MultiDatabase extends Multi
{
    /**
     * @var Database[]
     */
    public $datas = [ ];
    public $date_column = 'created_at';
    public $date_format = 'l dS M, Y';
    public $month_format = 'F, Y';
    public $preaggregated = false;

    public $aggregate_column = null;
    public $aggregate_type = null;

    /**
     * Create a new database instance.
     *
     * @param string $type
     * @param string $library
     */
    public function __construct($type = null, $library = null)
    {
        parent::__construct($type, $library);
    }

    /**
     * Set the dataset data.
     *
     * @param string $element_label
     * @param \Illuminate\Support\Collection $data
     *
     * @return MultiDatabase
     */
    public function dataset($element_label, $data)
    {
        $this->datas[ $element_label ] = new Database($data);
        $this->datas[ $element_label ]->dateColumn($this->date_column)
            ->dateFormat($this->date_format)
            ->monthFormat($this->month_format)
            ->preaggregated($this->preaggregated)
            ->aggregateColumn($this->aggregate_column, $this->aggregate_type);

        return $this;
    }

    /**
     * Set date column to filter the data.
     *
     * @param string $column
     *
     * @return MultiDatabase
     */
    public function dateColumn($column)
    {
        $this->date_column = $column;
        foreach ($this->datas as $element_label => $data) {
            $this->datas[ $element_label ]->dateColumn($this->date_column);
        }

        return $this;
    }

    /**
     * Set fancy date format based on PHP date() function.
     *
     * @param string $format
     *
     * @return MultiDatabase
     */
    public function dateFormat($format)
    {
        $this->date_format = $format;
        foreach ($this->datas as $element_label => $data) {
            $this->datas[ $element_label ]->dateFormat($this->date_format);
        }

        return $this;
    }

    /**
     * Set fancy month format based on PHP date() function.
     *
     * @param string $format
     *
     * @return MultiDatabase
     */
    public function monthFormat($format)
    {
        $this->month_format = $format;
        foreach ($this->datas as $element_label => $data) {
            $this->datas[ $element_label ]->monthFormat($this->month_format);
        }

        return $this;
    }

    /**
     * Set whether data is preaggregated or should be summed.
     *
     * @param bool $preaggregated
     *
     * @return MultiDatabase
     */
    public function preaggregated($preaggregated)
    {
        $this->preaggregated = $preaggregated;
        foreach ($this->datas as $element_label => $data) {
            $this->datas[ $element_label ]->preaggregated($this->preaggregated);
        }

        return $this;
    }

    /**
     * Set the column in which this program should use to sum. This is useful for summing columns.
     *
     * @param string $aggregateColumn
     * @param string $aggregateType
     *
     * @return MultiDatabase
     */
    public function aggregateColumn($aggregateColumn, $aggregateType)
    {
        $this->aggregate_column = $aggregateColumn;
        $this->aggregate_type = $aggregateType;
        foreach ($this->datas as $element_label => $data) {
            $this->datas[ $element_label ]->aggregateColumn($this->aggregate_column, $this->aggregate_type);
        }

        return $this;
    }

    /**
     * Group the data hourly based on the creation date.
     *
     * @param int $day
     * @param int $month
     * @param int $year
     * @param bool $fancy
     *
     * @return MultiDatabase
     */
    public function groupByHour($day = null, $month = null, $year = null, $fancy = false)
    {
        // Reset the datasets to avoid overlapping
        $this->datasets = [ ];

        foreach ($this->datas as $element_label => $data) {
            $data->groupByHour($day, $month, $year, $fancy);
            parent::dataset($element_label, $data->values);
        }

        $this->labels = $data->labels;

        return $this;
    }

    /**
     * Group the data daily based on the creation date.
     *
     * @param int $month
     * @param int $year
     * @param bool $fancy
     *
     * @return MultiDatabase
     */
    public function groupByDay($month = null, $year = null, $fancy = false)
    {
        // Reset the datasets to avoid overlapping
        $this->datasets = [ ];

        foreach ($this->datas as $element_label => $data) {
            $data->groupByDay($month, $year, $fancy);
            parent::dataset($element_label, $data->values);
        }

        $this->labels = $data->labels;

        return $this;
    }

    /**
     * Group the data monthly based on the creation date.
     *
     * @param int  $year
     * @param bool $fancy
     *
     * @return MultiDatabase
     */
    public function groupByMonth($year = null, $fancy = false)
    {
        // Reset the datasets to avoid overlapping
        $this->datasets = [ ];

        foreach ($this->datas as $element_label => $data) {
            $data->groupByMonth($year, $fancy);
            parent::dataset($element_label, $data->values);
        }

        $this->labels = $data->labels;

        return $this;
    }

    /**
     * Group the data yearly based on the creation date.
     *
     * @param int $number
     *
     * @return MultiDatabase
     */
    public function groupByYear($number = 4)
    {
        // Reset the datasets to avoid overlapping
        $this->datasets = [ ];

        foreach ($this->datas as $element_label => $data) {
            $data->groupByYear($number);
            parent::dataset($element_label, $data->values);
        }

        $this->labels = $data->labels;

        return $this;
    }

    /**
     * Group the data based on the column.
     *
     * @param string $column
     * @param string $relationColumn
     * @param array $labelsMapping
     *
     * @return MultiDatabase
     */
    public function groupBy($column, $relationColumn = null, array $labelsMapping = [ ])
    {
        // Reset the datasets to avoid overlapping
        $this->datasets = [ ];

        foreach ($this->datas as $element_label => $data) {
            $data->groupBy($column, $relationColumn, $labelsMapping);
            parent::dataset($element_label, $data->values);
        }

        $this->labels = $data->labels;

        return $this;
    }

    /**
     * Group the data based on the latest days.
     *
     * @param int  $number
     * @param bool $fancy
     *
     * @return MultiDatabase
     */
    public function lastByDay($number = 7, $fancy = false)
    {
        // Reset the datasets to avoid overlapping
        $this->datasets = [ ];

        foreach ($this->datas as $element_label => $data) {
            $data->lastByDay($number, $fancy);
            parent::dataset($element_label, $data->values);
        }

        $this->labels = $data->labels;

        return $this;
    }

    /**
     * Group the data based on the latest months.
     *
     * @param int  $number
     * @param bool $fancy
     *
     * @return MultiDatabase
     */
    public function lastByMonth($number = 6, $fancy = false)
    {
        // Reset the datasets to avoid overlapping
        $this->datasets = [ ];

        foreach ($this->datas as $element_label => $data) {
            $data->lastByMonth($number, $fancy);
            parent::dataset($element_label, $data->values);
        }

        $this->labels = $data->labels;

        return $this;
    }

    /**
     * Alias for groupByYear().
     *
     * @param int $number
     *
     * @return MultiDatabase
     */
    public function lastByYear($number = 4)
    {
        return $this->groupByYear($number);
    }
}
