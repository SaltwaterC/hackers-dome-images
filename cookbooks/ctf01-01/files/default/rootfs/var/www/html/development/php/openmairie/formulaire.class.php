<?php
/* $Id: formulaire.class.php,v 1.1 2008-07-24 13:18:52 jbastide Exp $
http://www.openmairie.org
contact@openmairie.org

Cette classe a pour objet la construction des champs du formulaire
suivant
    - $type    (tableau) : type de champ
    - $val     (tableau) : valeur du champ
    - $taille  (tableau) : taille du champ
    - $max     (tableau) : saisie maximale autorisée pour le champ
    - $lib     (tableau) : libelle de saisie
    - $select  (tableau) : valeur des controles liste
                           [0] value
                           [1] libelle (<option>libelle</option>)
    - $groupe  (tableau) : regroupement de champ par ligne
    - $regroupe (tableau) : fieldset
    - $enteteTab (string): entete du formulaire
    */

// modification ==============================================================
// 12/02/05 correction bug hiddenstaticdate
// version 1.01 selectdisabled / textdisabled / upload
// version 1.02 du 24 Mai 2005 fonction afficher
// version 1.06 type champ localisation
// version 1.07 du 06 fevrier 2006 affichage fieldset
// version 1.08 du 13 fevrier 2006 type champ textareamulti
// version 1.09 du 04 Avril 2006 debug derniere version WAMP balise
//                                <?=$x? => <?php echo($x);?
//                               type RVB
// version 1.10 du 02/05/06 : modification appel rvb.php
// version 1.11 du 13/05/06 :
//            correction taille champ date en disabled
//            affichage date disabled en hiddenstaticdate (date calculée)
//            checkbox et readonly
// version 1.12 textareahiddenstatic
// 20 octobre 2006 ajout fonction mail ->type champs mail
// version 1.17 type http (opencimetiere 1.09)
// version 1.18 type httpclick (openfoncier 1.04)
// version 2.01 type voir (opencimetiere 1.11)   Avril 2008
// ===========================================================================

