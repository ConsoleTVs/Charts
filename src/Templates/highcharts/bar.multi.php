<?php

$graph = "
    <script type='text/javascript'>
        $(function () {
            var chart = new Highcharts.Chart({
                chart: {
                    renderTo: \"$this->id\",
                    "; if (!$this->responsive) {
    $graph .= $this->width ? "width: $this->width," : '';
    $graph .= $this->height ? "height: $this->height," : '';
}
                    $graph .= "
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'column'
                },
                title: {
                    text: \"$this->title\"
                },
                plotOptions: {
                   column: {
                       pointPadding: 0.2,
                       borderWidth: 0
                   }
               },
               xAxis: {
                    categories: [
                        ";
                        foreach ($this->labels as $label) {
                            $graph .= "\"$label\",";
                        }
                        $graph .= '
                    ],
                    crosshair: true
                },
                series: [
                    ';
                    $i = 0;
                    foreach ($this->datasets as $el => $ds) {
                        $graph .= "{
                            name: \"$el\",
                            ";
                        $graph .= ($this->colors && count($this->colors) > $i) ? 'color: "'.$this->colors[$i].'",' : '';
                        $graph .= '
                            data: [';
                        foreach ($ds['values'] as $dta) {
                            $graph .= $dta.',';
                        }
                        $graph .= ']
                            },';
                        $i++;
                    }
                    $graph .= "
                ]
            });
        });
    </script>
";

if( !$this->customId )
{
    include __DIR__ . '/../_partials/div-container.php';
}

return $graph;
