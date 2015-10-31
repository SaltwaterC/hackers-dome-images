<script language="javascript">
//declaration des fonctions java en debut de fichier pour implementation ajax grace a include
//sinon fonctions non visibles
     var pfenetre;
     var fenetreouverte=false;
     //date
    function vdate(champ)
    {
    if(fenetreouverte==true)
     pfenetre.close();
     pfenetre=window.open("../spg/calendrier.php?origine="+champ,"calendrier","width=310,height=230,top=120,left=120");
     fenetreouverte=true;
    }
    // date F2 ***
    function vdate2(champ)
    {
    if(fenetreouverte==true)
     pfenetre.close();
     pfenetre=window.open("../spg/calendrier2.php?origine="+champ,"calendrier2","width=310,height=230,top=120,left=120");
     fenetreouverte=true;
    }

    //textmultiarea
   function selectauto(champ,selection)
   {
   if(document.f1.elements[champ].value=="")
       document.f1.elements[champ].value=document.f1.elements[selection].value;
   else
       document.f1.elements[champ].value=document.f1.elements[champ].value+"\n"+document.f1.elements[selection].value;
       
   document.f1.elements[selection].value="";
   }
   //comboG comboD
    function vcorrel(champ,zcorrel2,params)
    {
    if(fenetreouverte==true)
           pfenetre.close();
    var rec=document.f1.elements[champ].value;
    var temp=zcorrel2;
    if(temp=="s1"){
        zcorrel2="";
        temp="s1";
    }else
        zcorrel2=document.f1.elements[zcorrel2].value;
    pfenetre=window.open("../spg/combo.php?origine="+champ+"&recherche="+rec+params+"&zcorrel2="+zcorrel2,"Correspondance","width=600,height=300,top=120,left=120");
    fenetreouverte=true;
    }
    // comboG2 et comboD2
    function vcorrel2(champ,zcorrel2,params)
    {
    if(fenetreouverte==true)
           pfenetre.close();
    var rec= document.f2.elements[champ].value;
    var temp=zcorrel2;
    if(temp=="s1"){
        zcorrel2="";
        temp="s1";
    }else
        zcorrel2=document.f2.elements[zcorrel2].value;
    pfenetre=window.open("../spg/combo2.php?origine="+champ+"&recherche="+rec+params+"&zcorrel2="+zcorrel2,"Correspondance","width=600,height=300,top=120,left=120");
    fenetreouverte=true;
    }
    //upload
    function vupload(champ) {
         if(fenetreouverte==true)
           pfenetre.close();
           pfenetre=window.open("../spg/upload.php?origine="+champ,"upload","width=300,height=100,top=120,left=120");
           fenetreouverte=true;
    }
    //upload
    function vupload2(champ) {
         if(fenetreouverte==true)
           pfenetre.close();
           pfenetre=window.open("../spg/upload2.php?origine="+champ,"upload2","width=300,height=100,top=120,left=120");
           fenetreouverte=true;
    }
    function voir(champ) {
         var fichier=document.f1.elements[champ].value;
         if (fichier == "") alert("zone vide");
         if(fenetreouverte==true)
           pfenetre.close();
           pfenetre=window.open("../spg/voir.php?fic="+fichier,"Visualisation","width=630,height=530,top=50,left=150,scrollbars=yes,resizable = yes");
           fenetreouverte=true;
    }
    function voir2(champ) {
         var fichier=document.f2.elements[champ].value;
         if (fichier == "") alert("zone vide");
         if(fenetreouverte==true)
           pfenetre.close();
           pfenetre=window.open("../spg/voir2.php?fic="+fichier,"Visualisation","width=630,height=530,top=50,left=150,scrollbars=yes,resizable = yes");
           fenetreouverte=true;
    }
    //localisation
    function localisation(champ,chplan,positionx) {
    if(fenetreouverte==true)
           pfenetre.close();
    var plan=document.f1.elements[chplan].value;
    var x=document.f1.elements[positionx].value;
    var y=document.f1.elements[champ].value;
    pfenetre=window.open("../spg/localisation.php?positiony="+champ+"&positionx="+positionx+"&plan="+plan+"&x="+x+"&y="+y,"localisation","toolbar=no,scrollbars=yes,width=800,height=600,top=10,left=10");
    fenetreouverte=true;
    }
    //rvb
    function rvb(champ) {
    if(fenetreouverte==true)
           pfenetre.close();
    //
    var valeur=document.f1.elements[champ].value;
    pfenetre=window.open("../spg/rvb.php?retour="+champ+"&valeur="+valeur,"rvb","width=450,height=450,resizable=1");
    
    fenetreouverte=true;
    }
   //selectlistemulti
   function refresh_ids(champ,champ3) {
     var tids=document.f1.elements[champ3];
     var lids=document.f1.elements[champ];
     tids.value="";
     if (lids.options.length>0) {
        for (i=0;i<lids.options.length;i++) 
          if (lids.options[i].value) tids.value+=lids.options[i].value+",";
        tids.value=tids.value.substring(0,tids.value.length-1);
     }
   }
   function addlist(champ,champ2,champ3) {
      var linst=document.f1.elements[champ2];
      var lids=document.f1.elements[champ];
      if (linst.selectedIndex>=0) {
        lids.options[lids.options.length]=new Option(linst.options[linst.selectedIndex].text,linst.options[linst.selectedIndex].value);  
        refresh_ids(champ,champ3);
      }
   }
   function removelist(champ,champ3) {
      var lids=document.f1.elements[champ];
      if (lids.selectedIndex>=0) {
        lids.remove(lids.selectedIndex);  
        refresh_ids(champ,champ3);
      }                    
   }
   function removealllist(champ,champ3) {
      var lids=document.f1.elements[champ];
      lids.options.length=0;
      refresh_ids(champ,champ3);
      document.f1.elements["_unselect+champ"].disabled=false;
      document.f1.elements["_select+champ"].disabled=false;
   }
   //checkbox
   function changevaluecheckbox(object) {
     if (object.value=="Oui")
       object.value="";
     else
       object.value="Oui";
   }