class formulaire{

var $enteteTab;   // entete
var $val;         // valeur par defaut du champ
var $type;        // Type de champ
var $taille;      // taille du champ
var $max;         // nombre de caracteres maximum à saisir
var $lib;         // libelle du champ
var $groupe;      // regroupement
var $select;      // valeur des listes
var $onchange;    // javascrpt en cas de changement
var $regroupe;    // fieldset
var $correct;



/* =======================================================================
Initialisation des tableaux de parametrage formulaire
- valeur par défaut
  en modification et suppression = initialiser par la valeur des champs
  en ajout = initialisation vide
- type par defaut
  text pour ajout et modification
  static pour suppression
======================================================================= */

function formulaire($a, $validation,$maj, $champs, $val,$max) {
         $this->enteteTab=$a;
         // valeur par défaut et type
         if ($maj == 0) { //ajouter
            for($i=0;$i<count($champs);$i++){
                $this->val[$champs[$i]]="";
                $this->type[$champs[$i]]="text";
         }}
         if ($maj == 1) { //modifier
           if ($validation==0) {
             $i=0;
             foreach($val as $elem){
                $this->val[$champs[$i]] =strtr($elem,chr(34),"'");
                $i++;
             }}
            for($i=0;$i<count($champs);$i++){
               $this->type[$champs[$i]]="text";
               if ($validation!=0)
                 $this->val[$champs[$i]]="";
         }}
         if ($maj == 2) { //supprimer
          if ($validation==0) {
             $i=0;
             foreach($val as $elem){
                $this->val[$champs[$i]] =strtr($elem,chr(34),"'");
                $i++;
             }}
            for($i=0;$i<count($champs);$i++){
               $this->type[$champs[$i]]="static";
               if ($validation!=0)
                 $this->val[$champs[$i]]="";
         }}

         // taille  et longueur maximum
         $i=0;
         foreach($max as $elem){
              $this->taille[$champs[$i]] =$elem;
              $this->max[$champs[$i]] =$elem;
              $i++;
         }

         // libelle, group, select, onchange
         for($i=0;$i<count($champs);$i++){
             $this->lib[$champs[$i]]=ucwords($champs[$i]);
             $this->groupe[$champs[$i]]="";
             $this->select[$champs[$i]][0]="";
             $this->select[$champs[$i]][1]="";
             $this->onchange[$champs[$i]]="";
         }
}


function entete(){
echo "<table class='formEntete' cellpadding=0>";
//echo "<tr class='formEntete'><td colspan=3>".
//$this->enteteTab."</td></tr>";
}


//=======================================================================
// $champ = nom du champ
// $validation ==0 formulaire non validation
// parametre afficherchamp
// ======================================================================

function afficherChamp($champ,$validation,$DEBUG){
$DEBUG=0;
$rcjs=chr(92)."r";
// gestion du groupe
if ($this->type[$champ]!="hidden") {
  if ($this->groupe[$champ]!="F" and $this->groupe[$champ]!="G")
       echo "<td class='formLibelle'>" ;
   if($DEBUG==1){
   echo "<a href=# onclick=\"alert('Type :  ".$this->type[$champ].$rcjs.
        " Valeur par défaut : ".$this->val[$champ].$rcjs.
        " Taille : ".$this->taille[$champ].$rcjs.
        " Longueur maximale : ".$this->max[$champ].$rcjs.
        " onchange : ".$this->onchange[$champ].$rcjs.
        " ongroupe : ".$this->groupe[$champ].$rcjs.
        " regroupe : ".$this->regroupe[$champ].$rcjs.
        " Nom champ : ".$champ.$rcjs.
        "')\">".$this->lib[$champ]."</a>";
   }else{
      // affichage du libelle du controle
      echo "".$this->lib[$champ]."";
   }
  if ($this->groupe[$champ]!="F" and $this->groupe[$champ]!="G")
   echo "<td>";
}

// fonction suivant type du champ
$fonction=  $this->type[$champ];
if ($fonction=="static") $fonction="statiq"; // compatibilité
$this->$fonction($champ,$validation,$DEBUG);

// gestion du groupe
if ($this->type[$champ]!="hidden"){
    if ($this->groupe[$champ]!="D" and $this->groupe[$champ]!="G")
         echo"</td></tr>";
    }
}


// integration de fieldset + legend + table imbriquée
// 6 fevrier 2006
// dans var.inc les styles suivants sont à preciser
// - $style_tablefieldset
// - $style_legendfieldset
// - $style_fieldset
// cette solution plutot que css a ete mise en place
// car IE n accepte pas les class sur tables imbriquées

function afficherChampRegroupe($champ,$validation,$DEBUG){
$DEBUG=0;
$rcjs=chr(92)."r";
if(file_exists("../dyn/custom/var.inc")) {
   include("../dyn/custom/var.inc");
}
else {
  include("../dyn/var.inc");
}
// gestion du groupe
if ($this->type[$champ]!="hidden") {
  //if ($this->groupe[$champ]!="F" and $this->groupe[$champ]!="G"){
  if ($this->regroupe[$champ][0]=="D"){
    echo "<tr><td colspan='2'>" ;
  }
   if($DEBUG==1){
   echo "<a href=# onclick=\"alert('Type :  ".$this->type[$champ].$rcjs.
        " Valeur par défaut : ".$this->val[$champ].$rcjs.
        " Taille : ".$this->taille[$champ].$rcjs.
        " Longueur maximale : ".$this->max[$champ].$rcjs.
        " onchange : ".$this->onchange[$champ].$rcjs.
        " ongroupe : ".$this->groupe[$champ].$rcjs.
        " regroupe : ".$this->regroupe[$champ].$rcjs.
        " Nom champ : ".$champ.$rcjs.
        "')\">".$this->lib[$champ]."</a>";
   }else{
      // affichage du libelle du controle
    if ($this->regroupe[$champ][0]=="D"){
      echo "<fieldset style=".$style_fieldset."><legend style=".
      $style_legendfieldset.">".
      $this->regroupe[$champ][1].
      "</legend><table style=".$style_tablefieldset."><tr>";
    }
    echo "<td>".$this->lib[$champ]."</td><td>";
   }
}

// fonction suivant type du champ
$fonction=  $this->type[$champ];
if ($fonction=="static") $fonction="statiq"; // compatibilité
$this->$fonction($champ,$validation,$DEBUG);
echo "</td>";
// gestion du groupe
if ($this->type[$champ]!="hidden"){
    if ($this->regroupe[$champ][0]=="F") {
      echo "</tr></table></fieldset></td></tr>";
      //echo "</tr></table></div></td></tr>";
      }
    if ($this->groupe[$champ]!="D" and $this->groupe[$champ]!="G")
        echo "</tr><tr>";//echo "<br>";
}

}



// =============================================================================
// traitement formulaire suivant type de champ
// =============================================================================

// ***************************************************
// hiddenstatic
// la valeur du champ est passe par le controle hidden
// ***************************************************
function hiddenstatic($champ,$validation,$DEBUG){
    echo "<INPUT type='hidden' name='".$champ."' value=\"".
       $this->val[$champ]."\" class='champFormulaire' >";
    echo $this->val[$champ]."";
}
// ***************************************************
// hiddenstaticnum
// la valeur du champ est passe par le controle hidden
// ***************************************************
function hiddenstaticnum($champ,$validation,$DEBUG){
    echo "<INPUT type='hidden' name='".$champ."' value=\"".
       $this->val[$champ]."\" class='champFormulaire' >";
    echo "<p align='right'>".$this->val[$champ]." </p>";
}
// ***************************************************
// textareahiddenstatic
// la valeur du champ n est pas passe
// affichage du champ en texte
// ***************************************************
function textareahiddenstatic($champ,$validation,$DEBUG){
    echo "<INPUT type='hidden' name='".$champ."' value=\"".
       $this->val[$champ]."\" class='champFormulaire' >";
    $this->val[$champ] = str_replace("\n","<br>",$this->val[$champ]);
    echo $this->val[$champ]."";
}

// ***************************************************
// hiddenstaticdate => champ DATE
// la valeur du champ est passe par le controle hidden
// ***************************************************
function  hiddenstaticdate($champ,$validation,$DEBUG){
if($this->val[$champ]!="" and $validation==0)
    $defautDate= $this->dateAff($this->val[$champ]);
else
    $defautDate=$this->val[$champ];

if(!$this->correct) {
      echo "<INPUT type='hidden' name='".$champ."' value=\"".
      $defautDate."\" class='champFormulaire' >";
      echo $defautDate."";
}else{
      echo $this->val[$champ]."";
}
}

// ***************************************************
// Static
// la valeur du champ n'est pas conservée
// ***************************************************
function statiq($champ,$validation,$DEBUG){
echo "".$this->val[$champ]."";
}

// ***************************************************
// textarea
// ***************************************************

function textarea($champ,$validation,$DEBUG){
// colones = taille
// lignes = max
   if(!$this->correct) {
    echo "<textarea  name='".
       $champ."'  cols=".$this->taille[$champ].
       " rows=".$this->max[$champ]." onchange=\"".
       $this->onchange[$champ]."\" class='champFormulaire' >".
       $this->val[$champ]."</textarea>";
   }else{
    echo "<textarea  name='".
       $champ."'  cols=".$this->taille[$champ].
       " rows=".$this->max[$champ]." onchange=\"".
       $this->onchange[$champ]."\" class='champFormulaire' disabled >".
       $this->val[$champ]."</textarea>";       
}}

// ***************************************************
// pagehtml
// les \n => <br> en affichage
// ***************************************************
function pagehtml($champ,$validation,$DEBUG){
   if ($this->val[$champ]!="" and $validation==0)
         $this->val[$champ] = str_replace("<br>","\n",$this->val[$champ]);
   if(!$this->correct) {
    echo "<textarea  name='".
       $champ."'  cols=".$this->taille[$champ].
       " rows=".$this->max[$champ]." onchange=\"".
       $this->onchange[$champ]."\" class='champFormulaire' >".
       $this->val[$champ]."</textarea>";
   }else{
    echo "<textarea  name='".
       $champ."'  cols=".$this->taille[$champ].
       " rows=".$this->max[$champ]." onchange=\"".
       $this->onchange[$champ]."\" class='champFormulaire' disabled >".
       $this->val[$champ]."</textarea>";       
}}

// version 1.08 ********************************
// texteareamulti
// recuperation d une valeur dans un champ
// le champ d origine = $this->select[$champ][0]
// le champ d arrivé = $champ
// *********************************************

function textareamulti($champ,$validation,$DEBUG){
// colones = taille
// lignes = max
   if(!$this->correct) {
    echo "<input type='button' onclick='selectauto()' value='->' class='boutonmulti'> ";
    echo " <textarea  name='".
       $champ."'  cols=".$this->taille[$champ].
       " rows=".$this->max[$champ]." onchange=\"".
       $this->onchange[$champ]."\" class='champmulti' >".
       $this->val[$champ]."</textarea>";
   ?>
   <script type="text/javascript">
   function selectauto()
   {
   if(document.f1.<?php echo($champ);?>.value=="")
       document.f1.<?php echo($champ);?>.value=document.f1.<?php echo($this->select[$champ][0]);?>.value;
   else
       document.f1.<?php echo($champ);?>.value=document.f1.<?php echo($champ);?>.value+"\n"+document.f1.<?php echo($this->select[$champ][0]);?>.value;
       
   document.f1.<?php echo($this->select[$champ][0]);?>.value="";
   }
   </script>
   <?php
   }else{
    echo "<textarea  name='".
       $champ."'  cols=".$this->taille[$champ].
       " rows=".$this->max[$champ]." onchange=\"".
       $this->onchange[$champ]."\" class='champmulti' disabled >".
       $this->val[$champ]."</textarea>";       
}}
// ********************************************************
// date
// la date est saisie ou affichée sous le format JJ/MM/AAAA
// un calendrier s affiche en js
// ********************************************************
function date($champ,$validation,$DEBUG){
     if ($this->val[$champ]!="" and $validation==0){
         $this->val[$champ]=$this->dateAff($this->val[$champ]);
     }
 if(!$this->correct) {
      echo "<INPUT type='text' name='".$champ.
      "' value='".$this->val[$champ]."' size='".$this->taille[$champ].
       "' maxlength='10' onchange=\"".
      $this->onchange[$champ]."\" class='champFormulaire' >";
?>
<a href="javascript:vdate<?php echo($champ);?>();"><?php
 // * custom *
       if(file_exists("../dyn/custom/img/ico_calendrier.png")) {
          echo "<img src='../dyn/custom/img/ico_calendrier.png' align='middle' border='0' vspace='0' hspace='10'>";
       }
       else {
         echo "<img src='../img/calendrier.gif' align='middle' border='0' vspace='0' hspace='10'>";
       }
       //*
echo "</a>";
?>
<script language="javascript">
     var pfenetre;
     var fenetreouverte=false;
     function vdate<?php echo($champ);?>()
     {
     if(fenetreouverte==true)
       pfenetre.close();
       pfenetre=window.open("../spg/calendrier.php?origine=<?php echo($champ);?>","calendrier","width=310,height=230,top=120,left=120");
       fenetreouverte=true;
     }
</script>

<?php
echo "";
   }else{
        echo "<INPUT type='text' name=".$champ.
      "' value='".$this->val[$champ]."'  size='".$this->taille[$champ].
       "' maxlength='10'class='champFormulaire' disabled>";
  }
}

// ***************************************************************************
// SELECT
// affichage de table
//select['nomduchamp'][0]= value de l option
//$select['nomduchamp'][1]= affichage
// ****************************************************************************
function select($champ,$validation,$DEBUG){
   if(!$this->correct) {
     if($this->onchange[$champ]!="")
       echo "<select name='".$champ."'size='1' onchange=\"".$this->onchange[$champ]."\" class='champFormulaire' >";
     else
         echo "<select name='".$champ."'size='1' class='champFormulaire' >";
   }else
      echo "<select name='".$champ."'size='1' class='champFormulaire' disabled >";
   $k=0;
   foreach($this->select[$champ] as $elem)
     //  $nOption++;
        while ($k <count($elem)) {
          if(!$this->correct) {
               if ($this->val[$champ]==$this->select[$champ][0][$k])
                 echo "<option selected value=\"".$this->select[$champ][0][$k].
                 "\">".$this->select[$champ][1][$k]."</option>";
               else
                 echo "<option value=\"".$this->select[$champ][0][$k].
                 "\">".$this->select[$champ][1][$k]."</option>";
                 $k++;

          }else{
             if ($this->val[$champ]==$this->select[$champ][0][$k]){
                 echo "<option selected value=\"".$this->select[$champ][0][$k].
                 "\" >".$this->select[$champ][1][$k]."</option>";
                 $k =count($elem);
             }
          $k++;
          }
          }
   echo "</select>";

}

// *******************************
// select disabled
// affichage champ + lien mais pas
// modification de donnees  $val
// ********************************

function selectdisabled($champ,$validation,$DEBUG){
   echo "<select name='".$champ."'size='1' class='champFormulaire' disabled>";
   $k=0;
   foreach($this->select[$champ] as $elem)
     //  $nOption++;
        while ($k <count($elem)) {
          if(!$this->correct) {
               if ($this->val[$champ]==$this->select[$champ][0][$k])
                 echo "<option selected value=\"".$this->select[$champ][0][$k].
                 "\">".$this->select[$champ][1][$k]."</option>";
               $k++;
          }else{
             if ($this->val[$champ]==$this->select[$champ][0][$k]){
                 echo "<option selected value=\"".$this->select[$champ][0][$k].
                 "\" >".$this->select[$champ][1][$k]."</option>";
                 $k =count($elem);
             }
          $k++;
          }
          }
   echo "</select>";
}

// *****************************
// Text
// *****************************

function text($champ,$validation,$DEBUG){
 if(!$this->correct) {
    if ($this->onchange!=""){
       echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." onchange=\"".$this->onchange[$champ]."\" class='champFormulaire' >";
    }else{
      echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' >";
    }
   }else{
    echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' disabled>";
}}

// *****************************
// hidden
// *****************************

function hidden($champ,$validation,$DEBUG){
if(!$this->correct) {
    if ($this->onchange!=""){
       echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." onchange=\"".$this->onchange[$champ]."\" class='champFormulaire' >";
    }else{
      echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' >";
    }
   }else{
    echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' disabled>";
}}

// *****************************
// Password
// *****************************

function password($champ,$validation,$DEBUG){
if(!$this->correct) {
    if ($this->onchange!=""){
       echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." onchange=\"".$this->onchange[$champ]."\" class='champFormulaire' >";
    }else{
      echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' >";
    }
   }else{
    echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' disabled>";
}}

// *********************************
// textDisabled
// *********************************
function textdisabled($champ,$validation,$DEBUG){ // pas de passage de parametre
       echo "<INPUT type='text' name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." disabled class='champFormulaire'>";
       // echo "<INPUT type='hidden' name='".$this->nom[$champ]."' value=\"".$this->val[$champ]."\" class='champFormulaire' >";
}

// *****************************
// textreadonly
// champ texte non modifiable
// contribution de florian signoret
// *****************************

 

function textreadonly($champ,$validation,$DEBUG){// pas de passage de parametre
       echo "<INPUT type='text' name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." readonly class='champFormulaire'>";
}

 

// *****************************
// checkbox
// contribution de florian signoret
// *****************************

function checkbox($champ,$validation,$DEBUG){
if(!$this->correct) {
    if ($this->onchange!=""){
       echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"Oui\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." onchange=\"".$this->onchange[$champ]."\" class='champFormulaire'";
       if($this->val[$champ] == "Oui")
          echo "checked ";
       echo ">";
    }else{
      echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"Oui\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire'";
       if($this->val[$champ] == "Oui")
          echo "checked ";
       echo ">";
    }
   }else{
    echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"Oui\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' disabled ";
       if($this->val[$champ] == "Oui")
          echo "checked ";
       echo ">";
}}




// *****************************************************************************
// combo gauche
//(recherche de correspondance entre table importante)
//$select['code_departement_naissance'][0][0]="departement";// table
//$select['code_departement_naissance'][0][1]="code"; // zone origine
//$select['code_departement_naissance'][1][0]="libelle_departement"; // zone correl
//$select['code_departement_naissance'][1][1]="libelle_departement_naissance"; // champ correl
//(facultatif)
//$select['code_departement_naissance'][2][0]="code_departement"; // champ pour le where
//$select['code_departement_naissance'][2][1]="code_departement_naissance"; // zone du formulaire concerné
// ******************************************************************************
function comboG($champ,$validation,$DEBUG){
   if(!$this->correct){
      // zone libelle
       $tab=$this->select[$champ][0][0];
       $zorigine=$this->select[$champ][0][1];
       $zcorrel=$this->select[$champ][1][0];
       $correl=$this->select[$champ][1][1];
       if(isset($this->select[$champ][2][0])){
           $zcorrel2=$this->select[$champ][2][1];
           $correl2=$this->select[$champ][2][0];
       }else{
           $zcorrel2="s1"; // valeur du champ submit (sinon pb dans js)
           $correl2="";
       }

       if(file_exists("../dyn/custom/img/gauche.png")) {
          $tmp= "<img src='../dyn/custom/img/gauche.png' align='middle' border='0' vspace='0' hspace='0'>";
       }
       else {
          $tmp= "<img src='../img/gauche.gif' align='middle' border='0' vspace='0' hspace='0'>";
       }

echo "<a href='javascript:vcorrel2".$champ."();'>".$tmp."</a>";


?>
<script language="javascript">
    var pfenetre;
    var fenetreouverte=false;
function vcorrel2<?php echo($champ);?>()
{
if(fenetreouverte==true)
       pfenetre.close();
var rec=document.f1.<?php echo($champ);?>.value;
var temp="<?php echo($zcorrel2);?>";
if(temp=="s1"){
    var zcorrel2="";
    temp="s1";
}else
    var zcorrel2=document.f1.<?php echo($zcorrel2);?>.value;
pfenetre=window.open("../spg/combo.php?origine=<?php echo($champ);?>&recherche="+rec+"&table=<?php echo($tab);?>&correl=<?php echo($correl);?>&zorigine=<?php echo($zorigine);?>&zcorrel=<?php echo($zcorrel);?>&correl2=<?php echo($correl2);?>&zcorrel2="+zcorrel2,"Correspondance","width=600,height=300,top=120,left=120");
fenetreouverte=true;
}
</script>
<?php
       echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ].
       " onchange=\"".$this->onchange[$champ]."\" class='champFormulaire' >";
}else
 echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' disabled>";
}

