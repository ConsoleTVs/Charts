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
    protected $sufix;

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
        $this->sufix = '';
        $this->gauge_style = 'left';
        $this->responsive = config('charts.default.responsive');
        $length = 10; // The random identifier length.

        // Set the chart type
        $this->type = $type ? $type : config('charts.default.type');

        // Set the chart library
        $this->library = $library ? $library : config('charts.default.library');
    }

    /**
     * Set gauge style.
     *
     * @param string $style
     */
    public function setGaugeStyle($style)
    {
        $this->gauge_style = $style;

        return $this;
    }

    /**
     * Set chart type.
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set chart library.
     *
     * @param string $library
     */
    public function setLibrary($library)
    {
        $this->library = $library;

        return $this;
    }

    /**
     * Set chart labels.
     *
     * @param array $labels
     */
    public function setLabels($labels)
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * Set chart values.
     *
     * @param array $values
     */
    public function setValues($values)
    {
        $this->values = $values;

        return $this;
    }

    /**
     * Set the chart element label.
     *
     * @param string $label
     */
    public function setElementLabel($label)
    {
        $this->element_label = $label;

        return $this;
    }

    /**
     * Set chart title.
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set chart colors.
     *
     * @param array $colors
     */
    public function setColors($colors)
    {
        $this->colors = $colors;

        return $this;
    }

    /**
     * Set chart width.
     *
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Set chart height.
     *
     * @param int $height
     */
    public function setHeight($height)
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
    public function setDimensions($width, $height)
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
    public function setResponsive($responsive)
    {
        $this->responsive = $responsive;

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
        $this->customId = func_num_args() > 0 ? func_get_arg(0) : false;
        $this->id = $this->customId ? $this->customId : $this->randomString();
        $file = $this->sufix ? __DIR__."/Templates/$this->library/$this->type.$this->sufix.php" : __DIR__."/Templates/$this->library/$this->type.php";

        if (file_exists($file)) {
            return include $file;
        } else {
            $error_msg = 'Unknown chart library / type combination';
            $img_url = file_exists(public_path().'/vendor/consoletvs/charts/error.png') ? asset('/vendor/consoletvs/charts/error.png') : 'http://www.iconsfind.com/wp-content/uploads/2015/12/20151208_56663ed552e5d.png';

            $error = "<div style='position: relative;";
            if (!$this->responsive) {
                $error .= $this->height ? 'height: '.$this->height.'px' : '';
                $error .= $this->width ? 'width: '.$this->width.'px' : '';
            }
            $error .= "'><center><div style='position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);'><img style='width: 75px; height: 75px;' src='$img_url'><br><br><b>$error_msg</b></div></center><div>";

            return $error;
        }
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
}
