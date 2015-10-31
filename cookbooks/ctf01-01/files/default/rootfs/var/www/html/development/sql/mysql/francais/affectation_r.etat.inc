<?php
//13/03/2008   15:11:50
$etat['orientation']="P";
$etat['format']="A4";
$etat['footerfont']="helvetica";
$etat['footerattribut']="I";
$etat['footertaille']="8";
$etat['logo']="l.png";
$etat['logoleft']="7";
$etat['logotop']="9";
$etat['titre']="ELECTIONS 
[libellescrutin] 
du [date_scrutin]

RECEPISSE";
$etat['titreleft']="86";
$etat['titretop']="26";
$etat['titrelargeur']="100";
$etat['titrehauteur']="8";
$etat['titrefont']="helvetica";
$etat['titreattribut']="";
$etat['titretaille']="12";
$etat['titrebordure']="1";
$etat['titrealign']="C";
$etat['corps']="           Vu l’article R.44 du Code électoral et la circulaire ministérielle NOR/INT/A/07/000123/C du 20 décembre 2007,

Le Maire de la Ville d’Arles donne récépissé à :

[nom] [prenom]
[adresse]
[cpelu] [villeelu]

De sa désignation en qualité de [poste]

Au bureau de vote : [bureau] [libellebureau]

Pour le candidat  : [candidat]

	
	Fait à £ville,  le £aujourdhui

	Le Maire de la Ville d’£ville




";
$etat['corpsleft']="40";
$etat['corpstop']="79";
$etat['corpslargeur']="150";
$etat['corpshauteur']="5";
$etat['corpsfont']="times";
$etat['corpsattribut']="";
$etat['corpstaille']="12";
$etat['corpsbordure']="0";
$etat['corpsalign']="J";
$etat['sql']="select nom, prenom, adresse, elu.cp as cpelu, elu.ville as villeelu, affectation.scrutin,
scrutin.libelle as libellescrutin, 
concat(substring(date_scrutin,9,2),'/',substring(date_scrutin,6,2),'/',substring(date_scrutin,1,4)) as date_scrutin,  scrutin.convocation_president, poste,
affectation.bureau, bureau.libelle as libellebureau, bureau.bureau,candidat
from elu inner join affectation on elu.elu = affectation.elu  
inner join scrutin on affectation.scrutin=scrutin.scrutin
left join bureau on bureau.bureau = affectation.bureau
where affectation.scrutin='£idx' and decision = 'Oui' and poste != 'president'
order by bureau.bureau
";
$etat['sousetat']=array();
$etat['se_font']="helvetica";
$etat['se_margeleft']="8";
$etat['se_margetop']="5";
$etat['se_margeright']="5";
$etat['se_couleurtexte']=array("0","0","0");
?>
