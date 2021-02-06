<?php

echo "/* --- BMV --- */\n";

$url = "$base/in/rest/KUModelSVC/TOC?id=".urlencode("h::ark:/29755/".get_param( "c" ));
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
	$out = json_decode( $json, true )["section"];
	foreach( $out as $s ) {
		echo ' "CORS/BMV-getTileSource.php?deepZoomManifest=/in'.$s["imageLink"].".dzi\",\n";
	}
}

?>
