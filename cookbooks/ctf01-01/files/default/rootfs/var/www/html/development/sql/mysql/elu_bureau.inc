<?php
//$Id: elu_bureau.inc,v 1.1 2007-12-08 15:35:03 fraynaud1 Exp $
$DEBUG=0;
$serie=15;
$ent = "scrutin -> affectation";
$ico = "ico_parametrage.png";
$edition="";
$table="affectation inner join elu on elu.elu=affectation.elu
       inner join scrutin on affectation.scrutin=scrutin.scrutin";
$champAffiche = array ( "elu.elu as elu",
        "bureau",
        "affectation.poste",
        "periode",
        "concat(nom,' ',prenom) as nom","scrutin.scrutin"
        );
$champRecherche=array("scrutin","bureau");
$tri= " order by bureau,affectation.poste,periode ";
$selection=" where affectation.decision ='Oui' and bureau ='".$idx."' and scrutin.solde != 'Oui'";
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