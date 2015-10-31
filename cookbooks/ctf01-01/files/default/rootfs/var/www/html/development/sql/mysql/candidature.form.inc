<?php
//$Id: candidature.form.inc,v 1.3 2008-02-05 16:24:50 fraynaud1 Exp $
$ent = "agent -> candidature";
$ico = "../img/ico_parametrage.png";
$tableSelect="candidature";
$champs=array("candidature","agent","scrutin",
              "periode","poste","bureau",
              "recuperation","note","decision",
              "debut","fin");
$selection="";
$sql_scrutin="select scrutin,scrutin from scrutin where solde <> 'Oui'";
$sql_bureau="select bureau,concat(bureau,' ', libelle) as lib from bureau  order by bureau";
$sql_periode="select periode,concat(periode,' ', libelle) as lib from periode order by periode";
$sql_poste="select poste,poste as lib from poste where nature = 'candidature' order by poste";
?>