<?php

$graph = "
    <div><canvas id='$this->id'></canvas></div>
    <script type='text/javascript'>
        $(function (){
            var gauge = new RadialGauge({
              renderTo: \"$this->id\",
              "; $graph .= $this->colors ? 'colorNumbers: "'.$this->colors[0].'",' : ''; $graph .= '
              '; $graph .= $this->width ? "width: $this->width," : ''; $graph .= $this->height ? "height: $this->height," : ''; $graph .= "
              title: \"$this->title\",
              value: ".$this->values[0].",
              units: \"$this->element_label\",
              ";
                if (count($this->values) >= 2 and $this->values[1] <= $this->values[0]) {
                    $min = $this->values[1];
                    $graph .= "minValue: $min,";
                } else {
                    $min = 0;
                }
                if (count($this->values) >= 3 and $this->values[2] >= $this->values[0]) {
                    $max = $this->values[2];
                    $graph .= "maxValue: $max,";
                } else {
                    $max = 100;
                }

                $interval = 10;
                $interval_adder = round($max / $interval, 2);
                $graph .= 'majorTicks: [';
                    $r = $min;
                    for ($i = 0; $i <= $interval; $i++) {
                        if ($i == 0) {
                            $graph .= "$min,";
                        } elseif ($i == $interval) {
                            $graph .= "$max,";
                        } else {
                            $graph .= $r + $interval_adder.',';
                            $r = $r + $interval_adder;
                        }
                    }
                $graph .= '],';
              $graph .= "
              animationRule: 'linear',
              highlights: [
                  ";

                  if ($this->gauge_style == 'right') {
                      // Calculate warning area
                      $low_warning = round(0.40 * $max, 2);
                      $warning = round(0.25 * $max, 2);
                      $max_warning = round(0.10 * $max, 2);

                      $graph .= "
                          { from: $low_warning, to: $max, color: 'rgba(0,258,0,.20)' },
                          { from: $warning, to: $low_warning, color: 'rgba(255,255,0,.35)' },
                          { from: $max_warning, to: $warning, color: 'rgba(255,69,0,.40)' },
                          { from: $min, to: $max_warning, color: 'rgba(255,0,0,.5)' },
                      ";
                  } elseif ($this->gauge_style == 'center') {
                      // Calculate warning area
                      $warning = round(0.10 * $max, 2);

                      $warning2 = round(0.25 * $max, 2);

                      $warning3 = round(0.40 * $max, 2);
                      $warning4 = round(0.60 * $max, 2);

                      $warning5 = round(0.75 * $max, 2);

                      $warning6 = round(0.90 * $max, 2);

                      $graph .= "
                          { from: $warning3, to: $warning4, color: 'rgba(0,258,0,.20)' },
                          { from: $warning2, to: $warning3, color: 'rgba(255,255,0,.35)' },
                          { from: $warning4, to: $warning5, color: 'rgba(255,255,0,.35)' },
                          { from: $warning, to: $warning2, color: 'rgba(255,69,0,.40)' },
                          { from: $warning5, to: $warning6, color: 'rgba(255,69,0,.40)' },
                          { from: $min, to: $warning, color: 'rgba(255,0,0,.5)' },
                          { from: $warning6, to: $max, color: 'rgba(255,0,0,.5)' },
                      ";
                  } else {
                      // Calculate warning area
                      $low_warning = round(0.60 * $max, 2);
                      $warning = round(0.75 * $max, 2);
                      $max_warning = round(0.90 * $max, 2);

                      $graph .= "
                          { from: $min, to: $low_warning, color: 'rgba(0,258,0,.20)' },
                          { from: $low_warning, to: $warning, color: 'rgba(255,255,0,.35)' },
                          { from: $warning, to: $max_warning, color: 'rgba(255,69,0,.40)' },
                          { from: $max_warning, to: $max, color: 'rgba(255,0,0,.5)' },
                      ";
                  }

                  $graph .= '
            ],
          }).draw();
        });
    </script>
';

return $graph;
