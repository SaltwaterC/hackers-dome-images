<?php
//$Id: scrutin_elu_bureau.reqmo.inc,v 1.2 2008-07-28 09:09:50 jbastide Exp $
$reqmo['libelle']="elus_bureau";
$reqmo['sql']="select [scrutin],
                      concat(nom,' ',prenom) as nom,
                      [bureau],
                      [affectation.poste as poste],
                      [periode],
                      [candidat]
                      [decision],
                      from affectation inner join elu on affectation.elu=elu.elu
                      inner join poste on affectation.poste=poste.poste
                      where scrutin = '[SCRUTIN]'
                      and bureau='[BUREAU]'
                      order by bureau,poste.ordre";
//$reqmo['TRI']= array('bureau','poste','periode'
//                    );
//
$reqmo['candidat']="checked";
$reqmo['scrutin']="checked";
$reqmo['nom']="checked";
$reqmo['bureau']="checked";
$reqmo['poste']="checked";
$reqmo['periode']="checked";
$reqmo['decision']="checked";
$reqmo['SCRUTIN']="select scrutin,concat(scrutin,' ',libelle) as lib from scrutin where solde !='Oui'";
$reqmo['BUREAU']="select bureau,concat(bureau,' ',libelle) as lib from bureau order by bureau";

//
?>