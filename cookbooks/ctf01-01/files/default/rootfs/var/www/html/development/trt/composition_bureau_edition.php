<?php
/**
 * $Id: composition_bureau_edition.php,v 1.5 2008-07-24 14:33:31 jbastide Exp $
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
// GET - POST

if (isset ($_GET['scrutin'])){
   $scrutin=$_GET['scrutin'];
}else{
   $scrutin=0;
}
/**
 * Paramètres
 */
    $obj = "encours";
    $ent="composition_des_bureaux ->".$scrutin;

    $f = new utils ();
    $f -> headerhtml ();
    $f -> collectivite ();
    $f -> droit ($obj);
    $f -> header (1, $ent);
  echo "\n<div id=\"content\">\n";
  echo "<table class='tabCol' >";
  $sql="select bureau,president,president_suppleant,secretaire from composition_bureau where scrutin='".
  $scrutin."' order by bureau";
  $res = $f -> db -> query($sql);
  if (DB :: isError($res))
       die($res->getMessage()."erreur SELECT ".$sql);
  echo "<tr class='tabCol'><td class='tabCol'>".$f -> lang("bureau")."</td><td>".$f -> lang("president")."</td><td>".
        $f -> lang("president")."&nbsp;".$f -> lang("suppleant")."</td><td>".$f -> lang("secretaire")."</td></tr>";
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
        echo "<tr><td class='tabdataplus' align='center'><a class='lien' href=\"../pdf/pdfetat.php?idx=".$scrutin."&obj=composition_bureau&idz=".$row['bureau']."\">No ".$row['bureau']."&nbsp;&nbsp;<img src='../img/ico_pdf_small.png' style='vertical-align:middle' hspace='1' border='0'></a></td><td align='left'>".$row['president']."</td><td align='left'>".
        $row['president_suppleant']."</td><td align='left'>".$row['secretaire']."</td></tr>";
  }
  echo "</table>";
  echo "</div>";

//



    $f -> footer ();
    $f -> deconnexion (); 
    $f -> footerhtml ();
?>