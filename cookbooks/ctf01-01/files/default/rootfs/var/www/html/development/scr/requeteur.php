<?php
/**
 * $Id: requeteur.php,v 1.6 2008-09-22 13:09:19 jbastide Exp $
 * Requêteur
 * principe de REQMO (requete memorisée):
 * permet de faire des requetes memorisees
 * la requete est parametree en sql/typedebase/langue/obj.reqmo.inc
 * $reqmo['sql'] = requete parametrable
 * les parametres sont entre crochets
 * type de parametre  = $reqmo['parametre']
 *  checked : case à cocher pour que la zone soit prise en compte
 *  liste : liste de valeur proposé pour parametrer une selection ou un tri
 *  select : liste de valeur proposé pour parametrer une selection ou un tri d apres une requete dans une table
 * $reqmo['libelle'] = libelle de la requete
 * $reqmo['separateur'] = separateur pour fichier csv
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
    set_time_limit(180);
    $DEBUG=0;
    $aff = "requeteur";
    $validation = 0;
    if (isset ($_GET['validation']))
        $validation = $_GET['validation'];
    $idx = "";
    if (isset($_GET['idx']))
        $idx = $_GET['idx'];
    $obj = "";
    if (isset($_GET['obj']))
        $obj = $_GET['obj'];
    $ent = "requetes_memorisees"."->".$obj;
    $ico = "ico_aide.png";

/**
 * Classe utils ()
 */
    $f = new utils ();
    $f -> headerhtml ();
    $f -> collectivite ();
    $f -> droit ("reqmo");
    $f -> header (1, $ent);

