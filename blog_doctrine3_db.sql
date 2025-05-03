-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 17 mars 2025 à 09:39
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog_doctrine3_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `billets`
--

DROP TABLE IF EXISTS `billets`;
CREATE TABLE IF NOT EXISTS `billets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `texte` longtext NOT NULL,
  `datepost` datetime NOT NULL,
  `photoPost` varchar(255) DEFAULT NULL,
  `utilisateur_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4FCF9B68FB88E14F` (`utilisateur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `billets`
--

INSERT INTO `billets` (`id`, `titre`, `texte`, `datepost`, `photoPost`, `utilisateur_id`) VALUES
(1, 'L\'Économie Verte : Vers un Avenir Durable ?', 'L’économie verte vise à concilier croissance économique et respect de l’environnement en promouvant des pratiques durables, comme l’adoption des énergies renouvelables, la réduction des déchets, et l’économie circulaire. Ce modèle encourage l\'abandon progressif des énergies fossiles au profit de sources comme le solaire, l’éolien et l’hydrogène vert, permettant ainsi de réduire les émissions de gaz à effet de serre. La transition vers une économie verte est cependant coûteuse et présente des défis. Elle nécessite des investissements massifs dans les infrastructures et la formation professionnelle, car certains secteurs, comme les énergies fossiles, perdront des emplois. Des programmes de reconversion sont donc essentiels pour rendre cette transition juste. Enfin, les consommateurs jouent un rôle crucial : en choisissant des produits durables et en soutenant les entreprises responsables, ils influencent l’adoption de pratiques plus écologiques. Cependant, cette transition ne peut réussir qu’avec des régulations ambitieuses et une coopération internationale pour garantir un avenir durable pour tous.', '2025-03-05 10:25:57', NULL, 1),
(2, 'Télétravail et Productivité : Quels Sont les Vrais Impacts ?', 'Le télétravail permet aux employés de réduire les trajets et d\'aménager un environnement de travail plus confortable. Cependant, il a aussi des inconvénients, comme le risque d\'isolement social et la difficulté à déconnecter. Des études montrent que la productivité peut être améliorée pour certains, mais que d’autres souffrent d’un manque de motivation et d’interactions directes. D’un point de vue managérial, certaines entreprises hésitent encore à adopter le télétravail à long terme, craignant un relâchement dans la discipline ou des problèmes de sécurité des données. Néanmoins, le télétravail offre des économies potentielles sur les frais d\'infrastructure et pourrait attirer de nouveaux talents désireux de plus de flexibilité.', '2025-03-05 10:26:42', 'images/uploads_post/post_1741166802.jpg', 1),
(3, 'Les Cryptomonnaies : Un Placement d\'Avenir ou une Bulle Spéculative ?', 'Les cryptomonnaies sont-elles un moyen révolutionnaire de gérer la monnaie ou simplement une bulle qui finira par éclater ? Le Bitcoin, l\'Ethereum et d\'autres actifs numériques ont vu leur valeur exploser, suscitant l\'intérêt des investisseurs et la crainte des régulateurs. Alors que certains considèrent le Bitcoin comme de l\'or numérique, d\'autres estiment qu\'il repose sur une spéculation qui finira mal. Les cryptomonnaies posent également des questions de sécurité et de régulation. Les piratages et les fraudes restent des risques majeurs dans ce secteur non régulé, et les gouvernements cherchent des moyens de légiférer pour protéger les investisseurs tout en évitant d’étouffer l\'innovation.', '2025-03-05 10:27:25', 'images/uploads_post/post_1741166845.jpg', 1),
(4, 'L’Alimentation Durable : Comment Manger Plus Écologique au Quotidien ?', 'L\'alimentation durable consiste à choisir des produits qui ont un faible impact sur l\'environnement tout en étant bénéfiques pour la santé. Cela inclut, par exemple, de privilégier les produits locaux, de saison, et d\'origine biologique, ainsi que de réduire la consommation de viande, dont l\'empreinte carbone est importante. Selon plusieurs études, la production de viande et de produits laitiers représente environ 15 % des émissions de gaz à effet de serre mondiales, un chiffre qui pourrait être réduit si les consommateurs optaient pour des alternatives végétales. Manger durable ne signifie pas nécessairement devenir végétarien, mais implique de consommer de manière plus réfléchie. Planifier ses repas, acheter en vrac, et limiter le gaspillage alimentaire sont des actions concrètes qui permettent d’adopter une alimentation plus respectueuse de la planète. De nombreux consommateurs trouvent qu\'en prenant conscience de l\'origine et de l\'impact de leurs aliments, ils gagnent en santé et économisent aussi de l\'argent. Cependant, l\'alimentation durable n\'est pas exempte de défis. Le coût de certains produits biologiques, par exemple, peut être prohibitif pour de nombreuses familles. De plus, des efforts sont encore nécessaires pour améliorer l\'accessibilité des alternatives durables, surtout dans les zones urbaines et rurales isolées.', '2025-03-05 10:27:45', 'images/uploads_post/post_1741166865.jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `texte` varchar(255) NOT NULL,
  `datepost` datetime NOT NULL,
  `utilisateur_id` int DEFAULT NULL,
  `billet_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DB021E96FB88E14F` (`utilisateur_id`),
  KEY `IDX_DB021E9644973C78` (`billet_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `texte`, `datepost`, `utilisateur_id`, `billet_id`) VALUES
(1, 'Il y a encore beaucoup à faire pour que cette transition soit juste. Les grandes entreprises doivent être responsables et jouer un rôle actif, sinon ce sont toujours les citoyens qui paieront le prix.\"', '2025-03-05 10:30:48', 2, 1),
(3, 'Je suis en télétravail depuis 2 ans et j’adore la flexibilité que cela m’apporte. J’ai l’impression de mieux gérer mon temps, et je me sens même plus productive !\"', '2025-03-05 10:33:07', 2, 2),
(4, 'Je pense que les cryptomonnaies sont l’avenir de la finance. Oui, c’est risqué, mais toute innovation l’est au début. C’est comme Internet dans les années 90 !', '2025-03-05 10:33:21', 2, 3),
(5, 'Merci pour cet article ! Personnellement, j\'ai réduit ma consommation de viande et commencé à acheter plus de produits locaux. Ce n\'est pas facile tous les jours, mais on se sent mieux dans sa peau et dans son assiette !', '2025-03-05 10:33:36', 2, 4),
(6, 'Je pense que c’est une bonne chose. On ne peut plus continuer à ignorer l\'impact de notre économie sur la planète. La croissance doit être durable, sinon elle n’aura pas d\'avenir.\"', '2025-03-05 10:34:23', 3, 1),
(7, 'Le télétravail est une bonne solution, mais il faut fixer des règles claires et mesurer les résultats pour garantir que cela fonctionne pour l’entreprise', '2025-03-05 10:34:42', 3, 2),
(8, 'Les cryptomonnaies ont un vrai potentiel pour moderniser le système monétaire, mais elles doivent être mieux encadrées. Sinon, ça risque de se retourner contre les petits investisseurs.', '2025-03-05 10:34:51', 3, 3),
(9, 'C’est vrai que manger durable peut coûter cher, surtout pour une famille nombreuse. On fait de notre mieux, mais je trouve que les grandes surfaces devraient proposer plus de produits bio et locaux à prix abordables.', '2025-03-05 10:35:01', 3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `photo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `passwd`, `nom`, `prenom`, `admin`, `photo`) VALUES
(1, 'ADMIN', '$2y$10$9moSM/0Hv5NOGhuNI2MmHuKD6JlTG2j2pGArsXakJClCE59khEfF6', 'ADMIN', 'ADMIN', 1, 'images/uploads/profil_1.png'),
(2, 'TOTO', '$2y$10$272Pq.iPTsQaiqiJiFsaW.4nUafkGn30sbwvVQd3w86MD2QxPkBFu', 'TOTO', 'TOTO', 0, 'images/uploads/profil_2.jpg'),
(3, 'TITI', '$2y$10$OhPnFjB0ERWsAvnu9toJLuYBJCbvCb6nnM26q09fuJs9aNAe8/HG2', 'TITI', 'TITI', 0, 'images/uploads/profil_default.png');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
