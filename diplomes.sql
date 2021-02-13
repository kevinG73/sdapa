-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 13 fév. 2021 à 00:15
-- Version du serveur :  5.7.24
-- Version de PHP : 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sdapa`
--

-- --------------------------------------------------------

--
-- Structure de la table `diplomes`
--

CREATE TABLE `diplomes` (
  `id_diplomes` int(11) NOT NULL,
  `code_diplomes` varchar(255) DEFAULT NULL,
  `libelle_diplomes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `diplomes`
--

INSERT INTO `diplomes` (`id_diplomes`, `code_diplomes`, `libelle_diplomes`) VALUES
(1, 'LI', 'LICENCE'),
(2, 'MA', 'MASTER'),
(3, 'DEUG', 'Diplôme d\'études universitaires Générales'),
(4, 'DOC', 'DOCTORAT'),
(5, 'maîtrise', 'maîtrise'),
(6, 'BTS', 'Brevet de Technicien Supérieur'),
(7, 'MST', 'Maîtrise de Sciences et Techniques'),
(8, 'DU', 'Diplôme d\'université'),
(9, 'DESS', 'Diplôme d\'étude Supérieures Spécialisées');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `diplomes`
--
ALTER TABLE `diplomes`
  ADD PRIMARY KEY (`id_diplomes`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `diplomes`
--
ALTER TABLE `diplomes`
  MODIFY `id_diplomes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
