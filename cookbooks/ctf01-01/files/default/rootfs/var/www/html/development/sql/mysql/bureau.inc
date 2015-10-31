<?php
//$Id: bureau.inc,v 1.8 2008-07-28 13:39:18 jbastide Exp $
$DEBUG=0;
$serie=15;
$ent = "parametrage -> bureau";
if(isset($idx)){
  if($idx != "]")
   if (trim($idx!=""))
     $ent = $ent."-><font id='idz1'>&nbsp;".$idx."&nbsp;</font>";
}
if(isset($idz) ){
  if (trim($idz!=""))
   $ent = $ent."&nbsp;<font id='idz1'>&nbsp;".strtoupper($idz)."&nbsp;</font>";
}
$ico = "ico_bureau.png";
$edition="";
$table="bureau";
$champAffiche = array (
        "bureau", 
        "libelle", 
        "canton");
$champRecherche=array("libelle","bureau","canton");
$tri= " order by bureau";
$selection="";
// sous formulaire
$sousformulaire=array("agent_bureau","elu_bureau");
$sousformulaire_class="sousformulaire_profil";
?>