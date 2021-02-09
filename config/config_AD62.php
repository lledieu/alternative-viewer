<?php
$home = "http://archivesenligne.pasdecalais.fr";
$ark = "64297";

// Extraction from official viewer page
$step1 = "simuIIIF";
$base = $home;
$base_ark = "$home/v2/ark:/$ark/";
$filter_vue = '#inputvue_actuelle"\).val\(([0-9]*)\)';
$filter_logo =  '<img src="([^"]*)" alt="logo AD62"';
$filter_title =  '<img src="[^"]*" alt="logo AD62" title="([^"]*)"';
$filter_desc = '<title>([^(AD62)].+) - Visualiseur<\/title>';
//$filter_desc2 =  '<select id="inputid" [^>]*><option [^>]*>([^<]*)<\/option>';
$filter_desc2 = 'data-original="[^"]*\/frad062_([^\/"]*)_[0-9]*.jpg"';
?>
