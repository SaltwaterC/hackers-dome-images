<?php
//11/03/2008   12:39:10
$sousetat['titre']="Assesseurs et délégués";
$sousetat['titrehauteur']="8";
$sousetat['titrefont']="helvetica";
$sousetat['titreattribut']="";
$sousetat['titretaille']="12";
$sousetat['titrebordure']="0";
$sousetat['titrealign']="L";
$sousetat['titrefond']="0";
$sousetat['titrefondcouleur']=array("243","246","246");
$sousetat['titretextecouleur']=array("0","0","0");
$sousetat['intervalle_debut']=10;
$sousetat['intervalle_fin']=15;
$sousetat['entete_flag']="1";
$sousetat['entete_fond']="1";
$sousetat['entete_orientation']=array("0","0","0");
$sousetat['entete_hauteur']="13";
$sousetat['entetecolone_bordure']=array("TLB","LTB","LTBR");
$sousetat['entetecolone_align']=array("C","C","C");
$sousetat['entete_fondcouleur']=array("145","184","189");
$sousetat['entete_textecouleur']=array("0","0","0");
$sousetat['tableau_largeur']="195";
$sousetat['tableau_bordure']="1";
$sousetat['tableau_fontaille']="10";
$sousetat['bordure_couleur']=array("0","0","0");
$sousetat['se_fond1']=array("243","246","246");
$sousetat['se_fond2']=array("255","255","255");
$sousetat['cellule_fond']="1";
$sousetat['cellule_hauteur']="10";
$sousetat['cellule_largeur']=array("90","50","55");
$sousetat['cellule_bordure_un']=array("LTBR","LTBRL","LTBR");
$sousetat['cellule_bordure']=array("LTBR","LTBR","LTBR");
$sousetat['cellule_align']=array("L","C","L");
$sousetat['cellule_fond_total']="1";
$sousetat['cellule_fontaille_total']="10";
$sousetat['cellule_hauteur_total']="15";
$sousetat['cellule_fondcouleur_total']=array("196","213","215");
$sousetat['cellule_bordure_total']=array("TBL","TBL","TBLR");
$sousetat['cellule_align_total']=array("L","L","C");
$sousetat['cellule_fond_moyenne']="1";
$sousetat['cellule_fontaille_moyenne']="10";
$sousetat['cellule_hauteur_moyenne']="5";
$sousetat['cellule_fondcouleur_moyenne']=array("212","219","220");
$sousetat['cellule_bordure_moyenne']=array("BTL","BTL","BTLR");
$sousetat['cellule_align_moyenne']=array("L","L","C");
$sousetat['cellule_fond_nbr']="1";
$sousetat['cellule_fontaille_nbr']="10";
$sousetat['cellule_hauteur_nbr']="15";
$sousetat['cellule_fondcouleur_nbr']=array("255","255","255");
$sousetat['cellule_bordure_nbr']=array("TBL","TBL","TBLR");
$sousetat['cellule_align_nbr']=array("L","L","R");
$sousetat['cellule_numerique']=array("999","999","999");
$sousetat['cellule_total']=array("0","0","0");
$sousetat['cellule_moyenne']=array("0","0","0");
$sousetat['cellule_compteur']=array("0","0","0");
$sousetat['sql']="SELECT  concat(nom,' ',prenom ) as nom, concat(affectation.poste,' (',affectation.bureau,') ') as poste, 
candidat  from affectation inner join elu on elu.elu=affectation.elu
left join bureau on bureau.bureau = affectation.bureau
inner join poste on affectation.poste = poste.poste
where  affectation.scrutin='£idx'  and
(affectation.bureau='£idz' or affectation.bureau = 'T')
and affectation.poste not like 'president%' and decision ='Oui'
order by affectation.bureau,poste.ordre,candidat
";
?>
