<?php

$headers = apache_request_headers();
$fssessionid = $headers["SESSION_ID"];

if( isset( $_GET["url"] ) ) {
	$url = $_GET["url"];

	if( 1 == preg_match( '|^https://[^/]*familysearch.org/.*$|', $url ) ) {

		$ch = curl_init( $url );

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true );
		curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );
		curl_setopt( $ch, CURLOPT_COOKIE, "fssessionid=$fssessionid" );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, false );

		//curl_setopt( $ch, CURLOPT_VERBOSE, true );

		curl_exec( $ch );
	}
} else {
	$url = "https://www.familysearch.org/search/filmdata/filmdatainfo";
	if( isset( $_GET["dgsNum"] ) ) {
		$msg = json_encode( array(
			"args" => array(
				"dgsNum" => $_GET["dgsNum"],
				"locale" => "fr",
				"loggedIn" => true,
				"sessionId" => "$fssessionid",
				"state" => array()
			),
			"type" => "film-data"
		) );
	} else if( isset( $_GET["imageURL"] ) ) {
		$msg = json_encode( array(
			"args" => array(
				"imageURL" => $_GET["imageURL"],
				"locale" => "fr",
				"state" => array()
			),
			"type" => "image-data"
		) );
	} else {
		exit;
	}

	$ch = curl_init( $url );

	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true );
	curl_setopt( $ch, CURLOPT_HEADER, false );
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, false );

	curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $msg );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
		"Accept: application/json, application/json",
		"authorization: Bearer $fssessionid",
		"Content-Type: application/json",
		"Cookie: fssessionid=$fssessionid",
	) );

	//curl_setopt( $ch, CURLOPT_VERBOSE, true );

	header( "Content-Type: application/json" );
	curl_exec( $ch );
}

?>