// *****************************************************************************
// combo droit
//(recherche de correspondance entre table importante)
//$select['code_departement_naissance'][0][0]="departement";// table
//$select['code_departement_naissance'][0][1]="code"; // zone origine
//$select['code_departement_naissance'][1][0]="libelle_departement"; // zone correl
//$select['code_departement_naissance'][1][1]="libelle_departement_naissance"; // champ correl
//(facultatif)
//$select['code_departement_naissance'][2][0]="code_departement"; // champ pour le where
//$select['code_departement_naissance'][2][1]="code_departement_naissance"; // zone du formulaire concerné
// ******************************************************************************
function comboD($champ,$validation,$DEBUG){
    if($this->correct)
       echo "<INPUT type='".$this->type[$champ]."' name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size='".$this->taille[$champ].
       "' maxlength='".$this->max[$champ]."' class='champFormulaire' disabled>";
    else{
       echo "<INPUT type='".$this->type[$champ]."' name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size='".$this->taille[$champ].
       "' maxlength='".$this->max[$champ]."' onchange=\"".
       $this->onchange[$champ]."\" class='champFormulaire'>";
       $tab=$this->select[$champ][0][0];
       $zorigine=$this->select[$champ][0][1];
       $zcorrel=$this->select[$champ][1][0];
       $correl=$this->select[$champ][1][1];
       if(isset($this->select[$champ][2][0])){
           $zcorrel2=$this->select[$champ][2][1];
           $correl2=$this->select[$champ][2][0];
       }else{
           $zcorrel2="s1";  // valeur du champ submit (sinon pb dans js)
           $correl2="";
       }


       if(file_exists("../dyn/custom/img/droite.png")) {
          $tmp= "<img src='../dyn/custom/img/droite.png' align='middle' border='0' vspace='0' hspace='0'>";
       }
       else {
          $tmp= "<img src='../img/droite.gif' align='middle' border='0' vspace='0' hspace='0'>";
       }

echo "<a href='javascript:vcorrel".$champ."();'>".$tmp."</a>";
?><script language="javascript">
    var pfenetre;
    var fenetreouverte=false;
function vcorrel<?php echo($champ);?>()
{
if(fenetreouverte==true)
       pfenetre.close();
var rec=document.f1.<?php echo($champ);?>.value;
var temp="<?php echo($zcorrel2);?>";
if(temp=="s1"){
    var zcorrel2="";
    temp="s1";
}else
    var zcorrel2=document.f1.<?php echo($zcorrel2);?>.value;
pfenetre=window.open("../spg/combo.php?origine=<?php echo($champ);?>&recherche="+rec+"&table=<?php echo($tab);?>&correl=<?php echo($correl);?>&zorigine=<?php echo($zorigine);?>&zcorrel=<?php echo($zcorrel);?>&correl2=<?php echo($correl2);?>&zcorrel2="+zcorrel2,"Correspondance","width=600,height=300,top=120,left=120");
fenetreouverte=true;
}
</script>
<?php
}}

