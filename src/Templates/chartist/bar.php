<?php

$graph = '
<div '; if (! $this->responsive) {
    $graph .= "style='width: $this->width'";
} $graph .= "><center><b style='font-family: Arial, Helvetica, sans-serif;font-size: 18px;'>$this->title</b></center></div>
<div id='$this->id' "; if (! $this->responsive) {
    $graph .= "style='max-height: $this->height; max-width: $this->width'";
} $graph .= " class='ct-chart ct-perfect-fourth'></div>
    <script type='text/javascript'>
		var data = {
			labels: ["; foreach ($this->labels as $label) {
    $graph .= '"'.$label.'",';
} $graph .= '],
			series: [['; foreach ($this->values as $value) {
    $graph .= $value.',';
} $graph .= ']]
		};

        var options = {
            ';
            if (! $this->responsive) {
                $graph .= $this->height ? 'height: "'.$this->height.'px",' : '';
                $graph .= $this->width ? 'width: "'.$this->width.'px",' : '';
            }
            $graph .= "
        }
		new Chartist.Bar('#$this->id', data, options);
    </script>
";

return $graph;
