<?php
// $Id: menu.inc,v 1.15 2008-07-22 12:05:08 jbastide Exp $
if(file_exists("../dyn/menu.js")) {
  echo "<script language='javascript' src='../dyn/menu.js'></script>\n";
}
else {
  echo "<script language='javascript' src='../spg/menu.js'></script>\n";
}
//
echo "<link rel='stylesheet' type='text/css' href='../dyn/menu.css'>\n";
//
if (file_exists ("../dyn/menu_icone.inc"))
        include ("../dyn/menu_icone.inc");
if (isset($icone_unique)){
   if ($icone_unique==0){
      $ico="../img/pixel.gif";
   }
}
//
// initialisation
$colorSmenu="darkblue";
$m=0;
// initialisation session
if  (isset($_SESSION ['login']))
{
  if  ($_SESSION ['login']==""){
    $loginNom = "Identifiez Vous";
    $loginMenu = "../spg/login.php";
  }else{
    $loginNom = $_SESSION ['login'];
    $loginMenu = "../spg/login.php?dec=1";
  }
}
else
{
    $loginNom = "Identifiez Vous";
    $loginMenu = "../spg/login.php";
}
//======================================
echo "<div id='conteneurmenu'>\n";
// pour éviter le clignotement =================================================
echo "<script language='Javascript' type='text/javascript'>\n";
echo "preChargement()";
echo "</script>\n";
// menu1 =======================================================================
$m++;
$titre="&nbsp;".$this -> lang("scrutin");
if (isset($icone_unique)){
   if ($icone_unique==1){
      $ico="../img/pixel.gif";
   }else{
      $ico="../img/ico_scrutin.png";
   }
}else{
   $ico="../img/ico_scrutin.png";
}
//
$href="#";
echo "<p id='menu".$m."' class='menu' onmouseover=\"MontrerMenu('ssmenu".$m."');\" onmouseout='CacherDelai();'>";
echo "<a href='".$href."' onmouseover=\"MontrerMenu('ssmenu".$m."');\" onfocus=\"MontrerMenu('ssmenu".$m."');\">";
echo "<img src='".$ico."' style='vertical-align:middle' hspace='1' border='0'>";
echo $titre."</a>";
echo "</p>";

echo "<ul id='ssmenu".$m."' class='ssmenu' onmouseover='AnnulerCacher();'";
echo " onmouseout='CacherDelai();' onfocus='AnnulerCacher();'";
echo " onblur='CacherDelai();'>";
//
echo "<li><a href='../scr/scrutin.php'><img src='../img/ico_scrutin_defaut.png' style='vertical-align:middle' hspace='1' border='0'>".$this -> lang("scrutin")."&nbsp;".$this -> lang("par")."&nbsp;".$this -> lang("defaut")." : </a>";
if(isset($_SESSION['scrutin']))
    echo "&nbsp;<font class='parametre'>&nbsp;".$_SESSION['scrutin']."&nbsp;</font>";
else
   echo "<font id='idz1'>".$this -> lang("aucun")."&nbsp;".$this -> lang("scrutin")."&nbsp;".$this -> lang("par_defaut")."</font>";
