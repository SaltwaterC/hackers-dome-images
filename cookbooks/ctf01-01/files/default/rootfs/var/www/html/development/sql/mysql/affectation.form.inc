<?php
//$Id: affectation.form.inc,v 1.5 2008-03-11 16:31:42 fraynaud1 Exp $
$ent = "elu -> affectation";
$ico = "../img/ico_parametrage.png";
$tableSelect="affectation";
$champs=array("affectation","elu","scrutin",
              "periode","poste","bureau","candidat","note","decision");
$selection="";
$sql_scrutin="select scrutin,scrutin from scrutin where solde <> 'Oui'";
$sql_bureau="select bureau,concat(bureau,' ', libelle) as lib from bureau  order by bureau";
$sql_periode="select periode,concat(periode,' ', libelle) as lib from periode order by periode";
$sql_poste="select poste,poste as lib from poste where nature = 'affectation' order by poste";
$sql_candidat="select nom,concat(nom,' ',candidat.scrutin) as lib from candidat
inner join scrutin on scrutin.scrutin=candidat.scrutin where scrutin.solde != 'Oui' ";
if(isset($_SESSION['scrutin']))
     $sql_candidat.=" and candidat.scrutin = '".$_SESSION['scrutin']."'";
$sql_candidat.="order by nom";

?>