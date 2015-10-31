<?php
//$Id: scrutin.form.inc,v 1.3 2008-07-22 11:11:25 jbastide Exp $
$ent = "scrutin -> parametrage ";
$ico = "../img/ico_parametrage.png";
$tableSelect="scrutin";
$champs=array("scrutin","libelle","canton","tour","date_scrutin","solde"
              ,"convocation_agent", "convocation_president");
$selection="";
$sql_canton="select canton,concat(canton,' ', libelle) as lib from canton order by canton";
?>