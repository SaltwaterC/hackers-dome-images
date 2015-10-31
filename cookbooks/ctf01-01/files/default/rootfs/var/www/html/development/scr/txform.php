<?php 
// $Id: txform.php,v 1.2 2008-07-17 09:44:14 jbastide Exp $
/*
* Fichiers requis
*/
    if (file_exists ("../dyn/session.inc"))
        include ("../dyn/session.inc");
    if (file_exists ("../dyn/var.inc"))
        include ("../dyn/var.inc");
     if (file_exists ("../scr/lang.inc"))
        include ("../scr/lang.inc");
    if (file_exists ("../obj/utils.class.php"))
        include ("../obj/utils.class.php");
//*
// nom de l objet métier =====================================================
if(isset($_GET['obj']))
    $obj=$_GET['obj'];
else
      $obj="";
$DEBUG=0;
// identifiant enregistrement
// flag maj 0=ajouter 1=modifier 2=detruire

if (isset($_GET['idx'])) {
    $idx=$_GET['idx'];
} else {
    $idx=$_POST['idx'];
}

// validation
if (isset ($_GET['validation'])){
   $validation=$_GET['validation'];
}else{
   $validation=0;
}
if (isset ($_GET['maj'])){
   $maj=$_GET['maj'];
}else{
   $maj=1;
}

// librairies utilisée(s) ====================================================
require_once ($path_om."om_".$obj.".class.php");
// paramètres
$ent="texte ->".$obj." -> ".$idx;
$ico="ico_parametrage.png";
$premier=0;
$recherche="";
$DEBUG=0;
//
/**
 * Classe utils ()
 */
    $f = new utils ();
    // Fichier de paramétrage
    if (isset($langue)){
        if (file_exists ("../sql/".$f -> phptype."/".$langue."/".$obj.".inc"))
           include ("../sql/".$f -> phptype."/".$langue."/".$obj.".inc");
    }else{
         if (file_exists ("../sql/".$f -> phptype."/".$obj.".inc"))
           include ("../sql/".$f -> phptype."/".$obj.".inc");
    }
    $f -> headerhtml ();
    $f -> collectivite ();
    $f -> droit ($obj);
    $f -> header (1, $ent, $ico, $obj);

echo "\n<div id=\"content\">\n";
   $enr = new $obj($idx,$DEBUG,$maj);
   // mode debug message de l'objet métier
   if ($DEBUG == 1)
       echo "Objet métier =><br> ".$enr->msg;
   $validation++;
   $enr->formulaire($validation, $maj, $f -> db, $HTTP_POST_VARS,$obj, $DEBUG,$idx);
   $f -> db->disconnect();
   if ($DEBUG == 1)
      echo "La base ".$dsn['database']." est déconnectée.<br>";
//}else
//    echo "Droits insuffisants ou reconnectez-vous.";
echo "\n</div>\n\n";

/**
 * 
 */
    $f -> footer ();
    $f -> deconnexion (); 
    $f -> footerhtml ();
?>