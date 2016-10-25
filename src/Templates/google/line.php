<?php

$graph = "
    <script type='text/javascript'>

    chart = google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Element', \"$this->element_label\"],
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
            title: \"$this->title\",
            "; if ($this->colors) {
                $graph .= 'colors: ["'.$this->colors[0].'"],';
            } $graph .= "
            legend: { position: 'top', alignment: 'end' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('$this->id'));

        chart.draw(data, options);
    }
    </script>
";

if( !$this->customId )
{
    include __DIR__ . '/../_partials/div-container.php';
}

return $graph;
