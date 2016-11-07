<?php

$graph = '
<svg ';
if ($this->responsive) {
    $graph .= "width='100%' height='100%'";
} else {
    $graph .= $this->height ? "height='$this->height' " : '';
    $graph .= $this->width ? "width='$this->width' " : '';
}
$graph .= " id='$this->id'></svg>
	<script>
		$(function() {
			";
            $i = 0;
            foreach ($this->datasets as $ds) {
                $graph .= "
                    var s$i = [
                        ";
                for ($k = 0; $k < count($ds['values']); $k++) {
                    $graph .= '{x: "'.$this->labels[$k].'", y: '.$ds['values'][$k].' },';
                }
                $graph .= '
                    ];
                ';
                $i++;
            }
            $graph .= "

			var xScale = new Plottable.Scales.Category();
			var yScale = new Plottable.Scales.Linear();

			var xAxis = new Plottable.Axes.Category(xScale, 'bottom');
  			var yAxis = new Plottable.Axes.Numeric(yScale, 'left');

			var plot = new Plottable.Plots.Line()
			  ";
              for ($i = 0; $i < count($this->datasets); $i++) {
                  $graph .= ".addDataset(new Plottable.Dataset(s$i))";
              }
              $graph .= '
			  .x(function(d) { return d.x; }, xScale)
			  .y(function(d) { return d.y; }, yScale)
			  '; $graph .= $this->colors ? ".attr('stroke', \"".$this->colors[0].'")' : ''; $graph .= "
			  .animated(true);

			  var title = new Plottable.Components.TitleLabel(\"$this->title\")
  			  .yAlignment('center');;

			  var label = new Plottable.Components.AxisLabel(\"$this->element_label\")
			  .yAlignment('center');

			 var table = new Plottable.Components.Table([[label, title],[yAxis, plot],[null, xAxis]]);
		 	table.renderTo('svg#$this->id');


			window.addEventListener('resize', function() {
			  table.redraw();
			});
		});
	</script>
";

return $graph;
