<?php

$graph = "
    <canvas id='$this->id' ";
    if (! $this->responsive) {
        $graph .= $this->height ? "height='$this->height' " : '';
        $graph .= $this->width ? "width='$this->width' " : '';
    }
    $graph .= " ></canvas>
    <script>
        var ctx = document.getElementById('$this->id');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ["; foreach ($this->labels as $label) {
        $graph .= "'".$label."',";
    } $graph .= '],
                datasets: [{
                    data: ['; foreach ($this->values as $dta) {
        $graph .= $dta.',';
    } $graph .= '],
                    backgroundColor: [';
                    if ($this->colors) {
                        foreach ($this->colors as $color) {
                            $graph .= '"'.$color.'",';
                        }
                    } else {
                        foreach ($this->values as $dta) {
                            $graph .= "'".sprintf('#%06X', mt_rand(0, 0xFFFFFF))."',";
                        }
                    }
                    $graph .= '],
                }]
            },
            options: {
                responsive: '; $graph .= ($this->responsive or ! $this->width) ? 'true' : 'false'; $graph .= ",
                maintainAspectRatio: false,
                title: {
                    display: true,
                    text: \"$this->title\",
                    fontSize: 20,
                }
            }
        });
    </script>
";

return $graph;
