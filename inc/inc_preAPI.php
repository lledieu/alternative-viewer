<?php

echo "/* --- ".basename(__FILE__)." --- */\n";

if( isset( $reload_filter ) && 1 == preg_match( "/$reload_filter/", $l ) ) {
	echo "/* HEAD $l */\n";
	$h = get_headers( $l, 1, stream_context_create( array( 'http' => array( 'method' => 'HEAD' ) ) ) );
	if( isset( $h["Location"] ) ) {
		$l = end($h["Location"]);
	} else {
		echo "/* Missing Location header */\n";
	}
}

if( 1 == preg_match( "/$filter/", $l, $out ) ) {
	$id_notice = $out[1];
	
	$url = "$home/visualizer/api?arkName=".$out[1]."&uuid=".$out[2];
	echo "/* URL $url */\n";
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
		$out = json_decode( $json, true );

		$size = $out["counts"]["media"] - 1; // It's max index !
		$data["current-index"] = $out["positions"]["media"];

		require( "./inc/inc_API.php" );
	}
} else {
	echo "/* Invalid URL $l */\n";
}

?>
