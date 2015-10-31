<?php
/*
$Id: candidat.class.php,v 1.3 2008-07-29 14:00:45 jbastide Exp $
*/
include ("../dyn/var.inc");
require_once ($path_om."formulairedyn.class.php");
require_once ($path_om."dbformdyn.class.php");
//
class candidat extends dbForm {

    var $table="candidat";
    var $clePrimaire= "candidat";
    var $typeCle= "N" ;


function candidat($id,$db,$debug) {
$this->constructeur($id,$db,$debug);
} // fin constructeur

function setvalF($val){
$this->valF['candidat']=$val['candidat'];
$this->valF['scrutin']=$val['scrutin'];
$this->valF['nom']=$val['nom'];
}

// pas d initialisation valF pour la cle primaire
function setValFAjout($val){
}
// initialisation valF pour la cle primaire

function setId($db){
// id automatique nextid
$this->valF['candidat'] = $db->nextId($this->table);

}

function verifierAjout(){
}

function verifier($val,&$db,$DEBUG){
$this->correct=True;
$imgv="";
$f="&nbsp!&nbsp;&nbsp;&nbsp;&nbsp;";
$imgv="<img src='../img/punaise.png' align='middle'  border='0'>";
// obligatoire
if ($this->valF['nom']==""){
   $this->correct=false;
   $this->msg= $this->msg.$imgv.$this->lang("nom")."&nbsp;".$this->lang("obligatoire").$f;
}
if ($this->valF['scrutin']==""){
   $this->correct=false;
   $this->msg= $this->msg.$imgv.$this->lang("scrutin")."&nbsp;".$this->lang("obligatoire").$f;
}
}//verifier

function setType(&$form,$maj) {
if ($maj < 2) { //ajouter et modifier
  $form->setType('candidat', 'hiddenstatic');
  $form->setType('scrutin', 'hiddenstatic');
}else{ // supprimer
     $form->setType('candidat', 'hiddenstatic');
     $form->setType('nom', 'hiddenstatic');
}}


}// fin de classe
?>