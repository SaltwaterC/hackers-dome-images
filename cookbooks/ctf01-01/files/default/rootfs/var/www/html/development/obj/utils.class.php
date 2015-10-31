<?php
/**
 * $Id: utils.class.php,v 1.7 2008-07-24 14:33:31 jbastide Exp $
 * Cette classe représente une page
 */
include ("../dyn/var.inc");
require_once ($path_pear."DB.php");

class utils
{
    var $db;
    var $collectivite;
    var $droit;
    var $phptype;
    var $formatdate;

    function lang($texte){
         include ("../dyn/var.inc");
         if(!isset($langue)) $langue='francais';
          if (file_exists("../lang/".$langue.".inc")) {
            include ("../lang/".$langue.".inc");
         }
         $msg="";
         if(isset($lang['non_traduit'])){
            $msg=$lang['non_traduit'];
         }
         if (file_exists("../img/".$langue.".png")) {
             if(!isset($lang[$texte])) $lang[$texte]="<font id='a_traduire'><img src='../img/".$langue.".png'  style='vertical-align:middle' hspace='2' />".$texte."</font>&nbsp;[".$msg."]";
             if(isset($lang[$texte]) and trim($lang[$texte])=='') $lang[$texte]="<font id='a_traduire'><img src='../img/".$langue.".png'  style='vertical-align:middle' hspace='2' />".$texte."</font>&nbsp;[".$msg."(vide)]&nbsp;";
         }else{
              if(!isset($lang[$texte])) $lang[$texte]="<font id='a_traduire'>".$texte."</font>&nbsp;[".$msg."]";
              if(isset($lang[$texte]) and trim($lang[$texte])=='') $lang[$texte]="<font id='a_traduire'>".$texte."</font>&nbsp;[".$msg."(vide)]";;
         }
         if(!isset($lang[$texte])) $lang[$texte]='<i>'.$texte.'</i>';
         return $texte=$lang[$texte];
    }
     function langentete($texte){
         include ("../dyn/var.inc");
         if(!isset($langue)) $langue='francais';
          if (file_exists("../lang/".$langue.".inc")) {
            include ("../lang/".$langue.".inc");
         }
         if(!isset($lang[$texte])) $lang[$texte]='<i>'.$texte.'</i>';
         return $texte=$lang[$texte];
    }
    function utils ()
    {
        $collectivite = array ();
        return $this -> connexion ();
    } // Constructeur
    
    function headerhtml ()
    {
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
        echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" lang=\"fr\">\n";
        echo "\t<head>\n";
        echo "\t\t<meta http-equiv=\"Content-Type\" content=\"text/html;charset=iso-8859-1\" />\n";
        echo "\t\t<title>".$this -> lang("title_html")."</title>\n";
        echo "\t\t<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"../dyn/style.css\" />\n";
        echo "\t\t<link rel=\"stylesheet\" type=\"text/css\" media=\"print\" href=\"../dyn/print.css\" />\n";
        echo "\t\t<script type=\"text/javascript\" src=\"../dyn/script.js\"></script>\n";
        echo "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"../dyn/menu.css\" />\n";
        echo "\t\t<script type=\"text/javascript\" src=\"../dyn/menu.js\"></script>\n";
        echo "\t</head>\n";
        echo "\t<body>\n";
    } // header ()
    
    function connexion ()
    {
        // grille de connexion
        if (file_exists ("../dyn/base.php"))
            include_once "../dyn/base.php";
        // $coll est fonction de la grille de connexion
        // chaque collectivite peut avoir une base differente suivant l'importance de la collectivite
        $coll = 1;
        if (!isset ($_SESSION ['coll']))
            $_SESSION ['coll'] = 1;
        else
            $coll = $_SESSION ['coll'];
        $titre = $conn [$coll][0];
        $dsn = array (
                'phptype' => $conn [$coll][1],
                'dbsyntax' => $conn [$coll][2],
                'username' => $conn [$coll][3],
                'password' => $conn [$coll][4],
                'protocol' => $conn [$coll][5],
                'hostspec' => $conn [$coll][6],
                'port' => $conn [$coll][7],
                'socket' => $conn [$coll][8],
                'database' => $conn [$coll][9]
        );
        $db_option = array (
                'debug' => 2,
                'portability' => DB_PORTABILITY_ALL
        );
        
        // Format de la date suivant la base utilisée
        $this -> formatdate = $conn [$coll][10];
        
        // Connexion à la BDD
        $this -> db =& DB :: connect ($dsn, $db_option);
        if (DB :: isError($this -> db))
                die ($this -> db ->getMessage ());
                
        $this -> phptype = $dsn ['phptype'];
    } //connexion ()
    
