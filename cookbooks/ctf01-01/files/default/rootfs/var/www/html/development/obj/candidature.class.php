<script language="javascript">
//051207
function ftime(champ){
if(champ.value.lastIndexOf(":")==-1){
if (champ.value.substring(0,2)>30){
   champ.value="";
   alert("heure > 30")
   return
}
if (champ.value.substring(2,4)>59){
   champ.value="";
   alert("minute > 60")
   return
}
if (champ.value.substring(4,6)>59){
   champ.value="";
   alert("seconde > 60")
   return
}
if(champ.value.length==6)
champ.value=champ.value.substring(0,2)+":"+champ.value.substring(2,4)+":"+champ.value.substring(4,6);
if(champ.value.length==4)
champ.value=champ.value.substring(0,2)+":"+champ.value.substring(2,4)+":00";
}}
</script>
<?php
/*
$Id: candidature.class.php,v 1.15 2008-07-29 14:37:22 jbastide Exp $
*/
include ("../dyn/var.inc");
require_once ($path_om."formulairedyn.class.php");
require_once ($path_om."dbformdyn.class.php");
//
class candidature extends dbForm {

    var $table="candidature";
    var $clePrimaire= "candidature";
    var $typeCle= "N" ;


function candidature($id,$db,$debug) {
$this->constructeur($id,$db,$debug);
} // fin constructeur
function setvalF($val){
$this->valF['candidature']=$val['candidature'];
$this->valF['scrutin']=$val['scrutin'];
$this->valF['agent']=$val['agent'];
$this->valF['poste']=$val['poste'];
$this->valF['periode']=$val['periode'];
$this->valF['bureau']=$val['bureau'];
$this->valF['decision']=$val['decision'];
$this->valF['recuperation']=$val['recuperation'];
$this->valF['note']=$val['note'];
$this->valF['debut']=$val['debut'];
$this->valF['fin']=$val['fin'];

}

// pas d initialisation valF pour la cle primaire
function setValFAjout($val){
}
// initialisation valF pour la cle primaire

function setId($db){
// id automatique nextid
$this->valF['candidature'] = $db->nextId($this->table);

}

function verifierAjout(){
}

function verifier($val,&$db,$DEBUG){
$this->correct=True;
$imgv="";
$f="&nbsp!&nbsp;&nbsp;&nbsp;&nbsp;";
$imgv="<img src='../img/punaise.png' align='middle'  border='0'>";
// zones obligatoires
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
if ($this->valF['debut']!=""){
    $this->valF['debut'] = $this->heureDB($this->valF['debut']);
}
if ($this->valF['fin']!=""){
    $this->valF['fin'] = $this->heureDB($this->valF['fin']);
}
// on ne peut pas affecter des heures si il n y a pas de decision d affectation
if (($this->valF['debut']!="" or $this->valF['fin']!="")
   and $this->valF['decision']!='Oui' ){
       $this->correct=false;
       $this->msg=$this->msg.$imgv.$this->lang("decision_d_affectation_non_prise").$f;
}
// calcul du temps passe et verification des dates saisies
if ($this->valF['debut']!="" and $this->valF['fin']!=""){
   $heureD = explode(":", $this->valF['debut']);
   $heureF = explode(":", $this->valF['fin']);
   $heure = $heureF[0]-$heureD[0];
   $minute = $heureF[1]-$heureD[1];
   $total="00:00";
   if($heure<0){
       $this->correct=false;
       $this->msg=$this->msg.$imgv.$this->lang("heure")."&nbsp;".$this->lang("de")."&nbsp;".$this->lang("fin")."&nbsp;".$this->lang("avant")."&nbsp;".$this->lang("heure")."&nbsp;".$this->lang("de")."&nbsp;".$this->lang("depart").$f;
   }else{
      if($minute<0){
         if($heure>0){
            $heure=$heure-1;
            $minute=$minute+60;
            $total = $heure.":".$minute;
         }else{
            $this->correct=false;
            $this->msg=$this->msg.$imgv.  $this->msg=$this->msg.$imgv.$this->lang("heure")."&nbsp;".$this->lang("de")."&nbsp;".$this->lang("fin")."&nbsp;".$this->lang("avant")."&nbsp;".$this->lang("heure")."&nbsp;".$this->lang("de")."&nbsp;".$this->lang("depart").$f;
         }
      }else{
         $total = $heure.":".$minute;
      }
   $this->msg=$this->msg.$imgv.$this->lang("heures_effectuees")."&nbsp;".$heure.":".$minute.$f;
   }
}
// execption agent centralisation
// - tous bureau
// - posssibilté plusieurs agents ayant le meme poste
include ("../dyn/var.inc");
if($this->valF['poste']!= $agent_centralisation) {
   // affectation obligatoire d un bureau
   if($this->valF['decision']=='Oui'and $this->valF['bureau']=='T'){
      $this->correct=false;
      $this->msg= $this->msg.$imgv.$this->lang("vous_devez_decider_de_l_affectation_d_un_bureau")."&nbsp;".$this->lang("tous_interdit").$f;
   }
   // verification si le poste est occupe par un autre agent
     if($this->valF['decision']=='Oui' and $this->valF['bureau']!='T'){
     switch ($this->valF['periode']){
       case "journee" :
           $sql="select * from candidature where
               scrutin ='".$this->valF['scrutin']."'
               and poste ='".$this->valF['poste']."'
               and bureau ='".$this->valF['bureau']."'
               and decision = 'Oui'";
               if($this->valF['candidature']!='') //maj==1
                   $sql=$sql." and candidature !=".$this->valF['candidature'];
           break;
       case "matin" :
           $sql="select * from candidature where
               scrutin ='".$this->valF['scrutin']."'
               and poste ='".$this->valF['poste']."'
               and bureau ='".$this->valF['bureau']."'
               and (periode ='journee' or periode='matin')
               and decision = 'Oui'";
               if($this->valF['candidature']!='') //maj==1
                   $sql=$sql." and candidature !=".$this->valF['candidature'];
            break;
       case "apres-midi":
           $sql="select * from candidature where
               scrutin ='".$this->valF['scrutin']."'
               and poste ='".$this->valF['poste']."'
               and bureau ='".$this->valF['bureau']."'
               and (periode ='journee' or periode='apres-midi')
               and decision = 'Oui'";
               if($this->valF['candidature']!='') //maj==1
                   $sql=$sql." and candidature !=".$this->valF['candidature'];
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
                $this->correct=false;
                $this->msg = $this->msg.$imgv.$this->lang("il_y_a")."&nbsp;".$nbligne.
                " ".$this->valF['poste']."&nbsp;".$this->lang("pour")."&nbsp;".$this->lang("pour")."&nbsp;".$this->lang("le")."&nbsp;".$this->lang("bureau")."&nbsp;".$this->valF['bureau'].
                " - ".$this->valF['periode'].
                " [ ".$this->valF['scrutin']." ]".$f ;
             }
         }
     }
} //centralisation

// verification si l agent n occupe pas un poste dans la meme periode
// il peut y avoir plusieurs elections en meme temps
// si bureau = Tous => il y aura plusieurs agents pour un meme poste
// si bureau = Tous => il y aura plusieurs agents pour un meme poste
// par contre un meme agent ne peut pas occuper plusieurs postes

if($this->valF['decision']=='Oui'){// and $this->valF['bureau']!='T'){
     // date du scrutin
     $sql="select date_scrutin from scrutin where scrutin = '".
     $this->valF['scrutin']."'";
     $date_scrutin=$db->getOne($sql);
     // test periode
     switch ($this->valF['periode']){
       case "journee" :
           $sql="select * from candidature inner join scrutin
               on scrutin.scrutin=candidature.scrutin
               where date_scrutin ='".$date_scrutin."'
               and agent ='".$this->valF['agent']."'
               and decision = 'Oui'";
               if($this->valF['candidature'])
                   $sql=$sql." and candidature !=".$this->valF['candidature'];
           break;
       case "matin" :
           $sql="select * from candidature inner join scrutin
               on scrutin.scrutin=candidature.scrutin
               where date_scrutin ='".$date_scrutin."'
               and agent ='".$this->valF['agent']."'
               and (periode ='journee' or periode='matin')
               and decision = 'Oui'";
               if($this->valF['candidature'])
                   $sql=$sql." and candidature !=".$this->valF['candidature'];
            break;
       case "apres-midi":
           $sql="select * from candidature inner join scrutin
               on scrutin.scrutin=candidature.scrutin
               where date_scrutin ='".$date_scrutin."'
               and agent ='".$this->valF['agent']."'
               and (periode ='journee' or periode='apres-midi')
               and decision = 'Oui'";
               if($this->valF['candidature'])
                   $sql=$sql." and candidature !=".$this->valF['candidature'];
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
                $this->correct=false;
                $this->msg = $this->msg.$imgv.$this->lang("il_y_a")."&nbsp;".$nbligne.
                $this->lang("poste")."&nbsp;".$this->lang("occupe")."&nbsp;".$this->lang("pour")."&nbsp;".$this->lang("l")."&nbsp;".$this->lang("agent")."&nbsp;".$this->valF['agent'].
                " - ".$this->valF['periode'].
                " [ ".$date_scrutin." ] ".$f;
             }
         }
}




