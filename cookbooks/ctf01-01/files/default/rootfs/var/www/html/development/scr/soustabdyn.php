<?php
// $Id: soustabdyn.php,v 1.5 2008-07-22 09:13:05 jbastide Exp $
/*
$objsf  : objet sous formulaire

*/
/* debug
- utiliser utils.class -> fait
*/
// gestion des accents 1.08
header('Content-type: text/html; charset=iso-8859-1');
include ("../dyn/session.inc");
include("../dyn/var.inc");
//include("../scr/lang.inc")->utils.class.php;
//require_once "DB.php";
require_once ($path_pear."DB.php");
//include ("../dyn/connexion.php");
// Classe utils ()
if (file_exists ("../scr/lang.inc"))
    include ("../scr/lang.inc");
if (file_exists ("../obj/utils.class.php"))
        include ("../obj/utils.class.php");
$f = new utils ();
//
if(isset($_GET['recherche']))//Ajout
  $recherche=$_GET['recherche'];
if(isset($_GET['objsf'])){//Ajout
  $objsf=$_GET['objsf'];
}
if(isset($_GET['obj']))
  $obj=$_GET['obj'];
if(isset($_GET['idx']))
  $idx=$_GET['idx'];
if(isset($_GET['premiersf']))
    $premiersf=$_GET['premiersf'];
else
    $premiersf=0;
if(isset($_GET['trisf'])) //ajout fred
    $tricolsf=$_GET['trisf'];
else
    $tricolsf="";

$hiddenid=0;
$deleteall=0;
//include ("../sql/".$dsn['phptype']."/".$objsf.".inc");
// Fichier de parametrage  [files paramters]
if (file_exists ("../sql/".$f -> phptype."/".$objsf.".inc"))
        include ("../sql/".$f -> phptype."/".$objsf.".inc");
//dsn  ======================================================================
/*
$db=& DB :: connect($dsn, $db_option);
if (DB :: isError($db)) {
    die($db->getMessage());
    }
 else{
    if($DEBUG==1)
    echo "La base ".$dsn['database']." est connectee.<br>";
 }       //   fin ajout
*/
// ===============================
// modification gestion des quotes
if(isset($_POST['recherche'])){
       $recherche=$_POST['recherche'];
       if (get_magic_quotes_gpc()) // magic_quotes_gpc = on
          $recherche1= StripSlashes($recherche);
       else
          $recherche1= $recherche;
}else
    if(isset($_GET['recherche'])){
        $recherche=$_GET['recherche'];
        if (get_magic_quotes_gpc()) // magic_quotes_gpc = on
          $recherche1= StripSlashes($recherche);
        else
          $recherche1= $recherche;
    }else{
        $recherche="";
        $recherche1="";
    }

// librairie utilisee  =========================================================

    // variable droit
    /*
    $sql =  "SELECT profil from droit where droit= '".$obj."'";
    $droit =$db->getOne($sql);
    */
    $f -> droit ($obj);
    //
If ($_SESSION['profil'] >=  $f->droit){
    if(!isset($href) or $href==array()){

        $href[0]['lien']= "idxformulaire=".$idx;
        $href[0]['id']= "&objsf=".$objsf."&premiersf=".$premiersf."&retourformulaire=".$obj."&trisf=".$tricolsf;
        $href[0]['lib']= "<img src=../img/ajouter.gif border=0>";

        $href[1]['lien'] = "idx=";
        $href[1]['id']= "&objsf=".$objsf."&premiersf=".$premiersf."&retourformulaire=".$obj."&idxformulaire=".$idx."&trisf=".$tricolsf;
        $href[1]['lib']= "";

        $href[2]['lien'] = "idx=";
        $href[2]['id']= "&ids=1&objsf=".$objsf."&premiersf=".$premiersf."&retourformulaire=".$obj."&idxformulaire=".$idx."&trisf=".$tricolsf;
        $href[2]['lib']= "<img src='../img/supprimer.gif' border=0>";

        $href[2]['toutsup']= "ids=2&objsf=".$objsf."&premiersf=".$premiersf."&retourformulaire=".$obj."&idxformulaire=".$idx."&trisf=".$tricolsf;
      }
//*
      }else{
       $href[0]['lien']= "#";
       $href[0]['id']= "";
       $href[0]['lib']= "";
       $href[1]['lien'] = "";
       $href[1]['id']= "";
       $href[1]['lib']= "";
       $href[2]['lien'] = "#";
       $href[2]['id']= "";
       $href[2]['lib']= "";
    }


/**/      include ($path_om."tabdyn.class.php");    //ajout

//==============================================================================
    if ($_SESSION['profil']>0){
      if (isset($ongletun)) {
         if ($ongletun!=$objsf){
           $tb= new tab($obj,
                        $table,
                        $serie,
                        $champAffiche,
                        $champRecherche,
                        $tri,
                        $tricolsf,
                        $selection);
           $tb->afficheronglet($premiersf,
                               $recherche,
                               $href,
                               $f -> db,
                               $DEBUG,
                               $hiddenid,
                               $deleteall);
         }
      }else{
           $tb= new tab($obj,
                        $table,
                        $serie,
                        $champAffiche,
                        $champRecherche,
                        $tri,
                        $tricolsf,
                        $selection);
           $tb->afficheronglet($premiersf,
                               $recherche,
                               $href,
                               $f -> db,
                               $DEBUG,
                               $hiddenid,
                               $deleteall);
      }
    }else {
        echo "<div id='msgdroit'>".$f->lang("attention")."&nbsp;".$f->lang("droit").$f->lang("pluriel")."&nbsp;".$f->lang("insuffisant").$f->lang("pluriel")." - ".
        $f->lang("votre_profil_est")." : [".$_SESSION['profil']."]</div>";
    }
//==============================================================================
// deconnexion
$f -> db ->disconnect();
?>