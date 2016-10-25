<?php

// Get the max / min index
$max = 0;
$min = $this->values ? $this->values[0] : 0;
foreach ($this->values as $dta) {
    if ($dta > $max) {
        $max = $dta;
    } elseif ($dta < $min) {
        $min = $dta;
    }
}
$graph = "
    <script type='text/javascript'>
        $(function () {
            var chart = new Highcharts.Map({
                chart: {
                        renderTo: \"$this->id\",
                "; if (!$this->responsive) {
    $graph .= $this->width ? "width: $this->width," : '';
    $graph .= $this->height ? "height: $this->height," : '';
}
                $graph .= "
                },
                title : {
                    text : \"$this->title\"
                },

                mapNavigation: {
                    enabled: true,
                    enableDoubleClickZoomTo: true
                },

                colorAxis: {
                    min: $min,
                    "; if ($this->colors and count($this->colors) >= 2) {
                    $graph .= 'minColor: "'.$this->colors[0].'",';
                } $graph .= "
                    max: $max,
                    "; if ($this->colors and count($this->colors) >= 2) {
                    $graph .= 'maxColor: "'.$this->colors[1].'",';
                } $graph .= '
                },

                series : [{
                    data : [';
                      $i = 0;
                      foreach ($this->values as $dta) {
                          $e = $this->labels[$i];
                          $v = $dta;
                          $graph .= "{'code': \"$e\", 'value': $v},";
                          $i++;
                      }
                      $graph .= "
                    ],
                    mapData: Highcharts.maps['custom/world'],
                    joinBy: ['iso-a2', 'code'],
                    name: \"$this->element_label\",
                    states: {
                        hover: {
                            color: '#BADA55'
                        }
                    },
                }]
            });
        });
    </script>
";

if( !$this->customId )
{
    include __DIR__ . '/../_partials/div-container.php';
}

return $graph;
