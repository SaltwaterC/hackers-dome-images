<?php
/* 
$Id: index.php,v 1.5 2008-09-22 09:08:01 jbastide Exp $
*/
if (file_exists ("dyn/session.inc"))
    include ("dyn/session.inc");
function lang($texte){
         include ("dyn/var.inc");
         if(!isset($langue)) $langue='francais';
         include ("lang/".$langue.".inc");
         if(!isset($lang[$texte])) $lang[$texte]='<i>'.$texte.'</i>';
         return $texte=$lang[$texte];
}
// recuperer msg depuis tab.php ou form.php
if(isset($_GET['msg']))
    $msg=$_GET['msg'];
else
    $msg="";
// vider les variables sessions
session_unset();
//
if (file_exists ("dyn/var.inc"))
    include ("dyn/var.inc");
if (file_exists ("version.inc"))
    include ("version.inc");
//
// ENTETE HTML
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" lang=\"fr\">\n";
echo "\t<head>\n";
echo "\t\t<meta http-equiv=\"Content-Type\" content=\"text/html;charset=iso-8859-1\" />\n";
echo "\t\t<title>".lang("title_html")."</title>\n";
echo "\t\t<link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"img/favicon.ico\" />\n";
echo "\t\t<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"dyn/style.css\" />\n";
echo "\t</head>\n";
echo "\t<body>\n";
echo "<div id=\"content_index\">\n";
if($msg!='')
        echo "<div id='msgdroitindex'>".lang("reconnexion_depuis")."&nbsp;:&nbsp;".$msg."</div>";
echo "<div class=\"index_logo\">";
if(file_exists($logo_connexion)) {
   echo "<img src=\"".$logo_connexion."\" alt=\"Accueil\" title=\"Accueil\" />";
}else{
   echo "<br>&nbsp;".lang("choix_bd");
}
echo "</div>\n";

$conn = array ();
if (file_exists ("dyn/base.php"))
    include ("dyn/base.php");

echo "<table class=\"index_table\">\n";
$i=1;
foreach($conn as $elem){
    echo "<tr><td><br><img src='img/ico_bdd.png' align='middle' vspace='2' hspace='2' border='0'><a class='lienindex' href='spg/login.php?coll=".$i.
    "&ville=".$elem[0].
    "'>".
    $elem[0]."</a><br></td></tr>";
    $i++;
}
echo "</table>\n";
if (isset ($version)){
  $version=str_replace("../img", "img", $version);
  echo "<div class=\"index_version\">";
  echo lang("title_html")."&nbsp;"."&nbsp;".lang("version")."&nbsp;".$version."&nbsp;".lang($moisversion)."&nbsp;".$anneeversion."&nbsp;-&nbsp;".lang("langue");
  echo "</div>\n";
}
echo "</div>\n";

echo "\t</body>\n";
echo "</html>";
?>