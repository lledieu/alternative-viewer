<?php

echo "/* --- ".basename(__FILE__)." --- */\n";

echo "/* ";
var_dump( $_FILES );
echo "*/\n";

if( 0 == $_FILES['html']['error'] ) {
	echo "/* upload OK */\n";

	$page = file_get_contents( $_FILES['html']['tmp_name'] );

	echo "/* file loaded */\n";

	$res = preg_match_all( '/<img src="[^"]*" width="1px" height="1px" id="([^"]*)" class="lazy" data-type="IMG" data-original="([^"]*)"\/>/s', $page, $out, PREG_SET_ORDER );
	if( $res !== null ) {
		foreach( $out as $r ) {
			echo " \"simuIIIF/info_json.php?i=$r[2]\",\n";
		}
	}
} else {
	echo "/* Upload error : ".$_FILES['html']['error']." (voir https://www.php.net/manual/fr/features.file-upload.errors.php )*/\n";
}

unlink( $_FILES['html']['tmp_name'] );

echo "/* --- file removed --- */\n";

?>
