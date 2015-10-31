<?php
/* $Id: import_script.php,v 1.1 2007-10-29 17:02:21 fraynaud1 Exp $
*/
// =================================================================
include ("../dyn/session.inc");
set_time_limit(3600); // 60 mn
//
require_once "DB.php";
include ("../dyn/connexion.php");
include ("../dyn/var.inc");
// param
$aff="import_script";
// GET ========================================================================
if (isset ($_GET['validation'])){
   $validation=$_GET['validation'];
}else{
   $validation=0;
}
if (isset ($_GET['obj'])){
   $obj=$_GET['obj'];
}else{
   $validation=0;
   $obj='';
}
if ($obj!=''){
  include ("import_".$obj.".inc");
  //$fic="../tmp/".$fic;
}

// connexion
$db=& DB :: connect($dsn, $db_option);
if (DB :: isError($db)) {
    die($db->getMessage()." base adullact (0)");
}
// collectivite
$res = $db->query($sql_collectivite);
if (DB :: isError($res))
   die($res->getMessage()."erreur ".$sql_collectivite);
else{
  while ($row=& $res->fetchRow()){
              $ville=$row[0];
              $logo=$row[1];
}}
    $res->free();
// Présentation html
echo "<html>";
echo"<head>";
include("../dyn/entete.inc");
echo "</head>";
echo "<body>";
echo "<table id='entete' border='0'>";
echo "<tr valign='top'><td align='left'>IMPORT<img src='../img/fleche_droite.png' align='bottom'  border='0'>".$table."</td></tr></table>";
echo "<table id='aide' border='0'><tr><td>";
echo "<a href='javascript:aide()'><img src='../img/ico_import.png' border='0' alt='aide'>";
echo "<img src='../img/ico_aide.png' align='top' hspace='5' border='0' alt='aide'>";
echo "</a></td></tr>";
echo "</table>";
echo "</div>";
echo "<div id='formulaire_non_onglet'>";
?>
<script language="javascript">
    var pfenetre;
    var fenetreouverte=false;
function aide()
{
if(fenetreouverte==true)
       pfenetre.close();
pfenetre=window.open("../doc/import_script.html","Aide","toolbar=no,scrollbars=yes,status=no, width=600,height=400,top=120,left=120");
fenetreouverte=true;
}
</script>
<?php


