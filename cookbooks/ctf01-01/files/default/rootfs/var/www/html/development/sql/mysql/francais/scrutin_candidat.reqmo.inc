<?php
$reqmo['libelle']="candidat_acceptes";
$reqmo['sql']="select [scrutin],
                      concat(nom,' ',prenom) as nom,
                      [adresse],
                      [concat(cp,' ',ville) as cpville],
                      [bureau],
                      [candidature.poste as poste],
                      [periode]

                      from candidature inner join agent on candidature.agent=agent.agent
                      where scrutin = '[SCRUTIN]' and decision = 'Oui'
                      order by [TRI]";
$reqmo['TRI']= array('bureau','poste','periode'
                    );
//
$reqmo['scrutin']="checked";
$reqmo['nom']="checked";
$reqmo['bureau']="checked";
$reqmo['poste']="checked";
$reqmo['periode']="checked";
$reqmo['adresse']="checked";
$reqmo['cpville']="checked";
$reqmo['telephone']="checked";
$reqmo['SCRUTIN']="select scrutin,concat(scrutin,' ',libelle) as lib from scrutin where solde !='Oui'";
//
?>