-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 30 juin 2020 à 22:26
-- Version du serveur :  10.1.38-MariaDB
-- Version de PHP :  7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `forumbdd`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `titre` varchar(50) CHARACTER SET utf8 NOT NULL,
  `date_creation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `titre`, `date_creation`) VALUES
(1, 'Catégorie 1', '2020-06-25 00:00:00'),
(2, 'Catégorie 2', '2020-06-25 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `topic`
--

CREATE TABLE `topic` (
  `id` int(11) NOT NULL,
  `id_forum` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `contenu` text NOT NULL,
  `date_creation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `topic`
--

INSERT INTO `topic` (`id`, `id_forum`, `titre`, `contenu`, `date_creation`) VALUES
(1, 1, 'Topic 1.1', 'Mon contenu', '2020-06-26 00:00:00'),
(2, 1, 'Topic 1.2', 'Mon autre contenu', '2020-06-26 00:05:00'),
(3, 1, 'Topic 1.3', 'Toujours mon contenu', '2020-06-26 01:05:00'),
(4, 2, 'Topic 2.1', 'Mon contenu', '2020-06-26 01:30:00'),
(5, 1, 'Mon premier topic', 'Ceci est un test pour la cr&eacute;ation de mon premier topic', '2020-06-29 12:54:30'),
(6, 2, 'Cr&eacute;ation de mon forum', 'Voici comment j\'ai cr&eacute;er ce forum pour Huggii', '2020-06-29 12:55:23'),
(7, 2, 'Test', 'test', '2020-06-29 14:18:14'),
(8, 2, 'Topic 2.2', 'Tuto', '2020-06-29 16:25:25'),
(9, 2, 'Test topic', 'Bonjour ceci est un test', '2020-06-30 19:18:07');

-- --------------------------------------------------------

--
-- Structure de la table `topic_commentaire`
--

CREATE TABLE `topic_commentaire` (
  `id` int(11) NOT NULL,
  `id_topic` int(11) NOT NULL,
  `texte` text NOT NULL,
  `date_creation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `topic_commentaire`
--

INSERT INTO `topic_commentaire` (`id`, `id_topic`, `texte`, `date_creation`) VALUES
(1, 1, 'Super sujet !', '2020-06-28 10:30:00'),
(2, 1, 'Cool ce forum', '2020-06-28 12:45:00'),
(3, 2, 'Parfait', '2020-06-29 14:00:00'),
(4, 3, 'Super !', '2020-06-29 15:02:00'),
(5, 4, 'Test', '2020-06-29 17:12:00'),
(6, 5, 'Bonjour', '2020-06-29 14:08:06'),
(7, 5, 'Comment vas-tu ?', '2020-06-29 14:10:48'),
(11, 5, 'Ca va super et toi ?', '2020-06-29 14:16:43'),
(12, 5, 'Ca va bien', '2020-06-29 14:17:02'),
(13, 5, 'Coucou je suis nouveau', '2020-06-29 16:24:55'),
(14, 1, 'Test', '2020-06-30 19:17:40');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_forum` (`id_forum`);

--
-- Index pour la table `topic_commentaire`
--
ALTER TABLE `topic_commentaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_topic` (`id_topic`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `topic`
--
ALTER TABLE `topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `topic_commentaire`
--
ALTER TABLE `topic_commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`id_forum`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `topic_commentaire`
--
ALTER TABLE `topic_commentaire`
  ADD CONSTRAINT `topic_commentaire_ibfk_1` FOREIGN KEY (`id_topic`) REFERENCES `topic` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
