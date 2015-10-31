<?php
/**
 * $Id: convocation_president.php,v 1.4 2008-07-21 13:54:59 jbastide Exp $
 */
/**
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
/**
 * Paramètres
 */
    $obj = "encours";
    $ent="convocation->president";
// GET - POST
if (isset ($_GET['validation'])){
   $validation=$_GET['validation'];
}else{
   $validation=0;
}
if (isset ($_POST['scrutin'])){
   $scrutin=$_POST['scrutin'];
}else{
   $scrutin=0;
}
    $f = new utils ();
    $f -> headerhtml ();
    $f -> collectivite ();
    $f -> droit ($obj);
    $f -> header (1, $ent);
echo "\n<div id=\"content\">\n";
  echo "<table class='tabcol' width='100%'>";
   echo "<tr class='tabCol'><td><b>".$f -> lang("edition")."&nbsp;".$f -> lang("convocation")."&nbsp;".$f -> lang("des")."&nbsp;".$f -> lang("president").$f -> lang("pluriel")."</b></td></tr>";
  // choix scrutin
  $sql="select scrutin,libelle from scrutin where solde !='Oui'";
  $res = $f -> db -> query($sql);
  if (DB :: isError($res))
       die($res->getMessage()."erreur SELECT ".$sql);
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
  echo "<tr class='tabdata' align='center'><td><img src='../img/ico_pdf.png' style='vertical-align:middle' hspace='1' border='0'>&nbsp;&nbsp;<a href=\"../pdf/publipostage.php?idx=".$row['scrutin']."&obj=affectation_p\">".$f -> lang("envoi")."&nbsp;".$f -> lang("lettre")."&nbsp;".$f -> lang("convocation")."<br>".$f -> lang("election")."&nbsp;&nbsp;".$row['libelle']."&nbsp;".$f -> lang("aux")."&nbsp;".$f -> lang("president").$f -> lang("pluriel")."</td></tr>";
  }
  echo "</table>";
  echo "\n</div>\n";
    $f -> footer ();
    $f -> deconnexion (); 
    $f -> footerhtml ();
?>