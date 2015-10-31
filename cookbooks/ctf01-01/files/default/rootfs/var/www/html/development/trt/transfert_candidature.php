<?php
/**
 * $Id: transfert_candidature.php,v 1.4 2008-07-21 13:54:59 jbastide Exp $
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
    $ent="transfert_de_candidatures->pour_une_election_et_un_poste";
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
    $f = new utils ();
    $f -> headerhtml ();
    $f -> collectivite ();
    $f -> droit ($obj);
    $f -> header (1, $ent);
echo "\n<div id=\"content\">\n";
if($validation==0){
  $validation=1;
  echo "<table class='tabcol' width='100%'>";
  echo "<tr class='tabCol'><td colspan='2'>".$f -> lang("transfert")."&nbsp;".$f -> lang("de")."&nbsp;".$f -> lang("candidature")."</td></tr>";
  echo "<form method=\"POST\" action=\"transfert_candidature.php?validation=".$validation."\" name=f1>";
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
  echo "<tr align='center'><td><br>".$f -> lang("selectionnez")." ".$f -> lang("un")."&nbsp;".$f -> lang("scrutin")." ".$f -> lang("encours")."<br><select name='scrutin' size='1' class='champFormulaire' >";
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
  echo "<option value='".$row['scrutin']."'>".$row['libelle']."</option>";
  }
  echo "</select></td></tr>";
  // choix poste
  $sql="select poste,poste from poste where nature ='candidature'";
  $res = $f -> db -> query($sql);
  if (DB :: isError($res))
       die($res->getMessage()."erreur SELECT ".$sql);
  echo "<tr align='center'><td><br>".$f -> lang("selectionnez")." ".$f -> lang("un")."&nbsp;".$f -> lang("poste")."<br><select name='poste' size='1' class='champFormulaire' >";
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
  echo "<option value='".$row['poste']."'>".$row['poste']."</option>";
  }
  echo "</select><br><br></td></tr>";
  If ($_SESSION['profil'] >= $f -> droit){
     echo "<tr class='tabcol'><td colspan=2><center>";
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
  $sql = "select count(candidature) from candidature where scrutin ='".
  $scrutin."' and poste ='".$poste."' and decision = 'Oui'";
  $nb = $f -> db -> getOne($sql);
  echo "<br><font class='parametre_cle'>&nbsp;&nbsp;".$f -> lang("il_existe")."&nbsp;".$nb." ".$poste.$f -> lang("pluriel")."&nbsp;".$f -> lang("pour")."&nbsp;".$scrutin."&nbsp;".$f -> lang("avec")."&nbsp;".$f -> lang("decision")."&nbsp;=&nbsp;".$f -> lang("oui")."</font><br><br>";
  // selection
  $sql = "select bureau,recuperation,periode,candidature.agent,nom,prenom from candidature inner join agent on agent.agent=candidature.agent where scrutin ='".
  $scrutinsolde."' and candidature.poste ='".$poste."' and decision = 'Oui'";
  $res = $f -> db -> query($sql);
  if (DB :: isError($res))
       die($res->getMessage()."erreur SELECT ".$sql);
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
        $candidature = $f -> db -> nextId('candidature');
        $sql="insert into candidature (candidature,scrutin,decision,periode,poste,bureau,recuperation,note,agent)
        values('".$candidature."','".$scrutin."','Non','".$row['periode']."','".$poste."','".
        $row['bureau']."','".$row['recuperation']."','transfert ".$scrutinsolde.
        "','".$row['agent']."')";
        $res1 = $f -> db -> query($sql);
        if (DB :: isError($res1))
           die($res1->getMessage()."erreur maj ".$sql);
         echo "<br><font class='parametre'>&nbsp;&nbsp;".$row['agent']." ".$row['nom']." ".$row['prenom']."</font>&nbsp;".$row['bureau'].' '.$row['periode']."<br>";
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