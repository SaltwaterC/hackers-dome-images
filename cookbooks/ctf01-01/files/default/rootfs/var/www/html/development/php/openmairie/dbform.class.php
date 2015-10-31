<?php
// =============================================================================
// $Id: dbform.class.php,v 1.1 2008-07-24 13:18:52 jbastide Exp $
// http://www.openmairie.org
// contact@openmairie.org
// =============================================================================

/* =============================================================================
   php version 4 et 5
   Classe abstraite
   var $type= type de champ
   var $longueurMax = longueur max de champ
   var $flags = table info db
   var $val = valeur des champs requete selection
   var $valF = valeur des champs retournés pour saisie et maj
   var $msg message retourne au formulaire de saisie
   var $correct flag retourné au formulaire
================================================================================
*/
// =============================================================================
// ver 1.01 : correction date 00/00/0000 datedb
//           fonction timeDB
// ver 1.02 : prise en compte du retour ($premier et $recherche)
// ver 1.07 : rajout des medhodes triggerajouter triggermodifier triggersupprimer
// ver 1.09 : methode verifier     passage de variable
//            methode setvalF()    initialisation par défaut
//            message() possibilité d inhiber le message
// ver 1.16   $_session['verrou']
// ver 1.18 : modification de commentaires
//            modification accents dans les meessages (compatibilite linux)
// ver 2.02 : langue (20 Mai 2008)
//==============================================================================

class dbForm {

