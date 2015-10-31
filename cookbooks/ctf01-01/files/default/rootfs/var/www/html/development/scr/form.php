<?php 
//$Id: form.php,v 1.8 2008-09-01 06:53:05 jbastide Exp $
/*
tab.php (appel) -> form.php (onglet 1)
                -> soustabdyn.php (onglet 2 à n)-> sousformdyn.php
*** variables
** get
* formulaire
$obj = objet form
$idx = identifiant de l instance obj (en creation = "[")
$idz = libelle fixe de l instance obj
$validation = 0 (formulaire non validé) >0 (formulaire validé)
$premier = numero du premier enregistrement en retour tab.php
$recherche = recherche dans tab.php
$recherche1 / soustabdyn.php
$tricol = colone de tri dans tab.php
* sql/ ... /".$obj.".inc"
$champaffiche[0] = champ cle primaire formulaire
$sousformulaire(array) (tableau des sousformulaires a afficher)
* obj/$obj.class.php
$enr->correct=1 (1 = saisie formulaire correct / 0 sinon)
$enr->valF[$enr->table] valorisation $idx en ajout
$enr->msg  message d erreur
(attention la cle doit avoir le même nom que la table)
* sous formulaire
$objsf = objet sous formulaire courant
$premiersf = numero du premier enregistrement
$tricolsf =  colone de tri dans soustabdyn.php
** session
profil = profil de l utilisateur - droit d acces
** autres
$DEBUG =0 =1 mode debug
$champidx = traitement $champaffiche (problème du as)
$maj =0 (ajout) = 1 (modification) = 2 (suppression)
*** passage de variable HTML -> javascript
<objet> variable onglet en cours
<recherchedyn> variable recherche en cours
*** tabdyn.class.php  méthode paginationOnglet
Variables de navigation : passage par controle html
suivant.value
retour.value
page.value
*** zone d affichage  HTML
<objet_onglet>  formulaire
<recherche_onglet> recherche dans les soustabdyn
<soustab> positionnement des onglets
<sousform> sous formulaire courant
*** php.ini
magic_quotes_gpc = on ou off
*** dyn/var.inc
$path_om : acces au module openMairie

// correction tricol en sous form
================================================================================
                          english translation
================================================================================
tab.php (call) -> form.php (tab 1)
                -> soustabdyn.php (tab 2 to n)-> sousformdyn.php
*** variables
** get
* form
$obj = object form
$idx = identifier of instancie obj (add = "[")
$idz = fix wording of instancie obj
$validation = 0 (form not validate) >0 (form validate)
$premier = number of first registry in return tab.php
$recherche = saerch in tab.php
$recherche1 / soustabdyn.php
$tricol = sort column in  tab.php
* sql/ ... /".$obj.".inc"
$champaffiche[0] = field form primary key
$sousformulaire(array) (sub form array to display)
* obj/$obj.class.php
$enr->correct=1 (1 = form saisure  correct / 0 if not)
$enr->valF[$enr->table] value $idx in add
$enr->msg  error message
(be carrefull the primary key has the same name that the table)
* sub form
$objsf = current sub form object
$premiersf =  number of the first record to display
$tricolsf =  sort column in soustabdyn.php
** session
profil = user profil - acess right
** other
$DEBUG =0 =1 debug mode
$champidx = treatment $champaffiche (problem sql  "as")
$maj =0 (add) = 1 (modify) = 2 (delete)
*** variable passage  HTML -> javascript
<objet> current variable tab
<recherchedyn> current variable search
*** tabdyn.class.php  method paginationOnglet
Navigation variable: passage with html control
suivant.value
retour.value   return
page.value
*** display zone  HTML
<objet_onglet>  form
<recherche_onglet> search in soustabdyn
<soustab> position of tab
<sousform> current sub form
*** php.ini
magic_quotes_gpc = on ou off
*** dyn/var.inc
$path_om : access openMairie
 */

/* DEBUG
* message de fin car session profil isset ne peux pas etre
atteint car retour connexion
* entete_tab ?
* traduire
    Votre profil est
    msg=formulaire 
* fonction setfocus()
* pourquoi y a til 2 fonction deconnexion ?
* pourquoi il y a 5 /div sous menu
*/


