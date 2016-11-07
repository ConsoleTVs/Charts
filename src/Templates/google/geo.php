<?php

$graph = "
    <script type='text/javascript'>
      google.charts.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {

        var data = google.visualization.arrayToDataTable([
            ['Country', \"$this->element_label\"],
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
            if (! $this->responsive) {
                $graph .= $this->width ? "width: $this->width," : '';
                $graph .= $this->height ? "height: $this->height," : '';
            }
          $graph .= '
          colorAxis: {colors: ['; if ($this->colors and count($this->colors >= 2)) {
              $graph .= "'".$this->colors[0]."', '".$this->colors[1]."'";
          } $graph .= "]},
          datalessRegionColor: \"#e0e0e0\",
          defaultColor: \"#607D8\",
        };

        var chart = new google.visualization.GeoChart(document.getElementById('$this->id'));

        chart.draw(data, options);
      }
    </script>
    <div "; if (! $this->responsive) {
              $graph .= $this->width ? "style='width: $this->width'" : '';
          } $graph .= "><center><b style='font-family: Arial, Helvetica, sans-serif;font-size: 18px;'>$this->title</b><br><br></center></div>
    <div id='$this->id'></div>
";

return $graph;
