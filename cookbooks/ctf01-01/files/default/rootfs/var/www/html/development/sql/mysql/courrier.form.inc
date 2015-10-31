<?php
$DEBUG = 0;
$ent = "parametrage -> Courrier";
$ico = "ico_utilisateur.png";
$tableSelect="courrier";
$champs=array("courrier",
              "destinataire",
              "datecourrier",
              "lettretype",
              "complement"
              );
$selection="";
$sql_destinataire="select idutilisateur,nom from utilisateur order by nom";
?>