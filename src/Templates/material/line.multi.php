<?php

$graph = "
    <script type='text/javascript'>
    google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
          var data = google.visualization.arrayToDataTable([
              ['Element', "; foreach ($this->datasets as $el => $ds) {
    $graph .= "\"$el\",";
} $graph .= '],
              ';
                $i = 0;
                foreach ($this->labels as $l) {
                    $graph .= "[\"$l\",";
                    foreach ($this->datasets as $el => $ds) {
                        $graph .= $ds['values'][$i].',';
                    }
                    $graph .= '],';
                    $i++;
                }
                $graph .= "
          ]);

        var options = {
          chart: {
            title: \"$this->title\",
          },
          ";
          if ($this->colors) {
              $graph .= 'colors: [';
              foreach ($this->colors as $c) {
                  $graph .= "'".$c."',";
              }
              $graph .= '],';
          } $graph .= "
        };

        var chart = new google.charts.Line(document.getElementById('$this->id'));

        chart.draw(data, options);
      }
    </script>
    <div style='";
    if (! $this->responsive) {
        $graph .= $this->height ? 'height: '.$this->height.'px;' : '';
        $graph .= $this->width ? 'width: '.$this->width.'px;' : '';
    }
    $graph .= "' id='$this->id'></div>
";

return $graph;
