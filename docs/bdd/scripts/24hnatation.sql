-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Dim 10 Février 2013 à 21:43
-- Version du serveur: 5.5.25
-- Version de PHP: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `24hnatation`
--

-- --------------------------------------------------------

--
-- Structure de la table `ACTIVITES`
--

CREATE TABLE IF NOT EXISTS `ACTIVITES` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOM` varchar(200) NOT NULL,
  `DESCRIPTION` varchar(1000) NOT NULL,
  `INSCRIPTIBLE` tinyint(1) NOT NULL,
  `DATE_DEBUT` int(11) NOT NULL,
  `HEURE_DEBUT` varchar(5) NOT NULL,
  `DATE_FIN` int(11) NOT NULL,
  `HEURE_FIN` varchar(5) NOT NULL,
  `TYPE` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `ID_2` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `ACTIVITES`
--

INSERT INTO `ACTIVITES` (`ID`, `NOM`, `DESCRIPTION`, `INSCRIPTIBLE`, `DATE_DEBUT`, `HEURE_DEBUT`, `DATE_FIN`, `HEURE_FIN`, `TYPE`) VALUES
(1, 'Tournoi de water-polo', 'saut en parachute de la mort.', 1, 1, '19:00', 1, '21:00', 3),
(2, 'Batème de plongée', 'Fou la vie', 1, 1, '18:00', 1, '20:00', 4),
(3, 'Spectacle de plongeon', 'sur 1 jour, le deuxième jour', 0, 1, '21:00', 1, '21:00', 0),
(4, 'Challenge élèves', 'sur deux jours !', 1, 1, '20:00', 1, '21:00', 5),
(5, 'Spectacle de natation synchronisée', 'c''est beau', 0, 1, '21:30', 1, '21:30', 0),
(6, 'Cours d''initiation au plongeon', 'cours super', 0, 1, '21:50', 1, '22:10', 0),
(7, 'Spectacle de plongeon (loufoque)', 'Pour le rire', 0, 1, '22:20', 1, '22:20', 0),
(8, 'Finale du tournoi de Water Polo', 'finale', 0, 1, '22:30', 1, '22:30', 0),
(9, 'Fil Rouge', 'The fil rouge', 1, 1, '13:00', 2, '13:00', 1),
(10, 'Challenge cadres', 'the challenge', 1, 2, '11:00', 2, '12:00', 2);

-- --------------------------------------------------------

--
-- Structure de la table `INSCRIPTIONS_BAPTEMES`
--

CREATE TABLE IF NOT EXISTS `INSCRIPTIONS_BAPTEMES` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ACTIVITE` int(11) NOT NULL,
  `UID` varchar(101) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `INSCRIPTIONS_BAPTEMES`
--

INSERT INTO `INSCRIPTIONS_BAPTEMES` (`ID`, `ID_ACTIVITE`, `UID`) VALUES
(1, 2, 'francois.espinet');

-- --------------------------------------------------------

--
-- Structure de la table `INSCRIPTIONS_EQUIPES`
--

CREATE TABLE IF NOT EXISTS `INSCRIPTIONS_EQUIPES` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UID` varchar(101) NOT NULL,
  `ID_ACTIVITE` int(11) NOT NULL,
  `NOM_EQUIPE` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `INSCRIPTIONS_EQUIPES`
--

INSERT INTO `INSCRIPTIONS_EQUIPES` (`ID`, `UID`, `ID_ACTIVITE`, `NOM_EQUIPE`) VALUES
(4, 'francois.espinet', 4, 'Mythe'),
(5, 'francois.espinet', 4, 'Mythe');

-- --------------------------------------------------------

--
-- Structure de la table `INSCRIPTIONS_FIL_ROUGES`
--

CREATE TABLE IF NOT EXISTS `INSCRIPTIONS_FIL_ROUGES` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ACTIVITE` int(11) NOT NULL,
  `UID` varchar(101) NOT NULL,
  `TYPE_INSCRIPTION` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `INSCRIPTIONS_FIL_ROUGES`
--

INSERT INTO `INSCRIPTIONS_FIL_ROUGES` (`ID`, `ID_ACTIVITE`, `UID`, `TYPE_INSCRIPTION`) VALUES
(1, 9, 'francois.espinet', 1);

