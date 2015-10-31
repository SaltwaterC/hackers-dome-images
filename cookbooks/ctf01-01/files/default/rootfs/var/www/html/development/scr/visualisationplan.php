<?php   
//$Id: visualisationplan.php,v 1.2 2008-07-17 09:44:14 jbastide Exp $
/*
localisation
*/
include ("../dyn/session.inc");
include("../dyn/var.inc");
require_once ($path_pear."DB.php");
include ("../dyn/connexion.php");
$plan='collineb.png';
// parametrage =================================================================
$DEBUG=0;
// =============================================================================
echo "<html>";
echo"<head>";
include("../dyn/entete.inc");
?>
<SCRIPT LANGUAGE="JavaScript">
//

// global declarations
var num = 0;
var posx;
var posy;
var origwidth;
var origheight;
var divimageleft;
var divimagetop;
var camapleft = new Array();
var camaptop = new Array();

function getPositionCurseur(e){
//ie
if(document.all){
  posx = event.clientX;
  posy  = event.clientY;
} else if(document.layers) { //netscape 4
  posx  = e.pageX;
  posy  = e.pageY;
} else if(document.getElementById) { //mozilla
  posx  = e.clientX;
  posy  = e.clientY;
}
}

// initialisation
function init() {
   divimageleft=0;
   divimagetop=0;
   origwidth = document.myimage.width;
   origheight = document.myimage.height;
   i=1;
   while (document.getElementById("camap"+i)) {
      camapleft[i]=parseInt(document.getElementById("camap"+i).style.left);
      camaptop[i]=parseInt(document.getElementById("camap"+i).style.top);
//alert("objet"+i+" L"+camapleft[i]+" T"+camaptop[i]);
      i++;
   }
   document.onmousemove = getPositionCurseur;
}

function changer() {
if (num == 0) {
   num = 1;
   document.myimage.width = origwidth*2;
   document.myimage.height = origheight*2;
   if (posx<(origwidth/4))
     divimageleft=0;
   else if (posx>(origwidth*3/4))
     divimageleft=-origwidth;
   else
     divimageleft=-(2*posx-(origwidth/2));
   if (posy<(origheight/4))
     divimagetop=0;
   else if (posy>(origheight*3/4))
     divimagetop=-origheight;
   else
     divimagetop=-(2*posy-(origheight/2));
   document.getElementById("divimage").style.left=divimageleft;
   document.getElementById("divimage").style.top=divimagetop;
   for(i=1;i<camapleft.length;i++) {
//alert("Objet"+i+" L"+document.getElementById("camap"+i).style.left+" T"+document.getElementById("camap"+i).style.top);
      document.getElementById("camap"+i).style.left=(camapleft[i]*2)+divimageleft;
      document.getElementById("camap"+i).style.top=(camaptop[i]*2)+divimagetop;
      document.images[i].width=parseInt(document.images[i].width)*2;
//pas necessaire car rapport image conserve
//      document.images[i].height=parseInt(document.images[i].height)*2;
   }
} else {
  num = 0;
  for(i=1;i<camapleft.length;i++) {
      document.getElementById("camap"+i).style.left=camapleft[i];
      document.getElementById("camap"+i).style.top=camaptop[i];
      document.images[i].width=parseInt(document.images[i].width)/2;
//pas necessaire car rapport image conserve
//      document.images[i].height=parseInt(document.images[i].height)/2;
//alert("Objet"+i+" L"+document.getElementById("camap"+i).style.left+" T"+document.getElementById("camap"+i).style.top);
  }
  document.myimage.width = origwidth;
  document.myimage.height = origheight
  document.getElementById("divimage").style.left=0;
  document.getElementById("divimage").style.top=0;
}
}

</SCRIPT>
<?php
echo "</head>";
if(isset($_GET['plan']))
    $plan=$_GET['plan'];
else
    $plan="";
$imageplan=$chemin_plan.$plan ;
echo "<body onLoad='init()'>";
if (file_exists($imageplan)) {
   list($width, $height, $type, $attr) = getimagesize($imageplan);
   echo "<DIV style='position:absolute;left:0;top:0;height:".$height."px;width:".$width."px;overflow:hidden;'>";
   echo "<DIV id='divimage' style='position:absolute; left:0;top:0'>";
   echo "<img name='myimage' onClick='changer()' src='".$imageplan."' border=1>";
   echo "</div>";
   //connexion ====================================================================
   $db=& DB :: connect($dsn, $db_option);
   if (DB :: isError($db)) {
       die($db->getMessage());
   }else{
       if($DEBUG==1)
       echo "La base ".$dsn['database']." est connectée.<br>";
       $sql= "select * from emplacement where plans ='".$plan."'";
       $res = $db->query($sql);
       if (DB :: isError($res))
          die($res->getMessage()."erreur ".$sql);
       else{
           $i=0;
           while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
                 $i++;
                 echo "<div id='camap$i' style='position:absolute;left:".
                 $row['positionx'].";top:".$row['positiony']."'>";
                 if($row['libre']=='Oui')
                     echo "<a href='form.php?obj=".$row['nature']."&idx=".
                     $row['emplacement'].
                     "'><img name='image$i' src='../img/libre.png' alt='".
                     $row['famille']."' border=0 ></a>";
                 else
                   if($row['terme']=='temporaire')
                     echo "<a href='form.php?obj=".$row['nature']."&idx=".
                     $row['emplacement'].
                     "'><img name='image$i' src='../img/temporaire.png' alt='".
                     $row['famille']."' border=0 ></a>";
                   else
                     echo "<a href='form.php?obj=".$row['nature']."&idx=".
                     $row['emplacement'].
                     "'><img name='image$i' src='../img/perpetuite.png' alt='".
                     $row['famille']."' border=0 ></a>";
                 echo "</div>";
       }}
   }
   echo "</div>";
   //
   // deconnexion
   $db->disconnect();
   if ($DEBUG == 1)
         echo "La base ".$dsn['database']." est déconnectée.<br>";
} else {
  echo "<DIV><H3>Image: $imageplan absente ou inexistante</H3></DIV>";
}
echo "</body></html>";

?>

