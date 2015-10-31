<?php
/*
$Id: tab.class.php,v 1.1 2008-07-24 13:18:52 jbastide Exp $
affichage formulaire
FR 15/09/04
Cette classe sert à tabler les champs suivant une requete
      $aff= formulaire
      $serie= nb d enregistrement par page
      $champAffiche= tableau des champs à afficher (suivant la requete)
      $tri= critere de tri de la requete
[english]
This class serves for showing fields following a request
     $aff = form
     $serie = number of recording by page
     $champAffiche = board of fields to be shown (according to the requete)
     $tri = criterion of sorting of the request
*/

// Correction ==================================================================
// évolution => trs connexion sur interface php (gestion droit)
// 30/04/05 : afficherpdf => ouverture en target=_blank
// 05/05/05 : gestion des zones de recherche (rechercher.gif): fonction afficher
// 10/06/05 : afficherpdf() avec form
// O1/07/05 : afficherpdf() pb suivant et précédent
// 13/01/06 : sous formulaire + eclatement en fonctions
// 20/01/06 : affichedyn
// 02/02/06 : afficheimage
// 31/01/07 : on rajoute la clause group by dans le compte du nombre d'enregsitrements =============================================================================
// 22/10/07 : pb de balise <? <?php dans javascript de la methode page select
// 20/05/08 : afficheentetecolone langue
//            lang()
//            om_lang()
//            entete : enlever custom var.inc


