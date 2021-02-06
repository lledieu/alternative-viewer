<?php

// Init curl
$ch = curl_init();

curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch, CURLOPT_COOKIESESSION, true);
curl_setopt( $ch, CURLOPT_COOKIEJAR, "");
curl_setopt( $ch, CURLOPT_COOKIEFILE, "");

curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt( $ch, CURLOPT_MAXREDIRS, 1 );

$dZM = $_GET["deepZoomManifest"];
if( preg_match( '/.dzi$/', $dZM ) ) {
	header('Content-Type: application/json;charset=UTF-8');

	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

	$dZM = preg_replace( '/.dzi$/', '.xml', $_GET["deepZoomManifest"] );
	curl_setopt( $ch, CURLOPT_URL, "https://patrimoine-numerique.ville-valenciennes.fr/in/rest/pictureListSVC/getTileSource?deepZoomManifest=$dZM" );

	$json = curl_exec( $ch );

	// Correct data
	$json = preg_replace( '/^"/', '', $json );
	$json = preg_replace( '/"$/', '', $json );
	$json = preg_replace( '/\\\\"/', '"', $json );

	echo $json;
} else {
	header('Content-Type: image/jpeg');

	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
	curl_setopt( $ch, CURLOPT_URL, "https://patrimoine-numerique.ville-valenciennes.fr$dZM" );

	curl_exec( $ch );
}

?>
