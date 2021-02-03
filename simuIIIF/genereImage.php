<?php

$i = $_GET["i"];
$s = preg_filter( '/^\/mnt\/lustre\/([^\/]*)\/.*/', '$1', $i );
require( "./config/simu_$s.php" );
if( isset($_GET['p']) ) {
	$w = $_GET['w'];
	$h = $_GET['h'];
	$r = explode( '/', $_GET['p'] );
	/*
		1- region
		2- size
		3- rotation
		4- quality[.format]
	*/
	$rs = explode( ',', $r[2] );
	/*
		0- largeur
		1- vide
	*/
	if( $r[1] == "full" ) {
		if( $rs[0] == "full" ) {
			$v_l = $w;
		} else {
			$v_l = $rs[0] ;
		}
		$v_h = intval( $rs[0] * $h / $w );
		$url = "$base/v2/images/genereImage.html?l=${v_l}&h=${v_h}&r=0&n=0&b=0&c=0&o=IMG&id=single_image&image=".urlencode($i) ;
	} else {
		$rz = explode( ',', $r[1] );
		/*
			0- x
			1- y
			2- w
			3- h
		*/
		$v_x = $rz[0];
		$v_y = $rz[1];
		$v_l = $rz[2];
		$v_h = $rz[3];
		$v_ol = $rs[0] ;
		$v_oh = intval( $rs[0] * $rz[3] / $rz[2] );

		$url = "$base/v2/images/genereImage.html?l=${v_l}&h=${v_h}&ol=${v_ol}&oh=${v_oh}&x=${v_x}&y=${v_y}&r=0&n=0&b=0&c=0&o=TILE&image=".urlencode($i) ;
	}
} else {
	$url = "$base/v2/images/genereImage.html?l=1800&h=1800&r=0&n=0&b=0&c=0&o=IMG&id=single_image&image=".urlencode($i) ;
}

//echo "<br>$url<br>";

/* Paramètres 
	l : largeur de tile en sortie
	h : hauteur de tile en sortie
	ol : offset largeur
	oh :
	x
	y
	n : négatif (0/1)
	b : brithness (0-100)
	c : contrast (0-100)
	o : IMG / TILE
	id : image_single tuile_<level>_<?>_<?>_<?>
	image : 
*/


$ch = curl_init( $url );

curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch, CURLOPT_COOKIESESSION, true);
curl_setopt( $ch, CURLOPT_COOKIEJAR, "");
curl_setopt( $ch, CURLOPT_COOKIEFILE, "");

curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt( $ch, CURLOPT_MAXREDIRS, 1 );

$page = curl_exec( $ch );

if( $page === false ) {
	echo curl_error( $ch );
} else {
	//echo $page."<br>";

	$url = preg_filter( '/^[0-9]*\t([^\t]*)\t.*/', '$1', $page );
	//echo $base.$url ;

	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
	curl_setopt( $ch, CURLOPT_URL, $base.$url );

	header('Content-Type: image/jpeg');
	curl_exec( $ch );
}

?>
