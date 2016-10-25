<?php

$graph = "
    <script type='text/javascript'>
      google.charts.setOnLoadCallback(draw$this->id);
      function draw$this->id() {
        var data = google.visualization.arrayToDataTable([
          ['Element', 'Value'],
          ";
            $graph .= $this->values ? '["'.$this->element_label.'", '.$this->values[0].'],' : '["'.$this->element_label.'", 0],';
            $graph .= '
        ]);
        var options = {
            ';
            if (!$this->responsive) {
                $graph .= $this->width ? "width: $this->width," : '';
                $graph .= $this->height ? "height: $this->height," : '';
            }

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


            if ($this->gauge_style == 'right') {
                // Calculate warning area
                $low_warning = round(0.40 * $max, 2);
                $warning = round(0.25 * $max, 2);
                $max_warning = round(0.10 * $max, 2);

                $graph .= "
                    greenColor: '#c8e6c9', yellowColor: '#ffd54f', redColor: '#e57373',
                    greenFrom: $low_warning, greenTo: $max,
                    yellowFrom: $max_warning, yellowTo: $low_warning,
                    redFrom: $min, redTo: $max_warning,
                ";
            } elseif ($this->gauge_style == 'center') {
                // Calculate warning area
                $warning = round(0.25 * $max, 2);
                $warning2 = round(0.75 * $max, 2);

                $graph .= "
                    greenColor: '#c8e6c9', yellowColor: '#ffd54f', redColor: '#ffd54f',
                    greenFrom: $warning, greenTo: $warning2,
                    yellowFrom: $min, yellowTo: $warning,
                    redFrom: $warning2, redTo: $max,
                ";
            } else {
                // Calculate warning area
                $low_warning = round(0.60 * $max, 2);
                $warning = round(0.75 * $max, 2);
                $max_warning = round(0.90 * $max, 2);

                $graph .= "
                    greenColor: '#c8e6c9', yellowColor: '#ffd54f', redColor: '#e57373',
                    greenFrom: $min, greenTo: $low_warning,
                    yellowFrom: $low_warning, yellowTo: $max_warning,
                    redFrom: $max_warning, redTo: $max,
                ";
            }

            $graph .= "

            minorTicks: 10,
        };
        var $this->id = new google.visualization.Gauge(document.getElementById('$this->id'));
        $this->id.draw(data, options);

        setInterval(function() {
            $.getJSON( \"$this->url\", function( jdata ) {
                data.setValue(0, 1, jdata[\"$this->value_name\"]);
                $this->id.draw(data, options);
            })
        }, $this->interval);

      }
    </script>
";

if( !$this->customId )
{
    include __DIR__ . '/../_partials/titledDiv-container.php';
}

return $graph;
