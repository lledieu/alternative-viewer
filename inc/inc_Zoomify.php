<?php

echo "/* --- ".basename(__FILE__)." --- */\n";

$url = "$t_base$id_notice/0";
echo "/* URL STEP 1 : $url */\n";
curl_setopt( $ch, CURLOPT_URL, $url );

$page = curl_exec( $ch );

if( $page === false ) {
	echo "/* STEP 1 : $url \n".curl_error( $ch )."\n*/\n";
} else {
	if( isset( $filter_logo ) ) {
		$extracted_logo = preg_filter( "/.*$filter_logo.*/s", "$1", $page );
		$extracted_logo = preg_replace( '/\\\\/', '', $extracted_logo );
		if( substr( $extracted_logo, 0, 1 ) == "/" ) {
			$extracted_logo = $home.$extracted_logo;
		}
		$data["logo"] = $extracted_logo;
	} else if( isset( $logo ) ) {
		$data["logo"] = $logo;
	}

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
		$sources = array();
		$tileSources = array();

		$out = json_decode( $json, true );
		foreach( $out["items"] as $s ) {
			// specific data
			$source = array();
			$source["thumb"] = $s["thumb"];
			$source["source"] = $s["source"];
			$source["download"] = $home.$s["printable"];
			$source["permalink"] = $s["permalink"];
			$sources[] = $source;

			// OSD data
			$tileSources[] = "$z_base/cgi-bin/iipsrv.fcgi?zoomify=".$s["source"]."/ImageProperties.xml";
		}

		$data["tileSources"] = $tileSources;
		$data["sources"] = $sources;

		$data["home"] = $home;
		$data["desc"] = $out["batch"]["title"];

		if( isset( $filter_title ) ) {
			$extracted_title = preg_filter( "/.*$filter_title.*/s", "$1", $page );
			$data["title"] = $extracted_title;
		}
	}
}

?>
