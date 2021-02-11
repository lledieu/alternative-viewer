<?php
$home = "https://archives.calvados.fr";
$logo = "$home/assets/src/Custom/assets/static/front/img/icono-logo/logo.50fcef5475bb4b6b30e0b45da3dc7192.png";
$title = "Archives départementales du calvados";
$ark = "52329";

// Switch
$l = get_param( "l" );
$c = get_param( "c" );
if( $c != "" ) { // A criteria is provided
	$step1 = "search";
	$s_url_prefix = "$home/search/results?q=%22";
	$s_url_suffix = "%22&scope=all";
	$s_filter = "\/ark:\/$ark\/([^\/\"]*)\/";
	$s_filter_count = ' ([0-9]*) medias';
	// Next step
	$t_mode = "API";
} else if( $l != "" ) { // A link is provided
	$step1 = "preAPI";
	// New links : arkName / uuid
	$filter = ".*ark:\/$ark\/([^\/]*)\/([^\/]*)$";
} else { // Not expected
	$step1 = "KO";
}

?>