echo "<li>";
echo "<li><a href='../scr/tab.php?obj=scrutin'><img src='../img/ico_scrutin_chx.png' style='vertical-align:middle' hspace='1' border='0'>".$this -> lang("scrutin")."</a></li>";
echo "<li><a href='../scr/tab.php?obj=agent'><img src='../img/ico_agent.png' style='vertical-align:middle' hspace='1' border='0'>".$this -> lang("agent")."</a></li>";
echo "<li><a href='../scr/tab.php?obj=elu'><img src='../img/ico_elu.png' style='vertical-align:middle' hspace='1' border='0'>".$this -> lang("elu")."</a></li>";
echo "</ul>";
// menu2 =======================================================================
$m++;
//
$titre="&nbsp;".$this -> lang("parametrage");
if (isset($icone_unique)){
   if ($icone_unique==1){
      $ico="../img/pixel.gif";
   }else{
      $ico="../img/ico_parametrage.png";
   }
}else{
   $ico="../img/ico_parametrage.png";
}
//
$href="#";
echo "<p id='menu".$m."' class='menu' onmouseover=\"MontrerMenu('ssmenu".$m."');\" onmouseout='CacherDelai();'>";
echo "<a href='".$href."' onmouseover=\"MontrerMenu('ssmenu".$m."');\" onfocus=\"MontrerMenu('ssmenu".$m."');\">";
echo "<img src='".$ico."' style='vertical-align:middle' hspace='1' border='0'>";
echo $titre."</a>";
echo "</p>";
echo "<ul id='ssmenu".$m."' class='ssmenu' onmouseover='AnnulerCacher();'";
echo " onmouseout='CacherDelai();' onfocus='AnnulerCacher();'";
echo " onblur='CacherDelai();'>";
echo " <font id='titremenu'>".$titre."<br></font>";
echo "<li><a href='../scr/tab.php?obj=canton'><img src='../img/ico_canton.png' style='vertical-align:middle' hspace='1' border='0'>&nbsp;".$this -> lang("canton")."</a></li>";
echo "<li><a href='../scr/tab.php?obj=bureau'><img src='../img/ico_bureau.png' style='vertical-align:middle' hspace='1' border='0'>&nbsp;".$this -> lang("bureau")."</a></li>";
echo "<hr id='trait'>";
echo "<li><a href='../scr/tab.php?obj=service'>&nbsp;".$this -> lang("service")."</a></li>";
echo "<li><a href='../scr/tab.php?obj=grade'>&nbsp;".$this -> lang("grade")."</a></li>";
echo "<li><a href='../scr/tab.php?obj=poste'>&nbsp;".$this -> lang("poste")."</a></li>";
echo "<li><a href='../scr/tab.php?obj=periode'>&nbsp;".$this -> lang("periode")."</a></li>";
echo "</ul>";
// menu3 =======================================================================
$m++;
//
$titre="&nbsp;".$this -> lang("edition");
if (isset($icone_unique)){
   if ($icone_unique==1){
      $ico="../img/pixel.gif";
   }else{
      $ico="../img/ico_edition.png";
   }
}else{
   $ico="../img/ico_edition.png";
}
//
$href="#";
echo "<p id='menu".$m."' class='menu' onmouseover=\"MontrerMenu('ssmenu".$m."');\" onmouseout='CacherDelai();'>";
echo "<a href='".$href."' onmouseover=\"MontrerMenu('ssmenu".$m."');\" onfocus=\"MontrerMenu('ssmenu".$m."');\">";
echo "<img src='".$ico."' style='vertical-align:middle' hspace='1' border='0'>";
echo $titre."</a>";
echo "</p>";
echo "<ul id='ssmenu".$m."' class='ssmenu' onmouseover='AnnulerCacher();'";
echo " onmouseout='CacherDelai();' onfocus='AnnulerCacher();'";
echo " onblur='CacherDelai();'>";
echo "<li>";
echo " <font id='titremenu'>".$titre."<br></font>";
echo"</li>";
echo "<li><a href='../trt/composition_bureau.php'>&nbsp;".$this -> lang("composition")."&nbsp;".$this -> lang("bureau")." </a></li>";
echo "<li><a href='../trt/convocation_agent.php'>&nbsp;".$this -> lang("convocation")."&nbsp;".$this -> lang("des").$this -> lang("agent")."&nbsp;".$this -> lang("pluriel")."</a></li>";
echo "<li><a href='../trt/convocation_president.php'>&nbsp;".$this -> lang("convocation")."&nbsp;".$this -> lang("des").$this -> lang("president")."&nbsp;".$this -> lang("pluriel")."</a></li>";
echo "<li><a href='../trt/recepisse.php'>&nbsp;".$this -> lang("recepisse")."</a></li>";
echo "</ul>";
// menu4 =======================================================================
$m++;
//
$titre="&nbsp;".$this -> lang("traitement");
if (isset($icone_unique)){
   if ($icone_unique==1){
      $ico="../img/pixel.gif";
   }else{
      $ico="../img/ico_traitement.png";
   }
}else{
   $ico="../img/ico_traitement.png";
}
//
$href="#";
echo "<p id='menu".$m."' class='menu' onmouseover=\"MontrerMenu('ssmenu".$m."');\" onmouseout='CacherDelai();'>";
echo "<a href='".$href."' onmouseover=\"MontrerMenu('ssmenu".$m."');\" onfocus=\"MontrerMenu('ssmenu".$m."');\">";
echo "<img src='".$ico."' style='vertical-align:middle' hspace='1' border='0'>";
echo $titre."</a>";
echo "</p>";
echo "<ul id='ssmenu".$m."' class='ssmenu' onmouseover='AnnulerCacher();'";
echo " onmouseout='CacherDelai();' onfocus='AnnulerCacher();'";
echo " onblur='CacherDelai();'>";
echo "<li>";
echo " <font id='titremenu'>".$titre."<br></font>";
echo"</li>";
echo "<li><a href='../scr/reqmo.php'>&nbsp;".$this -> lang("requetes_memorisees")."</a></li>";
echo "<li><a href='../trt/affectation_heure.php'>&nbsp;".$this -> lang("affectation")."&nbsp;".$this -> lang("des")."&nbsp;".$this -> lang("heure").$this -> lang("pluriel")."</a></li>";
echo "<li><a href='../trt/transfert_candidature.php'>&nbsp;".$this -> lang("transfert")."&nbsp;".$this -> lang("candidature")."</a></li>";
echo "<li><a href='../trt/transfert_affectation.php'>&nbsp;".$this -> lang("transfert")."&nbsp;".$this -> lang("affectation")."</a></li>";

