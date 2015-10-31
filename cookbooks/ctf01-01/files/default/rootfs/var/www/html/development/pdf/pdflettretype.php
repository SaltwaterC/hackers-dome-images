<?php
session_name('openscrutin');
session_start();
//$Id: pdflettretype.php,v 1.4 2008-09-22 09:08:01 jbastide Exp $;
set_time_limit(180);
include("../dyn/var.inc");
// classe fpdf
define('FPDF_FONTPATH','font/');
require($path_fpdf.'fpdf.php');
require($path_pear.'DB.php');
class PDF extends FPDF
{
//Pied de page
  function Footer()
  {
      // NUMERO DE PAGE

      //Positionnement à 1,5 cm du bas
      $this->SetY(-15);
      // Police Arial italique 8
      $this->SetFont('Arial','I',8);
      // Numéro de page
      $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
  }
}
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
    $idx="";  //***

$sql_courrier="select * from courrier where courrier=".$idx;
$res = $db->query($sql_courrier);
if (DB :: isError($res))
   die($res->getMessage()."erreur ".$sql_courrier);
else{
   while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
              $obj=$row['lettretype'];
              $destinataire=$row['destinataire'];  // ***
              $datecourrier=$row['datecourrier'];
              $complement=$row['complement'];

}}
$res->free();
// format date
if ($formatDate=="AAAA-MM-JJ"){
       $valTemp=explode("-",$datecourrier);
       $datecourrier= $valTemp[2]."/".$valTemp[1]."/".$valTemp[0];
}
//if ($formatDate=="JJ/MM/AAAA"){
//}
    if (isset($langue)){
        if (file_exists("../sql/".$dsn['phptype']."/".$langue."/".$obj.".lettretype.inc"))
           include ("../sql/".$dsn['phptype']."/".$langue."/".$obj.".lettretype.inc");
    }else{
         if (file_exists ("../sql/".$dsn['phptype']."/".$obj.".lettretype.inc"))
           include ("../sql/".$dsn['phptype']."/".$obj.".lettretype.inc");
    }
// INSTANCE PDF            =====================================
// orientation P= portrait L=paysage
// unite mm (milimetre)
// format A4 A3
// =============================================================
$unite="mm";
$pdf=new PDF($lettretype["orientation"],$unite,$lettretype["format"]);
// methode fpdf calcul nombre de page
$pdf->AliasNbPages();
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
$pdf->Image("../trs/".$_SESSION['coll']."/".$lettretype["logo"],
            $lettretype["logoleft"],
            $lettretype["logotop"],
            0,
            0,
            '',
            '');
// variables statiques
$sql=$lettretype['sql'];
$titre= $lettretype["titre"];
$corps= $lettretype["corps"];
include("../dyn/varlettretypepdf.inc");
$res = $db->query($sql);
if (DB :: isError($res))
   die($res->getMessage()."erreur ".$sql);
