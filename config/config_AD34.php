<?php
$base = "https://archives-pierresvives.herault.fr";
$logo = "$base/img/logo_pdf.png";
$title = "Archives départementales de l'Hérault";
$ark = "37279";

// Recherche simple
$mode1 = "search";
$s_url_prefix = "$base/archive/recherche/simple/n:33?RECH_S=%22";
$s_url_suffix = "%22&arcfacfull=RECH_S&RECH_TYPE=and&arcfacmode=RECH_TYPE&type=simple&RECH_Dao=1";
$s_filter = "<a href=\"\/ark:\/$ark\/([^\"]*)\" title=\"lien vers la notice\"";

// IIIF
$t_mode = "IIIF";
$t_base = "$base/ark:/$ark/";
?>
