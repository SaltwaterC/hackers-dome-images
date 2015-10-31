<?php
//$Id: upload2.php,v 1.1 2008-07-17 11:31:33 jbastide Exp $

function pArray($array) {
    print '<pre style="background:#faebd7">';
    print_r($array);
    print '</pre>';
}
function lang($texte){
         include ("../dyn/var.inc");
         if(!isset($langue)) $langue='francais';
         include ("../lang/".$langue.".inc");
         if(!isset($lang[$texte])) $lang[$texte]='<i>'.$texte.'</i>';
         return $texte=$lang[$texte];
}
include ("../dyn/session.inc");
include ("../dyn/var.inc");
// Chargement de la classe
require_once('../spg/upload.class.php');

// Instanciation d'un nouvel objet "upload"
$Upload = new Upload();

/**
 * Gestion lors de la soumission du formulaire
 **/

if (!Empty($_POST['submit'])) {
    // Si vous voulez renommer le fichier...
    //$Upload-> Filename     = 'fichier';
    
    // Si vous voulez ajouter un préfixe au nom du fichier...
    //$Upload-> Prefixe = 'pre_';
    
    // Si vous voulez ajouter un suffixe au nom du fichier...
    //$Upload-> Suffice = '_suf';
    
    // Pour changer le mode d'écriture (entre 0 et 3)
    //$Upload-> WriteMode    = 0;
    
    // Pour filtrer les fichiers par extension
    $Upload-> Extension = '.gif;.jpg;.jpeg;.png;.txt;.pdf';
    
    // Pour filtrer les fichiers par entête
    //$Upload-> MimeType  = 'image/gif;image/pjpeg;image/bmp;image/x-png'; 
    
    // Pour tester la largeur / hauteur d'une image
    //$Upload-> ImgMaxHeight = 200;
    //$Upload-> ImgMaxWidth  = 200;
    //$Upload-> ImgMinHeight = 100;
    //$Upload-> ImgMinWidth  = 100;
    
    // Pour vérifier la page appelante
    //$Upload-> CheckReferer = 'http://mondomaine/mon_chemin/mon_fichier.php';
    
    // Pour générer une erreur si les champs sont obligatoires
    //$Upload-> Required     = false;
    
    // Pour interdire automatiquement tous les fichiers considérés comme "dangereux"
    //$Upload-> SecurityMax  = true;
    
    // Définition du répertoire de destination
    $Upload-> DirUpload    = '../trs/'.$_SESSION["coll"]."/"; //"."
    
    // On lance la procédure d'upload
    $Upload-> Execute();
    
    // Gestion erreur / succès
    if ($UploadError) {
             echo "<table border=0>";
             foreach($Upload-> GetError() as $elem){
             echo "<tr>" ;
             foreach($elem as $elem1)
             echo "<td>".$elem1."</td>";
             echo "</tr>";
             }
             echo "</table>";
    } else {
        //echo 'Upload effectuée avec succès :';
        //pArray($Upload-> GetSummary());
        //$tab=$Upload-> GetSummary();
        //echo "============".$tab['nom'];
        foreach($Upload-> GetSummary() as $elem){
           $nom = $elem['nom'];
           ?>
               <script language="javascript">
               parent.opener.document.f2.<?php echo $_GET['origine']?>.value='<?php echo $nom?>';
               parent.close();
               </script>
           <?php
        }
        echo $nom." - ".$_GET['origine'];


    }
}else{
/**
 * Création du formulaire
 **/
// Pour limiter la taille d'un fichier (exprimée en ko)
$Upload-> MaxFilesize  = '10000';

// Pour ajouter des attributs aux champs de type file
$Upload-> FieldOptions = 'style="border-color:black;border-width:1px;"';

// Pour indiquer le nombre de champs désiré
$Upload-> Fields       = 2;

// Initialisation du formulaire
$Upload-> InitForm();
// * custom *
$stylebodyupload="";
include("../dyn/var.inc");
//*
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
    <title>Upload</title>
</head>

<body style=<?php echo $stylebodyupload?>>
<form method="post" enctype="multipart/form-data" name="formulaire" id="formulaire" action="upload2.php?origine=<?php echo $_GET['origine']?>" onsubmit="return valider()">
<?php
// Affichage du champ MAX_FILE_SIZE
print $Upload-> Field[0];

// Affichage du premier champ de type FILE
 print $Upload-> Field[1] . '<br>';

// Affichage du second champ de type FILE
//print $Upload-> Field[2];
$msg_envoi_absent=lang("nom")." ".lang("fichier")." ".lang("a_envoyer")." ".lang("absent");
?>
<br>
<input type="submit" value="<?php echo lang("envoyer"); ?>" name="submit" style=<?php echo $styleBouton;?>>
</form>
 <script language="javascript">
    function valider()
    {
    var fic=document.getElementById("userfile[]").value;
    submitOK="true";
      if (fic=="")
       {
       alert("<?php echo $msg_envoi_absent?>"+" !!");
       submitOK="false";
       }
      if (submitOK=="false")
     {
     return false;
     }
    }
    </script>
<?php
}
?>
</body>
</html>