-- --------------------------------------------------------

--
-- Structure de la table `INSCRIPTIONS_INDIVIDUELLES`
--

CREATE TABLE IF NOT EXISTS `INSCRIPTIONS_INDIVIDUELLES` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ACTIVITE` int(11) NOT NULL,
  `UID` varchar(101) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `INSCRIPTIONS_INDIVIDUELLES`
--

INSERT INTO `INSCRIPTIONS_INDIVIDUELLES` (`ID`, `ID_ACTIVITE`, `UID`) VALUES
(2, 10, 'francois.espinet');

-- --------------------------------------------------------

--
-- Structure de la table `INSCRIPTIONS_TOURNOIS`
--

CREATE TABLE IF NOT EXISTS `INSCRIPTIONS_TOURNOIS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UID` varchar(101) NOT NULL,
  `ID_ACTIVITE` int(11) NOT NULL,
  `NOM_EQUIPE` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `ID_2` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `INSCRIPTIONS_TOURNOIS`
--

INSERT INTO `INSCRIPTIONS_TOURNOIS` (`ID`, `UID`, `ID_ACTIVITE`, `NOM_EQUIPE`) VALUES
(1, 'francois.espinet', 1, 'The coops');

-- --------------------------------------------------------

--
-- Structure de la table `LIEN_PARTICIPANTS_INSCRIPTIONS`
--

CREATE TABLE IF NOT EXISTS `LIEN_PARTICIPANTS_INSCRIPTIONS` (
  `ID` int(11) NOT NULL,
  `ID_PARTICIPANT` int(11) NOT NULL,
  `ID_INSCRIPTION` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ORGANISATEURS`
--

CREATE TABLE IF NOT EXISTS `ORGANISATEURS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOM` varchar(50) NOT NULL,
  `PRENOM` varchar(50) NOT NULL,
  `TELEPHONE` varchar(14) NOT NULL,
  `ID_ROLE` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `ORGANISATEURS`
--

INSERT INTO `ORGANISATEURS` (`ID`, `NOM`, `PRENOM`, `TELEPHONE`, `ID_ROLE`) VALUES
(1, 'Ducreux', 'Thomas', '06 31 02 42 03', 1),
(2, 'Geoffroy', 'Chevalier', '06 33 31 96 08', 2),
(3, 'Aoustin', 'Frédéric', '06 77 01 67 36', 3);

-- --------------------------------------------------------

--
-- Structure de la table `PARTICIPANTS`
--

CREATE TABLE IF NOT EXISTS `PARTICIPANTS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOM_PRENOM` varchar(101) NOT NULL,
  `ID_INSCRIPTION` int(11) NOT NULL,
  `ID_ACTIVITE` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `PARTICIPANTS`
--

INSERT INTO `PARTICIPANTS` (`ID`, `NOM_PRENOM`, `ID_INSCRIPTION`, `ID_ACTIVITE`) VALUES
(3, 'coucou|toi', 1, 9),
(4, 'Jean Roussel|Pierre a Feu', 1, 1),
(6, 'coucou|youhou|azeaze', 4, 4),
(7, 'coucou|youhou|azeaze', 5, 4);

-- --------------------------------------------------------

--
-- Structure de la table `PHOTOS`
--

CREATE TABLE IF NOT EXISTS `PHOTOS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UID_UTILISATEUR` varchar(101) NOT NULL,
  `NOM_FICHIER` varchar(100) NOT NULL,
  `ID_CATEGORIE` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `PHOTOS`
--

INSERT INTO `PHOTOS` (`ID`, `UID_UTILISATEUR`, `NOM_FICHIER`, `ID_CATEGORIE`) VALUES
(4, 'francois.espinet', '2012-01.jpg', 5),
(5, 'francois.espinet', '2012-02.jpg', 5);

-- --------------------------------------------------------

--
-- Structure de la table `REF_CATEGORIES`
--

CREATE TABLE IF NOT EXISTS `REF_CATEGORIES` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `LIBELLE` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `REF_CATEGORIES`
--

INSERT INTO `REF_CATEGORIES` (`ID`, `LIBELLE`) VALUES
(5, '2012');

-- --------------------------------------------------------

