<?php
$home = "http://archives.oise.fr";
$ark = "44803";

// Extraction from official viewer page
$step1 = "simuIIIF";
$base = "http://ressources.archives.oise.fr";
$base_ark = "$base/v2/ark:/$ark/";
$filter_vue = '#inputvue_actuelle"\).val\(([0-9]*)\)';
$filter_logo =  '<img src="([^"]*)" alt="logo AD60"';
$filter_title =  '<img src="[^"]*" alt="logo AD60" title="([^"]*)"';
$filter_desc = '<title>([^(AD62)].+) - Visualiseur<\/title>';
$filter_desc2 =  '<select id="inputid" [^>]*><option [^>]*>([^<]*)<\/option>';
//$filter_desc2 = 'data-original="[^"]*\/frad060_([^\/"]*)_[0-9]*.jpg"';

$pl_active = false;
?>
