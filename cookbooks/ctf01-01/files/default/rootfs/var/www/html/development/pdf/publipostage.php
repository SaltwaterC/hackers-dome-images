<?php
//$Id: publipostage.php,v 1.3 2008-07-21 13:54:59 jbastide Exp $

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
if(isset($_GET['idx']))
    $idx=$_GET['idx'];
else
    $idx="";
if(isset($_GET['obj']))
    $obj=$_GET['obj'];
else
    $obj="";
$ico = "ico_pdf.png";
$ent = "publipostage";
   $f = new utils ();
    $f -> headerhtml ();
    $f -> collectivite ();
    $f -> droit ($obj);
    $f -> header (1, $ent, $ico, $obj);
echo "\n<div id=\"content\">\n";
//
if (isset($langue)){
     if (file_exists("../sql/".$f -> phptype."/".$langue."/".$obj.".etat.inc"))
        include ("../sql/".$f -> phptype."/".$langue."/".$obj.".etat.inc");
}else{
     if(file_exists ("../sql/".$f -> phptype."/".$obj.".etat.inc"))
       include ("../sql/".$f -> phptype."/".$obj.".etat.inc");
}
// variables statiques
$titre= $etat["titre"];
$corps= $etat["corps"];

$temp = explode("[",$etat["titre"]);
for($i=1;$i<sizeof($temp);$i++){
   $temp1 = explode("]",$temp[$i]);
   $titre=str_replace("[".$temp1[0]."]","\".\$row[\"".$temp1[0]."\"].\"",$titre);
   $temp1[0]="";
}



$temp = explode("[",$etat["corps"]);

for($i=1;$i<sizeof($temp);$i++){
       $temp1 = explode("]",$temp[$i]);
       $corps=str_replace("[".$temp1[0]."]","\".\$row[\"".$temp1[0]."\"].\"",$corps);
       $temp1[0]="";
}

//
    $fp = fopen ("publipostage.inc", "w");
    $contenu = "<?php\n";

    $contenu .= "\$titre =\"".$titre."\";\n";
    $contenu .= "\$corps =\"".$corps."\";\n";
    $contenu .= "?>";
    fwrite ($fp, $contenu);
    fclose ($fp); 
//
echo "<table class='tabdoc' border='0'>";
echo "<tr>";
echo "<td>";
echo "<a class='lientable' href='javascript:history.go(-1)'><img  src=\"../img/retour_tab.png\" style='vertical-align:middle;border:0 px solid' hspace=\"5\" alt=\"Retour Liste\" title=\"Retour Liste\" /></a>";
echo "</td>";
echo "<td>";
$redir="pdfetat_publipostage.php?idx=".$idx."&obj=".$obj;
echo "<a class='lientable' href=".$redir." target='_blanck'>&nbsp;&nbsp;<img src='../img/voir.jpg' style='vertical-align:middle' hspace='1' border='0'>&nbsp;&nbsp;";
echo $f -> lang("voir")."&nbsp;".$f -> lang("document")."&nbsp;".$f -> lang("genere")."&nbsp;".$f -> lang("pour")."&nbsp;".$idx."&nbsp;".$obj."</a>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</div>";
$f -> footer ();
$f -> deconnexion ();
$f -> footerhtml ();
?>