class tab{
        var $aff;
        var $serie;
        var $champAffiche;
        var $champRecherche;
        var $tri;
        var $selection;
        var $sql;
        var $sqlC;
        // requete avec group by
        var $sqlG;
        // * Variable contenant la requete qui compte le nombre d'enregistrement
        // * Variable containing the request
        //   which counts the number of recording if there is a group by




function tab($aff,$table, $serie,$champAffiche,$champRecherche,$tri,$selection){
         $this->aff=$aff;
         $this->table=$table;
         $this->serie=$serie;
         $this->champAffiche=$champAffiche;
         $this->table=$table;
         $this->champRecherche=$champRecherche;
         $this->tri=$tri;
         $this->selection=$selection;

}

// **********************************************
// $aff  = formulaire de recherche
// $edition = fichier php d edition (pdf)
// $recherche : chaine recherchée
// *** english ***
// $aff = research form
// $edition = file php d edition ( pdf )
// $recherche: looked for chaine
// **********************************************

function entete($aff,$edition,$recherche){
// * var.inc : récupération de la variable $styleBouton
// * var.inc : Recovery of the variable $styleBouton
include("../dyn/var.inc");
if ($edition!="")  {
$this->edition($edition);
}
echo "<FORM action='tab.php?obj=".$this->aff."&validation=0' method=POST id=f1 name=f1>";
echo "<table class='tabEntete' border='0'>";
echo "<tr><td> ";
if(file_exists("../dyn/custom/img/loupe.png")) {
          echo "<img src='../dyn/custom/img/loupe.png' border='0' hspace='4' align='middle'>";
}else {
          echo "<img src='../img/loupe.png'  border='0' hspace='4' align='middle'>";
}
echo "<input type='text' name='recherche' value='".$recherche.
        "' class='champFormulaire' >";
echo " <input type='submit' name='s1' value='".$this->lang('recherche')."' style=".$styleBouton.
   "' ></td></tr></table></form>";
}

function edition($edition) {
   echo "<table class='impr' border='0'>";
   echo "<tr><td> ";
   echo "<a href='../pdf/pdf.php?obj=".$edition."' target='_blanck'>";
    if(file_exists("../dyn/custom/img/print.png")) {
       echo "<img src='../dyn/custom/img/print.png' alt='Edition Table ".$edition."' border='0' align='top'>";
    }else {
       echo "<img src='../img/print.gif' alt='Edition Table ".$edition."' border='0' align='top'>";
    }
   echo "</a>";
   echo "</td></tr></table>";
}

// **************************************************************************
//       $premier : 1er enregistrement a afficher [1st recording has to show]
//       $recherche: chaine de caractere recherchée [search string]
// **************************************************************************

// ***************************************************************************
// *** complement sur le tableau href [Complement on the href] ***
// href[0] est affiché en haut à gauche (ajouter) [is to the left shown at the top (to add)]
// href[1] etabli un lien hypertext sur les zones data affichées (modifier)
//         [hypertext link on zones data shown]
// href[2] à [n] affiche une colone à gauche des data recuperes la cle primaire
//         [show a col to the left and recover the primary cle]
// href[n][lien] = adresse hypertext  [hypertext adress - URL]
// href[n][id] = parametre à basculer dans le lien en plus de la cle primaire
//               [parameter to tip over to the link besides the primary key]
// href[n][lib] = libelle du lien
//                [Wording of the link]
// ***************************************************************************

function afficher($premier,$recherche,$href,$db,$DEBUG)
{
    // requete [request]
    $this->requete($recherche);
    $nbligne=$db->getOne($this->sqlC);
    // group by  [31 janvier 2007 (florent michon)]
    // Vérification de la clause $tri pour verifier s'il y a un group by
    // Si oui on compte le nombre de resultats de la requete $sqlG
    // qu'on affecte a  $nbligne
    // *** english ***
    // Check of the clause tri to verify if there is a group by
    // If yes we count the number of results of the requete sqlG
    // which we affect in $nbligne
    if (preg_match ("/group by/i", $this->tri) == 1)
    {
        $res1= $db -> query ($this -> sqlG);
        $nbligne = $res1 -> numRows (); 
    }
    //***
    
     $res = $db->limitquery($this->sql,$premier,$this->serie);
     if (get_magic_quotes_gpc()) // magic_quotes_gpc = on
            $recherche= StripSlashes($recherche);
     if (DB :: isError($res)) {
        $this->erreur_db($res->getDebugInfo(),$res->getMessage());
     } else{
     if ($DEBUG == 1){
        echo "la requete ".$this->sql." est exécutée<br>";
     }
        $info=$res->tableInfo();// *** oracle:recuperation immediate(en dynamique)
     // pagination
     $style= "tabEntetenbr";
     $this->pagination($recherche,$premier,$nbligne,$style);
     // affichage de table info
     if($DEBUG==1) $this->affichedebuginfo($DEBUG,$info);
     // affichage Entete colone
     echo "<table class='tabCol' border='0'>";
     $this->afficheentetecolone($href,$info);
     // affichage lien et ligne de data
      while ($row=& $res->fetchRow()){
            echo "<tr class='tabData'>";
            $i=0 ;
            foreach($href as $elem) {
               if($i>1)
                   echo "<td class='largeurtd'><a href=".$href[$i]['lien'].
                   urlencode($row[0]).$href[$i]['id'].
                   ">".$href[$i]['lib']."</a></td>";
                   $i++;
            }
            if($href[1]['lien']!=""){
              $i=0;
              foreach($row as $elem){
                if (is_numeric($elem))
                  echo "<td align='right'>";
                else
                  echo "<td>";
                echo "<a  class='lienTable' href=".$href[1]['lien'].
                urlencode ($row[0]).$href[1]['id'].">".$elem."</td>";
              $i++;
              }
             }else{
              $i=0;
              foreach($row as $elem){
                if (is_numeric($elem))
                  echo "<td align='right'>";
                else
                  echo "<td>";
              echo $elem."</td>";
              $i++;
              }
             }
          echo "</tr>";
        }
      // fin du formulaire [form end]
       echo "</table>";
       echo "</form>";
     }
     $res->free();
}//fin afficher

// requete =================================
// construction de la requete
// - pour liste en table
// - nombre de ligne total (hors pagination)
// - pour la recherche
// =========================================

function requete($recherche){
    $champ="";
    foreach($this->champAffiche as $elem)
     $champ = $champ."".$elem.",";
    $champ=substr($champ,0,strlen($champ)-1);
    if($recherche=="" )
    {       
        $this->sql="SELECT ".$champ." ".
                 " FROM ".$this->table." ".$this->selection." ".$this->tri;
        $this->sqlC="select count(*)  from ".$this->table." ".$this->selection;
    }
else{
          if ($this->selection!="")
          $this->sql=" SELECT ".$champ." ".
                "FROM ".$this->table." ".$this->selection." and ("  ;
          else
          $this->sql=" SELECT ".$champ." ".
                "FROM ".$this->table." where ("  ;
          $sqlw="";
          foreach($this->champRecherche as $elem) {
            if (substr($elem,0,1)!='*') {
               if (!get_magic_quotes_gpc()) { // magic_quotes_gpc = Off
               $sqlw = $sqlw." ".$elem." like '%".AddSlashes($recherche)."%' or ";
               }else{  // magic_quotes_gpc = On
               $sqlw = $sqlw." ".$elem." like '%".$recherche."%' or ";
               }

            }
          }

          $sqlw=substr($sqlw,0,strlen($sqlw)-3).")";
          $this->sql=$this->sql.$sqlw." ".$this->tri;
        if ($this->selection!="")
            $this->sqlC=" select count(*)  from ".$this->table." ".$this->selection." and (".$sqlw ;
        else
            $this->sqlC="select count(*)  from ".$this->table." where (".$sqlw;
     }
    ////////////////////// 31 janvier 2007
    // Construction de la requete $sqlG en rajoutant la clause $tri
    // pour insÃ©rer le group by s'il y en a un
    $this -> sqlG = $this -> sqlC ." ". $this -> tri;
    //////////////////////
}

// pagination ====================================
// affichage Nombre d enregistrement et pagination
// ===============================================

function pagination($recherche,$premier,$nbligne,$style){
  //langue
  include("om_var.inc");
  include($langue.".inc");

  echo "<table  class='".$style."' border='0' ><tr>";
  echo "<td><form id='f2' name='f2'><center>";
  if ($premier>0){
      $precedent=$premier-$this->serie;
      echo "<a href='tab.php?obj=".$this->aff."&premier=".$precedent."&recherche=".
      urlencode($recherche)."'>";
      if(file_exists("../dyn/custom/img/precedent.png")){
         echo "<img src='../dyn/custom/img/precedent.png' style='vertical-align:middle' border='0'>";
      }else {
         echo "<img src='../img/precedent.gif'  style='vertical-align:middle' border='0'>";
      }
      echo "</a>";
  }
   $dernieraffiche=$premier+ $this->serie;
   if($dernieraffiche>$nbligne) //controle $dernieraffiche
     $dernieraffiche=$nbligne;
   $premieraffiche=$premier+1;
   $varTemp= " ".$premieraffiche." - ".$dernieraffiche." ".
       $this->om_lang('enregistrement')." ".$this->om_lang("sur")." ".$nbligne;
   if (strcmp($recherche, ""))
      echo $varTemp." = [".$recherche."] ";
   else
      echo $varTemp." ";
      if ($premier+$this->serie<$nbligne){
           $suivant=$premier+$this->serie;
           echo " <a href='tab.php?obj=".$this->aff."&premier=".$suivant."&recherche=".
           urlencode($recherche)."'>";
           if(file_exists("../dyn/custom/img/suivant.png")) {
                echo "<img src='../dyn/custom/img/suivant.png' border='0'  style='vertical-align:middle'>";
           }else {
                echo "<img src='../img/suivant.gif' border='0'  style='vertical-align:middle'>";
           }
           echo "</a> ";
        }
   //pageselect
   $this->pageselect($recherche,$premier,$nbligne);
   echo "</center></form></td></tr></table>";
}

// pageselect ======================================
// nombre de page affiché dans un controle <SELECT>
// ================================================
 
function pageselect($recherche,$premier,$nbligne){
  //langue
  include("om_var.inc");
  include($langue.".inc");
  if($nbligne>$this->serie){ // si plus d une page
     if(($nbligne % $this->serie) == 0) // calcul du modulo
        $nbpage=(int)($nbligne/$this->serie) ;
     else
        $nbpage=(int)($nbligne/$this->serie)+1 ;
     echo " ".$this->om_lang('page')." - ";
     echo "<select name='page'size='1' onchange=\"allerpage();\" class='champFormulaire' >";
     for($i=1;$i<=$nbpage;$i++){
        if(($i-1)*$this->serie==$premier)
            echo "<option value=".($i-1)*$this->serie." selected>".$i."/".$nbpage."</option>";
        else
            echo "<option value=".($i-1)*$this->serie." >".$i."/".$nbpage."</option>";
        }
        echo "</select>";
   ?><script language="javascript">
function allerpage()
{
location="tab.php?obj=<?php echo $this->aff?>&premier="+document.f2.page.value+"&recherche=<?php echo urlencode($recherche)?>";
}
</script>
   <?php
   }

}

// debug info =========================

function affichedebuginfo($DEBUG,$info){
  echo "<table border=1>";
  foreach($info as $elem){
     echo "<tr>" ;
     foreach($elem as $elem1)
        echo "<td>".$elem1."</td>";
        echo "</tr>";
     }
  echo "</table>";
}

// affiche entete colonne =======


function afficheentetecolone($href,$info){
   echo "<tr class='tabCol'>";
   echo "<td>";
   // ajouter
   if($href[0]['lien']!=""){
       echo "<a href=".$href[0]['lien'].$href[0]['id'].">".
       $href[0]['lib']."</a>" ;
   }
   echo "</td>";
   $i=0 ;
   foreach($href as $elem){
      if($i>2)
        echo "<td></td>";
        $i++;
      }
      // nom des champs en entete de colone
      foreach($info as $elem){
          $x=0;
          foreach($this->champRecherche as $elem1){
             if (substr($elem1,0,1)=='*' and $elem['name']==substr($elem1,1,strlen($elem1))) $x=1;
             if($elem1==$elem['name']) $x=1;
          }
          if($x==1) {
            echo "<td>".ucwords($this->lang($elem['name']))."<br>";
            if(file_exists("../dyn/custom/img/rechercher.png")) {
                echo "<img src='../dyn/custom/img/rechercher.png' border='0'>";
            }else{
                echo "<img src='../img/rechercher.gif' border=0>";
            }
            echo "</td>";
          }else{
            echo "<td>".ucwords($this->lang($elem['name']))."</td>";
          }
      }
      echo "</tr>";
}

//*******************************************
// Afficher des liens (pdf) en blank
// methode specifique d affiche
// ******************************************

function afficherpdf($premier,$recherche,$href,$db,$DEBUG){

      // requete
     $this->requete($recherche);
     $nbligne=$db->getOne($this->sqlC);
     $res = $db->limitquery($this->sql,$premier,$this->serie);
     if (get_magic_quotes_gpc()) // magic_quotes_gpc = on
            $recherche= StripSlashes($recherche);
     if (DB :: isError($res)) {
        $this->erreur_db($res->getDebugInfo(),$res->getMessage());
     } else{
     if ($DEBUG == 1){
        echo "la requete ".$this->sql." est exécutée<br>";
     }
        $info=$res->tableInfo(); // *** oracle: recuperation immediate  (en dynamique)
     // pagination
     $style= "tabEntetenbr";
     $this->pagination($recherche,$premier,$nbligne,$style);

     // affichage de table info
     if($DEBUG==1) $this->affichedebuginfo($DEBUG,$info);

     // affichage Entete colone
     echo "<table class='tabCol' border='0'>";
     $this->afficheentetecolone($href,$info);
     // affichage lien et ligne de data =======================================
      while ($row=& $res->fetchRow()){
            echo "<tr class='tabData'>";
            $i=0 ;
            foreach($href as $elem) {
               // specifique **********************************
               if($i>1)
               echo "<td><a href=".$href[$i]['lien'].
               urlencode($row[0]).$href[$i]['id'].
                " target=_blank >".$href[$i]['lib']."</a></td>";
               //**********************************************
               $i++;
            }
             if($href[1]['lien']!=""){
              $i=0;
              foreach($row as $elem){
                 echo "<td><a  class='lienTable' href=".$href[1]['lien'].
                 urlencode ($row[0]).$href[1]['id'].">$elem</td>";
              $i++;
              }
             }else{
              $i=0;
              foreach($row as $elem){
              echo "<td>$elem</td>";
              $i++;
              }
             }
          echo "</tr>";
        }
      // fin du formulaire
       echo "</table>";
       echo "</form>";
     }
     // Déconnexion  **** vide les variables
     $res->free();
}



// affichage sousformulaire ==================
// methode specifique d affiche
// ===========================================

function affichersousformulaire($premier,$recherche,$href,$db,$DEBUG){
     // requete
     $this->requete($recherche);
     $nbligne=$db->getOne($this->sqlC);
     //////////////////////// 31 janvier 2007
    // VÃ©rification de la clause $tri pour vÃ©rifier s'il y a un group by
    // Si oui on compte le nombre de rÃ©sultats de la requete $sqlG
    // qu'on affecte Ã  $nbligne
    if (preg_match ("/group by/i", $this->tri) == 1)
    {
        $res1= $db -> query ($this -> sqlG);
        $nbligne = $res1 -> numRows (); 
    }
    /////////////////////////
     $res = $db->limitquery($this->sql,$premier,$this->serie);
     if (get_magic_quotes_gpc()) // magic_quotes_gpc = on
            $recherche= StripSlashes($recherche);
     if (DB :: isError($res)) {
        $this->erreur_db($res->getDebugInfo(),$res->getMessage());
     } else{
     if ($DEBUG == 1){
        echo "la requete ".$this->sql." est exécutée<br>";
     }
        $info=$res->tableInfo(); // *** oracle: recuperation immediate  (en dynamique)
     // pagination
     $this->pagination($recherche,$premier,$nbligne,"tabsousformnbr");

     // affichage de table info
     if($DEBUG==1) $this->affichedebuginfo($DEBUG,$info);

     // affichage Entete colone
     // specifique ********************************
     echo "<table class='tabsousform' border='0'>";
     // *******************************************
     $this->afficheentetecolone($href,$info);
      // affichage lien et ligne de data =======================================
      while ($row=& $res->fetchRow()){
            // specifique ******************
            echo "<tr class='tabsousform'>";
            // *****************************
            $i=0 ;
            foreach($href as $elem) {
               if($i>1)
               echo "<td class='largeurtd'><a href=".$href[$i]['lien'].
               urlencode($row[0]).$href[$i]['id'].
                ">".$href[$i]['lib']."</a></td>";
                $i++;
                }
             if($href[1]['lien']!=""){
              $i=0;
              foreach($row as $elem){
                if (is_numeric($elem))
                  echo "<td align='right'>";
                else
                  echo "<td>";
                 echo "<a  class='lienTable' href=".$href[1]['lien'].
                 urlencode ($row[0]).$href[1]['id'].">".$elem."</td>";
              $i++;
              }
             }else{
              $i=0;
              foreach($row as $elem){
                if (is_numeric($elem))
                  echo "<td align='right'>";
                else
                  echo "<td>";
              echo $elem."</td>";
              $i++;
              }
             }
          echo "</tr>";
        }
      // fin du formulaire
       echo "</table>";
       echo "</form>";
     }
     // Déconnexion  **** vide les variables
     $res->free();
}


// =====================================================================
// Traitement d erreur
// =====================================================================
function erreur_db($debuginfo,$messageDB)
{
       echo "</div><div id='erreur'>";
        $requete="";
        $erreur_origine="";
        $temp =explode('[',$debuginfo);
        if(isset($temp[0]))
           $requete=$temp[0];
        if (isset($temp[1]))
           $erreur_origine=substr($temp[1],0,strlen($temp[1])-1);


           $erreur_fr= array(
            'unknown error'        => 'erreur inconnue',
            'already exists'       => 'existe déjà',
            'can not create'       => 'ne peux pas être créer',
            'can not delete'       => 'ne peux pas etre detruit',
            'can not drop'         => $this->table.'table ne peut pas etre détruite',
            'constraint violation' => 'Contrainte de clé primaire, enregistrement déja existant',
            'null value violates not-null constraint'=> 'contrainte not-null non respectée',
            'division by zero'     => 'division par zero',
            'invalid'              => 'invalide',
            'invalid date or time' => 'date ou heure invalide',
            'invalid number'       => 'nombre invalide',
            'mismatch'             => 'mismatch',
            'no database selected' => 'pas de database selectionnée',
            'no such field'        => 'champ inexistant dans la table '.$this->table,
            'no such table'        =>  $this->table.' inexistante',
            'DB backend not capable'=> 'DB backend not capable',
            'not found'            => 'non trouvé',
            'not locked'           => 'non locké',
            'syntax error'         => 'erreur de syntaxe dans la requête',
            'not supported'        => 'non supporté',
            'value count on row'   => 'value count on row',
            'invalid DSN'          => 'DSN invalide',
            'connect failed'       => 'connexion en erreur',
            'no error'             => 'pas d erreur',
            'insufficient data supplied' => 'insufficient data supplied',
            'extension not found'  => 'extension on trouvée',
            'no such database'     => 'database non trouvée',
            'insufficient permissions'   => 'permission insuffisante',
            'truncated'            => 'détruit'
        );
        $message = substr($messageDB,10,strlen($messageDB));
        foreach (array_keys($erreur_fr) as $elem) {
            if ( $elem== $message){
                $msgfr = $erreur_fr[$elem];
            }
        }
        $erreur_origine = substr($erreur_origine,11,strlen($erreur_origine));
        //echo $temp[1];
        echo "";
        echo "<table class='tabCol'>";
        echo "<tr class='tabCol'>";
        echo "<td colspan=2>  Attention, Erreur de base de données";
        echo "</td>";
        echo "<tr class='tabdata'><td>Requête</td>";
        echo "<td>".$requete."</td></tr>";
        echo "<tr class='tabdata'><td>Erreur<br>du SGBD</td>";
        echo "<td>".$erreur_origine."</td></tr>";
        echo "<tr class='tabdata'><td>Erreur<br>DB.pear</td>";
        echo "<td>".$messageDB."</td></tr>";
        echo "<tr class='tabdata'><td>Erreur<br>Framework</td>";
        echo "<td>".$msgfr."</td></tr>";
        echo "<tr class='tabCol'>";
        echo "<td colspan=2><img src='../img/erreur.gif' border=0>";
        echo  "<b>Requete non exécutée</b>: ";
        echo "<img src=../img/zoneobligatoire.gif border=0>Contactez votre administrateur ... ";
        echo "</td>";
        echo "</tr></table>";
        echo "</div>";
        include "../dyn/menu.inc";
        die();
}

// =============================================================================
// afficheronglet
// cette methode permet
// un affichage dynamique avec ajax et pouvoir gerer (eventuellement) des onglets
// recup.php permet de recuperer les zones php à re integrer dans onglet.php
// =============================================================================


function afficheronglet($premier,$recherche,$href,&$db,$DEBUG){
     // requete
     $this->requete($recherche);
     $nbligne=$db->getOne($this->sqlC);
     //////////////////////// 31 janvier 2007
    // VÃ©rification de la clause $tri pour vÃ©rifier s'il y a un group by
    // Si oui on compte le nombre de rÃ©sultats de la requete $sqlG
    // qu'on affecte Ã  $nbligne
    if (preg_match ("/group by/i", $this->tri) == 1)
    {
        $res1= $db -> query ($this -> sqlG);
        $nbligne = $res1 -> numRows (); 
    }
    /////////////////////////
     $res = $db->limitquery($this->sql,$premier,$this->serie);
     if (get_magic_quotes_gpc()) // magic_quotes_gpc = on
            $recherche= StripSlashes($recherche);
     if (DB :: isError($res)) {
        $this->erreur_db($res->getDebugInfo(),$res->getMessage());
     } else{
     if ($DEBUG == 1){
        echo "la requete ".$this->sql." est exécutée<br>";
     }
        $info=$res->tableInfo();
     // pagination
     $style= "tabEntetenbr";
     $this->paginationonglet($recherche,$premier,$nbligne,"tabsousformnbr");

     // affichage de table info
     if($DEBUG==1) $this->affichedebuginfo($DEBUG,$info);

     // affichage Entete colone
     // specifique ********************************
     echo "<table class='tabsousform' border='0'>";
     $this->afficheentetecolone($href,$info);
     // affichage lien et data

     while ($row=& $res->fetchRow()){
            echo "<tr class='tabData'>";
            $i=0 ;
            foreach($href as $elem) {
               if($i>1)
               echo "<td class='largeurtd'><a href=".$href[$i]['lien'].
               urlencode($row[0]).$href[$i]['id'].
                ">".$href[$i]['lib']."</a></td>";
                $i++;
                }
             if($href[1]['lien']!=""){
              $i=0;
              foreach($row as $elem){
                 echo "<td>";
                 // bouton mail si adresse email dans $elem---------------------
                  if (ereg ("@",$elem)){
                   echo "<a href='mailto:".$elem."'>";
                   if(file_exists("../dyn/custom/img/email-ch.png")) {
                      echo "<img src='../dyn/custom/img/email-ch.png' border='0' hspace='10' align='middle'>";
                   }else {
                      echo "<img src='../img/email-ch.png'  border='0' hspace='10' align='middle'>";
                   }
                   echo "</a>";
                 }
                 //-------------------------------------------------------------
                 echo "<a  class='lienTable' href=".$href[1]['lien'].
                 urlencode ($row[0]).$href[1]['id'].">".$elem."</td>";



              $i++;
              }
             }else{
              $i=0;
              foreach($row as $elem){
              echo "<td>$elem</td>";
              $i++;
              }
             }
          echo "</tr>";
        }

     // fin du formulaire
       echo "</table>";
       echo "</form>";
     }
     // Déconnexion  **** vide les variables
     $res->free();
}//fin afficher

// paginationonglet utilise le javascript de onglet.php

function paginationonglet($recherche,$premier,$nbligne,$style){
  // langue
  include("om_var.inc");
  include($langue.".inc");
  $precedent=0;
  $suivant=0;
  echo "<table  class='".$style."' border='0' ><tr>";
  echo "<td><form id='f2' name='f2'><center>";

  if ($premier>0){
      $precedent=$premier-$this->serie;
       echo "<input type='button' value= '<' onclick='precedent()'>";
  }
   $dernieraffiche=$premier+ $this->serie;
   if($dernieraffiche>$nbligne) //controle $dernieraffiche
     $dernieraffiche=$nbligne;
   $premieraffiche=$premier+1;
   $varTemp= " ".$premieraffiche." - ".$dernieraffiche." ".
       $this->om_lang('enregistrement')." ".$this->om_lang("sur")." ".$nbligne;
   if (strcmp($recherche, ""))
      echo $varTemp." = [".$recherche."] ";
   else
      echo $varTemp." ";
      if ($premier+$this->serie<$nbligne){
           $suivant=$premier+$this->serie;
           echo "<input type='button' value= '>' onclick='suivant()'>";
        }
   //pageselect
   $this->pageselectonglet($recherche,$premier,$nbligne);
   echo "</center></form></td></tr></table>";
   echo "<div id='pageselect_onglet' >";
   echo "<span  id='precedent' >".$precedent."</span>";
   echo "<span  id='suivant' >".$suivant."</span></div>";
}

// pageselectonglet utilise le javascript de onglet.php

function pageselectonglet($recherche,$premier,$nbligne){
  //langue
  include("om_var.inc");
  include($langue.".inc");
  if($nbligne>$this->serie){ // si plus d une page
     if(($nbligne % $this->serie) == 0) // calcul du modulo
        $nbpage=(int)($nbligne/$this->serie) ;
     else
        $nbpage=(int)($nbligne/$this->serie)+1 ;
     echo " ".$this->om_lang('page')." - ";
     echo "<select name='page' size='1' onchange=\"allerpage();\" class='champFormulaire' >";
     for($i=1;$i<=$nbpage;$i++){
        if(($i-1)*$this->serie==$premier)
            echo "<option value=".($i-1)*$this->serie." selected>".$i."/".$nbpage."</option>";
        else
            echo "<option value=".($i-1)*$this->serie." >".$i."/".$nbpage."</option>";
        }
        echo "</select>";
   }

}


// =============================================================================
// afficherimage
// cette methode permet
// * d afficher des images si l extension de la zone
//   est jpeg, jpg, gif, png
// * d afficher les numeriques a droite
// =============================================================================

function afficherimage($premier,$recherche,$href,$db,$DEBUG){
     // requete
     $this->requete($recherche);
     $nbligne=$db->getOne($this->sqlC);
     $res = $db->limitquery($this->sql,$premier,$this->serie);
     if (get_magic_quotes_gpc()) // magic_quotes_gpc = on
            $recherche= StripSlashes($recherche);
     if (DB :: isError($res)) {
        $this->erreur_db($res->getDebugInfo(),$res->getMessage());
     } else{
     if ($DEBUG == 1){
        echo "la requete ".$this->sql." est exécutée<br>";
     }
        $info=$res->tableInfo(); // *** oracle: recuperation immediate  (en dynamique)
     // pagination
     $style= "tabEntetenbr";
     $this->pagination($recherche,$premier,$nbligne,$style);

     // affichage de table info
     if($DEBUG==1) $this->affichedebuginfo($DEBUG,$info);

     // affichage Entete colone
     echo "<table class='tabCol' border='0'>";
     $this->afficheentetecolone($href,$info);
     // affichage lien et ligne de data
      while ($row=& $res->fetchRow()){
            echo "<tr class='tabData'>";
            $i=0 ;
            foreach($href as $elem) {
               if($i>1)
               echo "<td class='largeurtd'><a href=".$href[$i]['lien'].
               urlencode($row[0]).$href[$i]['id'].
                ">".$href[$i]['lib']."</a></td>";
                $i++;
                }
             if($href[1]['lien']!=""){
              $i=0;
              foreach($row as $elem){
                 $tmp="";
                 $tmp1="";
                 $tmp2="";
                 if($elem!=''){
                     $tmp = strchr($elem, '.');
                     $tmp=substr($tmp,1,(strlen($tmp)-1));
                 }
                 if(isset($tmp) and (($tmp) == "jpeg"
                 or strtolower($tmp) == "gif"
                 or strtolower($tmp) == "jpg"
                 or strtolower($tmp) == "png")){
                   $tmp1= "<td align='center'>";
                   $tmp2= "<img src='../trs/".$elem."' border=0 >";
                 }else{
                   if(is_numeric($elem))
                     $tmp1="<td align=right>";
                   else
                     $tmp1="<td>";
                     $tmp2= $elem;
                 }
                 echo $tmp1."<a  class='lienTable' href=".$href[1]['lien'].
                 urlencode ($row[0]).$href[1]['id'].">".$tmp2."</a></td>";
                 $i++;
              }
             }else{
              $i=0;
              foreach($row as $elem){
              $tmp="";
                 $tmp1="";
                 $tmp2="";
                 if($elem!=''){
                     $tmp = strchr($elem, '.');
                     $tmp=substr($tmp,1,(strlen($tmp)-1));
                 }
                 if(isset($tmp) and (($tmp) == "jpeg"
                 or strtolower($tmp) == "gif"
                 or strtolower($tmp) == "jpg"
                 or strtolower($tmp) == "png")){
                   $tmp1= "<td align='center'>";
                   $tmp2= "<img src='../trs/".$elem."' border=0 >";
                 }else{
                   if(is_numeric($elem))
                     $tmp1="<td align=right>";
                   else
                     $tmp1="<td>";
                     $tmp2= $elem;
                 }
               echo $tmp1.$tmp2."</td>";
              $i++;
              }
             }
          echo "</tr>";
        }
      // fin du formulaire
       echo "</table>";
       echo "</form>";
     }
     // Déconnexion  **** vide les variables
     $res->free();
}//fin afficherimage
//
// =============================================================================
// a faire
// affichermail
// cette methode permet
// si mail (xx@xxxx) -> xx@xxx->maj + image->mailto
// =============================================================================

function affichermail($premier,$recherche,$href,$db,$DEBUG){
     // requete
     $this->requete($recherche);
     $nbligne=$db->getOne($this->sqlC);
     $res = $db->limitquery($this->sql,$premier,$this->serie);
     if (get_magic_quotes_gpc()) // magic_quotes_gpc = on
            $recherche= StripSlashes($recherche);
     if (DB :: isError($res)) {
        $this->erreur_db($res->getDebugInfo(),$res->getMessage());
     } else{
     if ($DEBUG == 1){
        echo "la requete ".$this->sql." est exécutée<br>";
     }
        $info=$res->tableInfo(); // *** oracle: recuperation immediate  (en dynamique)
     // pagination
     $style= "tabEntetenbr";
     $this->pagination($recherche,$premier,$nbligne,$style);

     // affichage de table info
     if($DEBUG==1) $this->affichedebuginfo($DEBUG,$info);

     // affichage Entete colone
     echo "<table class='tabCol' border='0'>";
     $this->afficheentetecolone($href,$info);
     // affichage lien et ligne de data
      while ($row=& $res->fetchRow()){
            echo "<tr class='tabData'>";
            $i=0 ;
            foreach($href as $elem) {
               if($i>1)
               echo "<td class='largeurtd'><a href=".$href[$i]['lien'].
               urlencode($row[0]).$href[$i]['id'].
                ">".$href[$i]['lib']."</a></td>";
                $i++;
                }
             if($href[1]['lien']!=""){
              $i=0;
              foreach($row as $elem){
                 $tmp="";
                 $tmp1="";
                 $tmp2="";
                 if($elem!=''){
                     $tmp = strchr($elem, '.');
                     $tmp=substr($tmp,1,(strlen($tmp)-1));
                 }
                 if(isset($tmp) and (($tmp) == "jpeg"
                 or strtolower($tmp) == "gif"
                 or strtolower($tmp) == "jpg"
                 or strtolower($tmp) == "png")){
                   $tmp1= "<td align='center'>";
                   $tmp2= "<img src='../trs/".$elem."' border=0 >";
                 }else{
                   if(is_numeric($elem))
                     $tmp1="<td align=right>";
                   else
                     $tmp1="<td>";
                     $tmp2= $elem;
                 }
                 //
                 echo $tmp1;
                 if (ereg ("@",$elem)){
                   echo "<a href='mailto:".$elem."'>";
                   if(file_exists("../dyn/custom/img/email-ch.png")) {
                      echo "<img src='../dyn/custom/img/email-ch.png' border='0' hspace='10' align='middle'>";
                   }else {
                      echo "<img src='../img/email-ch.png'  border='0' hspace='10' align='middle'>";
                   }
                   echo "</a>";
                 }
                 echo "<a  class='lienTable' href=".$href[1]['lien'].
                 urlencode ($row[0]).$href[1]['id'].">".$tmp2."</a>";
                 echo "</td>";
                 $i++;
              }
             }else{
              $i=0;
              foreach($row as $elem){
              $tmp="";
                 $tmp1="";
                 $tmp2="";
                 if($elem!=''){
                     $tmp = strchr($elem, '.');
                     $tmp=substr($tmp,1,(strlen($tmp)-1));
                 }
                 if(isset($tmp) and (($tmp) == "jpeg"
                 or strtolower($tmp) == "gif"
                 or strtolower($tmp) == "jpg"
                 or strtolower($tmp) == "png")){
                   $tmp1= "<td align='center'>";
                   $tmp2= "<img src='../trs/".$elem."' border=0 >";
                 }else{
                   if(is_numeric($elem))
                     $tmp1="<td align=right>";
                   else
                     $tmp1="<td>";
                     $tmp2= $elem;
                 }
               echo $tmp1;
               if (ereg ("@",$elem)){
                   echo "<a href='mailto:".$elem."'>";
                   if(file_exists("../dyn/custom/img/email-ch.png")) {
                      echo "<img src='../dyn/custom/img/email-ch.png' border='0' hspace='10' align='middle'>";
                   }else {
                      echo "<img src='../img/email-ch.png'  border='0' hspace='10' align='middle'>";
                   }
                   echo "</a>";
                 }
               echo $tmp2."</td>";
              $i++;
              }
             }
          echo "</tr>";
        }
      // fin du formulaire
       echo "</table>";
       echo "</form>";
     }
     // Déconnexion  **** vide les variables
     $res->free();
}//fin affichermail

// =========================================
// translation
// in directory lang/$lanque.inc
// in openmairie
//==========================================

function lang($texte){
         include ("../dyn/var.inc");
         if(!isset($langue)) $langue='francais';
         if (file_exists("../lang/".$langue.".inc")) {
             include ("../lang/".$langue.".inc");
         }
        $msg="";
        if(isset($lang['non_traduit'])){
            $msg=$lang['non_traduit'];
         }
        if (file_exists("../img/".$langue.".png")) {
             if(!isset($lang[$texte])) $lang[$texte]="<font id='a_traduire'><img src='../img/".$langue.".png'  style='vertical-align:middle' hspace='2' />".$texte."&nbsp;</font>&nbsp;[".$msg."]";
             if(isset($lang[$texte]) and trim($lang[$texte])=='') $lang[$texte]="<font id='a_traduire'><img src='../img/".$langue.".png'  style='vertical-align:middle' hspace='2' />".$texte."&nbsp;(vide)&nbsp;</font>&nbsp;[".$msg."]";
         }else{
              if(!isset($lang[$texte])) $lang[$texte]="<font id='a_traduire'>".$texte."&nbsp;</font>&nbsp;[".$msg."]";
              if(isset($lang[$texte]) and trim($lang[$texte])=='') $lang[$texte]="<font id='a_traduire'>".$texte."&nbsp;</font>&nbsp;[".$msg."](vide)";
         }
         return $lang[$texte];
}

function om_lang($texte){
         include ("../dyn/var.inc");
         if(! isset($path_om)) $path_om="";
         include ($path_om."om_var.inc");
         if(!isset($langue)) $langue='francais';
         if (file_exists($path_om.$langue.".inc")) {
            include ($path_om.$langue.".inc");
         }
         $msg="";
         if(isset($lang['non_traduit'])){
            $msg=$lang['non_traduit'];
         }
         if (file_exists("../img/".$langue.".png")) {
             if(!isset($lang[$texte])) $lang[$texte]="<font id='a_traduire'><img src='../img/".$langue.".png'  style='vertical-align:middle' hspace='2' />".$texte."</font>&nbsp;[".$msg."]";
             if(isset($lang[$texte]) and trim($lang[$texte])=='') $lang[$texte]="<font id='a_traduire'><img src='../img/".$langue.".png'  style='vertical-align:middle' hspace='2' />".$texte."</font>&nbsp;[".$msg."(vide)]&nbsp;";
         }else{
              if(!isset($lang[$texte])) $lang[$texte]="<font id='a_traduire'>".$texte."</font>&nbsp;[".$msg."]";
              if(isset($lang[$texte]) and trim($lang[$texte])=='') $lang[$texte]="<font id='a_traduire'>".$texte."</font>&nbsp;[".$msg."(vide)]";;
         }
         return $lang[$texte];
}
} // fin de classe
?>


