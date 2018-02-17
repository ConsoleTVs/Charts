<?php

namespace ConsoleTVs\Charts\Classes;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

class BaseChart
{
    /**
     * Stores the chart ID.
     *
     * @var string
     */
    public $id;

    /**
     * Stores the chart datasets.
     *
     * @var array
     */
    public $datasets = [];

    /**
     * Stores the dataset class to be used.
     *
     * @var object
     */
    protected $dataset = DatasetClass::class;

    /**
     * Stores the chart labels.
     *
     * @var array
     */
    public $labels = [];

    /**
     * Stores the chart container.
     *
     * @var string
     */
    public $container = '';

    /**
     * Stores the chart options.
     *
     * @var array
     */
    public $options = [];

    /**
     * Stores the chart script.
     *
     * @var string
     */
    public $script = '';

    /**
     * Stores the chart type.
     *
     * @var string
     */
    public $type = '';

    /**
     * Stores the height of the chart.
     *
     * @var int
     */
    public $height = 400;

    /**
     * Stores the width of the chart.
     *
     * @var int
     */
    public $width = null;

    /**
     * Stores the available chart letters to create the ID.
     *
     * @var string
     */
    private $chartLetters = 'abcdefghijklmnopqrstuvwxyz';

    /**
     * Chart constructor.
     */
    public function __construct()
    {
        $this->id = substr(str_shuffle(str_repeat($x = $this->chartLetters, ceil(25 / strlen($x)))), 1, 25);
    }

    /**
     * Adds a new dataset to the chart.
     *
     * @param string           $name
     * @param array|Collection $data
     */
    public function dataset(string $name, string $type, $data)
    {
        $dataset = new $this->dataset($name, $type, $data);

        array_push($this->datasets, $dataset);

        return $dataset;
    }

    /**
     * Set the chart labels.
     *
     * @param array|Collection $labels
     *
     * @return self
     */
    public function labels($labels)
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * Set the chart options.
     *
     * @param array|Collection $options
     * @param bool             $overwrite
     *
     * @return self
     */
    public function options($options, bool $overwrite = false)
    {
        if ($overwrite) {
            $this->options = $options;
        } else {
            $this->options = array_replace_recursive($this->options, $options);
        }

        return $this;
    }

    /**
     * Set the chart container.
     *
     * @param string $container
     *
     * @return self
     */
    public function container(string $container = null)
    {
        if (!$container) {
            return View::make($this->container, ['chart' => $this]);
        }

        $this->container = $container;

        return $this;
    }

    /**
     * Set the chart script.
     *
     * @param string $script
     *
     * @return self
     */
    public function script(string $script = null)
    {
        if (count($this->datasets) == 0) {
            throw new \Exception('No datasets provided, please provide at least one dataset to generate a chart');
        }

        if (!$script) {
            return View::make($this->script, ['chart' => $this]);
        }

        $this->script = $script;

        return $this;
    }

    /**
     * Set the chart type.
     *
     * @param string $type
     *
     * @return self
     */
    public function type(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the chart height.
     *
     * @param int $height
     *
     * @return self
     */
    public function height(int $height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Set the chart width.
     *
     * @param int $width
     *
     * @return self
     */
    public function width(int $width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Formats the type to be a correct output.
     *
     * @return string
     */
    public function formatType()
    {
        return strtolower($this->type ? $this->type : $this->datasets[0]->type);
    }

    /**
     * Formats the labels to be a correct output.
     *
     * @return string
     */
    public function formatLabels()
    {
        return json_encode($this->labels);
    }

    /**
     * Formats the chart options.
     *
     * @param bool $strict
     *
     * @return string
     */
    public function formatOptions(bool $strict = false, bool $noBraces = false)
    {
        if (!$strict && count($this->options) === 0) {
            return '';
        }

        $options = json_encode($this->options);

        return $noBraces ? substr($options, 1, -1) : $options;
    }

    /**
     * Reset the chart options.
     *
     * @return self
     */
    public function reset()
    {
        return $this->options([], true);
    }

    /**
     * Formats the datasets for the output.
     *
     * @return string
     */
    public function formatDatasets()
    {
        return Collection::make($this->datasets)
            ->each
            ->matchValues(count($this->labels))
            ->map
            ->format($this->labels)
            ->toJson();
    }

    /**
     * Formats the container options.
     *
     * @param string $type
     * @param bool   $maxIfNull
     *
     * @return string
     */
    public function formatContainerOptions(string $type = 'css', bool $maxIfNull = false)
    {
        $options = '';
        $height = ($maxIfNull && !$this->height) ? '100%' : $this->height;
        $width = ($maxIfNull && !$this->width) ? '100%' : $this->width;

        switch ($type) {
            case 'css':
                $options .= " style='";
                (!$height) ?: $options .= "height: {$height}px !important;";
                (!$width) ?: $options .= "width: {$width}px !important;";
                $options .= "' ";
                break;
            case 'js':
                if ($height) {
                    if (is_int($height)) {
                        $options .= "height: {$height}, ";
                    } else {
                        $options .= "height: '{$height}', ";
                    }
                }
                if ($width) {
                    if (is_int($width)) {
                        $options .= "width: {$width}, ";
                    } else {
                        $options .= "width: '{$width}', ";
                    }
                }
                break;
            default:
                (!$height) ?: $options .= " height='{$this->height}' ";
                (!$this->width) ?: $options .= " width='{$this->width}' ";
        }

        return $options;
    }
}
