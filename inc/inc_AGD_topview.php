<?php

// Init session
require( "./config/login_AGR.php" );

curl_setopt( $ch, CURLOPT_URL, "$base" );
$page = curl_exec( $ch );

$params = "username=$login&password=$passwd&Submit=";
$res = preg_match_all( '/type="hidden" name="([^"]*)" value="([^"]*)"/', $page, $out, PREG_SET_ORDER );
if( $res !== null ) {
	foreach( $out as $r ) {
		$params = "$params&$r[1]=$r[2]";
	}
}

curl_setopt( $ch, CURLOPT_POST, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $params );
curl_exec( $ch );

curl_setopt( $ch, CURLOPT_HTTPGET, true );

// Next steps

$eadid = get_param( 'eadid' );
$inventarisnr = get_param( 'inventarisnr' );

$url = str_replace( "{eadid}", $eadid, $t_url );
$url = str_replace( "{inventarisnr}", $inventarisnr, $url );

$n = 1;
$max = 0;
$out = array();

do {

	curl_setopt( $ch, CURLOPT_URL, "$url$n" );
	$page = curl_exec( $ch );

	if( $page === false ) {
		echo "/* $url$n\n";
		echo curl_error( $ch )."\n";
		echo "*/\n";
	} else {
		if( 1 == $n ) {
			$max = preg_filter( '/.*\/([0-9]*)\">[^<]*Dernier.*/s', '$1', $page );
		}

		$res = preg_match_all( '/FIF=([^&]*jp2)&/s', $page, $tmp_out, PREG_SET_ORDER );
		if( $res !== null ) {
			$out = array_merge( $out, $tmp_out );
		}
	}

	$n++;

} while( $n <= $max );

foreach( $out as $r ) {
	echo " \"$json_url$r[1]\",\n";
}

?>
