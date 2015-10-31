<?php
/**
 * $Id: doc.php,v 1.3 2008-07-22 09:13:05 jbastide Exp $
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
    $obj = "documentation";
    $ent = "documentation";

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
    $dir = getcwd ();

     if (isset($langue)){
       $dir = substr ($dir, 0, strlen ($dir) - 4)."/doc/".$langue;
    }else{
        $dir = substr ($dir, 0, strlen ($dir) - 4)."/doc/";
    }
    $dossier = opendir ($dir);
    $tab = array ();
    while ($entree = readdir ($dossier))
    {
        if (strstr ($entree, ".html"))
            array_push ($tab, array ('file' => substr($entree, 0, strlen ($entree) - 5))); 
    }
    asort ($tab);
    closedir ($dossier);
    
    $col = 0;
    echo "<table class=\"file_list\"><tr>";
    if (isset($langue)){
        echo "<tr><td id=\"file_list\">".$f -> lang("traduction")."&nbsp;<font class='parametre'>".$f -> lang("langue")."</font>&nbsp;".$f -> lang("en_cours")."<br>&nbsp;</td></tr>";
    }
    foreach ($tab as $elem)
    {
        $col ++;
         if (isset($langue)){
            echo "<td><img src=\"../img/ico_fleche.png\" alt=\"-\" /><a href=\"javascript:aide('".$langue."/".$elem ['file']."')\">".$f -> lang($elem ['file'])."</a></td>";
        }else{
            echo "<td><img src=\"../img/ico_fleche.png\" alt=\"-\" /><a href=\"javascript:aide('".$elem ['file']."')\">".$elem ['file']."</a></td>";
        }
        if ($col == 3) 
        {
            echo "</tr><tr>";
            $col = 0;
        }
    }
    echo "</tr></table>";
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