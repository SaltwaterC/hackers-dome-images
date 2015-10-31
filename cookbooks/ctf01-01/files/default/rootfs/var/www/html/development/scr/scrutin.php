<?php
/**
 * $Id: scrutin.php,v 1.4 2008-07-22 09:13:05 jbastide Exp $
 *
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
    // Variables générales
    $obj = "scrutindefaut";
    $ico = "ico_liste.png";
    $ent = "scrutin_par_defaut";
    // $_GET
    $step = 0;
    if (isset ($_GET ['step']) )
        $step = $_GET ['step'];
    //
    if ($step == 1 && isset ($_POST ['scrutin']))
    {
        $_SESSION ['scrutin'] = $_POST ['scrutin'];
    }

/**
 * Classe utils ()
 */
    $f = new utils ();
    $f -> headerhtml ();
    $f -> collectivite ();
    $f -> droit ($obj);
    $f -> header (1, $ent);

echo "\n<div id=\"content\">\n";
if ($_SESSION ['profil'] > 0 && $_SESSION ['profil'] >= $f -> droit)
{
    if ($step == 1)
    {
        $msg = "<div class=\"valid\">";
        $msg .= "Le scrutin par défaut est maintenant : ".$_SESSION ['scrutin']."";
        $msg .= "</div>";
        echo $msg;
        $step = 0;
    }
    if ($step == 0)
    {
        echo "<center>";
        echo "<form action=\"scrutin.php?step=1\" method=\"post\" name=\"f1\">";
        echo "<p>SELECTIONNER LE SCRUTIN PAR DEFAUT<br><br>Choisissez votre liste<br />";
        echo "<select name=\"scrutin\" tabindex=\"1\" size=\"1\" class=\"champFormulaire\" >";
        $sql = "select * from scrutin where solde !='Oui'";
        $res = $f -> db -> query ($sql);
        if (DB :: isError ($res))
            die ($res -> getMessage ()." erreur ".$sql);
        else
        {
            while ($row =& $res -> fetchRow (DB_FETCHMODE_ASSOC))
            {
                if ($row ['scrutin'] == $_SESSION ['scrutin'])
                    echo "<option value=\"".$row ['scrutin']."\" selected=\"selected\">".$row ['libelle']."</option>";
                else
                    echo "<option value=\"".$row ['scrutin']."\">".$row ['libelle']."</option>";
            }
        }
        echo "</select>";
        echo "</p>";
        echo "<p><input type=\"submit\" tabindex=\"4\" value=\"Validez le scrutin par défaut\" class=\"boutonFormulaire\" /></p>";
        echo "</form></center>";
    }
}
else
{
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