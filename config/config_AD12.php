<?php
$home = "https://archives.aveyron.fr";
$ark = "11971";
$logo = "$home/favicon.ico";
$title = "Archives départementales de l'Aveyron";

// Recherche simple
$step1 = "search";

// Version d'origine => OK
$s_url_prefix = "$home/archive/resultats/simple/n:22?RECH_S=%22";
$s_url_suffix = "%22&RECH_TYP=and&type=simple";
// Version qui marche pour les notaires
$s_url_prefix = "$home/archive/resultats/notaires/n:67?Rch_cote=%22";
$s_url_suffix = "%22&type=notaires";

$s_filter = "href=\"\/ark:\/$ark\/([^\"]*\/dao[^\/]*)\/";

// Zomify
$t_mode = "Zoomify";
$t_base = "$home/ark:/$ark/";
//$z_base = "https://hatch-nowm.vtech.fr";
$z_base = $home;
?>
