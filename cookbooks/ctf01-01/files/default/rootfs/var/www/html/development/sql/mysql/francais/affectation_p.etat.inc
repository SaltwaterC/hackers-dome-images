<?php
//13/03/2008   8:59:56
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
[cpelu] [villeelu]";
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
[libellescrutin]




       Madame, Monsieur, Cher(e) Collègue,


      Conformément aux dispositions de l’article R. 43 du Code Electoral « les bureaux de vote sont présidés par les Maires, Adjoints et Conseillers Municipaux dans l’ordre du tableau ».

      Je vous confirme votre affectation en qualité de    PRESIDENT  au bureau de vote 

      N° [bureau] [libellebureau]
      [adresse1]
      [adresse2]

      

      
[convocation_president]



       Dans cette attente, je vous prie de croire, Madame, Monsieur, Cher(e) Collègue, à l’expression de mes sentiments les meilleurs.


                                                                                                   Pour le Maire,   
                                                                                                   L’Adjoint déléguée




                                                                                                   Danielle DUCROS




";
$etat['corpsleft']="22";
$etat['corpstop']="61";
$etat['corpslargeur']="150";
$etat['corpshauteur']="5";
$etat['corpsfont']="times";
$etat['corpsattribut']="";
$etat['corpstaille']="12";
$etat['corpsbordure']="0";
$etat['corpsalign']="J";
$etat['sql']="select nom, prenom, adresse, elu.cp as cpelu, elu.ville as villeelu, affectation.scrutin,
scrutin.libelle as libellescrutin, 
concat(substring(date_scrutin,9,2),'/',substring(date_scrutin,6,2),'/',substring(date_scrutin,1,4)) as date_scrutin,  scrutin.convocation_president,
affectation.bureau, bureau.libelle as libellebureau, bureau.bureau,
bureau.adresse1, bureau.adresse2
from elu inner join affectation on elu.elu = affectation.elu  
inner join scrutin on affectation.scrutin=scrutin.scrutin
inner join bureau on bureau.bureau = affectation.bureau
where affectation.scrutin='£idx' and decision = 'Oui' and poste = 'president'
";
$etat['sousetat']=array();
$etat['se_font']="helvetica";
$etat['se_margeleft']="8";
$etat['se_margetop']="5";
$etat['se_margeright']="5";
$etat['se_couleurtexte']=array("0","0","0");
?>
