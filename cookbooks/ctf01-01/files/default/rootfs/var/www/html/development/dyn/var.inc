<?php
//$Id: var.inc,v 1.9 2008-07-28 09:09:50 jbastide Exp $
// =========================================================================
// Module de paramétrage général
// =========================================================================
//style
include ("varstyle.inc");
// variable collectivite
$sql_collectivite =  "SELECT * from collectivite where id = '0'";
// variable localisation
if (isset($_SESSION['coll'])){
  $chemin_plan="../trs/".$_SESSION['coll']."/";
}
// mode demo *******************************************************************
$demo=1; // login.php mode demo =1 et mode non demo =0
// le mode demo desactive le changement de mot de passe (obj/utils.class.php)
// et met dans login par defaut demo/demo
//
// integration recherche globale dans tableau de bord 1 ou 0 *******************
$global_tdb=1;
// integration recherche globale dans menu haut 1 ou 0 *************************
$global_haut=1;
// integration choix apparence dans tableau de bord ****************************
$look_tdb=1;
// *****************************************************************************
// integration des dependances (pear + fpdf + openmairie)
// $path_xx = "" => mettre les dependances dans php ex wamp/php ou easy/php
// $path_xx = "../php/xx/ => utiliser les dependances du package openCimetiere
// *** dependances dans wamp/php ou easyphp/php
//$path_om="";
//$path_pear= "";
//$path_fpdf="";
//
$path_om="../php/openmairie/";
$path_pear= "../php/pear/";
$path_fpdf="../php/fpdf/";

// *****************************************************************************
$langue="francais"; // francais, anglais, allemand, espagnol
// *****************************************************************************
$verrou=1; // verrou =1 actif 0= inactif (empeche actualisation sur form validé)

// SPECIFIQUE OPENSCRUTIN
$client_cp = '13200';
$client_ville = 'ARLES';
$agent_centralisation="AGENT CENTRALISATION";
?>