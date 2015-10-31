<?php
//$Id: calendrierhaut2.php,v 1.1 2008-07-17 11:31:33 jbastide Exp $
//fr 10 juiller 2004 Calendrier
function lang($texte){
         include ("../dyn/var.inc");
         if(!isset($langue)) $langue='francais';
         include ("../lang/".$langue.".inc");
         if(!isset($lang[$texte])) $lang[$texte]='<i>'.$texte.'</i>';
         return $texte=$lang[$texte];
}
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" lang=\"fr\">\n";
echo "\t<head>\n";
echo "\t\t<meta http-equiv=\"Content-Type\" content=\"text/html;charset=iso-8859-1\" />\n";
echo "\t\t<title>".lang("title_html")."</title>\n";
echo "\t</head>\n";
echo "<BODY onload='javascript:document.f1.submit();'  bgcolor='#FFBA00'>";
echo "<form method='post' name='f1' action='calendrierbas2.php?origine=".$_GET['origine']."' target='bas'>";
$moistoday= intval(date("m")) ;
$moislibelle= array("Janvier","Fevrier","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre");
echo "<SELECT name='mois' onchange='javascript:document.f1.submit();'>";
    for($mois=1;$mois<13;$mois++){
         if($mois==$moistoday)
         echo "<option value=".$mois." selected>".lang($moislibelle[$mois-1])."</option>";
         else
         echo "<option value=".$mois.">".lang($moislibelle[$mois-1])."</option>";
    }
    echo "</select>";
    echo "&nbsp;<SELECT name='annee' onchange='javascript:document.f1.submit();'>";
    for($annee=-120;$annee<+2;$annee++){
        $anneeaffiche=date("Y")+$annee;
        if($anneeaffiche== date("Y"))
        echo "<option value=".$anneeaffiche." selected>".$anneeaffiche."</option>";
        else echo "<option value=".$anneeaffiche.">".$anneeaffiche."</option>";
    }
echo "</select></form></body></html>";
?>