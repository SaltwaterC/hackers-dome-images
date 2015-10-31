<?php
/**
 * $Id: index.php,v 1.2 2008-07-28 09:09:50 jbastide Exp $
 *
 */
 
/**
 * Fichiers requis
 */
    if (file_exists ("../dyn/session.inc"))
        include ("../dyn/session.inc");
    if (file_exists ("../dyn/var.inc"))
        include ("../dyn/var.inc");
    if (file_exists ("../obj/utils.class.php"))
        include ("../obj/utils.class.php");

/**
 * Paramètres
 */
    $obj = "encours";
    $ent = "vide";

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
    echo $f->lang("droit").$f->lang("pluriel")."&nbsp;".$f->lang("insuffisant").$f->lang("pluriel");
    echo "\n</div>\n";

/**
 * 
 */
    $f -> footer ();
    $f -> deconnexion (); 
    $f -> footerhtml ();
?>