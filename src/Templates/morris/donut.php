<?php

$graph = '';

if( !$this->customId )
{
    include __DIR__ . '/../_partials/titledDiv2-container.php';
}

$graph .= "
    <script type='text/javascript'>
		$(function (){
			Morris.Donut({
			  element: '$this->id',
			  resize: true,
			  data: [
				";
                    $i = 0;
                    foreach ($this->values as $v) {
                        $l = $this->labels[$i];
                        $graph .= "{label: \"$l\", value: $v},";
                        $i++;
                    }
                $graph .= '
			  ],
			  ';
                if ($this->colors) {
                    $graph .= 'colors: [';
                    foreach ($this->colors as $c) {
                        $graph .= "\"$c\",";
                    }
                    $graph .= ']';
                }
              $graph .= '

			});
		});
    </script>
';

return $graph;
