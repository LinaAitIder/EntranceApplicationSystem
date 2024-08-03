-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 01 mai 2024 à 16:24
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `concours`
--

-- --------------------------------------------------------

--
-- Structure de la table `etud3a`
--

CREATE TABLE `etud3a` (
  `ID` int(11) NOT NULL,
  `nom` varchar(200) NOT NULL,
  `prenom` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `naissance` varchar(200) NOT NULL,
  `diplome` varchar(200) NOT NULL,
  `niveau` varchar(200) NOT NULL,
  `etablissement` varchar(200) NOT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `cv` varchar(200) DEFAULT NULL,
  `log` varchar(200) NOT NULL,
  `mdp` varchar(200) NOT NULL,
  `token` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etud3a`
--

INSERT INTO `etud3a` (`ID`, `nom`, `prenom`, `email`, `naissance`, `diplome`, `niveau`, `etablissement`, `photo`, `cv`, `log`, `mdp`, `token`) VALUES
(27, 'lina', 'ait ider', 'linaitider@gmail.com', '2024-04-28', 'Bac+2', 'nv3', 'lsls', NULL, NULL, 'lina', '$2y$10$iKEN2k4zGH3fVipfYofa6ei7T1jqK7I2C2ARt6hh84uxRMsGYinU6', 8464);

-- --------------------------------------------------------

--
-- Structure de la table `etud4a`
--

CREATE TABLE `etud4a` (
  `Id` int(11) NOT NULL,
  `nom` varchar(200) NOT NULL,
  `prenom` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `naissance` varchar(200) NOT NULL,
  `diplome` varchar(200) NOT NULL,
  `niveau` varchar(200) NOT NULL,
  `etablissement` varchar(200) NOT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `cv` varchar(200) DEFAULT NULL,
  `log` varchar(200) NOT NULL,
  `mdp` varchar(200) NOT NULL,
  `token` int(11) NOT NULL
) ;

--
-- Déchargement des données de la table `etud4a`
--

INSERT INTO `etud4a` (`Id`, `nom`, `prenom`, `email`, `naissance`, `diplome`, `niveau`, `etablissement`, `photo`, `cv`, `log`, `mdp`, `token`) VALUES
(2, 'linai', 'fff', 'linaitider@gmail.com', '2024-05-07', 'Bac+3', 'nv4', 'ensa', NULL, NULL, 'lina ait', '$2y$10$7r34u/s5IEqTYtweRdE4Leq9a/mk5dF/0zOKHkWJW.tpZfOOmUkmm', 924),
(3, 'linai', 'fff', 'linaitider@gmail.com', '2024-05-13', 'Bac+2', 'nv4', 'enas', NULL, NULL, 'lina ', '$2y$10$vZWyUkKbA9QUxGm7Y1A1XeUIa61lVdIxCJhdakRonC44BNBG8Hv7u', 7890),
(5, 'ahmed', 'moham', 'am@gmail.com', '2024-05-06', 'Bac+2', 'nv4', 'ddf', NULL, NULL, 'iah', '$2y$10$otdx7/IETlj8z2e0ywyx2efRZF87CAK/ZRvyWVNM9EtU4QVOhe4qG', 1300);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `etud3a`
--
ALTER TABLE `etud3a`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `log` (`log`);

--
-- Index pour la table `etud4a`
--
ALTER TABLE `etud4a`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `log` (`log`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `etud3a`
--
ALTER TABLE `etud3a`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `etud4a`
--
ALTER TABLE `etud4a`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
