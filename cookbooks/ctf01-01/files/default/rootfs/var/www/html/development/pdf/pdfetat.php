<?php
//$Id: pdfetat.php,v 1.5 2008-09-22 09:08:01 jbastide Exp $
session_name('openscrutin');
session_start();
//include ("../dyn/session.inc");
set_time_limit(180);
include("../dyn/var.inc");
// classe fpdf
define('FPDF_FONTPATH','font/');
require($path_om.'fpdf_etat.php');
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
   }
}
$res->free();
if(isset($_GET['idx']))
    $idx=$_GET['idx'];
else
    $idx="";
if(isset($_GET['obj']))
    $obj=$_GET['obj'];
else
    $obj="";

if (isset($langue)){
     if (file_exists("../sql/".$dsn['phptype']."/".$langue."/".$obj.".etat.inc"))
        include ("../sql/".$dsn['phptype']."/".$langue."/".$obj.".etat.inc");
}else{
     if(file_exists ("../sql/".$dsn['phptype']."/".$obj.".etat.inc"))
       include ("../sql/".$dsn['phptype']."/".$obj.".etat.inc");
}
// INSTANCE PDF            =====================================
// orientation P= portrait L=paysage
// unite mm (milimetre)
// format A4 A3
// =============================================================
$unite="mm";
$pdf=new PDF($etat["orientation"],$unite,$etat["format"]);
//
$pdf->footerfont=$etat["footerfont"];
$pdf->footertaille=$etat["footertaille"];
$pdf->footerattribut=$etat["footerattribut"];
$pdf->SetMargins($etat['se_margeleft'],$etat['se_margetop'],$etat['se_margeright']); //marge gauche,haut,droite par defaut 10mm
$pdf->SetDisplayMode('real','single');
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
$temp="../trs/".$_SESSION['coll']."/".$etat['logo'];
$pdf->Image($temp,
            $etat["logoleft"],
            $etat["logotop"],
            0,
            0,
            '',
            '');
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
   //
   //___________________________________________________________________________
   // titre                                                                   //
   //___________________________________________________________________________
   //
   $temp = explode("[",$etat["titre"]);
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
    }
  //****************************************************************************
  // attribut affichage <b> present  dans titre
  }else{
      $pdf->SetY($etat["titretop"]);
      $tmptitre="";
      $tmptitre=explode('<b>', $titre);
      //
       for($y=0;$y<sizeof($tmptitre);$y++){
           $pos1="";
           $pos1 = strpos($tmptitre[$y], "</b>");
           //
           if ($pos1 === false) {
             if(trim($tmptitre[$y])!="") {
               $pdf->SetFont($etat["titrefont"],$etat["titreattribut"],$etat["titretaille"]);
               $pdf->SetX($etat["titreleft"]);
               $pdf->MultiCell($etat["titrelargeur"],$etat["titrehauteur"],$tmptitre[$y],$etat["titrebordure"],$etat["titrealign"],0);
             }
           }else{
               $ctrl_fin_b=0;
               $ctrl_fin_b=substr_count($tmptitre[$y],"</b>");
               $etat["titreattribut"] = str_replace("B","",$etat["titreattribut"]);
               $etat["titreattribut"] = str_replace("b","",$etat["titreattribut"]);
                if ($ctrl_fin_b>1){
                   // nbr </b> superieur a 1
                   if(trim($tmptitre[$y])!="") {
                      $pdf->SetFont($etat["titrefont"],"B".$etat["titreattribut"],$etat["titretaille"]);
                      $pdf->SetX($etat["titreleft"]);
                      $pdf->MultiCell($etat["titrelargeur"],$etat["titrehauteur"],$tmptitre[$y],$etat["titrebordure"],$etat["titrealign"],0);
                   }
                }else{
                   $tmptitre1 = explode("</b>",$tmptitre[$y]);
                   //
                   if(trim($tmptitre1[0])!="") {
                        $pdf->SetFont($etat["titrefont"],"B".$etat["titreattribut"],$etat["titretaille"]);
                        $pdf->SetX($etat["titreleft"]);
                       $pdf->MultiCell($etat["titrelargeur"],$etat["titrehauteur"],$tmptitre1[0],$etat["titrebordure"],$etat["titrealign"],0);
                   }
                   if(trim($tmptitre1[1])!=""){
                      $pdf->SetFont($etat["titrefont"],$etat["titreattribut"],$etat["titretaille"]);
                      $pdf->SetX($etat["titreleft"]);
                      $pdf->MultiCell($etat["titrelargeur"],$etat["titrehauteur"],$tmptitre1[1],$etat["titrebordure"],$etat["titrealign"],0);
                   }
                }
              //
           }
       }
  }
  //
  //____________________________________________________________________________
  // corps                                                                    //
  //____________________________________________________________________________
   $temp = explode("[",$etat["corps"]);
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
      }
  //****************************************************************************
  // attribut affichage <b> present  dans corps
  }else{
      $pdf->SetXY($etat["corpsleft"],$etat["corpstop"]);
      $tmp="";
      $tmp=explode('<b>', $corps);
      //
       for($x=0;$x<sizeof($tmp);$x++){
           $pos1="";
           $pos1 = strpos($tmp[$x], "</b>");
           //
           if ($pos1 === false) {
              if(trim($tmp[$x])!=""){
               $pdf->SetFont($etat["corpsfont"],$etat["corpsattribut"],$etat["corpstaille"]);
               $pdf->write($etat["corpshauteur"],$tmp[$x]);
              }
           }else{
               $ctrl_fin_b=0;
               $ctrl_fin_b=substr_count($tmp[$x],"</b>");
               $etat["corpsattribut"] = str_replace("B","",$etat["corpsattribut"]);
               $etat["corpsattribut"] = str_replace("b","",$etat["corpsattribut"]);
                if ($ctrl_fin_b>1){
                   // nbr </b> superieur a 1
                   if(trim($tmp[$x])!=""){
                      $pdf->SetFont($etat["corpsfont"],"B".$etat["corpsattribut"],$etat["corpstaille"]);
                      $pdf->write($etat["corpshauteur"],$tmp[$x]);
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
                        $pdf->SetFont($etat["corpsfont"],"B".$etat["corpsattribut"],$etat["corpstaille"]);
                        $pdf->write($etat["corpshauteur"],"  ".$tmp1[0]."  ");
                      }else{
                         $pdf->SetFont($etat["corpsfont"],"B".$etat["corpsattribut"],$etat["corpstaille"]);
                         $pdf->write($etat["corpshauteur"],$tmp1[0]);
                      }
                   }
                   if(trim($tmp1[1])!=""){
                      $pdf->SetFont($etat["corpsfont"],$etat["corpsattribut"],$etat["corpstaille"]);
                      $pdf->write($etat["corpshauteur"],$tmp1[1]);
                   }
                }
              //
           }
       }
  }// fin attribut affichage
  //****************************************************************************
}}
// affichage des sous etats

if($etat['sousetat']!="") {
foreach($etat['sousetat'] as $elem){
if (isset($langue)){
  if (file_exists("../sql/".$dsn['phptype']."/".$langue."/".$elem.".sousetat.inc"))
     include ("../sql/".$dsn['phptype']."/".$langue."/".$elem.".sousetat.inc");
}else{
  if (file_exists("../sql/".$dsn['phptype']."/".$elem.".sousetat.inc"))
     include ("../sql/".$dsn['phptype']."/".$elem.".sousetat.inc");
}
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
$pdf->Output();


$db->disconnect();
if ($DEBUG == 1)
      echo "La base ".$dsn['database']." est déconnectée.<br>";
?>