<?php
/**
 * $Id: rechercheglobale.php,v 1.3 2008-07-28 13:39:18 jbastide Exp $
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
    $ent = "recherche";
    if(isset($_GET['tri'])) //ajout fred
       $tricol=$_GET['tri'];
    else
           $tricol="";
    if(isset($_GET['premier']))
          $premier=$_GET['premier'];
    else
          $premier=0;
    if(isset($_POST['recherche'])){
           $recherche=$_POST['recherche'];
           if (get_magic_quotes_gpc()) // magic_quotes_gpc = on
              $recherche1= StripSlashes($recherche);
           else
              $recherche1= $recherche;
    } else
        if(isset($_GET['recherche'])){
               $recherche=$_GET['recherche'];
               if (get_magic_quotes_gpc()) // magic_quotes_gpc = on
                  $recherche1= StripSlashes($recherche);
               else
                  $recherche1= $recherche;
        } else
          $recherche="";
          $recherche1="";

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
    if (isset($_SESSION ['profil'])){
       if ($_SESSION ['profil'] > 0 && $_SESSION ['profil'] >= $f -> droit) {
           if (file_exists ("../dyn/recherche.inc")){
              echo "<fieldset class='tb'>";
              echo "<legend class='tb'>&nbsp;&nbsp;".$f->lang("recherche_globale")."&nbsp;&nbsp;</legend>";
              echo "<div class='db'>";
              include ("../dyn/recherche.inc");
              //uniquement recherche globale
              $idrg=1;
              include ("../scr/recherche.php");
              echo "</div>";
              echo "</fieldset>";
              echo " <br>";
           }
       }else
           echo "<div id='msgdroit'>".$f->lang("attention")."&nbsp;".$f->lang("droit").$f->lang("pluriel")."&nbsp;".$f->lang("insuffisant").$f->lang("pluriel")." - ".
        $f->lang("votre_profil_est")." : [".$_SESSION['profil']."]</div>";
    }else{
       echo "<div id='msgdroit'>".$f->lang("attention")."&nbsp;".$f->lang("droit").$f->lang("pluriel")."&nbsp;".$f->lang("insuffisant").$f->lang("pluriel")." - ".
        $f->lang("votre_profil_est")." : [".$_SESSION['profil']."]</div>";
    }
    echo "\n</div>\n";

/**
 * 
 */
    $f -> footer ();
    $f -> deconnexion (); 
    $f -> footerhtml ();
?>