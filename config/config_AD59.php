<?php
$base = "https://archivesdepartementales.lenord.fr";
$logo = "$base/assets/src/Custom/assets/static/front/img/icono-logo/logo-header.6e77bd3ad3f5b75a6c5e58d94199314d.png";
$title = "Archives départementales du Nord";
$ark = "33518";

// Recherche globale
$mode1 = "search";
$s_url_prefix = "$base/search/results?q=%22";
$s_url_suffix = "%22&scope=all";
$s_filter = "\/ark:\/$ark\/([^\/\"]*)\/";
$s_filter_count = ' ([0-9]*) medias';

// API
$t_mode = "API";
?>
