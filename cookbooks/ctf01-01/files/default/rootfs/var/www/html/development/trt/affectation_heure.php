<?php
/**
 * $Id: affectation_heure.php,v 1.7 2008-07-21 13:54:59 jbastide Exp $
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
    $ent="affectation_automatique_des_heures";
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
if($validation==0){
  $validation=1;
  echo "<table class='tabcol' width='100%'>";
  echo "<tr class='tabCol'><td colspan='2'>".$f -> lang("affectation_automatique_des_heures")."&nbsp;-&nbsp;".$f -> lang("table")."&nbsp;\"periode\"</td></tr>";
  echo "<form method=\"POST\" action=\"affectation_heure.php?validation=".$validation."\" name=f1>";
  // choix scrutin
  $sql="select scrutin,libelle from scrutin where solde !='Oui'";
  $res = $f -> db -> query($sql);
  if (DB :: isError($res))
       die($res->getMessage()."erreur SELECT ".$sql);
  echo "<tr><td><center><br>Selectionner un scrutin :<select name='scrutin' size='1' class='champFormulaire' >";
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
  echo "<option value='".$row['scrutin']."'>".$row['libelle']."</option>";
  }
  echo "</select> </center><br></td></tr>";
  If ($_SESSION['profil'] >= $f -> droit){
     echo "<tr class='tabcol'><td colspan=2><br><center>";
     echo "<input type='submit' value='".$f -> lang("confirmation")."&nbsp;".$f -> lang("de")."&nbsp;".$f -> lang("l_")."&nbsp;".$f -> lang("affectation_automatique_des_heures")."' style='".$styleBouton."'>";
     echo "<br>".$f -> lang("attention")."&nbsp;".$f -> lang("toute").$f -> lang("pluriel")."&nbsp;".$f -> lang("les")."&nbsp;".$f -> lang("saisie").$f -> lang("pluriel")."&nbsp;".$f -> lang("seront_ecrasees")." !";
  }else
    echo "<tr><td colspan=2><center>Droits insuffisants ou reconnectez-vous.";
  echo "</form>";
  echo "</td></tr></table>";
}else{
// validation = 1
   echo "<div id='edition'>";
  $sql="select candidature,periode,debut,fin,nom,prenom from candidature inner join agent on agent.agent=candidature.agent where scrutin='".
  $scrutin."' and decision ='Oui' order by nom";
  $res = $f -> db -> query($sql);
  echo "<fieldset class='cadre'><legend>".$f -> lang("candidature").$f -> lang("pluriel")."&nbsp;".$f -> lang("concernee").$f -> lang("pluriel")."</legend>";
  if (DB :: isError($res))
       die($res->getMessage()."erreur SELECT ".$sql);
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
        $sql = "select debut from periode where periode ='".$row['periode']."'";
        $debut = $f -> db -> getOne($sql);
        //if(is_object($debut)) $debut='00:00';
        $sql = "select fin from periode where periode ='".$row['periode']."'";
        $fin = $f -> db -> getOne($sql);
        echo "<br><font class='parametre'>&nbsp;&nbsp;".$row['candidature']."&nbsp;&nbsp;".$row['nom']."&nbsp;&nbsp".$row['prenom']."&nbsp;&nbsp;</font>&nbsp;&nbsp;".$row['periode']."&nbsp;&nbsp;&nbsp;&nbsp;".$f -> lang("debut")." : ".$debut."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$f -> lang("fin")." : ".$fin."<br>";
        $sql="update candidature set debut='".$debut."', fin = '".$fin.
        "'  where candidature=".$row['candidature'];
        $res1 = $f -> db -> query($sql);
        if (DB :: isError($res1))
           die($res1->getMessage()."erreur maj ".$sql);
  }
  echo "<br></fieldset>";
  echo "<fieldset class='cadre'><legend>".$f -> lang("affectation")."&nbsp;".$f -> lang("heure").$f -> lang("pluriel")."</legend>";
  echo "<font class='parametre_cle'>".$f -> lang("affectation")."&nbsp;".$f -> lang("heure").$f -> lang("pluriel")."&nbsp;".$f -> lang("effectuee")." !</font>";
  echo "<br></fieldset>";
  echo "</div>";
}
echo "</div>";
    $f -> footer ();
    $f -> deconnexion (); 
    $f -> footerhtml ();
?>