// ===============
// *** include ***
// ===============
if (file_exists ("../dyn/session.inc"))
        include ("../dyn/session.inc");
// profil utilisateur [user profile]
// reconnexion si variable session non definie
// [reconnection if undefined session]
if(!isset($_SESSION['profil']))
    header('location:../index.php?msg=formulaire '.$obj);
if (file_exists ("../dyn/var.inc"))
        include ("../dyn/var.inc");
if (file_exists ("../scr/lang.inc"))
        include ("../scr/lang.inc");
if (file_exists ("../obj/utils.class.php"))
        include ("../obj/utils.class.php");
// ===============================================
// *** variables programmes  [program variable]***
// ===============================================
$DEBUG = 0;
// ===========
// *** GET ***
// ===========
// Objet métier form  [object form]
if (isset ($_GET ['obj']))
    $obj = $_GET ['obj'];
else
    $obj = "";
// Objet metier soustab  [subtab object form]
if (isset ($_GET ['objsf']))
    $objsf = $_GET ['objsf'];
else
    $objsf = "";
// Premier enregistrement a afficher [first record to display]
if (isset ($_GET ['premier']))
    $premier = $_GET ['premier'];
else
    $premier = 0;
// Premier enregistrement a afficher soustab [first record to display]
if (isset ($_GET ['premiersf']))
    $premiersf = $_GET ['premiersf'];
else
    $premiersf = 0;
// Recherche & gestion des quotes  [search and magic quote]
if (isset ($_GET ['recherche'])){
    $recherche = $_GET ['recherche'];
    if (get_magic_quotes_gpc ()) // magic_quotes_gpc = on
        $recherche = StripSlashes ($recherche);
}else{
    $recherche = "";
}
// recherche1 [search]
if (!isset ($recherche1))
    $recherche1 = "";
// tri form  [form sort]
if(isset($_GET['tri']))
    $tricol=$_GET['tri'];
else
    $tricol="";
// tri sous form  [sub form sort]
if(isset($_GET['trisf']))
    $tricolsf=$_GET['trisf'];
else
    $tricolsf="";
// identifiant enregistrement form [identifier form record]
if (!isset ($table))
    $table = "";
// libelle enregistrement form  [wording form record]
if (isset ($_GET ['idz'])){
    $idz=$_GET ['idz'];
}else{
    $idz="";
}
// evaluation maj  [maj value]
if (isset ($_GET ['idx'])){
    $idx = $_GET ['idx'];
    if (isset ($_GET ['ids']))    {
    //    $enteteTab = "Table ".$table." Suppression";
        $maj = 2;
    }else{
    //    $enteteTab = "Table ".$table." Modification";
        $maj = 1;
    }
}else{
    $maj=0;
    $idx="]";
    //if (isset($_GET['validation']))
    //    $enteteTab = "Table ".$table." Validation";
    //else
    //    $enteteTab = "Table ".$table." Ajout";
}
// validation
if (isset ($_GET ['validation']))
    $validation = $_GET ['validation'];
else
    $validation = 0;
//==============================================================================
//$enteteTab :ne sert a rien method entete de formulaire
//        message erreur "Notice: Undefined variable: enteteTab
//        in c:\easyphp1-7\www\openexemple\openmairie_exemple\scr\form.php"
//        ligne $enr -> formulaire ($enteteTab,............)
//         => declaration $enteteTab  vide ICI  ( A VOIR  )
//------------------------------------------------------------------------------
//       $enteteTab  passe en parametre : dbformdyn.class.php et dbform.class
//       ( function formulaire et sousformulaire )
//==============================================================================
$enteteTab="";
// ===========
// include obj
// ===========
include ("../obj/".$obj.".class.php");
// Classe utils ()
$f = new utils ();
// Fichier de parametrage  [files paramters]
if (file_exists ("../sql/".$f -> phptype."/".$obj.".inc"))
        include ("../sql/".$f -> phptype."/".$obj.".inc");
