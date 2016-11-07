<?php

$graph = '
<div '; if (! $this->responsive) {
    $graph .= $this->width ? "style='width: ".$this->width."px'" : '';
} $graph .= "><center><b style='font-family: Arial, Helvetica, sans-serif;font-size: 18px;'>$this->title</b></center></div>
	<div id='$this->id' "; if (! $this->responsive) {
    $graph .= "style='";
    $graph .= $this->height ? 'height: '.$this->height.'px' : '';
    $graph .= $this->width ? 'width: '.$this->width.'px' : '';
    $graph .= "'";
} else {
    $graph .= "style='height: 100%; width: 100%;'";
} $graph .= " ></div>
    <script type='text/javascript'>
		$(function (){
			Morris.Line({
			  element: '$this->id',
			  resize: true,
			  data: [
				";
                    $i = 0;
                    foreach ($this->values as $v) {
                        $l = $this->labels[$i];
                        $graph .= "{x: \"$l\", y: $v},";
                        $i++;
                    }
                $graph .= "
			  ],
			  xkey: 'x',
			  ykeys: ['y'],
			  labels: [\"$this->element_label\"],
			  hideHover: 'auto',
			  parseTime: false,
			  ";
                if ($this->colors) {
                    $graph .= 'lineColors: ["'.$this->colors[0].'"],';
                }
              $graph .= '

			});
		});
    </script>
';

return $graph;
