<?php
$graph .= '<svg ';
    if ($this->responsive) {
        $graph .= "width='100%' height='100%'";
    } else {
        $graph .= $this->height ? "height='$this->height' " : '';
        $graph .= $this->width ? "width='$this->width' " : '';
    }
$graph .= " id='$this->id'></svg>";
?>
