<?php

$graph = '';

if( !$this->customId )
{
    include __DIR__ . '/../_partials/titledDiv2-container.php';
}

$graph .= "
    <script type='text/javascript'>
		$(function (){
			Morris.Bar({
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
                    $graph .= 'barColors: [
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
