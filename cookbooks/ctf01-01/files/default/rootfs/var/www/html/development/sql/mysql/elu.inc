<?php
//$Id: elu.inc,v 1.6 2008-07-22 11:11:25 jbastide Exp $
$DEBUG=0;
$serie=15;
$ent = "scrutin -> elu";
if(isset($idx)){
  if($idx != "]")
   if (trim($idx!=""))
     $ent = $ent."-><font id='idz1'>&nbsp;".$idx."&nbsp;</font>";
}
if(isset($idz) ){
  if (trim($idz!=""))
   $ent = $ent."&nbsp;<font id='idz1'>&nbsp;".strtoupper($idz)."&nbsp;</font>";
}
$ico = "ico_elu.png";
$edition="";
$table="elu";
$champAffiche=array("elu","nom","prenom","nomjf");
$champRecherche=array("nom");
$tri= " order by nom";
$selection="";
// sous formulaire
$sousformulaire=array("affectation");
$sousformulaire_class="sousformulaire_profil";
?>