--
-- Structure de la table `REF_CRENEAUX`
--

CREATE TABLE IF NOT EXISTS `REF_CRENEAUX` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ACTIVITE` int(11) NOT NULL,
  `ID_INSCRIPTION` int(11) NOT NULL DEFAULT '0',
  `ID_JOUR` int(11) NOT NULL,
  `HEURE_DEBUT` varchar(5) NOT NULL,
  `HEURE_FIN` varchar(5) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=192 ;

--
-- Contenu de la table `REF_CRENEAUX`
--

INSERT INTO `REF_CRENEAUX` (`ID`, `ID_ACTIVITE`, `ID_INSCRIPTION`, `ID_JOUR`, `HEURE_DEBUT`, `HEURE_FIN`) VALUES
(1, 9, 0, 1, '13:00', '13:10'),
(2, 9, 0, 1, '13:10', '13:20'),
(3, 9, 0, 1, '13:20', '13:30'),
(4, 9, 0, 1, '13:30', '13:40'),
(5, 9, 0, 1, '13:40', '13:50'),
(6, 9, 0, 1, '13:50', '14:00'),
(7, 9, 0, 1, '14:00', '14:10'),
(8, 9, 0, 1, '14:10', '14:20'),
(9, 9, 0, 1, '14:20', '14:30'),
(10, 9, 0, 1, '14:30', '14:40'),
(11, 9, 0, 1, '14:40', '14:50'),
(12, 9, 0, 1, '14:50', '15:00'),
(13, 9, 0, 1, '15:00', '15:10'),
(14, 9, 0, 1, '15:10', '15:20'),
(15, 9, 0, 1, '15:20', '15:30'),
(16, 9, 0, 1, '15:30', '15:40'),
(17, 9, 0, 1, '15:40', '15:50'),
(18, 9, 0, 1, '15:50', '16:00'),
(19, 9, 0, 1, '16:00', '16:10'),
(20, 9, 0, 1, '16:10', '16:20'),
(21, 9, 0, 1, '16:20', '16:30'),
(22, 9, 0, 1, '16:30', '16:40'),
(23, 9, 0, 1, '16:40', '16:50'),
(24, 9, 0, 1, '16:50', '17:00'),
(25, 9, 0, 1, '17:00', '17:10'),
(26, 9, 0, 1, '17:10', '17:20'),
(27, 9, 0, 1, '17:20', '17:30'),
(28, 9, 0, 1, '17:30', '17:40'),
(29, 9, 0, 1, '17:40', '17:50'),
(30, 9, 0, 1, '17:50', '18:00'),
(31, 9, 0, 1, '18:00', '18:10'),
(32, 9, 0, 1, '18:10', '18:20'),
(33, 9, 0, 1, '18:20', '18:30'),
(34, 9, 0, 1, '18:30', '18:40'),
(35, 9, 0, 1, '18:40', '18:50'),
(36, 9, 0, 1, '18:50', '19:00'),
(37, 9, 0, 1, '19:00', '19:10'),
(38, 9, 0, 1, '19:10', '19:20'),
(39, 9, 0, 1, '19:20', '19:30'),
(40, 9, 0, 1, '19:30', '19:40'),
(41, 9, 0, 1, '19:40', '19:50'),
(42, 9, 0, 1, '19:50', '20:00'),
(43, 9, 0, 1, '20:00', '20:10'),
(44, 9, 0, 1, '20:10', '20:20'),
(45, 9, 0, 1, '20:20', '20:30'),
(46, 9, 0, 1, '20:30', '20:40'),
(47, 9, 0, 1, '20:40', '20:50'),
(48, 9, 0, 1, '20:50', '21:00'),
(49, 9, 0, 1, '21:00', '21:10'),
(50, 9, 0, 1, '21:10', '21:20'),
(51, 9, 0, 1, '21:20', '21:30'),
(52, 9, 0, 1, '21:30', '21:40'),
(53, 9, 0, 1, '21:40', '21:50'),
(54, 9, 0, 1, '21:50', '22:00'),
(55, 9, 0, 1, '22:00', '22:10'),
(56, 9, 0, 1, '22:10', '22:20'),
(57, 9, 0, 1, '22:20', '22:30'),
(58, 9, 0, 1, '22:30', '22:40'),
(59, 9, 0, 1, '22:40', '22:50'),
(60, 9, 0, 1, '22:50', '23:00'),
(61, 9, 0, 1, '23:00', '23:10'),
(62, 9, 0, 1, '23:10', '23:20'),
(63, 9, 0, 1, '23:20', '23:30'),
(64, 9, 0, 1, '23:30', '23:40'),
(65, 9, 0, 1, '23:40', '23:50'),
(66, 9, 0, 2, '00:00', '00:10'),
(67, 9, 0, 2, '00:10', '00:20'),
(68, 9, 0, 2, '00:20', '00:30'),
(69, 9, 0, 2, '00:30', '00:40'),
(70, 9, 0, 2, '00:40', '00:50'),
(71, 9, 0, 2, '00:50', '01:00'),
(72, 9, 0, 2, '01:00', '01:10'),
(73, 9, 0, 2, '01:10', '01:20'),
(74, 9, 0, 2, '01:20', '01:30'),
(75, 9, 0, 2, '01:30', '01:40'),
(76, 9, 0, 2, '01:40', '01:50'),
(77, 9, 0, 2, '01:50', '02:00'),
(78, 9, 0, 2, '02:00', '02:10'),
(79, 9, 0, 2, '02:10', '02:20'),
(80, 9, 0, 2, '02:20', '02:30'),
(81, 9, 0, 2, '02:30', '02:40'),
(82, 9, 0, 2, '02:40', '02:50'),
(83, 9, 0, 2, '02:50', '03:00'),
(84, 9, 0, 2, '03:00', '03:10'),
(85, 9, 0, 2, '03:10', '03:20'),
(86, 9, 0, 2, '03:20', '03:30'),
(87, 9, 0, 2, '03:30', '03:40'),
(88, 9, 0, 2, '03:40', '03:50'),
(89, 9, 0, 2, '03:50', '04:00'),
(90, 9, 0, 2, '04:00', '04:10'),
(91, 9, 0, 2, '04:10', '04:20'),
(92, 9, 0, 2, '04:20', '04:30'),
(93, 9, 0, 2, '04:30', '04:40'),
(94, 9, 0, 2, '04:40', '04:50'),
(95, 9, 0, 2, '04:50', '05:00'),
(96, 9, 0, 2, '05:00', '05:10'),
(97, 9, 0, 2, '05:10', '05:20'),
(98, 9, 0, 2, '05:20', '05:30'),
(99, 9, 0, 2, '05:30', '05:40'),
(100, 9, 0, 2, '05:40', '05:50'),
(101, 9, 0, 2, '05:50', '06:00'),
(102, 9, 0, 2, '06:00', '06:10'),
(103, 9, 0, 2, '06:10', '06:20'),
(104, 9, 0, 2, '06:20', '06:30'),
(105, 9, 0, 2, '06:30', '06:40'),
(106, 9, 0, 2, '06:40', '06:50'),
(107, 9, 0, 2, '06:50', '07:00'),
(108, 9, 0, 2, '07:00', '07:10'),
(109, 9, 0, 2, '07:10', '07:20'),
(110, 9, 0, 2, '07:20', '07:30'),
(111, 9, 1, 2, '07:30', '07:40'),
(112, 9, 1, 2, '07:40', '07:50'),
(113, 9, 1, 2, '07:50', '08:00'),
(114, 9, 1, 2, '08:00', '08:10'),
(115, 9, 1, 2, '08:10', '08:20'),
(116, 9, 0, 2, '08:20', '08:30'),
(117, 9, 0, 2, '08:30', '08:40'),
(118, 9, 0, 2, '08:40', '08:50'),
(119, 9, 0, 2, '08:50', '09:00'),
(120, 9, 0, 2, '09:00', '09:10'),
(121, 9, 0, 2, '09:10', '09:20'),
(122, 9, 0, 2, '09:20', '09:30'),
(123, 9, 0, 2, '09:30', '09:40'),
(124, 9, 0, 2, '09:40', '09:50'),
(125, 9, 0, 2, '09:50', '10:00'),
(126, 9, 0, 2, '10:00', '10:10'),
(127, 9, 0, 2, '10:10', '10:20'),
(128, 9, 0, 2, '10:20', '10:30'),
(129, 9, 0, 2, '10:30', '10:40'),
(130, 9, 0, 2, '10:40', '10:50'),
(131, 9, 0, 2, '10:50', '11:00'),
(132, 9, 0, 2, '11:00', '11:10'),
(133, 9, 0, 2, '11:10', '11:20'),
(134, 9, 0, 2, '11:20', '11:30'),
(135, 9, 0, 2, '11:30', '11:40'),
(136, 9, 0, 2, '11:40', '11:50'),
(137, 9, 0, 2, '11:50', '12:00'),
(138, 9, 0, 2, '12:00', '12:10'),
(139, 9, 0, 2, '12:10', '12:20'),
(140, 9, 0, 2, '12:20', '12:30'),
(141, 9, 0, 2, '12:30', '12:40'),
(142, 9, 0, 2, '12:40', '12:50'),
(143, 9, 0, 2, '12:50', '13:00'),
(144, 2, 1, 1, '18:00', '18:10'),
(145, 2, 0, 1, '18:00', '18:10'),
(146, 2, 0, 1, '18:00', '18:10'),
(147, 2, 0, 1, '18:00', '18:10'),
(148, 2, 0, 1, '18:10', '18:20'),
(149, 2, 0, 1, '18:10', '18:20'),
(150, 2, 0, 1, '18:10', '18:20'),
(151, 2, 0, 1, '18:10', '18:20'),
(152, 2, 0, 1, '18:20', '18:30'),
(153, 2, 0, 1, '18:20', '18:30'),
(154, 2, 0, 1, '18:20', '18:30'),
(155, 2, 0, 1, '18:20', '18:30'),
(156, 2, 0, 1, '18:30', '18:40'),
(157, 2, 0, 1, '18:30', '18:40'),
(158, 2, 0, 1, '18:30', '18:40'),
(159, 2, 0, 1, '18:30', '18:40'),
(160, 2, 0, 1, '18:40', '18:50'),
(161, 2, 0, 1, '18:40', '18:50'),
(162, 2, 0, 1, '18:40', '18:50'),
(163, 2, 0, 1, '18:40', '18:50'),
(164, 2, 0, 1, '18:50', '19:00'),
(165, 2, 0, 1, '18:50', '19:00'),
(166, 2, 0, 1, '18:50', '19:00'),
(167, 2, 0, 1, '18:50', '19:00'),
(168, 2, 0, 1, '19:00', '19:10'),
(169, 2, 0, 1, '19:00', '19:10'),
(170, 2, 0, 1, '19:00', '19:10'),
(171, 2, 0, 1, '19:00', '19:10'),
(172, 2, 0, 1, '19:10', '19:20'),
(173, 2, 0, 1, '19:10', '19:20'),
(174, 2, 0, 1, '19:10', '19:20'),
(175, 2, 0, 1, '19:10', '19:20'),
(176, 2, 0, 1, '19:20', '19:30'),
(177, 2, 0, 1, '19:20', '19:30'),
(178, 2, 0, 1, '19:20', '19:30'),
(179, 2, 0, 1, '19:20', '19:30'),
(180, 2, 0, 1, '19:30', '19:40'),
(181, 2, 0, 1, '19:30', '19:40'),
(182, 2, 0, 1, '19:30', '19:40'),
(183, 2, 0, 1, '19:30', '19:40'),
(184, 2, 0, 1, '19:40', '19:50'),
(185, 2, 0, 1, '19:40', '19:50'),
(186, 2, 0, 1, '19:40', '19:50'),
(187, 2, 0, 1, '19:40', '19:50'),
(188, 2, 0, 1, '19:50', '20:00'),
(189, 2, 0, 1, '19:50', '20:00'),
(190, 2, 0, 1, '19:50', '20:00'),
(191, 2, 0, 1, '19:50', '20:00');

-- --------------------------------------------------------

--
-- Structure de la table `REF_ELEVES`
--

CREATE TABLE IF NOT EXISTS `REF_ELEVES` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UID` varchar(101) NOT NULL,
  `SPORT` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `REF_ELEVES`
