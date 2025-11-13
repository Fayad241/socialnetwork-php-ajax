-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 19 juil. 2025 à 05:03
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `social-network-app`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `post-id` int(11) NOT NULL,
  `unique-id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `comment`, `post-id`, `unique-id`, `created_at`) VALUES
(3, 'Commenter en tant que Fayad Roufai', 3, 992337319, '2025-07-14 18:37:22'),
(4, 'consectetur adipisicing elit. Tempora magni facere quibusdam quidem asperiores accusamus eligendi maiores', 3, 967879338, '2025-07-15 18:41:52'),
(5, 'accusamus eligendi maiores', 3, 992337319, '2025-07-15 18:43:03'),
(6, 'Tempora magni facere quibusdam quidem', 3, 967879338, '2025-07-15 18:45:49'),
(7, 'facere quibusdam quidem', 3, 643654621, '2025-07-15 18:47:33'),
(8, 'Test commentaire, beau projet', 2, 643654621, '2025-07-16 10:02:52'),
(9, '1er commentaire sur la premiere publication', 1, 643654621, '2025-07-16 10:03:47'),
(10, 'Beau post keep it up', 1, 643654621, '2025-07-16 10:13:06'),
(11, '3eme commentaire', 1, 643654621, '2025-07-16 13:46:07');

-- --------------------------------------------------------

--
-- Structure de la table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL,
  `sender-id` int(11) NOT NULL,
  `receiver-id` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created-at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `sender-id`, `receiver-id`, `status`, `created-at`) VALUES
(1, 1433708506, 992337319, 'pending', '2025-07-14 04:50:59'),
(2, 1433708506, 643654621, 'pending', '2025-07-14 04:53:37'),
(3, 1433708506, 1028273087, 'pending', '2025-07-14 05:30:08');

-- --------------------------------------------------------

--
-- Structure de la table `ignored_suggestions`
--

CREATE TABLE `ignored_suggestions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ignored_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ignored_suggestions`
--

INSERT INTO `ignored_suggestions` (`id`, `user_id`, `ignored_user_id`) VALUES
(1, 992337319, 643654621),
(2, 992337319, 1433708506),
(3, 992337319, 1433708506),
(4, 992337319, 1433708506),
(5, 992337319, 967879338),
(6, 992337319, 1028273087);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender-msg-id` int(11) NOT NULL,
  `receiver-msg-id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `date-send` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `sender-msg-id`, `receiver-msg-id`, `msg`, `date-send`) VALUES
(1, 643654621, 1028273087, 'Bonjour man tu avnaces sur le projet déjà', '2025-07-16'),
(2, 1028273087, 643654621, 'Oui je suis en train de te fais le retour d\'ici peu', '2025-07-16');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user-id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `created-at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `img-publication` varchar(500) NOT NULL,
  `date-publication` date NOT NULL DEFAULT current_timestamp(),
  `unique-id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `content`, `img-publication`, `date-publication`, `unique-id`) VALUES
(1, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora magni facere quibusdam quidem asperiores accusamus eligendi maiores ea.', '1752417777_6873c5f1f07ad.jpeg', '2025-07-13', 1433708506),
(2, 'Very Good!!', '1752462725_68747585bc8ba.jpg', '2025-07-14', 1433708506),
(3, 'ESGIS!!!', '1752466945_6874860142761.jpg', '2025-07-14', 992337319);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `unique-id` int(11) NOT NULL,
  `last-name` varchar(40) NOT NULL,
  `first-name` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `bio` text NOT NULL,
  `password` varchar(200) NOT NULL,
  `gender` varchar(40) NOT NULL,
  `birthday` date NOT NULL,
  `profile-pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `unique-id`, `last-name`, `first-name`, `email`, `bio`, `password`, `gender`, `birthday`, `profile-pic`) VALUES
(9, 1028273087, 'Samson', 'Joseph', 'joseph@gmail.com', '', '$2y$10$W/VmYGU14iL7X71.9cRI0eVIYSLLn9VwxByDTzvc/wnsT38OrHBTC', 'homme', '2001-07-05', '1752328724_cj.jpeg'),
(10, 992337319, 'Moussavou', 'Juliette', 'julie@gmail.com', '', '$2y$10$zfnJrY3CZpnbzWxp0yyt7e9Dfl2NbtAkKeiVkAc7lAH2sUvAufTF.', 'femme', '2009-06-12', '68728f80d0cad_61358724d0ffc5da.jpeg'),
(11, 967879338, 'Nazario', 'Raul', 'raul@gmail.com', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque quibusdam necessitatibus voluptas, doloribus fugit velit?', '$2y$10$TX4nOFZnDhrpu9JpMC6FI.nhH.sfa/CXvMUma18asbcNyGml6t0QG', 'homme', '2006-11-25', '687290d33791b_588488da2eeef6ba.jpeg'),
(12, 643654621, 'Moudjibou', 'Pascal', 'pascal@gmail.com', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempora at nam dolor aut voluptatibus vero nemo maiores.', '$2y$10$e72PizewV87KiK.t.E58s.HcVWlzgBtt1ny5r.DlpJnFKCs1Nvjr6', 'homme', '2009-01-12', '687294d11c19f_fa51399144f18f56.jpeg'),
(13, 1433708506, 'Aurelie', 'Viviane', 'vivi@gmail.com', '', '$2y$10$GHQ9bdmfpBhRp08Qmdp4w.NHdUDF0VZ853HN6yiUVsreDYiPm6uhq', 'femme', '2004-11-12', '6872958e8b171_ef47b7dbfb83188d.jpeg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ignored_suggestions`
--
ALTER TABLE `ignored_suggestions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `ignored_suggestions`
--
ALTER TABLE `ignored_suggestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
