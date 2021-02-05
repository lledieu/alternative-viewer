<?php

// Global search

/*
 * IN :
 *  ch
 *  param c : criteria (with | separator)
 *  s_url_prefix
 *  s_url_suffix
 *  s_filter
 *  s_filter_count (optinal)
 *
 * OUT :
 *  id_notice
 *  size (when r_filter_count)
 */

echo "/* -- search -- */\n";

$c = get_param( 'c' );
$c = preg_replace('/\|/s', '" "', $c);

$url = $s_url_prefix.urlencode( $c ).$s_url_suffix;
echo "/* URL $url */\n";

curl_setopt( $ch, CURLOPT_URL, $url );

$page = curl_exec( $ch );

if( $page === false ) {
	echo "/*\n";
	echo curl_error( $ch )."\n";
	echo "*/\n";
} else if( preg_match( '/Veuillez vous reconnecter dans quelques minutes/', $page ) ) {
	echo "/* Service saturé ! */\n";
} else {
	$id_notice = preg_filter( "/.*${s_filter}.*/s", '$1', $page );

	if( isset( $s_filter_count ) ) {
		$size = preg_filter( "/.*${s_filter_count}.*/s", '$1', $page );
		$size--;
	}

	require( "./inc/inc_${t_mode}.php" );
}

?>