</script>
<?php
/* $Id: formulairedyn.class.php,v 1.1 2008-07-24 13:18:52 jbastide Exp $
http://www.openmairie.org
contact@openmairie.org

Cette classe a pour objet la construction des champs du formulaire
suivant
    - $type    (tableau) : type de champ
    - $val     (tableau) : valeur du champ
    - $taille  (tableau) : taille du champ
    - $max     (tableau) : saisie maximale autorisee pour le champ
    - $lib     (tableau) : libelle de saisie
    - $select  (tableau) : valeur des controles liste
                           [0] value
                           [1] libelle (<option>libelle</option>)
    - $groupe  (tableau) : regroupement de champ par ligne
    - $regroupe (tableau) : fieldset
    - $enteteTab (string): entete du formulaire
    */

/* maj et debug version 2.00 ---------------------------------------------------
 formulaire dynamique dans les onglets
 les fonctions javascript sont en entete
2.02 : \n pour debugage
------------------------------------------------------------------------------*/

class formulaire{

var $enteteTab;   // entete
var $val;         // valeur par defaut du champ
var $type;        // Type de champ
var $taille;      // taille du champ
var $max;         // nombre de caracteres maximum a saisir
var $lib;         // libelle du champ
var $groupe;      // regroupement
var $select;      // valeur des listes
var $onchange;    // javascrpt en cas de changement
var $onkeyup;    // javascrpt en cas de keyup Ajout
var $onclick;    // javascrpt en cas de clic Ajout
var $regroupe;    // fieldset
var $correct;



/* =======================================================================
Initialisation des tableaux de parametrage formulaire
- valeur par defaut
  en modification et suppression = initialiser par la valeur des champs
  en ajout = initialisation vide
- type par defaut
  text pour ajout et modification
  static pour suppression
======================================================================= */

function formulaire($a, $validation,$maj, $champs, $val,$max) {
         $this->enteteTab=$a;
         // valeur par defaut et type
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
             $this->onkeyup[$champs[$i]]=""; //Ajout
             $this->onclick[$champs[$i]]=""; //Ajout
         }
}