--

INSERT INTO `REF_ELEVES` (`ID`, `UID`, `SPORT`) VALUES
(9, 'francois.espinet', 'Natation');

-- --------------------------------------------------------

--
-- Structure de la table `REF_EXTERIEURS`
--

CREATE TABLE IF NOT EXISTS `REF_EXTERIEURS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UID` varchar(101) NOT NULL,
  `MDP` varchar(256) NOT NULL,
  `SALT` varchar(10) NOT NULL,
  `CHALLENGE` varchar(20) NOT NULL,
  `VALID` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `REF_EXTERIEURS`
--

INSERT INTO `REF_EXTERIEURS` (`ID`, `UID`, `MDP`, `SALT`, `CHALLENGE`, `VALID`) VALUES
(1, 'xavier.colomba', 'fae8b039d63e3ce5b178d685352f13387c684146eecb667dea1c3924522fd388', 'c578360e2b', '8969b9a0c8ad1666b4da', 1);

-- --------------------------------------------------------

--
-- Structure de la table `REF_JOURS`
--

CREATE TABLE IF NOT EXISTS `REF_JOURS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NO_JOUR` int(11) NOT NULL,
  `MOIS` varchar(20) NOT NULL,
  `LIBELLE` varchar(20) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `REF_JOURS`
--

