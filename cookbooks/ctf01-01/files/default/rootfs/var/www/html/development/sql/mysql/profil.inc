<?php
//$id$
$DEBUG=0;
$serie=10;
$ent = "parametrage -> profil";
//
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
$table="profil";
$champAffiche=array("profil","libelle_profil");
$champRecherche=array("profil","libelle_profil");
$tri= "";
$selection="";
// sous formulaire
$sousformulaire=array("utilisateur","droit");
$sousformulaire_class="sousformulaire_profil";
// =============================================================================
// href particulier pour edition d etat
// =============================================================================
/*
       $href[0]['lien']= "form.php?obj=profil";
       $href[0]['id']= "";
       $href[0]['lib']= "<img src=../img/ajouter.gif border=0>";
       $href[1]['lien'] = "form_onglet.php?obj=profil&idx=";
       $href[1]['id']= "&premier=".$premier."&recherche=".$recherche1;
       $href[1]['lib']= "";
       $href[2]['lien'] = "form.php?obj=profil&idx=";
       $href[2]['id']= "&ids=1&premier=".$premier."&recherche=".$recherche1;
       $href[2]['lib']= "<img src='../img/supprimer.gif' border=0>";
       $href[3]['lien'] = "../pdf/pdfetat.php?idx=";
       $href[3]['id']= "&obj=profil";
       $href[3]['lib']= "<img src='../img/ico_pdf.png' border=0>";

       $href[0]['lien']= "form.php?obj=profil";
       $href[0]['id']= "";
       $href[0]['lib']= "<img src=../img/ajouter.gif border=0>";
       $href[1]['lien'] = "form.php?obj=profil&idx=";
       $href[1]['id']= "&premier=".$premier."&recherche=".$recherche1;
       $href[1]['lib']= "";
       $href[2]['lien'] = "form.php?obj=profil&idx=";
       $href[2]['id']= "&ids=1&premier=".$premier."&recherche=".$recherche1;
       $href[2]['lib']= "<img src='../img/supprimer.gif' border=0>";
       $href[3]['lien'] = "../pdf/pdfetat.php?idx=";
       $href[3]['id']= "&obj=profil";
       $href[3]['lib']= "<img src='../img/ico_pdf.png' border=0>";
*/
?>