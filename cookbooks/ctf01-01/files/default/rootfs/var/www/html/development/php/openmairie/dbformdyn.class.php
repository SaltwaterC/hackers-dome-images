<?php
// =============================================================================
// $Id: dbformdyn.class.php,v 1.1 2008-07-24 13:18:52 jbastide Exp $
// http://www.openmairie.org
// contact@openmairie.org
// =============================================================================

/* =============================================================================
   php version 4 et 5
   Classe abstraite     [abstract class]
   var $type= type de champ  [field typify]
   var $longueurMax = longueur max de champ [fields len max]
   var $flags = table info db   [database information]
   var $val = valeur des champs requete selection [form controls values]
   var $valF = valeur des champs retournes pour saisie et maj [database values]
   var $msg message retourne au formulaire de saisie [return message to form]
   var $correct flag retourne au formulaire [return flag to form]
================================================================================
*/
// =============================================================================
// ver 2.00 : version dynamique full onglet
//==============================================================================

/* maj et debug version 2.00 ---------------------------------------------------
 18/01/2008 (+) setValsousformulaire : parametre db (openstock2 - versement.class
 18/01/2008 function modifier : modif affichage message apres validation
 03/07/2008 (+) setLib automatique
------------------------------------------------------------------------------*/

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
        // connexion.php = parametres de connexion   [connexion setting]
        // $dsn[phptype] = string  database (mysql, pgsql ...)
        // $this->table.form.inc = fichier contenant la requete de construction
        //                         file with request
        // $champ => tableau des champs de la requete SELECT
        //           [fields array]
        // $selection => string : clause where   [selection]
        // id = identifiant (cle primaire) de l'objet dans la base  [primary key]
        // $this->tableSelect = table de selection   [table]
        // $this->clePrimaire = nom de champ de la cle primaire de la table
        //                      [primary key field name]
        // $this->typeCle ==  A=alphanumerique N=numerique
        //                    [primaykey N =numeric A= not numeric]
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
           if($DEBUG==1){   // affichage de table info [display database information]
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
           // DATABASE INFORMATION
           // test compatibilite POSTGRESQL
           // len = -1
           // type vide
           // flags vide
           // ======================================================
            foreach($info as $elem)
                 $this->champs[$i++]=$elem['name'];
            foreach($info as $elem)
                 $this->longueurMax[$i++]=$elem['len'];
            foreach($info as $elem)
                 $this->type[$i++]=$elem['type'];
            foreach($info as $elem)
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
// [methods to modify the database]
// methode ajouter     [method add]
// methode modifier    [method modify]
// methode supprimer   [method delete}
// **********************************************************************

// =================================
//              AJOUTER   [ADD]
// =================================


function ajouter ( $val,&$db,$DEBUG) {
// variables
$this->msg="";
$id='';
// valF
    $this->setValFAjout($val);
    $this->setValF($val);
    $this->verifier($val,$db,$DEBUG);
    $this->verifierAjout();
    $this->testverrou();
    if ($this->correct){
        $this->setId($db);
        $this->triggerajouter($id,$db,$val,$DEBUG);
        $res= $db->autoExecute($this->table,$this->valF,DB_AUTOQUERY_INSERT);
         if (DB :: isError($res))
               $this->erreur_db($res->getDebugInfo(),$res->getMessage(),'');
               else{
               if ($DEBUG == 1)
                 echo "La requete de mise a jour est effectuee.<br>";
               $this->msg=$this->msg.$this->om_lang("enregistrement")."&nbsp;".
               $this->valF[$this->clePrimaire]." ".$this->om_lang("de_la")."&nbsp;".$this->om_lang("table")."&nbsp;".
               $this->table." [ ".$db->affectedRows()."&nbsp;".
                  $this->om_lang("enregistrement")."&nbsp;".$this->om_lang("ajoute")."&nbsp;]";
               $this->verrouille(); // *** verrou ***
               }
         $this->triggerajouterapres($id,$db,$val,$DEBUG);
    }else{
       if(file_exists("../img/attention.png")) {
         $this->msg=$this->msg. "<br><center><img src='../img/attention.png' hspace='5' vspace='5' border='0'><br>".$this->om_lang("non")."&nbsp;".$this->om_lang("enregistrer")."</center> ";
       }else{
          $this->msg=$this->msg. "<br>".$this->om_lang("non")."&nbsp;".$this->om_lang("enregistrer");
       }
    }
}

// **********************************************
// ajouter : Cle primaire automatique ou pas
// Add : Automatic or not automatic primary key
// **********************************************


function setValFAjout($val){
// initialisation valF pour la cle primaire (si pas de cle automatique)
// [value primary key to database - not automatic primary key]
   $this->valF[$this->clePrimaire] = $val[$this->clePrimaire];
}

function setId(&$db){
// initialisation valF pour la cle primaire (si  cle automatique)
// [value primary key to database - automatic primary key]
// id automatique method nextid
// automatic id with dbpear method nextid
}

function verifierAjout(){
// Verifier [verify]
// la cle primaire est obligatoire
// [primary key is compulsory]
if ($this->valF[$this->clePrimaire]==""){
   $this->correct=false;
   if(file_exists("../img/cle.png")) {
     $this->msg= $this->msg."<br><img src='../img/punaise.png'  style='vertical-align:middle'  vspace='5' hspace='2' border='0' />".$this->om_lang("identifiant")."&nbsp;\"".$this->clePrimaire."\"&nbsp;".$this->om_lang("obligatoire");
   }else{
     $this->msg= $this->msg."<br>\"".$this->om_lang("identifiant")."\"&nbsp;".$this->clePrimaire."&nbsp;".$this->om_lang("obligatoire");
   }
}}//function verifierAjout

// =================================
//          MODIFIER  MODIFY
// =================================

function modifier($val,&$db,$DEBUG){
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
                if ($db->affectedRows()==0){
                    if(file_exists("../img/attention.png")) {
                      $this->msg=$this->msg.
                      "<center><img src='../img/attention.png' hspace='5' vspace='5' border='0'><br>".$this->om_lang("mise_a_jour")."&nbsp;".$this->om_lang("non")."&nbsp;".$this->om_lang("effectuee")."&nbsp;!</center>";
                    } else{
                     $this->msg=$this->msg."<br><center>".$this->om_lang("mise_a_jour").
                     "&nbsp;".$this->om_lang("non")."&nbsp;".
                     $this->om_lang("effectuee")."&nbsp;!</center>" ;
                     }
                }else{
                // this->msg
                   $this->msg=$this->msg."<center>".
                   $this->om_lang("enregistrement")."&nbsp;".$id.
                   "&nbsp;".$this->om_lang("de_la")."&nbsp;".
                   $this->om_lang("table")."&nbsp;\"".
                   $this->table."\"<br>[&nbsp;".$db->affectedRows()."&nbsp;".
                   $this->om_lang("enregistrement")."&nbsp;".
                   $this->om_lang("mis_a_jour")."&nbsp;]</center>" ;
                }
              $this->verrouille(); // *** VERROU
              }
    $this->triggermodifierapres($id,$db,$val,$DEBUG);
 }
}

