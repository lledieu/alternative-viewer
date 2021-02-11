<?php

echo "/* --- ".basename(__FILE__)." --- */\n";

/* IN :
 *  ch
 *  home
 *  id_notice
 *  size
 */

$url = "$home/visualizer/api?arkName=".$id_notice."&end=${size}&group=0&start=0";
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
	foreach( $out as $s ) {
		// Specific data
		$source = array();
		$source["thumb"] = $s['location']['thumb'];
		$source["download"] = $s['location']['original'];
		$source["permalink"] = $s["url"];
		$sources[] = $source;

		// OSD data
		$tileSource = array();
		$tileSource["type"] = "image";
		$tileSource["url"] = $s['location']['original'];
		$tileSource["referenceStripThumbnailUrl"] = $s['location']['thumb'];
		$tileSource["buildPyramid"] = false;
		$tileSources[] = $tileSource;
	}

	$data["tileSources"] = $tileSources;
	$data["sources"] = $sources;

	$data["home"] = $home;
	$data["logo"] = $logo;
	$data["title"] = $title;

	if( isset( $out[0]["record"]["referenceCode"][0] ) && isset( $out[0]["record"]["title"][0] )) {
		$data["desc"] = $out[0]["record"]["referenceCode"][0]." - ".$out[0]["record"]["title"][0];
	} else if( isset( $out[0]["record"]["title"][0] ) ) {
		$data["desc"] = $out[0]["record"]["title"][0];
	} else if( isset( $out[0]["record"]["referenceCode"][0] ) ) {
		$data["desc"] = $out[0]["record"]["referenceCode"][0];
	}
}

?>
