<?php
$home = "https://archives.somme.fr";
$logo = "$home/assets/src/Custom/assets/static/front/favicons/apple-touch-icon.ac035e7c475f9df317e6036d6800dafe.png";
$title = "Archives départementales de la Somme";
$ark = "58483";

// Switch
$l = get_param( "l" );
$c = get_param( "c" );
if( $c != "" ) { // A criteria is provided
	$step1 = "search";
	$s_url_prefix = "$home/search/results?q=%22";
	$s_url_suffix = "%22&scope=all";
	$s_filter = "\/ark:\/$ark\/([^\/\"]*)\/";
	$s_filter_count = ' ([0-9]*) medias?';
	// Next step
	$t_mode = "API";
} else if( $l != "" ) { // A link is provided
	$step1 = "preAPI";
	// Old links
	$reload_filter = ".*ark:\/$ark\/[^\/]*\/[^\/]*\/[^\/]*$";
	// New links : arkName / uuid
	$filter = ".*ark:\/$ark\/([^\/]*)\/([^\/]*)$";
} else { // Not expected
	$step1 = "KO";
}

?>
