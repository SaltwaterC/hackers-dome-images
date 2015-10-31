<?php
//$Id: connexion.php,v 1.1 2007-10-29 17:02:20 fraynaud1 Exp $
if (!isset ($_SESSION['coll']))
  $coll=1; // collectivite par defaut
else
  $coll=$_SESSION['coll'];
// 1 collectivité par base
// $coll est fonction de la grille de connexion
// chaque collectivite peut avoir une base differente
// suivant l'importance de la collectivite
include("base.php");
$ville=$conn[$coll][0];
$dsn=array(
    'phptype'  => $conn[$coll][1],
    'dbsyntax' => $conn[$coll][2],
    'username' => $conn[$coll][3],
    'password' => $conn[$coll][4],
    'protocol' => $conn[$coll][5],
    'hostspec' => $conn[$coll][6],
    'port'     => $conn[$coll][7],
    'socket'   => $conn[$coll][8],
    'database' => $conn[$coll][9]
    );
//$db_option=array();
$db_option=array(
    'debug'=>2,
    'portability'=>DB_PORTABILITY_ALL);
// =================================
// format date suivant base utilisée
// =================================
$formatDate=$conn[$coll][10];
//==========================================================================
?>