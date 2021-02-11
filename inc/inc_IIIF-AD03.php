<?php

echo "/* --- ".basename(__FILE__)." --- */\n";

$l = get_param( "l" );
if( 1 == preg_match( "|^.*recherche.*ark:/$ark/.*|", $l ) ) {
	echo "/* HEAD $l */\n";
	$h = get_headers( $l, 1, stream_context_create( array( 'http' => array( 'method' => 'HEAD' ) ) ) );
	//echo "/*\n";
	//var_dump( $h );
	//echo "\n*/\n";
	if( isset( $h["Location"] ) ) {
		$l = end($h["Location"]);
		echo "/* Location: $l */\n";
	} else {
		echo "/* Missing Location header */\n";
		exit;
	}
}

if( 1 == preg_match( "|^.*/([0-9]*)$|", $l, $out ) ) {
	$data["current-index"] = $out[1];
}

if( 1 == preg_match( "|^.*(/_recherche-api/.*)$|", $l, $out ) ) {
	$url = $home.$out[1];
	echo "/* URL: $url */\n";
} else {
	echo "/* API url undefined */\n";
	exit;
}

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

	$sources = array();
	$tileSources = array();

	$out = json_decode( $json, true );
	foreach( $out["medias"][0]["sources"] as $s ) {
		// specific data
		$source = array();
		$source["permalink"] = $home.$s["ARKLink"];
		$sources[] = $source;

		// OSD data
		$tileSources[] = "CORS/AD03-proxy.php?csurl=".$s["src"]."/info.json";
	}

	$data["tileSources"] = $tileSources;
	$data["sources"] = $sources;

	$data["home"] = $home;
	$data["logo"] = $logo;
	$data["title"] = $title;

	$data["desc"] = $out["medias"][0]["sources"][0]["title"];
}

?>
