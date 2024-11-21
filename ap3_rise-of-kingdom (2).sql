-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db:3306
-- Généré le : jeu. 21 nov. 2024 à 07:47
-- Version du serveur : 8.4.1
-- Version de PHP : 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ap3_rise-of-kingdom`
--

-- --------------------------------------------------------

--
-- Structure de la table `ADMINISTRATEUR`
--

CREATE TABLE `ADMINISTRATEUR` (
  `idadministrateur` int NOT NULL,
  `nom` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `prenom` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `motpasse` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `a2f_secret_string` varchar(255) COLLATE utf8mb3_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Déchargement des données de la table `ADMINISTRATEUR`
--

INSERT INTO `ADMINISTRATEUR` (`idadministrateur`, `nom`, `prenom`, `motpasse`, `email`, `a2f_secret_string`) VALUES
(1, 'admin', 'admin', '$2a$12$mJ7h1.AQewjLxApgFGiMfuYGeXaadSEWm4JRil6HUxpTWgaSuawre', 'admin@hackathon.fr', NULL),
(13, 'Menin', 'Colin', '$2a$10$ozwa685h1EhEosHPuIE21eAd1kNsNtrBWBT5pUvCJtvh0aMYLNZx2', 'colinmenin@gmail.com', 'DAABQFAV7UKJSFXAAGPC25QYWBQ2ZKSJ'),
(14, 'Paquereau', 'Enzo', '$2a$10$Izajp078naLX4AoiGK3koO81XexMsrZstbsUED6Ie.bPkjjkokUUa', 'enzo@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `EQUIPE`
--

CREATE TABLE `EQUIPE` (
  `idequipe` int NOT NULL,
  `nomequipe` varchar(255) NOT NULL,
  `lienprototype` varchar(255) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `archiver` tinyint(1) DEFAULT '0',
  `a2f_secret_string` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `EQUIPE`
--

INSERT INTO `EQUIPE` (`idequipe`, `nomequipe`, `lienprototype`, `login`, `password`, `archiver`, `a2f_secret_string`) VALUES
(1, 'Les profs', 'lien.prof.com', 'profs@gmail.com', '$2y$10$zhqnpXR7S37bDPDFHbSHtueFGDqZrXOS3zqc6Ry0gX8sf30YHGEQe', 1, NULL),
(2, 'Jobar team', NULL, 'jobar@hotmail.com', '$2y$10$zhqnpXR7S37bDPDFHbSHtueFGDqZrXOS3zqc6Ry0gX8sf30YHGEQe', 0, NULL),
(3, 'Validation Équipe', 'https://www.google.com', 'validation@google.com', '$2y$12$5ZISC1f1gr5iAeVO4andaucTkdXgA79IIagj9Uhei7KR3NiqyNU1K', 0, NULL),
(4, 'Rise', 'XX', 'azezatr@gmail.com', '$2y$12$CIE.N7wuuuCUhNv4U.loGe3P06F/GKNcyWa9AQHV4AIqgAItLwbNW', 0, NULL),
(5, 'Kingdom', 'Kingdom.rise', 'azerty@gmail.com', '$2y$12$juhVrhNgf5IjFVJwixGIHO/3TuHyWn8rjQV/K6PEKDvVuB/Z3Smja', 0, NULL),
(7, 'test23', 'sdff', 'poq@gmail.com', '$2y$12$rydQngpNgwauzofDNZ88Du4JWWo6W5//i2.i6NW7XASiqZH/4HQZe', 0, NULL),
(8, 'sqdsqdsq', 'XX', 'testtest@gmail.com', '$2y$12$FHk//h07axe2woOSxBIYN.bFjCrJMrvTQ.xQ9NGLocqerZlY/wqVy', 0, NULL),
(9, 'sdfsdf', 'sdfsdfsd', 'wxcf@gmail.com', '$2y$12$XVRjKP9vF4zqZLo6vcNPs.NicJb2.9ijfxQHPp6hnNyzMiFPKPnjq', 0, NULL),
(10, 'sdfvgbdfhbgf', 'dfgdfgdfg', 'fsdgfsdgftsd@gmail.com', '$2y$12$cu9TmI5KWf.8RmwVUOMrUOdWbpqRzrkN2iAYx5QSEczIe31lZSz4e', 0, NULL),
(11, 'eaezazeaz', 'kindom', 'azerzzer@gmail.com', '$2y$12$dFTgK/8xCRzfCFDuW1UohOfYiYhiQgJ1pLyUzGIP40qFAVACS7Xuu', 0, NULL),
(12, 'dqs', 'qsdqsd', 'qsdqsdqsdqsd@gmail.com', '$2y$12$mTkVa14PnNQFbmYReBndiO8ns04ZPjCxiqpPzuBL0iECxzvSNrUOG', 0, NULL),
(14, 'qsdqsdqs', 'qsdqsdqsdqsd', 'sitedepaf@gmail.com', '$2y$12$4VIH82aOGUBB1lHb6g2N8eIPxpupT6ULV9Ro6FAfxoSgEuQ9S8JkC', 0, NULL),
(15, 'testn2', 'XXXtentacion', 'azerty123@gmail.com', '$2y$12$aj5Ml0FpfeBwwZfiDrvXXesHQSECrHIK8NNieHhK//iepB6l3iYM6', 0, NULL),
(16, 'test234', 'aze', 'aze@gmail.com', '$2y$12$MbEAyaQi9MtR8AZ9nHFcIeN5KhILkQVV/OPkvZv2qThzdTrO9Zhfi', 0, NULL),
(17, 'eazeeaze', 'azeazeaze', 'azerzetzet@gmail.com', '$2y$12$S3kXLiXMQZ37W3VzKohuvu4cHWiMYlPf82chYw2bl0aVLN0kb2Q8i', 0, NULL),
(18, 'TESt1', 'zezez', 'azerty12@gmail.com', '$2y$12$yoQwkwCz9LkGmtBMNA0CX.3fweY8QtQETHOB9dNYDkfiLzydQY7qa', 0, NULL),
(19, 'Fatou', 'yudgsdgifh', 'Fatou123', '$2a$10$UJYa2WVTIXkpXvmxdQrxyu3tPCSfD2pBo7dIKw2doQDZBhI05mUYm', 0, NULL),
(20, 'dfd', 'sfdfds', 'fsfd', '$2a$10$3n0U13Gik5Cm1j/h11VTEuBqosyWP3FHberEkquUrJ/Ocj9k.5/vm', 0, NULL),
(21, 'sddfg', 'fee', 'f', '$2a$10$oGyakXJp8fRtR7UQ.JhpTu.QK8D6zZNimQelBwGcl9nkT6gr9yMVm', 0, NULL),
(22, 'testaddmembre', 'dffs', 'fsdgger', '$2a$10$w8dLg0ic2NVno0XIIAEhV.j2igy2FP39yVlWLx.SqgABynD4qNv/q', 0, NULL),
(23, 'fdsd', 'dfsdff', 'fgfdf', '$2a$10$.1WuR6WSQ/5YvCg6lI7UaOHLTgA.g6fL/DDDJXjbgAje43ekH1aZa', 0, NULL),
(24, 'uitui', 'https://uytu7', 'guuytguig', '$2a$10$4tLvbr1CqvlZLzqyioeobO8pIg.wqQOdhpewZ/jezIdasfGk3cqmK', 0, NULL),
(25, 'test1', 'testtt', 'testazerty@gmail.com', '$2y$12$FnRe.LkpeyzlC/I.ZC76sOPcsQY9crYBZNjHWa4fci9SoaXHepCKW', 0, NULL),
(26, 'Test123', 'edzffds', 'testtt@gmail.com', '$2y$12$AUMBBqtHCucNkijq4/KAY.avVt6W7fN/Bi0wZZvqUt7xc9z55DsWm', 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `GROUPE_JURY`
--

CREATE TABLE `GROUPE_JURY` (
  `idgroupejury` int NOT NULL,
  `nomGroupeJury` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `GROUPE_JURY`
--

INSERT INTO `GROUPE_JURY` (`idgroupejury`, `nomGroupeJury`) VALUES
(1, ''),
(2, 'Jury Automne 2024'),
(3, 'Pas de jury '),
(4, 'test1234566');

-- --------------------------------------------------------

--
-- Structure de la table `HACKATHON`
--

CREATE TABLE `HACKATHON` (
  `idhackathon` int NOT NULL,
  `dateheuredebuth` datetime NOT NULL,
  `dateheurefinh` datetime NOT NULL,
  `lieu` varchar(128) NOT NULL,
  `ville` varchar(128) NOT NULL,
  `conditions` varchar(255) DEFAULT NULL,
  `thematique` varchar(128) DEFAULT NULL,
  `affiche` varchar(255) DEFAULT NULL,
  `objectifs` varchar(255) DEFAULT NULL,
  `idorganisateur` int DEFAULT NULL,
  `nbequipemax` int DEFAULT NULL,
  `Datebutoire` date DEFAULT NULL,
  `archivage` tinyint(1) DEFAULT '0',
  `idgroupejury` int DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `HACKATHON`
--

INSERT INTO `HACKATHON` (`idhackathon`, `dateheuredebuth`, `dateheurefinh`, `lieu`, `ville`, `conditions`, `thematique`, `affiche`, `objectifs`, `idorganisateur`, `nbequipemax`, `Datebutoire`, `archivage`, `idgroupejury`) VALUES
(1, '2025-06-26 23:00:00', '2025-06-30 12:00:00', 'Cité des sciences', 'Angers', 'Aucune', 'Code & Co', '/img/affiche.png', 'Apprendre le code', 1, 0, '2025-06-26', 1, 1),
(2, '2024-11-15 12:24:48', '2025-06-27 12:24:54', 'Le Louvre', 'Paris', 'Aucune', 'Craft It', '/img/affiche.png', 'Démo', 1, 0, '2024-11-15', 1, 2),
(3, '2024-09-16 22:00:00', '2025-09-18 23:00:00', 'Manufacture Collaborative', 'NANTES', 'Aux porteurs de projets (entreprises, associations…) qui souhaitent challenger un projet/une idée pour l’éco-concevoir.', 'Hackathon de l’écoconception', '', 'Réduire l’impact écologique d’un produit ou d’un service en repensant son développement, ses fonctionnalités ou son usage.', 2, 5, NULL, 0, 3),
(4, '2024-11-15 14:09:57', '2024-11-30 14:09:57', 'Monmarte', 'Paris', '', 'Baka', '', '', 3, 0, '2024-11-29', 1, 1),
(6, '2024-09-21 14:18:27', '2024-09-29 14:18:27', 'dpfopjsdp', 'Angers', 'sf', 'jeue', 'wdfs', 'df', 3, 0, '2024-09-21', 0, 3),
(9, '2025-06-26 23:00:00', '2025-06-30 12:00:00', 'Cité des sciences', 'Angers', 'Aucune', 'Code & Co', '/img/affiche.png', 'Apprendre le code', 1, 5, NULL, 0, 1),
(10, '2024-09-10 09:00:00', '2024-09-12 17:00:00', 'Palais des congrès', 'Paris', 'Aucune', 'Tech for Good', '/img/affiche.png', 'Innover pour un impact social', 1, 6, NULL, 0, 2),
(11, '2024-11-15 23:41:58', '2024-11-30 23:41:58', 'ffd', 'dfsdfsdfdf', 'ddfsfsd', 'sdfdfs', 'sdfds', 'dfsdfs', 2, 5, '2024-11-15', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `INSCRIRE`
--

CREATE TABLE `INSCRIRE` (
  `idhackathon` int NOT NULL,
  `idequipe` int NOT NULL,
  `dateinscription` date NOT NULL,
  `datedesincription` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `INSCRIRE`
--

INSERT INTO `INSCRIRE` (`idhackathon`, `idequipe`, `dateinscription`, `datedesincription`) VALUES
(1, 1, '2022-06-27', '2024-11-10'),
(1, 2, '2022-06-09', NULL),
(2, 1, '2022-06-17', '2024-11-10'),
(2, 3, '2024-08-28', '2024-11-10'),
(2, 4, '2024-09-27', '2024-11-10'),
(2, 5, '2024-09-27', '2024-11-10'),
(2, 9, '2024-09-27', '2024-11-10'),
(2, 12, '2024-09-27', '2024-11-10'),
(2, 17, '2024-10-04', '2024-11-10'),
(2, 18, '2024-10-18', '2024-11-10'),
(3, 25, '2024-11-21', NULL),
(3, 26, '2024-11-21', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `JUGE`
--

CREATE TABLE `JUGE` (
  `idjuge` int NOT NULL,
  `nom` varchar(128) NOT NULL,
  `prenom` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `entreprise` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `JUGE`
--

INSERT INTO `JUGE` (`idjuge`, `nom`, `prenom`, `email`, `entreprise`) VALUES
(1, 'Dupont', 'Marie', 'marie.dupont@example.com', 'TechCorp'),
(2, 'Martin', 'Paul', 'paul.martin@example.com', 'Innova'),
(3, 'Durand', 'Sophie', 'sophie.durand@example.com', 'BioLife'),
(4, 'Leroy', 'Julie', 'julie.leroy@example.com', 'OpenSource Inc.'),
(5, 'Nguyen', 'Leo', 'leo.nguyen@example.com', 'EcoBuild'),
(6, 'Bernard', 'Anna', 'anna.bernard@example.com', 'GreenTech'),
(7, 'Moreau', 'Pierre', 'pierre.moreau@example.com', 'AI Innovations'),
(8, 'Dupont', 'Antoine', 'antoinedpt@gmail.com', 'Space Y');

-- --------------------------------------------------------

--
-- Structure de la table `JURY`
--

CREATE TABLE `JURY` (
  `idgroupejury` int NOT NULL,
  `idjuge` int NOT NULL,
  `Date_insertion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `JURY`
