$Id: readme_english.txt,v 1.1 2008-07-24 13:18:52 jbastide Exp $

===================================================================================
Toute la documentation d'openMairie sur: 
http://www.openmairie.org
mail: contact@openmairie.org
===================================================================================


openMairie est un composant qui est utilis� par les applications de la gamme openMairie.

Ce composant permet:
- la gestion des formulaires
- les �ditions en pdf

Le framework (systeme d organisation des scripts) openmairie_exemple propose une gestion 
de menu, gestion des utilisateurs et un mode d'organisation des scripts php.


1- MODE DE FONCTIONNEMENT OPENMAIRIE
    ==============================

Une documentation plus complete des classes est accessible sur le site http://www.openmairie.org

Sur la base de l application openPresse, un document de prise en main d'openMairie est 
t�lechargeable sur le site http://www.openmairie.org [demonstration->openpresse]



2 LES CLASSES D OPEN MAIRIE 
   =====================

2.1 FORMULAIRE 

    2.1.1 tab.class.php ou tabdyn.class.php (version > 2.0)

Cette classe permet l'affichage page par page d'une requete en tableau.
La m�thode entete affiche l'entete:
    moteur de recherche
    edition
La m�thode afficher affiche la requete.
Cette m�thode est associ�e � l'interface /scr/tab.php ou l'objet m�tier est passe en parametre:
     exemple : /scr/tab.php?obj=profil
Le param�trage de l'objet se fait dans la requete /sql/mysql/profil.inc:

    2.1.2a dbform.class.php ou dbformdyn.class (version > 2.0)

Cette classe g�re l'interface entre l'objet m�tier et la base de donn�es connect�e via DBPEAR.
Le connexion est stock�e en dyn/base.php
Cette m�thode est associ�e � l'interface /scr/form.php ou l'objet m�tier est passe en parametre:
exemple : /scr/form.php?obj=profil
Le param�trage de l'objet se fait dans la requete /sql/mysql/profil.form.inc:


    2.1.2b txform.class.php

Cette classe g�re l'interface entre l'objet m�tier et un fichier texte.
Cette m�thode est associ�e � l'interface /scr/txform.php ou l'objet m�tier est passe en parametre:
exemple : /scr/txform.php?obj=lettretype
Le param�trage de l'objet se fait dans la requete /sql/mysql/utilisateur.lettretype.inc:

    2.1.3 formulaire.class.php ou formulairedyn.class.php (version > 2.0)

 Cette classe sert � afficher un formulaire en fonction des m�thodes de l'objet m�tier.
 Dans le repertoire /spg
 calendrier.php, calendrierbas.php, calendrierhaut.php permet l affichage de calendrier pour la saisie
 combo.php: affichage de boite de saisie pour le type combo. 
      Le param�trage de cette boite se fait dans
      dyn/comboparametre.inc, comboretour.inc, comboaffichage.inc

 
2.2 EXTENSION FPDF

Les classes suivantes herite de la classe fpdf avec:
- des methodes de fpdf surcharg�es
- de nouvelles methodes

pour permettre des g�rer les �tats, sous �tats, lettre type


2.2.1.  db_fpdf.php [abandonner en version 1.09 d openMairie]

cette classe permet de faire le  lien entre db pear et fpdf         
Le connexion est stock�e en dyn/connexion.php 
Cette m�thode est associ�e � l'interface /pdf/pdf.php ou l'objet m�tier est passe en parametre:
exemple : /pdf/pdf.php?obj=bureau
Le param�trage de l'objet se fait dans la requete /sql/mysql/utilisateur.pdf.inc:

2.2.2 fpdf_etiquette 

Cette m�thode est associ�e � l'interface /pdf/pdfetiquette.php
ou l'objet m�tier est passe en parametre:
exemple : /pdf/pdfetiquette.php?obj=jury
Le param�trage de l'objet se fait dans la requete:
pdf/utilisateur.pdfetiquette.php,


2.2.3 fpdf_etat.php [remplace db_fpdf.php a partir de la version 1.09]

Gestion des �tats et des sous �tats
Cette m�thode est associ�e � l'interface /pdf/pdfetat.php ou l'objet m�tier est passe en parametre:
exemple : /pdf/fpdfetat.php?obj=profil
Le param�trage de l'objet se fait dans la requete /sql/mysql/profil.etat.inc:
et eventuellement les sous etats : /sql/mysql/utilisateur.sousetat.inc ou
/sql/mysql/profil.sousetat.inc


2.3 MENU en JAVA SCRIPT

    /dyn/menu.js   par Sylvain Machefert.
    voir http:iubito.free.fr/prog/menu.php pour toutes les explications
    Le menu est initi� en dyn/menu.inc
    Le param�trage du menu se fait aussi dans la librairie java script: menu.js
    

2.4 UPLOAD 
  
  La classe formulaire.class.php  utilise la classe spg/upload.class.php
   * @author  Olivier VEUJOZ <o.veujoz@miasmatik.net>
  Pour faire appel � cette classe, ces programmes utilisent le programme d'
  interface spg/upload.php qui est param�trable.

2.5 RVB affichage des couleurs pour choix des couleurs
      Composant d affichage des palettes couleurs (version 2.0)
      adapt� pour openMairie en php (rvb.js / couleur.js)
      @author du composant js � l origine : BERNARD MARTIN-RABAUD  WebExpert