function entete(){
echo "\n<table class='formEntete' cellpadding=0>";
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
       echo "\n<td class='formLibelle'>" ;
   if($DEBUG==1){
   echo "<a href=# onclick=\"alert('Type :  ".$this->type[$champ].$rcjs.
        " Valeur par d�faut : ".$this->val[$champ].$rcjs.
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
   echo "</td>\n<td>";
}

// fonction suivant type du champ
$fonction=  $this->type[$champ];
if ($fonction=="static") $fonction="statiq"; // compatibilit�
$this->$fonction($champ,$validation,$DEBUG);

// gestion du groupe
if ($this->type[$champ]!="hidden"){
    if ($this->groupe[$champ]!="D" and $this->groupe[$champ]!="G")
         echo"</td>\n</tr>\n";
    }
}


// integration de fieldset + legend + table imbriqu�e
// 6 fevrier 2006
// dans var.inc les styles suivants sont � preciser
// - $style_tablefieldset
// - $style_legendfieldset
// - $style_fieldset
// cette solution plutot que css a ete mise en place
// car IE n accepte pas les class sur tables imbriqu�es

function afficherChampRegroupe($champ,$validation,$DEBUG){
$DEBUG=0;
$rcjs=chr(92)."r";
include("../dyn/var.inc");
// gestion du groupe
if ($this->type[$champ]!="hidden") {
  //if ($this->groupe[$champ]!="F" and $this->groupe[$champ]!="G"){
  if ($this->regroupe[$champ][0]=="D"){
    echo "<tr><td colspan='2'>" ;
  }
   if($DEBUG==1){
   echo "<a href=# onclick=\"alert('Type :  ".$this->type[$champ].$rcjs.
        " Valeur par d�faut : ".$this->val[$champ].$rcjs.
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
      echo "\n<fieldset style=".$style_fieldset."><legend style=".
      $style_legendfieldset.">".
      $this->regroupe[$champ][1].
      "</legend>\n<table style=".$style_tablefieldset."><tr>";
    }
    echo "<td>".$this->lib[$champ]."</td>\n<td>";
   }
}

// fonction suivant type du champ
$fonction=  $this->type[$champ];
if ($fonction=="static") $fonction="statiq"; // compatibilit�
$this->$fonction($champ,$validation,$DEBUG);
echo "</td>\n";
// gestion du groupe
if ($this->type[$champ]!="hidden"){
    if ($this->regroupe[$champ][0]=="F") {
      echo "</tr>\n</table>\n</fieldset>\n</td>\n</tr>\n";
      //echo "</tr></table></div></td></tr>";
      }
    if ($this->groupe[$champ]!="D" and $this->groupe[$champ]!="G")
        echo "\n</tr>\n<tr>";//echo "<br>";
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
       $this->val[$champ]."\" class='champFormulaire' >\n";
    echo $this->val[$champ]."";
}
// ***************************************************
// hiddenstaticnum
// la valeur du champ est passe par le controle hidden
// ***************************************************
function hiddenstaticnum($champ,$validation,$DEBUG){
    echo "<INPUT type='hidden' name='".$champ."' value=\"".
       $this->val[$champ]."\" class='champFormulaire' >\n";
    echo "<p align='right'>".$this->val[$champ]." </p>\n";
}
// ***************************************************
// textareahiddenstatic
// la valeur du champ n est pas passe
// affichage du champ en texte
// ***************************************************
function textareahiddenstatic($champ,$validation,$DEBUG){
    echo "<INPUT type='hidden' name='".$champ."' value=\"".
       $this->val[$champ]."\" class='champFormulaire' >\n";
    $this->val[$champ] = str_replace("\n","<br>",$this->val[$champ]);
    echo $this->val[$champ]."\n";
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
      $defautDate."\" class='champFormulaire' >\n";
      echo $defautDate."";
}else{
      echo $this->val[$champ]."\n";
}
}