// html + head
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" lang=\"fr\">\n";
echo "\t<head>\n";
echo "\t\t<meta http-equiv=\"Content-Type\" content=\"text/html;charset=iso-8859-1\" />\n";
echo "\t\t<title>".$f -> lang("title_html")."</title>\n";
echo "\t\t<link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"../img/favicon.ico\" />\n";
echo "\t\t<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"../dyn/style.css\" />\n";
echo "\t\t<link rel=\"stylesheet\" type=\"text/css\" media=\"print\" href=\"../dyn/print.css\" />\n";
echo "\t\t<script type=\"text/javascript\" src=\"../dyn/script_".$langue.".js\"></script>\n";
echo "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"../dyn/menu.css\" />\n";
echo "\t\t<script type=\"text/javascript\" src=\"../dyn/menu.js\"></script>\n";
echo "\t</head>\n";
// ================================================================
// activation de la fonction javascript au chargement
// [activate the javascript function]
//   cas 1 : il y a un sous formulaire et il y a une page sous form
//   cas 2 : il y a un sous formulaire
//   cas 3 : il n y a pas de sous formulaire
// ================================================================
if ($objsf)
   if ($premiersf)
      echo "<body onload=\"bodyload('".$objsf."',".
      $premiersf.")\">\n";
   else
       echo "<body onload=\"bodyload('".$objsf."',0)\">\n";
else
    echo "<body onload=\"bodyload('".$obj."',0)\">\n";
