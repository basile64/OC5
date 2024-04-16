-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 16 avr. 2024 à 15:30
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
-- Base de données : `OC5`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Coding'),
(2, 'Development');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL,
  `status` enum('Pending','Approved') NOT NULL,
  `postId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `text`, `date`, `status`, `postId`, `userId`) VALUES
(1, 'Très bon article ! Des mots justes utilisés avec parcimonie.', '2024-02-29 00:00:00', 'Approved', 1, 1),
(2, 'J\'ai également adoré. Bravo à l\'auteur !', '2024-02-29 00:00:00', 'Approved', 1, 1),
(4, 'J\'ai également adoré ! Bravo pour votre professionnalisme.', '2024-03-04 00:00:00', 'Approved', 1, 1),
(18, 'jbhjbj', '2024-03-13 00:00:00', 'Approved', 1, 1),
(19, 'hbuub', '2024-03-12 00:00:00', 'Approved', 1, 1),
(31, 'Autre commentaire', '2024-03-14 00:00:00', 'Approved', 1, 1),
(34, 'Bonjour', '2024-03-15 00:00:00', 'Approved', 1, 1),
(35, 'hey', '2024-03-15 00:00:00', 'Approved', 1, 1),
(45, 'Ceci est un commentaire', '2024-03-21 16:25:51', 'Approved', 2, 1),
(46, 'Ceci est une réponse à un commentaire', '2024-03-21 16:26:18', 'Approved', 2, 1),
(47, 'Commentaire test', '2024-03-21 17:08:43', 'Approved', 21, 1),
(51, 'Bonsoir', '2024-04-01 10:31:39', 'Approved', 1, 17),
(52, 'Nouveau commentaire', '2024-04-01 10:31:48', 'Approved', 1, 17),
(65, 'edede', '2024-04-13 14:23:19', 'Approved', 3, 1),
(66, 'dedede', '2024-04-13 14:23:58', 'Approved', 3, 1),
(67, 'dede', '2024-04-13 17:14:39', 'Pending', 34, 1);

-- --------------------------------------------------------

--
-- Structure de la table `mainComment`
--

CREATE TABLE `mainComment` (
  `id` int(11) NOT NULL,
  `commentId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `mainComment`
--

INSERT INTO `mainComment` (`id`, `commentId`) VALUES
(1, 1),
(2, 2),
(12, 18),
(19, 31),
(24, 45),
(25, 47),
(27, 52),
(33, 65),
(34, 66),
(35, 67);

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `chapo` text NOT NULL,
  `text` longtext NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime DEFAULT NULL,
  `img` varchar(300) NOT NULL,
  `userId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `chapo`, `text`, `dateCreation`, `dateModification`, `img`, `userId`, `categoryId`) VALUES
(1, 'Introduction', 'Dive into the diverse world of coding paradigms, from procedural to object-oriented programming.', 'Welcome to the fascinating world of coding paradigms, where the way we think about and structure our code can greatly impact the solutions we create. In this article, we\'ll explore the various coding paradigms such as procedural, object-oriented, and functional programming. Gain insights into when to use each paradigm and how they influence your approach to problem-solving. Understanding coding paradigms is crucial for becoming a versatile and effective programmer.', '2024-02-29 00:00:00', '2024-04-13 10:03:35', 'img1.jpg', 1, 1),
(2, 'Building Scalable Web Applications with Coding\n', 'Learn the principles and best practices for building scalable and efficient web applications using modern coding techniques.\n', 'Creating web applications that can handle growth and scale is a key challenge for developers. In this article, we\'ll delve into the principles and best practices for building scalable web applications using modern coding techniques. From optimizing database queries to implementing efficient caching strategies, learn how to ensure your web applications not only meet current demands but can also scale gracefully as your user base grows.\n\n', '2024-02-28 00:00:00', NULL, 'img2.jpg', 1, 1),
(3, 'Exploring Algorithms and Data Structures', 'Uncover the beauty and power of algorithms and data structures that form the foundation of computer science and coding.\r\n', 'Algorithms and data structures form the backbone of computer science and programming. In this comprehensive exploration, we&#39;ll journey through fundamental algorithms and data structures, from sorting and searching to linked lists and trees. Understanding these concepts is essential for writing efficient and optimized code. Get ready to deepen your knowledge and elevate your coding skills with this insightful exploration.\r\n\r\n', '2024-02-27 00:00:00', '2024-04-16 09:58:00', 'img3.jpg', 1, 1),
(4, 'The Art of Debugging in Coding\n', 'Master the art of debugging and error-solving, an essential skill for every coder.\n', 'Every coder encounters bugs and errors – it\'s a natural part of the coding process. This article is your guide to mastering the art of debugging. Learn effective strategies for identifying, isolating, and fixing bugs in your code. Explore debugging tools and techniques that will make you a more efficient and confident coder. Discover the satisfaction of turning a puzzling bug into a resolved and polished piece of software.\n\n', '2024-02-26 00:00:00', NULL, 'img4.jpg', 1, 1),
(20, 'dedzed', 'dzdezd', 'edezdezdz', '2024-03-12 00:00:00', NULL, 'img5.jpg', 1, 1),
(21, 'Ceci est un post', 'dekodnedehdnejd', 'diejdneofnefe', '2024-03-14 00:00:00', '2024-04-04 10:53:40', 'img6.jpg', 7, 1),
(34, 'ddaadd', 'dd', 'dd', '2024-04-13 13:04:25', '2024-04-13 17:49:10', 'Firefly logo minimaliste, bleu foncé, avec un ordinateur dans un rond 56855.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `responseComment`
--

CREATE TABLE `responseComment` (
  `id` int(11) NOT NULL,
  `mainCommentId` int(11) NOT NULL,
  `commentId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `responseComment`