// ***************************************************
// Static
// la valeur du champ n'est pas conserv�e
// ***************************************************
function statiq($champ,$validation,$DEBUG){
echo "".$this->val[$champ]."\n";
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
       $this->val[$champ]."</textarea>\n";
   }else{
    echo "<textarea  name='".
       $champ."'  cols=".$this->taille[$champ].
       " rows=".$this->max[$champ]." onchange=\"".
       $this->onchange[$champ]."\" class='champFormulaire' disabled >".
       $this->val[$champ]."</textarea>\n";
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
       $this->val[$champ]."</textarea>\n";
   }else{
    echo "<textarea  name='".
       $champ."'  cols=".$this->taille[$champ].
       " rows=".$this->max[$champ]." onchange=\"".
       $this->onchange[$champ]."\" class='champFormulaire' disabled >".
       $this->val[$champ]."</textarea>\n";
}}

// version 1.08 ********************************
// texteareamulti
// recuperation d une valeur dans un champ
// le champ d origine = $this->select[$champ][0]
// le champ d arriv� = $champ
// *********************************************

function textareamulti($champ,$validation,$DEBUG){
// colones = taille
// lignes = max
   if(!$this->correct) {
    echo "<input type='button' onclick=\"selectauto('".$champ."','".
         $this->select[$champ][0]."')\" value='->' class='boutonmulti'>\n ";
    echo " <textarea  name='".
       $champ."'  cols=".$this->taille[$champ].
       " rows=".$this->max[$champ]." onchange=\"".
       $this->onchange[$champ]."\" class='champmulti' >".
       $this->val[$champ]."</textarea>\n";
   }else{
    echo "<textarea  name='".
       $champ."'  cols=".$this->taille[$champ].
       " rows=".$this->max[$champ]." onchange=\"".
       $this->onchange[$champ]."\" class='champmulti' disabled >".
       $this->val[$champ]."</textarea>\n";
}}
// ********************************************************
// date
// la date est saisie ou affichee sous le format JJ/MM/AAAA
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
      $this->onchange[$champ]."\" class='champFormulaire' >\n";
      echo "<a href=\"javascript:vdate('".$champ."');\">\n";
      echo "<img src='../img/calendrier.gif' align='middle' border='0' vspace='0' hspace='10'>\n";
      echo "</a>\n";
