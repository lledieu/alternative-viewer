<?php

$url = $s_url_prefix.get_param('c').$s_url_suffix;
curl_setopt( $ch, CURLOPT_URL, $url );

$page = curl_exec( $ch );

if( $jpage === false ) {
	echo "/*\n";
	echo curl_error( $ch )."\n";
	echo "*/\n";
} else {
	$res = preg_match_all( "/$s_filter/s", $page, $out, PREG_SET_ORDER );
	if( $res != null ) {
		foreach( $out as $s ) {
			echo " { type: 'image', url: '$t_url_prefix".str_replace('/PG/', '/', $s[1])."$t_url_suffix', buildPyramid: false },\n";
		}
	}
}

?>
