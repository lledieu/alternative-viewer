<?php

$i = $_GET["i"];
$s = preg_filter( '/^\/mnt\/lustre\/([^\/]*)\/.*/', '$1', $i );
require( "./config/simu_$s.php" );
$url = $_GET["pl"];

$ch = curl_init( $url );

curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true );
curl_setopt( $ch, CURLOPT_COOKIESESSION, true);
curl_setopt( $ch, CURLOPT_COOKIEJAR, "");
curl_setopt( $ch, CURLOPT_COOKIEFILE, "");

curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt( $ch, CURLOPT_MAXREDIRS, 1 );

$page = curl_exec( $ch );

if( $page === false ) {
	echo curl_error( $ch );
} else {
	$url = "$base/v2/ark/permalien.html?chemin=".urlencode($i) ;

	curl_setopt( $ch, CURLOPT_HEADER, false);
	curl_setopt( $ch, CURLOPT_URL, $url );

	$page = curl_exec( $ch );

	if( $page === false ) {
		echo curl_error( $ch );
	} else {

		header('Content-Type: text/plain');
		$lien = preg_filter( '/.*href="([^"]*\/ark:\/[^"]*)".*/s', "$1", $page );
		if( null === $lien ) {
			echo "fail:";
		} else {
			echo $lien;
		}
	}
}

?>
