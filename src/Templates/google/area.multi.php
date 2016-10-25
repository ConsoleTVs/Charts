<?php

$graph = "
    <script type='text/javascript'>

    chart = google.charts.setOnLoadCallback(drawChart);

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
              $graph .= '
        ]);

        var options = {
            ';
            if (!$this->responsive) {
                $graph .= $this->width ? "width: $this->width," : '';
                $graph .= $this->height ? "height: $this->height," : '';
            }
            $graph .= "
            fontSize: 12,
            title: \"$this->title\",
            "; if ($this->colors) {
                $graph .= 'colors: [';
                foreach ($this->colors as $c) {
                    $graph .= "'".$c."',";
                }
                $graph .= '],';
            } $graph .= "
            legend: { position: 'top', alignment: 'end' }
        };

        var chart = new google.visualization.AreaChart(document.getElementById('$this->id'));

        chart.draw(data, options);
    }
    </script>
";

if( !$this->customId )
{
    include __DIR__ . '/../_partials/div-container.php';
}

return $graph;
