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
 * This is the database class.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
class Database extends Chart
{
    public $data;
    public $date_column;
    public $date_format = 'l dS M, Y';
    public $month_format = 'F, Y';

    /**
     * Create a new database instance.
     *
     * @param string $data
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
     * Set chart data.
     *
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Set date column to filter the data.
     *
     * @param string $column
     */
    public function setDateColumn($column)
    {
        $this->date_column = $column;

        return $this;
    }

    /**
     * Set fancy date format based on PHP date() function.
     *
     * @param string $format
     */
    public function setDateFormat($format)
    {
        $this->date_format = $format;

        return $this;
    }

    /**
     * Set fancy month format based on PHP date() function.
     *
     * @param string $format
     */
    public function setMonthFormat($format)
    {
        $this->month_format = $format;

        return $this;
    }

    /**
     * Group the data monthly based on the creation date.
     *
     * @param string $year
     * @param string $month
     * @param bool   $fancy
     */
    public function groupByDay($month = null, $year = null, $fancy = false)
    {
        $labels = [];
        $values = [];

        $date_column = $this->date_column;

        $month = $month ? $month : date('m');
        $year = $year ? $year : date('Y');

        $days = date('t', strtotime("$year-$month-01"));

        for ($i = 1; $i <= $days; $i++) {
            if ($i < 10) {
                $day = "0$i";
            } else {
                $day = "$i";
            }

            $date = "$year-$month-$day";

            $value = 0;

            foreach ($this->data as $data) {
                if (date('Y-m-d', strtotime($data->$date_column)) == $date) {
                    $value++;
                }
            }

            $date_get = $fancy ? $this->date_format : 'd-m-Y';
            $label = date($date_get, strtotime("$year-$month-$day"));

            array_push($labels, $label);
            array_push($values, $value);
        }
        $this->labels = $labels;
        $this->values = $values;

        return $this;
    }

    /**
     * Group the data monthly based on the creation date.
     *
     * @param int  $year
     * @param bool $fancy
     */
    public function groupByMonth($year = null, $fancy = false)
    {
        $labels = [];
        $values = [];

        $date_column = $this->date_column;

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

            $value = 0;
            foreach ($this->data as $data) {
                if ($year == date('Y', strtotime($data->$date_column))) {
                    // Same year
                    if ($month == date('m', strtotime($data->$date_column))) {
                        // Same month
                        $value++;
                    }
                }
            }
            array_push($values, $value);
        }

        $this->labels = $labels;
        $this->values = $values;

        return $this;
    }

    /**
     * Group the data yearly based on the creation date.
     *
     * @param int $number
     */
    public function groupByYear($number = 4)
    {
        $labels = [];
        $values = [];

        $date_column = $this->date_column;

        for ($i = 0; $i < $number; $i++) {
            if ($i == 0) {
                $year = date('Y');
            } else {
                $year = date('Y', strtotime('-'.$i.' Year'));
            }

            array_push($labels, $year);
            // Check the value
            $value = 0;
            foreach ($this->data as $data) {
                if ($year == date('Y', strtotime($data->$date_column))) {
                    $value++;
                }
            }
            array_push($values, $value);
        }
        $this->labels = array_reverse($labels);
        $this->values = array_reverse($values);

        return $this;
    }

    /**
     * Group the data based on the column.
     *
     * @param string $column
     */
    public function groupBy($column)
    {
        $labels = [];
        $values = [];
        foreach ($this->data->groupBy($column) as $data) {
            array_push($labels, $data[0]->$column);
            array_push($values, count($data));
        }
        $this->labels = $labels;
        $this->values = $values;

        return $this;
    }

    /**
     * Group the data based on the latest days.
     *
     * @param int  $number
     * @param bool $number
     */
    public function lastByDay($number = 7, $fancy = false)
    {
        $labels = [];
        $values = [];

        $date_column = $this->date_column;

        for ($i = 0; $i < $number; $i++) {
            $date = $i == 0 ? date('d-m-Y') : date('d-m-Y', strtotime("-$i Day"));
            $date_f = $fancy ? date($this->date_format, strtotime($date)) : $date;
            array_push($labels, $date_f);
            $value = 0;
            foreach ($this->data as $data) {
                if ($date == date('d-m-Y', strtotime($data->$date_column))) {
                    $value++;
                }
            }
            array_push($values, $value);
        }
        $this->labels = array_reverse($labels);
        $this->values = array_reverse($values);

        return $this;
    }

    /**
     * Group the data based on the latest months.
     *
     * @param int  $number
     * @param bool $number
     */
    public function lastByMonth($number = 6, $fancy = false)
    {
        $labels = [];
        $values = [];

        $date_column = $this->date_column;

        for ($i = 0; $i < $number; $i++) {
            $date = $i == 0 ? date('m-Y') : date('m-Y', strtotime("-$i Month"));
            $date_f = $fancy ? date($this->month_format, strtotime("01-$date")) : $date;
            array_push($labels, $date_f);
            $value = 0;
            foreach ($this->data as $data) {
                if ($date == date('m-Y', strtotime($data->$date_column))) {
                    $value++;
                }
            }
            array_push($values, $value);
        }
        $this->labels = array_reverse($labels);
        $this->values = array_reverse($values);

        return $this;
    }

    /**
     * Alias for groupByYear().
     *
     * @param int $number
     */
    public function lastByYear($number = 4)
    {
        return $this->groupByYear($number);
    }
}
