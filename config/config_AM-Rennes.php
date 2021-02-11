<?php
$home = "https://www.archives.rennes.fr";
$ark = "74559";

// Recherche simple
$step1 = "search";
$s_url_prefix = "$home/archive/resultats/simple//n:19?RECH_S=%22";
$s_url_suffix = "%22&type=simple";
$s_filter = "href=\"\/ark:\/$ark\/([^\"]*\/dao)";

// Zomify
$t_mode = "Zoomify";
$t_base = "$home/ark:/$ark/";
$z_base = $home;

$filter_logo = '"info":{"logo":"([^"]*)"';
$filter_title = '<meta name="publisher" content="([^"]*)"';

?>
