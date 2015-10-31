<?php
//$Id: affectation.inc,v 1.6 2008-07-28 13:39:18 jbastide Exp $
$DEBUG=0;
$serie=15;
$ent = "elu -> affectation";
$ico = "ico_parametrage.png";
$edition="";
$table="affectation inner join scrutin on scrutin.scrutin = affectation.scrutin";
$champAffiche = array (
        "affectation",
        "affectation.scrutin",
        "poste",
        "bureau",
        "candidat",
        "periode",
        "decision");
$champRecherche=array("affectation.scrutin","bureau");
$tri= "";
if(isset($idx))
    $selection=" where elu='".$idx."' and scrutin.solde != 'Oui'";
else
    $selection="";
?>