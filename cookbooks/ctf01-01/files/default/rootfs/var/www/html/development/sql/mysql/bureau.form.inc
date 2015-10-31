<?php
//$Id: bureau.form.inc,v 1.4 2008-07-22 11:11:25 jbastide Exp $
$ent = "parametrage -> bureau";
$ico = "../img/ico_parametrage.png";
$tableSelect="bureau";
$champs=array("bureau","libelle","canton","adresse1","adresse2","cp","ville");
$selection="";
$sql_canton="select canton,concat(canton,' ', libelle) as lib from canton order by canton";
?>