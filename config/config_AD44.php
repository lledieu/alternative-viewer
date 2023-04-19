<?php
$home = "https://archives.loire-atlantique.fr";
$ark = "42067";

// Extraction from official viewer page
$step1 = "simuIIIF";
$base = "https://archives-numerisees.loire-atlantique.fr";
$base_ark = "$base/v2/ark:/$ark/";
#$filter_vue = '#inputvue_actuelle"\).val\(([0-9]*)\)';
$filter_vue = 'name="vue_actuelle" value="([0-9]*)"';
$filter_logo =  '<img src="([^"]*)" alt="logo AD44"';
$filter_title =  '<img src="[^"]*" alt="logo AD44" title="([^"]*)"';
$filter_desc = '<title>(.+) - Visualiseur<\/title>';
$filter_desc2 =  '<select id="inputid" [^>]*><option [^>]*>([^<]*)<\/option>';
?>
