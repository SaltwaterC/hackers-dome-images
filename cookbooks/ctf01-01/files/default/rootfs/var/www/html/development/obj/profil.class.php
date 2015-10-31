<?php
/*
$Id: profil.class.php,v 1.3 2008-07-24 14:33:31 jbastide Exp $
*/
require_once ($path_om."formulairedyn.class.php");
require_once ($path_om."dbformdyn.class.php");

class profil extends dbForm {

    var $table="profil";
    var $clePrimaire= "profil";
    var $typeCle= "N" ;


function profil($id,$db,$debug) {
$this->constructeur($id,$db,$debug);
}

function setvalF($val){
$this->valF['libelle_profil'] = $val['libelle_profil'];
}

function verifier(){
   $this->correct=True;
    $imgv="";
    $f="&nbsp!&nbsp;&nbsp;&nbsp;&nbsp;";
    $imgv="<img src='../img/punaise.png' style='vertical-align:middle' hspace='2' border='0'>";
    if ($this->valF['libelle_profil']==""){
       $this->correct=false;
       $this->msg= $this->msg.$imgv.$this->lang("libelle")."&nbsp;".$this->lang("obligatoire").$f;
    }
}

function cleSecondaire($id,$db,$val,$debug) {
$this->rechercheDroit($id,$db,$debug) ;
$this->rechercheUtilisateur($id,$db,$debug) ;
}
function rechercheDroit($id,$db,$debug){
    $this->correct=True;
    $imgv="";
    $f="&nbsp!&nbsp;&nbsp;&nbsp;&nbsp;";
    $imgv="<img src='../img/punaise.png'style='vertical-align:middle'  border='0'>";
    $sql = "select * from droit where profil =".$id."";
    $res = $db->query($sql);
    if($debug==1) echo $sql;
    if (DB :: isError($res))
       die($res->getMessage(). " => Echec  ".$sql);
    else{
        $nbligne=$res->numrows();
        $this->msg = $this->msg.$imgv."&nbsp;".$this->lang("il_y_a")."&nbsp;<font class='parametre'>&nbsp;".$nbligne."&nbsp;</font>&nbsp;".
        $this->lang("enregistrement")."&nbsp;".$this->lang("en_lien")."&nbsp;".$this->lang("avec")."&nbsp;".$this->lang("table")." droit ".$this->lang("profil")."&nbsp; [".
        $id."]".$f."<br>";
        if ($nbligne>0)
           $this->correct=false;
    }
}

function rechercheUtilisateur($id,$db,$debug){
    $this->correct=True;
    $imgv="";
    $f="&nbsp!&nbsp;&nbsp;&nbsp;&nbsp;";
    $imgv="<img src='../img/punaise.png'style='vertical-align:middle'  border='0'>";
    $sql = "select * from utilisateur where profil =".$id."";
    $res = $db->query($sql);
    if($debug==1) echo $sql;
    if (DB :: isError($res))
       die($res->getMessage(). " => Echec  ".$sql);
    else{
        $nbligne=$res->numrows();
        $this->msg = $this->msg.$imgv."&nbsp;".$this->lang("il_y_a")."&nbsp;<font class='parametre'>&nbsp;".$nbligne."&nbsp;</font>&nbsp;".
        $this->lang("enregistrement")."&nbsp;".$this->lang("en_lien")."&nbsp;".$this->lang("avec")."&nbsp;".$this->lang("table")." utilisateur ".$this->lang("profil")."&nbsp; [".
        $id."]".$f."<br>";
        if ($nbligne>0)
           $this->correct=false;
    }
}

function setType(&$form,$maj) {
   if ($maj < 2) {
     if ($maj==1){
        $form->setType('profil', 'hiddenstatic');
     }
   }else{
        $form->setType('profil', 'hiddenstatic');
   }}

function setLib(&$form,$maj) {
  $form->setLib('libelle_profil',$this->lang("libelle"));
   $form->setLib('profil',$this->lang("profil"));
}

function setTaille(&$form,$maj){
  $form->setTaille('profil', 2);
  $form->setTaille('libelle_profil', 30);
}

function setMax(&$form,$maj){
  $form->setMax('profil', 2);
  $form->setMax('libelle_profil', 30);
}

function setOnchange(&$form,$maj){
$x=$this->lang("saisie_uniquement_numerique");
$form->setOnchange("libelle_profil","this.value=this.value.toUpperCase()");
$form->setOnchange('profil','VerifNumLocal(this)');
?>
<script language="javascript">
function VerifNumLocal(champ){
if (isNaN(champ.value)){
         alert("<?php echo $x?>"+" !");
         champ.value=0;
         return;
}
champ.value=champ.value.replace(".","");
}
</script>
<?php
}
}
?>