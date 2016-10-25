<?php
$graph .="
    <div "; if (!$this->responsive) {
                $graph .= $this->width ? "style='width: $this->width'" : '';
            } $graph .= "><center><b style='font-family: Arial, Helvetica, sans-serif;font-size: 18px;'>$this->title</b><br></center></div>
    <center><div id='$this->id'></div></center>
    ";
?>
