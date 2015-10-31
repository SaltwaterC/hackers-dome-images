$Id: readme.txt,v 1.6 2008-10-21 04:49:01 fraynaud1 Exp $
=========================================
Toute la documentation d'openMairie sur: 
[All the documentation of openMairie on:]
http://www.openmairie.org
=========================================
Translate in english  readme_english.txt

Pre requis :
============
Vous devez avoir installer:
- un serveur apache et php
- une base de données : mysql ou postgresql

En fait, reportez vous aux installations de :
- sous windows : wamp (http://www.wampserver.com/) ou easyphp(http://easyphp.fr/)
- sous linux : lamp


Si vous debutez, il est plus simple de garder mysql qui est packagée avec
easyphp ou wamp.

Depuis la version 1.02, il est possible de faire une installation simplifiée(1)

Cette installation est interressante :
- si vous voulez faire un essai rapide
- si vous n avez pas d autres applications openMairie
- si vous souhaitez mettre en place openCimetiere chez votre fournisseur d acces
   (attention il faut avoir un acces à une base de données mysql ou pgsql)

L installation traditionnelle avec les dependances reste possible (2), elle est à
préferer si vous avez la maîtrise de votre serveur.



1- Installation simplifiée [par defaut]
   ====================================

1.1 - Installation de openmairie_scrutin
   copier le repertoire openmairie_scrutin sur votre serveur
   exemples
        wamp/www/openmairie_scrutin
        sous linux (debian) : var/www/openmairie_scrutin

1.2 - Initialisation de la base en MySQL ou postgresql
    creer la base openscrutin sur mysql ou pgsql
    Ensuite, il faut creer les tables de la base de données
    puis executer les scripts SQL suivants :
    - en mysql :
    openmairie_scrutin/data/mysql/init.sql


la premiere initialisation se fait avec init.sql
les modifications de version se font avec ver numero-de-version
exemple: pour passer a la version 1.08 : ver1.08.sql
Vous pouvez utiliser la base d essai : data_essai.sql


1.3 parametrer la connexion dans /dyn/base.php
parametrage par defaut :

* collectivite 1 (sur mysql) : coll[1] est un tableau php qui contient les parametres
de connexion suivants
    'titre => 'openscrutin (mysql)',[parametrage openscrutin]
    'phptype'  => 'mysql', [ne pas changer parametrage dbpear]
    'dbsyntax' => '',[ne pas changer parametrage dbpear]
    'username' => 'root', [par defaut sur wamp easyphp ou lamp /
                           a voir avec le fournisseur d acces le cas echeant]
    'password' => '' [par defaut sur wamp easyphp ou lamp /
                        a voir avec le fournisseur d acces le cas echeant]
    'protocol' => '',
    'hostspec' => 'localhost', [nom de serveur par defaut wamp ou easyphp]
    'port'     => '',  [ne pas changer parametrage dbpear]
    'socket'   => '',  [ne pas changer parametrage dbpear]
    nom de la base => 'openscrutin', [parametrage openscrutin]
    format date par defaut =>'AAAA-MM-JJ' [[parametrage openscrutin ne pas changer]



2. Installation d'openscrutin avec les dependances
   =================================================

Cette installation est plus complexe à mettre en oeuvre par contre elle est plus
coherente par rapport a un serveur apache si plusieurs applications utilisent
les mêmes composants.

Vous pouvez vous reporter sur le document plus complet de l adullact à l adresse suivante
http://openmairie.org/documentation/installation-openmairie/

2.1 -  installer les 3 librairies (obligatoires)
exemple avec wamp ou linux (ubuntu ou debian)
  pear : wamp/php/pear usr/share/php/PEAR
           PEAR Base System PHP : http://pear.php.net/package/PEAR
           pear db  :  http://www.pear.php.net/package/DB
  fpdf  : wamp/php/fpdf   usr/share/fpdf 
           http://www.fpdf.org
  openmairie : wamp/php/openmairie ou usr/share/php/openmairie 
    http://www.openmairie.org 
    version >= 2.02

2.2 - modifier le chemin dans php.ini

* exemple sous windows avec wamp5
    include_path= ".;c:\wamp\php\includes;c:\wamp\php\pear;c:\wamp\php\fpdf;c:\wamp\php\openmairie"
* exemple avec linux (version debian ou ubuntu : etc/php5/apache2/php.ini):
include_path = ".:/usr/share/php:/usr/share/php/openmairie:/usr/share/fpdf"

2.3 - Installation de openmairie_scrutin
* copier le repertoire openmairie_scrutin sur votre serveur
   exemples
        wamp/www/openmairie_scrutin
        sous linux (debian) : var/www/openmairie_scrutin


2.4 - Initialisation de la base en MySQL
    creer la base openscrutin
    puis executer les scripts SQL suivants :
    * avec mysql
    openmairie_scrutin/data/mysql/init.sql = création des tables (obligatoire)

    * dans dyn/var.inc mettre les variables suivante à vide
    $path_fpdf, $path_om, $path_pear


    la premiere initialisation se fait avec init.sql
    les modifications de version se font avec ver numero-de-version
    exemple: pour passer a la version 1.08 : ver1.08.sql    






2.5- Sous linux : mettre les droits d ecriture pour apache (www-data)
            
        * Repertoire trs : transfert de fichier
            /var/www/openmairie_scrutin$ sudo chown www-data:www-data trs
            /var/www/openmairie_scrutin$ sudo chmod 755 trs  
        * Repertoire tmp : ecriture des resultats de traitement
            /var/www/openmairie_scrutin$ sudo chown www-data:www-data tmp
        * Repertoire sql/mysql/  ecriture modification des etats et sous etats 
            /var/www/openmairie_scrutin$ sudo chown www-data:www-data mysql 
            /var/www/openmairie_scrutin$ sudo chown www-data:www-data mysql
 
Voir aussi les droits pour changement d ergonomie dans dyn et img
            
            (distribution debian ou ubuntu)



2.6 logo par collectivité 

Lettre type et état :
Pour chaque collectivite mettre le logo dans le trs/coll correspondant
(coll= numero de la collectivité)
Attention le logo doit porte le meme nom qu en trs : ex : logopdf.png
         trs/1   logopdf.png
         trs/2   logopdf.png  ...



3 - parametrage dyn/var.inc  
    =======================

Vous pouvez changer les parametres par defaut suivants

   
// mode demo *******************************************************************
$demo=1; // login.php mode demo =1 et mode non demo =0
// le mode demo desactive le changement de mot de passe (obj/utils.class.php)
// et met dans login par defaut demo/demo
//
// integration recherche globale dans tableau de bord 1 ou 0 *******************
$global_tdb=1;
// integration recherche globale dans menu haut 1 ou 0 *************************
$global_haut=1;
// integration choix apparence dans tableau de bord ****************************
$look_tdb=1;
// *****************************************************************************
// integration des dependances (pear + fpdf + openmairie)
// $path_xx = "" => mettre les dependances dans php ex wamp/php ou easy/php
// $path_xx = "../php/xx/ => utiliser les dependances du package openCimetiere
// *** dependances dans wamp/php ou easyphp/php
//$path_om="";
//$path_pear= "";
//$path_fpdf="";
//
$path_om="../php/openmairie/";
$path_pear= "../php/pear/";
$path_fpdf="../php/fpdf/";

// *****************************************************************************
$langue="francais"; // francais, anglais, allemand, espagnol
// *****************************************************************************
$verrou=1; // verrou =1 actif 0= inactif (empeche actualisation sur form validé)

// SPECIFIQUE OPENSCRUTIN
$client_cp = '13200';
$client_ville = 'ARLES';
$agent_centralisation="AGENT CENTRALISATION";




