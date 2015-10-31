<?php
/**
 * $Id: composition_bureau.php,v 1.6 2008-07-29 14:00:45 jbastide Exp $
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
    $ent="composition_des_bureaux";
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
  echo "<tr class='tabCol'><td class='tabCol'>".$f -> lang("traitement")."&nbsp;".$f -> lang("de")."&nbsp;".$f -> lang("creation")."&nbsp;".$f -> lang("de")."&nbsp;".$f -> lang("composition_des_bureaux")."</td></tr>";
  echo "<form method=\"POST\" action=\"composition_bureau.php?validation=".$validation."\" name=f1>";
  // choix scrutin
  $sql="select scrutin,libelle from scrutin where solde !='Oui'";
  $res = $f -> db -> query($sql);
  if (DB :: isError($res))
       die($res->getMessage()."erreur SELECT ".$sql);
  echo "<tr><td><center><br>".$f -> lang("selectionnez")."&nbsp;".$f -> lang("un")."&nbsp;".$f -> lang("scrutin")." : <select name='scrutin' size='1' class='champFormulaire' >";
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
  echo "<option value='".$row['scrutin']."'>".$row['libelle']."</option>";
  }
  echo "</select></center></td></tr>";
  If ($_SESSION['profil'] >= $f -> droit){
     echo "<tr class='tabcol'><td><br><center>";
     echo "<input type='submit' value='".$f -> lang("confirmation")."&nbsp;".$f -> lang("du")."&nbsp;".$f -> lang("traitement")."&nbsp;".$f -> lang("de")."&nbsp;".$f -> lang("composition_des_bureaux")."' style='".$styleBouton."'>";
     echo "<br>".$f -> lang("lancez")."&nbsp;".$f -> lang("ce")."&nbsp;".$f -> lang("traitement")."&nbsp;"."&nbsp;".$f -> lang("avant")."&nbsp;".$f -> lang("les")."&nbsp;".$f -> lang("edition").$f -> lang("pluriel")."&nbsp;".$f -> lang("çi_dessous")." !<br><br>";
  }else
    echo "<tr><td><center>".$f->lang("attention")."&nbsp;".$f->lang("droit").$f->lang("pluriel")."&nbsp;".$f->lang("insuffisant").$f->lang("pluriel");
  echo "</form>";
  echo "</td></tr>";
  //echo "</table>";
  echo "<tr class='tabCol'><td><b>".$f -> lang("edition")."&nbsp;".$f -> lang("composition_des_bureaux")."</b></td></tr>";
  echo "<form method=\"POST\" action=\"composition_bureau_edition.php\" name=f1>";
  // choix scrutin
  $sql="select scrutin,libelle from scrutin where solde !='Oui'";
  $res = $f -> db -> query($sql);
  if (DB :: isError($res))
       die($res->getMessage()."erreur SELECT ".$sql);
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
  echo "<tr class='tabdata'><td><center><img src='../img/ico_pdf.png' style='vertical-align:middle' hspace='1' border='0'>&nbsp;&nbsp;<a href=\"composition_bureau_edition.php?scrutin=".$row['scrutin']."\">";
  echo $f -> lang("edition")."&nbsp;".$f -> lang("par")."&nbsp;".$f -> lang("bureau")."<br>".$f -> lang("election")."&nbsp;".$row['libelle']."</center></td></tr>";
  }
  echo "</table>";
  echo "</div>";
}else{
// validation = 1
  // vider la table composition_bureau
  echo "<fieldset class='cadre'><legend>  Traitement </legend>";
  $sql = "delete from composition_bureau where scrutin ='".$scrutin."'";
    $res = $f -> db -> query($sql);
    if (DB :: isError($res))
       die($res->getMessage()."erreur effacer table ".$sql);
  echo $f -> lang("enregistrement")."&nbsp;".$f -> lang("table")."\"composition_bureau\" ".$f -> lang("efface")."&nbsp;".$f -> lang("pour")."&nbsp;".$scrutin."<br>";
  $sql=" select canton from scrutin where scrutin ='".$scrutin."'";
  $canton =  $f -> db -> getOne($sql);
  if($canton == 'T')
      $sql="select bureau from  bureau";
  else
      $sql="select bureau from  bureau where canton = '".$canton."'";
  $res = $f -> db -> query($sql);
  if (DB :: isError($res))
       die($res->getMessage()."erreur SELECT ".$sql);
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
        $sql="insert into composition_bureau (bureau, scrutin) values('".$row['bureau']."','".$scrutin."')";
        $res1 = $f -> db -> query($sql);
        if (DB :: isError($res1))
           die($res1->getMessage()."erreur maj ".$sql);
  }
  echo $res->numrows()."&nbsp;".$f -> lang("bureau")."&nbsp;".$f -> lang("cree")."&nbsp;".$f -> lang("pour")."&nbsp;".$scrutin."&nbsp;".$f -> lang("canton")." : ".$canton."<br>";
  // secretaire
  $sql="select nom,prenom,bureau from candidature inner join agent on candidature.agent = agent.agent where scrutin='".
  $scrutin.
  "' and decision ='Oui' and candidature.poste = 'secretaire' and periode !='matin'";
  $res = $f -> db -> query($sql);
  if (DB :: isError($res))
       die($res->getMessage()."erreur SELECT ".$sql);
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
        $sql="update composition_bureau set secretaire='".$row['nom']." ".
        $row['prenom']."'  where bureau='".$row['bureau']."' and scrutin='".
        $scrutin."'";
        $res1 = $f -> db -> query($sql);
        if (DB :: isError($res1))
           die($res1->getMessage()."erreur maj ".$sql);
  }
  echo $res->numrows()." secretaire pour ".$scrutin." canton : ".$canton."<br>";
  // president
  $sql="select nom,prenom,bureau from affectation inner join elu on affectation.elu = elu.elu where scrutin='".
  $scrutin.
  "' and decision ='Oui' and affectation.poste = 'president' ";
  $res = $f -> db -> query($sql);
  if (DB :: isError($res))
       die($res->getMessage()."erreur SELECT ".$sql);
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
        $sql="update composition_bureau set president='".$row['nom']." ".
        $row['prenom']."'  where bureau='".$row['bureau']."' and scrutin='".
        $scrutin."'";
        $res1 = $f -> db -> query($sql);
        if (DB :: isError($res1))
           die($res1->getMessage()."erreur maj ".$sql);
  }
  echo $res->numrows()." president pour ".$scrutin." canton : ".$canton."<br>";

  // president suppleant
  $sql="select nom,prenom,bureau from affectation inner join elu on affectation.elu = elu.elu where scrutin='".
  $scrutin.
  "' and decision ='Oui' and affectation.poste = 'president suppleant' ";
  $res = $f -> db -> query($sql);
  if (DB :: isError($res))
       die($res->getMessage()."erreur SELECT ".$sql);
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
        $sql="update composition_bureau set president_suppleant='".$row['nom']." ".
        $row['prenom']."'  where bureau='".$row['bureau']."' and scrutin='".
        $scrutin."'";
        $res1 = $f -> db -> query($sql);
        if (DB :: isError($res1))
           die($res1->getMessage()."erreur maj ".$sql);
  }
  echo $res->numrows()." president suppleant pour ".$scrutin." canton : ".$canton."<br>";
  echo "<br></fieldset>";
  echo "<fieldset class='cadre'><legend> Composition du bureau </legend>";
  $sql="select bureau,president,president_suppleant,secretaire from composition_bureau where scrutin='".
  $scrutin."' order by bureau";
  $res = $f -> db -> query($sql);
  if (DB :: isError($res))
       die($res->getMessage()."erreur SELECT ".$sql);
  echo "<table class='tabcol'>";
  echo "<tr class='tabcol'><td class='tabcol'>Bureau</td><td>President</td><td>".
        "President suppleant</td><td>secretaire</td><td></tr>";
  while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
        echo "<tr class='tabcol'><td class='tabdataplus' align='center'>No ".$row['bureau']."</td><td>".$row['president']."</td><td>".
        $row['president_suppleant']."</td><td>".$row['secretaire']."</td></tr>";
  }
  echo "</table>";
  echo "<br></fieldset>";
  echo "</div>";
}
//



    $f -> footer ();
    $f -> deconnexion (); 
    $f -> footerhtml ();
?>