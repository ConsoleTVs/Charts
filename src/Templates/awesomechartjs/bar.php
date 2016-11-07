<?php

$graph = "
    <canvas id='$this->id' ";
    if (! $this->responsive) {
        $graph .= $this->height ? "height='$this->height' " : '';
        $graph .= $this->width ? "width='$this->width' " : '';
    }
    $graph .= " ></canvas>
    <script>
        var awesomechart = new AwesomeChart('$this->id');
            awesomechart.title = '$this->title';
            awesomechart.data = ["; foreach ($this->values as $dta) {
        $graph .= $dta.',';
    }
            $graph .= '];
            awesomechart.labels = ['; foreach ($this->labels as $label) {
                $graph .= '"'.$label.'",';
            }
            $graph .= '];
            awesomechart.colors = [';
                if ($this->colors) {
                    foreach ($this->colors as $color) {
                        $graph .= '"'.$color.'",';
                    }
                } else {
                    foreach ($this->values as $dta) {
                        $graph .= "'".sprintf('#%06X', mt_rand(0, 0xFFFFFF))."',";
                    }
                }
            $graph .= '];
            awesomechart.randomColors = false;
            awesomechart.draw();
    </script>
';

return $graph;