echo "\n<div id=\"content\">\n";
if ($_SESSION ['profil'] > 0 && $_SESSION ['profil'] >= $f -> droit)
{
   if (isset($langue)){
        if (file_exists ("../sql/".$f -> phptype."/".$langue."/".$obj.".reqmo.inc"))
           include ("../sql/".$f -> phptype."/".$langue."/".$obj.".reqmo.inc");
    }else{
         if (file_exists ("../sql/".$f -> phptype."/".$obj.".reqmo.inc"))
           include ("../sql/".$f -> phptype."/".$obj.".reqmo.inc");
    }
    if (isset ($_GET ['step']))
        $step = $_GET ['step'];
    else
        $step = 0;
            
    // Si step == 0 on affiche le formulaire
    if ($step == 0)
    {
        $validation = 1;
        $cptemp = 0;
        $cpts=0;
        $cptsel=0;
        echo "<form method=\"post\" action=\"requeteur.php?obj=".$obj."&amp;step=1\" name=\"f1\">";
        echo "<table class=\"reqmo\" cellspacing='2' cellpadding='0' border='0'>";
        echo "<tr class=\"reqmotitre\"><td colspan='7'>&nbsp;&nbsp;";
        echo "<img src=\"../img/ico_reqmo.png\" style=\"vertical-align:middle\" alt=\"".$f->lang("reqmo")."\" title=\"".$f->lang("reqmo")."\" />&nbsp;".strtoupper($f -> lang("recherche"))."&nbsp;".strtoupper($f -> lang($reqmo["libelle"]));
        echo "</td><td align='right'>";
         echo "<input type=\"submit\" value=\"".$f->lang("recherche")."\" style='".$styleBouton ."' />";
        echo "&nbsp;&nbsp;<a href=\"../scr/reqmo.php\"><img src=\"../img/retour.png\"  alt=\"".$f->lang("retour")."\" title=\"".$f->lang("retour")."\" /></a>";
        echo "</td>";
        echo "<td class='reqmochecked'>&nbsp;</td>";
        echo "</tr>";
        // On sépare tous les champs entre crochets dans la requête
        $temp = explode ("[", $reqmo ["sql"]);

        for ($i = 1; $i < sizeof ($temp); $i++)
        {
            // On vire le crochet de la fin
            $temp1 = explode("]", $temp [$i]);
            // On check si alias
            $temp4 = explode (" as ", $temp1 [0]);
            if (isset ($temp4 [1])) 
                $temp1 [0] = $temp4 [1];
            // On remplace les _ par des espaces
            // $temp6 = str_replace ('_', ' ', $temp1 [0]);
            // supprimer dans la version internationale
            $temp6 = $temp1 [0];
            if (!isset ($reqmo [$temp1 [0]])) {
            //saisie criteres where
               //
               if ($cpts == 0)
                    echo "<tr class=\"reqmochecked\" ><td class='reqmochecked'>&nbsp;</td>";
                elseif ($cpts == 4)
               {
                    echo "</tr><tr class=\"reqmochecked\"><td class='reqmochecked'>&nbsp;</td>";
                    $cpts = 0;
                }
                echo "<td class=\"reqmodatatitre\">&nbsp;".$f->lang($temp6)."&nbsp;<input type=\"text\" name=\"".$temp1[0]."\" value=\"\" size=\"30\" class=\"champFormulaire\" /></td>";
                echo "</td><td class='reqmochecked'>&nbsp;</td>";
                $cpts++;
              }
            else
            {
                if ($reqmo [$temp1 [0]] == "checked")
                {
                    if ($cptemp == 0)
                        echo "<tr class=\"reqmochecked\"><td class='reqmochecked'>&nbsp;</td>";
                    elseif ($cptemp == 4)
                    {
                        echo "</tr><tr class=\"reqmochecked\"><td class='reqmochecked'>&nbsp;</td>";
                        $cptemp = 0;
                    }
                    echo "<td class='reqmochecked0'><input type=\"checkbox\" value=\"Oui\" name=\"".$temp1[0]."\" size=\"40\" class=\"champFormulaire\" checked=\"checked\" />&nbsp;&nbsp;".$f->lang($temp6)."&nbsp;</td><td class='reqmochecked'>&nbsp;</td>";
                    $cptemp++;
                }
                else
                {
                    $temp3 = "";
                    $temp3 = $reqmo [$temp1 [0]];
                    if(!is_array($temp3)) 
                        $temp3 = substr ($temp3, 0, 6);
                    if ($temp3 == "select")
                    {
                        if ($cptsel == 0)
                           echo "<tr class=\"reqmochecked\" ><td class='reqmochecked'>&nbsp;</td>";
                       elseif ($cptsel == 4)
                       {
                           echo "</tr><tr class=\"reqmochecked\"><td class='reqmochecked'>&nbsp;</td>";
                           $cptsel = 0;
                       }
                       echo "<td class=\"reqmodatatitre\">".$f->lang($temp6)."&nbsp;";
                       echo "<select name=\"".$temp1[0]."\" class=\"champFormulaire\">";
                        $res1 = $f -> db -> query ($reqmo[$temp1[0]]);
                        if (DB :: isError($res1))
                            die ($res1 -> getMessage()." erreur ".$reqmo[$temp1[0]]);
                        while ($row1=& $res1->fetchRow())
                            echo "<option value=\"".$row1[0]."\">".$row1[1]."</option>";
                        echo "</select>";
                        $cptsel++;
                        echo "</td><td class='reqmochecked'>&nbsp;</td>";
                    }
                    else
                    {
                          if ($cptsel == 0)
                                echo "<tr class=\"reqmochecked\" ><td class='reqmochecked'>&nbsp;</td>";
                            elseif ($cptsel == 4)
                            {
                                echo "</tr><tr class=\"reqmochecked\"><td class='reqmochecked'>&nbsp;</td>";
                                $cptsel = 0;
                            }
                        echo "<td  class=\"reqmodatatitre\">".$f->lang($temp6)."&nbsp";
                        //
                        echo "<select name=\"".$temp1[0]."\" class=\"champFormulaire\">";
                        foreach ($reqmo [$temp1 [0]] as $elem)
                            echo "<option>".$elem."</option>";
                        echo "</select>";
                        $cptsel++;
                        echo "</td><td class='reqmochecked'>&nbsp;</td>";
                    }
                }
            }
            // re initialisation
            $temp1[0]="";
        }
        echo "</tr><tr><td></td></tr>";
        echo "<tr class=\"reqmochecked\" >";
        //
        echo "</td><td class='reqmochecked'>&nbsp;</td>";
        echo "<td class=\"reqmodatainput\" colspan='1'>".$f->lang("sortie")."&nbsp;";
        echo "<select name=\"sortie\" class=\"champFormulaire\">";
        echo "<option>csv</option>";
        echo "<option>tableau</option>";
        echo "</select>";
        echo "</td>";
        //
        echo "<td class='reqmochecked'>&nbsp;</td>";
        //
        echo "<td class=\"reqmodatainput\" colspan='3'>".$f->lang("separateur_champ")."&nbsp;";
        echo "<select name=\"separateur\" class=\"champFormulaire\">";
        echo "<option>;</option>";
        echo "<option>|</option>";
        echo "<option>,</option>";
        echo "</select>";
        echo "</td>";
        //
        echo "</td><td class='reqmochecked'>&nbsp;</td>";
        //
        echo "<td class=\"reqmodatainput\" >".$f->lang("limite")."&nbsp;";
        echo "<input type=\"text\" name=\"limite\" value=\"100\" size=\"5\" class=\"champFormulaire\" />";
        echo "</td>";
        //
        echo "<td class='reqmochecked'>&nbsp;</td>";
        //
        echo "</tr><tr><td></td></tr>";
        //
       //echo "<tr><td class='reqmochecked' colspan='9'>&nbsp;</td></tr>";
         echo "</table></form>";
         echo "<br>";
        //aide
        //echo "<fieldset class='recherche2'> <legend  align='center'> <img src='../img/ico_aide.gif' align='top' vspace='2' hspace='0' border='0' alt='aide'></LEGEND></tr>";
        echo "<fieldset class='recherche2'>";
        echo "<center><i><table border='0' >";
        echo "<tr><td class='reqmochecked0'><img src='../img/checkbox.png' hspace='2' style='vertical-align:middle' alt='' title=''></td><td>".$f->lang("afficher_ou_non")."&nbsp;&nbsp;&nbsp;&nbsp;</td>";
        echo "<td class='reqmodatatitre'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$f->lang("criteres_recherche_tri")."&nbsp;&nbsp;&nbsp;&nbsp;</td>";
        echo "<td class='reqmodatainput'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$f->lang("criteres_sortie")."&nbsp;&nbsp;&nbsp;&nbsp;</td>";
        echo "</tr></table></i></center>";
        echo"</fieldset>";
    }
    else // On affiche le csv ou le tableau
    {
        $temp = explode ("[",$reqmo["sql"]);
        for($i = 1; $i < sizeof ($temp); $i++)
        {
            $temp1 = explode ("]", $temp [$i]);
            $temp4 = explode (" as ", $temp1 [0]);
            if (isset ($temp4 [1]))
                $temp5 = $temp4 [1]; // uniquement as
            else
                $temp5 = $temp1 [0]; // en entier
            if (isset ($_POST [$temp5]))
                $temp2 = $_POST [$temp5];
            else
                $temp2 = "";
            if($reqmo[$temp5]=="checked")
            {
                if ($temp2 == 'Oui')
                {
                    $reqmo ['sql'] = str_replace ("[".$temp1[0]."]",$temp1[0],$reqmo['sql']);
                }
                else
                {
                    $reqmo['sql']=str_replace("[".$temp1[0]."],",'',$reqmo['sql']);
                    $reqmo['sql']=str_replace(",[".$temp1[0]."]",'',$reqmo['sql']);
                    $reqmo['sql']=str_replace(", [".$temp1[0]."]",'',$reqmo['sql']);
                    $reqmo['sql']=str_replace("[".$temp1[0]."]",'',$reqmo['sql']);
                }
            }
            else
            {
                $reqmo['sql']=str_replace("[".$temp1[0]."]",$temp2,$reqmo['sql']);
            }
            $temp1[0]="";
        }

        $blanc = 0;
        $temp = "";
        for($i=0;$i<strlen($reqmo['sql']);$i++)
        {
            if (substr($reqmo['sql'],$i,1)==chr(13) or substr($reqmo['sql'],$i,1)==chr(10) or substr($reqmo['sql'],$i,1)==chr(32))
            {
                if ($blanc==0)
                    $temp=$temp.chr(32);
                $blanc=1;
            }
            else
            {
                $temp=$temp.substr($reqmo['sql'],$i,1);
                $blanc=0;
            }
        }
        $reqmo['sql']=$temp ;
        $reqmo['sql']=str_replace(',,',',',$reqmo['sql']);
        $reqmo['sql']=str_replace(', ,',',',$reqmo['sql']);
        $reqmo['sql']=str_replace(', from',' from',$reqmo['sql']);
        $reqmo['sql']=str_replace('select ,','select ',$reqmo['sql']);
        // post limite
        if (isset($_POST['limite']))
            $limite = $_POST['limite'];
        else
            $limite = 100;
        // post  sortie
        if (isset ($_POST['sortie']))
            $sortie= $_POST['sortie'];
        else
            $sortie ='tableau';
        // post  separateur de champ (csv)
        if (isset ($_POST['separateur']))
            $separateur= $_POST['separateur'];
        else
            $separateur =';';
        // limite uniquement pour tableau
        if ($sortie =='tableau')
            $reqmo['sql']= $reqmo['sql']." limit ".$limite;
        // execution de la requete
        $res = $f -> db -> query ($reqmo['sql']);
        if (DB :: isError($res))
            die($res->getMessage()."erreur ".$reqmo['sql']);
        else
        {
            $info = $res -> tableInfo ();
            if ($sortie =='tableau')
            {
                echo "<table class='sortie_tab' border='0'><tr class='tabCol'>";
                foreach($info as $elem)
                    echo "<td>".$elem['name']."</td>";
                echo "</tr>";
                while ($row=& $res->fetchRow())
                {
                    echo "<tr class='tabData'>";
                    $i=0;
                    foreach($row as $elem)
                    {
                        if (is_numeric($elem))
                            echo "<td align='right'>";
                        else
                            echo "<td>";
                        echo $elem."</td>";
                        $i++;
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
            else
            {
                $inf="";
                foreach ($info as $elem)
                {
                    //echo $elem['name'].$separateur;
                    $inf=$inf.$elem['name'].$separateur;
                }
                //echo "<br />";
                $inf .= "\n";
                while ($row=& $res->fetchRow())
                {
                    $i=0;
                    foreach($row as $elem)
                    {
                        //echo $elem.$separateur;
                        $inf .= $elem.$separateur;
                        $i++;
                    }
                    //echo "<br />";
                    $inf .= "\n";
                }
                $nom_fichier="export_".$obj.".csv";
                $fic = fopen ("../tmp/".$nom_fichier,"w");
                fwrite ($fic, $inf);
                fclose ($fic);
//                $msg = $f->lang("voir")."&nbsp;".$f->lang("resultat")."&nbsp;".$f->lang("recherche")." : ";
//                $msg .= "<a href=\"javascript:traces('".$nom_fichier."');\"><img src=\"../img/voir.png\" style='vertical-align:middle' alt=\"".$f->lang("voir")."&nbsp;".$nom_fichier."\" title=\"".$f->lang("voir")."&nbsp;".$nom_fichier."\" /></a><br />";
//                $msg .= $f->lang("resultat")."&nbsp;/tmp/".$nom_fichier.".<br />";
//                echo $msg;

                // modification du 25 aout pour acces enregistrement sur clic
                $msg = $f->lang("message_1");
                $msg .= "<a href=\"javascript:traces('".$nom_fichier."');\"><img src=\"../img/voir.png\" hspace='5' alt=\"Fichier export\" title=\"Fichier export\" /></a><br />";
                $msg .= $f->lang("message_2")."\"".$nom_fichier."\".<br />";
                echo $msg;
            }
            echo "<br /><center><a href=\"../scr/requeteur.php?obj=".$obj."&amp;step=0\"><img src=\"../img/retour.png\" alt=\"".$f->lang("retour")."\" title=\"".$f->lang("retour")."\" /></a></center>";
        }
    }
    
}
else
{
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