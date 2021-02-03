<?php

// API -> image + thumb

/* IN :
 *  ch
 *  base
 *  id_notice
 *  size
 */

$url = "$base/visualizer/api?arkName=".$id_notice."&end=${size}&group=0&start=0";
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
	foreach( $out as $s ) {
		echo " { type: 'image', url: '".$s['location']['original']."', referenceStripThumbnailUrl: '".$s['location']['thumb']."', buildPyramid: false },\n";
	}
}

?>
