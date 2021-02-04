<?php
$base = "http://archives.aveyron.fr";
$logo = "$base/favicon.ico";
$title = "Archives départementales de l'Aveyron";
$ark = "11971";

// Recherche simple
$mode1 = "search";
$s_url_prefix = "$base/archive/resultats/simple/n:22?RECH_S=%22";
$s_url_suffix = "%22&RECH_TYP=and&type=simple";
$s_filter = "href=\"\/ark:\/$ark\/([^\"]*\/dao[^\/]*)\/";

// Zomify
$t_mode = "Zoomify";
$t_base = "$base/ark:/$ark/";
$z_base = "https://hatch-nowm.vtech.fr";
?>
