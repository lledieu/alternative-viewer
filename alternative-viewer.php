<?php
include ( './inc/inc_optional.php' );

function get_param( $name ) {
	if( isset( $_GET[ $name ] ) ) {
		return $_GET[ $name ];
	} else if( isset( $_POST[ $name ] ) ) {
		return $_POST[ $name ];
	}
}

$target = get_param( "d" );
if( preg_match( '/^[0-9_A-Za-z-]*$/', $target ) ) {
	require( "./config/config_$target.php" );
}

?><!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
 <title>Alternative Viewer</title>
 <link rel="stylesheet"
       href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
       integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
       crossorigin="anonymous" />
 <link rel="stylesheet" href="alternative-viewer.css">
</head>
<body>

<div id="alternative-viewer-container">
 <div id="loader" class="hidden"></div>
 <div id="logo">
  <a href="<?php echo $base; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $title; ?>"></a>
 </div>

 <div id="l-bar" class="nav-bar nav-shadow">
  <div id="l-bar-nav-one-back" title="-1"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
  <div id="l-bar-nav-ten-back" title="-10"><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
  <div id="l-bar-nav-first" title="Début du registre"><i class="fa fa-fast-backward" aria-hidden="true"></i></div>
 </div>

 <div id="navigation" class="nav-shadow">
  <ul>
   <li id="nav-first" class="fa fa-fast-backward" title="Début du registre"></li>
   <li id="nav-ten-back" class="fa" title="-10"><span><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i></span></li>
   <li id="nav-one-back" class="fa fa-chevron-left" title="-1"></li>
   <li class="current">
    <input type="text" id="inputvue" autocomplete="off">
    <span>/</span>
    <span id="total"></span>
   </li>
   <li id="nav-one" class="fa fa-chevron-right" title="+1"></li>
   <li id="nav-ten" class="fa" title="+10"><span><i class="fa fa-chevron-right" aria-hidden="true"></i><i class="fa fa-chevron-right" aria-hidden="true"></i></span></li>
   <li id="nav-last" class="fa fa-fast-forward" title="Fin du registre"></li>
   <li id="nav-fit-v" class="fa fa-arrows-alt-v" title="Ajuster à la hauteur"></li>
   <li id="nav-fit-h" class="fa fa-arrows-alt-h" title="Ajuster à la largeur"></li>
   <li id="nav-zone" class="far fa-square" title="Zoom sur une zone"></li>
   <li id="nav-rotate-left" class="fa fa-undo" title="Pivoter vers la gauche"></li>
   <li id="nav-rotate-right" class="fa fa-redo" title="Pivoter vers la droite"></li>
   <li id="nav-lock" class="fa fa-lock" title="Verrouiller / Déverrouiller les réglages"></li>
   <a id="nav-download" href="vide:" target="_blank"><li class="fa fa-download" title="Télécharger"></li></a>
   <li id="nav-screen" class="fa fa-expand" title="Activer / Désactiver le mode plein écran"></li>
  </ul>
 </div>

 <div id="r-bar" class="nav-bar nav-shadow">
  <div id="r-bar-nav-one" title="+1"><i class="fa fa-chevron-right" aria-hidden="true"></i></div>
  <div id="r-bar-nav-ten" title="+10"><i class="fa fa-chevron-right" aria-hidden="true"></i><i class="fa fa-chevron-right" aria-hidden="true"></i></div>
  <div id="r-bar-nav-last" title="Fin du registre"><i class="fa fa-fast-forward" aria-hidden="true"></i></div>
 </div>

 <div id="nav-list-remove"><span title="Masquer la liste"><i class="fa fa-caret-square-left"></i></span></div>
 <div id="nav-list-add" class="inactive"><span title="Afficher la liste"><i class="far fa-caret-square-right"></i></span></div>

 <div id="alternative-viewer"></div>
</div>

</body>
<script type="text/javascript">
const param_tileSources = [
<?php

	// Init curl
	$ch = curl_init();

	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch, CURLOPT_COOKIESESSION, true);
	curl_setopt( $ch, CURLOPT_COOKIEJAR, "");
	curl_setopt( $ch, CURLOPT_COOKIEFILE, "");

	curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
	curl_setopt( $ch, CURLOPT_MAXREDIRS, 1 );

	require( "./inc/inc_${mode1}.php" );

?>
];
<?php

// Initial Page
$vue = get_param( "vue" );
if( !is_numeric( $vue ) ) {
	$vue = 1;
}
if( $vue > sizeof( $out ) ) {
	$vue = sizeof( $out );
}
echo "const param_initialPage = ".($vue - 1).";\n";

// Initial zoom
$zoom = get_param( "zoom" );
if( $zoom != "" ) {
	$rz = preg_split( '/,/', $zoom );
	if( sizeof( $rz ) == 4 &&
	    is_numeric($rz[0]) && $rz[0] >= 0 && $rz[0] <= 100 &&
	    is_numeric($rz[1]) && $rz[1] >= 0 && $rz[1] <= 100 &&
	    is_numeric($rz[2]) && $rz[2] >= 0 && $rz[2] <= 100 &&
	    is_numeric($rz[3]) && $rz[3] >= 0 && $rz[3] <= 100 ) {
		echo "const param_initialZoom = { x: ".($rz[0]/100).", y: ".($rz[1]/100).", w: ".($rz[2]/100).", h: ".($rz[3]/100)." };\n";
	} else {
		echo "const param_initialZoom = null;\n";
	}
} else {
	echo "const param_initialZoom = null;\n";
}
?>
</script>
<script src="https://cdn.jsdelivr.net/npm/openseadragon@2.4/build/openseadragon/openseadragon.min.js"></script>
<!-- jquery needed to extend OSD -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="openseadragon-zoomify.js"></script>
<script src="openseadragon-topview.js"></script>
<!-- -->
<script src="alternative-viewer.js"></script>
</html>