// ***************************************************************
// upload
// ***************************************************************

function upload($champ,$validation,$DEBUG){
 if(!$this->correct) {
      echo "<INPUT type='text' name='".$champ.
      "' value=\"".$this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." onchange=\"".
      $this->onchange[$champ]."\" class='champFormulaire' >";
?>
<a href="javascript:vupload<?php echo($champ);?>();"><?php
 // * custom *
       if(file_exists("../dyn/custom/img/upload.png")) {
          echo "<img src='../dyn/custom/img/upload.png' align='middle' border='0' vspace='0' hspace='10'>";
       }
       else {
         echo "<img src='../img/upload.gif'  align='middle' border='0' vspace='0' hspace='10'>";
       }
       //*
echo "</a>";
?>
<a href="javascript:voir<?php echo($champ);?>();"><?php
 // * custom *
       if(file_exists("../dyn/custom/img/voir.png")) {
          echo "<img src='../dyn/custom/img/voir.png' align='middle' border='0' vspace='0' hspace='0'>";
       }
       else {
         echo "<img src='../img/voir.jpg'  align='middle' border='0' vspace='0' hspace='0'>";
       }
       //*
echo "</a>";
?>
<script language="javascript">
     var pfenetre;
     var fenetreouverte=false;
function vupload<?php echo($champ);?>()
     {
     if(fenetreouverte==true)
       pfenetre.close();
       pfenetre=window.open("../spg/upload.php?origine=<?php echo($champ);?>","upload","width=300,height=100,top=120,left=120");
       fenetreouverte=true;
}
function voir<?php echo($champ);?>()
     {
     var fichier=document.f1.<?php echo($champ);?>.value;
     if (fichier == "") alert("zone vide");
     if(fenetreouverte==true)
       pfenetre.close();
       pfenetre=window.open("../spg/voir.php?fic="+fichier,"Visualisation","width=630,height=530,top=50,left=150,scrollbars=yes,resizable = yes");
       fenetreouverte=true;
}
</script>

<?php
echo "";
   }else{
        echo "<INPUT type='text' name='".$champ.
      "' value='".$this->val[$champ]."' size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' disabled>";
  }
}

