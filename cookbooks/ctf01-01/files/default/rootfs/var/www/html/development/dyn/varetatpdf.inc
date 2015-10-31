<?php
// =========================================================================
// Module de paramétrage des etats
// $Id: varetatpdf.inc,v 1.3 2008-03-11 11:42:16 fraynaud1 Exp $
// =========================================================================
if(isset($_GET['idz']))
    $idz=$_GET['idz'];
else
    $idz="";


$sql=str_replace("£idx",$_GET['idx'],$sql);
$sql=str_replace("£idz",$idz,$sql);

$titre=str_replace("£aujourdhui",date('d/m/Y'),$titre);
$titre=str_replace("£ville",$ville,$titre);
$titre=str_replace("£nom",$nom,$titre);


$corps=str_replace("£aujourdhui",date('d/m/Y'),$corps);
$corps=str_replace("£ville",$ville,$corps);
$corps=str_replace("£nom",$nom,$corps);

?>