// verification des bureau Cas des cantonales
if($this->valF['bureau']!='T'){
$sql="select canton from scrutin where scrutin = '".
$this->valF['scrutin']."'";

$canton=$db->getOne($sql);
echo $canton."rrr";
if($canton!='T'){
     // selection du canton du bureau
     $sql="select canton from bureau where bureau = '".
     $this->valF['bureau']."'";
     $canton_bureau=$db->getOne($sql);
     if($canton != $canton_bureau){
           $this->correct=false;
           $this->msg = $this->msg.$imgv.$this->lang("le")."&nbsp;".$this->lang("bureau")."&nbsp;".
           $this->valF['bureau'].$this->lang("n_est_pas")."&nbsp;".$this->lang("dans")."&nbsp;".$this->lang("le")."&nbsp;".$this->lang("canton")."&nbsp;".$canton.
           $this->lang("pour")."&nbsp;".$this->lang("le")."&nbsp;".$this->lang("scrutin")."&nbsp;".$this->valF['scrutin']."<br>";
     }

}
}


}//verifier



function setType(&$form,$maj) {
if ($maj < 2) { //ajouter et modifier
  $form->setType('periode', 'select');
  $form->setType('poste', 'select');
  $form->setType('scrutin', 'select');
  $form->setType('bureau', 'select');
  $form->setType('recuperation', 'checkbox');
  $form->setType('decision', 'checkbox');
  $form->setType('candidature', 'hiddenstatic');
  $form->setType('agent', 'hiddenstatic');
  $form->setType('note', 'textarea');
}else{ // supprimer
     $form->setType('candidature', 'hiddenstatic');
     $form->setType('agent', 'hiddenstatic');
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

$form->setGroupe('bureau','D');
$form->setGroupe('recuperation','F');

$form->setGroupe('decision','D');
$form->setGroupe('debut','G');
$form->setGroupe('fin','F');
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

}}
}

