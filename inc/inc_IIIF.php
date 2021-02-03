<?php

// IIIF API Presentation

$url = "$t_base$id_notice/manifest";
curl_setopt( $ch, CURLOPT_URL, $url );
$json = curl_exec( $ch );

if( $json === false ) {
	echo "/*\n";
	echo curl_error( $ch )."\n";
	echo "*/\n";
} else if( preg_match( '/Invalid/', $json ) ) {
	echo "/*\n";
	echo "$url\n$json\n";
	echo "*/\n";
} else {
	$out = json_decode( $json, true )["sequences"][0]["canvases"];
	foreach( $out as $s ) {
		echo ' "'.$s["images"][0]["resource"]["service"]["@id"].'/info.json",'."\n";
	}
}

?>
