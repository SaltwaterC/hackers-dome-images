<?php
$DEBUG=0;
$serie=15;
$ent = "parametrage -> utilisateur";
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
$table="utilisateur left join profil on profil.profil=utilisateur.profil"; //table conecernée
$champAffiche=array("utilisateur.idutilisateur","utilisateur.nom","utilisateur.email","utilisateur.login","concat(utilisateur.profil,' ',profil.libelle_profil)as profil");
$champRecherche=array("nom","login");
if (!isset($idx))
   $selection="";
else
    $selection = " where utilisateur.profil = ".$idx;

$tri= " order by utilisateur.nom";
$methode="affichermail";
?>