// ***************************************************************
// voir
// ***************************************************************

function voir($champ,$validation,$DEBUG){
 if(!$this->correct) {
      echo "<INPUT type='text' name='".$champ.
      "' value=\"".$this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." onchange=\"".
      $this->onchange[$champ]."\" readonly class='champFormulaire' >";

?>
<a href="javascript:voir<?php echo($champ);?>();"><?php
 // * custom *
       if(file_exists("../dyn/custom/img/voir.png")) {
          echo "<img src='../dyn/custom/img/voir.png' align='middle' border='0' vspace='0' hspace='0'>";
       }
       else {
         echo "<img src='../img/voir.jpg'  align='middle' border='0' vspace='0' hspace='0'>";
       }
       //*
echo "</a>";
?>
<script language="javascript">
     var pfenetre;
     var fenetreouverte=false;

function voir<?php echo($champ);?>()
     {
     var fichier=document.f1.<?php echo($champ);?>.value;
     if (fichier == "") alert("zone vide");
     if(fenetreouverte==true)
       pfenetre.close();
       pfenetre=window.open("../spg/voir.php?fic="+fichier,"Visualisation","width=630,height=530,top=50,left=150,scrollbars=yes,resizable = yes");
       fenetreouverte=true;
}
</script>

<?php
echo "";
   }else{
        echo "<INPUT type='text' name='".$champ.
      "' value='".$this->val[$champ]."' size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' disabled>";
  }
}