    function collectivite ()
    {
        $sql = "select * from collectivite";
        $res = $this -> db -> query ($sql);
        if (DB :: isError ($res))
                die ($res -> getMessage ()." erreur ".$sql);
        $row =& $res -> fetchRow (DB_FETCHMODE_ASSOC);
                $this -> collectivite = $row;
        $res -> free ();
    } // collectivite ()
    
    function droit ($obj)
    {
        $sql =  "select profil from droit where droit = '".$obj."'";
        $this -> droit = $this -> db -> getOne ($sql);
    } // droit ($obj)
    
    function header ($menu = 0, $ent = "", $ico = "", $obj = "")
    {
        $this -> menu ();
        //
        include ("../dyn/var.inc");
        echo "<div id=\"header\">\n";
        //if ($menu == 1)
        //{
            echo "\t<div id=\"menu_fond\"></div>\n";
            echo "\t<div id=\"logo\"><img class=\"logo\" src=\"../img/logo.png\" alt=\"\" title=\"\" /></div>\n";
            echo "\t<div id=\"ville\">".htmlentities ($this -> collectivite ['ville'])."</div>\n";
            echo "\t<div id=\"date\">Date : ".date("d / m / Y")."</div>\n";
        //}
        echo "\t<div id=\"top\">";
        if (isset($_SESSION ['login']))
        {
          if ($_SESSION ['login']!="") {
            echo $_SESSION ['login'];
            echo " | ";
            //
            if (!isset ($demo)) $demo=0;
            if($demo==1){
                echo "<a class=\"MotdePasse\" href=\"#\" title=\"".$this -> lang("mot_de_passe").$this -> lang("non_accessible_avec")." demo\">&nbsp;".$this -> lang("mot_de_passe")."&nbsp;</a>";
            }else{
                echo "<a class=\"MotdePasse\" href=\"../spg/loginchangepwd.php\" title=\"".$this -> lang("changer")." ".$this -> lang("mot_de_passe")."\">&nbsp;".$this -> lang("mot_de_passe")."&nbsp;</a>";
            }
            echo " | ";
            echo "<a class=\"Deconnexion\" href=\"../spg/login.php?dec=1\" title=\"".$this -> lang("quitter")."\">&nbsp;".$this -> lang("deconnexion")."&nbsp;</a>";
            echo " | ";
            echo "<a class=\"lientable\" href=\"../index.php?msg=Menu\" title=\"".$this -> lang("autre_base")."\">&nbsp;";
            echo $this -> lang("autre_base")."&nbsp;</a>";
            echo " | ";
            //******
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
            //******
            if (isset($global_haut)){
              if ($global_haut==1){
               echo "<a class=\"lientdb\" href=\"../scr/rechercheglobale.php?recherche=".$recherche."\" title=\"".$this -> lang("recherche_globale")."\">&nbsp;";
               echo "<img  src=\"../img/loupe_mini.png\" style=\"vertical-align:middle\" alt=\"".$this -> lang("recherche_globale")."\" title=\"".$this -> lang("recherche_globale")."\" />&nbsp;".$this -> lang("recherche_globale")."&nbsp;</a>";
               echo " | ";
               }
            }
            echo "<a class=\"lientdb\" href=\"../scr/tdb.php?recherche=".$recherche."\" title=\"".$this -> lang("tableau_de_bord")."\">";
            echo "&nbsp;".$this -> lang("tableau_de_bord")."&nbsp;</a>";
          }else{
            echo $this -> lang("vous_n_etes_pas_connecte");
            echo " | ";
            echo "<a class=\"Identification\" href=\"../spg/login.php\" title=\"".$this -> lang("connexion")."\">&nbsp;".$this -> lang("identifiez_vous")."&nbsp;</a>";
          }
        }
        else
        {
            echo $this -> lang("vous_n_etes_pas_connecte");
            echo " | ";
            echo "<a class=\"Identification\" href=\"../spg/login.php\" title=\"".$this -> lang("connexion")."\">&nbsp;".$this -> lang("identifiez_vous")."&nbsp;</a>";
        }
        echo "</div>\n";
        
        echo "</div>\n";
        $this -> entete ($ent, $ico, $obj);
    } // header ($menu = 0, $ent = "", $ico = "", $obj = "")
    
