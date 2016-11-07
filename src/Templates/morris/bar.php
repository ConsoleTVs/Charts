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
