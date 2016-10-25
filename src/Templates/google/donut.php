<?php

$graph = "
    <script type='text/javascript'>
      google.charts.setOnLoadCallback(drawPieChart);
      function drawPieChart() {
        var data = google.visualization.arrayToDataTable([
          ['Element', 'Value'],
          ";
            $i = 0;
            foreach ($this->values as $dta) {
                $e = $this->labels[$i];
                $v = $dta;
                $graph .= "[\"$e\", $v],";
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
			pieHole: 0.4,
            title: \"$this->title\",";
            if ($this->colors) {
                $graph .= 'colors:[';
                foreach ($this->colors as $color) {
                    $graph .= "'$color',";
                }
                $graph .= '],';
            }
        $graph .= "
        };
        var chart = new google.visualization.PieChart(document.getElementById('$this->id'));
        chart.draw(data, options);
      }
    </script>
";

if( !$this->customId )
{
    include __DIR__ . '/../_partials/div-container.php';
}

return $graph;
