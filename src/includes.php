<?php

$includes['global'] = "<script src='".asset('/vendor/consoletvs/charts/jquery-3.0.0.min.js')."'></script>";

$includes['canvas-gauges'] = "<script src='".asset('/vendor/consoletvs/charts/canvas-gauges/gauge.min.js')."'></script>";

$includes['chartist'] = "<script src='".asset('/vendor/consoletvs/charts/chartist/chartist.min.js')."'></script>";
$includes['chartist'] .= "<link rel='stylesheet' type='text/css' href='".asset('/vendor/consoletvs/charts/chartist/chartist.min.css')."' />";

$includes['chartjs'] = "<script src='".asset('/vendor/consoletvs/charts/chartjs/Chart.js')."'></script>";

$includes['fusioncharts'] = "<script type='text/javascript' src='".asset('/vendor/consoletvs/charts/fusioncharts/fusioncharts.js')."'></script>";
$includes['fusioncharts'] .= "<script type='text/javascript' src='".asset('/vendor/consoletvs/charts/fusioncharts/themes/fusioncharts.theme.fint.js')."'></script>";

$includes['google'] = "<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>";
$includes['google'] .= "<script type='text/javascript' src='https://www.google.com/jsapi'></script>";
$includes['google'] .= "<script type='text/javascript'>google.charts.load('current', {'packages':['corechart', 'gauge', 'geochart', 'bar', 'line']});</script>";

$includes['highcharts'] = "<script src='".asset('/vendor/consoletvs/charts/highcharts/js/highcharts.js')."'></script>";
$includes['highcharts'] .= "<script src='".asset('/vendor/consoletvs/charts/highcharts/js/modules/exporting.js')."'></script>";
$includes['highcharts'] .= "<script src='".asset('/vendor/consoletvs/charts/highmaps/js/modules/map.js')."'></script>";
$includes['highcharts'] .= "<script src='".asset('/vendor/consoletvs/charts/highmaps/js/modules/data.js')."'></script>";
$includes['highcharts'] .= "<script src='".asset('/vendor/consoletvs/charts/highmaps/maps/world.js')."'></script>";

$includes['justgage'] = "<script src='".asset('/vendor/consoletvs/charts/justgage/raphael-2.1.4.min.js')."'></script>";
$includes['justgage'] .= "<script src='".asset('/vendor/consoletvs/charts/justgage/justgage.js')."'></script>";

$includes['morris'] = "<link rel='stylesheet' href='".asset('/vendor/consoletvs/charts/morris/morris.css')."'>";
$includes['morris'] .= "<script type='text/javascript' src='".asset('/vendor/consoletvs/charts/morris/raphael.min.js')."'></script>";
$includes['morris'] .= "<script type='text/javascript' src='".asset('/vendor/consoletvs/charts/morris/morris.min.js')."'></script>";

$includes['plottablejs'] = "<script src='".asset('/vendor/consoletvs/charts/d3/d3.js')."'></script>";
$includes['plottablejs'] .= "<link rel='stylesheet' href='".asset('/vendor/consoletvs/charts/plottable/plottable.css')."'>";
$includes['plottablejs'] .= "<script src='".asset('/vendor/consoletvs/charts/plottable/plottable.js')."'></script>";

$includes['progressbarjs'] = "<script src='".asset('/vendor/consoletvs/charts/progressbar/progressbar.min.js')."'></script>";

$includes['awesomechartjs'] = "<script src='".asset('/vendor/consoletvs/charts/awesomechartjs/awesomechart.js')."'></script>";

return $includes;