// *****************************************************************************
// localisation
//$select['positiony'][0]="plan";// zone plan
//$select['positiony'][1]="positionx"; // zone coordonnées X
// ******************************************************************************
function localisation($champ,$validation,$DEBUG){
   if(!$this->correct){
       echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ].
       " onchange=\"".$this->onchange[$champ]."\" class='champFormulaire' >";
         // zone libelle
       $plan=$this->select[$champ][0][0];  // plan
       $positionx=$this->select[$champ][0][1];
       ?><a href="javascript:localisation<?php echo($champ);?>();"><?php
       // * custom *
       if(file_exists("../dyn/custom/img/localisation.png")) {
          echo "<img src='../dyn/custom/img/localisation.png' align='middle' border='0' vspace='0' hspace='10'>";
       }
       else {
         echo "<img src='../img/localisation.png' align='middle' border='0' vspace='0' hspace='10'>";
       }
       //*
       echo "</a>";
?><script language="javascript">
    var pfenetre;
    var fenetreouverte=false;
function localisation<?php echo($champ);?>()
{
if(fenetreouverte==true)
       pfenetre.close();
var plan=document.f1.<?php echo($plan);?>.value;
var x=document.f1.<?php echo($positionx);?>.value;
var y=document.f1.<?php echo($champ);?>.value;
pfenetre=window.open("../spg/localisation.php?positiony=<?php echo($champ);?>&positionx=<?php echo($positionx);?>&plan="+plan+"&x="+x+"&y="+y,"localisation","toolbar=no,scrollbars=yes,width=800,height=600,top=10,left=10");
fenetreouverte=true;
}
</script>
<?php
       }else
       echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' disabled>";
}

