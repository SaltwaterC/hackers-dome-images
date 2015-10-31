-- phpMyAdmin SQL Dump
-- version 2.11.2.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mar 21 Octobre 2008 à 06:14
-- Version du serveur: 5.0.45
-- Version de PHP: 5.2.5

--
-- Base de données: `openscrutin`
--

-- --------------------------------------------------------

--
-- Structure de la table `affectation`
--

CREATE TABLE `affectation` (
  `affectation` int(8) NOT NULL default '0',
  `elu` varchar(10) NOT NULL default '',
  `scrutin` varchar(10) NOT NULL default '',
  `periode` varchar(10) NOT NULL default '',
  `poste` varchar(20) NOT NULL default '',
  `bureau` char(3) NOT NULL default '',
  `note` longtext NOT NULL,
  `decision` char(3) NOT NULL default '',
  `candidat` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`affectation`)
) TYPE=MyISAM;


-- --------------------------------------------------------

--
-- Structure de la table `agent`
--

CREATE TABLE `agent` (
  `agent` varchar(10) NOT NULL default '',
  `nom` varchar(40) NOT NULL default '',
  `prenom` varchar(40) NOT NULL default '',
  `adresse` varchar(80) NOT NULL default '',
  `cp` varchar(5) NOT NULL default '',
  `ville` varchar(40) NOT NULL default '',
  `telephone` varchar(14) NOT NULL default '',
  `service` varchar(10) NOT NULL default '',
  `poste` varchar(4) NOT NULL default '',
  `grade` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`agent`)
) TYPE=MyISAM;

-- --------------------------------------------------------
--
-- Structure de la table `bureau`
--

CREATE TABLE `bureau` (
  `bureau` char(3) NOT NULL default '',
  `libelle` varchar(30) NOT NULL default '',
  `canton` varchar(8) NOT NULL default '',
  `adresse1` varchar(60) NOT NULL default '',
  `adresse2` varchar(60) NOT NULL default '',
  `cp` varchar(5) NOT NULL default '',
  `ville` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`bureau`),
  UNIQUE KEY `bureau` (`bureau`)
) TYPE=MyISAM;


-- --------------------------------------------------------

--
-- Structure de la table `candidat`
--

CREATE TABLE `candidat` (
  `candidat` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `scrutin` varchar(15) NOT NULL,
  PRIMARY KEY  (`candidat`)
) TYPE=InnoDB;

-- --------------------------------------------------------

--
-- Structure de la table `candidature`
--

CREATE TABLE `candidature` (
  `candidature` int(8) NOT NULL default '0',
  `agent` varchar(10) NOT NULL default '',
  `scrutin` varchar(10) NOT NULL default '',
  `periode` varchar(10) NOT NULL default '',
  `poste` varchar(20) NOT NULL default '',
  `bureau` char(3) NOT NULL default '',
  `recuperation` char(3) NOT NULL default '',
  `note` longtext NOT NULL,
  `decision` char(3) NOT NULL default '',
  `debut` varchar(5) NOT NULL default '',
  `fin` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`candidature`)
) TYPE=MyISAM;




-- --------------------------------------------------------

--
-- Structure de la table `canton`
--

CREATE TABLE `canton` (
  `canton` varchar(8) NOT NULL default '',
  `libelle` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`canton`)
) TYPE=MyISAM;



-- --------------------------------------------------------

--
-- Structure de la table `collectivite`
--

CREATE TABLE `collectivite` (
  `ville` varchar(30) NOT NULL default '',
  `logo` varchar(40) NOT NULL default '',
  `maire` varchar(40) NOT NULL default '',
  `id` int(2) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Contenu de la table `collectivite`
--

INSERT INTO `collectivite` (`ville`, `logo`, `maire`, `id`) VALUES
('LibreVille / mysql', '../img/logo.png', 'openmairie', 0);

-- --------------------------------------------------------

--
-- Structure de la table `composition_bureau`
--

CREATE TABLE `composition_bureau` (
  `scrutin` varchar(15) NOT NULL default '',
  `bureau` char(3) NOT NULL default '',
  `president` varchar(80) NOT NULL default '',
  `president_suppleant` varchar(80) NOT NULL default '',
  `secretaire` varchar(80) NOT NULL default ''
) TYPE=MyISAM;



-- --------------------------------------------------------

--
-- Structure de la table `composition_bureau_agent`
--

CREATE TABLE `composition_bureau_agent` (
  `scrutin` varchar(15) NOT NULL default '',
  `bureau` char(3) NOT NULL default '',
  `secretaire_matin` varchar(80) NOT NULL default '',
  `secretaire_apm` varchar(80) NOT NULL default '',
  `planton_matin` varchar(80) NOT NULL default '',
  `planton_apm` varchar(80) NOT NULL default ''
) TYPE=MyISAM;

--
-- Contenu de la table `composition_bureau_agent`
--


-- --------------------------------------------------------

--
-- Structure de la table `droit`
--

CREATE TABLE `droit` (
  `droit` varchar(30) NOT NULL default '',
  `profil` int(2) NOT NULL default '0',
  PRIMARY KEY  (`droit`)
) TYPE=MyISAM;

--
-- Contenu de la table `droit`
--

INSERT INTO `droit` (`droit`, `profil`) VALUES
('utilisateur', 5),
('droit', 5),
('profil', 5),
('collectivite', 4),
('edition', 4),
('txtab', 4),
('agent', 3),
('elu', 3),
('scrutin', 3),
('service', 3),
('grade', 3),
('bureau', 4),
('canton', 4),
('periode', 4),
('poste', 4);

-- --------------------------------------------------------

--
-- Structure de la table `elu`
--

CREATE TABLE `elu` (
  `elu` varchar(10) NOT NULL default '',
  `nom` varchar(40) NOT NULL default '',
  `prenom` varchar(40) NOT NULL default '',
  `nomjf` varchar(40) NOT NULL default '',
  `date_naissance` date NOT NULL default '0000-00-00',
  `lieu_naissance` varchar(40) NOT NULL default '',
  `adresse` varchar(80) NOT NULL default '',
  `cp` varchar(5) NOT NULL default '',
  `ville` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`elu`)
) TYPE=MyISAM;