// ===============================================================
// util.class.php : methodes collectivite, droit, header [methods]
// ===============================================================
$f -> collectivite ();
$f -> droit ($obj);
$f -> header (1, $ent, $ico, $obj);
// champidx ================================================================
// Valorisation de champidx = 1er champ de $champaffiche
// recuperer nom du champ de formulaire qui contient la valeur de l idx pour
// affichage des sous formulaires (ajout valide)
// Traitement du "as" : enlever " as ..." si present
// [value of champidx with the array $champaffiche first field
//  when the adding is validate - treatment of the sql "as"]
// =========================================================================
$champidx = $champAffiche [0];
$champidx = split (" ", $champidx);  //
$champidx = $champidx [0];
// function javascript =========================================================
// *** bodyload -> activer
// *** activer :
//  -  si on est dans form -> recherche non affichée <recherche_onglet> -> afficheTab=0
//                  sinon  -> formulaire non affiché <objet_onglet>-> afficheTab = 1
//  - si afficheTab = 1 appel de soustabdyn.hp
//                      et affichage du sousformulaire dans <objet>
// *** afficherfom et afficherformajout (valeur de l idx dans $champidx.value)
//      recharge la page si il est cliquer sur l onglet form
//      permet d avoir les saisies à jour dans le formulaire prinsipal
//      si saisie en sous formulaire
//      -> bodyload -> activer
// *** afficher sousform : affichage du sous formulaire
//       appel sousformdyn.php
// *** suivant, precedent, allerpage, recherche, trier
//     navigation en soustabdyn.php -> voir tab.class.php ou tabdyn.class.php
// *********************** English translation *****************************
// *** bodyload -> activer
// *** activer :
//  -  if it is the form -> not display search <recherche_onglet> -> afficheTab=0
//                  if not  -> not display form <objet_onglet>-> afficheTab = 1
//  - if afficheTab = 1, call  soustabdyn.hp
//                      and display subform  <objet>
// *** afficherfom et afficherformajout (idx value in $champidx.value)
//      reload  if clik on tab form
//      the data is modify  in form
//      if seasure in sub form
//      -> bodyload -> activer
// *** afficher sousform : display the sub form
//       call sousformdyn.php
// *** suivant, precedent, allerpage, recherche, trier
//     navigation in soustabdyn.php -> see tab.class.php or tabdyn.class.php
// ==========================================================================
?>
<script language="javascript">
    var pfenetre;
    var fenetreouverte=false;
    var ns4 = (document.layers)? true:false;   //NS 4 
    var ie4 = (document.all)? true:false;   //IE 4 
    var dom = (document.getElementById)? true:false;   //DOM 


    function bodyload(objsf,premiersf){
        activer(objsf,premiersf);
    }

    function aide(){
    if(fenetreouverte==true)
       pfenetre.close();
    pfenetre=window.open("../doc/<?php echo $langue?>/<?php echo $obj;?>.html","Aide"," toolbar=no,scrollbars=yes,status=no,width=600,height=400,top=120,left=120");
    fenetreouverte=true;
    }

    function afficherform(){
       document.location.href="form.php?obj=<?php echo $obj;?>&idx=<?php echo $idx;?>&idz=<?php echo $idz;?>&premier=<?php echo $premier;?>&recherche=<?php echo urlencode($recherche)?>";
    }

    function afficherformajout(){
    document.location.href="form.php?obj=<?php echo $obj;?>&idx="+document.f1.<?php echo $champidx;?>.value+"&idz=<?php echo $idz;?>";
    }

    function activer(objsf,premiersf,tricolsf){
      //  cacher form et recherche si soustab
      var targetElement;
      var targetElement1;
      var affichageTab;
      targetElement = document.getElementById('objet_onglet') ;
      targetElement1 = document.getElementById('recherche_onglet') ;
      if (objsf=='<?php echo $obj;?>') {  // onglet form
         targetElement.style.display = "" ;
         targetElement1.style.display = "none" ;
         affichageTab=0;
      } else { // onglet soustab
         targetElement.style.display = "none" ;
         targetElement1.style.display = "" ;
         affichageTab=1;
      }
       if(tricolsf == null)
              tricolsf ="";
        else
              tricolsf = "&trisf="+tricolsf;
      //
      var bouton=document.getElementById("bouton_"+objsf);
      var objet = document.getElementById("objet").innerHTML;
      var  recherche = document.getElementById("recherchedyn").value;
      if(window.XMLHttpRequest) // Firefox
                xhr_object = new XMLHttpRequest();
      else if(window.ActiveXObject) // Internet Explorer
                xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
            else 
            { // XMLHttpRequest non supporte par le navigateur
                alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");   
                return;
            }
      if (affichageTab==1){ // affichage de soustabdyn si on n est plus en form
         xhr_object.open("GET", "soustabdyn.php?objsf="+objsf+"&obj=<?php echo($obj);?>&idx="+document.f1.<?php echo $champidx;?>.value+"&premiersf="+premiersf+"&recherche="+recherche+tricolsf, true);
         xhr_object.onreadystatechange = function()
         {
         if(xhr_object.readyState == 4)
             document.getElementById('sousform').innerHTML = xhr_object.responseText; //ancres
             }
                xhr_object.send(null);
             }else{
                document.getElementById('sousform').innerHTML = "";
            }
            if(window.XMLHttpRequest)
            { // Firefox
                if(objet!="")
                    document.getElementById("bouton_"+objet).setAttribute("style", ('<?php echo ($styleBoutonOngletInactif);?>'));
                bouton.setAttribute("style", ('<?php echo($styleBoutonOnglet);?>'));
            }
            if(window.ActiveXObject)
            { // Internet Explorer
                if(objet!="" )
                    document.getElementById("bouton_"+objet).style.setAttribute("cssText", ('<?php echo ($styleBoutonOngletInactif);?>'));
                bouton.style.setAttribute("cssText", ('<?php echo($styleBoutonOnglet);?>'));
            }
            document.getElementById('objet').innerHTML=objsf;
        //}
    }

    function affichersform(datasubmit) {
    var data=datasubmit;
    if (document.f2.elements[0]) {
      for (i=0;i<document.f2.elements.length;i++)
        data+="&"+document.f2.elements[i].name+"="+document.f2.elements[i].value;
    }
    if(window.XMLHttpRequest) // Firefox   
        xhr_object = new XMLHttpRequest();   
    else if(window.ActiveXObject) // Internet Explorer   
        xhr_object = new ActiveXObject("Microsoft.XMLHTTP");   
    else { // XMLHttpRequest non supportÃ© par le navigateur   
        alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");   
        return;   
    }  
    xhr_object.open("POST", "sousformdyn.php", true);
    xhr_object.onreadystatechange = function() {   
        if(xhr_object.readyState == 4) {
           document.getElementById('sousform').innerHTML = xhr_object.responseText;
        }
    } //postform
    xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); //post method
    xhr_object.send(data);
    }

    function suivant(tricol){
        // tab.class.php methode pagination 
        var objet = document.getElementById("objet");
        var  premier = document.getElementById("suivant");
        var  recherche = document.getElementById("recherchedyn").value;
        if(window.XMLHttpRequest) // Firefox   
            xhr_object = new XMLHttpRequest();   
        else if(window.ActiveXObject) // Internet Explorer   
            xhr_object = new ActiveXObject("Microsoft.XMLHTTP");   
        else 
        { // XMLHttpRequest non supporte par le navigateur   
            alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");   
            return;   
        }
        // si tricol est null, il n y a pas de tri choisi
        if(tricol == null)
              tricol ="";
        else
              tricol = "&trisf="+tricol;
        xhr_object.open("GET", "soustabdyn.php?objsf="+objet.innerHTML+"&premiersf="+premier.innerHTML+"&recherche="+recherche+"&obj=<?php echo $obj?>&idx="+document.f1.<?php echo $champidx;?>.value+tricol, true);
        xhr_object.onreadystatechange = function() 
        {
            if(xhr_object.readyState == 4)    
                document.getElementById('sousform').innerHTML = xhr_object.responseText;//ancres
        }   
        xhr_object.send(null);  
    } 

    function precedent(tricol){
        // tab.class.php methode paginationonglet
        var objet = document.getElementById("objet");
        var  premier = document.getElementById("precedent");
        var  recherche = document.getElementById("recherchedyn").value;
        if(window.XMLHttpRequest) // Firefox   
            xhr_object = new XMLHttpRequest();   
        else if(window.ActiveXObject) // Internet Explorer   
            xhr_object = new ActiveXObject("Microsoft.XMLHTTP");   
        else 
        { // XMLHttpRequest non supporte par le navigateur   
            alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");   
            return;   
        }
        // si tricol est null, il n y a pas de tri choisi
        if(tricol == null)
              tricol ="";
        else
              tricol = "&trisf="+tricol;
        xhr_object.open("GET", "soustabdyn.php?objsf="+objet.innerHTML+"&obj=<?php echo $obj;?>&idx="+document.f1.<?php echo $champidx;?>.value+"&premiersf="+premier.innerHTML+"&recherche="+recherche+tricol, true);
        xhr_object.onreadystatechange = function() 
        {   
            if(xhr_object.readyState == 4)    
                document.getElementById('sousform').innerHTML = xhr_object.responseText;//ancres
        }   
        xhr_object.send(null);  
    } 

    function allerpage(tricol){
        // tab.class.php methode paginationonglet
        var objet = document.getElementById("objet");
        var  premier = document.f2.page.value;
        var  recherche = document.getElementById("recherchedyn").value;
        if(window.XMLHttpRequest) // Firefox   
            xhr_object = new XMLHttpRequest();   
        else if(window.ActiveXObject) // Internet Explorer   
            xhr_object = new ActiveXObject("Microsoft.XMLHTTP");   
        else 
        { // XMLHttpRequest non supporte par le navigateur   
            alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");   
            return;   
        }
        // si tricol est null, il n y a pas de tri choisi
        if(tricol == null)
              tricol ="";
        else
              tricol = "&trisf="+tricol;
        xhr_object.open("GET", "soustabdyn.php?objsf="+objet.innerHTML+"&obj=<?php echo $obj;?>&idx="+document.f1.<?php echo $champidx;?>.value+"&premiersf="+premier+"&recherche="+recherche+tricol, true);
        xhr_object.onreadystatechange = function() 
        {   
            if(xhr_object.readyState == 4)    
            document.getElementById('sousform').innerHTML = xhr_object.responseText;//ancres
        }   
        xhr_object.send(null);  
    } 

    function recherche(){
        // tab.class.php methode paginationonglet
        var objet = document.getElementById("objet");
        var  recherche = document.getElementById("recherchedyn").value;
        if(window.XMLHttpRequest) // Firefox   
            xhr_object = new XMLHttpRequest();   
        else if(window.ActiveXObject) // Internet Explorer   
            xhr_object = new ActiveXObject("Microsoft.XMLHTTP");   
        else 
        { // XMLHttpRequest non supporte par le navigateur   
            alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");   
            return;   
        }  
        xhr_object.open("GET", "soustabdyn.php?objsf="+objet.innerHTML+"&obj=<?php echo $obj;?>&idx="+document.f1.<?php echo $champidx;?>.value+"&recherche="+recherche, true);
        xhr_object.onreadystatechange = function() 
        {   
            if(xhr_object.readyState == 4)    
                document.getElementById('sousform').innerHTML = xhr_object.responseText;//ancres
        }   
        xhr_object.send(null);
    }

    function trier(tricol){
      // tab.class.php methode afficheentetecolone
      var objet = document.getElementById("objet");
      var  premier;
      var  recherche = document.getElementById("recherchedyn").value;
    if(document.f2.page==null)
      premier=0;
    else
      premier=document.f2.page.value;
    if(window.XMLHttpRequest) // Firefox   
        xhr_object = new XMLHttpRequest();   
    else if(window.ActiveXObject) // Internet Explorer   
        xhr_object = new ActiveXObject("Microsoft.XMLHTTP");   
    else { // XMLHttpRequest non supportÃ© par le navigateur   
        alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");   
        return;   
    }  
    xhr_object.open("GET", "soustabdyn.php?objsf="+objet.innerHTML+"&obj=<?php echo($obj); ?>&idx=<?php echo($idx); ?>&premiersf="+premier+"&recherche="+recherche+"&trisf="+tricol, true);
    xhr_object.onreadystatechange = function() {   
        if(xhr_object.readyState == 4)    
           document.getElementById('sousform').innerHTML = xhr_object.responseText;}   
    xhr_object.send(null);  
    }
    
    //function setfocus(){
    //    document.f2.recherchedyn.focus();
    //}
