<?php
function lang($texte){
         include ("../../dyn/var.inc");
         if(!isset($langue)) $langue='francais';
         include ("../../lang/".$langue.".inc");
         if(!isset($lang[$texte])) $lang[$texte]='<i>'.$texte.'</i>';
         return $texte=$lang[$texte];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
    <title><?php echo lang("aide")."&nbsp".lang("title_html"); ?></title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head> 

<body>
<b><?php echo lang("sommaire"); ?></b><br><br>

<?php
    include ("../../dyn/var.inc");
    $dir = getcwd ();
    $l=0;
    $l= 4+strlen($langue);
    $dir = substr ($dir, 0, strlen ($dir) - $l)."/doc/".$langue."/";
    $dossier = opendir ($dir);
    $tab = array ();
    while ($entree = readdir ($dossier))
    {
        if (strstr ($entree, ".html"))
            array_push ($tab, array ('file' => substr($entree, 0, strlen ($entree) - 5))); 
    }
    asort ($tab);
    closedir ($dossier);
    echo "<table><tr>";
    foreach ($tab as $elem)
    {
        echo "<tr><td><img src=\"../../img/ico_fleche.png\" hspace='10' alt=\"-\" /><a href='../".$langue."/".$elem ['file'].".html')\">".lang($elem ['file'])."</a></td>";
    }
    echo "</tr></table>";
echo "</body>";
?>