//fonction java vdate en debut de fichier
echo "";
   }else{
        echo "<INPUT type='text' name=".$champ.
      "' value='".$this->val[$champ]."'  size='".$this->taille[$champ].
       "' maxlength='10'class='champFormulaire' disabled>\n";
  }
}
// ********************************************************
// date  en F2 (full onglet)
// la date est saisie ou affichee sous le format JJ/MM/AAAA
// un calendrier s affiche en js
// ********************************************************
function date2($champ,$validation,$DEBUG){
     if ($this->val[$champ]!="" and $validation==0){
         $this->val[$champ]=$this->dateAff($this->val[$champ]);
     }
 if(!$this->correct) {
      echo "<INPUT type='text' name='".$champ.
      "' value='".$this->val[$champ]."' size='".$this->taille[$champ].
       "' maxlength='10' onchange=\"".
      $this->onchange[$champ]."\" class='champFormulaire' >";
      echo "<a href=\"javascript:vdate2('".$champ."');\">\n";
      echo "<img src='../img/calendrier.gif' align='middle' border='0' vspace='0' hspace='10'>";
      echo "</a>\n";
      //fonction java vdate en debut de fichier
      echo "";
   }else{
        echo "<INPUT type='text' name=".$champ.
      "' value='".$this->val[$champ]."'  size='".$this->taille[$champ].
       "' maxlength='10'class='champFormulaire' disabled>\n";
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
       echo "<select name='".$champ."'size='1' onchange=\"".$this->onchange[$champ]."\" class='champFormulaire' >\n";
     else
         echo "<select name='".$champ."'size='1' class='champFormulaire' >\n";
   }else
      echo "<select name='".$champ."'size='1' class='champFormulaire' disabled >\n";
   $k=0;
   foreach($this->select[$champ] as $elem)
     //  $nOption++;
        while ($k <count($elem)) {
          if(!$this->correct) {
               if ($this->val[$champ]==$this->select[$champ][0][$k])
                 echo "\t<option selected value=\"".$this->select[$champ][0][$k].
                 "\">".$this->select[$champ][1][$k]."</option>\n";
               else
                 echo "\t<option value=\"".$this->select[$champ][0][$k].
                 "\">".$this->select[$champ][1][$k]."</option>\n";
                 $k++;

          }else{
             if ($this->val[$champ]==$this->select[$champ][0][$k]){
                 echo "\t<option selected value=\"".$this->select[$champ][0][$k].
                 "\" >".$this->select[$champ][1][$k]."</option>\n";
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
   echo "<select name='".$champ."'size='1' class='champFormulaire' disabled>\n";
   $k=0;
   foreach($this->select[$champ] as $elem)
     //  $nOption++;
        while ($k <count($elem)) {
          if(!$this->correct) {
               if ($this->val[$champ]==$this->select[$champ][0][$k])
                 echo "\t<option selected value=\"".$this->select[$champ][0][$k].
                 "\">".$this->select[$champ][1][$k]."</option>\n";
               $k++;
          }else{
             if ($this->val[$champ]==$this->select[$champ][0][$k]){
                 echo "\t<option selected value=\"".$this->select[$champ][0][$k].
                 "\" >".$this->select[$champ][1][$k]."</option>\n";
                 $k =count($elem);
             }
          $k++;
          }
        }
   echo "</select>\n";
}

// *****************************
// Text
// *****************************

function text($champ,$validation,$DEBUG){
  //ajout evenements onkeyup et onclick
 if(!$this->correct) {
   echo "<INPUT type=".$this->type[$champ]." name='".
   $champ."' value=\"".
   $this->val[$champ]."\" size=".$this->taille[$champ].
   " maxlength=".$this->max[$champ]." class='champFormulaire' ";
   if ($this->onchange!="")
       echo "onchange=\"".$this->onchange[$champ]."\" ";
   if ($this->onkeyup!="")
       echo "onkeyup=\"".$this->onkeyup[$champ]."\" ";
   if ($this->onclick!="")
       echo "onclick=\"".$this->onclick[$champ]."\" ";
   echo ">\n";
 }else{
    echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' disabled>\n";
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
       " maxlength=".$this->max[$champ]." onchange=\"".$this->onchange[$champ]."\" class='champFormulaire' >\n";
    }else{
      echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' >\n";
    }
   }else{
    echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' disabled>\n";
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
       " maxlength=".$this->max[$champ]." onchange=\"".$this->onchange[$champ].
       "\" class='champFormulaire' >\n";
    }else{
      echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' >\n";
    }
   }else{
    echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' disabled>\n";
}}

// *********************************
// textDisabled
// *********************************
function textdisabled($champ,$validation,$DEBUG){ // pas de passage de parametre
       echo "<INPUT type='text' name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." disabled class='champFormulaire'>\n";
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
       " maxlength=".$this->max[$champ]." readonly class='champFormulaire'>\n";
}

 

// *****************************
// checkbox
// contribution de florian signoret
// *****************************

function checkbox($champ,$validation,$DEBUG){ //051207
if($this->val[$champ] == "Oui") {
    $value = "Oui";
    $checked = "checked ";
} else {
    $value = "";
    $checked = "";
}
if(!$this->correct) {
    if ($this->onchange!=""){
       echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"$value\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." onchange=\"changevaluecheckbox(this);".
       $this->onchange[$champ]."\" class='champFormulaire'";
       echo $checked;
       echo ">\n";
    }else{
      echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"$value\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ].
       " onchange=\"changevaluecheckbox(this)\" class='champFormulaire'";
       echo $checked;
       echo ">\n";
    }
   }else{
    echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"$value\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ].
       " onchange=\"changevaluecheckbox(this)\" class='champFormulaire' disabled ";
       echo $checked;
       echo ">\n";
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
//$select['code_departement_naissance'][2][1]="code_departement_naissance"; // zone du formulaire concern�
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
       $tmp= "<img src='../img/gauche.gif' align='middle' border='0' vspace='0' hspace='2'>";
$params="&table=".$tab."&correl=".$correl."&zorigine=".$zorigine."&zcorrel=".$zcorrel."&correl2=".$correl2;
echo "<a href=\"javascript:vcorrel('".$champ."','".$zcorrel2."','".$params."');\">".$tmp."</a>\n";

       echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ].
       " onchange=\"".$this->onchange[$champ]."\" class='champFormulaire' >\n";
}else
 echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' disabled>\n";
}

