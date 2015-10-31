<?php
//$Id: droit.form.inc,v 1.3 2008-07-22 11:11:25 jbastide Exp $
$ent = "parametrage -> droit";
if(isset($idx)){
  if($idx != "]")
   if (trim($idx!=""))
     $ent = $ent."-><font id='idz1'>&nbsp;".$idx."&nbsp;</font>";
}
if(isset($idz) ){
  if (trim($idz!=""))
   $ent = $ent."&nbsp;<font id='idz1'>&nbsp;".strtoupper($idz)."&nbsp;</font>";
}
$ico = "../img/ico_parametrage.png";
$tableSelect="droit";
$champs=array("droit","profil");
$selection="";
$sql_profil="select profil,concat(profil,' ', libelle_profil) as lib from profil order by profil";
/*$ent = "Paramétrage -> bureau";
$ico = "../img/ico_parametrage.png";
$tableSelect="bureau";
$champs=array("bureau","libelle","canton","zone");
$selection="";
$sql_canton="select canton,concat(canton,' ', libelle) as lib from canton order by canton";
$sql_zone="select zone,concat(zone,' ', libelle) as lib from zone order by zone";*/
?>