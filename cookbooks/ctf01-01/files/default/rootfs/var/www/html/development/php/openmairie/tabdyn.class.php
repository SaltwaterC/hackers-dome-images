<?php
/*
$Id: tabdyn.class.php,v 1.1 2008-07-24 13:18:52 jbastide Exp $
affichage formulaire
FR 15/09/04
Cette classe sert a tabler les champs suivant une requete
      $aff= formulaire
      $serie= nb d enregistrement par page
      $champAffiche= tableau des champs a afficher (suivant la requete)
      $tri= critere de tri de la requete
*/

// Correction ==================================================================
// 1ere version 1.20 - affichage en dynamique (onglet)
// =============================================================================

class tab{

        var $aff;
        var $serie;
        var $champAffiche;
        var $champRecherche;
        var $tri;
        var $selection;
        var $sql;
        var $sqlC;
        // Variable contenant la requete qui compte le nombre d'enregistrement  
        // si il y a un group by
        var $sqlG;
        var $tricol;


function tab($aff,$table, $serie,$champAffiche,$champRecherche,$tri,$tricol,$selection){
         $this->aff=$aff;
         $this->table=$table;
         $this->serie=$serie;
         $this->champAffiche=$champAffiche;
         $this->table=$table;
         $this->champRecherche=$champRecherche;
         $this->tri=$tri;
         $this->tricol=$tricol;
         $this->selection=$selection;

}

// **********************************************
// $aff  = formulaire de recherche
// $edition = fichier php d edition (pdf)
// $recherche : chaine recherchee
// **********************************************

function entete($aff,$edition,$recherche){
//passage $this->tricol dans action du form
//recuperation de $styleBouton
include("../dyn/var.inc");
if ($edition!="")  {
$this->edition($edition);
}
echo "<FORM action='tab.php?obj=".$this->aff."&tri=".$this->tricol."&validation=0' method=POST id=f1 name=f1>";
echo "<table class='tabEntete' border='0'>";
echo "<tr><td> ";
echo "<img src='../img/loupe.png'  border='0' hspace='4' align='middle'>";
echo "<input type='text' name='recherche' value='".$recherche."' class='champFormulaire' >";
//echo " <input type='submit' name='s1' value='".$this->lang('recherche')."' style=".$styleBouton.
 //  "' ></td></tr></table></form>";

echo "<button type='submit' name='s1' style=".$styleBouton.">".$this->lang('recherche')."</button></td></tr></table></form>";
}

function edition($edition) {
   echo "<table class='impr' border='0'>";
   echo "<tr><td> ";
   echo "<a href='../pdf/pdf.php?obj=".$edition."' target='_blanck'>";
   echo "<img src='../img/print.gif' alt='Edition Table ".$edition."' border='0' align='top'>";
   echo "</a>";
   echo "</td></tr></table>";
}

// *********************************************
//       premier : 1er enregistrement a afficher
//       recherche: chaine de caractere recherchee
// ************************************************

// ***************************************************************************
// complement sur le tableau href
// href[0] est affiche en haut a gauche (ajouter)
// href[1] etabli un lien hypertext sur les zones data affichees (modifier)
// href[2] a [n] affiche une colene a gauche des datas recupere la cle primaire
// href[n][lien] = adresse hypertext
// href[n][id] = parametre a basculer dans le lien en plus de la cle primaire
// href[n][lib] = libelle du lien
// ***************************************************************************

function afficher($premier,$recherche,$href,$db,$DEBUG,$hidden=0)
{
    // requete
    $this->requete($recherche);
    $nbligne=$db->getOne($this->sqlC);
    //////////////////////// 31 janvier 2007
    // Vérification de la clause $tri pour vérifier s'il y a un group by
    // Si oui on compte le nombre de résultats de la requete $sqlG
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
        echo "la requete ".$this->sql." est executee<br>";
     }
        $info=$res->tableInfo(); // *** oracle: recuperation immediate  (en dynamique)
     // pagination
     $style= "tabEntetenbr";
     $this->pagination($recherche,$premier,$nbligne,$style);

     // affichage de table info
     if($DEBUG==1) $this->affichedebuginfo($DEBUG,$info);