function comboG2($champ,$validation,$DEBUG){
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
          $tmp= "<img src='../img/gauche.gif' align='middle' border='0' vspace='0' hspace='2'>\n";
$params="&table=".$tab."&correl=".$correl."&zorigine=".$zorigine."&zcorrel=".$zcorrel."&correl2=".$correl2;
// appel vcorrel2
echo "<a href=\"javascript:vcorrel2('".$champ."','".$zcorrel2."','".$params."');\">".$tmp."</a>";
       echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ].
       " onchange=\"".$this->onchange[$champ]."\" class='champFormulaire' >\n";
}else
 echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' disabled>\n";
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
//$select['code_departement_naissance'][2][1]="code_departement_naissance"; // zone du formulaire concern�
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
       $tmp= "<img src='../img/droite.gif' align='middle' border='0' vspace='0' hspace='2'>";

$params="&table=".$tab."&correl=".$correl."&zorigine=".$zorigine."&zcorrel=".$zcorrel."&correl2=".$correl2;
echo "<a href=\"javascript:vcorrel('".$champ."','".$zcorrel2."','".$params."');\">".$tmp."</a>\n";
}}

// combo D2 pour F2 (sousformdyn)

function comboD2($champ,$validation,$DEBUG){
    if($this->correct)
       echo "<INPUT type='".$this->type[$champ]."' name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size='".$this->taille[$champ].
       "' maxlength='".$this->max[$champ]."' class='champFormulaire' disabled>\n";
    else{
       echo "<INPUT type='".$this->type[$champ]."' name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size='".$this->taille[$champ].
       "' maxlength='".$this->max[$champ]."' onchange=\"".
       $this->onchange[$champ]."\" class='champFormulaire'>\n";
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
       $tmp= "<img src='../img/droite.gif' align='middle' border='0' vspace='0' hspace='2'>";
$params="&table=".$tab."&correl=".$correl."&zorigine=".$zorigine."&zcorrel=".$zcorrel."&correl2=".$correl2;
// appel vcorrel2
echo "<a href=\"javascript:vcorrel2('".$champ."','".$zcorrel2."','".$params."');\">".$tmp."</a>\n";
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

echo "<a href=\"javascript:vupload('".$champ."');\">";
echo "<img src='../img/upload.gif'  align='middle' border='0' vspace='0' hspace='10'>";
echo "</a>\n";
echo "<a href=\"javascript:voir('".$champ."');\">\n";
echo "<img src='../img/voir.jpg'  align='middle' border='0' vspace='0' hspace='0'>";
echo "</a>\n";
echo "";
   }else{
        echo "<INPUT type='text' name='".$champ.
      "' value='".$this->val[$champ]."' size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' disabled>\n";
  }
}
 function upload2($champ,$validation,$DEBUG){
 if(!$this->correct) {
      echo "<INPUT type='text' name='".$champ.
      "' value=\"".$this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." onchange=\"".
      $this->onchange[$champ]."\" class='champFormulaire' >\n";

echo "<a href=\"javascript:vupload2('".$champ."');\">\n";
echo "<img src='../img/upload.gif'  align='middle' border='0' vspace='0' hspace='10'>";
echo "</a>\n";

echo "<a href=\"javascript:voir2('".$champ."');\">";
echo "<img src='../img/voir.jpg'  align='middle' border='0' vspace='0' hspace='0'>";
echo "</a>\n";
echo "";
   }else{
        echo "<INPUT type='text' name='".$champ.
      "' value='".$this->val[$champ]."' size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' disabled>\n";
  }
}
// *****************************************************************************
// localisation
//$select['positiony'][0]="plan";// zone plan
//$select['positiony'][1]="positionx"; // zone coordonn�es X
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
       echo "<a href=\"javascript:localisation('".$champ."','".$plan."','".$positionx."');\">";
       echo "<img src='../img/localisation.png' align='middle' border='0' vspace='0' hspace='10'>";
       echo "</a>";
       }else
       echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' disabled>\n";
}

