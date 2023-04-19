<?php

echo "/* --- ".basename(__FILE__)." --- */\n";

$sources = array();
$tileSources = array();

$id = get_param('id');
curl_setopt( $ch, CURLOPT_URL, "https://www.leonore.archives-nationales.culture.gouv.fr/api/v1/notice?id=$id" );
$json_response = curl_exec( $ch );
$response = json_decode( $json_response, true );

if( $json_response === false ) {
	echo "/*\n";
	echo curl_error( $ch )."\n";
	echo "*/\n";
} else {
	//var_dump( $response );
	if( $response != null ) {
		foreach( $response["data"]["images"] as $i ) {
			$url = "$home$i";

			// Specific data
			$source = array();
			$source["download"] = $url;
			$sources[] = $source;

			// OSD data
			$tileSource = array();
			$tileSource["type"] = "image";
			$tileSource["url"] = $url;
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
$data["desc"] = $response["data"]["coteDossier"];

?>
