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
    public $credits;
    public $loader;
    public $loader_duration;
    public $loader_color;
    public $background_color;
    public $template;
    public $one_color;
    public $legend;
    public $x_axis_title;
    public $y_axis_title;

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
        $this->labels = [ ];
        $this->values = [ ];
        $this->colors = config('charts.default.colors');
        $this->suffix = '';
        $this->container = '';
        $this->gauge_style = 'left';
        $this->responsive = config('charts.default.responsive');
        $this->region = 'world';
        $this->background_color = config('charts.default.background_color');
        $this->credits = false; // Disables the library credits (not on all)
        $this->legend = config('charts.default.legend');
        $this->x_axis_title = config('charts.default.x_axis_title');
        $this->y_axis_title = config('charts.default.y_axis_title');

        // Setup the chart loader
        $this->loader = config('charts.default.loader.active');
        $this->loader_duration = config('charts.default.loader.duration');
        $this->loader_color = config('charts.default.loader.color');

        // Set the chart type
        $this->type = $type ? $type : config('charts.default.type');

        // Set the chart library
        $this->library = $library ? $library : config('charts.default.library');

        // Set the chart template
        $this->template = config('charts.default.template');

        $this->one_color = config('charts.default.one_color');
    }

    /**
     * Set the chart one color attribute.
     *
     * @param bool $one_color
     *
     * @return Chart
     */
    public function oneColor($one_color)
    {
        $this->one_color = $one_color;

        return $this;
    }

    /**
     * Set the chart color template.
     *
     * @param string $template
     *
     * @return Chart
     */
    public function template($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Set the chart division background color.
     *
     * @param string $background_color
     *
     * @return Chart
     */
    public function backgroundColor($background_color)
    {
        $this->background_color = $background_color;

        return $this;
    }

    /**
     * Set the loader for the chart.
     *
     * @param bool $loader
     *
     * @return Chart
     */
    public function loader($loader)
    {
        $this->loader = $loader;

        return $this;
    }

    /**
     * Set a custom loader time before showing the chart.
     *
     * @param int $loader_duration
     *
     * @return Chart
     */
    public function loaderDuration($loader_duration)
    {
        $this->loader_duration = $loader_duration;

        return $this;
    }

    /**
     * Set the loader color for the chart if the loader is enabled.
     *
     * @param string $loader_color
     *
     * @return Chart
     */
    public function loaderColor($loader_color)
    {
        $this->loader_color = $loader_color;

        return $this;
    }

    /**
     * Set a custom container to render the chart.
     *
     * @param string $division
     *
     * @return Chart
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
     *
     * @return Chart
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
     *
     * @return Chart
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
     *
     * @return Chart
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
     *
     * @return Chart
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
     *
     * @return Chart
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
     *
     * @return Chart
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
     *
     * @return Chart
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
     *
     * @return Chart
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
     *
     * @return Chart
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
     *
     * @return Chart
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
     *
     * @return Chart
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
     *
     * @return Chart
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
     *
     * @return Chart
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
     *
     * @return Chart
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
     *
     * @return Chart
     */
    public function view($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Set whether a chart's legend is shown (where applicable).
     *
     * @param bool $legend
     *
     * @return Chart
     */
    public function legend($legend)
    {
        $this->legend = $legend;

        return $this;
    }

    /**
     * Set the title of a chart's x-axis (where applicable).
     *
     * @param bool $x_axis_title
     *
     * @return Chart
     */
    public function xAxisTitle($x_axis_title)
    {
        $this->x_axis_title = $x_axis_title;

        return $this;
    }

    /**
     * Set the title of a chart's y-axis (where applicable).
     *
     * @param bool $y_axis_title
     *
     * @return Chart
     */
    public function yAxisTitle($y_axis_title)
    {
        $this->y_axis_title = $y_axis_title;

        return $this;
    }

    /**
     * Return and array of all the chart settings.
     *
     * @return array
     */
    public function settings()
    {
        return (array) $this;
    }

    /**
     * Render the chart.
     *
     * @return View|string
     */
    public function render()
    {
        $this->id = $this->container ? $this->container : $this->randomString();

        if (!$this->labels && !$this->values) {
            $this->labels = [ 'No Data Set' ];
            $this->values = [ 0 ];
        } elseif (!$this->values && $this->labels) {
            foreach ($this->labels as $l) {
                array_push($this->values, 0);
            }
        } elseif ($this->values && !$this->labels) {
            $i = 0;
            foreach ($this->values as $v) {
                array_push($this->labels, "Unknown $i");
            }
        } elseif (count($this->values) > count($this->labels)) {
            $lb = count($this->labels);
            for ($i = 0; $i < (count($this->values) - $lb); $i++) {
                array_push($this->labels, "Unknown $i");
            }
        } elseif (count($this->values) < count($this->labels)) {
            $vl = count($this->values);
            for ($i = 0; $i < (count($this->labels) - $vl); $i++) {
                array_push($this->values, 0);
            }
        }

        if (!$this->colors) {
            $this->colors = [ '#000000' ];
            // Set the template colors
            $templates = config('charts.templates');
            if ($this->template && array_key_exists($this->template, $templates) && $colors = $templates[ $this->template ]) {
                $this->colors = $colors;
            }
        }

        $ds = $this->suffix == 'multi' ? count($this->datasets) : [ ];
        $cv = count($this->values);
        $cc = count($this->colors);

        if ($this->one_color) {
            $color = $this->colors[ 0 ];
            $this->colors = [ ];
            foreach ($this->values as $v) {
                array_push($this->colors, $color);
            }
        } elseif (($cc != $cv) || ($this->suffix == 'multi' && ($cc != $ds))) {
            if ($this->suffix == 'multi') {
                $cv = $ds;
            }

            if ($cc > $cv) {
                // There are more colors than values
                $this->colors = array_slice($this->colors, 0, $cv);
            } else {
                // There are less colors than values
                $i = 0;
                $max = count($this->colors);
                while (count($this->colors) < $cv) {
                    if ($i == $max) {
                        $i = 0;
                    }
                    array_push($this->colors, $this->colors[ $i ]);
                    $i++;
                }
            }
        }

        $view = $this->suffix ? "charts::{$this->library}.{$this->suffix}.{$this->type}" : "charts::{$this->library}.{$this->type}";
        $view = $this->view ?: $view;

        if (View::exists($view)) {
            return view($view)->withModel($this);
        }

        // There must be an error, let's show the error!
        $error_msg = 'Unknown chart library / type combination';
        $img_url = 'http://www.iconsfind.com/wp-content/uploads/2015/12/20151208_56663ed552e5d.png';

        $error = "<div><div style='position: relative;";
        if (!$this->responsive) {
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
     *
     * @return string
     */
    public function randomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }
}
