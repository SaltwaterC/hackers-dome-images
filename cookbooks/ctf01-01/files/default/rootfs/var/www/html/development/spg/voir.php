<?php   
// $Id: voir.php,v 1.5 2008-09-22 09:08:01 jbastide Exp $
     if (file_exists ("../dyn/session.inc"))
        include ("../dyn/session.inc");
    if (file_exists ("../dyn/var.inc"))
        include ("../dyn/var.inc");
    if (file_exists ("../scr/lang.inc"))
        include ("../scr/lang.inc");
    if (file_exists ("../obj/utils.class.php"))
        include ("../obj/utils.class.php");
//
$tmp='';
$tmp = strrchr($_GET["fic"], '.');
$tmp=substr($tmp,1,(strlen($tmp)-1));
if(file_exists("../trs/".$_SESSION["coll"]."/".$_GET["fic"])){
  if (strtolower($tmp)=="pdf"){
   header("Location:../trs/".$_SESSION["coll"]."/".$_GET["fic"]);
  }
  /**
 * Paramètres
 */
  $ent="voir";
  $ico="voir.png";
//*
$DEBUG=0;
  //*
/**
 * Classe utils ()
 */
  $f = new utils ();
  $f -> headerhtml ();
  echo "<body class='voir'>";
  echo "<center>";
  echo "<table class='voir'>";
  echo "<tr><td>";
  echo "<br>[&nbsp;trs/".$_SESSION["coll"]."/".$_GET["fic"]."&nbsp;]<br></td></tr>";
  echo "<br><img src='../trs/".$_SESSION["coll"]."/".$_GET["fic"]."' >";
  echo "<tr><td>";
  echo "<a class='lientable' href='#' onclick='window.close();'>";
  echo "<img src='../img/fermer_fenetre.png' align='middle' alt='".$f->lang("fermer")."' title='".$f->lang("fermer")."' hspace='5' border='0'>";
  //*
  echo "</a>";
  echo "</td></tr>";

  echo "</table>";
  echo "</center>";
  $f -> footerhtml ();
}else{
  $f = new utils ();
  $f -> headerhtml ();
  echo "<body class='voir'>";
  echo "<center><br><br><br>";
  echo "<br><br><br>";
  echo "<font class='parametre_cle'>".$f -> lang("fichier")."&nbsp;".$f -> lang("inexistant")." ../trs/".$_SESSION["coll"]."/".$_GET["fic"]."</font>";
  echo "<a class='lientable' href='#' onclick='window.close();'>";
  echo "<br><br><br><img src='../img/fermer_fenetre.png' align='middle' alt='".$f->lang("fermer")."' title='".$f->lang("fermer")."' hspace='5' border='0'>";
  echo "</center>";
  echo "</body>";
}
?>


