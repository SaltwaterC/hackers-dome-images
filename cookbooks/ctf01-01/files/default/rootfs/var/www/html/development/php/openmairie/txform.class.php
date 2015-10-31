<?php
// =============================================================================
// $Id: txform.class.php,v 1.1 2008-07-24 13:18:52 jbastide Exp $
// http://www.openmairie.org
// contact@openmairie.org
// =============================================================================

/* =============================================================================
   php version 4 et 5
   fr 22/02/2006
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


class txForm {

    var $type;
    var $longueurMax;
    var $val;
    var $valF;
    var $msg;
    var $correct;


// méthodes de mise à jour de la base de données ************************
// methode ajouter
// methode modifier
// methode supprimer
// **********************************************************************
// =================================
//              AJOUTER
// =================================


function ajouter($val,&$db,$DEBUG){
    $this->setValF($val);
    $this->verifier();
 if ($this->correct){
    include("../dyn/var.inc");
    include ("../dyn/connexion.php");
    if (isset($langue)){
         $fichier = "../sql/".$dsn['phptype']."/".$langue."/".$this->obj.".".$this->objet.".inc";
    }else{
         $fichier = "../sql/".$dsn['phptype']."/".$this->obj.".".$this->objet.".inc";
    }
    $inf = fopen($fichier,"w");
    fwrite($inf,$this->valF);
    fclose($inf);
    if (isset($langue)){
      $this->msg=$this->msg.$this->om_lang("le")." ".$this->om_lang("fichier")." \"../sql/".$dsn['phptype']."/".$langue."/".
      $this->obj.".".$this->objet.".inc\""." ".$this->om_lang("est")." ".$this->om_lang("enregistre") ;
    }else{
      $this->msg=$this->msg."le fichier \"../sql/".$dsn['phptype']."/".
      $this->obj.".".$this->objet.".inc\" est enregistré" ;
    }
}}




// =================================
//              MODIFIER
// =================================

function modifier($val,&$db,$DEBUG){
    $this->setValF($val);
    $this->verifier();
 if ($this->correct){
    include("../dyn/var.inc");
    include ("../dyn/connexion.php");
   if (isset($langue)){
         $fichier = "../sql/".$dsn['phptype']."/".$langue."/".$this->obj.".".$this->objet.".inc";
    }else{
         $fichier = "../sql/".$dsn['phptype']."/".$this->obj.".".$this->objet.".inc";
    }
    $inf = fopen($fichier,"w");
    fwrite($inf,$this->valF);
    fclose($inf);
    if (isset($langue)){
      $this->msg=$this->msg.$this->om_lang("le")." ".$this->om_lang("fichier")." \"../sql/".$dsn['phptype']."/".$langue."/".
      $this->obj.".".$this->objet.".inc\""." ".$this->om_lang("est")." ".$this->om_lang("enregistre") ;
    }else{
      $this->msg=$this->msg."le fichier \"../sql/".$dsn['phptype']."/".
      $this->obj.".".$this->objet.".inc\" est enregistré" ;
    }
}}

// =================================
//              SUPPRIMER
// =================================

function supprimer($val,&$db,$DEBUG){
}

// ===============================
//     CONTROLE INTEGRITE
// ===============================
// Verification de saisie
function verifier(){
$this->correct=True;
}

// recuperation des valeurs du formulaire
function setvalF($val){
}

function enarray($val){
// traitement des tableaux
$temp = explode("\n", $val);
$retour="array(";
for($i=0;$i < sizeof($temp);$i++)
 if($temp[$i]!=""){
  if ($i == sizeof($temp)-1)
    $retour =$retour."\"".$temp[$i]."\")";
  else
    $retour =$retour."\"".substr($temp[$i],0,strlen($temp[$i])-1)."\",";
}else
  $retour=$retour.")";
return $retour;
}

function enrvb($val){
// traitement rvb
$temp = explode("-", $val);
$retour="array(";
for($i=0;$i < sizeof($temp);$i++)
 if($temp[$i]!=""){
  if ($i == sizeof($temp)-1)
    $retour =$retour."\"".$temp[$i]."\")";
  else
    $retour =$retour."\"".$temp[$i]."\",";
}else
  $retour=$retour.")";
return $retour;
}

// ============================================================================
//                             FORMULAIRE
// ============================================================================

function formulaire($validation, $maj,&$db, $postVar,$aff, $DEBUG,$idx){
/*
$enteteTab: libelle d entete du formulaire
$styleform: style des controles du formulaires
$maj      : 0 ajouter / 1 mise à jour / 2 suppression
$db       : connexion base de données
$aff      : appel formulaire
$DEBUG    : 0= normal / 1= debugage
$idx      : valeur de l'id de la table mouvement (pour relancer la requete
*/
$DEBUG=0;
if ($maj==0 )
    echo "<form method=\"POST\" action=\"txform.php?obj=".$aff."&validation=".$validation."&idx=".$idx."&maj=".$maj."\"  name=f1>";
