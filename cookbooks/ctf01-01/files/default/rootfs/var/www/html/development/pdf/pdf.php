<?php
//  $Id: pdf.php,v 1.2 2008-07-17 09:44:14 jbastide Exp $
// *****************************
// changer les variables session
// *****************************
session_name('openescrutin');
session_start();
set_time_limit(180);
header("Content-Type: image/png");
define('FPDF_FONTPATH','font/');
$DEBUG=0;
$multiplicateur=1; //compatibilite
// librairies utilisée(s) ===================================================
include ("../dyn/var.inc");
require($path_pear.'DB.php');
require($path_om.'db_fpdf.php');
// dsn
include ("../dyn/connexion.php");
// dsn
$db=& DB :: connect($dsn, $db_option);
if (DB :: isError($db)) {
    die($db->getMessage());
    }
 else{
    if($DEBUG==1)
    echo "La base ".$dsn['database']." est connectée.<br>";
}

// parametres generaux
$sqlc =  "SELECT * from collectivite ";
$res = $db->query($sqlc);
if (DB :: isError($res))
  $this->erreur_db($res->getDebugInfo(),$res->getMessage(),'');
else{
  while ($row=& $res->fetchRow()){
              $ville=$row[0];
              $logo=$row[1];
}}
//
// nom de l objet métier =====================================================
if(isset($_GET['obj']))
    $obj=$_GET['obj'];
else
    $obj="";
include ("../sql/".$dsn['phptype']."/".$obj.".pdf.inc");
// =========================================================================
$pdf=new PDF($orientation,'mm',$format);
$pdf->Open();
$pdf->SetMargins($margeleft,$margetop,$margeright); //marge gauche,haut,droite par defaut 10mm
$pdf->AliasNbPages();
$pdf->SetDisplayMode('real','single');
$pdf->SetDrawColor($C1border,$C2border,$C3border);////couleur du tracé
$pdf->AddPage();
//imprime  les colonnes de la requête
$pdf->Table($sql,$db,$height,$border,$align,$fond,$police,$size,$multiplicateur,$flag_entete);
//
$pdf->Output();
?> 