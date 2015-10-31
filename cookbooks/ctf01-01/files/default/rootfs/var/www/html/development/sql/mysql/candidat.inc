<?php
//$Id: candidat.inc,v 1.2 2008-07-24 14:33:31 jbastide Exp $
$DEBUG=0;
$serie=15;
$ent = "scrutin -> candidat";
$ico = "ico_parametrage.png";
$edition="";
$table="candidat";
$champAffiche = array ("candidat","nom");
$champRecherche=array("nom");
$tri= "";
if(isset($idx))
    $selection=" where scrutin='".$idx."'";
else
    $selection="";

?>