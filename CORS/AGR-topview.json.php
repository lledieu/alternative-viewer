<?php
header('Content-Type: application/json;charset=UTF-8');
header('X-Content-Type-Options: nosniff');

// Init curl
$ch = curl_init();

curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch, CURLOPT_COOKIESESSION, true);
curl_setopt( $ch, CURLOPT_COOKIEJAR, "");
curl_setopt( $ch, CURLOPT_COOKIEFILE, "");

curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt( $ch, CURLOPT_MAXREDIRS, 1 );

curl_setopt( $ch, CURLOPT_URL, "https://search.arch.be/imageserver/topview.json.php?FIF=".$_GET["FIF"] );

curl_exec( $ch );

?>
