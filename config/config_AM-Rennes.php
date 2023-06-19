<?php
$home = "https://www.archives.rennes.fr";
$logo = "$home/img/logo_accueil.png?1651762832";
$title = "Archives de Rennes";
$ark = "74559";

// Recherche simple
$step1 = "search";
$s_url_prefix = "$home/archive/resultats/simple//n:19?RECH_S=%22";
$s_url_suffix = "%22&type=simple";
$s_filter = "href=\"\/ark:\/$ark\/([^\"]*)\/dao";

// IIIF
$t_mode = "IIIF";
$t_base = "$home/ark:/$ark/";

?>
