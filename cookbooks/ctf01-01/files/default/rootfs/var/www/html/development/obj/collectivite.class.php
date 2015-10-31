<?php
/*
$Id: collectivite.class.php,v 1.3 2008-07-24 14:33:31 jbastide Exp $
*/
require_once ($path_om."formulairedyn.class.php");
require_once ($path_om."dbformdyn.class.php");

class collectivite extends dbForm {

    var $table="collectivite";
    var $clePrimaire= "id";
    var $typeCle= "N" ;

function collectivite($id,$db,$debug)  {
$this->constructeur($id,$db,$debug);
}

function setvalF($val){
    $this->valF['ville'] = $val['ville'];
    $this->valF['logo'] = $val['logo'];
    $this->valF['maire'] = $val['maire'];
}

function verifier(){
    $this->correct=True;
    $imgv="";
    $f="&nbsp!&nbsp;&nbsp;&nbsp;&nbsp;";
    $imgv="<img src='../img/punaise.png' style='vertical-align:middle' hspace='2' border='0'>";
    if ($this->valF['ville']==""){
       $this->correct=false;
       $this->msg= $this->msg.$imgv.$this->lang("ville")."&nbsp;".$this->lang("obligatoire").$f;
    }
    if ($this->valF['logo']==""){
       $this->correct=false;
       $this->msg= $this->msg.$imgv.$this->lang("logo")."&nbsp;".$this->lang("obligatoire").$f;

    }
}

function ajouter($val,$db,$debug){
    echo $this->lang("une_seule")."&nbsp;".$this->lang("collectivite")."&nbsp;".$this->lang("possible");
}

function supprimer($val,$db,$debug){
    echo $this->lang("impossible");
}


function setType(&$form, $maj) {
   $form->setType('id','hiddenstatic');
}

function setTaille(&$form,$maj){
   $form->setTaille('id', 1);
   $form->setTaille('ville', 30);
   $form->setTaille('logo', 40);
   $form->setTaille('maire', 40);
}

function setMax(&$form,$maj){
    $form->setMax('id', 1);
    $form->setMax('ville', 30);
    $form->setMax('logo', 40);
    $form->setMax('maire', 40);
}

function setLib(&$form,$maj) {
    $form->setLib('ville',$this->lang('ville'));
    $form->setLib('logo',$this->lang('logo'));
    $form->setLib('maire',$this->lang('maire'));
}

}
?>