function rvb($champ,$validation,$DEBUG){
   if(!$this->correct){
       $this->val[$champ]=str_replace("\n","-",$this->val[$champ]);
       echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ].
       " onchange=\"".$this->onchange[$champ]."\" class='champFormulaire' >";
       ?><a href="javascript:rvb<?php echo($champ);?>();"><?php
       // * custom *
       if(file_exists("../dyn/custom/img/rvb.png")) {
          echo "<img src='../dyn/custom/img/rvb.png' align='middle' border='0' vspace='0' hspace='10'>";
       }
       else {
         echo "<img src='../img/rvb.png' align='middle' border='0' vspace='0' hspace='10'>";
       }
       //*
       echo "</a>";
?><script language="javascript">
    var pfenetre;
    var fenetreouverte=false;
function rvb<?php echo($champ);?>()
{
if(fenetreouverte==true)
       pfenetre.close();
//
var valeur=document.f1.<?php echo($champ);?>.value;
pfenetre=window.open("../spg/rvb.php?retour=<?php echo($champ);?>&valeur="+valeur,"rvb","width=450,height=450,resizable=1");

fenetreouverte=true;
}
</script>
<?php
       }else
       echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' disabled>";


}
// lien http en formulaire
// passage d argument sur une application tierce
function http($champ,$validation,$DEBUG){// pas de passage de parametre
       if(isset($this->select[$champ][0]))
           $aff=$this->select[$champ][0];
       else
           $aff=$champ;
       echo "<a href=\"".
       $this->val[$champ]."\"  target=\"_blank\">".$aff."</a>";
}

// lien http en formulaire
// passage d argument sur une application tierce
function httpclick($champ,$validation,$DEBUG){// pas de passage de parametre
       if(isset($this->select[$champ][0]))
           $aff=$this->select[$champ][0];
       else
           $aff=$champ;
       echo "<a href='#' onclick=\"".$this->val[$champ]."\" >".$aff."</a>";
}
// ===============================================================
// ENPIED
// ===============================================================

function enpied(){
echo "</table>";
}

// ===============================================================
// Recuperation des variables formulaires
// ===============================================================

function recupererPostvar($champs,$validation,$postVar,$DEBUG){
for($i=0;$i<count($champs);$i++){
     if ($validation>0){
        //  magic_quotes_gpc est initialisé dans php.ini (mise automatique de
        //  quote quand il y a un ", \ , '.
        if($this->type[$champs[$i]]!="textdisabled" and
         $this->type[$champs[$i]]!="static"){
        //and $this->type[$champs[$i]]!="checkbox"){
            if(isset($postVar[$champs[$i]])){
                if (!get_magic_quotes_gpc())  // magic_quotes_gpc = Off
                   $this->val[$champs[$i]] = strtr($postVar[$champs[$i]],chr(34),"'");
                else  // magic_quotes_gpc = On
                   $this->val[$champs[$i]] = strtr(stripslashes($postVar[$champs[$i]]),chr(34),"'");
            }else
                 $this->val[$champs[$i]] ="";

        }else
            $this->val[$champs[$i]] ="";

}}}


// ===============================================================
// AFFICHER TOUS LES CHAMPS
// ===============================================================