-- --------------------------------------------------------

--
-- Structure de la table `grade`
--

CREATE TABLE `grade` (
  `grade` varchar(10) NOT NULL default '',
  `libelle` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`grade`)
) TYPE=MyISAM;


-- --------------------------------------------------------

--
-- Structure de la table `periode`
--

CREATE TABLE `periode` (
  `periode` varchar(15) NOT NULL default '',
  `libelle` varchar(40) NOT NULL default '',
  `debut` varchar(5) NOT NULL default '00:00',
  `fin` varchar(5) NOT NULL default '00:00',
  PRIMARY KEY  (`periode`)
) TYPE=MyISAM;

--
-- Contenu de la table `periode`
--

INSERT INTO `periode` (`periode`, `libelle`, `debut`, `fin`) VALUES
('matin', '7 heures a 13 heures', '07:00', '13:00'),
('apres-midi', '13 heures a la fin', '13:00', '22:00'),
('journee', '7 heures a la fin', '07:00', '23:00');

-- --------------------------------------------------------

--
-- Structure de la table `poste`
--

CREATE TABLE `poste` (
  `poste` varchar(20) NOT NULL default '',
  `nature` varchar(15) NOT NULL default '',
  `ordre` int(11) NOT NULL default '0',
  PRIMARY KEY  (`poste`)
) TYPE=MyISAM;

--
-- Contenu de la table `poste`
--

INSERT INTO `poste` (`poste`, `nature`, `ordre`) VALUES
('SECRETAIRE', 'candidature', 0),
('PLANTON', 'candidature', 0),
('PRESIDENT', 'affectation', 1),
('DELEGUE TITULAIRE', 'affectation', 5),
('ASSESSEUR TITULAIRE', 'affectation', 3),
('ASSESSEUR SUPPLEANT', 'affectation', 4),
('AGENT CENTRALISATION', 'candidature', 0),
('DELEGUE SUPPLEANT', 'affectation', 6),
('PRESIDENT SUPPLEANT', 'affectation', 2);

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `profil` int(2) NOT NULL default '0',
  `libelle_profil` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`profil`)
) TYPE=MyISAM;

--
-- Contenu de la table `profil`
--

INSERT INTO `profil` (`profil`, `libelle_profil`) VALUES
(5, 'ADMINISTRATEUR'),
(4, 'SUPER UTILISATEUR'),
(3, 'UTILISATEUR'),
(2, 'UTILISATEUR LIMITE'),
(1, 'CONSULTATION');

-- --------------------------------------------------------

--
-- Structure de la table `scrutin`
--

CREATE TABLE `scrutin` (
  `scrutin` varchar(15) NOT NULL default '',
  `libelle` varchar(40) NOT NULL default '',
  `tour` char(1) NOT NULL default '',
  `canton` char(1) NOT NULL default '',
  `date_scrutin` date NOT NULL default '0000-00-00',
  `solde` char(3) NOT NULL default '',
  `convocation_agent` varchar(100) NOT NULL default '',
  `convocation_president` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`scrutin`)
) TYPE=MyISAM;


-- --------------------------------------------------------
--
-- Structure de la table `service`
--

CREATE TABLE `service` (
  `service` varchar(10) NOT NULL default '',
  `libelle` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`service`)
) TYPE=MyISAM;



-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `idUtilisateur` int(8) NOT NULL default '0',
  `nom` varchar(30) NOT NULL default '',
  `Login` varchar(30) NOT NULL default '',
  `Pwd` varchar(100) NOT NULL default '',
  `profil` int(2) NOT NULL default '0',
  `email` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`idUtilisateur`)
) TYPE=MyISAM;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idUtilisateur`, `nom`, `Login`, `Pwd`, `profil`, `email`) VALUES
(1, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 5, 'contact@openmairie.org'),
(2, 'demo', 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 4, 'contact@openmairie.org');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_seq`
--

CREATE TABLE `utilisateur_seq` (
  `id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Contenu de la table `utilisateur_seq`
--

INSERT INTO `utilisateur_seq` (`id`) VALUES
(2);
