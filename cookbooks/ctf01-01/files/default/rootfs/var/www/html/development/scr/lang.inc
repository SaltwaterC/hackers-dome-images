<?php
// $Id: lang.inc,v 1.1 2008-07-17 11:31:32 jbastide Exp $
function lang($texte){
         include ("../dyn/var.inc");
         if(!isset($langue)) $langue='francais';
         if (file_exists("../lang/".$langue.".inc")) {
             include ("../lang/".$langue.".inc");
         }
         if(!isset($lang[$texte])) $lang[$texte]='<i>'.$texte.'</i>';
         return $lang[$texte];
}
?>