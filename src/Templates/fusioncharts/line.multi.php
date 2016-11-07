<?php

$graph = "
    <script type='text/javascript'>
		FusionCharts.ready(function () {
			var revenueChart = new FusionCharts({
				type: 'msline',
				renderAt: '$this->id',
				"; if ($this->responsive) {
    $graph .= "
							width: '100%',
							height: '100%',
						";
} else {
    $graph .= $this->width ? "width: '$this->width'," : "width: '100%',";
    $graph .= $this->height ? "height: '$this->height'," : "height: '100%',";
}
                $graph .= "
				dataFormat: 'json',
				dataSource: {
					'chart': {
						'caption': \"$this->title\",
						'yAxisName': \"$this->element_label\",
						'bgColor': '#ffffff',
						'borderAlpha': '20',
						'canvasBorderAlpha': '0',
						'usePlotGradientColor': '0',
						'plotBorderAlpha': '10',
						'rotatevalues': '1',
						'valueFontColor': '#ffffff',
						'showXAxisLine': '1',
						'xAxisLineColor': '#999999',
						'divlineColor': '#999999',
						'divLineIsDashed': '1',
						'showAlternateHGridColor': '0',
						'subcaptionFontBold': '0',
						'subcaptionFontSize': '14'
					},
                    'categories': [{
                        'category': [
                            ";
                            foreach ($this->labels as $l) {
                                $graph .= "{
                                    'label': \"$l\",
                                },";
                            }
                            $graph .= "
                            ]
                        }],
                    'dataset': [
                        ";
                        $i = 0;
                        foreach ($this->datasets as $el => $ds) {
                            $graph .= "
                                {
                                    'seriesname': \"$el\",
                                    ";
                            $graph .= ($this->colors and count($this->colors) > $i) ? "'color': \"".$this->colors[$i].'",' : '';
                            $graph .= "
                                    'data': [
                                        ";
                            foreach ($ds['values'] as $v) {
                                $graph .= "
                                                {
                                                    'value': '$v'
                                                },
                                            ";
                            }
                            $graph .= '
                                    ]
                                },
                            ';
                            $i++;
                        }
                        $graph .= "
                   ]
				}
			}).render();
		});
    </script>
	<div id='$this->id'></div>
";

return $graph;
