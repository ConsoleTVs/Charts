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
			Morris.Area({
			  element: '$this->id',
			  resize: true,
			  data: [
				";
                $k = 0;
                    foreach ($this->labels as $l) {
                        $graph .= "{x: \"$l\",";
                        $i = 0;
                        foreach ($this->datasets as $ds) {
                            $graph .= "s$i: ".$ds['values'][$k].', ';
                            $i++;
                        }
                        $graph .= "},\n";
                        $k++;
                    }
                $graph .= "
			  ],
			  xkey: 'x',
			  labels: [";
              foreach ($this->datasets as $el => $ds) {
                  $graph .= "\"$el\", ";
              }
              $graph .= '],
			  ykeys: [';
                  for ($i = 0; $i < count($this->datasets); $i++) {
                      $graph .= "\"s$i\", ";
                  }
                  $graph .= "],
			  hideHover: 'auto',
			  parseTime: false,
			  ";
                if ($this->colors) {
                    $graph .= 'lineColors: [
                        ';
                    foreach ($this->colors as $c) {
                        $graph .= "'$c', ";
                    }
                    $graph .= '
                    ],';
                }
              $graph .= '

			});
		});
    </script>
';

return $graph;
