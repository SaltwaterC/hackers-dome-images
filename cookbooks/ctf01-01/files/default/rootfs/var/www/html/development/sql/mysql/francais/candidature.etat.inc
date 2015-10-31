<?php
//29/05/2009   11:40:53
$etat['orientation']="P";
$etat['format']="A4";
$etat['footerfont']="helvetica";
$etat['footerattribut']="I";
$etat['footertaille']="8";
$etat['logo']="l.png";
$etat['logoleft']="7";
$etat['logotop']="9";
$etat['titre']="Arles le £aujourdhui

[nom] [prenom]
[adresse]
[cpagent] [villeagent]";
$etat['titreleft']="111";
$etat['titretop']="21";
$etat['titrelargeur']="100";
$etat['titrehauteur']="5";
$etat['titrefont']="helvetica";
$etat['titreattribut']="";
$etat['titretaille']="10";
$etat['titrebordure']="0";
$etat['titrealign']="L";
$etat['corps']="Objet : ELECTION DU [date_scrutin]
            Affectation / Réunion préparatoire





Madame, Monsieur,

J’ai le plaisir de vous faire part de votre affectation en qualité de « [poste] »

Pour les élections  [libellescrutin]

Le DIMANCHE[date_scrutin]

Au bureau de vote – « [bureau] [libellebureau] »  [adresse1] [adresse2]

pour la periode :   [periode] [periodelibelle]

En cas d’empêchement de votre part, pour assurer ces fonctions, il convient de m’en informer le plus rapidement possible au 04.90.49.35.48.

Vous voudrez bien PARTICIPER IMPERATIVEMENT à la réunion préparatoire dont l'horaire 
et le lieu sont précisés ci-dessous, par avance je vous en remercie.


 [convocation_agent]


Cette réunion, destinée à l'ensemble des secrétaires et plantons, est organisée afin de vous
présenter les nouvelles dispositions arrêtées pour ce scrutin et vous donner toutes
précisions utiles notamment  sur l'établissement du procès-verbal.


Je vous prie de recevoir, Madame, Monsieur l’assurance de mes sentiments distingués.


Michèle MILCENT";
$etat['corpsleft']="38";
$etat['corpstop']="61";
$etat['corpslargeur']="150";
$etat['corpshauteur']="5";
$etat['corpsfont']="arial";
$etat['corpsattribut']="";
$etat['corpstaille']="10";
$etat['corpsbordure']="0";
$etat['corpsalign']="J";
$etat['sql']="select nom, prenom, adresse, agent.cp as cpagent, agent.ville as villeagent, candidature.scrutin,
scrutin.libelle as libellescrutin, 
concat(substring(date_scrutin,9,2),'/',substring(date_scrutin,6,2),'/',substring(date_scrutin,1,4)) as date_scrutin, candidature.poste, scrutin.convocation_agent,
candidature.bureau, bureau.libelle as libellebureau, candidature.periode, bureau.bureau,
bureau.adresse1, bureau.adresse2,periode.libelle as periodelibelle
from agent inner join candidature on agent.agent = candidature.agent  
inner join scrutin on candidature.scrutin=scrutin.scrutin
inner join bureau on bureau.bureau = candidature.bureau
left join periode on candidature.periode = periode.periode
where candidature.candidature='£idx'
 and decision = 'Oui'";
$etat['sousetat']=array();
$etat['se_font']="helvetica";
$etat['se_margeleft']="8";
$etat['se_margetop']="5";
$etat['se_margeright']="5";
$etat['se_couleurtexte']=array("0","0","0");
?>
