<?php

echo "/* --- ".basename(__FILE__)." --- */\n";

$sources = array();
$tileSources = array();

$c = get_param('c');
$url = "$s_url_prefix$c$s_url_suffix";
echo "/* URL $url */\n";
curl_setopt( $ch, CURLOPT_URL, $url );

$page = curl_exec( $ch );

if( $page === false ) {
	echo "/*\n";
	echo curl_error( $ch )."\n";
	echo "*/\n";
} else {
	$res = preg_match_all( "/$s_filter/s", $page, $out, PREG_SET_ORDER );
	if( $res != null ) {
		foreach( $out as $s ) {
			$url = $t_url_prefix.str_replace('/PG/', '/', $s[1])."_L.jpg";
			$thumb = $t_url_prefix.str_replace('/PG/', '/VGN/', $s[1])."-v.jpg";

			// Specific data
			$source = array();
			$source["thumb"] = $thumb;
			$source["download"] = $url;
			$source["permalink"] = $t_url_prefix.$s[1].".htm";
			$sources[] = $source;

			// OSD data
			$tileSource = array();
			$tileSource["type"] = "image";
			$tileSource["url"] = $url;
			$tileSource["referenceStripThumbnailUrl"] = $thumb;
			$tileSource["buildPyramid"] = false;
			$tileSources[] = $tileSource;
		}
	}
}

$data["tileSources"] = $tileSources;
$data["sources"] = $sources;

$data["home"] = $home;
$data["logo"] = $logo;
$data["title"] = $title;
$data["desc"] = $c;

?>
