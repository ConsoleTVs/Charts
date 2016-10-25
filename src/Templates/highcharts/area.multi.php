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
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [
                    ";
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
