<?php
//$Id: canton.inc,v 1.5 2008-07-22 11:11:25 jbastide Exp $
$DEBUG=0;
$serie=15;
$ent = "parametrage -> canton";
if(isset($idz) ){
  if (trim($idz!=""))
   $ent = $ent."&nbsp;<font id='idz1'>&nbsp;".strtoupper($idz)."&nbsp;</font>";
}
$ico = "ico_canton.png";
$edition="";
$table="canton";
$champAffiche=array("canton","libelle");
$champRecherche=array("libelle");
$tri= " order by libelle";
$selection="";
?>