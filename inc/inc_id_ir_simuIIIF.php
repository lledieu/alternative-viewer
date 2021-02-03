<?php

// id and ir from parameters
// IIIF simulated

$id = get_param( 'id' );
$ir = get_param( 'ir' );

$url = "$t_base?id=${id}";
if( $ir != "" ) {
	$url .= "&ir=".$ir;
}
curl_setopt( $ch, CURLOPT_URL, $url );
$page = curl_exec( $ch );

if( $page === false ) {
	echo "/*\n";
	echo curl_error( $ch )."\n";
	echo "*/\n";
} else {

	$res = preg_match_all( '/<img src="[^"]*" width="1px" height="1px" id="([^"]*)" class="lazy" data-type="IMG" data-original="([^"]*)"\/>/s', $page, $out, PREG_SET_ORDER );
	if( $res !== null ) {
		foreach( $out as $r ) {
			echo " \"simuIIIF/info_json.php?i=$r[2]\",\n";
		}
	}
}

?>
