<?php
// $Id: txtab.php,v 1.3 2008-07-22 09:13:05 jbastide Exp $
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
 * Param�tres
 */
  $ent="lettretype";
  $ico="ico_parametrage.png";
//*
$DEBUG=0;
// nom de l objet m�tier
if(isset($_GET['obj']))
    $obj=$_GET['obj'];
else
    $obj="";  //***

/**
 * Classe utils ()
 */
    $f = new utils ();
    // Fichier de param�trage
    if (isset($langue)){
        if (file_exists ("../sql/".$f -> phptype."/".$langue."/".$obj.".inc"))
           include ("../sql/".$f -> phptype."/".$langue."/".$obj.".inc");
    }else{
         if (file_exists ("../sql/".$f -> phptype."/".$obj.".inc"))
           include ("../sql/".$f -> phptype."/".$obj.".inc");
    }
    $f -> headerhtml ();
    $f -> collectivite ();
    $f -> droit ($obj);
    $f -> header (1, $ent, $ico, $obj);

echo "\n<div id=\"content\">\n";
//
If ($_SESSION['profil'] >=  $f -> droit){
  $dir=getcwd();
  if (isset($langue)){
      $dir=substr($dir,0,strlen($dir)-4)."/sql/".$f -> phptype."/".$langue."/";
  }else{
      $dir=substr($dir,0,strlen($dir)-4)."/sql/".$f -> phptype."/";
  }
  $dossier = opendir($dir);
  // ajouter
  echo "<FORM action='../scr/txform.php?obj=".$obj."&maj=0' method=POST id=f1 name=f1>";
  echo "<table class='tabEntete' border='0'>";
  echo "<tr><td> ";
  echo "<input type='text' name='idx' value='' class='champFormulaire' >";
  echo " <input type='submit' name='s1' value='".$f->lang("ajoute")."&nbsp;".$f->lang($obj)."' style=".$styleBouton."' ></td></tr></table></form>";
  echo "<table class='tabdoc'><tr>";
  $col=0;

  while ($entree = readdir($dossier))
  {
    if ($entree == "." || $entree ==".."){
       continue;
    }else{
    $temp = explode(".",$entree);
    if(!isset($temp[1])) $temp[1]="";
    if($temp[1]=="inc") $temp[1]="tab";
    if($temp[1]==$obj){
      $col=$col+1;
      echo "<td>";
      echo "<img src='../img/ico_fleche.png' align='top' hspace='5' vspace='0' border='0'>";
      //*
      if($temp[1]=="lettretype"){
          echo "<a href='../scr/txform.php?obj=".$temp[1]."&idx=".$temp[0]."&maj=1' class='lientable' >";
          echo $temp[0]." (".$temp[1].")</a></td>";
      }
      if($temp[1]=="sousetat"){
          echo "<a href='../scr/txform.php?obj=".$temp[1]."&idx=".$temp[0]."&maj=1' class='lientable' >";
          echo $temp[0]." (".$temp[1].")</a></td>";
      }
      if($temp[1]=="etat"){
          echo "<a href='../scr/txform.php?obj=".$temp[1]."&idx=".$temp[0]."&maj=1' class='lientable' >";
          echo $temp[0]." (".$temp[1].")</a></td>";
      }

      if ($col==3){
         echo "</tr><tr>";
         $col=0;
      }
    }
  }}
  echo "</tr></table>";
  closedir($dossier);
}else{
        echo "<div id='msgdroit'>".$f->lang("attention")."&nbsp;".$f->lang("droit").$f->lang("pluriel")."&nbsp;".$f->lang("insuffisant").$f->lang("pluriel")." - ".
        $f->lang("votre_profil_est")." : [".$_SESSION['profil']."]</div>";
}
echo "\n</div>\n\n";

/**
 * 
 */
    $f -> footer ();
    $f -> deconnexion (); 
    $f -> footerhtml ();
?>