<?php
//$Id: pdfetiquette.php,v 1.3 2008-07-17 09:44:14 jbastide Exp $
set_time_limit(180);
header("Content-Type: image/png");
define('FPDF_FONTPATH','font/');
// *******************************
// session name
// *******************************
session_name('openscrutin');
session_start();
$DEBUG=0;
// librairies utilis�e(s) ======================================================
include ("../dyn/var.inc");
require($path_pear.'DB.php');
require('../spg/fpdf_etiquette.php');
include ("../dyn/connexion.php");
// nom de l objet m�tier =======================================================
if(isset($_GET['obj']))
    $obj=$_GET['obj'];
else
    $obj="";
//dsn  ======================================================================
$db=& DB :: connect($dsn, $db_option);

if (DB::isError($db)) {
    die($db->getMessage());
}else{
  $res = $db->query($sql_collectivite);
  if (DB :: isError($res))
       $this->erreur_db($res->getDebugInfo(),$res->getMessage(),'');
  else{
    if($DEBUG==1)
        echo "La base ".$dsn['database']." est connect�e.<br>";
    while ($row=& $res->fetchRow()){
              $ville=$row[0];
              $maire=$row[2];
              $cp=$row[7];    //****
}}}
//
include ("../sql/".$dsn['phptype']."/".$obj.".pdfetiquette.inc");
// =============================================================================
  $pdf=new PDF($orientation,'mm',$format);
  //
  $pdf->SetFont($police,$gras,$size);
  $pdf->SetTextColor($C1,$C2,$C3);
  $pdf->SetMargins(0,0);
  $pdf->SetAutoPageBreak(false);
  $pdf->Open();
  $pdf->AddPage();
  $pdf->SetDisplayMode('real','single');
  //--------------------------------------------------------------------------//
  // param:                                                                   //
  //--------------------------------------------------------------------------//
  // (0) $_Margin_Left = 5; Marge de gauche de l'�tiquette                    //
  // (1) $_Margin_Top = 11; marge en haut de la page avant la premi�re �tiquette
  // (2) $_X_Space  = 12;   Espace horizontal entre 2 bandes d'�tiquettes     //
  // (3) $_Y_Space = 10;    Espace vertical entre 2 bandes d'�tiquettes       //
  // (4) $_X_Number = 2;    Nombre d'�tiquettes sur la largeur de la page     //
  // (5) $_Y_Number =5;     Nombre d'�tiquettes sur la hauteur de la page     //
  // (6) $_Width = 95;      Largeur de chaque �tiquette                       //
  // (7) $_Height = 30;     Hauteur de chaque �tiquette                       //
  // (8) $_Char_Size = 5;   Hauteur des caract�res                            //
  // (9) $_Line_Height = 4; Hauteur par d�faut  interligne                    //
  // (10) $_cptx=0;                                                           //
  // (11) $_cpty=0;                                                           //
  // (12) size police                                                         //
  // (13) CADRE CHAMPS DATA,TXETE,COMPTEUR 1 OU 0                             //
  // (14) CADRE ZONE REPETEE avec tous les champs1 OU 0                       //
  //--------------------------------------------------------------------------//
  // imprimante marges minimale g 6.01,d 6.18,h 4.23,b 4.23 ?????
  $param=array();
  $param=array($_margin_left,$_margin_top,$_x_space,$_y_space,$_x_number,$_y_number,$_width,$_height,$_char_size,$_line_height,0,0,$size,$cadrechamps,$cadre);
  //--------------------------------------------------------------------------//
  //    champs compteur      $champs_compteur=array();                        //
  //--------------------------------------------------------------------------//
  // (0) 1 -> affichage compteur ou 0 ->pas d'affichage                       //
  // (1) x                                                                    //
  // (2) y                                                                    //
  // (3) width                                                                //
  // (4) bold 1 ou 0                                                          //
  // (5) size ou 0                                                            //
  // par rapport a la dimension du pr�-imprimer                               //
  // exemple  $champs_compteur=array(1,20,5,25,0,0);                          //
  //--------------------------------------------------------------------------//
  //
  //--------------------------------------------------------------------------//
  //    champs image(s)       $img=array();                                   //
  //--------------------------------------------------------------------------//
  // (0) file Nom du fichier contenant l'image.                               //
  // (1) x Abscisse du coin sup�rieur gauche.                                 //
  // (2) y Ordonn�e du coin sup�rieur gauche.                                 //
  // (3) w Largeur de l'image dans la page. Si elle n'est pas indiqu�e ou vaut//
  //       z�ro, elle est calcul�e automatiquement.                           //
  // (4) h Hauteur de l'image dans la page.Si elle n'est pas indiqu�e ou vaut //
  //      z�ro, elle est calcul�e automatiquement.                            //
  // (5) type Format de l'image. Les valeurs possibles sont                   //
  //     (ind�pendamment de la casse) : JPG, JPEG, PNG. S'il n'est pas pr�cis�,/
  //     le type est d�duit de l'extension du fichier.                        //
  // exemple :                                                                //
  // $img=array(array('../img/arles.png',1,1,17.6,12.6,'png')                 //
  // array('../img/arles.png',40,1,17.6,12.6,'png')                           //
  // array('../img/arles.png',25,1,120,86,'png')                              //
  // );                                                                       //
  //--------------------------------------------------------------------------//
  //
  //--------------------------------------------------------------------------//
  //    champs texte (s)       $texte=array();                                //
  //--------------------------------------------------------------------------//
  // (0) texte                                                                //
  // (1) x                                                                    //
  // (2) y                                                                    //
  // (3) width                                                                //
  // (4) bold 1 ou 0                                                          //
  // (5) size ou 0                                                            //
  // par rapport a la dimension du pr�-imprimer                               //
  //--------------------------------------------------------------------------//
  //
  //--------------------------------------------------------------------------//
  //    champs data  $champs=array()                                          //
  //--------------------------------------------------------------------------//
  // (0) affichage avant data                                                 //
  // (1) affichage apres data                                                 //
  // (2) tableau X Y Width bold(0 ou 1),size ou 0                             //
  // par rapport a la dimension du pr�-imprimer                               //
  // (3) 1 = number_format(champs,0) : 0002->2  /  ou 0                       //
  //--------------------------------------------------------------------------//
  //
  $pdf->Table_position($sql,$db,$param,$champs,$texte,$champs_compteur,$img);
  $pdf->Output();
  $pdf->Close();
  $db->disconnect();
?> 

