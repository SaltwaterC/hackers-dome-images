<?php
/* $Id: entete.inc,v 1.3 2008-07-17 09:44:14 jbastide Exp $
head HTML
*/
// Meta balise HTML   ======================================================
echo "<title>openMairie</title>";
echo "<meta name='DESCRIPTION' content='openMairie, framework php orienté objet basé sur sql'/>";
echo "<meta name='KEYWORDS' content='openmairie,framework,php,sql'/>";
echo "<meta name='robots' content='index,follow'/>";
echo "<meta name='revisit-after' content='20 days'/>";
echo "<meta name='language' content='fr'/>";
echo "<meta name='owner' content='openMairie.fr'/>";
echo "<meta name='reply-to' content='contact@openMairie.org'/>";
echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'/>";
if(isset($flagindex)){
  echo "<link rel='stylesheet' href='dyn/style.css' type='text/css'/>";
}else{
   echo "<link rel='stylesheet' href='../dyn/style.css' type='text/css'/>";
}
?>


