<?php
//$Id: service.inc,v 1.4 2008-07-22 11:11:25 jbastide Exp $
$DEBUG=0;
$serie=15;
$ent = "parametrage -> service";
if(isset($idx)){
  if($idx != "]")
   if (trim($idx!=""))
     $ent = $ent."-><font id='idz1'>&nbsp;".$idx."&nbsp;</font>";
}
if(isset($idz) ){
  if (trim($idz!=""))
   $ent = $ent."&nbsp;<font id='idz1'>&nbsp;".strtoupper($idz)."&nbsp;</font>";
}
$ico = "ico_parametrage.png";
$edition="";
$table="service";
$champAffiche=array("service","libelle");
$champRecherche=array("libelle");
$tri= " order by libelle";
$selection="";

?>