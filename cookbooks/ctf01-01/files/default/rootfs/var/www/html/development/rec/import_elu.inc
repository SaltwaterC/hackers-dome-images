<?php
// $Id: import_elu.inc,v 1.1 2008-01-23 11:25:12 fraynaud1 Exp $
$import= "Insertion dans elu";
$table= "elu";
$id=""; // numerotation automatique
// admin======================================================================
// verrou= 1 mise a jour de la base
//       = 0 pas de mise a jour  => phase de test
// debug=1 affichage des enregistrements à l ecran
//      =0 pas d affichage
// =============================================================================
$verrou=1;// =0 pas de mise a jour de la base / =1 mise à jour
$DEBUG=1; // =0 pas d affichage messages / =1 affichage detail enregistrement
$fic_erreur=1; // =0 pas de fichier d erreur / =1  fichier erreur
$fic_rejet=1; // =0 pas de fichier pour relance / =1 fichier relance traitement
                // contenant les enregistrements en erreur
// 1ere ligne ==================================================================
// la premiere ligne contient les noms de champs
// 1=oui
// 0=non
// =============================================================================
$ligne1=1;
// parametrage des controles ===================================================
// zone obligatoire
//$obligatoire['nom']=1;// obligatoire = 1
// test d existence si le profil existe dans la table des profils
//$exist['profil']=1;//  0=non / 1=oui
//$sql_exist['profil']= "select * from profil where profil = '";
//  zone à inserer ============================================================
// insertion d un enregistrement dans la table mouvement
// liste des zones à inserer
// mettre en commentaire les zones non traitées
// =============================================================================
      $zone['elu']='0';
      $zone['nom']='1';
      $zone['prenom']='2';
      $zone['adresse']='5';
      $zone['lieu_naissance']='4';
      $zone['ville']='';
      $zone['cp']='';
      $zone['temp']='6';
// par defaut =====================================
     $defaut['ville']='ARLES'; // profil par defaut si non renseigné
     $defaut['cp']='13200';
?>