else
    if($maj==1)       // modifier
    echo "<form method=\"POST\" action=\"txform.php?obj=".$aff."&validation=".$validation.
    "&idx=".$idx."&maj=".$maj."\" name=f1>"; // passage de idx
    else              // supprimer
    echo "<form method=\"POST\" action=\"txform.php?obj=".$aff."&validation=".$validation.
    "&ids=1"."&idx=".$idx."&maj=".$maj."\" name=f1>"; // passage de idx
$validation--; // compatibilite anterieure
$enteteTab=""; // compatibilite txform dbform
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
          $this->supprimer($form->val,$db,$DEBUG);
          }else{
          if($maj==1) {
              $this->modifier($form->val,$db,$DEBUG);
              }else{

              $this->ajouter($form->val,$db,$DEBUG) ;
}}}
$form->afficher($this->champs,$validation,$DEBUG,$this->correct);
// Affichage du bouton, message et retour
$this->message();
$this->bouton($maj);
$this->retour();
$form->enpied();
//fin du formulaire
echo "</form>";
} // fin formulaire


function message(){
   echo "<center><table class='formErreur'><tr class='formErreur'><td>".
   $this->msg."</td></tr></table></center>";
}
function retour(){
// =============================================================================
// $premier = page de retour
// $recherche = critere de recherche retour
// =============================================================================
if (!$this->correct){
     echo "<a href=\"txtab.php?obj=".$this->objet."\">";
     echo"<img src='../img/retour.png' align='top' hspace='10' border='0'>";
     echo "</a></center></td> </tr>";
}else{
     echo "<tr><td><br></td></tr><tr><td colspan=2><center><a href=\"txtab.php?obj=".$this->objet."\">";
     echo"<img src='../img/retour.png' align='top'  border='0'>";
     echo "</a></center></td> </tr>";
}}

function bouton($maj){
// =======================================================================
// Bouton Ajouter, modifier, supprimer
// =======================================================================
// * custom *
include("../dyn/var.inc");
//*
if (!$this->correct){
   if ($maj == 2) //supprimer
       $bouton = "Supprimer";
   else
       if ($maj == 1) // modifier   
           $bouton = "Modifier";
       else // ajouter
           $bouton = "Ajouter";
  // echo "<tr><td><br></td></tr><tr><td colspan=2><center><input type='submit' value='".
  //      $bouton." ".ucwords($this->om_lang($this->objet))."' style=".$styleBouton.
  //      " >";
  echo "<tr><td><br></td></tr><tr><td colspan=2><center>";
  echo "<button type='submit' style=".$styleBouton.">".$this->om_lang($bouton)."&nbsp;".ucwords($this->om_lang($this->objet))."</button>";
}}

// *************************************************************
// Parametrage du formulaire (specifique à chaque classe métier)
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



}// fin de classe
?>