<?php
//22/09/2008   10:53:30
$lettretype['orientation']="P";
$lettretype['format']="A4";
$lettretype['logo']="logo.png";
$lettretype['logoleft']="8";
$lettretype['logotop']="9";
$lettretype['titre']="Notification de login à [nom]";
$lettretype['titreleft']="89";
$lettretype['titretop']="30";
$lettretype['titrelargeur']="0";
$lettretype['titrehauteur']="10";
$lettretype['titrefont']="arial";
$lettretype['titreattribut']="B";
$lettretype['titretaille']="15";
$lettretype['titrebordure']="0";
$lettretype['titrealign']="L";
$lettretype['corps']="Reference : Service informatique de £ville;
Objet : <b>Exemple de lettre type</b> 

 

        Nous vous presentons une exemple de lettre type.


        Nous pouvons entre crochets mettre des champs définis dans la requete SQL

         Veuillez trouver votre login:
        
                Login : <b>[login]</b>
                Profil : <b>[profil]</b>

          Nous pouvons rajouter les champs de la table courrier preceder du signe monétaire de la livre anglaise comme ci dessous pour une formule de politesse personnalisée ainsi que les variables de l application (ville, nom du maire, variables session) qui sont paramétrées dans dyn/varlettretypepdf.inc.


          £complement
 


        
                               Fait à £ville, en Hôtel de Ville 
                               le £datecourrier



                               £nom
                                           ";
$lettretype['corpsleft']="24";
$lettretype['corpstop']="58";
$lettretype['corpslargeur']="150";
$lettretype['corpshauteur']="5";
$lettretype['corpsfont']="times";
$lettretype['corpsattribut']="";
$lettretype['corpstaille']="10";
$lettretype['corpsbordure']="0";
$lettretype['corpsalign']="J";
$lettretype['sql']="select nom,login,profil
        from utilisateur
        where idutilisateur = £destinataire";
?>
