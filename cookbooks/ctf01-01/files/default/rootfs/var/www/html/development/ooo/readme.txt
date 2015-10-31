$Id: readme.txt,v 1.3 2008-01-25 23:38:35 fraynaud1 Exp $

=======================================================================
Toute la documentation d'openMairie sur: 
http://www.openmairie.org
mail: contact@openmairie.org
========================================================================

Nous proposons dans le repertoire OOO un lien openoffice/ openscrutin de deux manières :

1- des etats CALC openoffice.org liés aux requetes memorisees
d openScrutin [reqmo]
	scrutin_heure.ods : Etat des heures supplementaires sous CALC
	scrutin_candidat.ods : Etat des candidatures sous CALC	

2- un lien ODBC sur la base mysql openscrutin openscrutin.odb
   et une lettre type liée à la requete convocation_agent.odt



1- Lien CALC / openScrutin

Il y a plusieurs maniere de recuperer les donnees

* lancer la requete sous forme de tableau html 
 1 - faire un copier du resultat de la requete sans les entetes de colones
 2 - faire un collage special (Edition - coller - collage special) option html

* lancer la requete sous format csv
 1 - faire un copier du resultat de la requete sans les entetes de collones
 2 - faire un collage special (Edition - coller - collage special) option texte non formate
 3 - choisir option de separation fixe :  ";" tab ou "|" suivant votre choix en reqmo


2 - lien openscrutin.odb et lettre type convocation_agent.odt

- mettre a jour le driver odbc

	edition
	   base de donnees
		proprietes -> faire un lien ODBC sur votre base

        Attention : creer un utilisateur qui ne peut pas modifier
	(droit : select)

				
- charger le modele convocation_agent.odt et lancer :

	option/assistant mailing

	document de base = document actif
	lettre type
	bloc d adresse -> openscrutin.odb / requete : candidature
	... 