else{
   while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
    // titre
   $temp = explode("[",$lettretype["titre"]);
   for($i=1;$i<sizeof($temp);$i++){
       $temp1 = explode("]",$temp[$i]);
       $titre=str_replace("[".$temp1[0]."]",$row[$temp1[0]],$titre);
       $temp1[0]="";
   }
   //
   //************************************************
   // traitement attribut affichage <b> dans titre  *
   //              aout 2008                        *
   //************************************************
   $pos_t="";
   $pos_t = strpos($titre, "<b>");
   if ($pos_t === false) {
   // compatibilite :aucun attribut affichage <b> dans corps
   //***************************************************************************
     if(trim($titre)!="") {
         $pdf->SetFont($lettretype["titrefont"],
                     $lettretype["titreattribut"],
                     $lettretype["titretaille"]);
         $pdf->SetXY($lettretype["titreleft"],
                   $lettretype["titretop"]);
         $pdf->MultiCell($lettretype["titrelargeur"],
                       $lettretype["titrehauteur"],
                       $titre,
                       $lettretype["titrebordure"],
                       $lettretype["titrealign"],
                       0);
    }
   //****************************************************************************
   // attribut affichage <b> present  dans titre
   }else{
      $pdf->SetY($lettretype["titretop"]);
      $tmptitre="";
      $tmptitre=explode('<b>', $titre);
      //
       for($y=0;$y<sizeof($tmptitre);$y++){
           $pos1="";
           $pos1 = strpos($tmptitre[$y], "</b>");
           //
           if ($pos1 === false) {
             if(trim($tmptitre[$y])!="") {
               $pdf->SetFont($lettretype["titrefont"],$lettretype["titreattribut"],$lettretype["titretaille"]);
               $pdf->SetX($lettretype["titreleft"]);
               $pdf->MultiCell($lettretype["titrelargeur"],$lettretype["titrehauteur"],$tmptitre[$y],$lettretype["titrebordure"],$lettretype["titrealign"],0);
             }
           }else{
               $ctrl_fin_b=0;
               $ctrl_fin_b=substr_count($tmptitre[$y],"</b>");
               $lettretype["titreattribut"] = str_replace("B","",$lettretype["titreattribut"]);
               $lettretype["titreattribut"] = str_replace("b","",$lettretype["titreattribut"]);
                if ($ctrl_fin_b>1){
                   // nbr </b> superieur a 1
                   if(trim($tmptitre[$y])!="") {
                      $pdf->SetFont($lettretype["titrefont"],"B".$lettretype["titreattribut"],$lettretype["titretaille"]);
                      $pdf->SetX($lettretype["titreleft"]);
                      $pdf->MultiCell($lettretype["titrelargeur"],$lettretype["titrehauteur"],$tmptitre[$y],$lettretype["titrebordure"],$lettretype["titrealign"],0);
                   }
                }else{
                   $tmptitre1 = explode("</b>",$tmptitre[$y]);
                   //
                   if(trim($tmptitre1[0])!="") {
                        $pdf->SetFont($lettretype["titrefont"],"B".$lettretype["titreattribut"],$lettretype["titretaille"]);
                        $pdf->SetX($lettretype["titreleft"]);
                       $pdf->MultiCell($lettretype["titrelargeur"],$lettretype["titrehauteur"],$tmptitre1[0],$lettretype["titrebordure"],$lettretype["titrealign"],0);
                   }
                   if(trim($tmptitre1[1])!=""){
                      $pdf->SetFont($lettretype["titrefont"],$lettretype["titreattribut"],$lettretype["titretaille"]);
                      $pdf->SetX($lettretype["titreleft"]);
                      $pdf->MultiCell($lettretype["titrelargeur"],$lettretype["titrehauteur"],$tmptitre1[1],$lettretype["titrebordure"],$lettretype["titrealign"],0);
                   }
                }
              //
           }
       }
   }
   // corps

   $temp = explode("[",$lettretype["corps"]);
   for($i=1;$i<sizeof($temp);$i++){
       $temp1 = explode("]",$temp[$i]);
       $corps=str_replace("[".$temp1[0]."]",$row[$temp1[0]],$corps);
       $temp1[0]="";
   }
   //************************************************
   // traitement attribut affichage <b> dans corps  *
   //              aout 2008                        *
   //************************************************
   $pos="";
   $pos = strpos($corps, "<b>");
   if ($pos === false) {
   // compatibilite :aucun attribut affichage dans corps
   //***************************************************************************
      if(trim($corps)!="") {
        $pdf->SetFont($lettretype["corpsfont"],
                   $lettretype["corpsattribut"],
                   $lettretype["corpstaille"]);
        $pdf->SetXY($lettretype["corpsleft"],
                 $lettretype["corpstop"]);
         $pdf->MultiCell($lettretype["corpslargeur"],
                     $lettretype["corpshauteur"] ,
                     $corps,
                     $lettretype["corpsbordure"],
                     $lettretype["corpsalign"],
                     0);
      }
     //****************************************************************************
     // attribut affichage <b> present  dans corps
    }else{
      $pdf->SetXY($lettretype["corpsleft"],$lettretype["corpstop"]);
      $tmp="";
      $tmp=explode('<b>', $corps);
      //
       for($x=0;$x<sizeof($tmp);$x++){
           $pos1="";
           $pos1 = strpos($tmp[$x], "</b>");
           //
           if ($pos1 === false) {
              if(trim($tmp[$x])!=""){
               $pdf->SetFont($lettretype["corpsfont"],$lettretype["corpsattribut"],$lettretype["corpstaille"]);
               $pdf->write($lettretype["corpshauteur"],$tmp[$x]);
              }
           }else{
               $ctrl_fin_b=0;
               $ctrl_fin_b=substr_count($tmp[$x],"</b>");
               $lettretype["corpsattribut"] = str_replace("B","",$lettretype["corpsattribut"]);
               $lettretype["corpsattribut"] = str_replace("b","",$lettretype["corpsattribut"]);
                if ($ctrl_fin_b>1){
                   // nbr </b> superieur a 1
                   if(trim($tmp[$x])!=""){
                      $pdf->SetFont($lettretype["corpsfont"],"B".$lettretype["corpsattribut"],$lettretype["corpstaille"]);
                      $pdf->write($lettretype["corpshauteur"],$tmp[$x]);
                   }
                }else{
                   $tmp1 = explode("</b>",$tmp[$x]);
                   //
                   if(trim($tmp1[0])!=""){
                      //
                      $nbcar=0;
                      $nbcar=$tmp1[0];
                      if( strlen($nbcar)==1) {
                        // ??????bug fpdf write si affichage 1 seul caractere -> ajout 2 blancs
                        $pdf->SetFont($lettretype["corpsfont"],"B".$lettretype["corpsattribut"],$lettretype["corpstaille"]);
                        $pdf->write($lettretype["corpshauteur"],"  ".$tmp1[0]."  ");
                      }else{
                         $pdf->SetFont($lettretype["corpsfont"],"B".$lettretype["corpsattribut"],$lettretype["corpstaille"]);
                         $pdf->write($lettretype["corpshauteur"],$tmp1[0]);
                      }
                   }
                   if(trim($tmp1[1])!=""){
                      $pdf->SetFont($lettretype["corpsfont"],$lettretype["corpsattribut"],$lettretype["corpstaille"]);
                      $pdf->write($lettretype["corpshauteur"],$tmp1[1]);
                   }
                }
              //
           }
       }
    }
   // fermeture pdf
   $pdf->Output();
}}
$db->disconnect();
if ($DEBUG == 1)
      echo "La base ".$dsn['database']." est déconnectée.<br>";
?>