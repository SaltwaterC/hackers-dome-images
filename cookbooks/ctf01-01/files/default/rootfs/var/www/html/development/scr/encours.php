<?php
/**
 * $Id: encours.php,v 1.2 2008-07-17 09:44:14 jbastide Exp $
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
    $obj = "encours";
    $ent="en_construction";

/**
 * Classe utils ()
 */
    $f = new utils ();
    $f -> headerhtml ();
    $f -> collectivite ();
    $f -> droit ($obj);
    $f -> header (1, $ent);

/**
 *
 */
    echo "\n<div id=\"content\">\n";
    echo "<img src='../img/encours.png' border='0' alt='aide'>";
    echo "\n</div>\n";

/**
 * 
 */
    $f -> footer ();
    $f -> deconnexion (); 
    $f -> footerhtml ();
?>