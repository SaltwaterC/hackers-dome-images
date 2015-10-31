<?php
/*
$Id: courrier.class.php,v 1.3 2008-07-24 14:33:31 jbastide Exp $
*/
require_once ($path_om."formulairedyn.class.php");
require_once ($path_om."dbformdyn.class.php");

class courrier extends dbForm {

    var $table="courrier";
    var $clePrimaire= "courrier";
    var $typeCle= "N" ;

function courrier($id,&$db,$DEBUG) {
$this->constructeur($id,$db,$DEBUG);
}

function setvalF($val){
$this->valF['courrier'] = $val['courrier'];
$this->valF['destinataire'] = $val['destinataire'];
$this->valF['lettretype'] = $val['lettretype'];
if($val['datecourrier']!="")
    $this->valF['datecourrier'] = $this->dateDB($val['datecourrier']);
$this->valF['complement'] = $val['complement'];
}

function setValFAjout($val){
}

function setId($db){
$this->valF['courrier'] = $db->nextId($this->table);
}

function verifierAjout(){
}

function verifier(){
$this->correct=True;
$f="&nbsp!&nbsp;&nbsp;&nbsp;&nbsp;";
$imgv="";
$imgv="<img src='../img/punaise.png' style='vertical-align:middle' hspace='2' border='0'>";
if ($this->valF['destinataire']==""){
   $this->correct=false;
   $this->msg= $this->msg.$imgv.$this->lang("destinataire")."&nbsp;".$this->lang("obligatoire").$f;
}
if ($this->valF['lettretype']==""){
   $this->correct=false;
   $this->msg= $this->msg.$imgv.$this->lang("lettretype")."&nbsp;".$this->lang("obligatoire").$f;
}

}

function setType(&$form,$maj) {
if ($maj < 2) { //ajouter et modifier
  $form->setType('destinataire', 'select');
  $form->setType('datecourrier', 'date');
  $form->setType('lettretype', 'select');
  $form->setType('complement', 'textarea');
  if($maj==0)
      $form->setType('courrier', 'hidden');
  else
      $form->setType('courrier', 'hiddenstatic');
}else{ // supprimer
     $form->setType('courrier', 'hiddenstatic');
}}

function setTaille(&$form,$maj){
$form->setTaille('complement', 70);
$form->setTaille('datecourrier', 12);
}
function setMax(&$form,$maj){
$form->setMax('complement',4 );

}

function setSelect(&$form, $maj,$db,$debug) {
include ("../dyn/connexion.php");
include ("../dyn/var.inc");
include ("../sql/".$dsn['phptype']."/".$this->table.".form.inc");
if($maj<2){
$res = $db->query($sql_destinataire);
if (DB :: isError($res))
     die($res->getMessage().$sql_destinataire);
else{
 if ($debug == 1)
   echo " la requete ".$sql_profil." est executee<br>";
   $contenu[0][0]="";
   $contenu[1][0]=$this->lang("choisir")."&nbsp;".$this->lang("destinataire");
   $k=1;
   while ($row=& $res->fetchRow()){
    $contenu[0][$k]=$row[0];
    $contenu[1][$k]=$row[1];
    $k++;
   }
  $form->setSelect("destinataire",$contenu);
  //
  $contenu=array();
  $dir=getcwd();
  $dir=substr($dir,0,strlen($dir)-4)."/sql/".$dsn['phptype']."/".$langue."/";
  $dossier = opendir($dir);
  $contenu[0][0]="";
  $contenu[1][0]=$this->lang("choisir")."&nbsp".$this->lang("lettretype");
  $k=1;
  while ($entree = readdir($dossier))
  {
    $temp = explode(".",$entree);
    if(!isset($temp[1])) $temp[1]="";
    if($temp[1]=="lettretype"){
           $contenu[0][$k]=$temp[0];
           $contenu[1][$k]=$temp[0];
           $k++;
    }
  }
  closedir($dossier);
$form->setSelect("lettretype",$contenu);
}}
}

function setGroupe(&$form,$maj){
}

function setRegroupe(&$form,$maj){
}

function setLib(&$form,$maj) {
$form->setLib('courrier',$this->lang("courrier"));
$form->setLib('destinataire',$this->lang("destinataire"));
$form->setLib('datecourrier',$this->lang("date")."&nbsp;".$this->lang("courrier"));
$form->setLib('lettretype',$this->lang("lettretype"));
$form->setLib('complement',$this->lang("complement"));
}
//
function setOnchange(&$form,$maj){
 $form->setOnchange("datecourrier","fdate(this)");

?>
<script language="javascript">
function fdate(champ){
if(champ.value.lastIndexOf("/")==-1){
 if (champ.value.substring(0,2)>32){
   champ.value="";
   alert("jour > 32")
   return
 }
 if (champ.value.substring(2,4)>13){
   champ.value="";
   alert("mois > 12")
   return
 }
 if(champ.value.length==6)
   champ.value=champ.value.substring(0,2)+"/"+champ.value.substring(2,4)+"/19"+champ.value.substring(4,6);
 if(champ.value.length==8)
   champ.value=champ.value.substring(0,2)+"/"+champ.value.substring(2,4)+"/"+champ.value.substring(4,8);
 if(champ.name=="datereduction"){
    document.f1.reduction.value='Oui';
    document.f1.taille.value=0.50;
 }
}
} // fin de fonction



</script>
<?php
}
}// fin de classe
?>