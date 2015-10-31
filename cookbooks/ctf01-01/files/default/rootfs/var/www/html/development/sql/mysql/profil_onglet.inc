<?php
$DEBUG=0;
$serie=15;
$ent = "parametrage -> profil";
$ico = "../img/ico_parametrage.png";
$edition="";
//
$table="profil";
$champAffiche=array("profil","libelle_profil");
$champRecherche=array("profil","libelle_profil");
$tri= "";
$selection="";
// 1ER ONGLET UNIQUEMENT FORMULAIRE---------------------------------------------
$ongletun="profil";
//------------------------------------------------------------------------------
// sous formulaire
$sousformulaire=array("profil_onglet","utilisateur","droit");
$sousformulaire_class="sousformulaire_profil";
$soustab="onglets_profil";
?>