     // affichage Entete colone
     echo "<table class='tabCol' border='0'>";
     //$this->afficheentetecolone($href,$info);
     $this->afficheentetecolone(false,$premier,$recherche,$href,$info,$hidden);
     // *!*ajout 28nov07
     $nbchamp=0;
     $nbchamp=count($info);
     // *!*
     //false car tab non dynamique (pas d'onglet')
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
                if ($i>=$hidden) {    //ajout fred 
                  if (is_numeric($elem))
                    echo "<td align='right'>";
                  else
                    echo "<td>";
                  // *!*ajout 28nov07
                  if($nbchamp>1){
                    echo "<a  class='lienTable' href=".$href[1]['lien'].
                    urlencode ($row[0])."&idz=".urlencode($row[1])."".$href[1]['id'].">".$elem."</td>";
                  }else{// *!*
                    echo "<a  class='lienTable' href=".$href[1]['lien'].
                    urlencode ($row[0]).$href[1]['id'].">".$elem."</td>";
                  }// *!*
                }  //ajout fred
                $i++;
              }
             }else{
              $i=0;
              foreach($row as $elem){
                if ($i>=$hidden) {
                  if (is_numeric($elem))
                    echo "<td align='right'>";
                  else
                    echo "<td>";
                  echo $elem."</td>";
                }
              $i++;
              }
             }
          echo "</tr>";
        }
      // fin du formulaire
       echo "</table>";
       echo "</form>";
     }
     // Deconnexion  **** vide les variables
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
    //prise en compte tri de colonne
    $tri=$this->tri;
    $tricol=$this->tricol;
    if ($tricol) {
      if (stristr($tricol,"adresseip")) $tricol="ipa,ipb,ipc,ipd";
      if ($tri) 
        $tri=str_replace("order by ","order by ".$tricol.",",$tri);
      else
        $tri=" order by ".$tricol;
    }
    //fin modif   
    if($recherche=="" )
    {       
        $this->sql="SELECT ".$champ." ".
                 " FROM ".$this->table." ".$this->selection." ".$tri;//$this->tri;
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
          $this->sql=$this->sql.$sqlw." ".$tri;//$this->tri;
        if ($this->selection!="")
            $this->sqlC=" select count(*)  from ".$this->table." ".$this->selection." and (".$sqlw ;
        else
            $this->sqlC="select count(*)  from ".$this->table." where (".$sqlw;
     }
    ////////////////////// 31 janvier 2007
    // Construction de la requÃªte $sqlG en rajoutant la clause $tri
    // pour insérer le group by s'il y en a un
    $this -> sqlG = $this -> sqlC ." ". $this -> tri;
    ////////////////////// 
}

// pagination ====================================
// affichage Nombre d enregistrement et pagination
// ===============================================

function pagination($recherche,$premier,$nbligne,$style) {
//passage de $this->tricol  
  echo "<table  class='".$style."' border='0' ><tr>";
  echo "<td><form id='f2' name='f2'><center>";
  if ($premier>0){
      $precedent=$premier-$this->serie;
      echo "<a href='tab.php?obj=".$this->aff."&premier=".$precedent."&recherche=".
      urlencode($recherche)."'>";
      echo "<img src='../img/precedent.gif'  style='vertical-align:middle' border='0'>";
      echo "</a>";
  }
   $dernieraffiche=$premier+ $this->serie;
   if($dernieraffiche>$nbligne) //controle $dernieraffiche
     $dernieraffiche=$nbligne;
   $premieraffiche=$premier+1;
   $varTemp= " ".$premieraffiche." - ".$dernieraffiche."&nbsp;".
        $this->om_lang('enregistrement')."&nbsp;".$this->om_lang("sur")."&nbsp;".$nbligne;
   if (strcmp($recherche, ""))
      echo $varTemp." = [".$recherche."] ";
   else
      echo $varTemp." ";
      if ($premier+$this->serie<$nbligne){
           $suivant=$premier+$this->serie;
           echo " <a href='tab.php?obj=".$this->aff."&premier=".$suivant."&recherche=".
           urlencode($recherche)."&tri=".$this->tricol."'>";
           echo "<img src='../img/suivant.gif'  style='vertical-align:middle' border='0'>";
           echo "</a> ";
        }
   //pageselect
   $this->pageselect($recherche,$premier,$nbligne);
   echo "</center></form></td></tr></table>";
}