echo "</ul>";
// menu5 =======================================================================
$m++;
$titre= "&nbsp;".$this -> lang("a_propos");
if (isset($icone_unique)){
   if ($icone_unique==1){
      $ico="../img/pixel.gif";
   }else{
      $ico="../img/ico_a_propos.png";
   }
}else{
   $ico="../img/ico_a_propos.png";
}
$href="#";
echo "<p id='menu".$m."' class='menu' onmouseover=\"MontrerMenu('ssmenu".$m."');\" onmouseout='CacherDelai();'>\n";
echo "\t<a href='".$href."' onmouseover=\"MontrerMenu('ssmenu".$m."');\" onfocus=\"MontrerMenu('ssmenu".$m."');\">\n";
echo "\t<img src='".$ico."' style='vertical-align:middle' hspace='1' border='0'>";
echo $titre."</a>\n";
echo "</p>\n\n";
echo "<ul id='ssmenu".$m."' class='ssmenu' onmouseover='AnnulerCacher();'";
echo " onmouseout='CacherDelai();' onfocus='AnnulerCacher();'";
echo " onblur='CacherDelai();'>\n";
echo "\t<li>";
echo " <font id='titremenu'>".$titre."<br></font>";
echo"</li>\n";

echo "\t<li><a href='../spg/doc.php'>&nbsp;".$this -> lang("documentation")."</a></li>\n";
echo "\t<li><a href='http://www.openmairie.org' target=_blank>&nbsp;".$this -> lang("site")."&nbsp;".
$this -> lang("openmairie")."</a></li>\n";
echo "</ul>\n\n";
// menu6 =======================================================================
$m++;
//
$titre="&nbsp;".$this -> lang("administration");
if (isset($icone_unique)){
   if ($icone_unique==1){
      $ico="../img/pixel.gif";
   }else{
      $ico="../img/ico_admin.png";
   }
}else{
   $ico="../img/ico_admin.png";
}
//
$href="../scr/tab.php?obj=utilisateur";
echo "<p id='menu".$m."' class='menu' onmouseover=\"MontrerMenu('ssmenu".$m."');\" onmouseout='CacherDelai();'>\n";
echo "\t<a href='".$href."' onmouseover=\"MontrerMenu('ssmenu".$m."');\" onfocus=\"MontrerMenu('ssmenu".$m."');\">\n";
echo "\t<img src='".$ico."' style='vertical-align:middle' hspace='1' border='0'>";
echo $titre."</a>\n";
echo "</p>\n\n";
echo "<ul id='ssmenu".$m."' class='ssmenu' onmouseover='AnnulerCacher();'";
echo " onmouseout='CacherDelai();' onfocus='AnnulerCacher();'";
echo " onblur='CacherDelai();'>\n";
echo "\t<li>";
echo " <font id='titremenu'>".$titre."<br></font>";
echo"</li>\n";
echo "\t<li><a href='../scr/tab.php?obj=collectivite'>&nbsp;".$this -> lang("collectivite")."</a></li>\n";
echo "\t<hr id='trait'>\n";
echo "\t<li><a href='../scr/tab.php?obj=profil'>&nbsp;".$this -> lang("gestion")."&nbsp;".$this -> lang("profil")."</a></li>\n";
echo "\t<li><a href='../scr/tab.php?obj=utilisateur'>&nbsp;".$this -> lang("gestion")."&nbsp;".$this -> lang("utilisateur")."</a></li>\n";
echo "\t<li><a href='../scr/tab.php?obj=droit'>&nbsp;".$this -> lang("gestion")."&nbsp;".$this -> lang("droit_acces")."</a></li>\n";
echo "\t<hr id='trait'>\n";
echo "\t<li><a href='../scr/txtab.php?obj=lettretype'>&nbsp;".$this -> lang("lettretype")."</a></li>\n";
echo "\t<li><a href='../scr/txtab.php?obj=etat'>&nbsp;".$this -> lang("etat")."</a></li>\n";
echo "\t<li><a href='../scr/txtab.php?obj=sousetat'>&nbsp;".$this -> lang("sous_etat")."</a></li>\n";
echo "</ul>\n\n";
echo "</div>\n";
//
echo "<script language='Javascript' type='text/javascript'>Chargement();</script>\n";
?>