if($validation==0){
    echo $import;
    echo "<form method='POST' action='import_script.php?obj=".$obj."&validation=1' name='f1' onsubmit='return valider()'>";
    echo "<table class='formentete'>";
    echo "<tr><td>";
    // Upload de fichier
    echo "<input type='text' name='fic1'  size='30' class='champFormulaire'>";
    echo " <a href='javascript:vupload1();'><img src='../img/upload.png' border='0'></a> ";
    echo "<a href='javascript:voir();'><img src='../img/voir.png' border='0' hspace='10'></a><br><br>";
    // Test de validité de droits
    // variable droit
    $sql =  "SELECT profil from droit where droit= '".$obj."'";
    $droit =$db->getOne($sql);
    if ($_SESSION['profil'] >= $droit)
      echo " <input type='submit' value='Transfert ".$obj."' style='".$styleBouton."'> ";
    else
      echo "<br>Droits insuffisants ou reconnectez-vous.";
    echo "</td></tr>";
    echo "</table>";
    echo "</form>";
    ?>
    <script language="javascript">
       var pfenetre;
       var fenetreouverte=false;
    function vupload1()
      {
        if(fenetreouverte==true)
          pfenetre.close();
        var fic=document.getElementById("fic1").value;
        pfenetre=window.open("../spg/upload.php?origine=fic1","Upload","width=300,height=100,top=120,left=120");
        fenetreouverte=true;
    }
    function voir()
    {
     var fichier=document.f1.fic1.value;
     if (fichier == "") {
        alert("Nom du fichier à importé  absent !!");
     }else{
       if(fenetreouverte==true){
         pfenetre.close();
         pfenetre=window.open("../trs/"+<?php echo $_SESSION["coll"]?>+"/"+fichier,"Visualisation","width=700,height=600,top=50,left=50,scrollbars=yes");
         fenetreouverte=true;
       }
     }
    }
    function valider()
    {
    var fic=document.getElementById("fic1").value;
    submitOK="true";
    if (fic=="")
     {
     alert("Nom du fichier à importé  absent !!");
     submitOK="false";
     }
    if (submitOK=="false")
     {
     return false;
     }
    }
    </script>
    <?php
}else{
  if (isset ($_POST['fic1']))
      $fic="../trs/".$_SESSION["coll"]."/".$_POST['fic1'];
  $fichier = fopen($fic, "r");
  $i=0; // compteur
  $msg="";
  $rejet="";
  $db->autoCommit();

  while (!feof($fichier)) {

    $i++; // compteur
    $correct=1;
    $contenu = fgetcsv($fichier, 4096, ";");
    if(sizeof($contenu)>1 and $contenu[0]!=""){    // enregistrement vide (RC à la fin)

        foreach(array_keys($zone) as $champ) {
            if ($zone[$champ]=='') {// valeur par defaut
                $valF[$champ] = ""; // eviter le not null value
                if (!isset($defaut[$champ])) $defaut[$champ]="";
                $valF[$champ]= $defaut[$champ];
            } else {
                $valF[$champ]=$contenu[$zone[$champ]];
            }
            if (!isset($obligatoire[$champ])) $obligatoire[$champ]=0;
            if ($obligatoire[$champ]==1 and $valF[$champ]==""){
               $correct=0;
               $msg=$msg."Enregistrement: ".$i." ".$champ." ".
               $valF[$champ]." vide \n";
            }
            if (!isset($exist[$champ])) $exist[$champ]=0;
            if($exist[$champ]==1){  // test existence de champ
            $sql= "$sql_exist[$champ]".$valF[$champ]."'";
              $temp1=$db->getOne($sql);
              if (!isset($temp1)){
                 $correct=0;
                 $msg=$msg."Enregistrement: ".$i." ".$champ." ".$valF[$champ].
                 " inexistant \n";
              }
           }

        }
        // affichage numero
        echo "<div id='compteur'>";
             echo "Nombre d'Enregistrement(s) : ".$i;
        echo "</div>";
        // debug
        if ($DEBUG==1){ // affichage du detail du transfert
           echo "<br><b>Enregistrement ".$i."</b><br>";
           foreach(array_keys($valF) as $elem)
           echo " - ".$elem." : ".$valF[$elem]."<br>";
        }

        // transfert
        if($verrou==1 and $correct==1){
         if($i!=1 or $ligne1==0){ //1ere ligne *********************************
            if ($id!="")
                  $valF[$id]= $db->nextId($table);
          $res= $db->autoExecute($table,$valF,DB_AUTOQUERY_INSERT);
          if (DB :: isError($res))
               die($res->getMessage()." => echec requete insertion ".
               $table);

          //$enr->ajouterTraitement($valF,$db,$DEBUG);

         }}
        if ($correct==0){
           // constitution de fichier pour le rejet
           $ligne="";
           foreach($contenu as $elem){
               $ligne=$ligne.$elem.";";
           }
           $ligne=substr($ligne,0,strlen($ligne)-1); // un ; en trop
           $rejet=$rejet.$ligne."\n";
        }
    } // enregistrement vide
  } // fin de fichier
  $db->commit() ;
  fclose($fichier); // Fermeture fichier
  // ecriture des fichiers en tmp
  if($fic_erreur==1){
    $fichier = "../trs/".$_SESSION["coll"]."/import_".$obj."_erreur.txt";
    $inf = fopen($fichier,"w");
    $ent= date("d/m/Y   G:i:s").
    "\nNuméro collectivité *** : ".$coll.
    "\nUtilisateur : ".$_SESSION['login']."\n".
    "=========================================="."\n";
    $msg=$ent."\n".$msg ;
    fwrite($inf,$msg);
    fclose($inf);
    echo "<br><a href='javascript:voirErreur();'>Fichier erreur <img src='../img/voir.png' border='0' hspace='10'></a>";

  }
  if($fic_rejet==1){
    $fichier = "../trs/".$_SESSION["coll"]."/import_".$obj."_rejet.txt";
    $inf = fopen($fichier,"w");
    $rejet=substr($rejet,0,strlen($rejet)-1); // un \n en trop
    fwrite($inf,$rejet);
    fclose($inf);
    echo "<br><br><a href='javascript:voirrejet();'>Fichier rejet <img src='../img/voir.png' border='0'></a>";

  }
?>
<script language="javascript">
    function voirErreur()
     {
     var fichier="import_<?php echo $obj?>_erreur.txt";
     if(fenetreouverte==true)
       pfenetre.close();
       pfenetre=window.open("../trs/"+<?php echo $_SESSION["coll"]?>+"/"+fichier,"Visualisation","width=700,height=600,top=50,left=50,scrollbars=yes");
       fenetreouverte=true;
    }
    function voirrejet()
     {
     var fichier="import_<?php echo $obj?>_rejet.txt";
     if(fenetreouverte==true)
       pfenetre.close();
       pfenetre=window.open("../trs/"+<?php echo $_SESSION["coll"]?>+"/"+fichier,"Visualisation","width=700,height=600,top=50,left=50,scrollbars=yes");
       fenetreouverte=true;
    }
    </script>
<?php
}//fin validation
//=======================================================================
$db->disconnect();
if ($DEBUG == 1)
        echo "la base ".$dsn['database']." est déconnectée<br>";
// fin entete HTML
echo "</div>";
include ("../dyn/menu.inc");
echo "</body>";
?>

