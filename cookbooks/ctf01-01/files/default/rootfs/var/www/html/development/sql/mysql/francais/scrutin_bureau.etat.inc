<?php
//25/01/2008   22:23:27
$etat['orientation']="P";
$etat['format']="A4";
$etat['footerfont']="helvetica";
$etat['footerattribut']="I";
$etat['footertaille']="8";
$etat['logo']="l.png";
$etat['logoleft']="7";
$etat['logotop']="9";
$etat['titre']="Arles le £aujourdhui



";
$etat['titreleft']="111";
$etat['titretop']="21";
$etat['titrelargeur']="100";
$etat['titrehauteur']="5";
$etat['titrefont']="helvetica";
$etat['titreattribut']="";
$etat['titretaille']="10";
$etat['titrebordure']="0";
$etat['titrealign']="L";
$etat['corps']="ELECTION DU [date_scrutin] 
[libelle]
           ";
$etat['corpsleft']="14";
$etat['corpstop']="62";
$etat['corpslargeur']="180";
$etat['corpshauteur']="5";
$etat['corpsfont']="times";
$etat['corpsattribut']="";
$etat['corpstaille']="15";
$etat['corpsbordure']="0";
$etat['corpsalign']="C";
$etat['sql']="select libelle, concat(substring(date_scrutin,9,2),'/',substring(date_scrutin,6,2),'/',substring(date_scrutin,1,4)) as date_scrutin 
from scrutin where scrutin = '£idx'";
$etat['sousetat']=array("scrutin_bureau");
$etat['se_font']="helvetica";
$etat['se_margeleft']="8";
$etat['se_margetop']="5";
$etat['se_margeright']="5";
$etat['se_couleurtexte']=array("0","0","0");
?>