INSERT INTO `REF_JOURS` (`ID`, `NO_JOUR`, `MOIS`, `LIBELLE`) VALUES
(1, 28, 'fevrier', 'Jeudi'),
(2, 1, 'mars', 'Vendredi');

-- --------------------------------------------------------

--
-- Structure de la table `REF_ORGA_ROLES`
--

CREATE TABLE IF NOT EXISTS `REF_ORGA_ROLES` (
  `ID` int(11) NOT NULL,
  `LIBELLE` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `REF_ORGA_ROLES`
--

INSERT INTO `REF_ORGA_ROLES` (`ID`, `LIBELLE`) VALUES
(1, 'president'),
(2, 'vice-president'),
(3, 'tresorier');

-- --------------------------------------------------------

--
-- Structure de la table `RESULTATS`
--

CREATE TABLE IF NOT EXISTS `RESULTATS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CONTENU` varchar(1000) NOT NULL,
  `ID_ACTIVITE` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `RESULTATS`
--

INSERT INTO `RESULTATS` (`ID`, `CONTENU`, `ID_ACTIVITE`) VALUES
(1, '<table id="result" border="1"><thead><tr><td>chef</td><td>rechef</td></tr></thead><tbody><tr><td>1 ier</td><td>coucou c''est moi</td></tr><tr><td>2ieme</td><td>c''est remoi</td></tr></tbody></table>', 4),
(2, '<table id="result" border="1"><thead><tr><td>coucou</td><td>couqsd</td></tr></thead><tbody><tr><td>pd</td><td>az</td></tr></tbody></table>', 3);

-- --------------------------------------------------------

--
-- Structure de la table `UTILISATEURS`
--

CREATE TABLE IF NOT EXISTS `UTILISATEURS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UID` varchar(101) NOT NULL,
  `NOM` varchar(50) NOT NULL,
  `PRENOM` varchar(50) NOT NULL,
  `NOM_PRENOM` varchar(150) DEFAULT NULL,
  `EMAIL` varchar(200) NOT NULL,
  `ROLE` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UID` (`UID`),
  KEY `UID_2` (`UID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Contenu de la table `UTILISATEURS`
--

INSERT INTO `UTILISATEURS` (`ID`, `UID`, `NOM`, `PRENOM`, `NOM_PRENOM`, `EMAIL`, `ROLE`) VALUES
(20, 'francois.espinet', 'Espinet', 'François', 'ESPINET François', 'francois.espinet@polytechnique.edu', '2'),
(27, 'xavier.colomba', 'Colomba', 'Xavier', 'Colomba Xavier (ADJ)', 'xavier.colomba@polytechnique.edu', '4');

-- --------------------------------------------------------

--
-- Structure de la table `WEBMASTERS`
--

CREATE TABLE IF NOT EXISTS `WEBMASTERS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UID` varchar(101) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `WEBMASTERS`
--

INSERT INTO `WEBMASTERS` (`ID`, `UID`) VALUES
(1, 'francois.espinet');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
