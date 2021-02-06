<?php

$i = $_GET["i"];
$s = preg_filter( '/^\/mnt\/lustre\/([^\/]*)\/.*/', '$1', $i );
require( "./config/simu_$s.php" );
$url = "$base/v2/images/genereImage.html?l=1800&h=1800&r=0&n=0&b=0&c=0&o=IMG&id=single_image&image=".urlencode($i) ;

//echo "<br>$url<br>";

$ch = curl_init( $url );

curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true );
//curl_setopt( $ch, CURLOPT_COOKIESESSION, true);
//curl_setopt( $ch, CURLOPT_COOKIEJAR, "");
//curl_setopt( $ch, CURLOPT_COOKIEFILE, "");
curl_setopt( $ch, CURLOPT_COOKIELIST, "ALL");
curl_setopt( $ch, CURLOPT_HEADER, false);

curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, false );
//curl_setopt( $ch, CURLOPT_MAXREDIRS, 1 );

$page = curl_exec( $ch );

if( $page === false ) {
	echo curl_error( $ch );
} else {
	//echo $page."<br>";

	$r = explode( "\t", $page );
	/*
		0- Un nombre (usage indéterminé)
		1- Chemin du cache généré
		2- Largeur du cache
		3- Hauteur du cache
		4- Largeur de l'original
		5- Hauteur de l'original
		6- Identifiant
	*/
	header('Content-Type: application/json');
	echo '{'.
		'"profile":"http://library.stanford.edu/iiif/image-api/1.1/compliance.html#level1",'.
		'"width":'.$r[4].','.
		'"height":'.$r[5].','.
		'"@context":"http://library.stanford.edu/iiif/image-api/1.1/context.json",'.
		'"@id": "simuIIIF/genereImage.php?i='.$i.'&w='.$r[4].'&h='.$r[5].'&p="'.
	'}';
}

?>
