<?php
	$graph = '
	<div '; if (!$this->responsive) {
	    $graph .= $this->width ? "style='width: ".$this->width."px'" : '';
	} $graph .= "><center><b style='font-family: Arial, Helvetica, sans-serif;font-size: 18px;'>$this->title</b></center></div>
		<div id='$this->id' "; if (!$this->responsive) {
	    $graph .= "style='";
	    $graph .= $this->height ? 'height: '.$this->height.'px' : '';
	    $graph .= $this->width ? 'width: '.$this->width.'px' : '';
	    $graph .= "'";
	} else {
	    $graph .= "style='height: 100%; width: 100%;'";
	} $graph .= " ></div>";
?>
