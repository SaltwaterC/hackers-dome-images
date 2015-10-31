<?php
//$Id: droit.inc,v 1.4 2008-07-22 11:11:25 jbastide Exp $
$DEBUG=0;
$serie=12;
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
$edition="";
//
$table="droit left join profil on profil.profil=droit.profil";
$champAffiche=array("droit.droit","concat(droit.profil,' ',profil.libelle_profil)as profil");
$champRecherche=array("droit");

if (!isset($idx))
   $selection="";
else
    $selection = " where droit.profil = ".$idx;

$tri= " order by droit";
?>