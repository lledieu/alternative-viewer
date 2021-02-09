<?php

echo "/* --- ".basename(__FILE__)." --- */\n";

$q = get_param( "q" );
$res = preg_match( "/$filter1/", $q, $out );
if( $res === false || $res == 0) {
	$res = preg_match( "'$filter2'", $q, $out );
	if( $res === false || $res == 0) {
		$res = preg_match( "'$filter3'", $q, $out );
		if( $res === false || $res == 0) {
			echo "/* Nothing ! */\n";
			http_response_code( 404 );
			die;
		} else {
			$id = $out[1];
			$data["current-index"] = $out[2] - 1;
		}
	} else {
		$id = $out[1];
	}
} else {
	$id = $out[1];
}

$url = "$base$id";
echo "/* URL $url */\n";
curl_setopt( $ch, CURLOPT_URL, $url );

$page = curl_exec( $ch );

if( $page === false ) {
	echo "/*\n";
	echo curl_error( $ch )."\n";
	echo "*/\n";
} else {
	$sources = array();
	$tileSources = array();

	$res = preg_match_all( "|$n_filter|s", $page, $out, PREG_SET_ORDER );
	if( $res !== false ) {
		foreach( $out as $s ) {
			// Specific data
			$source = array();
			$source["permalink"] = "$home/ark:/$ark/IMGBNR$id&nb=".$s[1];
			$sources[] = $source;

			// OSD data
			$tileSource = array();
			$tileSource["type"] = "image";
			$tileSource["url"] = "$home/dam_picture.php?id=$id&type=LAG&nb=".$s[1];
			$tileSource["referenceStripThumbnailUrl"] = "$home/dam_picture.php?id=$id&type=MED&nb=".$s[1];
			$tileSource["buildPyramid"] = false;
			$tileSources[] = $tileSource;
		}
	}

	$data["tileSources"] = $tileSources;
	$data["sources"] = $sources;

	$data["home"] = $home;
	$data["logo"] = $logo;
	$data["title"] = $title;

	$data["desc"] = preg_filter( "/.*$n_filter_desc.*/s", "$1", $page );
}

?>
