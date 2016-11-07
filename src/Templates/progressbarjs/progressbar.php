<?php

$min = count($this->values) >= 2 ? $this->values[1] : 0;
$max = count($this->values) >= 3 ? $this->values[2] : 100;

$graph = "

<div id=\"$this->id\" style=\" position: relative;
    ";
        if (! $this->responsive) {
            if ($this->height) {
                $graph .= 'height: '.$this->height.'px;';
            }
            $graph .= $this->width ? 'width: '.$this->width.'px;' : '';
        }
    $graph .= "
\"></div>

<script>
    $(function() {
        var $this->id = new ProgressBar.Line('#$this->id', {
            color: '"; $graph .= ($this->colors and count($this->colors)) ? $this->colors[0] : '#ffc107'; $graph .= "',
            strokeWidth: 4,
            svgStyle: {width: '100%', height: '100%'},
            easing: 'easeInOut',
            duration: 1000,
            trailColor: '#eee',
            trailWidth: 4,
        });
        $this->id.animate(".($this->values[0] - $min) / ($max - $min).');  // Number from 0.0 to 1.0
    });
</script>
';

return $graph;
