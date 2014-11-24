-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 21 Septembre 2014 à 13:13
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `doctors`
--
CREATE DATABASE IF NOT EXISTS `doctors` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `doctors`;

-- --------------------------------------------------------

--
-- Structure de la table `antecedent`
--

CREATE TABLE IF NOT EXISTS `antecedent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `allergies` longtext COLLATE utf8_unicode_ci,
  `autres` longtext COLLATE utf8_unicode_ci,
  `traitement` longtext COLLATE utf8_unicode_ci,
  `chirurgicaux` longtext COLLATE utf8_unicode_ci,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3166BE7C217BBB47` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Contenu de la table `antecedent`
--

INSERT INTO `antecedent` (`id`, `person_id`, `allergies`, `autres`, `traitement`, `chirurgicaux`, `type`) VALUES
(1, 1, 'ALLERGIE À LA PÉNICILLINE', 'Hypertension artérielle depuis 4 ans, traitée, valeur habituelle 140/85\r\nPas d’hypercholestérolémie, pas de diabète, pas d’autres antécédents, pas \r\nd’opérations.', NULL, NULL, 'Antecedents personnels'),
(2, 1, 'Intolérance au gluten\r\nHypertension artérielle (1975) \r\nHypercholestérolémie (1983) \r\nDiabète de type 2', NULL, NULL, 'Appendicectomie (1946)', 'Antecedents personnels'),
(3, 1, NULL, 'Parents encore en vie, 85 ans, en bonne santé\r\nSœur de 50 ans en bonne santé\r\nOncle décédé d’une mort subite à l’âge de 58 ans\r\nEnfants en bonne santé', NULL, NULL, 'Antecedents familiaux'),
(4, 5, 'allergies', '123 aazasas', NULL, NULL, 'Antecedents personnels'),
(6, 9, 'aza', 'az', NULL, NULL, 'Antecedents familiaux');

-- --------------------------------------------------------

