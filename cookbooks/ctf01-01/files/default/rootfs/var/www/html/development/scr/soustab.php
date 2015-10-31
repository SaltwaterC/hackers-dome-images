<?php
// $Id: soustab.php,v 1.3 2008-07-22 09:13:05 jbastide Exp $
$recherche="";
$premier=0;

// 16/02/2006 correction bug multi formulaire

// librairie utilisée =========================================================
include ("../sql/".$dsn['phptype']."/".$objsf.".inc");
    // variable droit
    $sql =  "SELECT profil from droit where droit= '".$objsf."'";
    $droit =$db->getOne($sql);
If ($_SESSION['profil'] >= $droit){
    if(!isset($href) or $href==array()){
       $href[0]['lien']= "sousform.php?idxformulaire=".$idx;
       $href[0]['id']= "&obj=".$objsf."&retourformulaire=".$obj;
       $href[0]['lib']= "<img src=../img/ajouter.gif border=0>";
       $href[1]['lien'] = "sousform.php?idx=";
       $href[1]['id']= "&obj=".$objsf."&retourformulaire=".$obj."&idxformulaire=".$idx;
       $href[1]['lib']= "";
       $href[2]['lien'] = "sousform.php?idx=";
       $href[2]['id']= "&ids=1&obj=".$objsf."&retourformulaire=".$obj."&idxformulaire=".$idx;
       $href[2]['lib']= "<img src='../img/supprimer.gif' border=0>";
      }
//*
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


?>
<script language="javascript">
    var pfenetre;
    var fenetreouverte=false;
function aide()
{
if(fenetreouverte==true)
       pfenetre.close();
pfenetre=window.open("../doc/<?php echo $obj?>.html","Aide","toolbar=no,scrollbars=yes,status=no, width=600,height=400,top=120,left=120");
fenetreouverte=true;
}
</script>
<?php

//==============================================================================
    if ($_SESSION['profil']>0){
      $tb= new tab($obj,$table, $serie,$champAffiche,$champRecherche,$tri,$selection);
      $tb->affichersousformulaire($premier,$recherche,$href,$db,$DEBUG);
    }else {
        echo "<div id='msgdroit'>".$f->lang("attention")."&nbsp;".$f->lang("droit").$f->lang("pluriel")."&nbsp;".$f->lang("insuffisant").$f->lang("pluriel")." - ".
        $f->lang("votre_profil_est")." : [".$_SESSION['profil']."]</div>";
    }
//==============================================================================
?>