function setLib(&$form,$maj) {
$form->setLib('scrutin','');
$form->setLib('periode','');
$form->setLib('poste','');
$form->setLib('bureau','');

}
function setOnchange(&$form, $maj) {
$form->setOnchange("debut","ftime(this)");
$form->setOnchange("fin","ftime(this)");

}

function heureDB($val) {
$this->correct=True;
$imgv="";
$f="&nbsp!&nbsp;&nbsp;&nbsp;&nbsp;";
$imgv="<img src='../img/punaise.png' align='middle'  border='0'>";
// =====================================================================
// controle du champs heure saisi 00 ou 00:00 ou 00:00:00
// =====================================================================
// pb saisie H et h **************
$val = str_replace("H",":",$val);
$val = str_replace("h",":",$val);
// ================================
$heure = explode(":", $val);
for($i=0;$i<sizeof($heure);$i++){
    if(is_numeric($heure[$i])){
        $num=1;
    }else{
        $num=0;
        $i=sizeof($heure);
    }
}
   // sur 2
   if ((sizeof($heure) >= 1 or sizeof($heure) <= 2 ) and $num==1) {
      If (sizeof($heure) ==1 and $heure[0]>=0 and $heure[0] <= 30)
         return $heure[0].":00";
      If (sizeof($heure) ==2 and $heure[0]>=0 and $heure[0] <= 30 and $heure[1]>=0 and $heure[1] <= 59)
            return $heure[0].":".$heure[1];
    //  If (sizeof($heure) ==3 and $heure[0]>=0 and $heure[0] <= 23 and $heure[1]>=0 and $heure[1] <= 59 and $heure[2]>=0 and $heure[2] <= 59)
    //        return $heure[0].":".$heure[1].":".$heure[2];
   }
       $this->msg= $this->msg.$imgv."&nbsp;".$this->lang("l")."&nbsp;".$this->lang("heure")."&nbsp;".$val."&nbsp;".$this->lang("n_est_pas_une_heure").$f;
       $this->correct=false;
}

function setRegroupe(&$form,$maj){
$form->setRegroupe('scrutin','D',$this->lang("scrutin"));
$form->setRegroupe('periode','G','');
$form->setRegroupe('poste','F','');

$form->setRegroupe('bureau','D',$this->lang("choix"));
$form->setRegroupe('recuperation','F','');

$form->setRegroupe('decision','D',$this->lang("decision")."&nbsp;".$this->lang("horaire").$this->lang("pluriel"));
$form->setRegroupe('debut','G','');
$form->setRegroupe('fin','F','');
}

function triggerajouter($id,&$db,$val,$DEBUG) {
 $this->valF['note']="1ère demande : ".$val['poste'].' au bureau '.$val['bureau'].
 ' pendant  '.$val['periode'];
}
}// fin de classe
?>