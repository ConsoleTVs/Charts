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

use View;

/**
 * This is the chart class.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
class Chart
{
    public $id;
    public $customId;
    public $type;
    public $library;
    public $title;
    public $element_label;
    public $labels;
    public $values;
    public $colors;
    public $responsive;
    public $gauge_style;
    public $view;
    public $region;
    protected $suffix;
    public $container;
    public $credits = true;
    
    public $xTickInterval;

    /**
     * Create a new chart instance.
     *
     * @param string $type
     * @param string $library
     */
    public function __construct($type = null, $library = null)
    {
        // Set the default chart data
        $this->title = config('charts.default.title');
        $this->height = config('charts.default.height');
        $this->width = config('charts.default.width');
        $this->element_label = config('charts.default.element_label');
        $this->labels = [];
        $this->values = [];
        $this->colors = [];
        $this->suffix = '';
        $this->container = '';
        $this->gauge_style = 'left';
        $this->responsive = config('charts.default.responsive');
        $this->region = 'world';
        $length = 10; // The random identifier length.

        // Set the chart type
        $this->type = $type ? $type : config('charts.default.type');

        // Set the chart library
        $this->library = $library ? $library : config('charts.default.library');
    }

    /**
     * Set a custom container to render the chart.
     *
     * @param string $division
     */
    public function container($division)
    {
        $this->container = $division;

        return $this;
    }

    /**
     * Set the google geo region.
     *
     * @param string $region
     */
    public function region($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Set gauge style.
     *
     * @param string $style
     */
    public function gaugeStyle($style)
    {
        $this->gauge_style = $style;

        return $this;
    }

    /**
     * Set chart type.
     *
     * @param string $type
     */
    public function type($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set chart library.
     *
     * @param string $library
     */
    public function library($library)
    {
        $this->library = $library;

        return $this;
    }

    /**
     * Set chart labels.
     *
     * @param array $labels
     */
    public function labels($labels)
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * Set chart values.
     *
     * @param array $values
     */
    public function values($values)
    {
        $this->values = $values;

        return $this;
    }

    /**
     * Set the chart element label.
     *
     * @param string $label
     */
    public function elementLabel($label)
    {
        $this->element_label = $label;

        return $this;
    }

    /**
     * Set chart title.
     *
     * @param string $title
     */
    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set chart credits enabled or Disable. Default credits enable.
     *
     * @param bool $credits
     */
    public function credits($credits)
    {
        $this->credits = $credits;

        return $this;
    }

    /**
     * Set chart colors.
     *
     * @param array $colors
     */
    public function colors($colors)
    {
        $this->colors = $colors;

        return $this;
    }

    /**
     * Set chart width.
     *
     * @param int $width
     */
    public function width($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Set chart height.
     *
     * @param int $height
     */
    public function height($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Set chart dimensions (width, height).
     *
     * @param int $width
     * @param int $height
     */
    public function dimensions($width, $height)
    {
        $this->width = $width;
        $this->height = $height;

        return $this;
    }

    /**
     * Set if chart is responsive (will ignore dimensions if true).
     *
     * @param bool $responsive
     */
    public function responsive($responsive)
    {
        $this->responsive = $responsive;

        return $this;
    }

    /**
     * Set a custom view to be used.
     *
     * @param string $view
     */
    public function view($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Return and array of all the chart settings.
     */
    public function settings()
    {
        return (array) $this;
    }

    /**
     * Render the chart.
     */
    public function render()
    {
        if (! $this->labels && ! $this->values) {
            $this->labels = ['No Data Set'];
            $this->values = [0];
        } elseif (! $this->values && $this->labels) {
            foreach ($this->labels as $l) {
                array_push($this->values, 0);
            }
        } elseif ($this->values && ! $this->labels) {
            foreach ($this->values as $v) {
                array_push($this->labels, 'No Data Set');
            }
        } elseif (count($this->values) > count($this->labels)) {
            for ($i = 0; $i < (count($this->values) - count($this->labels)); $i++) {
                array_push($this->labels, 'No Data Set');
            }
        } elseif (count($this->values) < count($this->labels)) {
            for ($i = 0; $i < (count($this->labels) - count($this->values)); $i++) {
                array_push($this->values, 0);
            }
        }

        $this->id = $this->container ? $this->container : $this->randomString();

        $view = $this->suffix ? "charts::{$this->library}.{$this->suffix}.{$this->type}" : "charts::{$this->library}.{$this->type}";
        $view = $this->view ?: $view;

        if (View::exists($view)) {
            return view($view)->withModel($this);
        }

        // There must be an error, let's show the error!
        $error_msg = 'Unknown chart library / type combination';
        $img_url = 'http://www.iconsfind.com/wp-content/uploads/2015/12/20151208_56663ed552e5d.png';

        $error = "<div><div style='position: relative;";
        if (! $this->responsive) {
            $error .= $this->height ? 'height: '.$this->height.'px' : '';
            $error .= $this->width ? 'width: '.$this->width.'px' : '';
        }
        $error .= "'><center><div style='position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);'><img style='width: 75px; height: 75px;' src='$img_url'><br><br><b>$error_msg</b></div></center><div></div>";

        return $error;
    }

    /**
     * Return a random string.
     *
     * @param int $length
     */
    public function randomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }
    
    public function xTickInterval($xTickInterval)
    {
    	$this->xTickInterval = $xTickInterval;
    
    	return $this;
    }
}

