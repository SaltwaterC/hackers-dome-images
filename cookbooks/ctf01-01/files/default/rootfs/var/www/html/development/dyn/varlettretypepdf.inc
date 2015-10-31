<?php
// =========================================================================
// Module de paramétrage des lettres type
// =========================================================================



$sql=str_replace("£idx",$_GET['idx'],$sql);
$sql=str_replace("£destinataire",$destinataire,$sql);

$titre=str_replace("£aujourdhui",date('d/m/Y'),$titre);
$titre=str_replace("£ville",$ville,$titre);
$titre=str_replace("£nom",$nom,$titre);
$titre=str_replace("£datecourrier",$datecourrier,$titre);
$titre=str_replace("£complement",$complement,$titre);
$titre=str_replace("£idx",$_GET['idx'],$titre);

$corps=str_replace("£aujourdhui",date('d/m/Y'),$corps);
$corps=str_replace("£ville",$ville,$corps);
$corps=str_replace("£nom",$nom,$corps);
$corps=str_replace("£datecourrier",$datecourrier,$corps);
$corps=str_replace("£complement",$complement,$corps);
?>