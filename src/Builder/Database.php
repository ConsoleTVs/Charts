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

use Illuminate\Support\Collection;

/**
 * This is the database class.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
class Database extends Chart
{
    /**
     * @var Collection
     */
    public $data;
    public $date_column;
    public $date_format = 'l dS M, Y';
    public $month_format = 'F, Y';
    public $preaggregated = false;

    public $aggregate_column = null;
    public $aggregate_type = null;
    public $value_data = [ ];

    /**
     * Create a new database instance.
     *
     * @param Collection $data
     * @param string $type
     * @param string $library
     */
    public function __construct($data, $type = null, $library = null)
    {
        parent::__construct($type, $library);

        // Set the data
        $this->date_column = 'created_at';
        $this->data = $data;
    }

    /**
     * @param Collection $data
     *
     * @return Database
     */
    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Set date column to filter the data.
     *
     * @param string $column
     *
     * @return Database
     */
    public function dateColumn($column)
    {
        $this->date_column = $column;

        return $this;
    }

    /**
     * Set fancy date format based on PHP date() function.
     *
     * @param string $format
     *
     * @return Database
     */
    public function dateFormat($format)
    {
        $this->date_format = $format;

        return $this;
    }

    /**
     * Set fancy month format based on PHP date() function.
     *
     * @param string $format
     *
     * @return Database
     */
    public function monthFormat($format)
    {
        $this->month_format = $format;

        return $this;
    }

    /**
     * Set whether data is preaggregated or should be summed.
     *
     * @param bool $preaggregated
     *
     * @return Database
     */
    public function preaggregated($preaggregated)
    {
        $this->preaggregated = $preaggregated;

        return $this;
    }

    /**
     * Set the column in which this program should use to aggregate. This is useful for summing/averaging columns.
     *
     * @param string $aggregateColumn - name of the column to aggregate
     * @param string $aggregateType - type of aggregation (sum, avg, min, max, count, ...)
     *                                Must be Laravel collection commands.
     * @see Illuminate\Support\Collection
     *
     * @return Database
     */
    public function aggregateColumn($aggregateColumn, $aggregateType)
    {
        $this->aggregate_column = $aggregateColumn;
        $this->aggregate_type = $aggregateType;

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
     * @return Database
     */
    public function groupByHour($day = null, $month = null, $year = null, $fancy = false)
    {
        $labels = [ ];
        $values = [ ];

        $day = $day ? $day : date('d');
        $month = $month ? $month : date('m');
        $year = $year ? $year : date('Y');

        $hours = 24;

        for ($i = 0; $i < $hours; $i++) {
            if ($i < 10) {
                $hour = "0$i";
            } else {
                $hour = "$i";
            }

            $date_get = $fancy ? $this->date_format : 'd-m-Y H:00:00';
            $label = date($date_get, strtotime("$year-$month-$day $hour:00:00"));

            $checkDate = "$year-$month-$day $hour:00:00";
            $value = $this->getCheckDateValue($checkDate, 'Y-m-d H:00:00', $label);

            array_push($labels, $label);
            array_push($values, $value);
        }
        $this->labels($labels);
        $this->values($values);

        return $this;
    }

    /**
     * Group the data daily based on the creation date.
     *
     * @param int $month
     * @param int $year
     * @param bool $fancy
     *
     * @return Database
     */
    public function groupByDay($month = null, $year = null, $fancy = false)
    {
        $labels = [ ];
        $values = [ ];

        $month = $month ? $month : date('m');
        $year = $year ? $year : date('Y');

        $days = date('t', strtotime("$year-$month-01"));

        for ($i = 1; $i <= $days; $i++) {
            if ($i < 10) {
                $day = "0$i";
            } else {
                $day = "$i";
            }

            $date_get = $fancy ? $this->date_format : 'd-m-Y';
            $label = date($date_get, strtotime("$year-$month-$day"));

            $checkDate = "$year-$month-$day";
            $value = $this->getCheckDateValue($checkDate, 'Y-m-d', $label);

            array_push($labels, $label);
            array_push($values, $value);
        }
        $this->labels($labels);
        $this->values($values);

        return $this;
    }

    /**
     * Group the data monthly based on the creation date.
     *
     * @param int  $year
     * @param bool $fancy
     *
     * @return Database
     */
    public function groupByMonth($year = null, $fancy = false)
    {
        $labels = [ ];
        $values = [ ];

        $year = $year ? $year : date('Y');

        for ($i = 1; $i <= 12; $i++) {
            if ($i < 10) {
                $month = "0$i";
            } else {
                $month = "$i";
            }

            $date_get = $fancy ? $this->month_format : 'm-Y';
            $label = date($date_get, strtotime("$year-$month-01"));

            array_push($labels, $label);

            $checkDate = "$year-$month";
            $value = $this->getCheckDateValue($checkDate, 'Y-m', $label);

            array_push($values, $value);
        }

        $this->labels($labels);
        $this->values($values);

        return $this;
    }

    /**
     * Group the data yearly based on the creation date.
     *
     * @param int $number
     *
     * @return Database
     */
    public function groupByYear($number = 4)
    {
        $labels = [ ];
        $values = [ ];

        for ($i = 0; $i < $number; $i++) {
            if ($i == 0) {
                $year = date('Y');
            } else {
                $year = date('Y', strtotime('-'.$i.' Year'));
            }

            array_push($labels, $year);
            // Check the value
            $checkDate = $year;
            $value = $this->getCheckDateValue($checkDate, 'Y', $year);

            array_push($values, $value);
        }

        $this->labels(array_reverse($labels));
        $this->values(array_reverse($values));

        return $this;
    }

    /**
     * Group the data based on the column.
     *
     * @param string $column
     * @param string $relationColumn
     * @param array $labelsMapping
     *
     * @return Database
     */
    public function groupBy($column, $relationColumn = null, array $labelsMapping = [ ])
    {
        $labels = [ ];
        $values = [ ];

        if ($relationColumn && strpos($relationColumn, '.') !== false) {
            $relationColumn = explode('.', $relationColumn);
        }

        foreach ($this->data->groupBy($column) as $data) {
            $label = $data[ 0 ];

            if (is_null($relationColumn)) {
                $label = $label->$column;
            } else {
                if (is_array($relationColumn)) {
                    foreach ($relationColumn as $boz) {
                        $label = $label->$boz;
                    }
                } else {
                    $label = $data[ 0 ]->$relationColumn;
                }
            }

            array_push($labels, array_key_exists($label, $labelsMapping) ? $labelsMapping[ $label ] : $label);
            array_push($values, count($data));
        }

        $this->labels($labels);
        $this->values($values);

        return $this;
    }

    /**
     * Group the data based on the latest days.
     *
     * @param int  $number
     * @param bool $fancy
     *
     * @return Database
     */
    public function lastByDay($number = 7, $fancy = false)
    {
        $labels = [ ];
        $values = [ ];

        for ($i = 0; $i < $number; $i++) {
            $date = $i == 0 ? date('d-m-Y') : date('d-m-Y', strtotime("-$i Day"));
            $date_f = $fancy ? date($this->date_format, strtotime($date)) : $date;
            array_push($labels, $date_f);
            $value = $this->getCheckDateValue($date, 'd-m-Y', $date_f);
            array_push($values, $value);
        }

        $this->labels(array_reverse($labels));
        $this->values(array_reverse($values));

        return $this;
    }

    /**
     * Group the data based on the latest months.
     *
     * @param int  $number
     * @param bool $fancy
     *
     * @return Database
     */
    public function lastByMonth($number = 6, $fancy = false)
    {
        $labels = [ ];
        $values = [ ];

        for ($i = 0; $i < $number; $i++) {
            $date = $i == 0 ? date('m-Y') : date('m-Y', strtotime("-$i Month"));
            $date_f = $fancy ? date($this->month_format, strtotime("01-$date")) : $date;
            array_push($labels, $date_f);
            $value = $this->getCheckDateValue($date, 'm-Y', $date_f);
            array_push($values, $value);
        }

        $this->labels(array_reverse($labels));
        $this->values(array_reverse($values));

        return $this;
    }

    /**
     * Alias for groupByYear().
     *
     * @param int $number
     *
     * @return Database
     */
    public function lastByYear($number = 4)
    {
        return $this->groupByYear($number);
    }

    /**
     * This is a simple value generator for the three types of summations used in this Chart object when sorted via data.
     *
     * @param string $checkDate - a string in the format 'Y-m-d H:ii::ss' Needs to resemble up with $formatToCheck to work
     * @param string $formatToCheck - a string in the format 'Y-m-d H:ii::ss' Needs to resemble up with $checkDate to work
     * @param string $label
     * @return mixed
     */
    private function getCheckDateValue($checkDate, $formatToCheck, $label)
    {
        $date_column = $this->date_column;
        $data = $this->data;
        if ($this->preaggregated) {
            // Since the column has been preaggregated, we only need one record that matches the search
            $valueData = $data->first(function($value) use ($checkDate, $date_column, $formatToCheck) {
                return $checkDate == date($formatToCheck, strtotime($value->$date_column));
            });
            $value = $valueData !== null ? $valueData->aggregate : 0;
        } else {
            // Set the data represented. Return the relevant value.
            $valueData = $data->filter(function($value) use ($checkDate, $date_column, $formatToCheck) {
                return $checkDate == date($formatToCheck, strtotime($value->$date_column));
            });

            if ($valueData !== null) {
                // Do an aggregation, otherwise count the number of records.
                $value = $this->aggregate_column ? $valueData->{$this->aggregate_type}($this->aggregate_column) : $valueData->count();
            } else {
                $value = 0;
            }

            // Store the datasets by label.
            $this->value_data[ $label ] = $valueData;
        }

        return $value;
    }
}
