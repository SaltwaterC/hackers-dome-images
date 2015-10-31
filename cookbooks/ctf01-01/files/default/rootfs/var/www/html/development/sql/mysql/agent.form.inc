<?php
//$Id: agent.form.inc,v 1.2 2008-07-22 11:11:25 jbastide Exp $
$ent = "scrutin -> agent ";
$ico = "../img/ico_parametrage.png";
$tableSelect="agent";
$champs=array("agent","nom","prenom","adresse","cp","ville","telephone","service","poste","grade");
$selection="";
$sql_service="select service,concat(service,' ', libelle) as lib from service order by service";
$sql_grade="select grade,concat(grade,' ', libelle) as lib from grade order by grade";
?>