--
-- Structure de la table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `the_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `the_value` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Contenu de la table `config`
--

INSERT INTO `config` (`id`, `the_key`, `the_value`) VALUES
(2, 'app_logo', 'uploads/img/af28c5cce7fd0c1de575c139fedf7ccda7e8bad6.png'),
(3, 'app_name', 'ONOUSC'),
(4, 'app_description', 'description :)'),
(5, 'app_address', 'lot charaf salé'),
(6, 'app_cp', '11060'),
(7, 'app_city', 'RABAT'),
(8, 'app_tel', '0644435561'),
(9, 'app_gsm', '056515214'),
(10, 'app_email', 'onousc@gmail.com'),
(11, 'app_website', 'http://onousc.com'),
(12, 'app_map_lat', '33'),
(13, 'app_map_lng', '33'),
(14, 'app_lang', 'en_US'),
(15, 'rows_per_page', '10'),
(16, 'app_css', '/* css */'),
(17, 'allow_registration', 'on'),
(18, 'defaut_logement', '1');

-- --------------------------------------------------------

--
-- Structure de la table `consultation`
--

CREATE TABLE IF NOT EXISTS `consultation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `doc_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `infrastructure` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` date NOT NULL,
  `diagnosis` longtext COLLATE utf8_unicode_ci,
  `treatment` longtext COLLATE utf8_unicode_ci,
  `motiftype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `decision` longtext COLLATE utf8_unicode_ci,
  `chronic` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_964685A6217BBB47` (`person_id`),
  KEY `IDX_964685A6895648BC` (`doc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Contenu de la table `consultation`
--

INSERT INTO `consultation` (`id`, `person_id`, `doc_id`, `name`, `type`, `infrastructure`, `created`, `diagnosis`, `treatment`, `motiftype`, `decision`, `chronic`) VALUES
(1, 1, 1, 'visite medicale', 'Consultation generale', NULL, '2014-08-25', 'Jaundice', 'Traitement préscrit', 'EXAMEN MEDICAL SYSTEMATIQUE', 'Décision prise', 1),
(2, 1, 1, 'Dermato', 'Consultation spécialisé', 'CHU', '2014-08-25', 'Alopecia', 'ODRIK 2 mg : une gélule par jour - Q.S.P. 1 mois \r\nDIAMICRON 30 mg : 1 comp. le matin - Q.S.P. 1 mois', 'EXAMEN MEDICAL SYSTEMATIQUE', NULL, 0),
(3, 2, 1, 'Examen medical', 'Consultation generale', NULL, '2014-08-26', 'Jaundice', 'pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'EXAMEN MEDICAL SYSTEMATIQUE', NULL, 0),
(4, 1, 4, 'consultation #13', 'Consultation generale', NULL, '2014-08-27', 'Bronchitis,Allergy', 'I''ve got the program to write to and save a .txt file however I''m having some trouble reading from .txt files.', 'CONSULTATION MEDICALE A LA DEMANDE', 'decision prise', 1),
(5, 3, 4, 'Examen medical', 'Consultation generale', NULL, '2014-08-28', 'Amblyopia', 'Traitement préscrit', 'EXAMEN MEDICAL SYSTEMATIQUE', NULL, 0),
(6, 1, 1, 'Examen medical', 'Consultation generale', NULL, '2014-08-28', 'Alzheimer''s disease', NULL, 'EXAMEN MEDICAL SYSTEMATIQUE', NULL, 0),
(7, 5, 1, 'motif 3', 'Consultation generale', NULL, '2014-09-12', 'Angines,Stress', 'aeaea', 'EXAMEN MEDICAL SYSTEMATIQUE', NULL, 0),
(8, 6, 4, 'consultation #1', 'Consultation generale', NULL, '2014-09-14', 'Allergy,Breast cancer', 'Traitement préscrit', 'CONSULTATION MEDICALE A LA DEMANDE', 'la Décision prise', 1),
(10, 8, 1, 'Specialité #1', 'Consultation spécialisé', 'Centre de diagnostic', '2014-09-18', 'Caries dentaires', 'Traitement préscrit #1\r\nTraitement préscrit #2', NULL, NULL, NULL),
(11, 9, 1, 'Certificat de bonne santé', 'Consultation generale', NULL, '2014-09-18', 'Angines,Caries dentaires', 'Traitement préscrit', 'EXAMEN MEDICAL SYSTEMATIQUE', 'Décision prise', 1);

-- --------------------------------------------------------

--
-- Structure de la table `consultation_meds`
--

CREATE TABLE IF NOT EXISTS `consultation_meds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `consultation_id` int(11) NOT NULL,
  `meds_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4540F7E662FF6CDF` (`consultation_id`),
  KEY `IDX_4540F7E6A30CAE6F` (`meds_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `consultation_meds`
--

INSERT INTO `consultation_meds` (`id`, `consultation_id`, `meds_id`, `count`) VALUES
(1, 1, 5, 2),
(3, 10, 1, 2),
(4, 11, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Contenu de la table `image`
--

INSERT INTO `image` (`id`, `path`) VALUES
(2, 'anonymous.png'),
(4, 'anonymous.png'),
(5, 'anonymous.png');

-- --------------------------------------------------------

--
-- Structure de la table `meds`
--

CREATE TABLE IF NOT EXISTS `meds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `count` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `about` longtext COLLATE utf8_unicode_ci,
  `created` datetime NOT NULL,
  `expdate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Contenu de la table `meds`
--

INSERT INTO `meds` (`id`, `name`, `count`, `type`, `about`, `created`, `expdate`) VALUES
(1, 'lisinopril oral', 5, 'Hypertension Drugs', 'High Blood Pressure Hypertension', '2014-09-01 12:36:49', '2015-09-01'),
(2, 'hydrochlorothiazide oral', 15, 'Hypertension Drugs', 'Uses\r\nThis medication is used to treat high blood pressure. Lowering high blood pressure helps prevent strokes, heart attacks, and kidney problems. Hydrochlorothiazide is a "water pill" (diuretic) that causes you to make more urine. This helps your body get rid of extra salt and water.', '2014-09-01 12:36:49', '2015-09-01'),
(3, 'OxyContin', 28, 'breathing problems', 'Uses\r\nThis medication is used to help relieve moderate to severe ongoing pain (such as due to cancer). Oxycodone belongs to a class of drugs known as narcotic (opiate) analgesics. It works in the brain to change how your body feels and responds to pain.', '2014-09-01 12:36:49', '2015-09-01'),
(4, 'Anti-inflammatoires', 0, 'Dermatologie', 'les traitements anti-douleurs.', '2014-09-01 12:36:49', '2015-09-01'),
(5, 'Doliprane', 25, 'Traitement', 'AUTRES ANALGESIQUES et ANTIPYRETIQUES-ANILIDES, Code ATC: N02BE01. N: Syst├¿me nerveux central.', '2014-09-01 12:36:49', '2015-09-01'),
(6, 'meds#1', 10, 'Dermatologie', 'nop', '2014-09-01 12:36:49', '2015-09-01'),
(7, 'aspirine', 50, 'Traitement', 'a', '2014-09-01 12:36:49', '2014-09-01');

-- --------------------------------------------------------

--
-- Structure de la table `metadata`
--

CREATE TABLE IF NOT EXISTS `metadata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_id` int(11) NOT NULL,
  `thekey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thevalue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4F1434141E5D0459` (`test_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cne` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `familyname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` date NOT NULL,
  `birthcity` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contry` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `etablissement` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `university` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gsm` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cnss` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cnsstype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_gsm` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_fixe` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resident` tinyint(1) NOT NULL,
  `handicap` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `needs` longtext COLLATE utf8_unicode_ci,
  `ishandicap` tinyint(1) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Contenu de la table `person`
--

INSERT INTO `person` (`id`, `cin`, `cne`, `firstname`, `familyname`, `email`, `birthday`, `birthcity`, `gender`, `contry`, `city`, `address`, `etablissement`, `university`, `gsm`, `cnss`, `cnsstype`, `parent_name`, `parent_address`, `parent_gsm`, `parent_fixe`, `resident`, `handicap`, `needs`, `ishandicap`, `created`) VALUES
(1, 'ae60550', '1028605605', 'adil', 'harbouj', 'benaich.med@gmail.com', '1992-08-25', 'rabat', 'Masculin', 'maroc', 'salé', 'rue 12, ain chok n52 casablanca', 'fsr', 'université mohamed V', '0644432821', '1234545314', 'Cnss', 'omar benaich', 'rue 12, ain chok n52 casablanca', '0666343755', '0534521568', 1, 'handicap', 'besoin 1\r\nbesoin 2', 1, '2014-08-28 00:00:00'),
(2, 'ae60561', '10284605605', 'adnan', 'yassir', 'benaich.med@gmail.com', '1992-03-04', 'rabat', 'Masculin', 'maroc', 'Rabat', 'lot charaf n42 salé', 'fsr', 'université mohamed V', '0644432821', '154612-1513-02', 'Ramed', 'inssaf chahid', 'lot charaf n42 salé', '0666343755', '0534521568', 1, NULL, NULL, 0, '2014-08-28 00:00:00'),
(3, 'ae60786', '1028605615', 'basma', 'nahal', 's.nahal@gmail.com', '1993-08-25', 'taza', 'Féminin', 'maroc', 'casablanca', 'lot charaf n42 salé', 'fsr', 'université mohamed V', '0644432821', '154612-1513-02', 'Cnss', 'rfikh najad', 'rue 12, ain chok n52 casablanca', '0666343755', '0534521568', 1, NULL, NULL, NULL, '2014-08-28 00:00:00'),
(4, 'EZ4562', '1028605611', 'nacer', 'chahid', 's.nahal@gmail.com', '1993-08-25', 'rabat', 'Masculin', 'maroc', 'salé', 'rue 12, ain chok n52 casablanca', 'fsr', 'université mohamed V', '0644432821', '1234545314', 'Cnss', 'inssaf chahid', 'rue 12, ain chok n52 casablanca', '06452215452', '0534521568', 1, NULL, NULL, NULL, '2014-08-28 00:00:00'),
(5, 'Z4520', '1028456512', 'azziz', 'amrabet', 'azziz-amrabet@gmail.com', '1990-09-12', 'salé', 'Masculin', 'maroc', 'Rabat', 'rabat hay riad block 45 rue araar', 'FSR', 'university mohamed V', '0666343745', '154621345', 'Cnss', 'omar amrabet', 'lot charaf n42 salé', '0666645946', '0537546512', 1, NULL, NULL, NULL, '2014-08-28 00:00:00'),
(6, 'ae605500', '10286205605', 'ahlame', 'isnaki', 'ahlame@gmail.com', '1993-09-14', 'rabat', 'Féminin', 'maroc', 'Rabat', 'rue 12, ain chok n52 casablanca', 'fsr', 'université mohamed V', '0644432821', '1234546', 'Assurance privé', 'nasiiri falah', 'rue 12, ain chok n52 casablanca', '0666343755', '0534521568', 0, NULL, NULL, 0, '2014-09-14 21:08:46'),
(8, 'ae60542', '1228605605', 'fadwa', 'mrabet', 'fadwa95@gmail.com', '1995-09-18', 'Taza', 'Féminin', 'maroc', 'Rabat', 'rue 12, ain chok n52 casablanca', 'fsr', 'université mohamed V', '0644432821', '051542123', 'Cnss', 'hassan mrabet', 'rue 12, ain chok n52 casablanca', '0666343755', '0537521568', 1, NULL, NULL, 0, '2014-09-18 12:33:52'),
(9, 'ae60552', '1028605625', 'adil', 'harbouj', 'benaich.med@gmail.com', '1992-09-18', 'rabat', 'Masculin', 'maroc', 'salé', 'rue 12, ain chok n52 casablanca', 'fsr', 'université mohamed V', '0644432821', '1234545314', 'Cnss', 'omar benaich', 'rue 12, ain chok n52 casablanca', '0666343755', '0534521568', 1, NULL, NULL, 0, '2014-09-18 15:33:47');

-- --------------------------------------------------------

--
-- Structure de la table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `consultation_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `taille` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `poids` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ta` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `od` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `og` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `request` longtext COLLATE utf8_unicode_ci,
  `result` longtext COLLATE utf8_unicode_ci,
  `hasvisualissue` tinyint(1) DEFAULT NULL,
  `fixedvisualissue` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D87F7E0C62FF6CDF` (`consultation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Contenu de la table `test`
--

INSERT INTO `test` (`id`, `consultation_id`, `type`, `taille`, `poids`, `ta`, `od`, `og`, `request`, `result`, `hasvisualissue`, `fixedvisualissue`) VALUES
(1, 1, 'Examen Générale', '1.75', '65', '13', '9', '10', NULL, NULL, 0, '0'),
(2, 1, 'Examens biologiques', NULL, NULL, NULL, NULL, NULL, 'Glycémie, Créatinine, Calcémie', 'Glycémie	1.10	(g/l : 0,70-1,10)	\r\nCréatinine	9.5	(mg/l : 5,6-11,3)	\r\nNatrémie	143	(mEq/l : 135-145)	\r\nKaliémie	4.2	(mEq/l : 3,5-5,1)	\r\nCalcémie	99	(mg/l : 90-105)	\r\nPhosphorémie	(mg/l : 25-50)	\r\nAc. urique	65	(mg/l : 25-60)	\r\nHb A1c 7,65	(%: 4,5-6,3)	\r\n\r\nCLAIRANCE DE LA CRÉATININE = 56 ml/mn (INSUFFISANCE RÉNALE MODÉRÉE) \r\n\r\nEstimation de la glycémie moyenne sur 120 jours : 1,69 g/l (9,37 mmol/l)', 0, '0'),
(4, 5, 'Examens biologiques', NULL, NULL, NULL, NULL, NULL, 'Demande Demande', 'Resultat', 0, '0'),
(5, 6, 'Examen Générale', '1.75', '65', '13', '9', '10', NULL, NULL, 0, '0'),
(6, 6, 'Examens radioloqiue', NULL, NULL, NULL, NULL, NULL, 'az', 'az', 0, '0'),
(7, 4, 'Examen Générale', '1.75', '65', '13', '9', '10', NULL, NULL, 1, 'Corrigé'),
(8, 4, 'Examens radioloqiue', NULL, NULL, NULL, NULL, NULL, 'demande1\r\ndemande2\r\ndemande3', 'Resultat 1\r\nResultat 2', NULL, NULL),
(9, 3, 'Examens biologiques', NULL, NULL, NULL, NULL, NULL, 'Demande 1\r\nDemande 2\r\nDemande 3', 'Resultat1\r\nResultat2\r\nResultat3', NULL, NULL),
(10, 8, 'Examen Générale', '1.75', '65', '13', '9', '8', NULL, NULL, 1, 'Non corrigé');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `family_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `lastActivity` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_5DBD36CC92FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_5DBD36CCA0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_5DBD36CC3DA5256D` (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `image_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `family_name`, `first_name`, `tel`, `created`, `lastActivity`) VALUES
(1, 2, 'admin', 'admin', 'benaich.med@gmail.com', 'benaich.med@gmail.com', 1, 'cjooq91lu5kokookkowwowgkcow08g0', 'QvKJ2JNFZ4WIlUbtZgu5NpBue/SZ8M4ozqg2x/xfRV5U3BUahUGu42AP6u3/WPQBowH/w8uFyVgKFtoGTH7NWg==', '2014-09-21 11:39:49', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:10:"ROLE_ADMIN";}', 0, NULL, 'benaich', 'mohamed', '0644342821', '2014-05-03 21:13:54', '2014-09-21 12:50:59'),
(4, 4, 'user', 'user', 'souad@gmail.com', 'souad@gmail.com', 1, '1ubba1pb58m8k8c84oggkgg0w8k8k4k', 'HkNUbNRxHqNXOLOt0vz5A+HaGa/ZACk+Kr9lfA/M5onG1Z0nBod+uZAkRIS0MWXVmBm5mGfkPMXEluuyjvzGyw==', '2014-09-21 12:57:46', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'fadil', 'souad', '0666343755', '2014-05-10 17:59:17', '2014-09-21 13:03:02'),
(5, 5, 'manager', 'manager', 'vincent.jev@gmail.com', 'vincent.jev@gmail.com', 1, 'l904llzwz9ws8cc8sow84sogko48ksw', 'yLv9u+3FRIrxIS+X4lqHQb/SiC1CyKYk/REsG76GGa+zpOmpCa4YhkPdBIilNTViXnJr4HIFQW3YDdY8Me2tTw==', '2014-09-21 12:53:17', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_MANAGER";}', 0, NULL, 'fadil', 'adil', '+21266345886', '2014-09-01 14:15:56', '2014-09-21 12:56:48');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `antecedent`
--
ALTER TABLE `antecedent`
  ADD CONSTRAINT `FK_3166BE7C217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`);

--
-- Contraintes pour la table `consultation`
--
ALTER TABLE `consultation`
  ADD CONSTRAINT `FK_964685A6217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `FK_964685A6895648BC` FOREIGN KEY (`doc_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `consultation_meds`
--
ALTER TABLE `consultation_meds`
  ADD CONSTRAINT `FK_4540F7E662FF6CDF` FOREIGN KEY (`consultation_id`) REFERENCES `consultation` (`id`),
  ADD CONSTRAINT `FK_4540F7E6A30CAE6F` FOREIGN KEY (`meds_id`) REFERENCES `meds` (`id`);

--
-- Contraintes pour la table `metadata`
--
ALTER TABLE `metadata`
  ADD CONSTRAINT `FK_4F1434141E5D0459` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`);

--
-- Contraintes pour la table `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `FK_D87F7E0C62FF6CDF` FOREIGN KEY (`consultation_id`) REFERENCES `consultation` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_5DBD36CC3DA5256D` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