function afficher($champs,$validation,$DEBUG,$correct){
// $champs : libelle des champs à afficher
// $validation == 0 1er passage  / >0 passage suivant suite validation
// $postVar : Variables controle du formulaire
// $DEBUG initialiser en page php
$this->correct=$correct;

for($i=0;$i<count($champs);$i++){
        if (isset($this->regroupe[$champs[$i]]))
            $this->afficherChampRegroupe($champs[$i],$validation,$DEBUG);
        else
            $this->afficherChamp($champs[$i],$validation,$DEBUG);
        if ($DEBUG==1){
           echo $champs[$i]." ";
           echo $this->type[$this->champs[$i]]." ";
           echo $this->val[$this->champs[$i]]." ";
           echo $this->taille[$this->champs[$i]]." ";
           echo $this->max[$this->champs[$i]]." ";
           echo $this->lib[$this->champs[$i]]." ";
           echo $this->groupe[$this->champs[$i]]."<br>";
        }
}}




// ===============================================================
// ACCESSEURS
// ===============================================================

function setVal($champ,$contenu){
$this->val[$champ]=$contenu;
}

function setType($champ,$contenu){
/*
valeur de $type =============================================================
 text: saisie texte alpha numerique
 hidden: le champ est caché, le parametre est passé
 password: saisie masquée
 static : champ uniquement affiché
 date : saisie de date
 hiddenstatic champ affiché et passage du parametre
 select : zone de selection soit sur une autre table, soit p/r à un tableau
==============================================================================
*/
$this->type[$champ]=$contenu;
}

function setLib($champ,$contenu){
// libelle du formulaire
$this->lib[$champ]=$contenu;
}

function setMax($champ,$contenu){
// maximum autorise à la saisie
$this->max[$champ]=$contenu;
}

function setTaille($champ,$contenu){
// taille du controle
$this->taille[$champ]=$contenu;
}

function setSelect($champ,$contenu){
/*
GESTION DES TABLES ET PASSAGE DE PARAMETRES
valeur de $select ============================================================
TABLE ------------------------------------------------------------------------
select['nomduchamp'][0]= value de l option
$select['nomduchamp'][1]= affichage
COMBO (recherche de correspondance entre table importante)--------------------
$select['code_departement_naissance'][0][0]="departement";// table
$select['code_departement_naissance'][0][1]="code"; // zone origine
$select['code_departement_naissance'][1][0]="libelle_departement"; // zone correl
$select['code_departement_naissance'][1][1]="libelle_departement_naissance"; // champ correl
(facultatif)
$select['code_departement_naissance'][2][0]="code_departement"; // champ pour le where
$select['code_departement_naissance'][2][1]="code_departement_naissance"; // zone du formulaire concerné
TEXTAREAMULTI ----------------------------------------------------------------
select['nomduchamp'][0]=  nom du champ origine pour recuperer la valeur
-------------------------------------------------------------------------------
*/
$this->select[$champ]=$contenu;
}

function setOnchange($champ,$contenu){
// javascript
$this->onchange[$champ]=$contenu;
}

function setGroupe($champ,$contenu){
/*
valeur de $groupe =======================================================
 D premier champ du groupe
 G champ groupe
 F dernier champ du groupe
=========================================================================
*/
$this->groupe[$champ]=$contenu;
}

function setRegroupe($champ,$contenu,$libelle){
/*
valeur de $groupe =======================================================
 D premier champ du fieldset
 G champ dans le fieldset
 F dernier champ du fieldset
=========================================================================
*/
$this->regroupe[$champ][0]=$contenu;
$this->regroupe[$champ][1]=$libelle;
}


// ===============================================================
// Affichage de date suivant format de base de données
// ===============================================================

function dateAff($val) {
// ======================================================================
// Fonction de traitement de champ DATE
// suivant base de données
// parametre dans connexion.php  $formatDate
// ======================================================================

include ("../dyn/connexion.php");
if ($formatDate=="AAAA-MM-JJ"){
       $valTemp=explode("-",$val);
       return $valTemp[2]."/".$valTemp[1]."/".$valTemp[0];
}
if ($formatDate=="JJ/MM/AAAA"){
    return $val;
}
}
// ********************************************************
// yannick Bernard [mailto:yannick6259@gmail.com]
// Mail
// // envoie avec le logiciel de messagerie
// ********************************************************
function mail($champ,$validation,$DEBUG){
 if(!$this->correct) {
    if ($this->onchange!=""){
       echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." 
onchange=\"".$this->onchange[$champ]."\" class='champFormulaire' >";
    }else{
      echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' >";
    }
   }else{
    echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' 
disabled>";
}

$mail=$this->val[$champ];
 
echo "<a href='mailto:".$mail."'>";
 // * custom *
       if(file_exists("../dyn/custom/img/email-ch.png")) {
          echo "<img src='../dyn/custom/img/email-ch.png' align='middle' 
border='0' vspace='0' hspace='10'>";
       }
       else {
         echo "<img src='../img/email-ch.png' align='middle' border='0' 
vspace='0' hspace='10'>";
       }
       //*
echo "</a>";
}



} // fin de classe
?>