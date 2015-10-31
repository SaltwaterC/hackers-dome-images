<?php
//22/09/2008   10:08:31
$etat['orientation']="P";
$etat['format']="A4";
$etat['footerfont']="helvetica";
$etat['footerattribut']="I";
$etat['footertaille']="8";
$etat['logo']="l.png";
$etat['logoleft']="7";
$etat['logotop']="9";
$etat['titre']="<b>Arles le £aujourdhui</b>";
$etat['titreleft']="125";
$etat['titretop']="10";
$etat['titrelargeur']="100";
$etat['titrehauteur']="5";
$etat['titrefont']="helvetica";
$etat['titreattribut']="I";
$etat['titretaille']="10";
$etat['titrebordure']="0";
$etat['titrealign']="C";
$etat['corps']="                                      ELECTION DU  <b>[date_scrutin]
                           [libelle]</b>";
$etat['corpsleft']="14";
$etat['corpstop']="30";
$etat['corpslargeur']="180";
$etat['corpshauteur']="8";
$etat['corpsfont']="helvetica";
$etat['corpsattribut']="";
$etat['corpstaille']="15";
$etat['corpsbordure']="1";
$etat['corpsalign']="C";
$etat['sql']="select libelle, concat(substring(date_scrutin,9,2),'/',substring(date_scrutin,6,2),'/',substring(date_scrutin,1,4)) as date_scrutin 
from scrutin where scrutin = '£idx'";
$etat['sousetat']=array("scrutin_president");
$etat['se_font']="helvetica";
$etat['se_margeleft']="8";
$etat['se_margetop']="5";
$etat['se_margeright']="5";
$etat['se_couleurtexte']=array("0","0","0");
?>