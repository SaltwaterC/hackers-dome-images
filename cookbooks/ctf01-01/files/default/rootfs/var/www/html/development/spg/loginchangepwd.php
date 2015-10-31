<?php
// $Id: loginchangepwd.php,v 1.2 2008-07-17 09:44:15 jbastide Exp $
/*
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
// initialisation
$DEBUG=0;
$error = "";
$idUtilisateur=0;
/**
 * Paramètres
 */
    $obj = "";
    $ent="changer->mot_de_passe";

/**
 * Classe utils ()
 */
    $f = new utils ();
    $f -> headerhtml ();
    $f -> collectivite ();
    $f -> droit ($obj);
    $f -> header (1, $ent);
    //
    echo "\n<div id=\"content\">\n";
    if (!isset($_GET['step']) ){
       $step=0 ;
    }else{
       $step=$_GET['step'];
    }
    if ( $step==1 ){
       $pwd = md5($_POST['pwd']);
       $pwd1= $_POST['pwd1'];
       //$pwd = ($_POST['pwd']);
         if($DEBUG==1)
            echo "La base ".$dsn['database']." est connectée.<br>";
       //"FROM ".USER." ".
         $sql =  "SELECT * ".
                 "from utilisateur ".
                 "WHERE login = '".$_SESSION['login']."' ".
                 "AND Pwd = '".$pwd."' ";
         $res = $f -> db->query($sql);
         //echo $sql;
         if (DB :: isError($res))
               die($res->getMessage());
         else{
         while ($row=& $res->fetchRow()){
            $idUtilisateur=$row[0];
         }
         //$res->free;
         if ( $idUtilisateur==0 or $pwd1<>$_POST["pwd2"]) {
          if($idUtilisateur==0)
              $error= $f -> lang("mot_de_passe")."&nbsp;".$f -> lang("incorrect");
           if( $pwd1<>$_POST["pwd2"])
              $error= $error."<br>".$f -> lang("saisie")."&nbsp;".$f -> lang("incorrect")." ".$f -> lang("du")." ".$f -> lang("nouveau")." ".$f -> lang("mot_de_passe");
          echo "<table class=\"formErreur\"><tr class=\"formErreur\"><td><i>".$error."</i></td></tr></table>";
          //unset($step);
              
         }
         else {
          //setcookie($cookie,$id,time()+3600,"/");
          $valF["pwd"]=md5($pwd1);
          $cle= "idutilisateur=".$idUtilisateur;
          $res= $f -> db->autoExecute("utilisateur",$valF,DB_AUTOQUERY_UPDATE,$cle);
          echo "<div class=\"valid\"><i>". $f -> lang("votre")."&nbsp;".$f -> lang("mot_de_passe")."&nbsp;".$f -> lang("est_valide")." </i></div>" ;
         }

         }
    }
    echo "</table>";
    /* Identification */
    if ($step==0 )
    {

       $step=1;
       echo "<FORM action='loginchangepwd.php?step=".$step."'  method=POST  name=f1 >";
       echo "<table>";
       echo "<tr>";
       echo "<td>".$f -> lang("ancien")."&nbsp;".$f -> lang("mot_de_passe")."</td>";
       echo "<td  colspan='4'><INPUT type='password' name='pwd' tabindex=1 size=15 class='champFormulaire' ></td>";

       echo "<tr> ";
       echo "<td>".$f -> lang("nouveau")."&nbsp;".$f -> lang("mot_de_passe")."</td>";
       echo "<td><INPUT type='password' name='pwd1' tabindex=2 size=19 class='champFormulaire' ></td>";
       echo "<td>".$f -> lang("deuxieme")."&nbsp".$f -> lang("saisie")."&nbsp;".$f -> lang("du")."&nbsp;".$f -> lang("nouveau")."&nbsp;".$f -> lang("mot_de_passe")."</td>";
       echo "<td><INPUT type='password' name='pwd2' tabindex=3 size=19 class='champFormulaire' ></td>";
       echo "<td rowspan=2><center><input type='submit' tabindex=70 value='".$f -> lang("valider")."' style='".$styleBouton."'  border=0></center></td></tr>";
       echo "</tr>";
       echo "</table>";
       echo "</form>";
    }
    echo "\n</div>\n";
    $f -> footer ();
    $f -> deconnexion (); 
    $f -> footerhtml ();
?>

