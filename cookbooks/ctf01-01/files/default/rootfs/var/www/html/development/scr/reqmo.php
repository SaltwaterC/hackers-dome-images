<?php
// $Id: reqmo.php,v 1.3 2008-07-22 09:13:05 jbastide Exp $
 
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
//
$DEBUG=0;
$ent="reqmo";
$ico="ico_reqmo.png";
// nom de l objet métier
if(isset($_GET['obj']))
    $obj=$_GET['obj'];
else
    $obj="reqmo";  //***
/**
 * Classe utils ()
 */
    $f = new utils ();
    // Fichier de paramétrage
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
 if ($_SESSION ['profil'] >= $f -> droit) {
  $dir=getcwd();
  if (isset($langue)){
      $dir=substr($dir,0,strlen($dir)-4)."/sql/".$f -> phptype."/".$langue."/";
  }else{
      $dir=substr($dir,0,strlen($dir)-4)."/sql/".$f -> phptype."/";
  }
  $dossier = opendir($dir);
  echo "<table><tr>";
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
      if($temp[1]=="reqmo"){
          echo "<a href='../scr/requeteur.php?obj=".$temp[0]."' class='lientable' >";
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