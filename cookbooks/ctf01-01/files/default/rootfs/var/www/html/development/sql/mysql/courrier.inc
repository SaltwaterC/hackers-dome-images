<?php
$DEBUG=0;
$serie=10;
$ent = "traitement -> envoi->lettretype";
$ico = "ico_traitement.png";
// =======================================================
// href special edition courrier
// =======================================================
       $href[0]['lien']= "form.php?obj=courrier";
       $href[0]['id']= "";
       $href[0]['lib']= "<img src='../img/ajouter.png' border='0'>";
       $href[1]['lien'] = "form.php?obj=courrier&idx=";
       $href[1]['id']= "&premier=".$premier."&recherche=".$recherche1;
       $href[1]['lib']= "";
       $href[2]['lien'] = "form.php?obj=courrier&idx=";
       $href[2]['id']= "&ids=1&premier=".$premier."&recherche=".$recherche1;
       $href[2]['lib']= "<img src='../img/supprimer.gif' border='0'>";
       $href[3]['lien'] = "../pdf/pdflettretype.php?idx=";
       $href[3]['id']= "";
       $href[3]['lib']= "<img src='../img/ico_pdf.png' border=0>";
//
$table="courrier inner join utilisateur on courrier.destinataire=utilisateur.idutilisateur";
$edition="";
//
$champAffiche=array("courrier as no",
                    "nom",
                    "lettretype",
                    "concat(substring(datecourrier,9,2),'/',substring(datecourrier,6,2),'/',substring(datecourrier,1,4)) as date"
                    );
$champRecherche=array("courrier","lettretype");
$tri= "";
$selection="";
?>