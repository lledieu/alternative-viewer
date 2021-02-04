<?php

echo "/* -- Zoomify -- */\n";

$url = "$t_base$id_notice/0";
echo "/* URL STEP 1 : $url */\n";
curl_setopt( $ch, CURLOPT_URL, $url );

$page = curl_exec( $ch );

if( $page === false ) {
	echo "/* STEP 1 : $url \n".curl_error( $ch )."\n*/\n";
} else {
	$url = preg_filter( '/.*Binocle\({"source":"([^"]*.json).*/s', '$1', $page );
	$url = preg_replace( '/\\\\/', '', $url );
	echo "/* URL STEP 2 : $url */\n";

	curl_setopt( $ch, CURLOPT_URL, $url );

	$json = curl_exec( $ch );

	if( $json === false ) {
		echo "/* STEP 2 : $url\n".curl_error( $ch )."\n*/\n";
	} else if( preg_match( '/Invalid/', $json ) ) {
		echo "/* STEP 2bis\n$url\n$json\n*/\n";
	} else {
		$out = json_decode( $json, true )["items"];
		foreach( $out as $s ) {
			echo " \"$z_base/cgi-bin/iipsrv.fcgi?zoomify=".$s["source"]."/ImageProperties.xml\",\n";
		}
		/* N.B.: Some usefull data inside => batch thumb downloadable permalink */
	}

}

?>
