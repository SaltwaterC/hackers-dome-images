<?php
//$Id: pdfetat_publipostage.php,v 1.8 2008-10-15 16:20:43 fraynaud1 Exp $
session_name('openscrutin');
session_start();
//include ("../dyn/session.inc");
set_time_limit(180);
include("../dyn/var.inc");
// classe fpdf
define('FPDF_FONTPATH','font/');
require('fpdf_etat_publipostage.php');
require($path_pear.'DB.php');

// connexion
include ("../dyn/connexion.php");
$DEBUG=0;
// dsn
$db=& DB :: connect($dsn, $db_option);
if (DB :: isError($db))
    die($db->getMessage());
else{
    if($DEBUG==1)
    echo "La base ".$dsn['database']." est connectée.<br>";
}
// parametre generaux
$res = $db->query($sql_collectivite);
if (DB :: isError($res))
   die($res->getMessage()."erreur ".$sql_collectivite);
else{
   while ($row=& $res->fetchRow()){
              $ville=$row[0];
              $logo=$row[1];
              $nom=$row[2];
}}
$res->free();
if(isset($_GET['idx']))
    $idx=$_GET['idx'];
else
    $idx="";
if(isset($_GET['obj']))
    $obj=$_GET['obj'];
else
    $obj="";
//
if (isset($langue)){
     if (file_exists("../sql/".$dsn['phptype']."/".$langue."/".$obj.".etat.inc"))
        include ("../sql/".$dsn['phptype']."/".$langue."/".$obj.".etat.inc");
}else{
     if(file_exists ("../sql/".$dsn['phptype']."/".$obj.".etat.inc"))
       include ("../sql/".$dsn['phptype']."/".$obj.".etat.inc");
}
//
// INSTANCE PDF            =====================================
// orientation P= portrait L=paysage
// unite mm (milimetre)
// format A4 A3
// =============================================================
$unite="mm";
$pdf=new PDF($etat["orientation"],$unite,$etat["format"]);
$pdf->footerfont=$etat["footerfont"];
$pdf->footertaille=$etat["footertaille"];
$pdf->footerattribut=$etat["footerattribut"];
$pdf->SetMargins($etat['se_margeleft'],$etat['se_margetop'],$etat['se_margeright']); //marge gauche,haut,droite par defaut 10mm
$pdf->SetDisplayMode('real','single');
// methode fpdf calcul nombre de page
// $pdf->AliasNbPages();
// methode de creation de page
$pdf->AddPage();
// police ======================================================
// setFont 0 = times, arial
//         1 = I B ou ''
//         2 = 8 ....
// affichage image =============================================
// image     0 = nom
//           1 = left
//           2 = top
//           3 = width 0=calcul auto
//           4 = hauteur 0=calcul auto
//           5 = type image  rien=exetension du fichier
//           6 = lien
// setXY (left,top) =============================================
// affichage multicell ==========================================
// multicell 0 = width   =0 left->droite
//           1 = hauteur de la cellule
//           2 = texte
//           3 = bordure (0 ou 1)
//           4 = align (L C R J)
//           5 =     0 fd transparent
//                   1 couleur (parametre à rajouter)
// ==============================================================

// variables statiques
$sql=$etat['sql'];
$titre= $etat["titre"];
$corps= $etat["corps"];
include("../dyn/varetatpdf.inc");

$res = $db->query($sql);



if (DB :: isError($res))
   die($res->getMessage()."erreur ".$sql);
else{
   while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
   $temp="../trs/".$etat['logo'];
   $pdf->Image($temp,
            $etat["logoleft"],
            $etat["logotop"],
            0,
            0,
            '',
            '');
    // titre
   /*
   $temp = explode("[",$etat["titre"]);
   for($i=1;$i<sizeof($temp);$i++){
       $temp1 = explode("]",$temp[$i]);
       $titre=str_replace("[".$temp1[0]."]",$row[$temp1[0]],$titre);
       $temp1[0]="";
   }
   */
   //$titre = $row['nom']; // => prend tout les noms
   include ("publipostage.inc");
   include("../dyn/varetatpdf.inc");
   $pdf->SetFont($etat["titrefont"],
                 $etat["titreattribut"],
                 $etat["titretaille"]);
   $pdf->SetXY($etat["titreleft"],
               $etat["titretop"]);
   $pdf->MultiCell($etat["titrelargeur"],
                   $etat["titrehauteur"],
                   $titre,
                   $etat["titrebordure"],
                   $etat["titrealign"],
                   0);

   // corps

  // $temp = explode("[",$etat["corps"]);

  // for($i=1;$i<sizeof($temp);$i++){
  //     $temp1 = explode("]",$temp[$i]);
  //     $corps=str_replace("[".$temp1[0]."]",$row[$temp1[0]],$corps);
  //     $temp1[0]="";
  // }

   //$corps=$corps.$row['nom'];
   // ne prend que le 1er nom : josette laget
   $pdf->SetFont($etat["corpsfont"],
                 $etat["corpsattribut"],
                 $etat["corpstaille"]);
   $pdf->SetXY($etat["corpsleft"],
               $etat["corpstop"]);
   $pdf->MultiCell($etat["corpslargeur"],
                   $etat["corpshauteur"] ,
                   $corps,
                   $etat["corpsbordure"],
                   $etat["corpsalign"],
                   0);
   $pdf->AddPage();
 // ***
//echo $row['nom'];
}}
$pdf->Output();
// affichage des sous etats
/*
if($etat['sousetat']!="") {
foreach($etat['sousetat'] as $elem){
include ("../sql/".$dsn['phptype']."/".$elem.".sousetat.inc");
// =========================================================================
// traitementde variables : &
$sql=$sousetat['sql'];
$titre=$sousetat['titre'];
include("../dyn/varetatpdf.inc");
$sousetat['sql']=$sql;
$sousetat['titre']=$titre;
//
//imprime  les colonnes de la requête
$pdf->sousetat($db,$etat,$sousetat);
}
//
}
*/



$db->disconnect();
if ($DEBUG == 1)
      echo "La base ".$dsn['database']." est déconnectée.<br>";
?>