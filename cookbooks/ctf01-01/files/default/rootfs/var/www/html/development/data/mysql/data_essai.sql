--
-- Contenu de la table `affectation`
--

INSERT INTO `affectation` (`affectation`, `elu`, `scrutin`, `periode`, `poste`, `bureau`, `note`, `decision`, `candidat`) VALUES
(1, 'E000002', 'MUN08-1', 'journee', 'PRESIDENT', '01', '', 'Oui', 'Dupont Pierre'),
(2, 'E000003', 'MUN08-1', 'journee', 'PRESIDENT SUPPLEANT', '01', '', 'Oui', 'Dupont Pierre'),
(3, 'E000001', 'MUN08-1', 'journee', 'PRESIDENT', '02', '', 'Oui', 'Dupont Pierre'),
(4, 'E000004', 'MUN08-1', 'journee', 'DELEGUE TITULAIRE', 'T', '', 'Oui', 'Durant Paul'),
(5, 'E000001', 'MUN08-2', 'journee', 'PRESIDENT', '02', 'transfert MUN08-1', 'Non', 'Dupont Pierre'),
(6, 'E000002', 'MUN08-2', 'journee', 'PRESIDENT', '01', 'transfert MUN08-1', 'Non', 'Dupont Pierre'),
(7, 'E000004', 'MUN08-2', 'journee', 'DELEGUE TITULAIRE', 'T', 'transfert MUN08-1', 'Non', 'Durant Paul');



--
-- Structure de la table `affectation_seq`
--

CREATE TABLE `affectation_seq` (
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) TYPE=InnoDB  AUTO_INCREMENT=8 ;

--
-- Contenu de la table `affectation_seq`
--

INSERT INTO `affectation_seq` (`id`) VALUES
(7);

--
-- Contenu de la table `agent`
--

INSERT INTO `agent` (`agent`, `nom`, `prenom`, `adresse`, `cp`, `ville`, `telephone`, `service`, `poste`, `grade`) VALUES
('00100', 'MARTIN', 'Germaine', '', '13200', 'ARLES', '', '33500', '', 'AB'),
('00101', 'MAUSSAN', 'Pierre', '', '13200', 'ARLES', '', '33500', '', 'AB'),
('00102', 'PINSON', 'Marie', '', '13200', 'ARLES', '', '33500', '', 'AB'),
('0104', 'GRAND', 'Paul', '', '13200', 'ARLES', '', '33500', '', 'DT');


--
-- Contenu de la table `bureau`
--

INSERT INTO `bureau` (`bureau`, `libelle`, `canton`, `adresse1`, `adresse2`, `cp`, `ville`) VALUES
('01', 'Hotel de ville', 'T', 'Place de la republique', '', '13200', 'ARLES'),
('02', 'Ecole Jules Valles', 'T', 'Ecole des Garcons', '', '13200', 'ARLES');



--
-- Contenu de la table `candidat`
--

INSERT INTO `candidat` (`candidat`, `nom`, `scrutin`) VALUES
(1, 'Durant Paul', 'MUN08-1'),
(2, 'Dupont Pierre', 'MUN08-1'),
(3, 'Dupont Pierre', 'MUN08-2'),
(4, 'Durant', 'MUN08-2');

-- --------------------------------------------------------

--
-- Contenu de la table `candidature`
--

