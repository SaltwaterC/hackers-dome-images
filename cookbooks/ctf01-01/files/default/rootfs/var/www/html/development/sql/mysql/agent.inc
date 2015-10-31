<?php
//$Id: agent.inc,v 1.8 2008-07-22 11:11:25 jbastide Exp $
$DEBUG=0;
$serie=15;
$ent = "scrutin -> agent";
if(isset($idx)){
  if($idx != "]")
   if (trim($idx!=""))
     $ent = $ent."-><font id='idz1'>&nbsp;".$idx."&nbsp;</font>";
}
if(isset($idz) ){
  if (trim($idz!=""))
   $ent = $ent."&nbsp;<font id='idz1'>&nbsp;".strtoupper($idz)."&nbsp;</font>";
}
$ico = "ico_agent.png";
$edition="";
$table="agent left join service on agent.service=service.service left join grade on grade.grade=agent.grade";
$champAffiche=array("agent","nom","prenom","telephone",
                    "grade.libelle as grade",
                    "service.libelle as service");
$champRecherche=array("nom");
$tri= " order by nom";
$selection="";
// sous formulaire
$sousformulaire=array("candidature");
$sousformulaire_class="sousformulaire_profil";
?>