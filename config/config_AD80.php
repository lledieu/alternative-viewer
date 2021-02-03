<?php
$base = "https://archives.somme.fr";
$logo = "$base/assets/src/Custom/assets/static/front/favicons/apple-touch-icon.ac035e7c475f9df317e6036d6800dafe.png";
$title = "Archives départementales de la Somme";
$ark = "58483";

// Recherche globale
$mode1 = "search";
$s_url_prefix = "$base/search/results?q=%22";
$s_url_suffix = "%22&scope=all";
$s_filter = "\/ark:\/$ark\/([^\/\"]*)\/";
$s_filter_count = ' ([0-9]*) medias';

// API
$t_mode = "API";
?>
