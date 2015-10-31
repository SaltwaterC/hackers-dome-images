<?php
/**
 * $Id: login.php,v 1.13 2009-01-11 11:03:12 fraynaud1 Exp $
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


// ================================================
     $profil="";
     $error ="";
     $msg="";
     if(isset($_GET['tri'])) //ajout fred
       $tricol=$_GET['tri'];
     else
       $tricol="";
     if (isset ($_GET['coll'])){
        if (!isset ($_SESSION['coll'])){
             $_SESSION['coll']=$_GET['coll'];
     }}
     $ville="";
     if (isset ($_GET['ville']))
       if ($ville==""){
         $ville=$_GET['ville'];
     }
    if (!isset($_GET['step'])){
       $step=0;
    }else{
       $step=$_GET['step'];
    }
    if ( !isset($_GET['dec']) )
       $dec=0 ;
    else
       $dec= $_GET['dec'];
    //
    $lib = "";
    $nom = "";
    $login = "";
    $obj = "login";
    $DEBUG=0;

/**
 * Classe utils ()
 */
    $f = new utils ();
    $f -> headerhtml ();
    $f -> collectivite ();
//
    if ( $step==1 and !isset($_POST['pwd']) and !isset($_POST['login'])){
        $step=0;
    }

if ($step == 1 )
 {
       $pwd = md5($_POST['pwd']);
       // traitement contre les injections sql #
       $post_login= $_POST['login'];
       $post_login= str_replace('#','',$post_login);
       if($DEBUG==1)
         echo $f -> lang("base")."&nbsp;".$dsn["database"].$f -> lang("base")."<br>";
         //verification de la validite du login
         $sql =  "SELECT * "."from utilisateur "."WHERE login = '".$post_login."' ";
         $res = $f -> db -> query ($sql);
         if (DB :: isError($res))
            die($res->getMessage());
         else
         {
            //si on a un utilisateur qui correspond dans la base on recup les infos le concernant
            while ($row=& $res->fetchRow())
            {
               if($row[3]==$pwd){ // injection sql
                   $profil = $row[4];
                   $nom = $row[1];
                   $login=$row[2];
                   $error= 'ok';
               }else
                   $error = $f -> lang("mot_de_passe")."&nbsp;".$f -> lang("incorrect")."&nbsp;,&nbsp;".$f -> lang("recommencer")."&nbsp;...";
            }

            //
            if ($error != 'ok' )
            {
              if($error=='')
                  $error = $f -> lang("login")."&nbsp;".$f -> lang("incorrect")."&nbsp;,&nbsp;".$f -> lang("recommencer")."&nbsp;...";
              $step=0;
            }
            //si lutilisateur existe bien on initialise les variables de session qui le concerne et affiche le message de bienvenue une fois connecte
            //ucwords met en maj la premiere lettre de tous les mots de la chaine passee en parametre
            else 
            {
              $_SESSION['profil'] = $profil;
              $_SESSION['nom'] = $nom;
              $_SESSION['login'] = $login;
              $step=1;
              $msg=$f -> lang("bienvenue")."&nbsp;<font class='parametre'>&nbsp;".ucwords($nom)."&nbsp;</font> - ".$f -> lang("profil")."&nbsp;:&nbsp;<font class='parametre'>&nbsp;".$profil."&nbsp;</font>&nbsp;&nbsp;" ;
              $msg=$msg.$f -> lang("vous_travaillez_sur")."&nbsp;".$f -> lang("collectivite")."&nbsp;:&nbsp;<font class='parametre'>&nbsp;".ucwords (strtolower($f -> collectivite ['ville']))."&nbsp;</font>";
           }
            $res->free();
         }
    }
    if ($profil > 0)
    {
        $f -> header (1, "tableau_de_bord");
        echo "\n<div id=\"content\">\n";
    }
    else
    {
        echo "\n<div id=\"content_login\">\n";
    }
     if ($step == 1)
     {
         echo "<div id='msgloginok'>";
         echo $msg;
         echo "<div>";
     }
      //*****
    if ($profil > 0)
    {
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
            $recherche1= $recherche;
      //***
      if (file_exists ("../dyn/tdb.inc")){
          include ("../dyn/tdb.inc");
      }
      //**
    }
    //*****
    /* Identification */

    if ($step == 0)
    {

        if ($error != "")
        {
            echo "<div class=\"erreur_login\">";
            echo "<img src='../img/warning.gif' style='vertical-align:middle' vspace='5' hspace='5' border='0'>".$error;
            echo "</div>";
        }

        echo "<div class=\"index_logo\"><img src='../trs/".$_SESSION['coll']."/logo.png'></div>\n";
        echo "<form action=\"login.php?step=1\"  method=\"post\" name=\"f1\">";
        echo "<table class=\"login\" cellSpacing='5' cellPadding='5'>";
        echo "<tr><td colspan=\"3\"><b>".$f -> lang("identifiez_vous")."</b><br />".$f -> lang("acces_a")."&nbsp;".ucwords (strtolower($f -> collectivite ['ville']))."</td></tr>";
        // mode demo
        if($demo==1){
            echo "<tr><td>".$f -> lang("login")." : </td><td><input type=\"text\" name=\"login\" value=\"demo\" size=\"20\" class=\"champFormulaire\" /></td><td>&nbsp;</td></tr>";
            echo "<tr>";
            echo "<td>".$f -> lang("mot_de_passe")." : </td><td><input type=\"password\" name=\"pwd\" value=\"demo\" size=\"25\" class=\"champFormulaire\" /></td>";
        }else{
            echo "<tr><td>".$f -> lang("login")." : </td><td><input type=\"text\" name=\"login\" value=\"\" size=\"20\" class=\"champFormulaire\" /></td><td>&nbsp;</td></tr>";
            echo "<tr>";
            echo "<td>".$f -> lang("mot_de_passe")." : </td><td><input type=\"password\" name=\"pwd\" size=\"25\" class=\"champFormulaire\" /></td>";
        }
        echo "<td><input type=\"submit\" value=\"".$f -> lang("valider")."\" style=".$styleBouton."/></td>";
        echo "</tr>";
        echo "</table>";
        echo "<div class=\"login_base\"><img src=\"../img/ico_bdd.png\" alt=\"\" title=\"\" /><a class=\"lienindex\" href=\"../index.php?msg=".$f -> lang("identification")."\">".$f -> lang("autre_base")."</a></div>\n";
        echo "</form>";
    }
    echo "\n</div>\n\n";


    if ($profil > 0)
    $f -> footer ();
    $f -> deconnexion (); 
    $f -> footerhtml ();
?>