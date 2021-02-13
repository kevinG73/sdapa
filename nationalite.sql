-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 13 fév. 2021 à 07:36
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
-- Structure de la table `nationalite`
--

CREATE TABLE `nationalite` (
  `id_nationalite` int(11) NOT NULL,
  `libelle_nationalite` varchar(255) NOT NULL,
  `pays_nationalite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `nationalite`
--

INSERT INTO `nationalite` (`id_nationalite`, `libelle_nationalite`, `pays_nationalite`) VALUES
(1, 'Ivoirienne', 0),
(2, 'Suisse', 0),
(3, 'Belge', 0),
(4, 'Allemande', 0),
(5, 'Italienne', 0),
(6, 'Afghane', 0),
(7, 'Albanaise', 0),
(8, 'Algerienne', 0),
(9, 'Americaine', 0),
(10, 'Andorrane', 0),
(11, 'Angolaise', 0),
(12, 'Antiguaiseetbarbudienne', 0),
(13, 'Argentine', 0),
(14, 'Armenienne', 0),
(15, 'Australienne', 0),
(16, 'Autrichienne', 0),
(17, 'Azerbaïdjanaise', 0),
(18, 'Bahamienne', 0),
(19, 'Bahreinienne', 0),
(20, 'Bangladaise', 0),
(21, 'Barbadienne', 0),
(22, 'Belizienne', 0),
(23, 'Beninoise', 0),
(24, 'Bhoutanaise', 0),
(25, 'Bielorusse', 0),
(26, 'Birmane', 0),
(27, 'Bissau-Guinéenne', 0),
(28, 'Bolivienne', 0),
(29, 'Bosnienne', 0),
(30, 'Botswanaise', 0),
(31, 'Bresilienne', 0),
(32, 'Britannique', 0),
(33, 'Bruneienne', 0),
(34, 'Bulgare', 0),
(35, 'Burkinabe', 0),
(36, 'Burundaise', 0),
(37, 'Cambodgienne', 0),
(38, 'Camerounaise', 0),
(39, 'Canadienne', 0),
(40, 'Cap-verdienne', 0),
(41, 'Centrafricaine', 0),
(42, 'Chilienne', 0),
(43, 'Chinoise', 0),
(44, 'Chypriote', 0),
(45, 'Colombienne', 0),
(46, 'Comorienne', 0),
(47, 'Congolaise', 0),
(48, 'Costaricaine', 0),
(49, 'Croate', 0),
(50, 'Cubaine', 0),
(51, 'Danoise', 0),
(52, 'Djiboutienne', 0),
(53, 'Dominicaine', 0),
(54, 'Dominiquaise', 0),
(55, 'Egyptienne', 0),
(56, 'Emirienne', 0),
(57, 'Equato-guineenne', 0),
(58, 'Equatorienne', 0),
(59, 'Erythreenne', 0),
(60, 'Espagnole', 0),
(61, 'Est-timoraise', 0),
(62, 'Estonienne', 0),
(63, 'Ethiopienne', 0),
(64, 'Fidjienne', 0),
(65, 'Finlandaise', 0),
(66, 'Gabonaise', 0),
(67, 'Gambienne', 0),
(68, 'Georgienne', 0),
(69, 'Ghaneenne', 0),
(70, 'Grenadienne', 0),
(71, 'Guatemalteque', 0),
(72, 'Guineenne', 0),
(73, 'Guyanienne', 0),
(74, 'Haïtienne', 0),
(75, 'Hellenique', 0),
(76, 'Hondurienne', 0),
(77, 'Hongroise', 0),
(78, 'Indienne', 0),
(79, 'Indonesienne', 0),
(80, 'Irakienne', 0),
(81, 'Irlandaise', 0),
(82, 'Islandaise', 0),
(83, 'Israélienne', 0),
(84, 'Française', 0),
(85, 'Jamaïcaine', 0),
(86, 'Japonaise', 0),
(87, 'Jordanienne', 0),
(88, 'Kazakhstanaise', 0),
(89, 'Kenyane', 0),
(90, 'Kirghize', 0),
(91, 'Kiribatienne', 0),
(92, 'Kittitienne-et-nevicienne', 0),
(93, 'Koweitienne', 0),
(94, 'Laotienne', 0),
(95, 'Lesothane', 0),
(96, 'Lettone', 0),
(97, 'Libanaise', 0),
(98, 'Liberienne', 0),
(99, 'Libyenne', 0),
(100, 'Liechtensteinoise', 0),
(101, 'Lituanienne', 0),
(102, 'Luxembourgeoise', 0),
(103, 'Macedonienne', 0),
(104, 'Malaisienne', 0),
(105, 'Malawienne', 0),
(106, 'Maldivienne', 0),
(107, 'Malgache', 0),
(108, 'Malienne', 0),
(109, 'Maltaise', 0),
(110, 'Marocaine', 0),
(111, 'Marshallaise', 0),
(112, 'Mauricienne', 0),
(113, 'Mauritanienne', 0),
(114, 'Mexicaine', 0),
(115, 'Micronesienne', 0),
(116, 'Moldave', 0),
(117, 'Monegasque', 0),
(118, 'Mongole', 0),
(119, 'Montenegrine', 0),
(120, 'Mozambicaine', 0),
(121, 'Namibienne', 0),
(122, 'Nauruane', 0),
(123, 'Neerlandaise', 0),
(124, 'Neo-zelandaise', 0),
(125, 'Nepalaise', 0),
(126, 'Nicaraguayenne', 0),
(127, 'Nigeriane', 0),
(128, 'Nigerienne', 0),
(129, 'Nord-coréenne', 0),
(130, 'Norvegienne', 0),
(131, 'Omanaise', 0),
(132, 'Ougandaise', 0),
(133, 'Ouzbeke', 0),
(134, 'Pakistanaise', 0),
(135, 'Palau', 0),
(136, 'Palestinienne', 0),
(137, 'Panameenne', 0),
(138, 'Papouane-neoguineenne', 0),
(139, 'Paraguayenne', 0),
(140, 'Peruvienne', 0),
(141, 'Philippine', 0),
(142, 'Polonaise', 0),
(143, 'Portoricaine', 0),
(144, 'Portugaise', 0),
(145, 'Qatarienne', 0),
(146, 'Roumaine', 0),
(147, 'Russe', 0),
(148, 'Rwandaise', 0),
(149, 'Saint-Lucienne', 0),
(150, 'Saint-Marinaise', 0),
(151, 'Saint-Vincentaise-et-Grenadine', 0),
(152, 'Salomonaise', 0),
(153, 'Salvadorienne', 0),
(154, 'Samoane', 0),
(155, 'Santomeenne', 0),
(156, 'Saoudienne', 0),
(157, 'Senegalaise', 0),
(158, 'Serbe', 0),
(159, 'Seychelloise', 0),
(160, 'Sierra-leonaise', 0),
(161, 'Singapourienne', 0),
(162, 'Slovaque', 0),
(163, 'Slovene', 0),
(164, 'Somalienne', 0),
(165, 'Soudanaise', 0),
(166, 'Sri-lankaise', 0),
(167, 'Sud-africaine', 0),
(168, 'Sud-coréenne', 0),
(169, 'Suedoise', 0),
(170, 'Surinamaise', 0),
(171, 'Swazie', 0),
(172, 'Syrienne', 0),
(173, 'Tadjike', 0),
(174, 'Taiwanaise', 0),
(175, 'Tanzanienne', 0),
(176, 'Tchadienne', 0),
(177, 'Tcheque', 0),
(178, 'Thaïlandaise', 0),
(179, 'Togolaise', 0),
(180, 'Tonguienne', 0),
(181, 'Trinidadienne', 0),
(182, 'Tunisienne', 0),
(183, 'Turkmene', 0),
(184, 'Turque', 0),
(185, 'Tuvaluane', 0),
(186, 'Ukrainienne', 0),
(187, 'Uruguayenne', 0),
(188, 'Vanuatuane', 0),
(189, 'Venezuelienne', 0),
(190, 'Vietnamienne', 0),
(191, 'Yemenite', 0),
(192, 'Zambienne', 0),
(193, 'Zimbabweenne', 0),
(194, 'Kossovienne', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `nationalite`
--
ALTER TABLE `nationalite`
  ADD PRIMARY KEY (`id_nationalite`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `nationalite`
--
ALTER TABLE `nationalite`
  MODIFY `id_nationalite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
