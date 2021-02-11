<?php

echo "/* --- ".basename(__FILE__)." --- */\n";

$c = get_param( "c" );
if( 1 == preg_match( '|^([^/]*/[^/]*)/v([0-9]*)$|', $c, $out ) ) {
	$c= $out[1];
	$data["current-index"] = $out[2] - 1;
} else  if( 1 == preg_match( '|^([^/]*/[^/]*)$|', $c, $out ) ) {
	$c= $out[1];
} else {
	echo "/* Invalid prama c $c */ \n";
	http_response_code(404);
	die;
}

$iid = urlencode( "h::ark:/$ark/$c" );
$fileIID = urlencode( "ark:/$ark/$c" );
$url = "$home/in/rest/KUModelSVC/TOC?id=$iid";
echo "/* URL1 $url */\n";

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
	foreach( $out["section"] as $s ) {
		$numpage = preg_filter( "/.*-([0-9]*)-.*/", "$1", $s['identifier'] );

		// Specific data
		$source = array();
		$source["imageLink"] = $s['imageLink'];
		$source["identifier"] = $s['identifier'];
		$source["pagination"] = $s['pagination'];
		//$source["download"] = "$home/in/rest/imageExportSVC/pdf?iid=$iid&attachmentID=".$s['imageLink']."&image=".($numpage -1 )."&fileIID=$fileIID"; // POST + cookie !
		$source["permalink"] = "$base_ark$c/v".sprintf( "%04d", $numpage );
		$sources[] = $source;

		// OSD data
		$tileSources[] = "CORS/BMV-getTileSource.php?deepZoomManifest=/in".$s["imageLink"].".dzi";
	}

	$data["tileSources"] = $tileSources;
	$data["sources"] = $sources;

	$data["home"] = $home;
	$data["logo"] = $logo;
	$data["title"] = $title;

	// More data
	$url = "$home/in/rest/api/resolveArk?ark=$fileIID";
	echo "/* URL2 $url */\n";

	curl_setopt( $ch, CURLOPT_URL, $url );
	$json = curl_exec( $ch );
	$out = json_decode( $json, true );

	$data["title"] = $out["collectionData"]["source"];
	$data["desc"] = $out["resolve"][1]["title"];
}

?>
