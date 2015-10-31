$Id: readme_english.txt,v 1.1 2008-07-24 13:18:52 jbastide Exp $

===================================================================================
Toute la documentation d'openMairie sur: 
http://www.openmairie.org
mail: contact@openmairie.org
===================================================================================


openMairie est un composant qui est utilisé par les applications de la gamme openMairie.

Ce composant permet:
- la gestion des formulaires
- les éditions en pdf

Le framework (systeme d organisation des scripts) openmairie_exemple propose une gestion 
de menu, gestion des utilisateurs et un mode d'organisation des scripts php.


1- MODE DE FONCTIONNEMENT OPENMAIRIE
    ==============================

Une documentation plus complete des classes est accessible sur le site http://www.openmairie.org

Sur la base de l application openPresse, un document de prise en main d'openMairie est 
télechargeable sur le site http://www.openmairie.org [demonstration->openpresse]



2 LES CLASSES D OPEN MAIRIE 
   =====================

2.1 FORMULAIRE 

    2.1.1 tab.class.php ou tabdyn.class.php (version > 2.0)

Cette classe permet l'affichage page par page d'une requete en tableau.
La méthode entete affiche l'entete:
    moteur de recherche
    edition
La méthode afficher affiche la requete.
Cette méthode est associée à l'interface /scr/tab.php ou l'objet métier est passe en parametre:
     exemple : /scr/tab.php?obj=profil
Le paramétrage de l'objet se fait dans la requete /sql/mysql/profil.inc:

    2.1.2a dbform.class.php ou dbformdyn.class (version > 2.0)

Cette classe gére l'interface entre l'objet métier et la base de données connectée via DBPEAR.
Le connexion est stockée en dyn/base.php
Cette méthode est associée à l'interface /scr/form.php ou l'objet métier est passe en parametre:
exemple : /scr/form.php?obj=profil
Le paramétrage de l'objet se fait dans la requete /sql/mysql/profil.form.inc:


    2.1.2b txform.class.php

Cette classe gére l'interface entre l'objet métier et un fichier texte.
Cette méthode est associée à l'interface /scr/txform.php ou l'objet métier est passe en parametre:
exemple : /scr/txform.php?obj=lettretype
Le paramétrage de l'objet se fait dans la requete /sql/mysql/utilisateur.lettretype.inc:

    2.1.3 formulaire.class.php ou formulairedyn.class.php (version > 2.0)

 Cette classe sert à afficher un formulaire en fonction des méthodes de l'objet métier.
 Dans le repertoire /spg
 calendrier.php, calendrierbas.php, calendrierhaut.php permet l affichage de calendrier pour la saisie
 combo.php: affichage de boite de saisie pour le type combo. 
      Le paramétrage de cette boite se fait dans
      dyn/comboparametre.inc, comboretour.inc, comboaffichage.inc

 
2.2 EXTENSION FPDF

Les classes suivantes herite de la classe fpdf avec:
- des methodes de fpdf surchargées
- de nouvelles methodes

pour permettre des gérer les états, sous états, lettre type


2.2.1.  db_fpdf.php [abandonner en version 1.09 d openMairie]

cette classe permet de faire le  lien entre db pear et fpdf         
Le connexion est stockée en dyn/connexion.php 
Cette méthode est associée à l'interface /pdf/pdf.php ou l'objet métier est passe en parametre:
exemple : /pdf/pdf.php?obj=bureau
Le paramétrage de l'objet se fait dans la requete /sql/mysql/utilisateur.pdf.inc:

2.2.2 fpdf_etiquette 

Cette méthode est associée à l'interface /pdf/pdfetiquette.php
ou l'objet métier est passe en parametre:
exemple : /pdf/pdfetiquette.php?obj=jury
Le paramétrage de l'objet se fait dans la requete:
pdf/utilisateur.pdfetiquette.php,


2.2.3 fpdf_etat.php [remplace db_fpdf.php a partir de la version 1.09]

Gestion des états et des sous états
Cette méthode est associée à l'interface /pdf/pdfetat.php ou l'objet métier est passe en parametre:
exemple : /pdf/fpdfetat.php?obj=profil
Le paramétrage de l'objet se fait dans la requete /sql/mysql/profil.etat.inc:
et eventuellement les sous etats : /sql/mysql/utilisateur.sousetat.inc ou
/sql/mysql/profil.sousetat.inc


2.3 MENU en JAVA SCRIPT

    /dyn/menu.js   par Sylvain Machefert.
    voir http:iubito.free.fr/prog/menu.php pour toutes les explications
    Le menu est initié en dyn/menu.inc
    Le paramétrage du menu se fait aussi dans la librairie java script: menu.js
    

2.4 UPLOAD 
  
  La classe formulaire.class.php  utilise la classe spg/upload.class.php
   * @author  Olivier VEUJOZ <o.veujoz@miasmatik.net>
  Pour faire appel à cette classe, ces programmes utilisent le programme d'
  interface spg/upload.php qui est paramétrable.

2.5 RVB affichage des couleurs pour choix des couleurs
      Composant d affichage des palettes couleurs (version 2.0)
      adapté pour openMairie en php (rvb.js / couleur.js)
      @author du composant js à l origine : BERNARD MARTIN-RABAUD  WebExpert


