<?php
/*
$Id: affectation.class.php,v 1.10 2008-07-29 14:00:45 jbastide Exp $
*/
include ("../dyn/var.inc");
require_once ($path_om."formulairedyn.class.php");
require_once ($path_om."dbformdyn.class.php");
//
class affectation extends dbForm {

    var $table="affectation";
    var $clePrimaire= "affectation";
    var $typeCle= "N" ;


function affectation($id,$db,$debug) {
$this->constructeur($id,$db,$debug);
} // fin constructeur


// pas d initialisation valF pour la cle primaire
function setValFAjout($val){
}
// initialisation valF pour la cle primaire

function setId($db){
// id automatique nextid
$this->valF['affectation'] = $db->nextId($this->table);
}

function verifierAjout(){
}

function verifier($val,&$db,$DEBUG){
$this->correct=True;
$imgv="";
$f="&nbsp!&nbsp;&nbsp;&nbsp;&nbsp;";
$imgv="<img src='../img/punaise.png' align='middle'  border='0'>";
// obligatoire
if ($this->valF['poste']==""){
   $this->correct=false;
   $this->msg= $this->msg.$imgv.$this->lang("poste")."&nbsp;".$this->lang("obligatoire").$f;
}
if ($this->valF['periode']==""){
   $this->correct=false;
   $this->msg= $this->msg.$imgv.$this->lang("periode")."&nbsp;".$this->lang("obligatoire").$f;
}
if ($this->valF['scrutin']==""){
   $this->correct=false;
   $this->msg= $this->msg.$imgv.$this->lang("scrutin")."&nbsp;".$this->lang("obligatoire").$f;
}

// affectation obligatoire d un bureau
if($this->valF['decision']=='Oui'and $this->valF['bureau']=='T'
and $this->valF['poste']!='DELEGUE TITULAIRE' and $this->valF['poste']!='DELEGUE SUPPLEANT'){
   $this->correct=false;
   $this->msg= $this->msg.$imgv.$this->lang("vous_devez_decider_de_l_affectation_d_un_bureau")."&nbsp;".$this->lang("tous_interdit").$f;
}

// verification si le poste est occupe par un autre elu / non bloquant
if($this->valF['decision']=='Oui' and $this->valF['bureau']!='T'){
switch ($this->valF['periode']){
  case "journee" :
      $sql="select * from affectation where
          scrutin ='".$this->valF['scrutin']."'
          and poste ='".$this->valF['poste']."'
          and bureau ='".$this->valF['bureau']."'
          and decision = 'Oui'";
          if($this->valF['affectation']!='') //maj==1
              $sql=$sql." and affectation !=".$this->valF['affectation'];
      break;
  case "matin" :
      $sql="select * from affectation where
          scrutin ='".$this->valF['scrutin']."'
          and poste ='".$this->valF['poste']."'
          and bureau ='".$this->valF['bureau']."'
          and (periode ='journee' or periode='matin')
          and decision = 'Oui'";
          if($this->valF['affectation']!='') //maj==1
              $sql=$sql." and affectation !=".$this->valF['affectation'];
       break;
  case "apres-midi":
      $sql="select * from affectation where
          scrutin ='".$this->valF['scrutin']."'
          and poste ='".$this->valF['poste']."'
          and bureau ='".$this->valF['bureau']."'
          and (periode ='journee' or periode='apres-midi')
          and decision = 'Oui'";
          if($this->valF['affectation']!='') //maj==1
              $sql=$sql." and affectation !=".$this->valF['affectation'];
      break;
  default:
}
    $res = $db->query($sql);
    if($DEBUG==1) echo $sql;
    if (DB :: isError($res))
       die($res->getMessage(). " => Echec  ".$sql);
    else{
        $nbligne=$res->numrows();
        if ($nbligne>0){
           //$this->correct=false;
           $this->msg = $this->msg.$imgv."&nbsp;".$this->lang("il_y_a")."&nbsp;".$nbligne.
           " ".$this->valF['poste']."&nbsp;".$this->lang("pour")."&nbsp;".$this->lang("le")."&nbsp;".$this->lang("bureau")."&nbsp;".$this->valF['bureau'].
           " - ".$this->valF['periode'].
           " [ ".$this->valF['scrutin']." ]".$f;
        }
    }
}
// verification si l agent n occupe pas un poste dans la meme periode
// il peut y avoir plusieurs elections en meme temps
// non bloquant
if($this->valF['decision']=='Oui' and $this->valF['bureau']!='T'){
// date du scrutin
$sql="select date_scrutin from scrutin where scrutin = '".
$this->valF['scrutin']."'";
$date_scrutin=$db->getOne($sql);
// test periode
switch ($this->valF['periode']){
  case "journee" :
      $sql="select * from affectation inner join scrutin
          on scrutin.scrutin=affectation.scrutin
          where date_scrutin ='".$date_scrutin."'
          and elu ='".$this->valF['elu']."'
          and decision = 'Oui'";
          if($this->valF['affectation'])
              $sql=$sql." and affectation !=".$this->valF['affectation'];
      break;
  case "matin" :
      $sql="select * from affectation inner join scrutin
          on scrutin.scrutin=affectation.scrutin
          where date_scrutin ='".$date_scrutin."'
          and elu ='".$this->valF['elu']."'
          and (periode ='journee' or periode='matin')
          and decision = 'Oui'";
          if($this->valF['affectation'])
              $sql=$sql." and affectation !=".$this->valF['affectation'];
       break;
  case "apres-midi":
      $sql="select * from affectation inner join scrutin
          on scrutin.scrutin=affectation.scrutin
          where date_scrutin ='".$date_scrutin."'
          and elu ='".$this->valF['elu']."'
          and (periode ='journee' or periode='apres-midi')
          and decision = 'Oui'";
          if($this->valF['affectation'])
              $sql=$sql." and affectation !=".$this->valF['affectation'];
      break;
  default:
}
    $res = $db->query($sql);
    if($DEBUG==1) echo $sql;
    if (DB :: isError($res))
       die($res->getMessage(). " => Echec  ".$sql);
    else{
        $nbligne=$res->numrows();
        if ($nbligne>0){
           //$this->correct=false;
           $this->msg = $this->msg.$imgv."&nbsp;".$this->lang("il_y_a")."&nbsp;".$nbligne.
           "&nbsp;".$this->lang("poste")."&nbsp;".$this->lang("occupe")."&nbsp;".$this->lang("pour")."&nbsp;".$this->lang("elu")."&nbsp;".$this->valF['elu'].
           " - ".$this->valF['periode'].
           " [ ".$date_scrutin." ] ".$f;
        }
    }
}
// verification des bureaux Cas des cantonales
if($this->valF['bureau']!='T'){
$sql="select canton from scrutin where scrutin = '".
$this->valF['scrutin']."'";
$canton=$db->getOne($sql);
if($canton!='T'){
     // selection du canton du bureau
     $sql="select canton from bureau where bureau = '".
     $this->valF['bureau']."'";
     $canton_bureau=$db->getOne($sql);
     if($canton != $canton_bureau){
           $this->correct=false;
           $this->msg = $this->msg.$imgv.$this->lang("le")."&nbsp;".$this->lang("bureau")."&nbsp;".
           $this->valF['bureau'].$this->lang("n_est_pas")."&nbsp;".$this->lang("dans")."&nbsp;".$this->lang("le")."&nbsp;".$this->lang("canton")."&nbsp;".$canton.
           $this->lang("pour")."&nbsp;".$this->lang("le")."&nbsp;".$this->lang("scrtin")."&nbsp;".$this->valF['scrutin']."&nbsp;".$f;
     }

}
}

}//verifier



function setType(&$form,$maj) {
if ($maj < 2) { //ajouter et modifier
  $form->setType('periode', 'select');
  $form->setType('poste', 'select');
  if(isset($_SESSION['scrutin']))
      $form->setType('scrutin', 'hiddenstatic');
  else
      $form->setType('scrutin', 'select');
  $form->setType('bureau', 'select');
  $form->setType('decision', 'checkbox');
  $form->setType('affectation', 'hiddenstatic');
  $form->setType('elu', 'hiddenstatic');
  $form->setType('note', 'textarea');
  $form->setType('candidat', 'select');
}else{ // supprimer
     $form->setType('affectation', 'hiddenstatic');
     $form->setType('elu', 'hiddenstatic');
}}

function setSelect(&$form, $maj,$db,$debug) {
include ("../dyn/connexion.php");
include ("../sql/".$dsn['phptype']."/".$this->table.".form.inc");
if($maj<2){
// scrutin
$res = $db->query($sql_scrutin);
if (DB :: isError($res))
     die($res->getMessage().$sql_scrutin);
else{
 if ($debug == 1)
   echo " la requete ".$sql_scrutin." est exécutée<br>";
   $contenu[0][0]="";
   $contenu[1][0]=$this->lang("choisir")."&nbsp;".$this->lang("un")."&nbsp;".$this->lang("scrutin");
   $k=1;
   while ($row=& $res->fetchRow()){
    $contenu[0][$k]=$row[0];
    $contenu[1][$k]=$row[1];
    $k++;
   }
$form->setSelect("scrutin",$contenu);
}
// bureau
$contenu=array();
$res = $db->query($sql_bureau);
if (DB :: isError($res))
     die($res->getMessage().$sql_bureau);
else{
 if ($debug == 1)
   echo " la requete ".$sql_bureau." est exécutée<br>";
   $contenu[0][0]="T";
   $contenu[1][0]=$this->lang("tous")."&nbsp;".$this->lang("les")."&nbsp;".$this->lang("bureaux");
   $k=1;
   while ($row=& $res->fetchRow()){
    $contenu[0][$k]=$row[0];
    $contenu[1][$k]=$row[1];
    $k++;
   }
$form->setSelect("bureau",$contenu);
}
// poste
$contenu=array();
$res = $db->query($sql_poste);
if (DB :: isError($res))
     die($res->getMessage().$sql_poste);
else{
 if ($debug == 1)
   echo " la requete ".$sql_poste." est exécutée<br>";
   $contenu[0][0]="";
   $contenu[1][0]=$this->lang("choisir")."&nbsp;".$this->lang("un")."&nbsp;".$this->lang("poste");
   $k=1;
   while ($row=& $res->fetchRow()){
    $contenu[0][$k]=$row[0];
    $contenu[1][$k]=$row[1];
    $k++;
   }
$form->setSelect("poste",$contenu);
}
// periode
$contenu=array();
$res = $db->query($sql_periode);
if (DB :: isError($res))
     die($res->getMessage().$sql_periode);
else{
 if ($debug == 1)
   echo " la requete ".$sql_periode." est exécutée<br>";
   $contenu[0][0]="";
   $contenu[1][0]=$this->lang("choisir")."&nbsp;".$this->lang("une")."&nbsp;".$this->lang("periode");
   $k=1;
   while ($row=& $res->fetchRow()){
    $contenu[0][$k]=$row[0];
    $contenu[1][$k]=$row[1];
    $k++;
   }
$form->setSelect("periode",$contenu);
}
// candidat
$contenu=array();
$res = $db->query($sql_candidat);
if (DB :: isError($res))
     die($res->getMessage().$sql_candidat);
else{
 if ($debug == 1)
   echo " la requete ".$sql_candidat." est exécutée<br>";
   $contenu[0][0]="";
   $contenu[1][0]=$this->lang("choisir")."&nbsp;".$this->lang("un")."&nbsp;".$this->lang("candidat");
   $k=1;
   while ($row=& $res->fetchRow()){
    $contenu[0][$k]=$row[0];
    $contenu[1][$k]=$row[1];
    $k++;
   }
$form->setSelect("candidat",$contenu);
}
}}
function setTaille(&$form,$maj){
$form->setTaille('note', 80);
}
function setMax(&$form,$maj){
$form->setMax('note', 5);
}
function setGroupe(&$form,$maj){
$form->setGroupe('scrutin','D');
$form->setGroupe('periode','G');
$form->setGroupe('poste','F');


}
function setValsousformulaire(&$form,$maj,$validation,$idxformulaire,$retourformulaire,$typeformulaire,&$db,$DEBUG=null){

if ($validation==0) {
  if ($maj == 0){
    if(isset($_SESSION['scrutin']))
        $scrutin=$_SESSION['scrutin'];
    else
        $scrutin="";
    $form->setVal($retourformulaire, $idxformulaire);
    $form->setVal("scrutin", $scrutin);
    $form->setVal("periode", "journee");
}}
}
function setLib(&$form,$maj) {

$form->setLib('scrutin','');
$form->setLib('periode','');
$form->setLib('poste','');
$form->setLib('bureau','');

}
function setRegroupe(&$form,$maj){
$form->setRegroupe('scrutin','D',$this->lang("scrutin"));
$form->setRegroupe('periode','G','');
$form->setRegroupe('poste','F','');
}
}// fin de classe
?>