// pageselect ======================================
// nombre de page affiche dans un controle <SELECT>
// ================================================
 
function pageselect($recherche,$premier,$nbligne){
//passage de $this->tricol  
     if($nbligne>$this->serie){ // si plus d une page
     if(($nbligne % $this->serie) == 0) // calcul du modulo
        $nbpage=(int)($nbligne/$this->serie) ;
     else
        $nbpage=(int)($nbligne/$this->serie)+1 ;
     echo "&nbsp;".$this->om_lang('page')."&nbsp";
     echo "<select name='page'size='1' onchange=\"allerpage('".$this->tricol."');\" class='champFormulaire' >";
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
location="tab.php?obj=<?php echo $this->aff?>&premier="+document.f2.page.value+"&recherche=<?php echo urlencode($recherche)?>&tri=<?php echo($this->tricol);?>";
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


function afficheentetecolone($onglet,$premier,$recherche,$href,$info,$hidden=0) { 
//surcharge pour passage hidden (Ã  1, id masqué)
//et reception $onglet,$premier,$recherche pour lien tri
  if (!isset($hidden)) $hidden=0;
  echo "<tr class='tabCol'>";
  // ajouter
  if($href[0]['lien']!="") {
    if($onglet) { //si sousform généré en ajax
      echo "<td onclick=\"affichersform('".$href[0]['lien'].$href[0]['id']."')\"><a href='#'>".$href[0]['lib']."</a>";
    } else {
      echo "<td><a href=".$href[0]['lien'].$href[0]['id'].">".
      $href[0]['lib']."</a>" ;
    }
  } else
    echo "<td>";
  echo "</td>";
   $i=0 ;
   foreach($href as $elem){
      if($i>2)
        echo "<td></td>";
        $i++;
      }
  // nom des champs en entete de colone
  $i=0;  //ajout fred
  foreach($info as $elem){
    if ($i>=$hidden) { //ajout fred
      $x=0;
      foreach($this->champRecherche as $elem1){
         if (substr($elem1,0,1)=='*' and $elem['name']==substr($elem1,1,strlen($elem1))) $x=1;
         if($elem1==$elem['name']) $x=1;
      }
      // fleche sur colonne triée
      if ($this->tricol==$elem['name']){
         $fleche_tri="<img src='../img/fleche_tri.png' border='0' hspace='3' vspace='2' />";
      }else{
         $fleche_tri="<img src='../img/fleche_nontri.png' border='0' hspace='3' vspace='2' />";
      }
      if ($onglet) {
         echo "<td onclick=\"trier('".$elem['name']."')\">".$fleche_tri."<a href='#ancrepostform'>".ucwords($this->lang($elem['name']))."</a>";
      }else {
        echo "<td>";
        echo $fleche_tri."<a href='tab.php?obj=".$this->aff."&premier=".$premier."&recherche=".urlencode($recherche)."&tri=".$elem['name']."'>";
        echo ucwords($this->lang($elem['name']))."</a>";
      }
      if($x==1) {
        echo "<br><img src='../img/rechercher.gif' border=0>";
        echo "</td>";
      }
      echo "</td>";
    }  //ajout fred
    $i++;  //ajout fred        
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
     $this->afficheentetecolone(false,$premier,$recherche,$href,$info);
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
     $res = $db->limitquery($this->sql,$premier,$this->serie);
     if (get_magic_quotes_gpc()) // magic_quotes_gpc = on
            $recherche= StripSlashes($recherche);
     if (DB :: isError($res)) {
        $this->erreur_db($res->getDebugInfo(),$res->getMessage());
     } else{
     if ($DEBUG == 1){
        echo "la requete ".$this->sql." est exécuté<br>";
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
     $this->afficheentetecolone(false,$premier,$recherche,$href,$info);
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
            'can not create'       => 'ne peux pas étre créer',
            'can not delete'       => 'ne peux pas etre detruit',
            'can not drop'         => $this->table.'table ne peut pas etre détruite',
            'constraint violation' => 'Contrainte de clé primaire, enregistrement déjà existant',
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
            'syntax error'         => 'erreur de syntaxe dans la requete',
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
        echo "<tr class='tabdata'><td>Requéte</td>";
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
// recup.php permet de recuperer les zones php é re integrer dans onglet.php
// =============================================================================


function afficheronglet($premier,$recherche,$href,&$db,$DEBUG,$hidden=0,$deleteall=0){
     //version dyn
     //hidden Ã  1 -> id masqué dans tableau
     //deleteall Ã  1 -> bouton "Tout Supprimer" dans tableau
     //
     // requete
     if (!isset($hidden)) $hidden=0;
     if (!isset($deleteall)) $deleteall=0;
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
        $info=$res->tableInfo();
     // pagination
     $style= "tabEntetenbr";
     //passage de href et deleteall en plus dans version dyn
     $this->paginationonglet($recherche,$premier,$href,$nbligne,"tabsousformnbr",$deleteall);

     // affichage de table info
     if($DEBUG==1) $this->affichedebuginfo($DEBUG,$info);

     // affichage Entete colone
     // specifique ********************************
     echo "<table class='tabsousform' border='0'>";
     //version dyn
     $this->afficheentetecolone(true,$premier,$recherche,$href,$info,$hidden);
     //$this->afficheentetecolone($href,$info);
     // affichage lien et data

     while ($row=& $res->fetchRow()){
            echo "<tr class='tabData'>";
            $i=0 ;
            foreach($href as $elem) {
                //051207
                if($i>1) {
                    if($i>2)  //pdf ou autre lien
                        echo "<td class='largeurtd'><a href=".$href[$i]['lien'].
                        urlencode($row[0]).$href[$i]['id'].
                        ">".$href[$i]['lib']."</a></td>";
                    else //i=2 suppression
                        if($href[2]['lien']) { //suppression active
                            echo "<td class='largeurtd' onclick=\"affichersform('".$href[$i]['lien'].
                            urlencode($row[0]).$href[$i]['id'].
                            "')\">";
                            echo "<a href='#'>".$href[$i]['lib']."</a></td>";
                        } else  //suppression inactive
                            echo "<td></td>"; 
               }
               $i++;
             }
             if($href[1]['lien']!=""){
              $i=0;
              foreach($row as $elem) {
               if ($i>=$hidden) {   //ajout fred
                if (is_numeric($elem)){
                 echo "<td align='right' onclick=\"affichersform('".$href[1]['lien'].
                    urlencode($row[0]).$href[1]['id'].
                    "')\">";
                 }else{
                  echo "<td onclick=\"affichersform('".$href[1]['lien'].
                    urlencode($row[0]).$href[1]['id'].
                    "')\">";
                 }
                 // bouton mail si adresse email dans $elem---------------------
                 if (ereg ("@",$elem)){
                   echo "<a href='mailto:".$elem."'>";
                   echo "<img src='../img/email-ch.png'  border='0' hspace='10' align='middle'>";
                   echo "</a>";
                 }
                 //-------------------------------------------------------------
                 if (is_numeric($elem)){
                    echo "<a class='lienTable' href='#'>".$elem."&nbsp;</td>";
                 }else{
                    echo "<a class='lienTable' href='#'>&nbsp;".$elem."</td>";
                 }
                }
                $i++;
              }
             }else{
              $i=0;
              foreach($row as $elem){
                if ($i>=$hidden){
                 if (is_numeric($elem)){
                   echo "<td align='right'>".$elem."&nbsp;</td>";
                 }else{
                   echo "<td>&nbsp;".$elem."</td>";
                 }
                }
                $i++;
              }
             }
          echo "</tr>";
        }

     // fin du formulaire
       echo "</table>";
       echo "</form>";
     }
     // Deconnexion  **** vide les variables
     $res->free();
}//fin afficher

// paginationonglet utilise le javascript de onglet.php

function paginationonglet($recherche,$premier,$href,$nbligne,$style,$deleteall){
  // ***
  $precedent=0;
  $suivant=0;
  echo "<table  class='".$style."' border='0' ><tr>";
  echo "<td><form id='f2' name='f2'><center>";
 // echo "<br><input type='text' name='recherchedyn' id='recherchedyn' value='".$recherche."'  class='champFormulaire' onkeyup='recherche();' >";
       
  if ($premier>0){
      $precedent=$premier-$this->serie;
       echo "<input type='button' value= '<' onclick=\"precedent('".$this->tricol."')\">";
  }
   $dernieraffiche=$premier+ $this->serie;
   if($dernieraffiche>$nbligne) //controle $dernieraffiche
     $dernieraffiche=$nbligne;
   $premieraffiche=$premier+1;
   $varTemp= " ".$premieraffiche." - ".$dernieraffiche."&nbsp;".
       $this->om_lang('enregistrement')."&nbsp; ".$this->om_lang("sur")."&nbsp;".
   $nbligne;
   if (strcmp($recherche, ""))
      echo $varTemp." = [".$recherche."] ";
   else
      echo $varTemp." ";
      if ($premier+$this->serie<$nbligne){
           $suivant=$premier+$this->serie;
           echo "<input type='button' value= '>' onclick=\"suivant('".$this->tricol."')\">";
        }
   //pageselect
   $this->pageselectonglet($recherche,$premier,$nbligne);

   //ajout bouton Tout Supprimer en haut de soustab
   if ($deleteall==1 && $href[2]['toutsup'] && $nbligne>0)
      echo "<input type='button' value= 'Tout Supprimer' onclick=\"affichersform('".$href[2]['toutsup']."')\">";

   echo "</center></form></td></tr></table>";
   echo "<div id='pageselect_onglet' >";
   echo "<span  id='precedent' >".$precedent."</span>";
   echo "<span  id='suivant' >".$suivant."</span></div>";
}

// pageselectonglet utilise le javascript de onglet.php

function pageselectonglet($recherche,$premier,$nbligne){
//passage de $this->tricol  
  if($nbligne>$this->serie){ // si plus d une page
     if(($nbligne % $this->serie) == 0) // calcul du modulo
        $nbpage=(int)($nbligne/$this->serie) ;
     else
        $nbpage=(int)($nbligne/$this->serie)+1 ;
     echo "&nbsp;".$this->om_lang('page')."&nbsp;";
     echo "<select name='page' size='1' onchange=\"allerpage('".$this->tricol."');\" class='champFormulaire' >";
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
     $this->afficheentetecolone(false,$premier,$recherche,$href,$info);
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
     // *!*ajout 28nov07
     $nbchamp=0;
     $nbchamp=count($info);
     // *!*
     // pagination
     $style= "tabEntetenbr";
     $this->pagination($recherche,$premier,$nbligne,$style);

     // affichage de table info
     if($DEBUG==1) $this->affichedebuginfo($DEBUG,$info);

     // affichage Entete colone
     echo "<table class='tabCol' border='0'>";
     $this->afficheentetecolone(false,$premier,$recherche,$href,$info);
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
                   echo "<img src='../img/email-ch.png'  border='0' hspace='10' align='middle'>";
                   echo "</a>";
                 }
                 // *!*ajout 28nov07
                  if($nbchamp>1){
                     echo "<a  class='lienTable' href=".$href[1]['lien'].
                     urlencode ($row[0])."&idz=".urlencode($row[1])."".$href[1]['id'].">".$tmp2."</a>";
                  }else{// *!*
                     echo "<a  class='lienTable' href=".$href[1]['lien'].
                     urlencode ($row[0]).$href[1]['id'].">".$tmp2."</a>";
                  }// *!*
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
                   echo "<img src='../img/email-ch.png'  border='0' hspace='10' align='middle'>";
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
//
// =========================================
// translation
// in directory lang/$lanque.inc
// in openmairie
//==========================================
//
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
         if ($path_om=="") {
              include ($path_om.$langue.".inc");
         }else{
            if (file_exists($path_om.$langue.".inc")) {
               include ($path_om.$langue.".inc");
            }
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

