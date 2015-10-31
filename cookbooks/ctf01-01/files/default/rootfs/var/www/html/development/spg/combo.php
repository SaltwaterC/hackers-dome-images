<?php
//$Id: combo.php,v 1.3 2008-09-22 09:08:01 jbastide Exp $

/*
Correlation entre 2 champs
D'après la saisie d'une valeur dans un champ d'origine
correle au travers d'une table un autre champ
$table= table sur lequel s effectue la recherche
$champOrigine = champ d origine => affectation de la valeur validée
$champCorrel = champ à affecter la valeur validée
$recherche = valeur du champ origine à rechercher
$zoneOrigine = champ de recherche sur la table
$zoneCorrel = champ en relation
$zoneCorrel2 = valeur du champ de selection (clause where)
$champCorrel2 = champ de selection (clause where)
*/
// modifications ===============================================================
//
// version 1.1 : possibilite de parametrage application par include   27/02/05
// include dyn/comboParametre.inc
// include dyn/comboAffichage.inc
// include dyn/comboRetour.inc
// =============================================================================
function lang($texte){
         include ("../dyn/var.inc");
         if(!isset($langue)) $langue='francais';
         include ("../lang/".$langue.".inc");
         if(!isset($lang[$texte])) $lang[$texte]='<i>'.$texte.'</i>';
         return $texte=$lang[$texte];
}
include ("../dyn/session.inc");
include ("../dyn/var.inc");
// classe(s) utilisée(s)
require_once ($path_pear."DB.php");
// parametrage =================================================================
$DEBUG=0;
// debut = 0 recherche sur la chaine
// debut = 1 recherche sur le debut de la chaine
  $debut=0 ;
  $longueurRecherche=1;
  $sql="";
// Recupération de champs
  $table=$_GET['table']; // table sur laquelle se fait la correlation
  $zoneOrigine=$_GET['zorigine']; // zone d'origine de la correlation
  $zoneCorrel= $_GET['zcorrel'];  // zone qui sera mise à jour par la correlation
  $recherche= $_GET['recherche']; // caracteres saisis dans la zone d'origine
  $champOrigine=$_GET['origine']; // valeur affectée à la zone d'origine
  $champCorrel=$_GET['correl'];   // valeur affectée à la zone correllée
// parametres de selection
  $champCorrel2=$_GET['correl2'];
  $zoneCorrel2= $_GET['zcorrel2'];
// =============================================================================

// Parmetre Specifique *********************************************************
// parametrage de $sql = requete de recherche specifique
// $longueurRecherche  = longueur autorise en recherche
// $debut = rrecherche au debut de zone ou compris dans la zone
include ("comboparametre.inc");
//******************************************************************************
include("../dyn/var.inc");
echo "<html>";
echo"<head>";
echo "</head>";
echo "<body>";
//
if($DEBUG==1){
  echo "champ origine =>".$champOrigine."<br>";
  echo "recherche     =>".$recherche."<br>";
  echo "table         =>".$table."<br>";
  echo "zone origine  =>".$zoneOrigine."<br>";
  echo "zone correl   =>".$zoneCorrel."<br>";
  echo "champ correl  =>".$champCorrel."<br>";
  echo "zone  correl 2=>".$zoneCorrel2."<br>";
  echo "champ correl 2=>".$champCorrel2."<br>";
}


if (strlen($recherche) > $longueurRecherche){
   // dsn
   include ("../dyn/connexion.php");
   $db=& DB :: connect($dsn, $db_option);
   if (DB :: isError($db)) {
    die($db->getMessage());
    }
    else{
        if($DEBUG==1)
        echo "La base ".$dsn['database']." est connectée.<br>";
    }
    If ($sql==""){
        if($debut==0){
            $sql="select * from ".$table." where ".$zoneOrigine." like '%".$recherche."%'";
        }else{
            $sql="select * from ".$table." where ".$zoneOrigine." like '".$recherche."%'";
        }
    }
    if($zoneCorrel2!="") // selection
        $sql=$sql." and ".$champCorrel2." like '".$zoneCorrel2."'";
    if ($DEBUG==1)
       echo $sql;
       $res = $db->query($sql);
       $nbligne=$res->numrows();
       if (DB :: isError($res))
           die("<option>".$res->getMessage()."</option>");
       else{
       if ($nbligne > 1){
       // ==============================
       // il y a  plusieurs lignes
       // ==============================
          if ($DEBUG == 1)
             echo "<option> La requête ".$sql." est exécutée.</option>>";
          echo "<center><br>".lang("verifiez_correspondance_avec")."&nbsp;".$champOrigine.".<br>";
          echo "<form name='f2'>";
          echo  "<select size=\"1\" name=\"".$champOrigine."\" class=\"champFormulaire\">";
          while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
              // parametrage standard
              $x=$row[$zoneCorrel];    // dans la zone correllée
              $y=$row[$zoneOrigine];   // dans la zone d'origine
              //$retourUnique= $row[$zoneOrigine];
              $aff=$row[$zoneCorrel]." - ".$row[$zoneOrigine];
              // AFFICHAGE SPECIFIQUE *************************************************
              // defintion du retour  unique d apres la table select = $retourUnique
              // definition affichage en table = $aff
              include ("comboaffichage.inc");
              // **********************************************************************
              //$opt= "<option value=\"".$row[$zoneCorrel]."£".$retourUnique."\">";
              $opt= "<option value=\"".$x."£".$y."£".$a."£".$b."£".$c."£".$d."£".$e."£".$f."\">";
              $opt=$opt.$aff."</option>";
              echo $opt;
          }
          echo "</select>";

          echo "<br><br><br><br><input type='submit' tabindex=70 value='".lang("valider")."' onclick='javascript:recup();'  style='".$styleBouton."'></center>";
          echo "</form>";
       }else{
           if ($nbligne==0)
                  echo "<br><br><CENTER>".lang("aucune_correspondance")."</CENTER>";
           else{
           // ====================================
           // il n y a qu une ligne => retour auto
           // ====================================
              while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
                    $x=$row[$zoneCorrel];    // dans la zone correllée
                    $y=$row[$zoneOrigine];   // dans la zone d'origine
                    // RETOUR SPECIFIQUE =======================================
                    // parametrage des retour dans les champs $x et $y
                    include ("comboretour.inc");
                    //==========================================================

            }
            //echo $y."-".$x."-".$champOrigine."-".$champCorrel;
?>
<script language="javascript">
// envoi des donnees dans le formulaire
// 1 seule ligne
opener.document.f1.<?php echo $champCorrel;?>.value = "<?php echo $x;?>";
opener.document.f1.<?php echo $champOrigine;?>.value = "<?php echo $y;?>";
this.close();
</script>
<?php
 }
       } }
?>
<script language="javascript">
//recuperation des données apres validation
// plusieurs lignes
function recup()
    {   
    var s = document.f2.<?php echo $champOrigine;?>.value;
    var x = s.split( "£" ); 
    opener.document.f1.<?php echo $champOrigine;?>.value = x[1];
    opener.document.f1.<?php echo $champCorrel;?>.value =x[0];
    this.close();
    }
</script>

<?php

}else
        echo "<center>".lang("vous_devez_saisir_une_valeur_d_au_moins")."&nbsp;<br><br> ".($longueurRecherche+1)."&nbsp;".lang("caracteres_dans_le_champs")."&nbsp;".$champOrigine."</center>";
echo "<BR><center><a href=# onclick='window.close();'>";
echo "<img src='../img/fermer_fenetre.png' border='0'  alt='".lang("fermer_fenetre")."' align='middle'>";
echo "</a></center>";
?>