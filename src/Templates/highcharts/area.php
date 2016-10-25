<?php

$graph = "
    <script type='text/javascript'>
        $(function () {
            var chart = new Highcharts.Chart({
                chart: {
                    type: 'area',
                    renderTo: \"$this->id\",
                "; if (!$this->responsive) {
    $graph .= $this->width ? "width: $this->width," : '';
    $graph .= $this->height ? "height: $this->height," : '';
}
                $graph .= "
                },
                title: {
                    text: \"$this->title\",
                    x: -20 //center
                },
                xAxis: {
                    categories: ["; foreach ($this->labels as $label) {
                    $graph .= '"'.$label.'",';
                } $graph .= "]
                },
                yAxis: {
                    title: {
                        text: \"$this->element_label\"
                    },
                    plotLines: [{
                        value: 0,
                        height: 0.5,
                        width: 1,
                        color: '#808080'
                    }]
                },
                "; if ($this->colors) {
                    $graph .= '
                        plotOptions: {
                            series: {
                                color: "'.$this->colors[0].'"
                            }
                        },
                    ';
                }
                $graph .= "
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                    name: \"$this->element_label\",
                    data: ["; foreach ($this->values as $dta) {
                    $graph .= $dta.',';
                } $graph .= "]
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
