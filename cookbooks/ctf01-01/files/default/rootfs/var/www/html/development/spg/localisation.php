<?php
//$Id: localisation.php,v 1.2 2008-07-17 09:44:14 jbastide Exp $
/*
localisation
Ce programme a recupéré des functions de la librairie ci dessous
 DHTMLapi.js custom API for cross-platform
 object positioning by Danny Goodman (http://www.dannyg.com)
 From "JavaScript Bible" 4th Edition.
Ces fonctions ont été intégrées de manière à simplifier le fonctionnement
Ce programme est compatible IE et mozilla
*/
include("../dyn/session.inc");
function lang($texte){
         include ("../dyn/var.inc");
         if(!isset($langue)) $langue='francais';
         include ("../lang/".$langue.".inc");
         if(!isset($lang[$texte])) $lang[$texte]='<i>'.$texte.'</i>';
         return $texte=$lang[$texte];
}
// parametrage =================================================================
$DEBUG=0;
// Recupération de champs
  $positionx=$_GET['positionx']; // coordonne X sur le plan
  $positiony=$_GET['positiony']; // coordonne Y sur le plan
  $plan= $_GET['plan'];  // plan
  $x= $_GET['x'];
  $y= $_GET['y'];
// =============================================================================
include("../dyn/var.inc");
echo "<html>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" lang=\"fr\">\n";
echo "\t<head>\n";
echo "\t\t<meta http-equiv=\"Content-Type\" content=\"text/html;charset=iso-8859-1\" />\n";
echo "\t\t<title>".lang("title_html")."</title>\n";
?>

<SCRIPT LANGUAGE="JavaScript">
//

// global declarations
var offsetX = 0
var offsetY = 0
var selectedObj  // objet selectionne
var states = new Array() // tableau decrivant l'objet
var recupx // variable X recuperer
var recupy // variable Y recuperer

// initialisation
function init() {
    initArray()
    document.onmousemove = release
}
// initialisation du tableau et implementation de l'objet
function initArray() {
    states["ca"] = new state("ca")
}
function state(abbrev) {
    this.abbrev = abbrev
    this.done = false
    // assigne les evenements
    // copier glisser
    assignEvents(this)
}
// assigne les evenements
function assignEvents(layer) {
    var obj
    if (document.layers) {
        obj = document.layers[layer.abbrev + "map"]
        obj.captureEvents(Event.MOUSEDOWN | Event.MOUSEMOVE | Event.MOUSEUP )
    } else if (document.all) {
        obj = document.all(layer.abbrev + "map")
    } else if (document.getElementById) {
        obj = document.getElementById(layer.abbrev + "map")
    }
    if (obj) {
        // clic sur l objet
        obj.onmousedown = engage
        // glisser l objet
        obj.onmousemove = dragIt
        // relacher l objet
        obj.onmouseup = release

    }
}
// clic sur l objet
function engage(evt) {
    evt = (evt) ? evt : event
    setSelectedMap(evt)
    if (selectedObj) {
        if (evt.pageX) {
            offsetX = evt.pageX - ((selectedObj.offsetLeft) ? selectedObj.offsetLeft : selectedObj.left)
            offsetY = evt.pageY - ((selectedObj.offsetTop) ? selectedObj.offsetTop : selectedObj.top)
        } else if (evt.offsetX || evt.offsetY) {
            offsetX = evt.offsetX - ((evt.offsetX < -2) ? 0 : document.body.scrollLeft)
            offsetY = evt.offsetY - ((evt.offsetY < -2) ? 0 : document.body.scrollTop)
        }
        return false
    }
}

// set global reference to map being engaged and dragged
function setSelectedMap(evt) {
    var target = (evt.target) ? evt.target : evt.srcElement
    var abbrev = (target.name && target.src) ? target.name.toLowerCase() : ""
    if (abbrev) {
        if (document.layers) {
            selectedObj = document.layers[abbrev + "map"]
        } else if (document.all) {
            selectedObj = document.all(abbrev + "map")
        } else if (document.getElementById) {
            selectedObj = document.getElementById(abbrev + "map")
        }
        //setZIndex(selectedObj, 100)
        return
    }
    selectedObj = null
    return
}
// move DIV on mousemove
function dragIt(evt) {
    evt = (evt) ? evt : event
    if (selectedObj) {
        if (evt.pageX) {
            shiftTo(selectedObj, (evt.pageX - offsetX), (evt.pageY - offsetY))
        } else if (evt.clientX || evt.clientY) {
            shiftTo(selectedObj, (evt.clientX - offsetX), (evt.clientY - offsetY))
        }
        evt.cancelBubble = true
        return false
    }
}
// position an object at a specific pixel coordinate
function shiftTo(obj, x, y) {
    var theObj = getObject(obj)
    if (theObj.moveTo) {
        theObj.moveTo(x,y)
    } else if (typeof theObj.left != "undefined") {
        theObj.left = x
        theObj.top = y
    }
}
//
// convert object name string or object reference
// into a valid object reference ready for style change
function getObject(obj) {
    var theObj
    if (document.layers) {
        if (typeof obj == "string") {
            return document.layers[obj]
        } else {
            return obj
        }
    }
    if (document.all) {
        if (typeof obj == "string") {
            return document.all(obj).style
        } else {
            return obj.style
        }
    }
    if (document.getElementById) {
        if (typeof obj == "string") {
            return document.getElementById(obj).style
        } else {
            return obj.style
        }
    }
    return null
}

// souris non clique
// recuperation de variable recupx et recupy avant d annuler selectedobj

function release(evt) {
    evt = (evt) ? evt : event
    if (selectedObj) {
       recupy= selectedObj.offsetTop
       recupx= selectedObj.offsetLeft
       selectedObj = null
    }
}

// sauvegarde des donnees en position sur le document
// apres double click
// formulaire f1
// $positionx nom du controle x
// $positiony nom du controle y
function sauve(){
alert("coordonnees x :"+recupx+"\n coordonnees y :"+recupy)

       opener.document.f1.<?php echo $positionx?>.value = recupx;
       opener.document.f1.<?php echo $positiony?>.value = recupy;
       this.close();

}

</SCRIPT>
<?php
echo "</head>";
echo "<body id='localisation' onLoad='init()'>";
// affichage du plan
$plan=$chemin_plan.$plan ;
echo "<DIV  style='position:absolute; left:0;top:0'>";
echo "<IMG SRC='".$plan."'>&nbsp;</IMG>";
echo "<a class='lientable' href='#' onclick='window.close();'>";
echo "<br><br><center><img src='../img/fermer_fenetre.png' align='middle' alt='".lang("fermer")."' title='".lang("fermer")."' hspace='5' border='0'>";
echo "</center></a>";
echo "</div>";
// affichage de l objet
// position $x
// position $y
echo "<DIV ID=camap style='position:absolute; left:".$x."; top:".$y."; width:1' ondblclick='sauve();'>";
echo $objet_plan;
echo "</DIV>";
echo "</body></html>";
?>