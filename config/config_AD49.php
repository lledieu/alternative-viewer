<?php
$home = "https://www.archives49.fr";
//$logo = "https://www.archinoe.fr/v2/ad49/images/logo.png";
//$title = "Archives départementales du Maine-et-Loire";
$ark = "71821";

// Extraction from official viewer page
$step1 = "simuIIIF";
$base = "https://www.archinoe.fr";
$base_ark = "$base/v2/ark:/$ark/";
$filter_vue = '#inputvue_actuelle"\).val\(([0-9]*)\)';
$filter_logo =  '<img src="([^"]*)" alt="logo AD49"';
$filter_title =  '<img src="[^"]*" alt="logo AD49" title="([^"]*)"';
$filter_desc = '<title>(.+) - Visualiseur<\/title>';
$filter_desc2 =  '<select id="inputid" [^>]*><option [^>]*>([^<]*)<\/option>';
?>
