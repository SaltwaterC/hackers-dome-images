<?php
    echo "<table class='tabcol' border='0' width='100%'>";
    echo "<tr>";
    echo "<td valign='top'  rowspan='3'>";
    echo "<fieldset class='tb'><legend class='tb_aplli_titre'>&nbsp;&nbsp;".$f -> lang("scrutin")."&nbsp;&nbsp</legend>";
    echo "<div><br><img src='../img/ico_scrutin_defaut.png' style='vertical-align:middle' hspace='1' border='0'>&nbsp;&nbsp;<a href='../scr/scrutin.php' class='lien' >".$f -> lang("scrutin")."&nbsp;".$f -> lang("par_defaut")."</a>&nbsp;&nbsp;";
    if(isset($_SESSION['scrutin'])){
       echo " ( ".$f -> lang("scrutin_par_defaut")."&nbsp;:&nbsp;&nbsp;<font id='idz0'>&nbsp;".$_SESSION['scrutin']."&nbsp;</font>&nbsp;)";
    }else {
       echo "<font id='idz0'>".$f -> lang("aucun")."&nbsp;".$f -> lang("scrutin")."&nbsp;".$f -> lang("par_defaut")."</font>";
    }
    echo "</div>";
    echo "<div><br><a href='../scr/tab.php?obj=scrutin'><img src='../img/ico_scrutin_chx.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;".$f -> lang("scrutin")."</a></div>";
    echo "<div><br><a href='../scr/tab.php?obj=agent'><img src='../img/ico_agent.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;".$f -> lang("agent")."</a></div>";
    echo "<div><br><a href='../scr/tab.php?obj=elu'><img src='../img/ico_elu.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;".$f -> lang("elu")."</a></div>";
    echo "<br></fieldset>";
    echo "</td>";
    //
    echo "<td valign='top'>";
    echo "<fieldset class='tb'>";
    echo "<legend class='tb_aplli'><img src='../img/ico_traitement.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;&nbsp;".$f -> lang("traitement")."&nbsp;&nbsp;</legend>";
    echo "<div class='db'><a href='../trt/affectation_heure.php'><img src='../img/tb_fleche.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;".$f -> lang("affectation")."&nbsp;".$f -> lang("heure").$f -> lang("pluriel")."</a></div>";
      echo "</fieldset></td>";
    echo "<td valign='top'>";
    echo "<fieldset class='tb'>";
    echo "<legend class='tb_aplli'><img src='../img/ico_import.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;&nbsp;".$f -> lang("transfert")."&nbsp;&nbsp;</legend>";
    echo "<div class='db'><a href='../trt/transfert_candidature.php'><img src='../img/tb_fleche.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;".$f -> lang("transfert")."&nbsp;".$f -> lang("de")."&nbsp;".$f -> lang("candidature").$f -> lang("pluriel")."</a></div>";
    echo "<div class='db'><a href='../trt/transfert_affectation.php'><img src='../img/tb_fleche.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;".$f -> lang("transfert")."&nbsp;".$f -> lang("de")."&nbsp;".$f -> lang("affectation").$f -> lang("pluriel")."</a></div>";
    echo "</fieldset>";
    echo "</td></tr>";
    //
    ///
    echo "<tr>";
    echo "<td valign='top' colspan='2'>";
    echo "<fieldset class='tb'>";
    echo "<legend class='tb_aplli' ><img src='../img/ico_pdf.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;&nbsp;".$f -> lang("edition")."&nbsp;&nbsp;</legend>";
    echo "<a href='../trt/composition_bureau.php'><img src='../img/tb_fleche.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;".$f -> lang("composition_des_bureaux")."</a>&nbsp;&nbsp;";
    echo "<a href='../trt/convocation_agent.php'><img src='../img/tb_fleche.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;".$f -> lang("convocation")."&nbsp;".$f -> lang("des")."&nbsp;".$f -> lang("agent").$f -> lang("pluriel")."</a>&nbsp;&nbsp;";
    echo "<a href='../trt/convocation_president.php'><img src='../img/tb_fleche.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;".$f -> lang("convocation")."&nbsp;".$f -> lang("des")."&nbsp;".$f -> lang("president").$f -> lang("pluriel")."</a>&nbsp;&nbsp;";
    echo "<a href='../trt/recepisse.php'><img src='../img/tb_fleche.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;".$f -> lang("recepisse")."</a>&nbsp;&nbsp;";
    echo "</fieldset>";
    echo "</td></tr>";
    //
    echo "<td valign='top'>";
    echo "<fieldset class='tb'>";
    echo "<legend class='tb'><img src='../img/ico_parametrage.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;Paramétrage&nbsp;".$f -> lang("lettretype")."&nbsp;/&nbsp;".$f -> lang("etat")."</legend>";
    echo "<div class='db'><a href='../scr/txtab.php?obj=lettretype'><img src='../img/tb_fleche.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;".$f -> lang("lettretype")."</a>&nbsp;&nbsp;</div>";
    echo "<div class='db'><a href='../scr/txtab.php?obj=etat'><img src='../img/tb_fleche.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;".$f -> lang("etat")."</a>&nbsp;&nbsp;</div>";
     echo "<div class='db'><a href='../scr/txtab.php?obj=sousetat'><img src='../img/tb_fleche.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;".$f -> lang("sousetat")."</a>&nbsp;&nbsp;</div>";
    echo "</fieldset>";
    echo "</td>";
    //
     echo "<td valign='top'>";
    echo "<fieldset class='tb'>";
    echo "<legend class='tb'>&nbsp;&nbsp;".$f -> lang("requetes_memorisees")."&nbsp;&nbsp;</legend>";
    echo "<div class='db'><a href='../scr/reqmo.php'><img src='../img/ico_reqmo.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;".$f -> lang("lancement")."</a></div>";
    echo "</fieldset>";
   echo "</td></tr>";
    //
    echo "<tr><td valign='top'>";
    if (isset($global_tdb)){
     if ($global_tdb==1){
         if (file_exists ("../dyn/recherche.inc")){
            echo "<fieldset class='tb'>";
            echo "<legend class='tb'>&nbsp;&nbsp;".$f -> lang("recherche_globale")."&nbsp;&nbsp;</legend>";
            echo "<div class='db'>";
            include ("../dyn/recherche.inc");
            include ("../scr/recherche.php");
            echo "</div>";
            echo "</fieldset>";
         }
     }
    }
    echo "</td>";
    //
    echo "<td valign='top'>";
    echo "<fieldset class='tb'>";
    echo "<legend class='tb_aplli'><img src='../img/ico_parametre.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;&nbsp;".$f -> lang("parametrage")."&nbsp;&nbsp;</legend>";
    echo "<div><br><a href='../scr/tab.php?obj=canton'><img src='../img/tb_fleche.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;&nbsp;".$f -> lang("canton")."</a></div>";
    echo "<div><br><a href='../scr/tab.php?obj=bureau'><img src='../img/tb_fleche.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;&nbsp;".$f -> lang("bureau")."</a></div>";
    echo "<div><br><a href='../scr/tab.php?obj=service'><img src='../img/tb_fleche.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;&nbsp;".$f -> lang("service")."</a></div>";
    echo "<br></fieldset>";
    echo "</td>";
     echo "<td valign='top'>";
    echo "<fieldset class='tb'>";
    echo "<legend class='tb_aplli'><img src='../img/ico_parametre.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;&nbsp;".$f -> lang("parametrage")."&nbsp;&nbsp;</legend>";
    echo "<div><br><a href='../scr/tab.php?obj=grade'><img src='../img/tb_fleche.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;&nbsp;".$f -> lang("grade")."</a></div>";
    echo "<div><br><a href='../scr/tab.php?obj=poste'><img src='../img/tb_fleche.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;&nbsp;".$f -> lang("poste")."</a></div>";
    echo "<div><br><a href='../scr/tab.php?obj=periode'><img src='../img/tb_fleche.png' alt='' title=''  style='vertical-align:middle'/>&nbsp;&nbsp;".$f -> lang("periode")."</a></div>";
    echo "<br></fieldset>";
    echo "</td>";
    //
    echo "</tr>";
    echo "</table>";
    if (isset($look_tdb)){
     if ($look_tdb==1){
        echo "<fieldset class='tb'>";
         if(isset($_GET['msgl'])){
              if($_GET['msgl']=="droits"){
                 echo "<legend class='tb'>&nbsp;&nbsp;".$f -> lang("ergonomie")." (".$f -> lang("vous_n_avez_pas")."&nbsp;".$f -> lang("les")."&nbsp;".$f -> lang("droit")."&nbsp;".$f -> lang("suffisants")."&nbsp;".$f -> lang("pour")."&nbsp".$f -> lang("valider")."&nbsp;".$f -> lang("votre")."&nbsp;".$f -> lang("selection")."&nbsp;&nbsp;</legend>";
              }else{
                 echo "<legend class='tb'>&nbsp;&nbsp;".$f -> lang("ergonomie")."&nbsp;&nbsp;</legend>";
              }
         }else{
            echo "<legend class='tb'>&nbsp;&nbsp;".$f -> lang("ergonomie")."&nbsp;&nbsp;</legend>";
         }
        echo "<div class='db'>- 1 -<a href='../scr/look.php?nolook=1'  OnMouseOver=img1.src='../img/look1m.png' OnMouseOut=img1.src='../img/look1.png' ><img name='img1' src='../img/look1.png'  alt='' title=''  style='vertical-align:middle'/></a></div>";
        echo "<div class='db'>- 2 -<a href='../scr/look.php?nolook=2' OnMouseOver=img2.src='../img/look2m.png' OnMouseOut=img2.src='../img/look2.png' ><img name='img2' src='../img/look2.png' alt='' title=''  style='vertical-align:middle'/></a></div>";
        echo "<div class='db'>- 3 -<a href='../scr/look.php?nolook=3' OnMouseOver=img3.src='../img/look3m.png' OnMouseOut=img3.src='../img/look3.png' ><img name='img3' src='../img/look3.png' alt='' title=''  style='vertical-align:middle'/></a></div>";
        echo "<div class='db'>- 4 -<a href='../scr/look.php?nolook=4' OnMouseOver=img4.src='../img/look4m.png' OnMouseOut=img4.src='../img/look4.png' ><img name='img4' src='../img/look4.png' alt='' title=''  style='vertical-align:middle'/></a></div>";
        echo "<div class='db'>- 5 -<a href='../scr/look.php?nolook=5' OnMouseOver=img5.src='../img/look5m.png' OnMouseOut=img5.src='../img/look5.png' ><img name='img5' src='../img/look5.png' alt='' title=''  style='vertical-align:middle'/></a></div>";
        echo "</fieldset>";
        echo " <br>";
       }
    }
?>