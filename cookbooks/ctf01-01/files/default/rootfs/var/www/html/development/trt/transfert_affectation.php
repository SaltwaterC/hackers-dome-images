<?php
/**
 * $Id: transfert_affectation.php,v 1.4 2008-07-21 14:45:11 jbastide Exp $
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
     $ent="transfert_des_affectations->pour_une_election_et_un_poste";
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
if (isset ($_POST['scrutinsolde'])){
   $scrutinsolde=$_POST['scrutinsolde'];
}else{
   $scrutinsolde=0;
}
if (isset ($_POST['poste'])){
   $poste=$_POST['poste'];
}else{
   $poste=0;
}
if (isset ($_POST['candidat'])){
   $candidat=$_POST['candidat'];
}else{
   $candidat=0;
}

    $f = new utils ();
    $f -> headerhtml ();
    $f -> collectivite ();
    $f -> droit ($obj);
    $f -> header (1, $ent);
    echo "\n<div id=\"content\">\n";
if($validation==0){
  $validation=1;
  echo "<table  class='tabcol' width='100%'>";
  echo "<tr class='tabCol'><td colspan='2'>".$f -> lang("transfert")."&nbsp;".$f -> lang("des")."&nbsp;".$f -> lang("affectation").$f -> lang("pluriel")."</td></tr>";
  echo "<form method=\"POST\" action=\"transfert_affectation.php?validation=".$validation."\" name=f1>";
  // choix scrutin
  $sql="select scrutin,libelle from scrutin where solde ='Oui'";
  $res = $f -> db -> query($sql);
  if (DB :: isError($res))
       die($res->getMessage()."erreur SELECT ".$sql);
  echo "<tr align='center'><td>".$f -> lang("selectionnez")." ".$f -> lang("un")."&nbsp;".$f -> lang("scrutin")." ".$f -> lang("solde")."<br><select name='scrutinsolde' size='1' class='champFormulaire' >";
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
  echo "<option value='".$row['scrutin']."'>".$row['libelle']."</option>";
  }
  echo "</select></td></tr>";
  // choix scrutin
  $sql="select scrutin,libelle from scrutin where solde !='Oui'";
  $res = $f -> db -> query($sql);
  if (DB :: isError($res))
       die($res->getMessage()."erreur SELECT ".$sql);
  echo "<tr align='center'><td>".$f -> lang("selectionnez")." ".$f -> lang("un")."&nbsp;".$f -> lang("scrutin")." ".$f -> lang("encours")."<br><select name='scrutin' size='1' class='champFormulaire' >";
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
  echo "<option value='".$row['scrutin']."'>".$row['libelle']."</option>";
  }
  echo "</select></td></tr>";
  // choix poste
  $sql="select poste,poste from poste where nature ='affectation'";
  $res = $f -> db -> query($sql);
  if (DB :: isError($res))
       die($res->getMessage()."erreur SELECT ".$sql);
  echo "<tr align='center'><td>".$f -> lang("selectionnez")." ".$f -> lang("un")."&nbsp;".$f -> lang("poste")."<br><select name='poste' size='1' class='champFormulaire' >";
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
  echo "<option value='".$row['poste']."'>".$row['poste']."</option>";
  }
  echo "</select></td></tr>";
  // choix candidat
  $sql="select candidat,nom,candidat.scrutin as scrutin from candidat inner join scrutin on candidat.scrutin=scrutin.scrutin where solde ='Oui' order by nom";
  $res = $f -> db -> query($sql);
  if (DB :: isError($res))
       die($res->getMessage()."erreur SELECT ".$sql);
  echo "<tr><td align='center'>".$f -> lang("selectionnez")." ".$f -> lang("un")."&nbsp;".$f -> lang("candidat")."<br><select name='candidat' size='1' class='champFormulaire' >";
  echo "<option value='T'>Tous</option>";
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
    echo "<option value='".$row['nom']."'>".$row['nom']." - ".$row['scrutin']."</option>";
  }
  echo "</select></td></tr>";
  If ($_SESSION['profil'] >= $f -> droit){
     echo "<tr class='tabcol'><td colspan=2><br><center>";
     echo "<input type='submit' value='".$f -> lang("confirmez")." ".$f -> lang("le")."&nbsp;".$f -> lang("transfert")."' style='".$styleBouton."'>";
         echo "<br><br><i>";
     echo $f -> lang("attention")." ".$f -> lang("traitement")."&nbsp;".$f -> lang("non")."&nbsp;".$f -> lang("controle")."&nbsp;,&nbsp;".$f -> lang("decision")."&nbsp;=&nbsp;".$f -> lang("non")."&nbsp !</i>";
  }else
    echo "<tr><td colspan=2><center>Droits insuffisants ou reconnectez-vous.";
  echo "</form>";
  echo "</td></tr>";
  echo "</table>";
}else{
// validation = 1
   echo "<div id='edition'>";
  // verification existence
  echo "<fieldset class='cadre'><legend>".$f -> lang("traitement")."</legend>";
  $sql = "select count(affectation) from affectation where scrutin ='".
  $scrutin."' and poste ='".$poste."' and decision = 'Oui'";
  if($candidat!='T')
      $sql.=" and where candidat='".$candidat."'";
  $nb = $f -> db -> getOne($sql);
  if(!is_numeric($nb)) $nb=0;
  echo "<br><font class='parametre_cle'>&nbsp;&nbsp;".$f -> lang("il_existe")."&nbsp;".$nb." ".$poste.$f -> lang("pluriel")."&nbsp;".$f -> lang("pour")."&nbsp;".$scrutin."&nbsp;".$f -> lang("candidat")."&nbsp".$candidat."&nbsp;".$f -> lang("avec")."&nbsp;".$f -> lang("decision")."&nbsp;=&nbsp;".$f -> lang("oui")."</font><br>";
  // selection
  $sql = "select affectation.elu,bureau,periode,candidat,nom,prenom from affectation inner join elu on elu.elu=affectation.elu where scrutin ='".
  $scrutinsolde."' and affectation.poste ='".$poste."' and decision = 'Oui'";
  if($candidat!='T')
      $sql.=" and candidat='".$candidat."'";
  $res = $f -> db -> query($sql);
  if (DB :: isError($res))
       die($res->getMessage()."erreur SELECT ".$sql);
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
        $affectation = $f -> db -> nextId('affectation');
        $sql="insert into affectation (affectation,scrutin,decision,periode,poste,bureau,candidat,note,elu)
        values('".$affectation."','".$scrutin."','Non','".$row['periode']."','".$poste."','".
        $row['bureau']."','".$row['candidat']."','transfert ".$scrutinsolde.
        "','".$row['elu']."')";
        $res1 = $f -> db -> query($sql);
        if (DB :: isError($res1))
           die($res1->getMessage()."erreur maj ".$sql);
        echo "<br><font class='parametre'>&nbsp;&nbsp;".$row['elu']." ".$row['nom']." ".$row['prenom']."&nbsp;</font>&nbsp;".$row['bureau'].' '.
        $row['periode']."<br>";
  }

  echo "</table>";
  echo "<br></fieldset>";
  echo "</div>";

}
echo "</div>";
//
    $f -> footer ();
    $f -> deconnexion (); 
    $f -> footerhtml ();
?>