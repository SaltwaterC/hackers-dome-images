<?php
// $Id: look.php,v 1.1 2008-07-17 11:31:32 jbastide Exp $
if (file_exists ("../dyn/session.inc"))
        include ("../dyn/session.inc");
if (file_exists ("../dyn/var.inc"))
        include ("../dyn/var.inc");
if (file_exists ("../scr/lang.inc"))
        include ("../scr/lang.inc");
if (file_exists ("../obj/utils.class.php"))
        include ("../obj/utils.class.php");
//
function create_tab ($dir) {  // fonction creant le tableau contenant les repertoires et fichiers
    $dir = rtrim ($dir, '/'); // on vire un eventuel slash mis par l'utilisateur de la fonction a droite du repertoire
    if (is_dir ($dir))        // si c'est un repertoire
      $dh = opendir ($dir);   // on l'ouvre
    else {
      echo $dir, ' n\'est pas un repertoire valide'; // sinon on sort! Appel de fonction non valide
      exit;
      }
    while (($file = readdir ($dh)) !== false ) { //boucle pour parcourir le repertoire 
      if ($file !== '.' && $file !== '..'
          && $file !== 'Thumbs.db'
          && $file !== 'CVS'  && $file !== 'index.php'  && $file !== 'encours.png') { // no comment
        $path =$file;           // construction d'un joli chemin...
        $tableau[] = $path;
      }
    }
    closedir ($dh); // on ferme le repertoire courant
    if (isset ($tableau)) {
            return $tableau;
        }
}

function copier_rep ($destination, $reps, $tableau_dir = array ()) { // fonction pour copier repertoire : on cree un repertoire de meme nom, puis on va chercher les fichiers, et on les copie. Si il y a des sous repertoires, appel recursif.
    if (empty ($tableau_dir)) {
      $tableau_dir = create_tab ($reps);
    }
   //print_r($tableau_dir);
    $fin= sizeof($tableau_dir);
    for ($i = 0; $i < $fin; $i++) {
        $tmp="";
        $tmp =  $tableau_dir[$i];
        copy($reps."/".$tableau_dir[$i] ,$destination."/".$tableau_dir[$i]);
    }
}
//
    $f = new utils ();
    $f -> droit ("look");
//echo "////////////".$f -> droit."****".$_SESSION ['profil'];
  if (isset($_SESSION ['profil'])){
       if ($_SESSION ['profil'] > 0 && $_SESSION ['profil'] >= $f -> droit) {
            if (isset ($_GET ['nolook'])) {
                 $nolook = $_GET ['nolook'];
                 // 1er paramètre : le répertoire de destination sous forme d'une chaine
                 // 2eme paramètre : le répertoire à copier sous forme d'une chaine ou d'un tableau
                 copier_rep ('../dyn', '../dyn/'.$nolook.'/dyn/');
                 copier_rep ('../img', '../dyn/'.$nolook.'/img/');
                 copier_rep ('../trs/'.$_SESSION['coll'], '../dyn/'.$nolook.'/trs/');
                header('Location: tdb.php');
             }
       }else
            header('Location: tdb.php?msgl=droits');
    }else{
        header('Location: tdb.php?msgl=droits');
    }
?>