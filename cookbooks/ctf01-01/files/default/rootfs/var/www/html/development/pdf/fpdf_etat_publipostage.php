<?php
//$Id: fpdf_etat_publipostage.php,v 1.2 2008-10-15 16:20:43 fraynaud1 Exp $
// openMairie : http://www.openmairie.org
// contact@openmairie.org
include("../dyn/var.inc");
require_once $path_fpdf."fpdf.php";
class PDF extends fpdf
{
var $footerfont;
var $footerattribut;
var $footertaille;


// surcharge fpdf
//Pied de page
function Footer()
{
    //Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    //Police Arial italique 8
    $this->SetFont('Arial','I',8);
    //Numéro de page
    // $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
} //fin class pdf
?>