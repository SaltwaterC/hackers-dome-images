$Id: readme_english.txt,v 1.2 2008-10-21 04:49:01 fraynaud1 Exp $
=======================================
All the documentation of openMairie on:
http://www.openmairie.org
=======================================

Prerequisite :
============
You must have the following services installed :
- Apache server with php extension
- database server : mysql 

You should report to the installations of :
- for windows : wamp (http://www.wampserver.com/) or easyphp(http://easyphp.fr/)
- for Linux : lamp

If you're new to all that, it'd be easier to keep mysql that comes included in the
easyphp or wamp package.

Since version 1.02, it is now possible to perform an easy install(1)

This install should interest you :
- if you want to make a quick try
- if you don't have any other openMairie application
- if you want to install openscrutin on a provider platform
   (be careful to have an access to a mysql or pgsql database server)

The normal installation with dependencies is still possible(2), it is recommended if you can perform administration tasks on your server.

You can set up your parameters file dyn/var.inc(3)



1- Easy install [default]
   ================

1.1 - Install openmairie_scrutin
   copy the openmairie_scrutin folder on your server
   examples
        wamp/www/openmairie_scrutin
        for Linux (Debian) : var/www/openmairie_scrutin

1.2 - Initialize the MySQL database
    create the openscrutin database on mysql
    Then, you have to create the database tables
    then execute the following SQL scripts :
    - for mysql :
    openmairie_scrutin/data/mysql/init.sql

The first initialisation runs with init.sql
The version upgrades run with ver.version-number
example: to upgrade to version 1.08 : ver1.08.sql

1.3 setting up the connection in /dyn/base.php

default settings :

* collectivite 1 (with mysql) : coll[1] is a php array containing the following connection settings
    'titre => 'openscrutin (mysql)',[openscrutin setting]
    'phptype'  => 'mysql', [do not change dbpear setting]
    'dbsyntax' => '',[do not change dbpear setting]
    'username' => 'root', [default setting on wamp easyphp or lamp /
                           see with provider if needed]
    'password' => '' [default setting on wamp easyphp or lamp /
                           see with provider if needed]
    'protocol' => '',
    'hostspec' => 'localhost', [default server name for wamp or easyphp]
    'port'     => '',  [do not change dbpear setting]
    'socket'   => '',  [do not change dbpear setting]
    dbname => 'openscrutin', [openscrutin setting]
    default date format =>'AAAA-MM-JJ' [do not change openscrutin setting]

On Linux, you have to set the "write" permissions 
Setting up the logo 



2. Installing openscrutin with dependencies
   ===============================

This install is more complicated but it is more coherent on the Apache side if several applications use the same components.

Please report on the full documentation on the adullact website on the following address (French)
http://openmairie.org/demonstration/openscrutin-1/installation_openscrutin.pdf/view

2.1 -  installing the 3 libraries (mandatory)

example with wamp or Linux (ubuntu / Debian)

  pear : wamp/php/pear /usr/share/php/PEAR
           PEAR Base System PHP : http://pear.php.net/package/PEAR
           pear db  :  http://www.pear.php.net/package/DB

  fpdf  : wamp/php/fpdf   /usr/share/fpdf 
           http://www.fpdf.org

  openmairie : wamp/php/openmairie or /usr/share/php/openmairie 
    http://www.openmairie.org 
    version >= 2.01

2.2 - modify the path in php.ini

* example for windows with wamp5
    include_path= ".;c:\wamp\php\includes;c:\wamp\php\pear;c:\wamp\php\fpdf;c:\wamp\php\openmairie"
* example for Linux (Debian or ubuntu : /etc/php5/Apache2/php.ini):
    include_path = ".:/usr/share/php:/usr/share/php/openmairie:/usr/share/fpdf"

2.3 - Installing openmairie_scrutin


* copy the openmairie_scrutin folder on your server
   examples
        wamp/www/openmairie_scrutin
        for Linux (Debian) : /var/www/openmairie_scrutin


2.4 - Initialize the MySQL database

    create the openscrutin database

    then execute the following SQL scripts :

    * with mysql
    openmairie_scrutin/data/mysql/init.sql = creating the tables (mandatory)



    set up the connection in /dyn/base.php (see 1.3)

    * in dyn/var.inc set the following variables with no value

    $path_fpdf, $path_om, $path_pear


    the first initialization is done with init.sql
    the version upgrades are done with ver.version_number
    example: to upgrade to version 1.08 : ver1.08.sql    



2.5- Linux : setting the write permissions for Apache (www-data)
            
        * trs folder : file transfer
            /var/www/openmairie_scrutin$ sudo chown www-data:www-data trs
            /var/www/openmairie_scrutin$ sudo chmod 755 trs  
        * tmp folder : writing the process results
            /var/www/openmairie_scrutin$ sudo chown www-data:www-data tmp
        * sql/mysql/ folder : writing and modifying the states and sub states
            /var/www/openmairie_scrutin$ sudo chown www-data:www-data mysql 
            /var/www/openmairie_scrutin$ sudo chown www-data:www-data mysql
        * sql/pgsql/ folder : writing and modifying the states and sub states
            /var/www/openmairie_scrutin$ sudo chown www-data:www-data pgsql
            /var/www/openmairie_scrutin$ sudo chown www-data:www-data pgsql
            
         
	 setting write permission directories img and dyn for ergonomia
 
   (Debian / ubuntu)



2.6 logo per collectivity 

Template and status :
For each collectivity, put the logo in the /trs/coll corresponding
(coll= number of the collectivity)
Be careful, the logo must be named like in trs : ex : logopdf.png
         trs/1   logopdf.png
         trs/2   logopdf.png  ...


3 - global parameters in var.inc  
    =============================
    Global search can be configured in dyn/var.inc to optimize large response times when starting the application
     // 1 = calculate all occurrences then possible search on input
     // 0 = only calculate on input search
     $global_flag=1;   (default)


     language can be configured in dyn/var.inc 
      $langue="francais";   (default)
      
     actual options:
     - francais= french
     - anglais=english
     - espagnol= spanish
     -  allemand= german
    
others:
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




