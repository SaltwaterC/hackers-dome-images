<?php
/*
$Id: om_lettretype.class.php,v 1.2 2008-11-13 08:52:18 fraynaud1 Exp $
*/
require_once ($path_om."formulaire.class.php");
require_once ($path_om."txform.class.php");

class lettretype extends txForm {

   var $objet="lettretype";
   var $obj='';  // nom de fichier



function lettretype($idx,$DEBUG,$maj) {

// fichier a mettre a jour
$this->obj=$idx;

if ($maj == 0){
    // par defaut
    $lettretype['orientation']="";
    $lettretype['format']="";
    $lettretype['logo']="logo.png";
    $lettretype['logoleft']="";
    $lettretype['logotop']="";
    $lettretype['titre']="";
    $lettretype['titreleft']="";
    $lettretype['titretop']="";
    $lettretype['titrelargeur']="";
    $lettretype['titrehauteur']="";
    $lettretype['titrefont']="";
    $lettretype['titreattribut']="";
    $lettretype['titretaille']="";
    $lettretype['titrebordure']="";
    $lettretype['titrealign']="";
    $lettretype['corps']="";
    $lettretype['corpsleft']="";
    $lettretype['corpstop']="";
    $lettretype['corpslargeur']="";
    $lettretype['corpshauteur']="";
    $lettretype['corpsfont']="";
    $lettretype['corpsattribut']="";
    $lettretype['corpstaille']="";
    $lettretype['corpsbordure']="";
    $lettretype['corpsalign']="";
    $lettretype['sql']="";
}else{
     include ("../dyn/var.inc");
     include ("../dyn/connexion.php");
     if (isset($langue)){
        if (file_exists ("../sql/".$dsn['phptype']."/".$langue."/".$this->obj.".lettretype.inc"))
           include ("../sql/".$dsn['phptype']."/".$langue."/".$this->obj.".lettretype.inc");
     }else{
         if (file_exists ("../sql/".$dsn['phptype']."/".$this->obj.".lettretype.inc"))
           include ("../sql/".$dsn['phptype']."/".$this->obj.".lettretype.inc");
     }
}

     $i=0;
     foreach(array_keys($lettretype) as $elem){
                 $this->champs[$i++]=$elem;
     }
     $this->champs[$i++]="image";
     $i=0;
     foreach(array_keys($lettretype) as $elem){
     $this->longueurMax[$i++]=5;
     }
     $this->longueurMax[$i++]=5;
     $i=0;
     foreach($lettretype as $elem){
          $this->val[$i++]=$elem;
     }
     $this->val[$i++]="lettretype.png";
} // fin constructeur

function setvalF($val){
$this->valF="<?php\n//".date(("d/m/Y   G:i:s"))."\n";
$this->valF=$this->valF."\$lettretype['orientation']=\"".$val['orientation']."\";\n";
$this->valF=$this->valF."\$lettretype['format']=\"".$val['format']."\";\n";
$this->valF=$this->valF."\$lettretype['logo']=\"".$val['logo']."\";\n";
$this->valF=$this->valF."\$lettretype['logoleft']=\"".$val['logoleft']."\";\n";
$this->valF=$this->valF."\$lettretype['logotop']=\"".$val['logotop']."\";\n";
$this->valF=$this->valF."\$lettretype['titre']=\"".$val['titre']."\";\n";
$this->valF=$this->valF."\$lettretype['titreleft']=\"".$val['titreleft']."\";\n";
$this->valF=$this->valF."\$lettretype['titretop']=\"".$val['titretop']."\";\n";
$this->valF=$this->valF."\$lettretype['titrelargeur']=\"".$val['titrelargeur']."\";\n";
$this->valF=$this->valF."\$lettretype['titrehauteur']=\"".$val['titrehauteur']."\";\n";
$this->valF=$this->valF."\$lettretype['titrefont']=\"".$val['titrefont']."\";\n";
$this->valF=$this->valF."\$lettretype['titreattribut']=\"".$val['titreattribut']."\";\n";
$this->valF=$this->valF."\$lettretype['titretaille']=\"".$val['titretaille']."\";\n";
$this->valF=$this->valF."\$lettretype['titrebordure']=\"".$val['titrebordure']."\";\n";
$this->valF=$this->valF."\$lettretype['titrealign']=\"".$val['titrealign']."\";\n";
$this->valF=$this->valF."\$lettretype['corps']=\"".$val['corps']."\";\n";
$this->valF=$this->valF."\$lettretype['corpsleft']=\"".$val['corpsleft']."\";\n";
$this->valF=$this->valF."\$lettretype['corpstop']=\"".$val['corpstop']."\";\n";
$this->valF=$this->valF."\$lettretype['corpslargeur']=\"".$val['corpslargeur']."\";\n";
$this->valF=$this->valF."\$lettretype['corpshauteur']=\"".$val['corpshauteur']."\";\n";
$this->valF=$this->valF."\$lettretype['corpsfont']=\"".$val['corpsfont']."\";\n";
$this->valF=$this->valF."\$lettretype['corpsattribut']=\"".$val['corpsattribut']."\";\n";
$this->valF=$this->valF."\$lettretype['corpstaille']=\"".$val['corpstaille']."\";\n";
$this->valF=$this->valF."\$lettretype['corpsbordure']=\"".$val['corpsbordure']."\";\n";
$this->valF=$this->valF."\$lettretype['corpsalign']=\"".$val['corpsalign']."\";\n";
$this->valF=$this->valF."\$lettretype['sql']=\"".$val['sql']."\";\n";
$this->valF=$this->valF."?>\n";

}

function verifier(){
$this->correct=True;
// obligatoire
//if ($this->valF['idx']==""){
//   $this->correct=false;
//   $this->msg= $this->msg."<br>idx obligatoire";
//}
}//verifier




function setType(&$form,$maj) {
  $form->setType('image', 'hidden');
if ($maj < 2) { //ajouter et modifier
  $form->setType('orientation', 'select');
  $form->setType('format', 'select');
  $form->setType('titreattribut', 'select');
  $form->setType('corpsattribut', 'select');
  $form->setType('titrefont', 'select');
  $form->setType('corpsfont', 'select');
  $form->setType('titrealign', 'select');
  $form->setType('corpsalign', 'select');
  $form->setType('titrebordure', 'select');
  $form->setType('corpsbordure', 'select');
  $form->setType('titre', 'textarea');
  $form->setType('corps', 'textarea');
  $form->setType('sql', 'textarea');
  $form->setType('logotop', 'localisation');
  $form->setType('titretop', 'localisation');
  $form->setType('corpstop', 'localisation');
  $form->setType('logo', 'upload');
  if ($maj==1){ //modifier
     $form->setType('idx', 'hidden');
  }
}else{ // supprimer
     $form->setType('idx', 'hiddenstatic');
}}

function setTaille(&$form,$maj){
$form->setTaille('titre', 100);
$form->setTaille('corps', 100);
$form->setTaille('sql', 100);
$form->setTaille('logo', 20);
}
function setMax(&$form,$maj){
$form->setMax('titre', 3);
$form->setMax('corps', 20);
$form->setMax('sql', 10);
$form->setMax('logo', 20);
}

function setSelect(&$form, $maj,$db,$debug) {
//
$contenu=array();
$contenu[0]=array('P','L');
$contenu[1]=array($this->om_lang("portrait"),$this->om_lang("paysage"));
$form->setSelect("orientation",$contenu);
//
$contenu=array();
$contenu[0]=array('A4','A3');
$contenu[1]=array('A4','A3');
$form->setSelect("format",$contenu);
//
$contenu=array();
$contenu[0]=array('','I','B','U','BI','UI');
$contenu[1]=array($this->om_lang("normal"),$this->om_lang("italique"),$this->om_lang("gras"),$this->om_lang("souligne"),$this->om_lang("italique")." ".$this->om_lang("gras"),$this->om_lang("souligne")." ".$this->om_lang("gras"));
$form->setSelect("titreattribut",$contenu);
$form->setSelect("corpsattribut",$contenu);
//
$contenu=array();
$contenu[0]=array('helvetica','times','arial');
$contenu[1]=array('helvetica','times','arial');
$form->setSelect("titrefont",$contenu);
$form->setSelect("corpsfont",$contenu);
//
$contenu=array();
$contenu[0]=array('L','R','J','C');
$contenu[1]=array($this->om_lang("gauche"),$this->om_lang("droite"),$this->om_lang("justifie"),$this->om_lang("centre"));
$form->setSelect("titrealign",$contenu);
$form->setSelect("corpsalign",$contenu);
//
$contenu=array();
$contenu[0]=array('0','1');
$contenu[1]=array($this->om_lang("sans"),$this->om_lang("avec"));
$form->setSelect("titrebordure",$contenu);
$form->setSelect("corpsbordure",$contenu);
// position geographique
$contenu=array();
$contenu[0]=array('image','logoleft');
$form->setSelect("logotop",$contenu);
$contenu=array();
$contenu[0]=array('image','titreleft');
$form->setSelect("titretop",$contenu);
$contenu=array();
$contenu[0]=array('image','corpsleft');
$form->setSelect("corpstop",$contenu);
}

function setOnchange(&$form,$maj){
//$form->setOnchange("libelle_profil","this.value=this.value.toUpperCase()");
$form->setOnchange('titretaille','VerifNum(this)');
?>
<script language="javascript">
function VerifNum(champ){$conte
if (isNaN(champ.value)){
         alert("vous ne devez entrer \ndes chiffres\nuiniquement");
         champ.value=0;
         return;
}
champ.value=champ.value.replace(".","");
}
</script>
<?php
}

function om_lang($texte){
         include ("../dyn/var.inc");
         if(! isset($path_om)) $path_om="";
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

function setRegroupe(&$form,$maj){

$form->setRegroupe('orientation','D',$this->om_lang("parametres")."&nbsp;".$this->om_lang("generaux"));
$form->setRegroupe('format','G','');
$form->setRegroupe('logo','G','');
$form->setRegroupe('logoleft','G','');
$form->setRegroupe('logotop','F','');

$form->setRegroupe('titreleft','D',$this->om_lang("parametres")."&nbsp;".$this->om_lang("titre"));
$form->setRegroupe('titretop','G','');
$form->setRegroupe('titrelargeur','G','');
$form->setRegroupe('titrehauteur','G','');
$form->setRegroupe('titrefont','G','');
$form->setRegroupe('titreattribut','G','');
$form->setRegroupe('titretaille','G','');
$form->setRegroupe('titrebordure','G','');
$form->setRegroupe('titrealign','F','');

$form->setRegroupe('corpsleft','D',$this->om_lang("parametres")."&nbsp;".$this->om_lang("corps"));
$form->setRegroupe('corpstop','G','');
$form->setRegroupe('corpslargeur','G','');
$form->setRegroupe('corpshauteur','G','');
$form->setRegroupe('corpsfont','G','');
$form->setRegroupe('corpsattribut','G','');
$form->setRegroupe('corpstaille','G','');
$form->setRegroupe('corpsbordure','G','');
$form->setRegroupe('corpsalign','F','');
}
function setGroupe(&$form,$maj){

$form->setGroupe('orientation','D');
$form->setGroupe('format','F');
$form->setGroupe('logo','D');
$form->setGroupe('logoleft','G');
$form->setGroupe('logotop','F');

$form->setGroupe('titretop','D');
$form->setGroupe('titreleft','G');
$form->setGroupe('titrelargeur','G');
$form->setGroupe('titrehauteur','F');

$form->setGroupe('titrefont','D');
$form->setGroupe('titreattribut','G');
$form->setGroupe('titretaille','G');
$form->setGroupe('titrebordure','G');
$form->setGroupe('titrealign','F');

$form->setGroupe('corpsleft','D');
$form->setGroupe('corpstop','G');
$form->setGroupe('corpslargeur','G');
$form->setGroupe('corpshauteur','F');

$form->setGroupe('corpsfont','D');
$form->setGroupe('corpsattribut','G');
$form->setGroupe('corpstaille','G');
$form->setGroupe('corpsbordure','G');
$form->setGroupe('corpsalign','F');
}
function setLib(&$form,$maj) {
$form->setLib('logoleft',$this->om_lang('left'));
$form->setLib('logotop',$this->om_lang('top'));
$form->setLib('orientation',$this->om_lang('orientation'));
$form->setLib('format',$this->om_lang('format'));

$form->setLib('titre',$this->om_lang('titre'));

$form->setLib('titreleft',$this->om_lang('left'));
$form->setLib('titretop',$this->om_lang('top'));
$form->setLib('titrelargeur',$this->om_lang('largeur'));
$form->setLib('titrehauteur',$this->om_lang('hauteur'));
$form->setLib('titrefont',$this->om_lang('font'));
$form->setLib('titreattribut',$this->om_lang('mise_en_forme')."&nbsp;".$this->om_lang('du')."&nbsp;".$this->om_lang('texte'));
$form->setLib('titretaille',$this->om_lang('taille'));
$form->setLib('titrebordure',$this->om_lang('bordure'));
$form->setLib('titrealign',$this->om_lang('align'));

$form->setLib('corps',$this->om_lang('corps'));
$form->setLib('corpsleft',$this->om_lang('left'));
$form->setLib('corpstop',$this->om_lang('top'));

$form->setLib('corpslargeur',$this->om_lang('largeur'));
$form->setLib('corpshauteur',$this->om_lang('hauteur'));
$form->setLib('corpsfont','font');
$form->setLib('corpsattribut',$this->om_lang('mise_en_forme')."&nbsp;".$this->om_lang('du')."&nbsp;".$this->om_lang('texte'));
$form->setLib('corpstaille',$this->om_lang('taille'));
$form->setLib('corpsbordure',$this->om_lang('bordure'));
$form->setLib('corpsalign',$this->om_lang('align'));

$form->setLib('sql',$this->om_lang('sql'));
}

function setVal(&$form,$maj,$validation){
if ($validation==0) {
  if ($maj == 0){
    $form->setVal('orientation','P');
    $form->setVal('format','A4');
    $form->setVal('logoleft', 10);
    $form->setVal('logo','logo.png');
    $form->setVal('logotop', 10);
    $form->setVal('titre','Texte du titre');
    $form->setVal('titreleft',109);
    $form->setVal('titretop',16);
    $form->setVal('titrelargeur',0);
    $form->setVal('titrehauteur',10);
    $form->setVal('titrefont','arial');
    $form->setVal('titreattribut','B');
    $form->setVal('titretaille',20);
    $form->setVal('titrebordure',0);
    $form->setVal('titrealign','L');
    $form->setVal('corps','Texte du corps');
    $form->setVal('corpsleft',14);
    $form->setVal('corpstop',66);
    $form->setVal('corpslargeur',110);
    $form->setVal('corpshauteur',5);
    $form->setVal('corpsfont','times');
    $form->setVal('corpsattribut','');
    $form->setVal('corpstaille',10);
    $form->setVal('corpsbordure',0);
    $form->setVal('corpsalign','J');
    $form->setVal('sql',' select ... from  ... where ... = �idx');
}}}

}// fin de classe
?>