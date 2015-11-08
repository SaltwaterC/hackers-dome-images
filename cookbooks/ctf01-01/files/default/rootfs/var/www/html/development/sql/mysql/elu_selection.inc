<?php
//$Id: elu_selection.inc,v 1.3 2009-05-29 12:46:22 fraynaud1 Exp $
$DEBUG=0;
$serie=15;
$ent = "scrutin -> affectation";
$ico = "ico_parametrage.png";
$edition="";
$table="affectation inner join elu on elu.elu=affectation.elu";
$champAffiche = array ( "affectation","elu.elu as elu",
        "bureau",
        "affectation.poste",
        "periode",
        "concat(nom,' ',prenom) as nom"
        );
$champRecherche=array("scrutin","bureau");
$tri= " order by bureau,affectation.poste,periode ";
$selection=" where affectation.decision ='Oui' and scrutin ='".$idx."'";
//href
       $href[0]['lien']= "";
       $href[0]['id']= "";
       $href[0]['lib']= "";
       $href[1]['lien'] = "";
       $href[1]['id']= "";
       $href[1]['lib']= "";
       //051207
       $href[2]['lien'] = "";
       $href[2]['id']= "";
       $href[2]['lib']= "";
       $href[3]['lien'] = "../pdf/pdfetat.php?idx=";
       $href[3]['id']= "&obj=affectation";
       $href[3]['lib']= "<img src='../img/ico_pdf.png' border=0>";
?>