function rvb($champ,$validation,$DEBUG){
   if(!$this->correct){
       $this->val[$champ]=str_replace("\n","-",$this->val[$champ]);
       echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ].
       " onchange=\"".$this->onchange[$champ]."\" class='champFormulaire' >";
       echo "<a href=\"javascript:rvb('".$champ."');\">";
       echo "<img src='../img/rvb.png' align='middle' border='0' vspace='0' hspace='10'>";
       echo "</a>\n";
       }else
       echo "<INPUT type=".$this->type[$champ]." name='".
       $champ."' value=\"".
       $this->val[$champ]."\" size=".$this->taille[$champ].
       " maxlength=".$this->max[$champ]." class='champFormulaire' disabled>\n";
}
// lien http en formulaire
// passage d argument sur une application tierce
function http($champ,$validation,$DEBUG){// pas de passage de parametre
       if(isset($this->select[$champ][0]))
           $aff=$this->select[$champ][0];
       else
           $aff=$champ;
       echo "<a href=\"".
       $this->val[$champ]."\"  target=\"_blank\">".$aff."</a>\n";
}

// lien http en formulaire
// passage d argument sur une application tierce
function httpclick($champ,$validation,$DEBUG){// pas de passage de parametre
       if(isset($this->select[$champ][0]))
           $aff=$this->select[$champ][0];
       else
           $aff=$champ;
       echo "<a href='#' onclick=\"".$this->val[$champ]."\" >".$aff."</a>\n";
}
// ===============================================================
// ENPIED
// ===============================================================

function enpied(){
echo "</table>\n";
}

// ===============================================================
// Recuperation des variables formulaires
// ===============================================================

function recupererPostvarsousform($champs,$validation,$postVar,$DEBUG){
  for($i=0;$i<count($champs);$i++){
    if ($validation>0){
      //  magic_quotes_gpc est initialise dans php.ini (mise automatique de
      //  quote quand il y a un ", \ , '.
      if($this->type[$champs[$i]]!="textdisabled" and $this->type[$champs[$i]]!="static" and array_key_exists($champs[$i],$postVar)){
        if (!get_magic_quotes_gpc()) { // magic_quotes_gpc = Off
          $this->val[$champs[$i]] = strtr($postVar[$champs[$i]],chr(34),"'");
        }else{  // magic_quotes_gpc = On
          $this->val[$champs[$i]] = strtr(stripslashes($postVar[$champs[$i]]),chr(34),"'");
        }
      }else
        $this->val[$champs[$i]] ="";
      $this->val[$champs[$i]] = utf8_decode($this->val[$champs[$i]]);
    } //else  //validation=0
  }
}

