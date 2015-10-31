<?php
//$Id: calendrierbas.php,v 1.2 2008-07-17 09:44:14 jbastide Exp $ 
//fr 10/07/04 Calendrier
function lang($texte){
         include ("../dyn/var.inc");
         if(!isset($langue)) $langue='francais';
         include ("../lang/".$langue.".inc");
         if(!isset($lang[$texte])) $lang[$texte]='<i>'.$texte.'</i>';
         return $texte=$lang[$texte];
}
if(isset($_POST['mois']))
   $mois=$_POST['mois'];
else
   $mois=date("m");

if(isset($_POST['annee']))
   $annee=$_POST['annee'];
else
   $annee=date("Y");
//
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" lang=\"fr\">\n";
    echo "\t<head>\n";
    echo "\t\t<meta http-equiv=\"Content-Type\" content=\"text/html;charset=iso-8859-1\" />\n";
    echo "\t\t<title>".lang("title_html")."</title>\n";
    echo "\t</head>\n";
    echo "<body bgcolor='#FDD548'>";
    echo "<form name='f1'>";
    echo "<input type='hidden' name='mois' value='".$mois."'>";
    echo "<input type='hidden' name='annee' value='".$annee."'>";
    echo "</form>";
    echo "<table bgcolor='#ffffff' border='1' bordercolor='#FBC8AE' cellpadding='0' cellspacing='0'>";
    echo "<tr bgcolor='#F59C44' style='color:#562005'>";
    echo "<td width='30'>".lang("Lun")."."."</td>";
    echo "<td width='30'>".lang("Mar")."."."</td>";
    echo "<td width='30'>".lang("Mer")."."."</td>";
    echo "<td width='30'>".lang("Jeu")."."."</td>";
    echo "<td width='30'>".lang("Ven")."."."</td>";
    echo "<td width='30'>".lang("Sam")."."."</td>";
    echo "<td width='30'>".lang("Dim")."."."</td></tr><tr>";
    //recherche du 1er jour
    $anneeaff=$annee;
    while ($anneeaff<1971) $anneeaff+=28;
    $pjour = mktime(0,0,0,$mois,1,$anneeaff);
    $j=(int) strftime("%w",$pjour); //format numero de jour
    // 0=dimanche 1=lundi 2=mardi 3=mercredi 4=Jeudi 5=Vendredi 6=samedi
     if($j==0) //dimanche = 7 et non 0
     $j=7;
     $j=$j-1; //nbre d'espace à sauter en fonction du 1er jour
     if($j!=0)//lundi pas d espace
     echo "<td colspan=$j>&nbsp;</td>";
     for($i=1;$i<32;$i++){
       if (checkdate($mois,$i,$annee)){
       echo "<td align='center' style='CURSOR: hand;' onmouseover=this.style.backgroundColor='#9999ff' onmouseout=this.style.backgroundColor='#FFFFFF' onclick='javascript:recupdate($i);'>";
       echo $i;
       echo "</td>";
       }
        $j++;
        if(($j %7)==0)
        echo "</tr><tr>";
     }
     echo "</table>";

?>

    <script language="javascript">
    function recupdate(MyElement)
    {   
        affMois=""+document.f1.mois.value;
        if (affMois.length<2) affMois="0"+ affMois;
        affMy=""+MyElement;
        if (affMy.length<2) affMy="0"+ affMy;
    parent.opener.document.f1.<?php echo $_GET['origine']?>.value = affMy + "/" + affMois + "/" +  document.f1.annee.value;
    parent.close();
    }
    </script>
</BODY>
</HTML>