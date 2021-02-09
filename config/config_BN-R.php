<?php
$home = "https://www.bn-r.fr";
$logo = "$home/themes/default/img/common/logo-large.png";
$title = "Bibliothèque numérique de Roubaix";
$ark = "20179";

$step1 = "BN-R";

// Input
$filter1 = "^[IMGBNR]*([0-9]*)$"; // id seul
$filter2 = ".*/ark:/$ark/BNR([0-9]*)$"; // id seul
$filter3 = ".*/ark:/$ark/IMGBNR([0-9]*)&nb=([0-9]*)$"; // id + page

$base = "$home/zoom.php?q=id:";
$n_filter = '{src:"/dam_picture.php\?id=[^&]*&type=LAG&nb=([0-9]*)&path=[^&]*&repertoire=[^"]*"}';
$n_filter_desc = '<meta name="title" content="([^"]*)"';
?>
