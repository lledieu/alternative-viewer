<?php

echo "/* --- ".basename(__FILE__)." --- */\n";

$sources = array();
$tileSources = array();

$dgsNum = get_param( "dgsNum" );
$fssessionid = get_param( "fssessionid" );
$url = "http://home.lledieu.org/OSD/CORS/FS-proxy.php?dgsNum=$dgsNum";
echo "/* URL : $url */\n";

curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
	"SESSION_ID: $fssessionid",
) );
curl_setopt( $ch, CURLOPT_URL, $url );

$json = curl_exec( $ch );

if( $json === false ) {
	echo "/*\n".curl_error( $ch )."\n*/\n";
} else {
	$out = json_decode( $json, true );
	foreach( $out["images"] as $s ) {
		// specific data
		$source = array();
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

$data["SESSION_ID"] = $fssessionid;

?>
