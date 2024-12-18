-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 15 juil. 2024 à 13:32
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion`
--

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

DROP TABLE IF EXISTS `profil`;
CREATE TABLE IF NOT EXISTS `profil` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`idUser`, `nom`, `prenom`, `email`) VALUES
(1, 'Lepoivre', 'Francis', 'francis@gmail.com'),
(2, 'Jambon', 'Benoît', 'benoît@gmail.com'),
(4, 'Bengio', 'Nathan', 'shnitzeul@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `travail`
--

DROP TABLE IF EXISTS `travail`;
CREATE TABLE IF NOT EXISTS `travail` (
  `idTravail` int NOT NULL AUTO_INCREMENT,
  `idUser` int NOT NULL,
  `date` date NOT NULL,
  `heure_deb` time NOT NULL,
  `heure_fin` time NOT NULL,
  `total` varchar(30) NOT NULL,
  `total_cent` varchar(30) NOT NULL,
  PRIMARY KEY (`idTravail`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `travail`
--

INSERT INTO `travail` (`idTravail`, `idUser`, `date`, `heure_deb`, `heure_fin`, `total`, `total_cent`) VALUES
(45, 2, '2024-07-11', '22:00:00', '23:00:00', '1:00', '1.00'),
(46, 2, '2024-08-15', '15:01:00', '17:01:00', '2:00', '2.00'),
(47, 2, '2024-08-15', '15:01:00', '17:01:00', '2:00', '2.00'),
(48, 4, '2024-07-11', '00:53:00', '01:55:00', '1:02', '1.03'),
(49, 4, '2024-07-11', '00:53:00', '01:55:00', '1:02', '1.03'),
(50, 4, '2024-07-11', '00:53:00', '01:55:00', '1:02', '1.03'),
(51, 4, '2024-07-11', '00:53:00', '01:55:00', '1:02', '1.03'),
(52, 4, '2024-07-11', '00:53:00', '01:55:00', '1:02', '1.03'),
(53, 4, '2024-07-11', '00:53:00', '01:55:00', '1:02', '1.03'),
(54, 4, '2024-07-11', '00:53:00', '01:55:00', '1:02', '1.03'),
(55, 1, '2024-07-11', '01:21:00', '02:22:00', '1:01', '1.02'),
(56, 4, '2024-07-11', '23:46:00', '23:49:00', '0:03', '0.05'),
(57, 4, '2024-07-12', '10:46:00', '11:48:00', '1:02', '1.03');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `travail`
--
ALTER TABLE `travail`
  ADD CONSTRAINT `fk_travail_profil` FOREIGN KEY (`idUser`) REFERENCES `profil` (`idUser`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
