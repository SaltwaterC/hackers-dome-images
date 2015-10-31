<?php
//$Id: scrutin.inc,v 1.12 2008-07-22 11:11:25 jbastide Exp $
$DEBUG=0;
$serie=15;
$ent = "scrutin";
if(isset($idx)){
  if($idx != "]")
   if (trim($idx!=""))
     $ent = $ent."-><font id='idz1'>&nbsp;".$idx."&nbsp;</font>";
}
if(isset($idz) ){
  if (trim($idz!=""))
   $ent = $ent."&nbsp;<font id='idz1'>&nbsp;".strtoupper($idz)."&nbsp;</font>";
}
$ico = "ico_scrutin_chx.png";
$edition="";
         $href[0]['lien']= "form.php?obj=".$obj."&tri=".$tricol;
         $href[0]['id']= "";
         $href[0]['lib']= "<img src='../img/ajouter.png' border='0'>";
         //*
         $href[1]['lien'] = "form.php?obj=".$obj."&tri=".$tricol."&idx=";
         $href[1]['id']= "&premier=".$premier."&recherche=".$recherche1;
         $href[1]['lib']= "";
         $href[2]['lien'] = "form.php?obj=".$obj."&tri=".$tricol."&idx=";
         $href[2]['id']= "&ids=1&premier=".$premier."&recherche=".$recherche1;
         $href[2]['lib']= "<img src='../img/supprimer.png' border='0'>";
         //$href[3]['lien'] = "../pdf/publipostage.php?idx=";
         //$href[3]['id']= "&obj=candidature_p";
         //$href[3]['lib']= "<img src='../img/ico_agent.png' border=0>";
         //$href[4]['lien'] = "../pdf/publipostage.php?idx=";
         //$href[4]['id']= "&obj=affectation_p";
         //$href[4]['lib']= "<img src='../img/ico_elu.png' border=0>";
         //$href[5]['lien'] = "../pdf/publipostage.php?idx=";
         //$href[5]['id']= "&obj=affectation_r";
         //$href[5]['lib']= "<img src='../img/ico_exemplaire.png' border=0>";
         $href[3]['lien'] = "../pdf/pdfetat.php?idx=";
         $href[3]['id']= "&obj=scrutin_president";
         $href[3]['lib']= "<img src='../img/ico_scrutin.png' border=0>";
         $href[4]['lien'] = "../pdf/pdfetat.php?idx=";
         $href[4]['id']= "&obj=scrutin_bureau";
         $href[4]['lib']= "<img src='../img/ico_bureau.png' border=0>";
$table="scrutin";


$champAffiche=array("scrutin","libelle","canton","tour",
                    "concat(substring(date_scrutin,9,2),'/',substring(date_scrutin,6,2),'/',substring(date_scrutin,1,4)) as date_scrutin",
                    "solde");
$champRecherche=array("libelle","canton");
$tri= " order by date_scrutin desc";
$selection="";
// sous formulaire
$sousformulaire=array("candidat","agent_selection","elu_selection");
$sousformulaire_class="sousformulaire_profil";
?>