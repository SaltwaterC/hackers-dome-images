<?php 
//*
//$Id: sousformdyn.php,v 1.4 2008-09-01 06:53:05 jbastide Exp $
/*
$enr objetsf sousformulaire
$enr->sousformulaire dbformdyn.class.php method
      $enteteTab, variable sous formulaire ne sert a rien
      $validation,  = 0 non valide , > 1 valide
      $maj, variable maj = 0 creation, 1 maj, 2 suprimer
      $f -> db, objet base de donnees (dbpear)
      $_POST, valeur des controles du sous form
      $premiersf, premier enregistrement soustabdyn
      $DEBUG, debug
      $idx, idx de sousformdyn
      $idxformulaire, idx de form
      $retourformulaire, form
      $typeformulaire, vide  a quoi cela sert ?
      $objsf,  objet sous formulaire (get)
      $tricolsf colonne de tri tabdyn.php
*/
header('Content-type: text/html; charset=iso-8859-1');
/*
debug
traduction
    droit insufisant
pourquoi ne pas utiliser utils class ?
    methode header specifique pour sousformdyn
traduction droit insufisant
$enteteTab ne sert a rien method entete de formulaire
//  -> pas d'affichage dabs formulairedyn.class.php et formulaire.class.php
//  -> passage en parametre dans
      * form.php :       message erreur "Notice: Undefined variable: enteteTab
        in c:\easyphp1-7\www\openexemple\openmairie_exemple\scr\form.php "
        => declaration $enteteTab  vide
      * dbformdyn.class.php et dbform.class : function formulaire et sousformulaire
*/

// include
include ("../dyn/session.inc");
include("../dyn/var.inc");
//include("../scr/lang.inc")-> utils.class.php;
// variable
$DEBUG = 0;
//$droitTable = '';
// *** variable methode sousformulaire
$enteteTab="";
$typeformulaire="";
//============
// *** GET ***
//============
// objsf
if (isset ($_POST['objsf'])){
   $objsf=$_POST['objsf'];
}else{
   $objsf=0;
}
// table
$table = $objsf;
// premiersf
if (isset ($_POST['premiersf'])){
   $premiersf=$_POST['premiersf'];
}else{
   $premiersf=0;
}
// trisf
if(isset($_POST['trisf'])) 
    $tricolsf=$_POST['trisf'];
else
    $tricolsf="";
// retourformulaire [form return]
if (isset ($_POST['retourformulaire'])){
   $retourformulaire=$_POST['retourformulaire'];
}else{
   $retourformulaire=0;
}
// pear + connexion
require_once ($path_pear."DB.php");
//include ("../dyn/connexion.php");
// Classe utils ()
if (file_exists ("../scr/lang.inc"))
        include ("../scr/lang.inc");
if (file_exists ("../obj/utils.class.php"))
        include ("../obj/utils.class.php");
$f = new utils ();
// objet metier
include ("../obj/".$objsf.".class.php");
// parametrage ===============================================================
//include ("../sql/".$dsn['phptype']."/".$objsf.".form.inc");
// Fichier de parametrage  [files paramters]
if (file_exists ("../sql/".$f -> phptype."/".$objsf.".inc"))
        include ("../sql/".$f -> phptype."/".$objsf.".inc");
//============================================================================
// identifiant enregistrement
// flag maj 0=ajouter 1=modifier 2=detruire
// compatibilite php4
//if (!isset ($table))
//   $table="";
if (isset($_POST['idx'])) {
    $idx=$_POST['idx'];
      if (isset ($_POST['ids'])){
        //$enteteTab = "Table ".$table." Suppression";
        //$ent = $ent."->Suppression ";
        $maj = 2;
      }else{
        //$enteteTab = "Table ".$table." Modification";
        //$ent = $ent."->Modification ";
        $maj = 1;
      }
} else {
   $idx="]";
   if (isset ($_POST['ids'])) {
     //$enteteTab = "Table ".$table." Vidage";
     //$ent = $ent."->Vidage ";
     $maj = 3;
   } else{
     //$enteteTab = "Table ".$table." Ajout";
     //$ent = $ent."->Ajout ";
     $maj = 0;
   }
}
// ====
// POST
// ====
// validation
if (isset ($_POST['validation'])){
   $validation=$_POST['validation'];
}else{
   $validation=0;
}
// idxformulaire
if (isset ($_POST['idxformulaire']))
   $idxformulaire=$_POST['idxformulaire'];
else
   $idxformulaire="";
// dsn
/*
$db=& DB :: connect($dsn, $db_option);
if (DB :: isError($db)) {
    die($db->getMessage());
    }
 else{
    if($DEBUG==1)
    echo "La base ".$dsn['database']." est connect�e.<br>";
 }

$sql =  "SELECT * from collectivite ";
$res = $db->query($sql);
if (DB :: isError($res))
   die($res->getMessage()."erreur ".$sql);
else{
   while ($row=& $res->fetchRow()){
              $ville=$row[0];
              $logo=$row[1];
}}
$res->free();
// variable droit
//$sql =  "SELECT profil from droit where droit= '".$table."'";
// variable droit recuperation depuis droitTable
$sql =  "SELECT profil from droit where droit= '";
// Test du type de base de donnees.
if ($db->dsn['phptype']==='pgsql'){
    $sql = $sql.$droitTable."'";
} else {
    $sql = $sql.$table."'";
}
$droit =$db->getOne($sql);
*/
// utils
$f -> droit ($objsf);
//$f -> titre ($ent);
//$f -> header (1, $ent, $ico, $obj); // fonction specifique
/*if (ereg("->",$ent)) {
$ent=str_replace("->", "<img src='../img/fleche_droite.png' align='middle' hspace='1' border='0'>", $ent);
}*/
echo "<table id='entetesf' border='0'>";
echo "<tr><td align='left'>".$f -> titre ($ent)."<td align='right'></td></tr></table>";

//
echo "<div id='sformulaire'>";
//If ($_SESSION['profil'] >= $droit){
If ($_SESSION['profil'] >= $f->droit){
   $enr = new $objsf($idx, $f -> db,$DEBUG);
   // mode DEBUG message de l'objet metier
   if ($DEBUG == 1)
       echo "Objet metier =><br> ".$enr->msg;
   $validation++;
   $enr->sousformulaire($enteteTab,
                        $validation,
                        $maj,
                        $f -> db,
                        $_POST,
                        $premiersf,
                        $DEBUG,
                        $idx,
                        $idxformulaire,
                        $retourformulaire,
                        $typeformulaire,
                        $objsf,
                        $tricolsf);
   // deconnexion
   $f -> db ->disconnect();
   if ($DEBUG == 1)
      echo "la base ".$dsn['database']." est deconnectee<br>";
}else{
   echo "<div id='msgdroit'>".$f->lang("attention")."&nbsp;".$f->lang("droit").$f->lang("pluriel")."&nbsp;".$f->lang("insuffisant").$f->lang("pluriel")." - ".
        $f->lang("votre_profil_est")." : [".$_SESSION['profil']."]</div>";
}
echo "</div>";
?>