<?php

$graph = "
    <script type='text/javascript'>
        $(function () {
            Highcharts.setOptions({global: { useUTC: false } });
            $this->id = new Highcharts.Chart({

                    chart: {
                        renderTo: \"$this->id\",
                        type: 'column',
                        events: {
                            load: requestData
                        },
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
                    type: 'datetime',
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
                    name: '$this->element_label',
                    data: [],
                    pointStart: new Date().getTime(),
                    pointInterval: ($this->interval)
                }]
            });
            function requestData() {
                $.ajax({
                    url: \"$this->url\",
                    success: function(point) {
                        var series = $this->id.series[0],
                            shift = series.data.length >= $this->max_values; // shift if the series is
                                                             // longer than 20

                        // add the point
                        $this->id.series[0].addPoint(point[\"$this->value_name\"], true, shift);
                        $this->id.xAxis.categories

                        // call it again after one second
                        setTimeout(requestData, $this->interval);
                    },
                    cache: false
                });
            }
        });
    </script>
";

if( !$this->customId )
{
    include __DIR__ . '/../_partials/div-container.php';
}

return $graph;
