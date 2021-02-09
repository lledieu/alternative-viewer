<?php
$home = "http://archives.aveyron.fr";
$ark = "11971";
$logo = "$home/favicon.ico";
$title = "Archives départementales de l'Aveyron";

// Recherche simple
$step1 = "search";
$s_url_prefix = "$home/archive/resultats/simple/n:22?RECH_S=%22";
$s_url_suffix = "%22&RECH_TYP=and&type=simple";
$s_filter = "href=\"\/ark:\/$ark\/([^\"]*\/dao[^\/]*)\/";

// Zomify
$t_mode = "Zoomify";
$t_base = "$home/ark:/$ark/";
$z_base = "https://hatch-nowm.vtech.fr";
?>
