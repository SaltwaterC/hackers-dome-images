<?php
//$Id: agent_bureau.inc,v 1.2 2008-02-05 17:06:53 fraynaud1 Exp $
$DEBUG=0;
$serie=15;
$ent = "scrutin -> candidature";
$ico = "ico_parametrage.png";
$edition="";
$table="candidature inner join agent on agent.agent=candidature.agent
       inner join scrutin on candidature.scrutin=scrutin.scrutin";
$champAffiche = array ("candidature.agent",
        "bureau",
        "candidature.poste",
        "periode",
        "concat(nom,' ',prenom,' ',telephone) as agent",
        "scrutin.scrutin"
        );
$champRecherche=array("scrutin","bureau");
$tri= " order by bureau,scrutin.scrutin,candidature.poste,periode ";
$selection=" where candidature.decision ='Oui' and bureau ='".$idx."' and scrutin.solde != 'Oui'";
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
       $href[3]['id']= "&obj=candidature";
       $href[3]['lib']= "<img src='../img/ico_pdf.png' border=0>";
?>