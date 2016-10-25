<?php

$graph = "
    <script type='text/javascript'>
      google.charts.setOnLoadCallback(drawPieChart);
      function drawPieChart() {

          var data = google.visualization.arrayToDataTable([
              ['Element', \"$this->element_label\""; if ($this->colors) {
    $graph .= ", { role: 'style' }";
} $graph .= '],
              ';
                $i = 0;
                foreach ($this->values as $dta) {
                    $e = $this->labels[$i];
                    $v = $dta;
                    $graph .= "[\"$e\", $v";
                    if ($this->colors) {
                        $graph .= ", '".$this->colors[$i]."'";
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
            legend: { position: 'top', alignment: 'end' },
            fontSize: 12,
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

        var chart = new google.visualization.ColumnChart(document.getElementById('$this->id'));

        chart.draw(data, options);
      }
    </script>
";

if( !$this->customId )
{
    include __DIR__ . '/../_partials/div-container.php';
}

return $graph;
