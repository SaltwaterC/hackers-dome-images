<?php
$DEBUG=0;
$ent = "parametrage -> utilisateur";
$ico = "../img/ico_parametrage.png";
$serie=15;
$edition="";
$tableSelect="utilisateur";
$champs=array("idutilisateur","nom","email","login","pwd","profil");
$selection="";
$sql_profil="select profil,concat(profil,' ', libelle_profil) as lib from profil order by profil";
?>