--

INSERT INTO `JURY` (`idgroupejury`, `idjuge`, `Date_insertion`) VALUES
(1, 1, NULL),
(1, 2, NULL),
(1, 3, NULL),
(1, 4, NULL),
(1, 5, NULL),
(2, 2, NULL),
(2, 3, NULL),
(2, 5, NULL),
(2, 6, NULL),
(2, 7, NULL),
(2, 8, '2024-11-19'),
(4, 1, '2024-11-19');

--
-- Déclencheurs `JURY`
--
DELIMITER $$
CREATE TRIGGER `before_insert_jury` BEFORE INSERT ON `JURY` FOR EACH ROW BEGIN
    IF NEW.Date_insertion IS NULL THEN
        SET NEW.Date_insertion = CURRENT_DATE;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `Log`
--

CREATE TABLE `Log` (
  `id` int NOT NULL,
  `admin_id` int NOT NULL,
  `target_admin_id` int DEFAULT NULL,
  `action_type` varchar(50) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `details` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Log`
--

INSERT INTO `Log` (`id`, `admin_id`, `target_admin_id`, `action_type`, `timestamp`, `details`) VALUES
(13, 1, 13, 'Désactivation', '2024-11-16 02:57:18', 'A2F désactivée avec succès.'),
(14, 14, NULL, 'Désactivation', '2024-11-16 21:55:28', 'A2F désactivée avec succès.'),
(15, 13, NULL, 'Désactivation', '2024-11-16 22:20:24', 'A2F désactivée avec succès.'),
(16, 14, 13, 'Désactivation', '2024-11-16 22:20:26', 'L\'administrateur Paquereau Enzo a désactivé la 2FA de l\'administrateur cible.');

-- --------------------------------------------------------

--
-- Structure de la table `MEMBRE`
--

CREATE TABLE `MEMBRE` (
  `idmembre` int NOT NULL,
  `idequipe` int DEFAULT NULL,
  `nom` varchar(128) NOT NULL,
  `prenom` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(128) DEFAULT NULL,
  `datenaissance` date DEFAULT NULL,
  `lienportfolio` varchar(255) DEFAULT NULL,
  `archiver` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `MEMBRE`
--

INSERT INTO `MEMBRE` (`idmembre`, `idequipe`, `nom`, `prenom`, `email`, `telephone`, `datenaissance`, `lienportfolio`, `archiver`) VALUES
(1, 1, 'Membre126', 'Roger', 'membre1@gmail.com', '06822455', '1988-02-28', '', 0),
(2, 2, 'Membre2', 'Roger', 'membre2@gmail.com', '0689726343', '2021-06-27', NULL, 0),
(4, 2, 'Menin', 'Colin', 'colinmenin@aol.com', '0654856963', '2003-01-31', 'https://test1', 0),
(8, 8, 'gr', 'dggre', 'grrge@ewfe.com', '0645859632', '1909-07-23', '', 0),
(9, 3, 'ASF', 'SDFD', 'SCDD@HIOH.COM', '0654856963', '1939-10-25', '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ORGANISATEUR`
--

CREATE TABLE `ORGANISATEUR` (
  `idorganisateur` int NOT NULL,
  `nom` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `prenom` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Déchargement des données de la table `ORGANISATEUR`
--

INSERT INTO `ORGANISATEUR` (`idorganisateur`, `nom`, `prenom`, `email`) VALUES
(1, 'PIVERT', 'Thomas', 'thomas.pivert@assoINFO.org'),
(2, 'HERNANDEZ', 'Valérie', 'valerie.hernandez@evol.fr'),
(3, 'GUIVAZE', 'David', 'd.guivaze@envol.fr'),
(4, 'Menin', 'Colin', 'colin.menin@aol.com');

-- --------------------------------------------------------

--
-- Structure de la table `TOKEN`
--

CREATE TABLE `TOKEN` (
  `uuid` varchar(128) NOT NULL,
  `idequipe` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ADMINISTRATEUR`
--
ALTER TABLE `ADMINISTRATEUR`
  ADD PRIMARY KEY (`idadministrateur`);

--
-- Index pour la table `EQUIPE`
--
ALTER TABLE `EQUIPE`
  ADD PRIMARY KEY (`idequipe`),
  ADD UNIQUE KEY `ulogin` (`login`);

--
-- Index pour la table `GROUPE_JURY`
--
ALTER TABLE `GROUPE_JURY`
  ADD PRIMARY KEY (`idgroupejury`);

--
-- Index pour la table `HACKATHON`
--
ALTER TABLE `HACKATHON`
  ADD PRIMARY KEY (`idhackathon`),
  ADD KEY `hackathon_ibfk_1` (`idorganisateur`),
  ADD KEY `fk_hackathon_groupejury` (`idgroupejury`);

--
-- Index pour la table `INSCRIRE`
--
ALTER TABLE `INSCRIRE`
  ADD PRIMARY KEY (`idhackathon`,`idequipe`),
  ADD KEY `i_fk_inscrire_hackathon1` (`idhackathon`),
  ADD KEY `i_fk_inscrire_equipe1` (`idequipe`);

--
-- Index pour la table `JUGE`
--
ALTER TABLE `JUGE`
  ADD PRIMARY KEY (`idjuge`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `JURY`
--
ALTER TABLE `JURY`
  ADD PRIMARY KEY (`idgroupejury`,`idjuge`),
  ADD KEY `idjuge` (`idjuge`);

--
-- Index pour la table `Log`
--
ALTER TABLE `Log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `target_admin_id` (`target_admin_id`);

--
-- Index pour la table `MEMBRE`
--
ALTER TABLE `MEMBRE`
  ADD PRIMARY KEY (`idmembre`),
  ADD KEY `i_fk_membre_equipe1` (`idequipe`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ORGANISATEUR`
--
ALTER TABLE `ORGANISATEUR`
  ADD PRIMARY KEY (`idorganisateur`);

--
-- Index pour la table `TOKEN`
--
ALTER TABLE `TOKEN`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `i_fk_token_equipe1` (`idequipe`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `ADMINISTRATEUR`
--
ALTER TABLE `ADMINISTRATEUR`
  MODIFY `idadministrateur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `EQUIPE`
--
ALTER TABLE `EQUIPE`
  MODIFY `idequipe` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `GROUPE_JURY`
--
ALTER TABLE `GROUPE_JURY`
  MODIFY `idgroupejury` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `HACKATHON`
--
ALTER TABLE `HACKATHON`
  MODIFY `idhackathon` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `JUGE`
--
ALTER TABLE `JUGE`
  MODIFY `idjuge` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `Log`
--
ALTER TABLE `Log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `MEMBRE`
--
ALTER TABLE `MEMBRE`
  MODIFY `idmembre` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ORGANISATEUR`
--
ALTER TABLE `ORGANISATEUR`
  MODIFY `idorganisateur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `HACKATHON`
--
ALTER TABLE `HACKATHON`
  ADD CONSTRAINT `fk_hackathon_groupejury` FOREIGN KEY (`idgroupejury`) REFERENCES `GROUPE_JURY` (`idgroupejury`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `hackathon_ibfk_1` FOREIGN KEY (`idorganisateur`) REFERENCES `ORGANISATEUR` (`idorganisateur`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `INSCRIRE`
--
ALTER TABLE `INSCRIRE`
  ADD CONSTRAINT `inscrire_ibfk_1` FOREIGN KEY (`idhackathon`) REFERENCES `HACKATHON` (`idhackathon`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscrire_ibfk_2` FOREIGN KEY (`idequipe`) REFERENCES `EQUIPE` (`idequipe`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `JURY`
--
ALTER TABLE `JURY`
  ADD CONSTRAINT `JURY_ibfk_1` FOREIGN KEY (`idgroupejury`) REFERENCES `GROUPE_JURY` (`idgroupejury`) ON DELETE CASCADE,
  ADD CONSTRAINT `JURY_ibfk_2` FOREIGN KEY (`idjuge`) REFERENCES `JUGE` (`idjuge`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Log`
--
ALTER TABLE `Log`
  ADD CONSTRAINT `Log_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `ADMINISTRATEUR` (`idadministrateur`) ON DELETE CASCADE,
  ADD CONSTRAINT `Log_ibfk_2` FOREIGN KEY (`target_admin_id`) REFERENCES `ADMINISTRATEUR` (`idadministrateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `MEMBRE`
--
ALTER TABLE `MEMBRE`
  ADD CONSTRAINT `membre_ibfk_2` FOREIGN KEY (`idequipe`) REFERENCES `EQUIPE` (`idequipe`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `TOKEN`
--
ALTER TABLE `TOKEN`
  ADD CONSTRAINT `token_ibfk_1` FOREIGN KEY (`idequipe`) REFERENCES `EQUIPE` (`idequipe`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