--

INSERT INTO `responseComment` (`id`, `mainCommentId`, `commentId`) VALUES
(2, 1, 4),
(3, 12, 19),
(10, 19, 34),
(14, 24, 46),
(17, 19, 51);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `avatar` varchar(50) NOT NULL DEFAULT 'avatar.png',
  `password` varchar(255) NOT NULL,
  `dateRegistration` datetime NOT NULL,
  `role` enum('basic','admin') NOT NULL DEFAULT 'basic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `mail`, `avatar`, `password`, `dateRegistration`, `role`) VALUES
(1, 'Basile', 'Pineau', 'basile.pineau@greta-cfa-aquitaine.academy', 'avatar1.jpeg', '$2y$10$sfh8n7Hslvz0uC6USH3zD.29sej6aLUhaSI8faYuQBx2V6YjUFhpa', '2024-02-29 21:42:21', 'admin'),
(7, 'Noé', 'fzefze', 'fezfez', 'avatar.png', '$2y$10$DuFW26PB2gESx9jKoc6RP.ci2SNpMPrYsxyRgWIiOW7avXnJTUvoC', '2024-03-15 10:54:16', 'admin'),
(9, 'Corinne', 'Pineau', 'corinne.pineau@gmail.com', 'avatar.png', '$2y$10$.bfoHWnpMuE6MqIVn.0q3uws68O3i/nxyuVM7p19MVLrm3KTJDOyK', '2024-03-20 08:46:25', 'basic'),
(10, 'efefeeeeeeeeee', 'fefefe', 'fefed', 'avatar.png', '$2y$10$tIHcevIt6s3GjJHts8/eIenyvKE5fL2z56uil0YkfuFATV1F.d47G', '2024-03-21 17:25:56', 'basic'),
(11, 'tededaaa', 'tetede', 'deded', 'avatar.png', '$2y$10$08uvc3Jz8dOHcGpe1H41XOrHcq9qml/KMWmJ3rGU1M.aSMgnOCdTO', '2024-03-25 20:36:36', 'basic'),
(12, 'Laurent', 'PINEAU', 'laurent.pineau@gmail.com', 'avatar.png', '$2y$10$7fb8ci7jPOITtuUSbUhzOukeL0CZXfI2Su2pifwIWsIpwZXBqkGNq', '2024-03-26 18:27:13', 'basic'),
(16, 'dede', 'dede', 'zdzdz', 'avatar.png', '$2y$10$s29bN4pIbVWYD8mVrD0cHem4vl1smM3Nw13h8ZRRpf8RMD3TC4g4K', '2024-03-28 17:26:48', 'basic'),
(17, 'Shelly', 'Cros', 'shelly.cros@gmail.com', 'avatar2.png', '$2y$10$UeKjtmZ9juLZ0bMqIMgdK.bqD0V1stcj1vl4P/yaKmmGYyhxI3Q5G', '2024-04-01 10:31:06', 'basic');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`userId`),
  ADD KEY `idPost` (`postId`);

--
-- Index pour la table `mainComment`
--
ALTER TABLE `mainComment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idComment` (`commentId`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idAdminUser` (`userId`),
  ADD KEY `idCategory` (`categoryId`);

--
-- Index pour la table `responseComment`
--
ALTER TABLE `responseComment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMainComment` (`mainCommentId`),
  ADD KEY `idComment` (`commentId`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT pour la table `mainComment`
--
ALTER TABLE `mainComment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `responseComment`
--
ALTER TABLE `responseComment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`postId`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `mainComment`
--
ALTER TABLE `mainComment`
  ADD CONSTRAINT `maincomment_ibfk_2` FOREIGN KEY (`commentId`) REFERENCES `comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `responseComment`
--
ALTER TABLE `responseComment`
  ADD CONSTRAINT `responsecomment_ibfk_1` FOREIGN KEY (`commentId`) REFERENCES `comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `responsecomment_ibfk_2` FOREIGN KEY (`mainCommentId`) REFERENCES `mainComment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
