<?php

$graph = '';

if( !$this->customId )
{
    include __DIR__ . '/../_partials/titledDiv2-container.php';
}

$graph .= "
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
