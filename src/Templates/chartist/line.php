<?php

$graph = '
<div '; if (! $this->responsive) {
    $graph .= $this->width ? "style='width: ".$this->width."px'" : '';
} $graph .= "><center><b style='font-family: Arial, Helvetica, sans-serif;font-size: 18px;'>$this->title</b></center></div>
<div id='$this->id'></div>
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
		new Chartist.Line('#$this->id', data, options);
    </script>
";

return $graph;
