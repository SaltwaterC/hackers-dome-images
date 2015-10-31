<?php
// $Id: edition.php,v 1.3 2008-07-22 09:13:05 jbastide Exp $
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
$ent="edition";
$ico="ico_edition.png";
$obj="";
// Paramétrage ===============================================================
$DEBUG=0;
/**
 * Classe utils ()
 */
    $f = new utils ();
    // Fichier de paramétrage
    if (file_exists ("../sql/".$f -> phptype."/".$obj.".inc"))
        include ("../sql/".$f -> phptype."/".$obj.".inc");
    $f -> headerhtml ();
    $f -> collectivite ();
    $f -> droit ($obj);
    $f -> header (1, $ent, $ico, $obj);

echo "\n<div id=\"content\">\n";
 if ($_SESSION ['profil'] >= $f -> droit) {
       echo "<div id='edition'>";
       echo "<fieldset class='cadre'><legend> 1 </legend>";
       echo "<br></fieldset>";
       echo "<br><br><fieldset class='cadre'><legend>  2 </legend>";
       echo "<br></fieldset>";
       echo "<br><br><fieldset class='cadre'><legend> 3 </legend>";
       //
       echo "<br></fieldset>";
       //
       echo "<br><br></div>";
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