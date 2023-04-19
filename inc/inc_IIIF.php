<?php

echo "/* --- ".basename(__FILE__)." --- */\n";

$url = "$t_base$id_notice/manifest";
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

	$sources = array();
	$tileSources = array();

	$out = json_decode( $json, true );
	foreach( $out["sequences"][0]["canvases"] as $s ) {
		// specific data
		$source = array();
		if( array_key_exists( "thumbmail", $s ) ) {
			$source["thumb"] = $s["thumbnail"];
		}
		if( array_key_exists( "ligeoPermalink", $s ) ) {
			$source["permalink"] = $s["ligeoPermalink"];
		}
		$sources[] = $source;

		// OSD data
		$tileSources[] = $s["images"][0]["resource"]["service"]["@id"]."/info.json";
	}

	$data["tileSources"] = $tileSources;
	$data["sources"] = $sources;

	$data["home"] = $home;
	$data["logo"] = $logo;
	$data["title"] = $title;

	$data["desc"] = $out["label"];

	if( isset( $filter_title ) ) {
		$extracted_title = preg_filter( "/.*$filter_title.*/s", "$1", $page );
		$data["title"] = $extracted_title;
	}

}

?>
