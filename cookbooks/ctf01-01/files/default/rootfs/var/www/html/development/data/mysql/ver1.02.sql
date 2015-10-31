# ver 1.02
# calcul automatique d heure par periode
ALTER TABLE `periode` ADD `debut` VARCHAR( 5 ) NOT NULL ,
ADD `fin` VARCHAR( 5 ) NOT NULL ;

# ordre de sortie des postes pour etat
ALTER TABLE `poste` ADD `ordre` INT NOT NULL ;

# candidat pour un scrutin
CREATE TABLE `candidat` (
`candidat` INT NOT NULL ,
`nom` VARCHAR( 50 ) NOT NULL ,
`scrutin` VARCHAR( 15 ) NOT NULL ,
PRIMARY KEY ( `candidat` ) 
);
# correction
ALTER TABLE `affectation` CHANGE `poste` `poste` VARCHAR( 20 ) NOT NULL ;
ALTER TABLE `candidature` CHANGE `poste` `poste` VARCHAR( 20 ) NOT NULL ;

CREATE TABLE `composition_bureau` (
  `scrutin` varchar(15) NOT NULL default '',
  `bureau` char(3) NOT NULL default '',
  `president` varchar(80) NOT NULL default '',
  `president_suppleant` varchar(80) NOT NULL default '',
  `secretaire` varchar(80) NOT NULL default ''
) TYPE=MyISAM;

ALTER TABLE `bureau` CHANGE `bureau` `bureau` CHAR( 2 ) NOT NULL;

