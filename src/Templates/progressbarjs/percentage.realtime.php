<?php

$min = count($this->values) >= 2 ? $this->values[1] : 0;
$max = count($this->values) >= 3 ? $this->values[2] : 100;

$graph = "
<center><div id=\"$this->id\" style=\" position: relative;
    ";
        if (! $this->responsive) {
            if ($this->height) {
                $graph .= 'height: '.$this->height.'px;';
                $this->width = $this->height;
            }
            $graph .= $this->width ? 'width: '.$this->width.'px;' : '';
        }
    $graph .= "
\"></div></center>
<script>
    $(function() {
        var $this->id = new ProgressBar.Circle('#$this->id', {
            color: '"; $graph .= ($this->colors and count($this->colors) >= 2) ? $this->colors[1] : '#000'; $graph .= "',
            // This has to be the same size as the maximum width to
            // prevent clipping
            strokeWidth: 4,
            trailWidth: 1,
            easing: 'easeInOut',
            duration: 1000,
            text: {
                autoStyleContainer: false
            },
            from: { color: '#aaa', width: 4 },
            to: { color: '"; $graph .= $this->colors ? $this->colors[0] : '#333'; $graph .= "', width: 4 },
            // Set default step function for all animate calls
            step: function(state, circle) {
                circle.path.setAttribute('stroke', state.color);
                circle.path.setAttribute('stroke-width', state.width);

                var value = ".$this->values[0].";
                if (value === 0) {
                  circle.setText('');
                } else {
                  circle.setText(value);
                }
            }
        });
        $this->id.animate(".($this->values[0] - $min) / ($max - $min).");  // Number from 0.0 to 1.0
        setInterval(function() {
            $.getJSON( \"$this->url\", function( jdata ) {
                var v = (jdata[\"$this->value_name\"] - $min)/($max - $min);
                $this->id.animate(v, {step: function(state, circle, attachment) {circle.setText(jdata[\"$this->value_name\"].toString())}});
            })
        }, $this->interval);
    });
</script>
";

return $graph;