    var $type;
    var $longueurMax;
    var $flags ;
    var $val;
    var $valF;
    var $msg;
    var $correct;


function constructeur($id,&$db,$DEBUG) {

        // ====================================================================
        // connexion.php = parametres de connexion
        // $dsn[phptype] = string / base de donnees concernee (repertoire)
        // $this->table.form.inc = fichier contenant la requete de construction
        // $champ => tableau des champs de la requete SELECT
        // $selection => string : clause where
        // id = identifiant (cle primaire) de l'objet dans la base
        // $this->tableSelect = table de selection
        // $this->clePrimaire = nom de champ de la cle primaire de la table
        // $this->typeCle ==  A=alphanumerique N=numerique
        // ====================================================================

        include ("../dyn/connexion.php");
        include ("../sql/".$dsn['phptype']."/".$this->table.".form.inc");
        $listeChamp="";
        foreach($champs as $elem)
            $listeChamp = $listeChamp."".$elem.",";
        $listeChamp=substr($listeChamp,0,strlen($listeChamp)-1);
        if ($id=="]"){
           $selection=ltrim($selection);
           if(strtolower(substr($selection,0,3))=='and')
                  $selection = " where ".
                  substr($selection,4,strlen($selection));
           $sql="select ".$listeChamp." from ".$tableSelect." ".$selection;
             }else{
             if($this->typeCle=="A")
             $sql="select ".$listeChamp." from ".$tableSelect." where ".
             $this->clePrimaire.
             " like '".$id."' ".$selection;
             else {
             $sql="select ".$listeChamp." from ".$tableSelect." where ".
             $this->clePrimaire." = ".$id." ".$selection;
             }
        }
        $res = $db->limitquery($sql,0,1);
        if (DB :: isError($res)){
           $this->erreur_db($res->getDebugInfo(),$res->getMessage(),$tableSelect);
        }else{
        $info=$res->tableInfo();
        if ($DEBUG == 1)
           $this->msg=$this->msg." la requete ".$sql." est executee<br>";
           if($DEBUG==1){   // affichage de table info
           $this->msg=$this->msg."<table border=1>";
           foreach($info as $elem){
             $this->msg=$this->msg."<tr>" ;
             foreach($elem as $elem1)
                $this->msg=$this->msg."<td>".$elem1."</td>";
             $this->msg=$this->msg."</tr>";
             }
           $this->msg=$this->msg."</table>";
           } // boucle for
           $i=0;
           // ======================================================
           // test compatibilite POSTGRESQL
           // len = -1
           // type vide
           // flags vide
           // ======================================================
            foreach($info as $elem) // recuperation infos de la base
                 $this->champs[$i++]=$elem['name'];
            foreach($info as $elem) // recuperation infos de la base
                 $this->longueurMax[$i++]=$elem['len'];
            foreach($info as $elem) // recuperation infos de la base
                 $this->type[$i++]=$elem['type'];
            foreach($info as $elem) // recuperation infos de la base
                 $this->flags[$i++]=$elem['flags'];
           while ($row=& $res->fetchRow()){
               $i=0;
               foreach($row as $elem) {
               $this->val[$i++]=$elem;
               }
           } // boucle while
     } //requete executee
} // fin constructeur

// methodes de mise a jour de la base de donnees ************************
// methode ajouter
// methode modifier
// methode supprimer
// **********************************************************************

// =================================
//              AJOUTER
// =================================


function ajouter ( $val,&$db,$DEBUG) { //1.15
// parametrage
$this->msg="";
$id='';
// valF
    $this->setValFAjout($val);
    $this->setValF($val);
    $this->verifier($val,$db,$DEBUG);
    $this->verifierAjout();
    $this->testverrou();
    if ($this->correct){
        $this->setId($db); //1.15
        $this->triggerajouter($id,$db,$val,$DEBUG);
        $res= $db->autoExecute($this->table,$this->valF,DB_AUTOQUERY_INSERT);
         if (DB :: isError($res))
               $this->erreur_db($res->getDebugInfo(),$res->getMessage(),'');
               else{
               if ($DEBUG == 1)
                 echo "La requête de mise a jour est effectuee.<br>";

               $this->msg=$this->msg."<br>".$this->om_lang("enregistrement")." ".
               $this->valF[$this->clePrimaire]." ".$this->om_lang("de_la").
               " ".$this->om_lang("table")." ".
               $this->table." [".$db->affectedRows().
               " ".$this->om_lang("enregistrement")." ".$this->om_lang("ajoute")."]" ;
               $this->verrouille();
               } // requete maj
         $this->triggerajouterapres($id,$db,$val,$DEBUG);
    }else{
    $this->msg=$this->msg. "<br>".$this->om_lang("non_enregistre");
    }
}

// initialisation valF pour la cle primaire (si pas de cle automatique)
function setValFAjout($val){
   $this->valF[$this->clePrimaire] = $val[$this->clePrimaire];
}
// initialisation valF pour la cle primaire (si  cle automatique)
function setId(&$db){
// id automatique nextid
}
// Verification
// la cle primaire est obligatoire
function verifierAjout(){
if ($this->valF[$this->clePrimaire]==""){
   $this->correct=false;
   $this->msg= $this->msg."<br>".$this->clePrimaire." ".$this->om_lang("obligatoire");
}}//function verifier ajout

// =================================
//              MODIFIER
// =================================

function modifier($val,&$db,$DEBUG){
 // valF
    $id=$val[$this->clePrimaire];
    $this->setValF($val);
    $this->verifier($val,$db,$DEBUG);
    $this->testverrou();
 if ($this->correct){
    $this->triggermodifier($id,$db,$val,$DEBUG);
    if($this->typeCle=="A")
           $cle= $this->clePrimaire." = '".$id."'";
    else
           $cle= $this->clePrimaire." = ".$id;
    $res= $db->autoExecute($this->table,$this->valF,DB_AUTOQUERY_UPDATE,$cle);
        if (DB :: isError($res))
              $this->erreur_db($res->getDebugInfo(),$res->getMessage(),'');
              else{
              if ($DEBUG == 1)
              echo "La requête de mise a jour est effectuee.<br>";
              $this->msg=$this->msg.$this->om_lang("enregistrement")." ".
              $id." ".$this->om_lang("de_la")." ".$this->om_lang("table")." ".
              $this->table." [".$db->affectedRows()." ".
              $this->om_lang("enregistrement")." ".$this->om_lang("mis_a_jour")."]" ;
              $this->verrouille();
              } // requete maj
    $this->triggermodifierapres($id,$db,$val,$DEBUG);
 }
}

// =================================
//              SUPPRIMER
// =================================

function supprimer($val,&$db,$DEBUG){
$id=$val[$this->clePrimaire];
$this->cleSecondaire($id,$db,$val,$DEBUG);
$this->testverrou();
if($this->correct) {
    $this->triggersupprimer($id,$db,$val,$DEBUG);
    if($this->typeCle=="A")
        $cle= $this->clePrimaire." = '".$id."'";
    else
        $cle= $this->clePrimaire." = ".$id;
    $sql= "delete from ".$this->table." where ".$cle;
    $res= $db->query($sql);
     if (DB :: isError($res))
           $this->erreur_db($res->getDebugInfo(),$res->getMessage(),'');
           else{
           if ($DEBUG == 1)
           echo "La requête".$sql." est effectuee.<br>";
           $this->msg=$this->msg."<br>".$this->om_lang("enregistrement")." ".$id.
           $this->om_lang("de_la")." ".$this->om_lang("table")." ".
           $this->table." [".$db->affectedRows()." ".
           $this->om_lang("enregistrement")." ".$this->om_lang("supprime")."]" ;
           $this->verrouille();
           } // requete maj
     $this->triggersupprimerapres($id,$db,$val,$DEBUG);
}}

// ===============================
//     CONTROLE INTEGRITE
// ===============================
// Verification de saisie
function verifier($val=null,&$db,$DEBUG=null){      //1.15
$this->correct=True;
}



function cleSecondaire($id,&$db,$val,$DEBUG) {
// controle suppression
$this->correct=True;
}
// recuperation des valeurs du formulaire
function setvalF($val){
//ver 1.09 tableau generique ***
    foreach(array_keys($val) as $elem){
         $this->valF[$elem] =$val[$elem];
    }
}

// TRIGGER AVANT MODIFICATION DE DONNEES
function triggerajouter($id,&$db,$val,$DEBUG) {
}
function triggermodifier($id,&$db,$val,$DEBUG) {
}
function triggersupprimer($id,&$db,$val,$DEBUG) {
}
// TRIGGER APRES MODIFICATION DE DONNEES
function triggerajouterapres($id,&$db,$val,$DEBUG) {
}
function triggermodifierapres($id,&$db,$val,$DEBUG) {
}
function triggersupprimerapres($id,&$db,$val,$DEBUG) {
}



// ============================================================================
//                             FORMULAIRE
// ============================================================================

function formulaire($enteteTab, $validation, $maj,&$db, $postVar,$aff, $DEBUG,$idx,$premier,$recherche){  //1.15
/*
$enteteTab: libelle d entete du formulaire
$styleform: style des controles du formulaires
$maj      : 0 ajouter / 1 mise a jour / 2 suppression
$db       : connexion base de donnees
$aff      : appel formulaire
$DEBUG    : 0= normal / 1= debugage
$idx      : valeur de l'id de la table mouvement (pour relancer la requete
$premier  : page de retour
$recherche: recherche pour retour
*/
$DEBUG=0;
if ($idx=="]" )
    echo "<form method=\"POST\" action=\"form.php?obj=".$aff."&validation=".$validation."\"  name=f1 style ='margin: 0; padding: 0;'>";
    // pas de passage de idx => ajout
else
    if($maj==1)       // modifier
    echo "<form method=\"POST\" action=\"form.php?obj=".$aff."&validation=".$validation.
    "&idx=".$idx."&premier=".$premier."&recherche=".$recherche."\" name=f1 style ='margin: 0; padding: 0;'>"; // passage de idx
    else              // supprimer
    echo "<form method=\"POST\" action=\"form.php?obj=".$aff."&validation=".$validation.
    "&ids=1"."&idx=".$idx."&premier=".$premier."&recherche=".$recherche."\" name=f1 style ='margin: 0; padding: 0;'>"; // passage de idx
$validation--; // compatibilite anterieure
$form = new formulaire($enteteTab, $validation, $maj, $this->champs,$this->val,$this->longueurMax);
//--------------------------------------------------------------------------
// valorisation des variables formulaires
//--------------------------------------------------------------------------
$this->setVal($form,$maj,$validation);
$this->setType($form,$maj) ;
$this->setLib($form,$maj) ;
$this->setTaille($form,$maj) ;
$this->setMax($form,$maj) ;
$this->setSelect($form,$maj,$db,$DEBUG) ;
$this->setOnchange($form,$maj) ;
$this->setGroupe($form,$maj) ;
$this->setRegroupe($form,$maj) ;
//--------------------------------------------------------------------------
// affichage du formulaire
// -------------------------------------------------------------------------
$form->entete();
$form->recupererPostvar($this->champs,$validation,$postVar,$DEBUG);
// validation ==============================================================
if ($validation>0) {
       if ($maj==2){
          $db->autoCommit(false);
          $this->supprimer($form->val,$db,$DEBUG);
          $db->commit() ;
       }else{
          if($maj==1) {
              $db->autoCommit(false);   //***1.14
              $this->modifier($form->val,$db,$DEBUG);
              $db->commit() ;
          }else{
              $db->autoCommit(false);
              $this->ajouter($form->val,$db,$DEBUG) ;
              $db->commit() ;
       }}
}
$this->deverrouille($validation); //*** 1.16
$form->afficher($this->champs,$validation,$DEBUG,$this->correct);
// Affichage du bouton, message et retour
$this->bouton($maj);
$this->retour($premier,$recherche);
$form->enpied();
//fin du formulaire
echo "</form>";
if ($validation>0) {
   $this->message();
}
} // fin formulaire

function deverrouille($validation){
// *** 1.16
if($validation==0)
 $_SESSION['verrou']=0;
}

function verrouille(){
// *** 1.16
$_SESSION['verrou']=1;
}

function testverrou(){
// *** 1.16
// $verrou est parametre dans var.inc
   $DEBUG=0;
    include ("../dyn/var.inc");

    if(!isset($verrou)){
        $verrou=0;
        $_SESSION['verrou']=0;
    }
    if($_SESSION['verrou']==1 and $verrou==1){
       $this->correct=false;
       $this->msg=$this->msg."<br>".$this->om_lang("verrou");
       if($DEBUG==1)
          $this->msg=$this->msg."<br>verrou var.inc = ".
          $verrou." verrou session = ".$_SESSION['verrou'];

    }else{
      if($DEBUG==1)
       $this->msg=$this->msg."verrou var.inc = ".
       $verrou."  verrou session = ".$_SESSION['verrou']."<br>";
    }
}


function message(){
// possibilite d inhiber le message si valeur a msgAffiche v1.09
include ("../dyn/var.inc");
if(!isset($msgAffiche))
 if ($this->msg!=""){
   echo "<center><table class='formErreur'><tr class='formErreur'><td>".
   $this->msg."</td></tr></table></center>";
 }
}
function retour($premier,$recherche){
// =============================================================================
// $premier = page de retour
// $recherche = critere de recherche retour
// =============================================================================
if (!$this->correct){
     echo "<a href=\"tab.php?obj=".$this->table.
     "&premier=".$premier."&recherche=".$recherche.
     "\">";
     // * custom *
    if(file_exists("../dyn/custom/img/retour.png")) {
       echo "<img src='../dyn/custom/img/retour.png' align='top' hspace='10' border='0'>";
    }
    else {
       echo"<img src='../img/retour.png' align='top' hspace='10' border='0'>";
    }
    //*
    echo "</a></center></td> </tr>";
}else{
     echo "<tr><td><br></td></tr><tr><td colspan=2><center><a href=\"tab.php?obj=".$this->table.
     "&premier=".$premier."&recherche=".$recherche.
     "\">";
     // * custom *
    if(file_exists("../dyn/custom/img/retour.png")) {
       echo "<img src='../dyn/custom/img/retour.png' align='top'  border='0'>";
    }
    else {
       echo"<img src='../img/retour.png' align='top'  border='0'>";
    }
    //*
    echo "</a></center></td> </tr>";
}}

function bouton($maj){
// =======================================================================
// Bouton Ajouter, modifier, supprimer
// =======================================================================
include("../dyn/var.inc"); // style bouton
if (!$this->correct){
   if ($maj == 2) //supprimer
       $bouton = $this->om_lang("Supprimer");
   else
       if ($maj == 1) // modifier   
           $bouton = $this->om_lang("Modifier");
       else // ajouter
           $bouton = $this->om_lang("Ajouter");
   echo "<tr><td><br></td></tr><tr><td colspan=2><center><input type='submit' value='".
        $bouton." ".ucwords($this->table)."' style=".$styleBouton.
        " >";
}}

// *************************************************************
// Parametrage du formulaire (specifique a chaque classe metier)
// Appel aux accesseurs de formulaire.class
// *************************************************************
function setVal(&$form,$maj,$validation){
}
function setType(&$form,$maj) {
}
function setLib(&$form,$maj) {
}
function setTaille(&$form,$maj){
}
function setMax(&$form,$maj){
}
function setSelect(&$form,$maj,$db,$DEBUG) {
}
function setOnchange(&$form,$maj){
}
function setGroupe(&$form,$maj){
}
function setRegroupe(&$form,$maj){
}
// ====================================================================
//         S O U S    F O R M U L A I R E
// ====================================================================

function sousformulaire($enteteTab, $validation, $maj,&$db, $postVar,$premiersf, $DEBUG,$idx,$idxformulaire,$retourformulaire,$typeformulaire,$objsf){
/*
$enteteTab: libelle d entete du formulaire
$styleform: style des controles du formulaires
$maj      : 0 ajouter / 1 mise a jour / 2 suppression
$db       : connexion base de donnees
$aff      : appel formulaire
$DEBUG    : 0= normal / 1= debugage
$idx      : valeur de l'id de la table mouvement (pour relancer la requete
$idxformulaire : idx du formulaire
$retourformulaire : nom du formulaire de retour
*/
$DEBUG=0;
if ($idx=="]" )
    echo "<form method=\"POST\" action=\"sousform.php?objsf=".
    $objsf."&retourformulaire=".$retourformulaire."&idxformulaire=".$idxformulaire.
    "&validation=".$validation."&premiersf=".$premiersf."\"  name=f1>";
    // pas de passage de idx => ajout
else
    if($maj==1)       // modifier
    echo "<form method=\"POST\" action=\"sousform.php?objsf=".
    $objsf."&retourformulaire=".$retourformulaire."&idxformulaire=".$idxformulaire.
    "&validation=".$validation."&idx=".$idx."&premiersf=".
    $premiersf."\" name=f1>"; // passage de idx
    else              // supprimer
    echo "<form method=\"POST\" action=\"sousform.php?objsf=".
    $objsf."&retourformulaire=".$retourformulaire."&idxformulaire=".$idxformulaire.
    "&validation=".$validation."&ids=1"."&idx=".$idx."&premiersf=".
    $premiersf."\" name=f1>"; // passage de idx
$validation--; // compatibilite anterieure
$form = new formulaire($enteteTab, $validation, $maj, $this->champs,$this->val,$this->longueurMax);
//--------------------------------------------------------------------------
// valorisation des variables formulaires
//--------------------------------------------------------------------------
$this->setValsousformulaire($form,$maj,$validation,$idxformulaire,$retourformulaire,$typeformulaire);
$this->setType($form,$maj) ;
$this->setLib($form,$maj) ;
$this->setTaille($form,$maj) ;
$this->setMax($form,$maj) ;
$this->setSelect($form,$maj,$db,$DEBUG) ;
$this->setOnchange($form,$maj) ;
$this->setGroupe($form,$maj) ;
$this->setRegroupe($form,$maj) ;
//--------------------------------------------------------------------------
// affichage du formulaire
// -------------------------------------------------------------------------
$form->entete();
$form->recupererPostvar($this->champs,$validation,$postVar,$DEBUG);
// validation ==============================================================
if ($validation>0) {
       if ($maj==2){
          $db->autoCommit(false);
          $this->supprimer($form->val,$db,$DEBUG);
          $db->commit() ;
       }else{
          if($maj==1) {
              $db->autoCommit(false);
              $this->modifier($form->val,$db,$DEBUG);
              $db->commit() ;
          }else{
              $db->autoCommit(false);
              $this->ajouter($form->val,$db,$DEBUG,$idx) ;
              $db->commit() ;
}}}
$this->deverrouille($validation);
$form->afficher($this->champs,$validation,$DEBUG,$this->correct);
// Affichage du bouton, message et retour
$this->message();
//$this->boutonsousformulaire($maj,$idxformulaire,$retourformulaire);
$this->bouton($maj);
$this->retoursousformulaire($idxformulaire,$retourformulaire,$form->val,$objsf,$premiersf);
$form->enpied();
//fin du formulaire
echo "</form>";
} // fin formulaire



function retoursousformulaire($idxformulaire,$retourformulaire,$val,$objsf,$premiersf){

if (!$this->correct){
     echo "<a href=\"form.php?obj=".
     $retourformulaire."&idx=".$val[$retourformulaire].
     "&objsf=".$objsf."&premiersf=".$premiersf."\">";
     // * custom *
    if(file_exists("../dyn/custom/img/retour.png")) {
       echo "<img src='../dyn/custom/img/retour.png' align='top' hspace='10' border='0'>";
    }
    else {
       echo"<img src='../img/retour.png' align='top' hspace='10' border='0'>";
    }
    //*
    echo "</a></center></td> </tr>";
}else{
     echo "<tr><td><br></td></tr><tr><td colspan=2><center><a href=\"form.php?obj=".
     $retourformulaire."&idx=".$val[$retourformulaire].
     "&objsf=".$objsf."&premiersf=".$premiersf."\">";
     // * custom *
    if(file_exists("../dyn/custom/img/retour.png")) {
       echo "<img src='../dyn/custom/img/retour.png' align='top'  border='0'>";
    }
    else {
       echo"<img src='../img/retour.png' align='top'  border='0'>";
    }
    //*
    echo "</a></center></td> </tr>";
}}

function setValsousformulaire(&$form,$maj,$validation,$idxformulaire,$retourformulaire,$typeformulaire){

if ($validation==0) {
  if ($maj == 0){

    $form->setVal($retourformulaire, $idxformulaire);
}}
}

// =====================================================================
// Traitement d erreur
// transfert a l ecran des erreurs de bases de donnees
// =====================================================================
function erreur_db($debuginfo,$messageDB,$table)
{
        include ("error_db.inc");
        echo "<table class='tabCol'>";
        echo "<tr class='tabCol'>";
        echo "<td colspan=2>  Attention, Erreur de base de donnees";
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
        echo "<td colspan=2>";
         // * custom *
         if(file_exists("../dyn/custom/img/erreur.png")) {
            echo "<img src='../dyn/custom/img/erreur.png' align='top'  border='0'>";
         }
         else {
            echo"<img src='../img/erreur.gif' border='0'>";
         }
        //*
        echo  "<b>Requete non executee</b>: ";
         // * custom *
         if(file_exists("../dyn/custom/img/zoneobligatoire.png")) {
            echo "<img src='../dyn/custom/img/zoneobligatoire.png'  border='0'>";
         }
         else {
            echo"<img src=../img/zoneobligatoire.gif border='0'>";
         }
        echo "Contactez votre administrateur ... ";
        echo "</td>";
        echo "</tr></table>";
        echo "</div>";
        include "../dyn/menu.inc";
        die();
}





// ======================================================================
// fonction de traitement de date qui est saisie sous la forme JJ/MM/AAAA
// dateSyspmePHP renvoie la date systeme au format de la base de donnees
// dateDB met la date au format de la base de donnees
// datePHP met la date au format PHP
// anneePHP, moisPHP, jourPHP controle les dates affichees et transforme
// en date en format PHP pour les annee mois et jour
// heureDB controle l heure saisie
// ======================================================================

function dateDB($val) {
// ============================================================
// transforme les dates affichees en date pour base de donnees
// suivant parametre dans connexion.php [$formatDate]
// ============================================================
$dateOK=1; // Flag sur longueur de date annee mois jour
$date = explode("/", $val);
// annee est sur 2 caractere / 1 caractere
if ($date==""){
   if  (strlen($date[2]) ==2) $date[2]="20".$date[2] ;
   if  (strlen($date[2]) ==1) $date[2]="200".$date[2] ;
   if  (strlen($date[2]) !=4){
       echo "faux";
       $dateOK=0;
   }
// mois sur un caractere
   if  (strlen($date[1]) ==1) $date[1]="0".$date[1] ;
   if  (strlen($date[1]) !=2){
       $dateOK=0;
   }
}
// Jour sur 1 caractere
if  (strlen($date[0]) ==1) $date[0]="0".$date[0] ;
if  (strlen($date[0]) !=2){
   $dateOK=0;
}
// Transforme la date suivant parametre date => connexion
if ($dateOK==1){
   include ("../dyn/connexion.php");
   if ($formatDate=="AAAA-MM-JJ"){
   // controle de date
      if (sizeof($date) == 3 and (checkdate($date[1],$date[0],$date[2])or $val=="00/00/0000")) {
         return $date[2]."-".$date[1]."-".$date[0];
      }else{
          $this->msg= $this->msg."<br>la date ".$val." n'est pas une date";
          if($this->correct==true) $this->correct=false;
      }
   }
   if ($formatDate=="JJ/MM/AAAA"){
   // controle de date
      if (sizeof($date) == 3  and checkdate($date[1],$date[0],$date[2])){
         return $date[0]."/".$date[1]."/".$date[2];
      }else{
          $this->msg= $this->msg."<br>la date ".$val." n'est pas une date";
          $this->correct=false;
      }
   }
}else{
      // Format de saisie mauvais
      $this->msg= $this->msg."<br>la date ".$val." n'est pas une date";
      $this->correct=false;
}
}

function heureDB($val) {
// =====================================================================
// controle du champs heure saisi 00 ou 00:00 ou 00:00:00
// =====================================================================
// pb saisie H et h **************
$val = str_replace("H",":",$val);
$val = str_replace("h",":",$val);
// ================================
$heure = explode(":", $val);
   if (sizeof($heure) >= 1 or sizeof($heure) <= 3 ) {
      If (sizeof($heure) ==1 and $heure[0]>=0 and $heure[0] <= 23)
         return $heure[0].":00:00";
      If (sizeof($heure) ==2 and $heure[0]>=0 and $heure[0] <= 23 and $heure[1]>=0 and $heure[1] <= 59)
         return $heure[0].":".$heure[1].":00";
      If (sizeof($heure) ==3 and $heure[0]>=0 and $heure[0] <= 23 and $heure[1]>=0 and $heure[1] <= 59 and $heure[2]>=0 and $heure[2] <= 59)
         return $heure[0].":".$heure[1].":".$heure[2];
   }
       $this->msg= $this->msg."<br>l heure ".$val." n'est pas une heure";
       $this->correct=false;
}

function dateSystemeDB() {
// =======================================================================
// mise au format base de donnees de la date systeme
// suivant parametre dans connexion.php [$formatDate]
// =======================================================================
include ("../dyn/connexion.php");
if ($formatDate=="AAAA-MM-JJ")
      return date('Ymd');
if ($formatDate=="JJ/MM/AAAA")
    return date('d/m/y');
}

function datePHP($val) {
// ======================================================================
// controle et transforme la date saisie (jj/mm/aaaa) en date  format PHP
// pour faire des calculs
// ======================================================================
// annee = 2 mois = 0 jour = 1
// ========================
$date = explode("/", $val);
// controle de date
if (sizeof($date) == 3 and checkdate($date[1],$date[0],$date[2] )){
   return $date[2]."-".$date[1]."-".$date[0];
}else{
   $this->msg= $this->msg."<br>la date ".$val." n'est pas une date (calcul date php)";
   $this->correct=false;
}}

function anneePHP($val) {
// ==========================================================================
// controle et recupere l annee de la date saisie (jj/mm/aaaa)
// pour faire des calculs
// ==========================================================================
$date = explode("/", $val);
// controle de date
if (sizeof($date) == 3 and checkdate($date[1],$date[0],$date[2])){
   return $date[2];
}else{
   $this->msg= $this->msg."<br>la date ".$val." n'est pas une date (calcul annee)";
   $this->correct=false;
}}

function moisPHP($val) {
// ==========================================================================
// controle et recupere le mois de la date saisie (jj/mm/aaaa)
// pour faire des calculs
// ==========================================================================
$date = explode("/", $val);
// controle de date
if (sizeof($date) == 3 and checkdate($date[1],$date[0],$date[2])){
   return $date[0];
}else{
   $this->msg= $this->msg."<br>la date ".$val." n'est pas une date (calcul Mois)";
   $this->correct=false;
}}

function jourPHP($val) {
// ==========================================================================
// controle et recupere le jour de la date saisie (jj/mm/aaaa)
// pour faire des calculs
// ==========================================================================
$date = explode("/", $val);
// controle de date
if (sizeof($date) == 3 and checkdate($date[1],$date[0],$date[2])){
   return $date[1];
}else{
   $this->msg= $this->msg."<br>la date ".$val." n'est pas une date";
   $this->correct=false;
}}

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
         if(!isset($lang[$texte])) $lang[$texte]='<i>'.$texte.'</i>';
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
         if(!isset($lang[$texte])) $lang[$texte]='<i>'.$texte.'</i>';
         return $lang[$texte];
}

}// fin de classe
?>