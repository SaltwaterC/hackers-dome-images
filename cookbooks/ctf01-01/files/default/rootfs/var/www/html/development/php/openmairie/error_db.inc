<?php
// $Id: error_db.inc,v 1.1 2008-07-24 13:18:52 jbastide Exp $
// openMairie : http://www.openmairie.org
// contact@openmairie.org

        $requete="";
        $erreur_origine="";
        $temp =explode('[',$debuginfo);
        if(isset($temp[0]))
           $requete=$temp[0];
        if (isset($temp[1]))
           $erreur_origine=substr($temp[1],0,strlen($temp[1])-1);
           $erreur_fr= array(
            'unknown error'        => 'erreur inconnue',
            'already exists'       => 'existe d�j�',
            'can not create'       => 'ne peux pas �tre cr�er',
            'can not delete'       => 'ne peux pas etre detruit',
            'can not drop'         =>  'table '.$table.' ne peut pas etre d�truite',
            'constraint violation' => 'Contrainte de cl� primaire, enregistrement d�ja existant',
            'null value violates not-null constraint'=> 'contrainte not-null non respect�e',
            'division by zero'     => 'division par zero',
            'invalid'              => 'invalide',
            'invalid date or time' => 'date ou heure invalide',
            'invalid number'       => 'nombre invalide',
            'mismatch'             => 'mismatch',
            'no database selected' => 'pas de database selectionn�e',
            'no such field'        => 'champ inexistant dans la table '.$table,
            'no such table'        =>  'table :'.$table.' inexistante',
            'DB backend not capable'=> 'DB backend not capable',
            'not found'            => 'non trouv�',
            'not locked'           => 'non lock�',
            'syntax error'         => 'erreur de syntaxe dans la requ�te',
            'not supported'        => 'non support�',
            'value count on row'   => 'value count on row',
            'invalid DSN'          => 'DSN invalide',
            'connect failed'       => 'connexion en erreur',
            'no error'             => 'pas d erreur',
            'insufficient data supplied' => 'insufficient data supplied',
            'extension not found'  => 'extension on trouv�e',
            'no such database'     => 'database non trouv�e',
            'insufficient permissions'   => 'permission insuffisante',
            'truncated'            => 'd�truit'
        );
        $message = substr($messageDB,10,strlen($messageDB));
        foreach (array_keys($erreur_fr) as $elem) {
            if ( $elem== $message){
                $msgfr = $erreur_fr[$elem];
            }
        }
        $erreur_origine = substr($erreur_origine,11,strlen($erreur_origine));
        $requete=str_replace(",",", ",$requete);
?>