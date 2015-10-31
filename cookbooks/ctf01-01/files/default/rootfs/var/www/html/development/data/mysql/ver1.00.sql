# ver 1.00
# modification de la base des versions "maquette"
ALTER TABLE `affectation` ADD `candidat` VARCHAR( 40 ) NOT NULL ;
ALTER TABLE `affectation` CHANGE `poste` `poste` VARCHAR( 20 ) NOT NULL ;
ALTER TABLE `scrutin` ADD `convocation_agent` VARCHAR( 100 ) NOT NULL ,
ADD `convocation_president` VARCHAR( 100 ) NOT NULL ;
drop table zone;