<?php

echo "/* --- ".basename(__FILE__)." --- */\n";

$sources = array();
$tileSources = array();

$dgsNum = get_param( "dgsNum" );
if( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
	$url = "https://";
} else {
	$url = "http://";
}
$url .= $_SERVER['HTTP_HOST'];
$url .= substr( $_SERVER['REQUEST_URI'], 0, strrpos( $_SERVER['REQUEST_URI'], "/" ) + 1 );
$url .= "CORS/FS-proxy.php?dgsNum=$dgsNum";
echo "/* URL : $url */\n";

curl_setopt( $ch, CURLOPT_URL, $url );

$json = curl_exec( $ch );

if( $json === false ) {
	echo "/*\n".curl_error( $ch )."\n*/\n";
} else {
	$out = json_decode( $json, true );
	foreach( $out["images"] as $s ) {
		// specific data
		$source = array();
		$source["permalink"] = str_replace( "/image.xml", "", $s );
		$sources[] = $source;

		// OSD data
		$tileSources[] = "CORS/FS-proxy.php?url=".str_replace( $base1, $base2, $s );
	}

	$data["desc"] = $dgsNum;
}

$data["tileSources"] = $tileSources;
$data["sources"] = $sources;

$data["home"] = $home;
$data["logo"] = $logo;
$data["title"] = $title;

$fssessionid = get_param( "fssessionid" );
$data["SESSION_ID"] = $fssessionid;

?>
