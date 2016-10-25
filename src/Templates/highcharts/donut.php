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
                    type: 'pie'
                },
                title: {
                    text: \"$this->title\",
                },
                tooltip: {
                    pointFormat: '{point.y} <b>({point.percentage:.1f}%)</b>'
                },
                plotOptions: {
                    pie: {
						innerSize: 225,
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y} ({point.percentage:.1f}%)',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    colorByPoint: true,
                    data: [
                    ";
                    $i = 0;
                    foreach ($this->values as $dta) {
                        $e = $this->labels[$i];
                        $v = $dta;
                        $graph .= "{name: \"$e\", y: $v},";
                        $i++;
                    }
                    $graph .= "
                    ]
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
