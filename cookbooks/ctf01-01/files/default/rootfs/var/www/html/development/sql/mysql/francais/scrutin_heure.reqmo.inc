<?php
//$Id: scrutin_heure.reqmo.inc,v 1.2 2008-07-28 09:09:50 jbastide Exp $
$reqmo['libelle']="etat_des_heures_supplementaires_en_lien_avec_ooo";
$reqmo['sql']="select agent.agent,
                      concat(nom,' ',prenom) as nom,
                      concat(candidature.poste,' (',bureau,')') as poste,
                      periode,
                      debut,fin, recuperation
                      from candidature inner join agent on candidature.agent=agent.agent
                      where scrutin = '[SCRUTIN]' and decision ='Oui'
                      order by [TRI]";
$reqmo['TRI']= array('bureau','poste','periode'
                    );
//
$reqmo['SCRUTIN']="select scrutin,concat(scrutin,' ',libelle) as lib from scrutin where solde !='Oui'";
//
?>