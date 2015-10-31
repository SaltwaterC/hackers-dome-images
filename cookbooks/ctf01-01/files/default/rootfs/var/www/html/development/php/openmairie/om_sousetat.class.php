<?php
/*
$Id: om_sousetat.class.php,v 1.1 2008-07-24 13:18:52 jbastide Exp $
*/
require_once ($path_om."formulaire.class.php");
require_once ($path_om."txform.class.php");

class sousetat extends txForm {

   var $objet="sousetat";
   var $obj='';



function sousetat($idx,$DEBUG,$maj) {
// fichier
$this->obj=$idx;

if ($maj == 0){
    // par defaut
$sousetat['titre']="";
$sousetat['titrehauteur']="";
$sousetat['titrefont']="";
$sousetat['titreattribut']="";
$sousetat['titretaille']="";
$sousetat['titrebordure']="";
$sousetat['titrealign']="";
$sousetat['titrefond']="";
$sousetat['titrefondcouleur']="";
$sousetat['titretextecouleur']="";
$sousetat['intervalle_debut']="";
$sousetat['intervalle_fin']="";
$sousetat['entete_flag']="";
$sousetat['entete_orientation']=0;
$sousetat['entete_fond']="";
$sousetat['entete_hauteur']="";
$sousetat['entetecolone_bordure']="";
$sousetat['entetecolone_align']="";
$sousetat['entete_fondcouleur']="";
$sousetat['entete_textecouleur']="";
$sousetat['tableau_largeur']="";
$sousetat['tableau_bordure']="";
$sousetat['tableau_fontaille']="";
$sousetat['bordure_couleur']="";
$sousetat['se_fond1']="";
$sousetat['se_fond2']="";
$sousetat['cellule_fond']="";
$sousetat['cellule_hauteur']="";
$sousetat['cellule_largeur']="";
$sousetat['cellule_bordure_un']="";
$sousetat['cellule_bordure']="";
$sousetat['cellule_align']="";
$sousetat['cellule_fond_total']="";
$sousetat['cellule_fontaille_total']="";
$sousetat['cellule_hauteur_total']="";
$sousetat['cellule_fondcouleur_total']="";
$sousetat['cellule_bordure_total']="";
$sousetat['cellule_align_total']="";
$sousetat['cellule_fond_moyenne']="1";
$sousetat['cellule_fontaille_moyenne']="";
$sousetat['cellule_hauteur_moyenne']="";
$sousetat['cellule_fondcouleur_moyenne']="";
$sousetat['cellule_bordure_moyenne']="";
$sousetat['cellule_align_moyenne']="";
$sousetat['cellule_fond_nbr']="";
$sousetat['cellule_fontaille_nbr']="";
$sousetat['cellule_hauteur_nbr']="";
$sousetat['cellule_fondcouleur_nbr']="";
$sousetat['cellule_bordure_nbr']="";
$sousetat['cellule_align_nbr']="";
$sousetat['cellule_numerique']="";
$sousetat['cellule_total']="";
$sousetat['cellule_moyenne']="";
$sousetat['cellule_compteur']="";
$sousetat['sql']="";
}else{
     include ("../dyn/var.inc");
     include ("../dyn/connexion.php");
     if (isset($langue)){
        if (file_exists ("../sql/".$dsn['phptype']."/".$langue."/".$this->obj.".sousetat.inc"))
           include ("../sql/".$dsn['phptype']."/".$langue."/".$this->obj.".sousetat.inc");
     }else{
         if (file_exists ("../sql/".$dsn['phptype']."/".$this->obj.".sousetat.inc"))
           include ("../sql/".$dsn['phptype']."/".$this->obj.".sousetat.inc");
     }
}

     $i=0;
     $position=0;
     foreach(array_keys($sousetat) as $elem){
                 $this->champs[$i++]=$elem;
     }

     $i=0;
     foreach(array_keys($sousetat) as $elem){
     $this->longueurMax[$i++]=5;
     }
     $i=0;
     foreach($sousetat as $elem){
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

} // fin constructeur

function setvalF($val){
$this->valF="<?php\n//".date(("d/m/Y   G:i:s"))."\n";
// titre
$this->valF=$this->valF."\$sousetat['titre']=\"".$val['titre']."\";\n";
$this->valF=$this->valF."\$sousetat['titrehauteur']=\"".$val['titrehauteur']."\";\n";
$this->valF=$this->valF."\$sousetat['titrefont']=\"".$val['titrefont']."\";\n";
$this->valF=$this->valF."\$sousetat['titreattribut']=\"".$val['titreattribut']."\";\n";
$this->valF=$this->valF."\$sousetat['titretaille']=\"".$val['titretaille']."\";\n";
$this->valF=$this->valF."\$sousetat['titrebordure']=\"".$val['titrebordure']."\";\n";
$this->valF=$this->valF."\$sousetat['titrealign']=\"".$val['titrealign']."\";\n";
$this->valF=$this->valF."\$sousetat['titrefond']=\"".$val['titrefond']."\";\n";
$this->valF=$this->valF."\$sousetat['titrefondcouleur']=".
            $this->enrvb($val['titrefondcouleur']).";\n";
$this->valF=$this->valF."\$sousetat['titretextecouleur']=".
            $this->enrvb($val['titretextecouleur']).";\n";

// intervalle
$this->valF=$this->valF."\$sousetat['intervalle_debut']=".$val['intervalle_debut'].";\n";
$this->valF=$this->valF."\$sousetat['intervalle_fin']=".$val['intervalle_fin'].";\n";
// entete
$this->valF=$this->valF."\$sousetat['entete_flag']=\"".$val['entete_flag']."\";\n";
$this->valF=$this->valF."\$sousetat['entete_fond']=\"".$val['entete_fond']."\";\n";
$this->valF=$this->valF."\$sousetat['entete_orientation']=".
            $this->enarray($val['entete_orientation']).";\n";
$this->valF=$this->valF."\$sousetat['entete_hauteur']=\"".$val['entete_hauteur']."\";\n";
$this->valF=$this->valF."\$sousetat['entetecolone_bordure']=".
            $this->enarray($val['entetecolone_bordure']).";\n";
$this->valF=$this->valF."\$sousetat['entetecolone_align']=".
            $this->enarray($val['entetecolone_align']).";\n";
$this->valF=$this->valF."\$sousetat['entete_fondcouleur']=".
            $this->enrvb($val['entete_fondcouleur']).";\n";
$this->valF=$this->valF."\$sousetat['entete_textecouleur']=".
            $this->enrvb($val['entete_textecouleur']).";\n";
// tableau
$this->valF=$this->valF."\$sousetat['tableau_largeur']=\"".$val['tableau_largeur']."\";\n";
$this->valF=$this->valF."\$sousetat['tableau_bordure']=\"".$val['tableau_bordure']."\";\n";
$this->valF=$this->valF."\$sousetat['tableau_fontaille']=\"".$val['tableau_fontaille']."\";\n";
$this->valF=$this->valF."\$sousetat['bordure_couleur']=".
            $this->enrvb($val['bordure_couleur']).";\n";
$this->valF=$this->valF."\$sousetat['se_fond1']=".
            $this->enrvb($val['se_fond1']).";\n";
$this->valF=$this->valF."\$sousetat['se_fond2']=".
            $this->enrvb($val['se_fond2']).";\n";

// cellule
$this->valF=$this->valF."\$sousetat['cellule_fond']=\"".$val['cellule_fond']."\";\n";
$this->valF=$this->valF."\$sousetat['cellule_hauteur']=\"".$val['cellule_hauteur']."\";\n";
$this->valF=$this->valF."\$sousetat['cellule_largeur']=".
            $this->enarray($val['cellule_largeur']).";\n";
$this->valF=$this->valF."\$sousetat['cellule_bordure_un']=".
            $this->enarray($val['cellule_bordure_un']).";\n";
$this->valF=$this->valF."\$sousetat['cellule_bordure']=".
            $this->enarray($val['cellule_bordure']).";\n";
$this->valF=$this->valF."\$sousetat['cellule_align']=".
            $this->enarray($val['cellule_align']).";\n";

// total
$this->valF=$this->valF."\$sousetat['cellule_fond_total']=\"".$val['cellule_fond_total']."\";\n";
$this->valF=$this->valF."\$sousetat['cellule_fontaille_total']=\"".$val['cellule_fontaille_total']."\";\n";
$this->valF=$this->valF."\$sousetat['cellule_hauteur_total']=\"".$val['cellule_hauteur_total']."\";\n";

$this->valF=$this->valF."\$sousetat['cellule_fondcouleur_total']=".
            $this->enrvb($val['cellule_fondcouleur_total']).";\n";
$this->valF=$this->valF."\$sousetat['cellule_bordure_total']=".
            $this->enarray($val['cellule_bordure_total']).";\n";
$this->valF=$this->valF."\$sousetat['cellule_align_total']=".
            $this->enarray($val['cellule_align_total']).";\n";
// moyenne
$this->valF=$this->valF."\$sousetat['cellule_fond_moyenne']=\"".$val['cellule_fond_moyenne']."\";\n";
$this->valF=$this->valF."\$sousetat['cellule_fontaille_moyenne']=\"".$val['cellule_fontaille_moyenne']."\";\n";
$this->valF=$this->valF."\$sousetat['cellule_hauteur_moyenne']=\"".$val['cellule_hauteur_moyenne']."\";\n";

$this->valF=$this->valF."\$sousetat['cellule_fondcouleur_moyenne']=".
            $this->enrvb($val['cellule_fondcouleur_moyenne']).";\n";
$this->valF=$this->valF."\$sousetat['cellule_bordure_moyenne']=".
            $this->enarray($val['cellule_bordure_moyenne']).";\n";
$this->valF=$this->valF."\$sousetat['cellule_align_moyenne']=".
            $this->enarray($val['cellule_align_moyenne']).";\n";
// nb enregistrement
$this->valF=$this->valF."\$sousetat['cellule_fond_nbr']=\"".$val['cellule_fond_nbr']."\";\n";
$this->valF=$this->valF."\$sousetat['cellule_fontaille_nbr']=\"".$val['cellule_fontaille_nbr']."\";\n";
$this->valF=$this->valF."\$sousetat['cellule_hauteur_nbr']=\"".$val['cellule_hauteur_nbr']."\";\n";

$this->valF=$this->valF."\$sousetat['cellule_fondcouleur_nbr']=".
            $this->enrvb($val['cellule_fondcouleur_nbr']).";\n";
$this->valF=$this->valF."\$sousetat['cellule_bordure_nbr']=".
            $this->enarray($val['cellule_bordure_nbr']).";\n";
$this->valF=$this->valF."\$sousetat['cellule_align_nbr']=".
            $this->enarray($val['cellule_align_nbr']).";\n";
// type cellule
$this->valF=$this->valF."\$sousetat['cellule_numerique']=".
            $this->enarray($val['cellule_numerique']).";\n";
// affichage total moyenne nb enr
$this->valF=$this->valF."\$sousetat['cellule_total']=".
            $this->enarray($val['cellule_total']).";\n";
$this->valF=$this->valF."\$sousetat['cellule_moyenne']=".
            $this->enarray($val['cellule_moyenne']).";\n";
$this->valF=$this->valF."\$sousetat['cellule_compteur']=".
            $this->enarray($val['cellule_compteur']).";\n";
//
$this->valF=$this->valF."\$sousetat['sql']=\"".$val['sql']."\";\n";
//
$this->valF=$this->valF."?>\n";

}



function verifier(){
$this->correct=True;

}//verifier




function setType(&$form,$maj) {
  $form->setType('image', 'hidden');
if ($maj < 2) { //ajouter et modifier
  $form->setType('titreattribut', 'select');
  $form->setType('titrefont', 'select');
  $form->setType('titrealign', 'select');
  $form->setType('titrebordure', 'select');
  $form->setType('titre', 'textarea');
  $form->setType('titrefondcouleur', 'rvb');
  $form->setType('titretextecouleur', 'rvb');

  $form->setType('titrefond', 'select');

  $form->setType('entete_flag', 'select');
  $form->setType('entete_fond', 'select');
  $form->setType('entete_orientation','textarea');
  $form->setType('entetecolone_bordure','textarea');
  $form->setType('entetecolone_align','textarea');
  $form->setType('entete_fondcouleur','rvb');
  $form->setType('entete_textecouleur','rvb');

  $form->setType('tableau_bordure', 'select');
  $form->setType('bordure_couleur','rvb');
  $form->setType('se_fond1','rvb');
  $form->setType('se_fond2','rvb');

  $form->setType('cellule_fond', 'select');
  $form->setType('cellule_largeur','textarea');
  $form->setType('cellule_bordure_un','textarea');
  $form->setType('cellule_bordure','textarea');
  $form->setType('cellule_align','textarea');

  $form->setType('cellule_fond_total', 'select');
  $form->setType('cellule_fondcouleur_total','rvb');
  $form->setType('cellule_bordure_total','textarea');
  $form->setType('cellule_align_total','textarea');

  $form->setType('cellule_fond_moyenne', 'select');
  $form->setType('cellule_fondcouleur_moyenne','rvb');
  $form->setType('cellule_bordure_moyenne','textarea');
  $form->setType('cellule_align_moyenne','textarea');

  $form->setType('cellule_fond_nbr', 'select');
  $form->setType('cellule_fondcouleur_nbr','rvb');
  $form->setType('cellule_bordure_nbr','textarea');
  $form->setType('cellule_align_nbr','textarea');

  // operations
  $form->setType('cellule_numerique','textarea');
  $form->setType('cellule_total','textarea');
  $form->setType('cellule_moyenne','textarea');
  $form->setType('cellule_compteur','textarea');

  $form->setType('sql', 'textarea');
 // $form->setType('sousetat', 'textareamulti');

  if ($maj==1){ //modifier
     $form->setType('idx', 'hidden');
  }
}else{ // supprimer
     $form->setType('idx', 'hiddenstatic');
}}

function setTaille(&$form,$maj){

$form->setTaille('titre', 80);
$form->setTaille('sql', 80);
$form->setTaille('titrefondcouleur', 13);
$form->setTaille('titretextecouleur', 13);

$form->setTaille('entete_orientation',10);
$form->setTaille('entetecolone_bordure',10);
$form->setTaille('entetecolone_align',10);
$form->setTaille('entete_fondcouleur',13);
$form->setTaille('entete_textecouleur',13);

$form->setTaille('bordure_couleur',13);
$form->setTaille('se_fond1',13);
$form->setTaille('se_fond2',13);

$form->setTaille('cellule_largeur',10);
$form->setTaille('cellule_bordure_un',10);
$form->setTaille('cellule_bordure',10);
$form->setTaille('cellule_align',10);

$form->setTaille('cellule_fondcouleur_total',13);
$form->setTaille('cellule_bordure_total',10);
$form->setTaille('cellule_align_total',10);

$form->setTaille('cellule_fondcouleur_moyenne',13);
$form->setTaille('cellule_bordure_moyenne',10);
$form->setTaille('cellule_align_moyenne',10);

$form->setTaille('cellule_fondcouleur_nbr',13);
$form->setTaille('cellule_bordure_nbr',10);
$form->setTaille('cellule_align_nbr',10);

$form->setTaille('cellule_numerique',10);
$form->setTaille('cellule_total',10);
$form->setTaille('cellule_moyenne',10);
$form->setTaille('cellule_compteur',10);
}
function setMax(&$form,$maj){
$form->setMax('titre', 3);
$form->setMax('sql', 10);
$form->setMax('titrefondcouleur', 11);
$form->setMax('titretextecouleur', 11);

$form->setMax('entete_orientation',3);
$form->setMax('entetecolone_bordure',3);
$form->setMax('entetecolone_align',3);
$form->setMax('entete_fondcouleur',11);
$form->setMax('entete_textecouleur',11);

$form->setMax('bordure_couleur',11);
$form->setMax('se_fond1',11);
$form->setMax('se_fond2',11);

$form->setMax('cellule_largeur',3);
$form->setMax('cellule_bordure_un',3);
$form->setMax('cellule_bordure',3);
$form->setMax('cellule_align',3);

$form->setMax('cellule_fondcouleur_total',11);
$form->setMax('cellule_bordure_total',3);
$form->setMax('cellule_align_total',3);

$form->setMax('cellule_fondcouleur_moyenne',11);
$form->setMax('cellule_bordure_moyenne',3);
$form->setMax('cellule_align_moyenne',3);

$form->setMax('cellule_fondcouleur_nbr',11);
$form->setMax('cellule_bordure_nbr',3);
$form->setMax('cellule_align_nbr',3);

$form->setMax('cellule_numerique',3);
$form->setMax('cellule_total',3);
$form->setMax('cellule_moyenne',3);
$form->setMax('cellule_compteur',3);
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

//
$contenu=array();
$contenu[0]=array('helvetica','times','arial');
$contenu[1]=array('helvetica','times','arial');
$form->setSelect("titrefont",$contenu);

//
$contenu=array();
$contenu[0]=array('L','R','J','C');
$contenu[1]=array($this->om_lang("gauche"),$this->om_lang("droite"),$this->om_lang("justifie"),$this->om_lang("centre"));
$form->setSelect("titrealign",$contenu);

//
$contenu=array();
$contenu[0]=array('0','1');
$contenu[1]=array($this->om_lang("sans"),$this->om_lang("avec"));
$form->setSelect("titrebordure",$contenu);
$form->setSelect("entete_flag",$contenu);
$form->setSelect("tableau_bordure",$contenu);
// fond
$contenu[1]=array($this->om_lang("transparent"),$this->om_lang("fond"));
$form->setSelect("titrefond",$contenu);
$form->setSelect("entete_fond",$contenu);
$form->setSelect("cellule_fond",$contenu);
$form->setSelect("cellule_fond_total",$contenu);
$form->setSelect("cellule_fond_moyenne",$contenu);
$form->setSelect("cellule_fond_nbr",$contenu);
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
// sousetat => liste
$contenu=array();
include ("../dyn/var.inc");
include ("../dyn/connexion.php");
$dir=getcwd();
if (isset($langue)){
    if (file_exists ("../sql/".$dsn['phptype']."/".$langue));
      $dir=substr($dir,0,strlen($dir)-4)."/sql/".$dsn['phptype']."/".$langue."/";
}else{
     $dir=substr($dir,0,strlen($dir)-4)."/sql/".$dsn['phptype']."/";
}
$dossier = opendir($dir);
$k=0;
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

$form->setRegroupe('titrehauteur','D',$this->om_lang("parametres")."&nbsp;".$this->om_lang("titre"));
$form->setRegroupe('titrelargeur','G','');
$form->setRegroupe('titrefont','G','');
$form->setRegroupe('titreattribut','G','');
$form->setRegroupe('titretaille','G','');
$form->setRegroupe('titrebordure','G','');
$form->setRegroupe('titrealign','G','');
$form->setRegroupe('titrefond','G','');
$form->setRegroupe('titrefondcouleur','G','');
$form->setRegroupe('titretextecouleur','G','');
$form->setRegroupe('intervalle_debut','G','');
$form->setRegroupe('intervalle_fin','F','');
// entete
$form->setRegroupe('entete_flag','D',$this->om_lang("entete")."&nbsp;".$this->om_lang("du")."&nbsp;".$this->om_lang("tableau"));
$form->setRegroupe('entete_fond','G','');
$form->setRegroupe('entete_orientation','G','');
$form->setRegroupe('entete_hauteur','G','');
$form->setRegroupe('entetecolone_bordure','G','');
$form->setRegroupe('entetecolone_align','G','');
$form->setRegroupe('entete_fondcouleur','G','');
$form->setRegroupe('entete_textecouleur','F','');
// data
$form->setRegroupe('tableau_largeur','D',$this->om_lang("data")."&nbsp;".$this->om_lang("du")."&nbsp;".$this->om_lang("tableau"));
$form->setRegroupe('tableau_bordure','G','');
$form->setRegroupe('tableau_fontaille','G','');
$form->setRegroupe('bordure_couleur','G','');
$form->setRegroupe('se_fond1','G','');
$form->setRegroupe('se_fond2','F','');
// cellule
$form->setRegroupe('cellule_fond','D',$this->om_lang("cellule")."&nbsp;".$this->om_lang("du")."&nbsp;".$this->om_lang("tableau"));
$form->setRegroupe('cellule_hauteur','G','');
$form->setRegroupe('cellule_largeur','G','');
$form->setRegroupe('cellule_bordure_un','G','');
$form->setRegroupe('cellule_bordure','G','');
$form->setRegroupe('cellule_align','F','');
// total
$form->setRegroupe('cellule_fond_total','D',$this->om_lang("total")."&nbsp;".$this->om_lang("du")."&nbsp;".$this->om_lang("tableau"));
$form->setRegroupe('cellule_fontaille_total','G','');
$form->setRegroupe('cellule_hauteur_total','G','');
$form->setRegroupe('cellule_fondcouleur_total','G','');
$form->setRegroupe('cellule_bordure_total','G','');
$form->setRegroupe('cellule_align_total','F','');
// moyenne
$form->setRegroupe('cellule_fond_moyenne','D',$this->om_lang("moyenne")."&nbsp;".$this->om_lang("du")."&nbsp;".$this->om_lang("tableau"));
$form->setRegroupe('cellule_fontaille_moyenne','G','');
$form->setRegroupe('cellule_hauteur_moyenne','G','');
$form->setRegroupe('cellule_fondcouleur_moyenne','G','');
$form->setRegroupe('cellule_bordure_moyenne','G','');
$form->setRegroupe('cellule_align_moyenne','F','');
// nbr
$form->setRegroupe('cellule_fond_nbr','D',$this->om_lang("nombre")."&nbsp;".$this->om_lang("enregistrement")."&nbsp;".$this->om_lang("du")."&nbsp;".$this->om_lang("tableau"));
$form->setRegroupe('cellule_fontaille_nbr','G','');
$form->setRegroupe('cellule_hauteur_nbr','G','');
$form->setRegroupe('cellule_fondcouleur_nbr','G','');
$form->setRegroupe('cellule_bordure_nbr','G','');
$form->setRegroupe('cellule_align_nbr','F','');
// operations
$form->setRegroupe('cellule_numerique','D',$this->om_lang("operations")."&nbsp;".$this->om_lang("du")."&nbsp;".$this->om_lang("tableau"));
$form->setRegroupe('cellule_total','G','');
$form->setRegroupe('cellule_moyenne','G','');
$form->setRegroupe('cellule_compteur','F','');
}
function setGroupe(&$form,$maj){
// titre
$form->setGroupe('titrehauteur','D');
$form->setGroupe('titrefont','G');
$form->setGroupe('titreattribut','F');

$form->setGroupe('titretaille','D');
$form->setGroupe('titrebordure','G');
$form->setGroupe('titrealign','F');

$form->setGroupe('titrefond','D');
$form->setGroupe('titrefondcouleur','G');
$form->setGroupe('titretextecouleur','F');

$form->setGroupe('intervalle_debut','D');
$form->setGroupe('intervalle_fin','F');
// entete
$form->setGroupe('entete_flag','D');
$form->setGroupe('entete_fond','F');
$form->setGroupe('entete_orientation','D');
$form->setGroupe('entete_hauteur','G');
$form->setGroupe('entetecolone_bordure','F');
$form->setGroupe('entetecolone_align','D');
$form->setGroupe('entete_fondcouleur','G');
$form->setGroupe('entete_textecouleur','F');
// data
$form->setGroupe('tableau_largeur','D');
$form->setGroupe('tableau_bordure','G');
$form->setGroupe('tableau_fontaille','F');

$form->setGroupe('bordure_couleur','D');
$form->setGroupe('se_fond1','G');
$form->setGroupe('se_fond2','F');
// cellules
$form->setGroupe('cellule_fond','D');
$form->setGroupe('cellule_hauteur','F');

$form->setGroupe('cellule_largeur','D');
$form->setGroupe('cellule_bordure_un','G');
$form->setGroupe('cellule_bordure','G');
$form->setGroupe('cellule_align','F');
// total
$form->setGroupe('cellule_fond_total','D');
$form->setGroupe('cellule_fontaille_total','G');
$form->setGroupe('cellule_hauteur_total','F');

$form->setGroupe('cellule_fondcouleur_total','D');
$form->setGroupe('cellule_bordure_total','G');
$form->setGroupe('cellule_align_total','F');
// moyenne
$form->setGroupe('cellule_fond_moyenne','D');
$form->setGroupe('cellule_fontaille_moyenne','G');
$form->setGroupe('cellule_hauteur_moyenne','F');

$form->setGroupe('cellule_fondcouleur_moyenne','D');
$form->setGroupe('cellule_bordure_moyenne','G');
$form->setGroupe('cellule_align_moyenne','F');
// nbr
$form->setGroupe('cellule_fond_nbr','D');
$form->setGroupe('cellule_fontaille_nbr','G');
$form->setGroupe('cellule_hauteur_nbr','F');

$form->setGroupe('cellule_fondcouleur_nbr','D');
$form->setGroupe('cellule_bordure_nbr','G');
$form->setGroupe('cellule_align_nbr','F');
// operations
$form->setGroupe('cellule_numerique','D');
$form->setGroupe('cellule_total','G');
$form->setGroupe('cellule_moyenne','G');
$form->setGroupe('cellule_compteur','F');
}
function setLib(&$form,$maj) {

$form->setLib('titre',$this->om_lang('titre'));

$form->setLib('titrehauteur',$this->om_lang('hauteur'));
$form->setLib('titrefont',$this->om_lang('font'));
$form->setLib('titreattribut',$this->om_lang('mise_en_forme')."&nbsp;".$this->om_lang('du')."&nbsp;".$this->om_lang('texte'));
$form->setLib('titretaille',$this->om_lang('taille'));
$form->setLib('titrebordure',$this->om_lang('bordure'));
$form->setLib('titrealign',$this->om_lang('align'));
$form->setLib('titrefondcouleur',$this->om_lang('couleur')."&nbsp;".$this->om_lang('du')."&nbsp;".$this->om_lang('fond'));
$form->setLib('titretextecouleur',$this->om_lang('couleur')."&nbsp;".$this->om_lang('du')."&nbsp;".$this->om_lang('texte'));
$form->setLib('intervalle_debut',$this->om_lang('intervalle')."&nbsp;".$this->om_lang('debut'));
$form->setLib('intervalle_fin',$this->om_lang('fin'));

$form->setLib('entete_flag',$this->om_lang('flag'));
$form->setLib('entete_fond',$this->om_lang('fin'));
$form->setLib('entete_orientation',$this->om_lang('orientation')."&nbsp;".$this->om_lang('texte'));
$form->setLib('entete_hauteur',$this->om_lang('hauteur'));

$form->setLib('entetecolone_bordure',$this->om_lang('bordure'));
$form->setLib('entetecolone_align',$this->om_lang('align'));
$form->setLib('entete_fondcouleur',$this->om_lang('fond'));
$form->setLib('entete_textecouleur',$this->om_lang('couleur'));
// data
$form->setLib('tableau_largeur',$this->om_lang('largeur'));
$form->setLib('tableau_bordure',$this->om_lang('bordure'));
$form->setLib('tableau_fontaille',$this->om_lang('taille'));
$form->setLib('bordure_couleur',$this->om_lang('bordure'));
$form->setLib('se_fond1',$this->om_lang('fond')."&nbsp;".$this->om_lang('numero')."&nbsp".$this->om_lang('un'));
$form->setLib('se_fond2',$this->om_lang('fond')."&nbsp;".$this->om_lang('numero')."&nbsp".$this->om_lang('deux'));
// cellule
$form->setLib('cellule_fond','');
$form->setLib('cellule_hauteur',$this->om_lang('hauteur'));
$form->setLib('cellule_largeur',$this->om_lang('largeur'));
$form->setLib('cellule_bordure_un',$this->om_lang('bordure')."&nbsp;".$this->om_lang("premiere")."&nbsp;".$this->om_lang('cellule'));
$form->setLib('cellule_bordure',$this->om_lang('bordure'));
$form->setLib('cellule_align',$this->om_lang('align'));
// total
$form->setLib('cellule_fond_total',$this->om_lang('fond')."&nbsp;".$this->om_lang('cellule'));
$form->setLib('cellule_fontaille_total',$this->om_lang('taille'));
$form->setLib('cellule_hauteur_total',$this->om_lang('hauteur'));
$form->setLib('cellule_fondcouleur_total',$this->om_lang('fond'));
$form->setLib('cellule_bordure_total',$this->om_lang('bordure'));
$form->setLib('cellule_align_total',$this->om_lang('align'));
// moyenne
$form->setLib('cellule_fond_moyenne',$this->om_lang('fond')."&nbsp;".$this->om_lang('cellule'));
$form->setLib('cellule_fontaille_moyenne',$this->om_lang('taille'));
$form->setLib('cellule_hauteur_moyenne',$this->om_lang('hauteur'));
$form->setLib('cellule_fondcouleur_moyenne',$this->om_lang('fond'));
$form->setLib('cellule_bordure_moyenne',$this->om_lang('bordure'));
$form->setLib('cellule_align_moyenne',$this->om_lang('align'));
// nbr
$form->setLib('cellule_fond_nbr',$this->om_lang('fond')."&nbsp;".$this->om_lang('cellule'));
$form->setLib('cellule_fontaille_nbr',$this->om_lang('taille'));
$form->setLib('cellule_hauteur_nbr',$this->om_lang('hauteur'));
$form->setLib('cellule_fondcouleur_nbr',$this->om_lang('fond'));
$form->setLib('cellule_bordure_nbr',$this->om_lang('bordure'));
$form->setLib('cellule_align_nbr',$this->om_lang('align'));
// operations
$form->setLib('cellule_numerique',$this->om_lang('numerique'));
$form->setLib('cellule_total',$this->om_lang('total'));
$form->setLib('cellule_moyenne',$this->om_lang('moyenne'));
$form->setLib('cellule_compteur',$this->om_lang('nombre'));

$form->setLib('sql',$this->om_lang('sql'));
}

function setVal(&$form,$maj,$validation){
if ($validation==0) {
  if ($maj == 0){
    $form->setVal('titre','Texte du titre');
    $form->setVal('titrefont','helvetica');
    $form->setVal('titrehauteur',10);
    $form->setVal('titrefond',0);
    $form->setVal('titreattribut','B');
    $form->setVal('titretaille',12);
    $form->setVal('titrebordure',0);
    $form->setVal('titrealign','L');

    $form->setVal('titrefondcouleur','243-246-246');
    $form->setVal('titretextecouleur','0-0-0');

    $form->setVal('intervalle_debut',10);
    $form->setVal('intervalle_fin',15);

    $form->setVal('entete_flag',1);
    $form->setVal('entete_fond',1);
    $form->setVal('entete_orientation',"0\n0\n0");
    $form->setVal('entete_hauteur',20);
    $form->setVal('entetecolone_bordure',"TLB\nLTB\nLTBR");
    $form->setVal('entetecolone_align',"C\nC\nC");
    $form->setVal('entete_fondcouleur','195-224-169');
    $form->setVal('entete_textecouleur','0-0-0');

    $form->setVal('tableau_largeur',195);
    $form->setVal('tableau_bordure',1);
    $form->setVal('tableau_fontaille',10);

    $form->setVal('bordure_couleur','0-0-0');
    $form->setVal('se_fond1','243-243-246');
    $form->setVal('se_fond2','255-255-255');

    $form->setVal('cellule_fond',1);
    $form->setVal('cellule_hauteur',10);
    $form->setVal('cellule_largeur',"65\n65\n65");
    $form->setVal('cellule_bordure_un',"LTBR\nLTBR\nLTBR");
    $form->setVal('cellule_bordure',"LTBR\nLTBR\nLTBR");
    $form->setVal('cellule_align',"L\nL\nC");

    $form->setVal('cellule_fond_total',1);
    $form->setVal('cellule_fontaille_total',10);
    $form->setVal('cellule_hauteur_total',15);
    $form->setVal('cellule_fondcouleur_total',"196-213-215");
    $form->setVal('cellule_bordure_total',"TBL\nTBL\nLTBR");
    $form->setVal('cellule_align_total',"L\nL\nC");

    $form->setVal('cellule_fond_moyenne',1);
    $form->setVal('cellule_fontaille_moyenne',10);
    $form->setVal('cellule_hauteur_moyenne',15);
    $form->setVal('cellule_fondcouleur_moyenne',"196-213-215");
    $form->setVal('cellule_bordure_moyenne',"TBL\nTBL\nLTBR");
    $form->setVal('cellule_align_moyenne',"L\nL\nC");

    $form->setVal('cellule_fond_nbr',1);
    $form->setVal('cellule_fontaille_nbr',10);
    $form->setVal('cellule_hauteur_nbr',15);
    $form->setVal('cellule_fondcouleur_nbr',"196-213-215");
    $form->setVal('cellule_bordure_nbr',"TBL\nTBL\nLTBR");
    $form->setVal('cellule_align_nbr',"L\nL\nC");

    $form->setVal('cellule_numerique',"999\n999\n999");
    $form->setVal('cellule_total',"0\n0\n0");
    $form->setVal('cellule_moyenne',"0\n0\n0");
    $form->setVal('cellule_compteur',"0\n0\n1");

    $form->setVal('sql',"select ... \nfrom ... \nwhere ... = £idx");

}}}
}// fin de classe
?>  