<?php
//05/02/2008   16:51:09
$etat['orientation']="P";
$etat['format']="A4";
$etat['footerfont']="helvetica";
$etat['footerattribut']="I";
$etat['footertaille']="8";
$etat['logo']="l.png";
$etat['logoleft']="7";
$etat['logotop']="9";
$etat['titre']="Arles le �aujourdhui

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
            Affectation / R�union pr�paratoire





Madame, Monsieur,

J�ai le plaisir de vous faire part de votre affectation en qualit� de � [poste] �

Pour les �lections  [libellescrutin]

Le DIMANCHE [date_scrutin]

Au bureau de vote � � [bureau] [libellebureau] �  [adresse1] [adresse2]

pour la periode : [periode]  [libelleperiode]

En cas d�emp�chement de votre part, pour assurer ces fonctions, il convient de m�en informer le plus rapidement possible au 04.90.49.35.48.

Vous voudrez bien PARTICIPER IMPERATIVEMENT � la r�union pr�paratoire dont les horaires et le lieu sont pr�cis�s ci-dessous, par avance je vous en remercie.

[convocation_agent]

Cette r�union, destin�e � l�ensemble des secr�taires et plantons, est organis�e afin de vous pr�senter les nouvelles dispositions arr�t�es pour ces scrutins et vous donner toutes pr�cisions utiles notamment sur l��tablissement du proc�s-verbal.

Je vous prie de recevoir, l�assurance de mes sentiments distingu�s.


Mich�le MILCENT";
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
candidature.bureau, bureau.libelle as libellebureau, candidature.periode, bureau.bureau, adresse1, adresse2, periode.libelle as libelleperiode
from agent inner join candidature on agent.agent = candidature.agent  
inner join scrutin on candidature.scrutin=scrutin.scrutin
inner join bureau on bureau.bureau = candidature.bureau
left join periode on candidature.periode=periode.periode
where candidature.scrutin='�idx'
 and decision = 'Oui'";
$etat['sousetat']=array();
$etat['se_font']="helvetica";
$etat['se_margeleft']="8";
$etat['se_margetop']="5";
$etat['se_margeright']="5";
$etat['se_couleurtexte']=array("0","0","0");
?>
