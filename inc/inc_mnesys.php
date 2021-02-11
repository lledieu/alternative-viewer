<?php

echo "/* --- ".basename(__FILE__)." --- */\n";

$sources = array();
$tileSources = array();

$l = get_param( "l" );
if( 1 == preg_match( "|.*ark:/$ark/(.*)$|", $l, $out ) ) {
	$url = "$home/viewer/watch/".$out[1];

	echo "/* URL : $url */\n";
	curl_setopt( $ch, CURLOPT_URL, $url );

	$page = curl_exec( $ch );

	if( $page === false ) {
		echo "/*\n".curl_error( $ch )."\n*/\n";
	} else {
		$r_uuid = preg_filter( '/.*<input type="hidden" id="var_record_uuid" value="([^"]*)".*/s', "$1", $page );

		$res = preg_match_all( '/ data-src="([^"]*)0_0.jpg" data-recuuid="([^"]*)"/s', $page, $out, PREG_SET_ORDER  );
		if( $res != null ) {
			foreach( $out as $s ) {
				// specific data
				$source = array();
				$source["data-src"] = str_replace( "_jpg_/", ".jpg", $s[1] );
				$source["uuid"] = $s[2];
				$sources[] = $source;

				// OSD data
				$tileSources[] = "CORS/mnesys-proxy.php?url=$home".$s[1]."p.xml";
			}
		}

		$data["download"] = "$home/{data-src}";
		$data["permalink"] = "$home/ark:/$ark/$r_uuid/{uuid}";

		$data["desc"] = preg_filter( '/.*data-title="([^"]*)".*/s', "$1", $page );

		$data["current-index"] = preg_filter( '/.*<span class="current_media_index">([0-9]*)<\/span>.*/s', "$1", $page ) - 1;
	}
}

$data["tileSources"] = $tileSources;
$data["sources"] = $sources;

$data["home"] = $home;
$data["title"] = $title;
$data["logo"] = $logo;

?>
