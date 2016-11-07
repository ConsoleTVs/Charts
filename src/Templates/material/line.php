<?php

$graph = "
    <script type='text/javascript'>
    google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['', \"$this->element_label\"],
          ";
          for ($i = 0; $i < count($this->values); $i++) {
              $e = $this->labels[$i];
              $v = $this->values[$i];
              $graph .= "[\"$e\", $v],";
          }
          $graph .= "
        ]);

        var options = {
          chart: {
            title: \"$this->title\",
          },
          ";
          $graph .= $this->colors ? "colors: ['".$this->colors[0]."']" : '';
          $graph .= "
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
