<?php
$base = "https://archives.lozere.fr";
$logo = "$base/favicon.ico";
$title = "Archives départementales de Lozère";
$ark = "24967";

// Recherche simple
$mode1 = "search";

$t = get_param( "t" );
$opt="";
if( "EC" == $t ) {
	$t="ec2";
} else if( "CON" == $t ) {
	$t="controle";
	$opt="/direction:asc/sort:unitid";
} else if( "ENR" == $t ) {
	$t="enregistrement";
	// opt ?
} else if( "RM" == $t ) {
	$t="matricule";
	// opt ?
} else {
	$t="ec2";
}

$s_url_prefix = "$base/archive/resultats/general/$t/formselector:1/n:329$opt?RECH_S=%22";
$s_url_suffix = "%22&type=general";
$s_filter = "href=\"\/ark:\/$ark\/([^\"]*\/dao[^\/]*)\/";

// Zomify
$t_mode = "Zoomify";
$t_base = "$base/ark:/$ark/";
$z_base = $base;
?>