// =================================
//         SUPPRIMER  [DELETE]
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
           echo "La requete".$sql." est effectuee.<br>";
           $this->msg=$this->msg.$this->om_lang("enregistrement")."&nbsp;".$id."&nbsp;".$this->om_lang("de_la")."&nbsp;".$this->om_lang("table")."&nbsp;".
           $this->table." [ ".$db->affectedRows()."&nbsp;".
              $this->om_lang("enregistrement")."&nbsp;".$this->om_lang("supprime")."&nbsp;]";
           $this->verrouille(); // VERROU
           }
     $this->triggersupprimerapres($id,$db,$val,$DEBUG);
}}

// ===============================
//     CONTROLE INTEGRITE
// ===============================
// Verification de saisie [verify saisure]

function verifier($val=null,&$db,$DEBUG=null){
$this->correct=True;
}

function cleSecondaire($id,&$db,$val,$DEBUG) {
// controle suppression cle secondaire [secondary key delete control]
$this->correct=True;
}
// recuperation des valeurs du formulaire  [recovery form values to data]
function setvalF($val){
    // recuperation automatique [automatic recovery]
    foreach(array_keys($val) as $elem){
         $this->valF[$elem] =$val[$elem];
    }
}

// TRIGGER AVANT MODIFICATION DE DONNEES  [TRIGGER BEFORE TO MODIFY DATA]
function triggerajouter($id,&$db,$val,$DEBUG) {
}
function triggermodifier($id,&$db,$val,$DEBUG) {
}
function triggersupprimer($id,&$db,$val,$DEBUG) {
}
// TRIGGER APRES MODIFICATION DE DONNEES  [TRIGGER AFTER TO MODIFY DATA]
function triggerajouterapres($id,&$db,$val,$DEBUG) {
}
function triggermodifierapres($id,&$db,$val,$DEBUG) {
}
function triggersupprimerapres($id,&$db,$val,$DEBUG) {
}



