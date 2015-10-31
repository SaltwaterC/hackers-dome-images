<?php
//$Id: candidature.inc,v 1.5 2008-07-28 13:39:18 jbastide Exp $
$DEBUG=0;
$serie=15;
$ent = "agent -> candidature";
$ico = "ico_parametrage.png";
$edition="";
$table="candidature inner join scrutin on scrutin.scrutin = candidature.scrutin";
$champAffiche = array (
        "candidature",
        "candidature.scrutin",
        "poste",
        "bureau",
        "periode",
        "recuperation",
        "decision");
$champRecherche=array("candidature.scrutin","bureau");
$tri= "";
if(isset($idx))
  $selection=" where agent='".$idx."' and scrutin.solde !='Oui'";
else
    $selection="";
?>