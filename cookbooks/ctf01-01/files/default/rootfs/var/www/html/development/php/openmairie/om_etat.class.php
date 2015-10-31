<?php
/*
$Id: om_etat.class.php,v 1.1 2008-07-24 13:18:52 jbastide Exp $
*/
require_once ($path_om."formulaire.class.php");
require_once ($path_om."txform.class.php");

class etat extends txForm {

   var $objet="etat";
   var $obj='';



function etat($idx,$DEBUG,$maj) {
//
$this->obj=$idx;
if ($maj == 0){
    // par defaut
    $etat['orientation']="";
    $etat['format']="";
    $etat['footerfont']="";
    $etat['footerattribut']="";
    $etat['footertaille']="";
    $etat['logo']="";
    $etat['logoleft']="";
    $etat['logotop']="";
    $etat['titre']="";
    $etat['titreleft']="";
    $etat['titretop']="";
    $etat['titrelargeur']="";
    $etat['titrehauteur']="";
    $etat['titrefont']="";
    $etat['titreattribut']="";
    $etat['titretaille']="";
    $etat['titrebordure']="";
    $etat['titrealign']="";
    $etat['corps']="";
    $etat['corpsleft']="";
    $etat['corpstop']="";
    $etat['corpslargeur']="";
    $etat['corpshauteur']="";
    $etat['corpsfont']="";
    $etat['corpsattribut']="";
    $etat['corpstaille']="";
    $etat['corpsbordure']="";
    $etat['corpsalign']="";
    $etat['sql']="";
    $etat['sousetat']="";
    $etat['se_font']="";
    $etat['se_margeleft']="";
    $etat['se_margetop']="";
    $etat['se_margeright']="";
    $etat['se_couleurtexte']="";
}else{
     include ("../dyn/var.inc");
     include ("../dyn/connexion.php");
     if (isset($langue)){
        if (file_exists ("../sql/".$dsn['phptype']."/".$langue."/".$this->obj.".etat.inc"))
           include ("../sql/".$dsn['phptype']."/".$langue."/".$this->obj.".etat.inc");
     }else{
         if (file_exists ("../sql/".$dsn['phptype']."/".$this->obj.".etat.inc"))
           include ("../sql/".$dsn['phptype']."/".$this->obj.".etat.inc");
     }
}

     $i=0;
     $position=0;
     foreach(array_keys($etat) as $elem){
                 if ($elem=="sousetat"){
                    $this->champs[$i++]="listesousetat";
                    $position=$i-1;
                 }
                 $this->champs[$i++]=$elem;

     }
     $this->champs[$i++]="image";

     $i=0;
     foreach(array_keys($etat) as $elem){
     $this->longueurMax[$i++]=5;
     }
     $this->longueurMax[$i++]=5;  //liste sous etat
     $this->longueurMax[$i++]=5;  //image
     $i=0;

     foreach($etat as $elem){
             // liste sousetat
             if ($position==$i) {
                    $this->val[$i]="";
                    $i++;
             }
             if(is_array($elem)){
                 $this->val[$i]="";
                 foreach($elem as $elem1){
                  $this->val[$i]=$this->val[$i].$elem1."\n";
                 }
                 $this->val[$i]= substr($this->val[$i],0,strlen($this->val[$i])-1);
                 $i++;
             }else
                $this->val[$i++]=$elem;
     }
     // affichage pour position elements
     $this->val[$i++]="lettretype.png";
} // fin constructeur

function setvalF($val){
$this->valF="<?php\n//".date(("d/m/Y   G:i:s"))."\n";
//$this->valF=$this->valF."\$etat['idx']=\"".$val['idx']."\";\n";
$this->valF=$this->valF."\$etat['orientation']=\"".$val['orientation']."\";\n";
$this->valF=$this->valF."\$etat['format']=\"".$val['format']."\";\n";

$this->valF=$this->valF."\$etat['footerfont']=\"".$val['footerfont']."\";\n";
$this->valF=$this->valF."\$etat['footerattribut']=\"".$val['footerattribut']."\";\n";
$this->valF=$this->valF."\$etat['footertaille']=\"".$val['footertaille']."\";\n";

$this->valF=$this->valF."\$etat['logo']=\"".$val['logo']."\";\n";
$this->valF=$this->valF."\$etat['logoleft']=\"".$val['logoleft']."\";\n";
$this->valF=$this->valF."\$etat['logotop']=\"".$val['logotop']."\";\n";

$this->valF=$this->valF."\$etat['titre']=\"".$val['titre']."\";\n";
$this->valF=$this->valF."\$etat['titreleft']=\"".$val['titreleft']."\";\n";
$this->valF=$this->valF."\$etat['titretop']=\"".$val['titretop']."\";\n";
$this->valF=$this->valF."\$etat['titrelargeur']=\"".$val['titrelargeur']."\";\n";
$this->valF=$this->valF."\$etat['titrehauteur']=\"".$val['titrehauteur']."\";\n";
$this->valF=$this->valF."\$etat['titrefont']=\"".$val['titrefont']."\";\n";
$this->valF=$this->valF."\$etat['titreattribut']=\"".$val['titreattribut']."\";\n";
$this->valF=$this->valF."\$etat['titretaille']=\"".$val['titretaille']."\";\n";
$this->valF=$this->valF."\$etat['titrebordure']=\"".$val['titrebordure']."\";\n";
$this->valF=$this->valF."\$etat['titrealign']=\"".$val['titrealign']."\";\n";

$this->valF=$this->valF."\$etat['corps']=\"".$val['corps']."\";\n";
$this->valF=$this->valF."\$etat['corpsleft']=\"".$val['corpsleft']."\";\n";
$this->valF=$this->valF."\$etat['corpstop']=\"".$val['corpstop']."\";\n";
$this->valF=$this->valF."\$etat['corpslargeur']=\"".$val['corpslargeur']."\";\n";
$this->valF=$this->valF."\$etat['corpshauteur']=\"".$val['corpshauteur']."\";\n";
$this->valF=$this->valF."\$etat['corpsfont']=\"".$val['corpsfont']."\";\n";
$this->valF=$this->valF."\$etat['corpsattribut']=\"".$val['corpsattribut']."\";\n";
$this->valF=$this->valF."\$etat['corpstaille']=\"".$val['corpstaille']."\";\n";
$this->valF=$this->valF."\$etat['corpsbordure']=\"".$val['corpsbordure']."\";\n";
$this->valF=$this->valF."\$etat['corpsalign']=\"".$val['corpsalign']."\";\n";
$this->valF=$this->valF."\$etat['sql']=\"".$val['sql']."\";\n";
//
$this->valF=$this->valF."\$etat['sousetat']=".
            $this->enarray($val['sousetat']).";\n";

$this->valF=$this->valF."\$etat['se_font']=\"".$val['se_font']."\";\n";
$this->valF=$this->valF."\$etat['se_margeleft']=\"".$val['se_margeleft']."\";\n";
$this->valF=$this->valF."\$etat['se_margetop']=\"".$val['se_margetop']."\";\n";
$this->valF=$this->valF."\$etat['se_margeright']=\"".$val['se_margeright']."\";\n";
//
$this->valF=$this->valF."\$etat['se_couleurtexte']=".
            $this->enrvb($val['se_couleurtexte']).";\n";




$this->valF=$this->valF."?>\n";

}



function verifier(){
$this->correct=True;

}//verifier




function setType(&$form,$maj) {
  $form->setType('image', 'hidden');
if ($maj < 2) { //ajouter et modifier
  $form->setType('orientation', 'select');
  $form->setType('format', 'select');
  $form->setType('logo', 'upload');
  $form->setType('titreattribut', 'select');
  $form->setType('corpsattribut', 'select');
  $form->setType('footerattribut', 'select');
  $form->setType('titrefont', 'select');
  $form->setType('corpsfont', 'select');
  $form->setType('footerfont', 'select');
  $form->setType('se_font', 'select');
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
  $form->setType('listesousetat', 'select');
  $form->setType('sousetat', 'textareamulti');
  $form->setType('se_couleurtexte', 'rvb');
  if ($maj==1){ //modifier
     $form->setType('idx', 'hidden');
  }
}else{ // supprimer
     $form->setType('idx', 'hiddenstatic');
}}

function setTaille(&$form,$maj){
$form->setTaille('logo', 20);
$form->setTaille('titre', 100);
$form->setTaille('corps', 100);
$form->setTaille('sql', 100);
$form->setTaille('sousetat', 20);
$form->setTaille('se_couleurtexte', 10);
}
function setMax(&$form,$maj){
$form->setMax('logo', 20);
$form->setMax('titre', 3);
$form->setMax('corps', 20);
$form->setMax('sql', 10);
$form->setMax('sousetat', 5);
$form->setMax('se_couleurtexte', 11);
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
$form->setSelect("footerattribut",$contenu);
//
$contenu=array();
$contenu[0]=array('helvetica','times','arial');
$contenu[1]=array('helvetica','times','arial');
$form->setSelect("titrefont",$contenu);
$form->setSelect("corpsfont",$contenu);
$form->setSelect("footerfont",$contenu);
$form->setSelect("se_font",$contenu);
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
//------------------------
include ("../dyn/var.inc");
include ("../dyn/connexion.php");
// sousetat => liste
$contenu=array();
//*
     if (isset($langue)){
        if (file_exists ("../sql/".$dsn['phptype']."/".$langue."/".$this->obj.".etat.inc"))
           include ("../sql/".$dsn['phptype']."/".$langue."/".$this->obj.".etat.inc");
     }else{
         if (file_exists ("../sql/".$dsn['phptype']."/".$this->obj.".etat.inc"))
           include ("../sql/".$dsn['phptype']."/".$this->obj.".etat.inc");
     }
//*

$dir=getcwd();
if (isset($langue)){
    if (file_exists ("../sql/".$dsn['phptype']."/".$langue));
      $dir=substr($dir,0,strlen($dir)-4)."/sql/".$dsn['phptype']."/".$langue."/";
}else{
     $dir=substr($dir,0,strlen($dir)-4)."/sql/".$dsn['phptype']."/";
}
$dossier = opendir($dir);
//
$contenu[0][0]="";
$contenu[1][0]=$this->om_lang("choisir")."&nbsp;".$this->om_lang("un")."&nbsp;".$this->om_lang("sous_etat");
$k=1;
  while ($entree = readdir($dossier))
  {
    if ($entree == "." || $entree ==".."){
       continue;
    }else{
    $temp = explode(".",$entree);
    if(!isset($temp[1])) $temp[1]="";
    if($temp[1]=="sousetat"){
       $contenu[0][$k]=$temp[0];
       $contenu[1][$k]=$temp[0];
    $k++; 
    }
  $form->setSelect("listesousetat",$contenu);
}}

// parametre textareamulti
$contenu=array();
$contenu[0] ="listesousetat";
$form->setSelect("sousetat",$contenu);

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
$form->setRegroupe('footerfont','G','');
$form->setRegroupe('footerattribut','G','');
$form->setRegroupe('footertaille','G','');
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

$form->setRegroupe('se_font','D',$this->om_lang("sous_etat")."&nbsp;:&nbsp;".$this->om_lang("font")."&nbsp/&nbsp".$this->om_lang("marges")."&nbsp;/&nbsp;".$this->om_lang("couleur")."&nbsp;".$this->om_lang("texte"));
$form->setRegroupe('se_margeleft','G','');
$form->setRegroupe('se_margetop','G','');
$form->setRegroupe('se_margeright','G','');
$form->setRegroupe('se_couleurtexte','F','');
}
function setGroupe(&$form,$maj){

$form->setGroupe('orientation','D');
$form->setGroupe('format','F');

$form->setGroupe('footerfont','D');
$form->setGroupe('footerattribut','G');
$form->setGroupe('footertaille','F');

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

$form->setGroupe('listesousetat','D');
$form->setGroupe('sousetat','F');

$form->setGroupe('se_font','D');
$form->setGroupe('se_margeleft','G');
$form->setGroupe('se_margetop','G');
$form->setGroupe('se_margeright','G');
$form->setGroupe('se_couleutexte','F');
}
function setLib(&$form,$maj) {

$form->setLib('footerattribut',$this->om_lang('mise_en_forme')."&nbsp;".$this->om_lang('du')."&nbsp;".$this->om_lang('texte'));
$form->setLib('titreleft',$this->om_lang('left'));
$form->setLib('titretop',$this->om_lang('top'));
$form->setLib('titrelargeur',$this->om_lang('largeur'));
$form->setLib('titrehauteur',$this->om_lang('hauteur'));
$form->setLib('titrefont',$this->om_lang('font'));
$form->setLib('titreattribut',$this->om_lang('mise_en_forme')."&nbsp;".$this->om_lang('du')."&nbsp;".$this->om_lang('texte'));
$form->setLib('titretaille',$this->om_lang('taille'));
$form->setLib('titrebordure',$this->om_lang('bordure'));
$form->setLib('titrealign','');

$form->setLib('titre',$this->om_lang('titre'));

$form->setLib('corps',$this->om_lang('corps'));
$form->setLib('corpsleft',$this->om_lang('left'));
$form->setLib('corpstop',$this->om_lang('top'));

$form->setLib('corpslargeur',$this->om_lang('largeur'));
$form->setLib('corpshauteur',$this->om_lang('hauteur'));
$form->setLib('corpsfont',$this->om_lang('font'));
$form->setLib('corpsattribut',$this->om_lang('mise_en_forme')."&nbsp;".$this->om_lang('du')."&nbsp;".$this->om_lang('texte'));
$form->setLib('corpstaille',$this->om_lang('taille'));
$form->setLib('corpsbordure',$this->om_lang('bordure'));
$form->setLib('corpsalign','');

$form->setLib('listesousetat',$this->om_lang('sous_etat'));
$form->setLib('sousetat','');
$form->setLib('se_font',$this->om_lang('font'));
$form->setLib('se_margeleft',$this->om_lang('marges')."&nbsp;".$this->om_lang('left'));
$form->setLib('se_margetop',$this->om_lang('marges')."&nbsp;".$this->om_lang('haute'));
$form->setLib('se_margeright',$this->om_lang('marges')."&nbsp;".$this->om_lang('droite'));
$form->setLib('se_couleurtexte',$this->om_lang('couleur'));
}

function setVal(&$form,$maj,$validation){
if ($validation==0) {
  if ($maj == 0){
    $form->setVal('orientation','P');
    $form->setVal('format','A4');
    $form->setVal('footerfont','helvetica');
    $form->setVal('footerattribut','I');
    $form->setVal('footertaille',8);
    $form->setVal('logo','logopdf.png');
    $form->setVal('logoleft', 10);
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
    $form->setVal('sql',' select ... from  ... where ... = £idx');
    $form->setVal('sousetat','');
    $form->setVal('se_font','helvetica');
    $form->setVal('se_margeleft',8);
    $form->setVal('se_margetop',5);
    $form->setVal('se_margeright',5);
    $form->setVal('se_couleurtexte','0-0-0');
}}}

}// fin de classe
?>  