INSERT INTO `candidature` (`candidature`, `agent`, `scrutin`, `periode`, `poste`, `bureau`, `recuperation`, `note`, `decision`, `debut`, `fin`) VALUES
(1, '0104', 'MUN08-1', 'journee', 'SECRETAIRE', '01', '', '1ère demande : SECRETAIRE au bureau 01 pendant  journee', 'Oui', '07:00', '23:00'),
(2, '00100', 'MUN08-1', 'apres-midi', 'PLANTON', '01', '', '1ère demande : PLANTON au bureau 01 pendant  apres-midi', 'Oui', '13:00', '22:00'),
(3, '00101', 'MUN08-1', 'apres-midi', 'SECRETAIRE', '02', '', '1ère demande : SECRETAIRE au bureau 02 pendant  apres-midi', 'Oui', '13:00', '22:00'),
(4, '00102', 'MUN08-1', 'apres-midi', 'PLANTON', '02', '', '1ère demande : PLANTON au bureau 02 pendant  apres-midi', 'Oui', '13:00', '22:00'),
(5, '00101', 'MUN08-2', 'apres-midi', 'SECRETAIRE', '02', '', 'transfert MUN08-1', 'Non', '', ''),
(6, '0104', 'MUN08-2', 'journee', 'SECRETAIRE', '01', '', 'transfert MUN08-1', 'Oui', '07:00', '23:00'),
(7, '00100', 'MUN08-2', 'apres-midi', 'PLANTON', '01', '', 'transfert MUN08-1', 'Oui', '13:00', '22:00'),
(8, '00102', 'MUN08-2', 'apres-midi', 'PLANTON', '02', '', 'transfert MUN08-1', 'Non', '', '');



--
-- Structure de la table `candidature_seq`
--

CREATE TABLE `candidature_seq` (
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) TYPE=InnoDB  AUTO_INCREMENT=9 ;

--
-- Contenu de la table `candidature_seq`
--

INSERT INTO `candidature_seq` (`id`) VALUES
(8);

--
-- Structure de la table `candidat_seq`
--

CREATE TABLE `candidat_seq` (
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) TYPE=InnoDB  AUTO_INCREMENT=5 ;


--
-- Contenu de la table `candidat_seq`
--

INSERT INTO `candidat_seq` (`id`) VALUES
(4);

--
-- Contenu de la table `canton`
--

INSERT INTO `canton` (`canton`, `libelle`) VALUES
('T', 'Tous canton');

--
-- Contenu de la table `composition_bureau`
--

INSERT INTO `composition_bureau` (`scrutin`, `bureau`, `president`, `president_suppleant`, `secretaire`) VALUES
('MUN08-2', '01', '', '', 'GRAND Paul'),
('MUN08-2', '02', '', '', '');


--
-- Contenu de la table `elu`
--

INSERT INTO `elu` (`elu`, `nom`, `prenom`, `nomjf`, `date_naissance`, `lieu_naissance`, `adresse`, `cp`, `ville`) VALUES
('E000001', 'LEMAIRE', 'paul', '', '0000-00-00', '', '', '13200', 'ARLES'),
('E000002', 'LADJOINT', 'josette', '', '0000-00-00', '', '', '13200', 'ARLES'),
('E000003', 'LECONSEILLER', 'jules', '', '0000-00-00', '', '', '13200', 'ARLES'),
('E000004', 'POLO', 'Walter', '', '0000-00-00', '', '', '13200', 'ARLES');

-- --------------------------------------------------------
--
-- Structure de la table `elu_seq`
--

CREATE TABLE `elu_seq` (
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) TYPE=InnoDB  AUTO_INCREMENT=5 ;

--
-- Contenu de la table `elu_seq`
--

INSERT INTO `elu_seq` (`id`) VALUES
(4);

--
-- Contenu de la table `grade`
--

INSERT INTO `grade` (`grade`, `libelle`) VALUES
('DT', 'Directeur Territorial'),
('AB', 'Agent de bureau');

--
-- Contenu de la table `scrutin`
--

INSERT INTO `scrutin` (`scrutin`, `libelle`, `tour`, `canton`, `date_scrutin`, `solde`, `convocation_agent`, `convocation_president`) VALUES
('MUN08-1', 'Municipales 1er Tour', '1', 'T', '2008-10-19', 'Oui', 'Salle des Pas Perdus le 18/10/2008 à 15 heures', 'Salle du conseil le 18/10/2008 à 20 heures'),
('MUN08-2', 'Municipales 2eme Tour', '2', 'T', '2008-10-26', '', '25 Octobre 2008 Salle des Pas Perdus', '25 Octobre 2008 Salle du conseil');

-- --------------------------------------------------------
--
-- Contenu de la table `service`
--

INSERT INTO `service` (`service`, `libelle`) VALUES
('33500', 'Informatique'),
('33510', 'Telecoms');