</script>
<?php
// ===========================================================================
//                      *** FORMULAIRE ***                   [form]
// ===========================================================================
echo "<div id='formulaire'>\n";
//If (isset($_SESSION ['profil'])){
If ($_SESSION ['profil'] >=  $f -> droit) {
   echo "<!-- Formulaire -->\n";
   // ==========================================
   // AFFICHAGE DU FORMULAIRE  [display form]
   // document.getElementById('objet_onglet')
   // ==========================================
   echo "<div id='objet_onglet' style=\"display:none;\">\n";
   $enr = new $obj ($idx, $f -> db, $DEBUG);
   if ($DEBUG == 1)
      echo "Objet metier =><br> ".$enr->msg;
   echo "\t<div class='cadresousform_onglet'>\n";
   $validation++;
   $enr -> formulaire ($enteteTab,
                       $validation,
                       $maj,
                       $f -> db,
                       $_POST,
                       $obj,
                       $DEBUG,
                       $idx,
                       $premier,
                       $recherche,
                       $tricol,
                       $idz);
   echo "\t</div>\n"; // </'cadresousform_onglet'>
   echo "</div>\n";   // </objet_onglet>
   //==========================================================================
   //                *** SOUS FORMULAIRE ***       [sub form]
   // =========================================================================
   echo "<!-- Sous-formulaire -->\n";
   // -----------------------
   // classe tabdyn.class.php
   // -----------------------
   include ($path_om."tabdyn.class.php");
   if (!isset ($sousformulaire_class))
      $sousformulaire_class='sousformulaire';
   echo "\t<div id='soustab'>\n";
   $elem = "";
   // -------------------------------------------------------------------
   // AFFICHAGE DES BOUTONS ONGLETS FORMULAIRE ET SOUS FORMULAIRE:
   // [display form button and sub form button(s)
   // -------------------------------------------------------------------
   // *** bouton onglet FORMULAIRE ***
   //    ajout-> afficherformajout()  [add]
   //    autres -> afficherform()     [other]
   if($idx==']')
       echo "\t<input type='button' id='bouton_".$obj."' value='".lang($obj).
       "' onclick='afficherformajout();'  onFocus='this.blur()' style=".
       $styleBoutonOngletInactif.">\n";
   else
       echo "\t<input type='button' id='bouton_".$obj."' value='".lang($obj).
       "' onclick='afficherform();'  onFocus='this.blur()' style=".
       $styleBoutonOngletInactif.">\n";
   // *** bouton onglet SOUS FORMULAIRE ***
   // - en maj [modify] si [if] $maj==1
   // - en ajout [add] si [if] $maj == 0 , $validation>1 , $enr->correct==1 , $idx ==']'
   if ($maj==1 or ($maj == 0 and $validation>1
       and $enr->correct==1 and $idx ==']')){{ //***
      if (isset ($sousformulaire))
         foreach ($sousformulaire as $elem) {
           echo "\t<input type='button' id='bouton_".$elem."' value='".
           lang($elem)."' onclick='activer(\"".$elem.
           "\",0);recherche();'  onFocus='this.blur()' style=".
           $styleBoutonOngletInactif.">\n";
        }
      }
   }
   // ----------------------------------------------
   // RECHERCHE EN SOUS FORMULAIRE [search sub form]
   // ----------------------------------------------
   // Affichage de la recherche en sous formulaire
   // [display sub form search]
   // <recherche_onglet>   SPAN
   // --------------------------------------------
   echo "\t<span id='recherche_onglet'style=\"display:none;\">";
   echo "<img src='../img/rechercher.gif'  border='0' align='top'>\n";
   // ---------------------------------------------------------
   // ARCHIVE l element recherche en sous formulaire
   // passage de variable en java script
   // [filing search element - passage of variable to javascript]
   // recherche = document.getElementById("recherchedyn").value
   // ---------------------------------------------------------
   echo "\t<input type='text' name='recherchedyn' id='recherchedyn' value='' style='width:80' class='champFormulaire' onkeyup='recherche();' >\n";
   echo "\t</span>\n"; // </span recherche_onglet>
   echo "\t</div>\n";
   // ----------------------------------------------------------------
   // AFFICHAGE DU SOUS FORMULAIRE COURANT  [Display current sub form]
   // ----------------------------------------------------------------
   echo "\t<div id='sousform'></div>\n";
   // ------------------------------------------------------
   // Valorisation de $idx en ajout [add : value of $idx]
   // ATTENTION la cle doit avoir le même nom que la table
   // [BE CARREFUL the primary key has the same table name ]
   // ------------------------------------------------------
   if ($maj == 0 and $validation>1 and $enr->correct==1 and $idx ==']')
      $idx = $enr->valF[$enr->table];
   // ------------------------------------------------------------
   // passage de la variable $idx en javascript
   // [$idx - passage of variable to javascript]
   // cle formulaire -> function afficherformajout  [primary key]
   // cle secondaire des sous formulaire [secondary key -> sub form]
   // ---------------------------------------------------------------
   if ($maj>0 or ($maj == 0 and $validation>1 and $enr->correct==1)) {
   ?>
   <script language="javascript">
       document.f1.<?php echo $champidx;?>.value = '<?php echo $idx;?>';
   </script>
   <?php
   }
// ===============================================
// droit d acces insufisant  [Insufficient rights]
// ===============================================
}else{
       echo "<div id='msgdroitform'>".$f->lang("attention")."&nbsp;".$f->lang("droit").$f->lang("pluriel")."&nbsp;".$f->lang("insuffisant").$f->lang("pluriel")." - ".
        $f->lang("votre_profil_est")." : [".$_SESSION['profil']."]</div>";
}
//}
//else
// ===========================================
// Le profil n est pas défini [re-connect you]
// normalement on y arrive pas
// ===========================================
//echo "\t<div id='msgdroitform'><img src='../img/warning.gif' style='vertical-align:middle' hspace='5' vspace='5' border='0'>Droits insuffisants - ".
//        "Votre profil est : [".$_SESSION['profil']."]</div>\n";

// =============================================================================
// SOUS FORMULAIRE COURANT  <objet>    [current sub form]
// document.getElementById("objet").innerHTML
// <span permettant d afficher le sous tab en cours>
// ATTENTION : ne jamais appeller un element de la meme
// maniere : exemple nom de champ objet
echo "\t<br><span id='objet' style=\"display:none;\"></span>\n";
echo "\t</div>";

//$f -> db -> disconnect ();
//   if ($DEBUG == 1) echo "La base ".$dsn ['database']." est deconnectee.<br>";
// ====
// menu
// ====
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>\n";
// ============================
// deconnexion [disconnect]
// ============================
// utils.class
    $f -> deconnexion ();
    $f -> footerhtml ();
?>