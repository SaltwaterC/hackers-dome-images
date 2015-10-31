<?php
/*
$Id: droit.class.php,v 1.4 2008-10-31 23:02:56 fraynaud1 Exp $
*/
require_once ($path_om."formulairedyn.class.php");
require_once ($path_om."dbformdyn.class.php");

class droit extends dbForm {

    var $table="droit";
    var $clePrimaire= "droit";
    var $typeCle= "A" ;


function droit($id,$db,$debug) {
$this->constructeur($id,$db,$debug);
}

function setvalF($val){
$this->valF['profil'] = $val['profil'];
}

function verifier(){
   $this->correct=True;
    $imgv="";
    $f="&nbsp!&nbsp;&nbsp;&nbsp;&nbsp;";
    $imgv="<img src='../img/punaise.png' style='vertical-align:middle' hspace='2' border='0'>";
    if ($this->valF['profil']==""){
       $this->correct=false;
       $this->msg= $this->msg.$imgv.$this->lang("profil")."&nbsp;".$this->lang("obligatoire").$f;
    }
}

function setType(&$form,$maj) {
if ($maj < 2) {
  $form->setType('profil', 'select');
  if ($maj==1){
     $form->setType('droit', 'hiddenstatic');
  }
}else{
     $form->setType('droit', 'hiddenstatic');
}}

function setTaille(&$form,$maj){
$form->setTaille('profil', 2);
$form->setTaille('droit', 30);
}
function setMax(&$form,$maj){
$form->setMax('profil', 2);
$form->setMax('droit', 30);
}
function setSelect(&$form, $maj,$db,$debug) {
include ("../dyn/connexion.php");
include ("../sql/".$dsn['phptype']."/".$this->table.".form.inc");
if($maj<2){
$res = $db->query($sql_profil);
if (DB :: isError($res))
     die($res->getMessage().$sql_profil);
else{
 if ($debug == 1)
   echo " la requete ".$sql_profil." est executee<br>";
   $contenu[0][0]="";
   $contenu[1][0]=$this->lang("choisir")."&nbsp;".$this->lang("profil");
   $k=1;
   while ($row=& $res->fetchRow()){
    $contenu[0][$k]=$row[0];
    $contenu[1][$k]=$row[1];
    $k++;
   }
$form->setSelect("profil",$contenu);
}
} }

}// fin de classe
?>