    function titre ($ent)
    {
        if (ereg("->",$ent)) {
           $temp = explode("->",$ent);
           $temp1="";
           foreach($temp as $elem){
             $temp1=$temp1.$this -> langentete(trim($elem))."->";
            }
           $temp1=substr($temp1,0,strlen($temp1)-2);
           $ent = str_replace ("->", "&nbsp;<img class=\"fleche_droite\" src=\"../img/fleche_droite.png\" style=\"vertical-align:middle\" alt=\"->\" title=\"->\" />&nbsp;", $temp1);
        }else{
           $ent =  $this -> lang($ent);
        }
        echo "\t<div id=\"titre\">";
        $ent = ucwords($ent);
        echo $ent;
        echo "</div>\n";
    } // titre ($ent)
    
    function aide ($ico, $obj)
    {
        include ("../dyn/var.inc");
        echo "\t<div id=\"aide\">";
        if (isset($langue)){
           echo "<a href=\"javascript:aide('".$langue."/".$obj."')\">";
           echo "<img class=\"aide\" src=\"../img/".$ico."\" alt=\"".$this -> lang("aide")."\" title=\"".$this -> lang("aide")."\" /><img class=\"aide\" src=\"../img/ico_aide.png\" alt=\"".$this -> lang("aide")."\" title=\"".$this -> lang("aide")."\" />";
        }else{
            echo "<a href=\"javascript:aide('".$obj."')\">";
            echo "<img class=\"aide\" src=\"../img/".$ico."\" alt=\"\" title=\"\" /><img class=\"aide\" src=\"../img/ico_aide.png\" alt=\"\" title=\"\" />";
        }
        echo "</a>";
        echo "</div>\n";
    } // aide ($ico, $obj)
    
    function entete ($ent = "", $ico = "", $obj = "")
    {
        echo "<div id=\"entete\">\n";
        $this -> titre ($ent);
        if ($ico != "" && $obj != "")
                $this -> aide ($ico, $obj);
        echo "</div>\n";
    } // entete ($ent = "", $ico = "", $obj = "")
    
    function menu ()
    {
        if (file_exists ("../dyn/menu.inc"))
            include_once "../dyn/menu.inc";
    } // menu ()
    
    function footer ()
    {
        $version = "0.00";
        if (file_exists ("../version.inc"))
            include_once ("../version.inc");
        //
        include ("../dyn/var.inc");
        echo "<div id=\"footer\">\n";
        if (file_exists("../img/".$langue.".png")) {
            echo "\t<span id=\"footerName\">".$this -> lang("title_html")."&nbsp"."&nbsp;".$this -> lang("version")."&nbsp;".$version."&nbsp;".$this -> lang($moisversion)."&nbsp;".$anneeversion."&nbsp;-&nbsp;<img src='../img/".$langue.".png'  style='vertical-align:middle' hspace='2' />".$this -> lang("langue")."<br>";
        }else{
            echo "\t<span id=\"footerName\">".$this -> lang("title_html")."&nbsp"."&nbsp;".$this -> lang("version")."&nbsp;".$version."&nbsp;".$this -> lang($moisversion)."&nbsp;".$anneeversion."&nbsp;-&nbsp;".$this -> lang("langue")."<br>";
        }
        echo "&nbsp;|&nbsp;<a href=\"../spg/doc.php\" title=\"Documentation\">".$this -> lang("documentation")."</a>";
        echo "&nbsp;|&nbsp;<a href=\"http://www.openmairie.org/\" target=\"_blank\" title=\"OpenMairie.org\">".$this -> lang("openmairie")."</a>&nbsp;|&nbsp;</span>\n";
        echo "</div>\n";
    } // footer ()
    
    function deconnexion ()
    {
        $this -> db -> disconnect ();
    } // deconnexion ()
    
    function footerhtml ()
    {
        echo "\t</body>\n";
        echo "</html>";
    } // footerhtml ()
    

    function tmp ($fichier, $msg)
    {   
        $inf = fopen ($fichier, "w");
        
        $ent .= date("d/m/Y G:i:s")."<br />";
        $ent .= $this -> lang("collectivite")." : ".$_SESSION ['coll']." - ".$this -> collectivite ['ville']."<br />";
        $ent .= $this -> lang("utilisateur")." : ".$_SESSION ['login']."<br />";
        $ent .= "==================================================<br />";
        
        $msg = $ent."<br />".$msg ;
        
        fwrite ($inf, $msg);
        
        fclose ($inf);
    } // tmp ($fichier, $msg)
}
?>