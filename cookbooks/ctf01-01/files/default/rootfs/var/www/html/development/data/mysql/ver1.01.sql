# ver 1.01

ALTER TABLE `candidature` CHANGE `poste` `poste` VARCHAR( 15 ) NOT NULL ;

CREATE TABLE `poste` (
  `poste` varchar(20) NOT NULL default '',
  `nature` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`poste`)
) TYPE=MyISAM;

INSERT INTO `poste` VALUES ('SECRETAIRE', 'candidature');
INSERT INTO `poste` VALUES ('PLANTON', 'candidature');
INSERT INTO `poste` VALUES ('PRESIDENT', 'affectation');
INSERT INTO `poste` VALUES ('VICE-PRESIDENT', 'affectation');
INSERT INTO `poste` VALUES ('DELEGUE', 'affectation');
INSERT INTO `poste` VALUES ('ASSESSEUR TITULAIRE', 'affectation');
INSERT INTO `poste` VALUES ('ASSESSEUR SUPPLEANT', 'affectation');



CREATE TABLE `periode` (
`periode` VARCHAR( 15 ) NOT NULL ,
`libelle` VARCHAR( 40 ) NOT NULL ,
PRIMARY KEY ( `periode` ) 
);

INSERT INTO `periode` VALUES ('matin', '7 heures à 13 heures');
INSERT INTO `periode` VALUES ('apres-midi', '13 heures à la fin');
INSERT INTO `periode` VALUES ('journee', '7 heures à la fin');

ALTER TABLE `bureau` DROP `zone` ;
ALTER TABLE `bureau` ADD `adresse1` VARCHAR( 60 ) NOT NULL ,
ADD `adresse2` VARCHAR( 60 ) NOT NULL ,
ADD `cp` VARCHAR( 5 ) NOT NULL ,
ADD `ville` VARCHAR( 40 ) NOT NULL ;

update bureau set cp = '13200', ville='ARLES' ;