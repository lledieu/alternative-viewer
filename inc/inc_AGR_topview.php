<?php

echo "/* --- ".basename(__FILE__)." --- */\n";

// Init session
require( "./config/login_AGR.php" );

curl_setopt( $ch, CURLOPT_URL, "$home" );
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

$t_url_pl = str_replace( "{eadid}", $eadid, $t_url_pl );
$t_url_pl = str_replace( "{inventarisnr}", $inventarisnr, $t_url_pl );

$n = 1;
$n2 = 1;
$max = 0;

$sources = array();
$tileSources = array();

do {

	curl_setopt( $ch, CURLOPT_URL, "$url$n" );
	echo "/* URL $url$n */\n";
	$page = curl_exec( $ch );

	if( $page === false ) {
		echo "/* $url$n\n";
		echo curl_error( $ch )."\n";
		echo "*/\n";
	} else {
		if( 1 == $n ) {
			$max = preg_filter( '/.*\/([0-9]*)\">[^<]*Dernier.*/s', '$1', $page );
			echo "/* max $max */\n";
		}

		$res = preg_match_all( '/FIF=([^&]*jp2)&/s', $page, $out, PREG_SET_ORDER );
		if( $res !== null ) {
			foreach( $out as $r ) {
				// Specific data
				$source = array();
				$source["FIF"] = $r[1];
				$source["permalink"] = "$t_url_pl$n2";
				$source["download"] = "https://ophir.alwaysdata.net/dezoomify/dezoomify.html#https://search.arch.be/imageserver/topview.json.php?FIF=".$r[1];
				$sources[] = $source;

				// OSD data
				$tileSources[] = "$json_url$r[1]";

				$n2++;
			}
		}
	}

	$n++;

} while( $n <= $max );

$data["tileSources"] = $tileSources;
$data["sources"] = $sources;

$data["home"] = $home;
$data["logo"] = $logo;
$data["title"] = $title;

// More data
$url = str_replace( "{eadid}", $eadid, $t_url2 );
$url = str_replace( "{inventarisnr}", $inventarisnr, $url );

curl_setopt( $ch, CURLOPT_URL, "$url" );
echo "/* URL2 $url */\n";
$page = curl_exec( $ch );

if( $page === false ) {
	echo "/* $url$n\n";
	echo curl_error( $ch )."\n";
	echo "*/\n";
} else {
	$extracted_desc = preg_filter( "/.*<strong>Instruction pour la commande[^<]*<\/strong><br \/>([^>]*)<\/p>.*/s", "$1", $page );
	$extracted_desc = str_replace( "\n", "", $extracted_desc );
	$extracted_desc = preg_replace( "/ +/", " ", $extracted_desc );
	$data["desc"] = $extracted_desc;
}


?>
