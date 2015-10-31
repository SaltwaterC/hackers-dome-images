<?php
// $Id: tab.php,v 1.5 2008-07-22 09:13:05 jbastide Exp $
 
/**
 * Fichiers requis
 */
    if (file_exists ("../dyn/session.inc"))
        include ("../dyn/session.inc");
    //
    if(isset($_GET['obj']))
      $obj=$_GET['obj'];
    else
      $obj="";
    if(!isset($_SESSION['profil']))
          header("location:../index.php?msg=liste ".$obj);
    //
    if (file_exists ("../dyn/var.inc"))
        include ("../dyn/var.inc");
     if (file_exists ("../scr/lang.inc"))
        include ("../scr/lang.inc");
    if (file_exists ("../obj/utils.class.php"))
        include ("../obj/utils.class.php");

//*
// variable get ===============================================================
// $obj = nom de l'objet metier
// $recherche = chaine recherchee
// $premier = premier enregistrement a afficher
// ============================================================================
if(isset($_GET['tri'])) //ajout fred
    $tricol=$_GET['tri'];
else
    $tricol="";
// ===============================
// modification gestion des quotes
if(isset($_POST['recherche'])){
       $recherche=$_POST['recherche'];
       if (get_magic_quotes_gpc()) // magic_quotes_gpc = on
          $recherche1= StripSlashes($recherche);
       else
          $recherche1= $recherche;
}else
    if(isset($_GET['recherche'])){
        $recherche=$_GET['recherche'];
        if (get_magic_quotes_gpc()) // magic_quotes_gpc = on
          $recherche1= StripSlashes($recherche);
        else
          $recherche1= $recherche;
    }else{
        $recherche="";
        $recherche1="";
    }
if(isset($_GET['premier']))
    $premier=$_GET['premier'];
else
    $premier=0;
// Icône d'aide
    $ico = "";
// librairie utilisee =========================================================
include ($path_om."tabdyn.class.php");
// parametrage ================================================================
// $DEBUG= mode debug 0 ou 1
// $serie= nombre enregistrement par page
// $ent= affichage
// $ico= nom de l icone
// $table= nom de la table
// $formulaire= nom du formulaire
// $edition= programme edition : nomfichier.pdf.php
// $champAffiche= tableau des champs a afficher  : array(nomchamp1, nomchamp2 ...)
// $champRecherche=  tableau des champs a rechercher  : array(nomchamp1, nomchamp2 ...)
// $tri= string = tri (order by nomchamp)
// $selection= selection dans la requete : " where nomchamp = '' "
// $ref = tableau des liens (facultatif)
// $methode methode a executer

$hiddenid=0;
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
    if ($_SESSION ['profil'] >= $f -> droit)
    {
       if(!isset($href) or $href==array()){
         $href[0]['lien']= "form.php?obj=".$obj."&tri=".$tricol;
         $href[0]['id']= "";
         $href[0]['lib']= "<img src='../img/ajouter.png' border='0'>";
         //*
         $href[1]['lien'] = "form.php?obj=".$obj."&tri=".$tricol."&idx=";
         $href[1]['id']= "&premier=".$premier."&recherche=".$recherche1;
         $href[1]['lib']= "";
         $href[2]['lien'] = "form.php?obj=".$obj."&tri=".$tricol."&idx=";
         $href[2]['id']= "&ids=1&premier=".$premier."&recherche=".$recherche1;
         $href[2]['lib']= "<img src='../img/supprimer.png' border='0'>";
         //*
       }
    }else{
       $href[0]['lien']= "#";
       $href[0]['id']= "";
       $href[0]['lib']= "";
       $href[1]['lien'] = "";
       $href[1]['id']= "";
       $href[1]['lib']= "";
       $href[2]['lien'] = "#";
       $href[2]['id']= "";
       $href[2]['lib']= "";
    }
if ($_SESSION ['profil'] > 0)
{
    if (file_exists ("../sql/".$f -> phptype."/".$obj.".inc"))
    {
      if(!isset($methode))      
           $methode="afficher";
      $tb= new tab($obj,$table, $serie,$champAffiche,$champRecherche,$tri,$tricol,$selection);
      $tb->entete($table,$edition,$recherche1);
      $tb->$methode($premier,$recherche,$href,$f -> db,$DEBUG,$hiddenid);
    }
    else
        echo "Erreur du logiciel : le fichier \"../sql/".$f -> phptype."/".$obj.".inc\" est inaccessible";
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
/*
echo "</body>";*/
?>