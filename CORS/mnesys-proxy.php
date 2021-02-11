<?php

$url = $_GET["url"];

if( 1 == preg_match( '|^https://archives.[a-z]*.fr/medias/.*/p.xml$|', $url ) ) {

	$ch = curl_init( $url );

	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true );
	curl_setopt( $ch, CURLOPT_COOKIELIST, "ALL");
	curl_setopt( $ch, CURLOPT_HEADER, false);
	curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, false );

	header('Content-Type: application/xml');
	curl_exec( $ch );
}

?>
