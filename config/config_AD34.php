<?php
$home = "https://archives-pierresvives.herault.fr";
$logo = "$home/img/logo_pdf.png";
$title = "Archives départementales de l'Hérault";
$ark = "37279";

// Recherche simple
$step1 = "search";
$s_url_prefix = "$home/archive/recherche/simple/n:33?RECH_S=%22";
$s_url_suffix = "%22&arcfacfull=RECH_S&RECH_TYPE=and&arcfacmode=RECH_TYPE&type=simple&RECH_Dao=1";
$s_filter = "href=\"\/ark:\/$ark\/([^\"]*)\" title=\"Lien vers la notice - nouvel onglet\"";

// IIIF
$t_mode = "IIIF";
$t_base = "$home/ark:/$ark/";
?>