// ============================================================================
//                             FORMULAIRE             [FORM]
// ============================================================================

function formulaire($enteteTab, $validation, $maj,&$db, $postVar,$aff, $DEBUG,$idx,$premier,$recherche,$tricol,$idz){  //1.15
/*
$enteteTab: libelle d entete du formulaire         [form head (not use)]
$styleform: style des controles du formulaires     [control form style]
$maj      : 0 ajouter / 1 mise a jour / 2 suppression [0=add,1=modify,2=delete,3=delete all]
$db       : connexion base de donnees [dbpear object : database connexion]
$aff      : appel formulaire  [call form]  *** remplacement de aff par get_class($this)
$DEBUG    : 0= normal / 1= debugage
$idx      : valeur de l'id de la table [occurence]
$premier  : page de retour   [return page tab.class.php]
$recherche: recherche pour retour [return page tab.class.php with search]
$tricol : tri pour retour [return sort tab.class.php]
*/
// variables
$DEBUG=0;
// FORM
if ($idx=="]" )  // ajouter [add]
    echo "<form method=\"POST\" action=\"form.php?obj=".get_class($this)."&validation=".$validation."\"  name=f1 style ='margin: 0; padding: 0;'>";
else
    if($maj==1)       // modifier [modify]
    echo "<form method=\"POST\" action=\"form.php?obj=".get_class($this)."&validation=".$validation.
    "&idx=".$idx."&idz=".$idz."&premier=".$premier."&recherche=".$recherche."&tri=".$tricol."\" name=f1 style ='margin: 0; padding: 0;'>"; // passage de idx
    else              // supprimer [delete]
    echo "<form method=\"POST\" action=\"form.php?obj=".get_class($this)."&validation=".$validation.
    "&ids=1"."&idx=".$idx."&idz=".$idz."&premier=".$premier."&recherche=".$recherche."&tri=".$tricol."\" name=f1 style ='margin: 0; padding: 0;'>"; // passage de idx
$validation--; // compatibilite anterieure [old compatibility]
$form = new formulaire($enteteTab, $validation, $maj, $this->champs,$this->val,$this->longueurMax);
//--------------------------------------------------------------------------
// valorisation des variables formulaires  [form variables values]
//--------------------------------------------------------------------------
$this->setVal($form,$maj,$validation,$db,$DEBUG);
$this->setType($form,$maj) ;
$this->setLib($form,$maj) ;
$this->setTaille($form,$maj) ;
$this->setMax($form,$maj) ;
$this->setSelect($form,$maj,$db,$DEBUG) ;
$this->setOnchange($form,$maj) ;
$this->setOnkeyup($form,$maj) ; //***
$this->setOnclick($form,$maj) ; //***
$this->setGroupe($form,$maj) ;
$this->setRegroupe($form,$maj) ;
//--------------------------------------------------------------------------
//         *** affichage du formulaire ***           [display form]
// -------------------------------------------------------------------------
$form->entete();
$form->recupererPostvar($this->champs,$validation,$postVar,$DEBUG);
// ----------
// validation
// ----------
if ($validation>0) {
       if ($maj==2){ // [delete]
          $db->autoCommit(false);
          $this->supprimer($form->val,$db,$DEBUG);
          $db->commit() ;
       }else{
          if($maj==1) {  //[modify]
              $db->autoCommit(false);
              $this->modifier($form->val,$db,$DEBUG);
              $db->commit() ;
          }else{  // [add]
              $db->autoCommit(false);
              $this->ajouter($form->val,$db,$DEBUG) ;
              $db->commit() ;
       }}
}
$this->deverrouille($validation); //*** VERROU
$form->afficher($this->champs,$validation,$DEBUG,$this->correct);
// --------------------------------------
// Affichage du bouton, message et retour
// [display button, message, return]
// --------------------------------------
$this->bouton($maj);
$this->retour($premier,$recherche,$tricol);
$form->enpied();
// end form
echo "</form>";
if ($validation>0) {
   $this->message();
}
} // end function formulaire

