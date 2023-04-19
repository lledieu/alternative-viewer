<?php
$home = "https://archives.aisne.fr";
$logo = "$home/img/logo_cg00.png";
$title = "Archives départementales de l'Aisne";
$ark = "63271";

// Recherche simple
$step1 = "search";
$s_url_prefix = "$home/archive/resultats/transversale/images/formselector:1/n:222?RECH_S=%22";
$s_url_suffix = "%22&RECH_SELECTOR%5B0%5D=images&type=transversale";
$s_filter = "href=\"\/ark:\/$ark\/([^\"]*)\/daogrp";

// Zomify
$t_mode = "IIIF";
$t_base = "$home/ark:/$ark/";

?>
