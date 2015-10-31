<?php
//11/03/2008   11:41:37
$etat['orientation']="P";
$etat['format']="A4";
$etat['footerfont']="helvetica";
$etat['footerattribut']="I";
$etat['footertaille']="8";
$etat['logo']="l.png";
$etat['logoleft']="7";
$etat['logotop']="9";
$etat['titre']="ELECTION DU [date_scrutin] 

[libelle]


[bureau] - [libelle_bureau]



";
$etat['titreleft']="99";
$etat['titretop']="13";
$etat['titrelargeur']="100";
$etat['titrehauteur']="5";
$etat['titrefont']="helvetica";
$etat['titreattribut']="";
$etat['titretaille']="15";
$etat['titrebordure']="0";
$etat['titrealign']="L";
$etat['corps']="President  :  [president]

suppleant :  [president_suppleant]

Secretaire : [secretaire]";
$etat['corpsleft']="14";
$etat['corpstop']="62";
$etat['corpslargeur']="180";
$etat['corpshauteur']="5";
$etat['corpsfont']="times";
$etat['corpsattribut']="B";
$etat['corpstaille']="15";
$etat['corpsbordure']="0";
$etat['corpsalign']="L";
$etat['sql']="select composition_bureau.bureau, president,president_suppleant,secretaire,               concat(substring(date_scrutin,9,2),'/',substring(date_scrutin,6,2),'/',substring(date_scrutin,1,4)) as date_scrutin,
scrutin.libelle as libelle, bureau.libelle as libelle_bureau
from composition_bureau inner join scrutin on scrutin.scrutin=composition_bureau.scrutin 
inner join bureau on bureau.bureau=composition_bureau.bureau
where composition_bureau.scrutin = '£idx' and composition_bureau.bureau ='£idz'";
$etat['sousetat']=array("composition_bureau");
$etat['se_font']="helvetica";
$etat['se_margeleft']="8";
$etat['se_margetop']="5";
$etat['se_margeright']="5";
$etat['se_couleurtexte']=array("0","0","0");
?>