function recupererPostvar($champs,$validation,$postVar,$DEBUG){ //ajout test si variable postée existe
for($i=0;$i<count($champs);$i++){                               //avant affectation à $this->val[$champs[$i]]
     if ($validation>0){
        //  magic_quotes_gpc est initialise dans php.ini (mise automatique de
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
// $champs : libelle des champs � afficher
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
           echo $this->groupe[$this->champs[$i]]."<br>\n";
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
 hidden: le champ est cach�, le parametre est pass�
 password: saisie masqu�e
 static : champ uniquement affich�
 date : saisie de date
 hiddenstatic champ affich� et passage du parametre
 select : zone de selection soit sur une autre table, soit p/r � un tableau
==============================================================================
*/
$this->type[$champ]=$contenu;
}

function setLib($champ,$contenu){
// libelle du formulaire
$this->lib[$champ]=$contenu;
}

function setMax($champ,$contenu){
// maximum autorise � la saisie
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
$select['code_departement_naissance'][2][1]="code_departement_naissance"; // zone du formulaire concern�
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
// Affichage de date suivant format de base de donn�es
// ===============================================================

function dateAff($val) {
// ======================================================================
// Fonction de traitement de champ DATE
// suivant base de donnees
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

// ***************************************************************************
// SELECTLISTE (liste)
// affichage de table
//select['nomduchamp'][0]= value de l option
//select['nomduchamp'][1]= affichage
// ****************************************************************************
function selectliste($champ,$validation,$DEBUG){
  if(!$this->correct) {
    echo "<select name='".$champ."' size='".$this->taille[$champ].
       "' class='champFormulaire' ";
    if($this->onchange[$champ]!="")
      echo "onchange=\"".$this->onchange[$champ]."\" ";  
    if($this->onclick[$champ]!="")
      echo "onclick=\"".$this->onclick[$champ]."\" ";  
    echo ">";
   }else
      echo "<select name='".$champ."' size='".$this->taille[$champ].
       "' class='champFormulaire' disabled >";
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

// ***************************************************************************
// SELECTLISTEMULTI (liste)
// affichage de table
//select['nomduchamp'][0]= value de l option
//select['nomduchamp'][1]= affichage
//select['nomduchamp'][2]= autre select dont la value peut etre ajoutée
//select['nomduchamp'][3]= champ caché des values ajoutées ex: 45,12,32
// ****************************************************************************
function selectlistemulti($champ,$validation,$DEBUG){
// colones = taille
// lignes = max
   echo "<table><tr><td>";
   if(!$this->correct) {
    $champ2=$this->select[$champ][2];
    $champ3=$this->select[$champ][3];
    echo "<table border=1 ><tr><td>";
    echo "<input type='button' name='_select$champ' onclick='addlist(\"$champ\",\"$champ2\",\"$champ3\")' value='->' class='boutonmulti'> ";
    echo "</td></tr><tr><td>";
    echo "<input type='button' name='_unselect$champ' onclick='removelist(\"$champ\",\"$champ3\")' value='<-' class='boutonmulti'> ";
    echo "</td></tr><tr><td>";
    echo "<input type='button' name='_unselectall$champ' onclick='removealllist(\"$champ\",\"$champ3\")' value='<<' class='boutonmulti'> ";
//    echo "</td></tr><tr><td>";
//    echo "<input type='button' name='_selectall$champ' onclick='addalllist(\"$champ\",\"$champ2\")' value='>>' class='boutonmulti'> ";
    echo "</td></tr></table></td><td>";
    echo "<select name='".$champ."' size='".$this->taille[$champ].
       "' class='champFormulaire' ";
    if($this->onchange[$champ]!="")
      echo "onchange=\"".$this->onchange[$champ]."\" ";  
    if($this->onclick[$champ]!="")
      echo "onclick=\"".$this->onclick[$champ]."\" ";  
    echo ">";
   }else 
      echo "<select name='".$champ."' size='".$this->taille[$champ].
       "' class='champFormulaire' disabled >";
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
/*   ?>
   <script type="text/javascript">
   </script>
   <?php */
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
   echo "</td></tr></table>";
}

function setOnkeyup($champ,$contenu){
// javascript
$this->onkeyup[$champ]=$contenu;
}

function setOnclick($champ,$contenu){
// javascript
$this->onclick[$champ]=$contenu;
}

} // fin de classe
?>