<?php

echo "/* --- ".basename(__FILE__)." --- */\n";

$pl = get_param( 'pl' );
if( "" == $pl ) {
	// uploaded file

	echo "/* ";
	var_dump( $_FILES );
	echo "*/\n";

	if( isset( $_FILES['html'] ) ) {
		if( 0 == $_FILES['html']['error'] ) {
			echo "/* upload OK */\n";

			$page = file_get_contents( $_FILES['html']['tmp_name'] );

			echo "/* file loaded */\n";

			$pl = preg_filter( '/.*<meta property="og:url" content="([^"]*)".*/s', "$1", $page );
			$url = $pl;
		} else {
			echo "/* Upload error : ".$_FILES['html']['error']." (voir https://www.php.net/manual/fr/features.file-upload.errors.php )*/\n";
			$page = false;
		}
	} else {
		echo "/* no pl / no upload ! */\n";
		$page = false;
	}
} else {
	if( false === strpos( $pl, '/' ) ) {
		// Id only
		$url = $base_ark.$pl;
	} else {
		// Full link
		$url = $pl;
	}
	echo "/* URL $url */\n";

	curl_setopt( $ch, CURLOPT_URL, $url );
	$page = curl_exec( $ch );
	if( $page === false ) {
		echo "/*\n";
		echo curl_error( $ch )."\n";
		echo "*/\n";
	}
}

if( $page !== false ) {

	//echo "/*\n$page\n*/\n";

	$sources = array();
	$tileSources = array();
	$res = preg_match_all( '/<img src="[^"]*" width="[^"]*" height="[^"]*" id="[^"]*" class="[^"]*" data-type="IMG" data-original="([^"]*)"\/>/', $page, $out, PREG_SET_ORDER );
	if( $res !== null ) {
		foreach( $out as $r ) {
			// specific data
			$source = array();
			$source["data-original"] = $r[1];
			$sources[] = $source;

			// OSD data
			$tileSources[] = "simuIIIF/info_json.php?i=".$r[1];
		}
	}
	$data["tileSources"] = $tileSources;
	$data["sources"] = $sources;

	$data["home"] = $home;
	if( isset( $pl_active ) && $pl_active == false) {
		// Desactivated (not working)
	} else {
		$data["ajax_pl"] = "simuIIIF/permalien.php?i={data-original}&pl=".urlencode($url);
	}
	$data["ajax_info"] = "simuIIIF/info_json.php?i={data-original}";

	if( isset( $filter_logo ) ) {
		$extracted_logo = preg_filter( "/.*$filter_logo.*/s", "$1", $page );
		if( substr( $extracted_logo, 0, 1 ) == "/" ) {
			$extracted_logo = $base.$extracted_logo;
		} else if( substr( $extracted_logo, 0, 3 ) == "../" ) {
			$extracted_logo = preg_replace( '/\/[^\/]*\/[^\/]*$/', '', $pl ).substr( $extracted_logo, 2 );
		}
		$data["logo"] = $extracted_logo;
	}

	if( isset( $filter_title ) ) {
		$extracted_title = preg_filter( "/.*$filter_title.*/s", "$1", $page );
		$data["title"] = $extracted_title;
	}

	if( isset( $filter_vue ) ) {
		$extracted_vue = preg_filter( "/.*$filter_vue.*/s", "$1", $page );
		if( $extracted_vue > 1 ) {
			$data["current-index"] = $extracted_vue - 1;
		}
	}

	if( isset( $filter_desc ) ) {
		$extracted_desc = preg_filter( "/.*$filter_desc.*/s", "$1", $page );
		$extracted_desc = str_replace( "\n", "", $extracted_desc );
		if( "" == $extracted_desc && isset( $filter_desc2 ) ) {
			$extracted_desc = strtoupper( preg_filter( "/.*$filter_desc2.*/s", "$1", $page ) );
			$extracted_desc = str_replace( "\n", "", $extracted_desc );
		}
		$data["desc"] = $extracted_desc;
	}
}

?>
