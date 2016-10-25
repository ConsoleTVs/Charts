<?php

$graph = '';

if( !$this->customId )
{
    include __DIR__ . '/../_partials/titledDiv2-container.php';
}

$graph .= "
    <script type='text/javascript'>
		$(function () {
			Morris.Bar({
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
					";
                    if ($this->colors) {
                        $i = 0;
                        $graph .= 'barColors: function (row, series, type) {';
                        foreach ($this->colors as $c) {
                            if ($i == 0) {
                                $graph .= 'if(row.label == "'.$this->labels[$i].'") return "'.$this->colors[$i].'";
								';
                            } else {
                                $graph .= 'else if(row.label == "'.$this->labels[$i].'") return "'.$this->colors[$i].'";
								';
                            }
                            $i++;
                        }
                        $graph .= '}';
                    }

                    $graph .= '


			});
		});
    </script>
';

return $graph;
