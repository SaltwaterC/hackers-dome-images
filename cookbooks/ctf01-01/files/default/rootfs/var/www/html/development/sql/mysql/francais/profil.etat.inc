<?php
//11/05/2006   11:16:59
$etat['orientation']="P";
$etat['format']="A4";
$etat['footerfont']="helvetica";
$etat['footerattribut']="I";
$etat['footertaille']="8";
$etat['logo']="logopdf.png";
$etat['logoleft']="8";
$etat['logotop']="9";
$etat['titre']="Profil [libelle_profil]
";
$etat['titreleft']="95";
$etat['titretop']="31";
$etat['titrelargeur']="100";
$etat['titrehauteur']="12";
$etat['titrefont']="helvetica";
$etat['titreattribut']="B";
$etat['titretaille']="15";
$etat['titrebordure']="1";
$etat['titrealign']="C";
$etat['corps']="Profil utilisé par  la ville de £ville numero [profil]

Nous presentons ici un exemple d'état des profils avec 2 sous etats:

- utilisateur pour le profil [libelle_profil]
- les droits pour le profil [libelle_profil]
                         ";
$etat['corpsleft']="28";
$etat['corpstop']="58";
$etat['corpslargeur']="110";
$etat['corpshauteur']="5";
$etat['corpsfont']="helvetica";
$etat['corpsattribut']="";
$etat['corpstaille']="10";
$etat['corpsbordure']="0";
$etat['corpsalign']="J";
$etat['sql']="select profil, libelle_profil from profil where profil = £idx";
$etat['sousetat']=array("utilisateur","droit");
$etat['se_font']="helvetica";
$etat['se_margeleft']="8";
$etat['se_margetop']="5";
$etat['se_margeright']="5";
$etat['se_couleurtexte']=array("0","0","0");
?>