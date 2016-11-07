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
			var data = [
				"; for ($i = 0; $i < count($this->values); $i++) {
    $graph .= '{x: "'.$this->labels[$i].'", y: '.$this->values[$i];
    $graph .= $this->colors ? ', color: "'.$this->colors[$i].'" ' : '';
    $graph .= ' },';
}
                $graph .= "
			];

			var xScale = new Plottable.Scales.Category();
			var yScale = new Plottable.Scales.Linear();

			var xAxis = new Plottable.Axes.Category(xScale, 'bottom');
  			var yAxis = new Plottable.Axes.Numeric(yScale, 'left');

			var reverseMap = {};
  			data.forEach(function(d) { reverseMap[d.y] = d.x;});

			var plot = new Plottable.Plots.Pie()
			  .addDataset(new Plottable.Dataset(data))
			  .sectorValue(function(d) { return d.y; }, yScale)
			  "; $graph .= $this->colors ? ".attr('fill', function(d) { return d.color; })" : ''; $graph .= "
			  .labelsEnabled(true)
			  .labelFormatter(function(n){ return reverseMap[n] ;})
			  .outerRadius(500, yScale)
			  .animated(true);


			  var title = new Plottable.Components.TitleLabel(\"$this->title\")
  			  .yAlignment('center');


			 var table = new Plottable.Components.Table([[title],[plot]]);
		 	table.renderTo('svg#$this->id');


			window.addEventListener('resize', function() {
			  table.redraw();
			});
		});
	</script>
";

return $graph;
