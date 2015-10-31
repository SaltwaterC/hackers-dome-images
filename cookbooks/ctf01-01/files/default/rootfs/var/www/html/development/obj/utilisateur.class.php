<?php
/*
$Id: utilisateur.class.php,v 1.3 2008-07-24 14:33:31 jbastide Exp $
*/
require_once ($path_om."formulairedyn.class.php");
require_once ($path_om."dbformdyn.class.php");

class utilisateur extends dbForm {

    var $table="utilisateur";
    var $clePrimaire= "idutilisateur";
    var $typeCle= "N" ;

function utilisateur($id,$db,$debug) {
$this->constructeur($id,$db,$debug);
}

function setvalF($val){
$this->valF['idutilisateur'] = $val['idutilisateur'];
$this->valF['nom'] = $val['nom'];
$this->valF['login'] = $val['login'];
if ($val['pwd']!="*****")
   $this->valF['pwd'] = md5($val['pwd']);
$this->valF['profil'] = $val['profil'];
$this->valF['email'] = $val['email'];
}

function setValFAjout($val){
}

function setId($db){
$this->valF['idutilisateur'] = $db->nextId($this->table);
}

function verifierAjout(){
}

function verifier($val,&$db,$DEBUG){
$this->correct=True;
$imgv="";
$f="&nbsp!&nbsp;&nbsp;&nbsp;&nbsp;";
$imgv="<img src='../img/punaise.png' style='vertical-align:middle' hspace='2' border='0'>";

  if ($this->valF['profil']==""){
     $this->correct=false;
     $this->msg= $this->msg.$imgv.$this->lang("profil")."&nbsp;".$this->lang("obligatoire").$f;
  }
  if ($this->valF['login']==""){
     $this->correct=false;
     $this->msg= $this->msg.$imgv.$this->lang("login")."&nbsp;".$this->lang("obligatoire").$f;
  }
  if ($this->valF['nom']==""){
     $this->correct=false;
      $this->msg= $this->msg.$imgv.$this->lang("nom")."&nbsp;".$this->lang("obligatoire").$f;
  }
  if ($val['pwd']==""){
     $this->correct=false;
      $this->msg= $this->msg.$imgv.$this->lang("pwd")."&nbsp;".$this->lang("obligatoire").$f;
  }
}

function setVal(&$form,$maj){
 if ($maj == 1)
     $form->setVal('pwd', "*****");
 }
 function setValsousformulaire(&$form,$maj,$validation,$idxformulaire,$retourformulaire,$typeformulaire){

 if ($validation==0) {
   if ($maj == 0){
     $form->setVal($retourformulaire, $idxformulaire);
  }else{
     $form->setVal('pwd', "*****");
  }
 }
}

function setType(&$form,$maj) {
if ($maj < 2) {
  $form->setType('profil', 'select');
  $form->setType('idutilisateur', 'hiddenstatic');
}else{
     $form->setType('idutilisateur', 'hiddenstatic');
}}

function setTaille(&$form,$maj){
$form->setTaille('idutilisateur', 8);
$form->setTaille('profil', 2);
$form->setTaille('nom', 30);
$form->setTaille('login', 30);
$form->setTaille('pwd', 50);

}
function setMax(&$form,$maj){
$form->setMax('idutilisateur',8 );
$form->setMax('profil', 2);
$form->setMax('nom', 30);
$form->setMax('login', 30);
$form->setMax('pwd', 100);
//
// ....
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
   echo " la requete ".$sql_profil." est execute<br>";
   $contenu[0][0]="";
   $contenu[1][0]=$this->lang("choisir")."&nbsp;".$this->lang("un")."&nbsp;".$this->lang("profil");
   $k=1;
   while ($row=& $res->fetchRow()){
    $contenu[0][$k]=$row[0];
    $contenu[1][$k]=$row[1];
    $k++;
   }
$form->setSelect("profil",$contenu);
}}}
function setLib(&$form,$maj) {
  $form->setLib('idutilisateur',$this->lang("identifiant")."&nbsp;".$this->lang("utilisateur"));
  $form->setLib('nom',$this->lang("nom"));
  $form->setLib('profil',$this->lang("profil"));
  $form->setLib('login',$this->lang("login"));
  $form->setLib('pwd',$this->lang("pwd"));
  $form->setLib('email',$this->lang("email"));
}

}// fin de classe
?>