<?php 
//*
//$Id: sousform.php,v 1.4 2008-07-22 09:13:05 jbastide Exp $
include ("../dyn/session.inc");
// déclaration de des droits sur les tables
$droitTable = '';
//========================================
// compatibilite version openmairie < 1.11
//========================================
if (isset ($_GET['objsf'])){
   $objsf=$_GET['objsf'];
}else{
  if (isset ($_GET['obj'])){
     $objsf=$_GET['obj'];
  }else{
  $objsf=0;
}}
// ========================================
// premier du sous formulaire
// ========================================
if (isset ($_GET['premiersf'])){
   $premiersf=$_GET['premiersf'];
}else{
   $premiersf=0;
}
if (isset ($_GET['retourformulaire'])){
   $retourformulaire=$_GET['retourformulaire'];
}else{
   $retourformulaire=0;
}
$typeformulaire="";
// librairies utilisée(s) ===================================================
if (file_exists ("../dyn/var.inc"))
    include ("../dyn/var.inc");
require_once ($path_pear."DB.php");
include ("../dyn/connexion.php");
// objet metier
include ("../obj/".$objsf.".class.php");
// Paramétrage ===============================================================
$DEBUG = 0;
$table = $objsf;
$aff = $objsf.".form.php";
//============================================================================
// identifiant enregistrement
// flag maj 0=ajouter 1=modifier 2=detruire
if (!isset ($table)) // compatibilité php4
   $table="";
if (isset($_GET['idx'])) {
    $idx=$_GET['idx'];
      if (isset ($_GET['ids'])){
        $enteteTab = "Table ".$table." Suppression";
        $maj = 2;
      }else{
        $enteteTab = "Table ".$table." Modification";
        $maj = 1;
      }
} else {
   if (isset($_GET['maj'])) {
     $maj=$_GET['maj'];
     $idx="]";
     $enteteTab = "Table ".$table." Validation";
   } else{
    $idx="]";
    $enteteTab = "Table ".$table." Ajout";
    $maj = 0;
    }
}
// validation
if (isset ($_GET['validation'])){
   $validation=$_GET['validation'];
}else{
   $validation=0;
}
// lien avec article
if (isset ($_GET['idxformulaire']))
   $idxformulaire=$_GET['idxformulaire'];
else
   $idxformulaire="";
//dsn  ======================================================================
$db=& DB :: connect($dsn, $db_option);
if (DB :: isError($db)) {
    die($db->getMessage());
    }
 else{
    if($DEBUG==1)
    echo "La base ".$dsn['database']." est connectée.<br>";
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
// variable droit récupération depuis droitTable
$sql =  "SELECT profil from droit where droit= '";
// Test du type de base de donnees.
if ($db->dsn['phptype']==='pgsql'){
    $sql = $sql.$droitTable."'";
} else {
    $sql = $sql.$table."'";
}
$droit =$db->getOne($sql);
//*
// entete et charte HTML =====================================================
echo "<HTML>";
include("../dyn/var.inc");
//*
// entete et charte HTML
include ("../sql/".$dsn['phptype']."/".$objsf.".form.inc");
echo"<HEAD>";
include("../dyn/entete.inc");
echo "<body>";
echo "<div>";
// * custom *
    $tmp='';
    $tmp = strrchr($ico, '/');
    if (!isset($tmp))
       $tmp=substr($tmp,1,(strlen($tmp)-1));
    else
        $tmp=$ico;
       $ico = "../img/".$tmp;
    if (ereg("->",$ent)) {
       $ent=str_replace("->", "<img src='../img/fleche_droite.png' align='middle' hspace='1' border='0'>", $ent);
    }
// * *
echo "<table id='entete' border='0'>";
echo "<tr valign='top'><td align='left'>".$ent."<td align='right'></td></tr></table>";
echo "<table id='aide' border='0'><tr><td>";
echo "<a href='javascript:aide()'><img src='".$ico."' border='0' alt='aide'>";
echo "<img src='../img/ico_aide.png' align='top' hspace='5' border='0' alt='aide'>";
//*
echo "</a></td></tr>";
echo "</table>";
echo "</div>";
?>
<script language="javascript">
    var pfenetre;
    var fenetreouverte=false;
function aide()
{
if(fenetreouverte==true)
       pfenetre.close();
pfenetre=window.open("../doc/<?php echo $objsf?>.html","Aide"," toolbar=no,scrollbars=yes,status=no,width=600,height=400,top=120,left=120");
fenetreouverte=true;
}
</script>
<?php
echo "<div id='formulaire1'>";
// ===========================================================================
// objet metier
If ($_SESSION['profil'] >= $droit){
   $enr = new $objsf($idx,$db,$DEBUG);
   // mode DEBUG message de l'objet métier
   if ($DEBUG == 1)
       echo "Objet métier =><br> ".$enr->msg;
   $validation++;
   $enr->sousformulaire($enteteTab, $validation, $maj, $db, $_POST,$premiersf, $DEBUG,$idx,$idxformulaire,$retourformulaire,$typeformulaire,$objsf);
   // deconnexion
   $db->disconnect();
   if ($DEBUG == 1)
      echo "la base ".$dsn['database']." est déconnectée<br>";
}else {
        echo "<div id='msgdroit'>".$f->lang("attention")."&nbsp;".$f->lang("droit").$f->lang("pluriel")."&nbsp;".$f->lang("insuffisant").$f->lang("pluriel")." - ".
        $f->lang("votre_profil_est")." : [".$_SESSION['profil']."]</div>";
}
 // *
echo "</div>";
include ("../dyn/menu.inc");
echo "</body></HTML>";
?>