// =================================================
// VERROU pour ne pas valider 2 fois
// [bolt don't validate twice]
// =================================================
function deverrouille($validation){
if($validation==0)
 $_SESSION['verrou']=0;
}

function verrouille(){
$_SESSION['verrou']=1;
}

function testverrou(){
// $verrou est parametre dans var.inc
// [verrou is a setting parameter of dyn/var.inc]
   $DEBUG=0;
    include ("../dyn/var.inc");
    if(!isset($verrou)){
        $verrou=0;
        $_SESSION['verrou']=0;
    }
    if($_SESSION['verrou']==1 and $verrou==1){
       $this->correct=false;
       $this->msg=$this->msg."<br> verrou actif - procedure anormale";
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

function retour($premier,$recherche,$tricol){
// =============================================================================
// $premier = page de retour
// $recherche = critere de recherche retour
// =============================================================================
//passage de get_class($this) plutot que $this->table
//prise en charge $tricol
if (!$this->correct){
     echo "<a href=\"tab.php?obj=".get_class($this)."&tri=".$tricol.
     "&premier=".$premier."&recherche=".$recherche.
     "\">";
     echo"<img src='../img/retour.png' align='top' hspace='10' border='0'>";
     echo "</a></center></td> </tr>";
}else{
     echo "<tr><td><br></td></tr><tr><td colspan=2><center><a href=\"tab.php?obj=".
     get_class($this)."&tri=".$tricol."&premier=".$premier."&recherche=".$recherche.
     "\">";
     echo"<img src='../img/retour.png' align='top'  border='0'>";
     echo "</a></center></td> </tr>";
}}

function bouton($maj){
// =======================================================================
// Bouton Ajouter, modifier, supprimer
// =======================================================================
include("../dyn/var.inc");
//*
if (!$this->correct){
   if ($maj == 2) //supprimer
       $bouton = $this->om_lang("Supprimer");
   else
       if ($maj == 1) // modifier   
           $bouton = $this->om_lang("Modifier");
       else // ajouter
           $bouton = $this->om_lang("Ajouter");
     echo "<tr><td><br></td></tr><tr><td colspan=2><center>";
  echo "<button type='submit' style='".$styleBouton."'>".$bouton."&nbsp;".$this->om_lang("enregistrement")."&nbsp;".$this->om_lang("table")."&nbsp;:&nbsp;\"".ucwords($this->table)."\"</button>";
}}

function boutonsousformulaire($datasubmit,$maj,$val=null){
  include("../dyn/var.inc");
  if (!$this->correct){
  $tmp="";
  $tmp="&nbsp;".$this->om_lang("enregistrement")."&nbsp;".$this->om_lang("table")."&nbsp;:&nbsp;";
    switch ($maj) {
      case 0:
        $bouton = $this->om_lang("Ajouter").$tmp;
        break;
      case 1:
        $bouton = $this->om_lang("Modifier").$tmp;
        break;
      case 2:
        $bouton = $this->om_lang("Supprimer").$tmp;
        break;
      case 3:
        $bouton = $this->om_lang("tout")."&nbsp;".$this->om_lang("Supprimer");
    }
    echo "<tr><td><br></td></tr><tr><td colspan=2><center><input type='button' value='".
    $bouton." ".ucwords($this->table)."' style=".$styleBouton.
    " onclick=\"affichersform('$datasubmit')\">";
    //
  }
}

// *************************************************************
// Parametrage du formulaire (specifique a chaque classe metier)
// Appel aux accesseurs de formulaire.class
// *************************************************************
function setVal(&$form,$maj,$validation,&$db,$DEBUG=null){
}

function setType(&$form,$maj) {
}

function setLib(&$form,$maj) {
// libelle automatique
//[automatic wording]
    foreach(array_keys($form->val) as $elem){
         $form->setLib($elem,$this->lang($elem));
    }
}

function setTaille(&$form,$maj){
}

function setMax(&$form,$maj){
}

function setSelect(&$form,$maj,&$db,$DEBUG) {
}

function setOnchange(&$form,$maj){
}

function setOnkeyup(&$form,$maj) {
}

function setOnclick(&$form,$maj){
}

function setGroupe(&$form,$maj){
}

function setRegroupe(&$form,$maj){
}

// ====================================================================
//         S O U S    F O R M U L A I R E    [SUB FORM]
// ====================================================================

function sousformulaire($enteteTab, $validation, $maj,&$db, $postVar,$premiersf, $DEBUG,$idx,$idxformulaire,$retourformulaire,$typeformulaire,$objsf,$tricolsf){
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
//passage tricolonne soustableau par $tricolsf
$DEBUG=0;
//sousformulaire genere par ajax [sub form with ajax]
$datasubmit=""; 
if ($idx=="]")// sans idx [without idx]
  if($maj==0) // ajouter  [add]
    $datasubmit="objsf=$objsf&premiersf=$premiersf&retourformulaire=$retourformulaire&idxformulaire=$idxformulaire&trisf=$tricolsf".
    "&validation=$validation";
  else  // tout supprimer $maj==3 [delete all]
    $datasubmit="objsf=$objsf&premiersf=$premiersf&retourformulaire=$retourformulaire&idxformulaire=$idxformulaire&trisf=$tricolsf".
    "&validation=$validation&ids=2";
else          // avec idx [with idx]
  if($maj==1)   // modifier  [modify]
    $datasubmit="objsf=$objsf&premiersf=$premiersf&retourformulaire=$retourformulaire&idxformulaire=$idxformulaire&trisf=$tricolsf".
    "&validation=$validation&idx=$idx";
  else  // supprimer  [delete]
    $datasubmit="objsf=$objsf&premiersf=$premiersf&retourformulaire=$retourformulaire&idxformulaire=$idxformulaire&trisf=$tricolsf".
    "&validation=$validation&ids=1&idx=$idx";
echo "<form method=\"POST\" action=\"\" onsubmit=\"affichersform('$datasubmit'); return false\" name=f2>";
$validation--; // compatibilite anterieure
$form = new formulaire($enteteTab, $validation, $maj, $this->champs,$this->val,$this->longueurMax);
//--------------------------------------------------------------------------
// valorisation des variables formulaires    [form variables values]
//--------------------------------------------------------------------------
$this->setValsousformulaire($form,$maj,$validation,$idxformulaire,$retourformulaire,$typeformulaire,$db,$DEBUG);
$this->setType($form,$maj) ;
$this->setLib($form,$maj) ;
$this->setTaille($form,$maj) ;
$this->setMax($form,$maj) ;
$this->setSelect($form,$maj,$db,$DEBUG) ;
$this->setOnchange($form,$maj) ;
$this->setOnkeyup($form,$maj) ;
$this->setOnclick($form,$maj) ;
$this->setGroupe($form,$maj) ;
$this->setRegroupe($form,$maj) ;
//--------------------------------------------------------------------------
// affichage du formulaire
// -------------------------------------------------------------------------
$form->entete();
$form->recupererPostvarsousform($this->champs,$validation,$postVar,$DEBUG);
// validation ==============================================================
if ($validation>0) {
   if ($maj==3){
      $db->autoCommit(false);
      $this->toutsupprimer($form->val,$idxformulaire,$db,$DEBUG);
      $db->commit() ;
      }else{
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
}}}}
$this->deverrouille($validation);
$form->afficher($this->champs,$validation,$DEBUG,$this->correct);
// Affichage du bouton, message et retour
$this->message();
$this->boutonsousformulaire($datasubmit,$maj,$form->val);
//$this->bouton($maj);
$this->retoursousformulaire($idxformulaire,$retourformulaire,$form->val,$objsf,$premiersf,$tricolsf);
$form->enpied();
//fin du formulaire
echo "</form>";
} // fin formulaire



function retoursousformulaire($idxformulaire,$retourformulaire,$val,$objsf,$premiersf,$tricolsf){
//passage de $tricolsf pour usage futur possible avec activer()
if (!$this->correct){
    echo "<a onclick=\"activer('$objsf','$premiersf')\" href='#'>";
    echo"<img src='../img/retour.png' align='top' hspace='10' border='0'>";
    echo "</a></center></td> </tr>";
}else{
    echo "<tr><td><br></td></tr><tr><td colspan=2><center><a onclick=\"activer('$objsf','$premiersf')\" href='#'>";
    echo"<img src='../img/retour.png' align='top'  border='0'>";
    echo "</a></center></td> </tr>";
}}

function setValsousformulaire(&$form,$maj,$validation,$idxformulaire,$retourformulaire,$typeformulaire,&$db,$DEBUG=null){
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
        echo "<tr class='tabdata'><td>Requï¿½te</td>";
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
         if(!isset($path_om)) $path_om="";
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
}// fin de classe
?>