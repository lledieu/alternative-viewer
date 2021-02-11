<?php

$url = $_GET["csurl"];

if( 1 == preg_match( '|^https://archives.allier.fr/_recherche-images/show/[0-9]*/image/[0-9]*/[0-9]*/info.json$|', $url ) ) {

	$ch = curl_init( $url );

	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true );
	curl_setopt( $ch, CURLOPT_COOKIELIST, "ALL");
	curl_setopt( $ch, CURLOPT_HEADER, false);
	curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, false );

	$json = curl_exec( $ch );

	$out = json_decode( $json, true );
	$out["@id"] = str_replace( "/info.json", "", $url );

	header('Content-Type: application/json');
	echo json_encode( $out );
}

?>
