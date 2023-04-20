<?php

header( "Access-Control-Allow-Origin: http://home.lledieu.org:5007, https://lledieu.org" );
header( "Access-Control-Allow-Headers: X-Session-Id, content-type, X-Api-Url" );

switch( $_SERVER["REQUEST_METHOD"] ) {
	case "GET":
		$params = $_GET;
		break;
	case "POST":
		$params = $_POST;
		break;
	default:
		// OPTION used for CORS
		exit;
}

$headers = apache_request_headers();
if( isset( $params["fssessionid"] ) ) {
	$fssessionid = $params["fssessionid"];
} else if( isset( $headers["X-Session-Id"] ) ) {
	$fssessionid = $headers["X-Session-Id"];
} else {
	// Local use (hard code)
	$fssessionid = "89cb651c-6556-4477-ad8d-4dcf500993c6-prod";
}

if( isset( $params["url"] ) ) {
	$url = $params["url"];
	$method = "GET";
	$valid_headers = [ "content-type" ];
} else if( isset( $headers["X-Api-Url"] ) ) {
	$url = $headers["X-Api-Url"];
	$contentType = "application/x-fs-v1+json";
	$method = $_SERVER["REQUEST_METHOD"];
	$body = file_get_contents( 'php://input' );
	$valid_headers = [ "content-type", "warning", "x-entity-id", "x-processing-time", "etag" ];
} else if( isset( $params["dgsNum"] ) ) {
	$url = "https://www.familysearch.org/search/filmdata/filmdatainfo";
	$contentType = "application/json";
	$method = "POST";
	$body = json_encode( array(
		"args" => array(
			"dgsNum" => $params["dgsNum"],
			"locale" => "fr",
			"loggedIn" => true,
			"sessionId" => "$fssessionid",
			"state" => array()
		),
		"type" => "film-data"
	) );
	$valid_headers = [ "content-type" ];
}

if( 1 != preg_match( '|^https://[^/]*familysearch.org/.*$|', $url ) ) {
	var_dump( $params );
	var_dump( $headers );
	exit;
}

$ch = curl_init( $url );

curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true );
curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );
curl_setopt( $ch, CURLOPT_HEADER, false );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, false );

curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, $method );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $body );
//curl_setopt( $ch, CURLOPT_COOKIE, "fssessionid=$fssessionid" );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
	"Accept: application/json",
	"authorization: Bearer $fssessionid",
	"Content-Type: $contentType",
	"Accept-Language: ".$headers["Accept-Language"]
) );
curl_setopt($ch, CURLOPT_HEADERFUNCTION, function( $f_ch, $f_header ) use (&$valid_headers) {
	$len = strlen( $f_header );
	$header = explode( ':', $f_header, 2 );
	if( count( $header ) < 2) {
		// ignore invalid headers
		return $len;
	}

	$name = strtolower( trim( $header[0] ) );
	if( true == in_array( $name, $valid_headers ) ) {
		header( $f_header );
	}

	return $len;
} );

$rep = curl_exec( $ch );
$r = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
if( $r > 200 && $r < 400 ) {
	// Real code when success
	http_response_code( $r );
}
if( $rep == "" && $r >= 300 ) {
	echo "{\"errors\":[{\"code\":$r}]}";
} else {
	echo $rep;
}

?>
