<?php

$graph = "
    <script type='text/javascript'>
		FusionCharts.ready(function () {
			var revenueChart = new FusionCharts({
				type: 'pie2d',
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
						'paletteColors': '#0075c2',
						'bgColor': '#ffffff',
						'showBorder': '0',
						'use3DLighting': '0',
						'showShadow': '0',
						'enableSmartLabels': '1',
						'startingAngle': '0',
						'showPercentValues': '1',
						'showPercentInTooltip': '0',
						'decimals': '1',
						'captionFontSize': '14',
						'subcaptionFontSize': '14',
						'subcaptionFontBold': '0',
						'toolTipColor': '#ffffff',
						'toolTipBorderThickness': '0',
						'toolTipBgColor': '#000000',
						'toolTipBgAlpha': '80',
						'toolTipBorderRadius': '2',
						'toolTipPadding': '5',
						'showHoverEffect':'1',
						'showLegend': '1',
						'legendBgColor': '#ffffff',
						'legendBorderAlpha': '0',
						'legendShadow': '0',
						'legendItemFontSize': '10',
						'legendItemFontColor': '#666666'
					},
					'data': [
						";
                            $i = 0;
                            foreach ($this->values as $v) {
                                $l = $this->labels[$i];
                                $graph .= "
									{
										'label': \"$l\",
										'value': \"$v\",
										";
                                if ($this->colors) {
                                    $graph .= "
												'color': \"".$this->colors[$i].'",
											';
                                }
                                $graph .= '
									},
								';
                                $i++;
                            }
                        $graph .= "
					],
				}
			}).render();
		});
    </script>
	<div id='$this->id'></div>
";

return $graph;
