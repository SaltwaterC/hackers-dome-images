<?php
$titre ="Arles le £aujourdhui

".$row["nom"]." ".$row["prenom"]."
".$row["adresse"]."
".$row["cpagent"]." ".$row["villeagent"]."";
$corps ="Objet : ELECTION DU ".$row["date_scrutin"]."
            Affectation / Réunion préparatoire





Madame, Monsieur,

J’ai le plaisir de vous faire part de votre affectation en qualité de « ".$row["poste"]." »

Pour les élections  ".$row["libellescrutin"]."

Le DIMANCHE ".$row["date_scrutin"]."

Au bureau de vote – « ".$row["bureau"]." ".$row["libellebureau"]." »  ".$row["adresse1"]." ".$row["adresse2"]."

pour la periode : ".$row["periode"]."  ".$row["libelleperiode"]."

En cas d’empêchement de votre part, pour assurer ces fonctions, il convient de m’en informer le plus rapidement possible au 04.90.49.35.48.

Vous voudrez bien PARTICIPER IMPERATIVEMENT à la réunion préparatoire dont les horaires et le lieu sont précisés ci-dessous, par avance je vous en remercie.

".$row["convocation_agent"]."

Cette réunion, destinée à l’ensemble des secrétaires et plantons, est organisée afin de vous présenter les nouvelles dispositions arrêtées pour ces scrutins et vous donner toutes précisions utiles notamment sur l’établissement du procès-verbal.

Je vous prie de recevoir, l’assurance de mes sentiments distingués.


Michèle MILCENT";
?>