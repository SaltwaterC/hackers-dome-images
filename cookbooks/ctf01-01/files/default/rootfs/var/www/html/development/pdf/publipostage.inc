<?php
$titre ="Arles le �aujourdhui

".$row["nom"]." ".$row["prenom"]."
".$row["adresse"]."
".$row["cpagent"]." ".$row["villeagent"]."";
$corps ="Objet : ELECTION DU ".$row["date_scrutin"]."
            Affectation / R�union pr�paratoire





Madame, Monsieur,

J�ai le plaisir de vous faire part de votre affectation en qualit� de � ".$row["poste"]." �

Pour les �lections  ".$row["libellescrutin"]."

Le DIMANCHE ".$row["date_scrutin"]."

Au bureau de vote � � ".$row["bureau"]." ".$row["libellebureau"]." �  ".$row["adresse1"]." ".$row["adresse2"]."

pour la periode : ".$row["periode"]."  ".$row["libelleperiode"]."

En cas d�emp�chement de votre part, pour assurer ces fonctions, il convient de m�en informer le plus rapidement possible au 04.90.49.35.48.

Vous voudrez bien PARTICIPER IMPERATIVEMENT � la r�union pr�paratoire dont les horaires et le lieu sont pr�cis�s ci-dessous, par avance je vous en remercie.

".$row["convocation_agent"]."

Cette r�union, destin�e � l�ensemble des secr�taires et plantons, est organis�e afin de vous pr�senter les nouvelles dispositions arr�t�es pour ces scrutins et vous donner toutes pr�cisions utiles notamment sur l��tablissement du proc�s-verbal.

Je vous prie de recevoir, l�assurance de mes sentiments distingu�s.


Mich�le MILCENT";
?>