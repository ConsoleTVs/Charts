<?php

$graph = "<div id=\"$this->id\" style=\"
    ";
        if (! $this->responsive) {
            $graph .= $this->height ? 'height: '.$this->height.'px;' : '';
            $graph .= $this->width ? 'width: '.$this->width.'px;' : '';
        }
    $graph .= "
\"></div>

<script>
    $(function() {
        var $this->id = new JustGage({
            id: \"$this->id\",
            value: "; $graph .= $this->values ? $this->values[0] : '0'; $graph .= ',
            ';

            if (count($this->values) >= 2 and $this->values[1] <= $this->values[0]) {
                $min = $this->values[1];
                $graph .= "min: $min,";
            } else {
                $min = 0;
            }
            if (count($this->values) >= 3 and $this->values[2] >= $this->values[0]) {
                $max = $this->values[2];
                $graph .= "max: $max,";
            } else {
                $max = 100;
            }

            $graph .= "
            gaugeWidthScale: 0.6,
            pointer: true,
            counter: true,
            title: \"$this->title\",
            label: \"$this->element_label\",
            hideInnerShadow: true
        });
        setInterval(function() {
            $.getJSON( \"$this->url\", function( jdata ) {
                $this->id.refresh(jdata[\"$this->value_name\"]);
            })
        }, $this->interval);
    });
</script>
";

return $graph;
