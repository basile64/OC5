-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 24 avr. 2024 à 16:22
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
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Coding'),
(2, 'Development'),
(3, 'Cybersecurity'),
(4, 'Web Development'),
(5, 'Machine Learning');

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
(1, 'Very good article! Just the right words used sparingly.\"\nVery good article! Just the right words used sparingly.\n', '2024-02-29 00:00:00', 'Approved', 1, 1),
(2, 'Great article', '2024-02-29 00:00:00', 'Approved', 1, 1),
(4, 'I also loved it! Bravo for your professionalism.', '2024-03-04 00:00:00', 'Approved', 1, 1),
(18, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum euismod lorem et massa malesuada, id molestie urna rhoncus.', '2024-03-13 00:00:00', 'Approved', 1, 1),
(19, 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum euismod lorem et massa malesuada, id molestie urna rhoncus.\n', '2024-03-12 00:00:00', 'Approved', 1, 1),
(31, 'Dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\n', '2024-03-14 00:00:00', 'Approved', 1, 1),
(34, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2024-03-15 00:00:00', 'Approved', 1, 1),
(35, 'Hello ! ', '2024-03-15 00:00:00', 'Approved', 1, 1),
(45, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\n', '2024-03-21 16:25:51', 'Approved', 2, 1),
(46, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore. ', '2024-03-21 16:26:18', 'Approved', 2, 1),
(51, 'Thank for sharing this', '2024-04-01 10:31:39', 'Approved', 1, 17),
(52, 'First !', '2024-04-01 10:31:48', 'Approved', 1, 17),
(82, 'Great article, very informative!', '2024-04-02 09:30:00', 'Approved', 45, 25),
(83, 'Thanks for sharing!', '2024-04-02 10:00:00', 'Approved', 45, 26),
(84, 'I have a question regarding cybersecurity measures for small businesses.', '2024-04-02 10:30:00', 'Pending', 45, 25),
(85, 'This post helped me understand Python better.', '2024-03-15 11:30:00', 'Approved', 46, 26),
(86, 'Looking forward to more articles like this!', '2024-03-15 12:00:00', 'Approved', 47, 28),
(87, 'I\'m excited about the future of web development!', '2024-03-15 12:30:00', 'Approved', 47, 25),
(88, 'Great article! I learned a lot from it.', '2023-12-01 12:30:00', 'Approved', 45, 30),
(89, 'This post is very informative. Thank you for sharing!', '2024-01-10 15:45:00', 'Approved', 46, 30),
(90, 'I agree with the points made in this article.', '2024-02-20 09:15:00', 'Approved', 47, 30),
(91, 'That is a good question !', '2024-04-24 14:38:35', 'Approved', 21, 29),
(92, 'What is your answer Antoine ?', '2024-04-24 14:39:23', 'Approved', 21, 1),
(105, 'Secret !', '2024-04-24 14:55:15', 'Approved', 21, 29),
(106, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '2024-04-24 15:01:08', 'Pending', 21, 26);

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
(27, 52),
(44, 82),
(45, 83),
(46, 85),
(86, 88),
(87, 89),
(88, 90),
(89, 91),
(92, 106);

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
(2, 'Building Scalable Web Applications with Coding\n', 'Learn the principles and best practices for building scalable and efficient web applications using modern coding techniques.\n', 'Creating web applications that can handle growth and scale is a key challenge for developers. In this article, we\'ll delve into the principles and best practices for building scalable web applications using modern coding techniques. From optimizing database queries to implementing efficient caching strategies, learn how to ensure your web applications not only meet current demands but can also scale gracefully as your user base grows.\n\n', '2024-02-28 00:00:00', NULL, 'img2.jpg', 1, 2),
(3, 'Exploring Algorithms and Data Structures', 'Uncover the beauty and power of algorithms and data structures that form the foundation of computer science and coding.\r\n', 'Algorithms and data structures form the backbone of computer science and programming. In this comprehensive exploration, we&#39;ll journey through fundamental algorithms and data structures, from sorting and searching to linked lists and trees. Understanding these concepts is essential for writing efficient and optimized code. Get ready to deepen your knowledge and elevate your coding skills with this insightful exploration.\r\n\r\n', '2024-02-27 00:00:00', '2024-04-16 09:58:00', 'img3.jpg', 1, 1),
(4, 'The Art of Debugging in Coding\n', 'Master the art of debugging and error-solving, an essential skill for every coder.\n', 'Every coder encounters bugs and errors – it\'s a natural part of the coding process. This article is your guide to mastering the art of debugging. Learn effective strategies for identifying, isolating, and fixing bugs in your code. Explore debugging tools and techniques that will make you a more efficient and confident coder. Discover the satisfaction of turning a puzzling bug into a resolved and polished piece of software.\n\n', '2024-02-26 00:00:00', NULL, 'img4.jpg', 1, 1),
(20, 'This is the best post', 'Aliquam auctor purus non nisl pulvinar, vitae consectetur lorem vehicula. Sed convallis magna vel posuere volutpat. Vivamus sit amet ligula vel lacus scelerisque dictum. Sed at metus nec risus cursus malesuada.', 'Aliquam auctor purus non nisl pulvinar, vitae consectetur lorem vehicula. Sed convallis magna vel posuere volutpat. Vivamus sit amet ligula vel lacus scelerisque dictum. Sed at metus nec risus cursus malesuada. Aliquam auctor purus non nisl pulvinar, vitae consectetur lorem vehicula. Sed convallis magna vel posuere volutpat. Vivamus sit amet ligula vel lacus scelerisque dictum. Sed at metus nec risus cursus malesuada. Aliquam auctor purus non nisl pulvinar, vitae consectetur lorem vehicula. Sed convallis magna vel posuere volutpat. Vivamus sit amet ligula vel lacus scelerisque dictum. Sed at metus nec risus cursus malesuada. Aliquam auctor purus non nisl pulvinar, vitae consectetur lorem vehicula. Sed convallis magna vel posuere volutpat. Vivamus sit amet ligula vel lacus scelerisque dictum. Sed at metus nec risus cursus malesuada.', '2024-03-12 00:00:00', NULL, 'img5.jpg', 1, 1),
(21, 'Why learning PHP ?', 'Suspendisse potenti. Aenean auctor fermentum aliquam. Nunc tristique est in velit consectetur, nec scelerisque velit consequat.', 'Vitae consectetur lorem vehicula. Sed convallis magna vel posuere volutpat. Vivamus sit amet ligula vel lacus scelerisque dictum. Sed at metus nec risus cursus malesuada. Vitae consectetur lorem vehicula. Sed convallis magna vel posuere volutpat. Vivamus sit amet ligula vel lacus scelerisque dictum. Sed at metus nec risus cursus malesuada. Vitae consectetur lorem vehicula. Sed convallis magna vel posuere volutpat. Vivamus sit amet ligula vel lacus scelerisque dictum. Sed at metus nec risus cursus malesuada.', '2024-03-14 00:00:00', '2024-04-04 10:53:40', 'img6.jpg', 1, 4),
(45, '10 Common Cybersecurity Threats and How to Prevent Them', 'Stay ahead of cyber threats with these essential tips.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse accumsan libero ac feugiat consequat. Nullam ut tellus vitae felis tempus vehicula. Phasellus maximus pharetra tincidunt. Curabitur id commodo elit, in dapibus felis. Integer vestibulum neque nec odio consequat, vel efficitur dui volutpat. Sed sagittis, eros id luctus fermentum, felis quam ullamcorper magna, vel tempor velit libero in enim. Sed hendrerit mollis justo, ut suscipit ligula consectetur in. Vestibulum nec ipsum at odio elementum dictum. Suspendisse eget felis in ante tempor fermentum non quis nisi. In hac habitasse platea dictumst. Vivamus ut libero vel nisi consectetur hendrerit nec sed elit. Morbi bibendum vehicula risus et convallis. Phasellus bibendum magna id ante vehicula, quis sollicitudin odio aliquam.', '2024-04-01 09:00:00', NULL, 'img7.jpg', 27, 3),
(46, 'Introduction to Python Programming', 'Get started with Python, the versatile and powerful programming language.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse accumsan libero ac feugiat consequat. Nullam ut tellus vitae felis tempus vehicula. Phasellus maximus pharetra tincidunt. Curabitur id commodo elit, in dapibus felis. Integer vestibulum neque nec odio consequat, vel efficitur dui volutpat. Sed sagittis, eros id luctus fermentum, felis quam ullamcorper magna, vel tempor velit libero in enim. Sed hendrerit mollis justo, ut suscipit ligula consectetur in. Vestibulum nec ipsum at odio elementum dictum. Suspendisse eget felis in ante tempor fermentum non quis nisi. In hac habitasse platea dictumst. Vivamus ut libero vel nisi consectetur hendrerit nec sed elit. Morbi bibendum vehicula risus et convallis. Phasellus bibendum magna id ante vehicula, quis sollicitudin odio aliquam.', '2024-03-15 10:00:00', NULL, 'img8.jpg', 29, 1),
(47, 'The Future of Web Development: Trends to Watch', 'Stay updated with the latest trends shaping the future of web development.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse accumsan libero ac feugiat consequat. Nullam ut tellus vitae felis tempus vehicula. Phasellus maximus pharetra tincidunt. Curabitur id commodo elit, in dapibus felis. Integer vestibulum neque nec odio consequat, vel efficitur dui volutpat. Sed sagittis, eros id luctus fermentum, felis quam ullamcorper magna, vel tempor velit libero in enim. Sed hendrerit mollis justo, ut suscipit ligula consectetur in. Vestibulum nec ipsum at odio elementum dictum. Suspendisse eget felis in ante tempor fermentum non quis nisi. In hac habitasse platea dictumst. Vivamus ut libero vel nisi consectetur hendrerit nec sed elit. Morbi bibendum vehicula risus et convallis. Phasellus bibendum magna id ante vehicula, quis sollicitudin odio aliquam.', '2024-02-15 11:00:00', NULL, 'img9.jpg', 29, 4);

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
(17, 19, 51),
(21, 44, 86),
(22, 45, 87),
(23, 89, 92),
(27, 89, 105);

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
(17, 'Shelly', 'Cros', 'shelly.cros@gmail.com', 'avatar2.png', '$2y$10$UeKjtmZ9juLZ0bMqIMgdK.bqD0V1stcj1vl4P/yaKmmGYyhxI3Q5G', '2024-04-01 10:31:06', 'basic'),
(25, 'Jean', 'Dupont', 'jean.dupont@example.com', 'avatar.png', '$2y$10$rI48RzCSsP/.sjP8lGnU8uew7T9L/ALmbwI30V.eJoZki2ABjGM2m', '2024-04-24 13:57:48', 'basic'),
(26, 'Marie', 'Leroy', 'marie.leroy@example.com', 'avatar.png', '$2y$10$rI48RzCSsP/.sjP8lGnU8uew7T9L/ALmbwI30V.eJoZki2ABjGM2m', '2024-04-24 13:57:48', 'basic'),
(27, 'Pierre', 'Martin', 'pierre.martin@example.com', 'avatar.png', '$2y$10$rI48RzCSsP/.sjP8lGnU8uew7T9L/ALmbwI30V.eJoZki2ABjGM2m', '2024-04-24 13:57:48', 'admin'),
(28, 'Sophie', 'Dufour', 'sophie.dufour@example.com', 'avatar.png', '$2y$10$rI48RzCSsP/.sjP8lGnU8uew7T9L/ALmbwI30V.eJoZki2ABjGM2m', '2024-04-24 13:57:48', 'basic'),
(29, 'Antoine', 'Garcia', 'antoine.garcia@example.com', 'avatar.png', '$2y$10$rI48RzCSsP/.sjP8lGnU8uew7T9L/ALmbwI30V.eJoZki2ABjGM2m', '2024-04-24 13:57:48', 'admin'),
(30, 'Maxwell', 'Everest', 'maxwell.everest@example.com', 'avatar.png', '$2y$10$rI48RzCSsP/.sjP8lGnU8uew7T9L/ALmbwI30V.eJoZki2ABjGM2m', '2023-10-15 08:00:00', 'basic');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT pour la table `mainComment`
--
ALTER TABLE `mainComment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `responseComment`
--
ALTER TABLE `responseComment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
