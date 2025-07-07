-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 20 juin 2025 à 14:02
-- Version du serveur : 8.0.30
-- Version de PHP : 8.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `torrefacteurs`
--
CREATE DATABASE IF NOT EXISTS `torrefacteurs` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `torrefacteurs`;

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id_article` int NOT NULL,
  `titre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contenu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_publication` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_user` int NOT NULL,
  `category_id` int NOT NULL,
  `status` enum('encours','validé','non validé') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'encours'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id_article`, `titre`, `contenu`, `photo`, `date_publication`, `id_user`, `category_id`, `status`) VALUES
(6, 'Poudre de café', 'Le café moulu est l&#039;une des formes les plus populaires de consommation du café. Il permet aux amateurs de café de profiter d&#039;une infusion rapide, adaptée à différents types de machines et méthodes d&#039;extraction. Que vous soyez adepte de la cafetière à filtre, de la cafetière italienne ou du piston, le café moulu est une option pratique et accessible. Mais comment bien choisir son café moulu ? Quels sont ses avantages et ses caractéristiques ? Plongeons dans l&#039;univers aromatique du café moulu !', '6818c2987cc19.jpg', '2025-05-05 15:52:24', 3, 11, 'validé'),
(9, 'café en grain', 'Le grain de café est le cœur même de toute tasse de café. Avant de devenir cette boisson énergisante que nous savourons chaque jour, il traverse un long processus, de la culture à la torréfaction. Mais quels sont ses secrets ? Comment bien choisir son grain de café ? Plongeons dans l’univers fascinant du grain de café.', '6818c43e251d2.jpg', '2025-05-05 15:59:26', 2, 10, 'validé'),
(14, 'coffee cup', 'Les capsules de café offrent un compromis entre rapidité et qualité, mais leur impact environnemental est indéniable. En optant pour des alternatives rechargeables, recyclables ou des méthodes plus traditionnelles, les amateurs de café peuvent réduire leur empreinte écologique tout en continuant à savourer leur boisson préférée.', '6819ffe6982b9.jpg', '2025-05-06 14:26:14', 3, 12, 'validé'),
(15, 'Sans caféine', 'Le café décaféiné est une excellente option pour ceux qui veulent profiter du goût du café sans les effets excitants de la caféine. Grâce aux techniques modernes, il conserve une grande partie de ses saveurs et peut être tout aussi agréable qu’un café classique.\r\n\r\nAlors, prêt à découvrir un décaféiné aux arômes subtils et équilibrés ?', '681a01ce66212.jpg', '2025-05-06 14:34:22', 2, 13, 'validé'),
(18, 'café écrasé', 'Le café moulu est bien plus qu’une alternative pratique : c’est une porte d’entrée vers la richesse aromatique du café. En choisissant une mouture adaptée, une bonne torréfaction et en optimisant sa conservation, chacun peut apprécier une tasse parfaitement équilibrée et pleine de caractère.\r\n\r\nQue tu sois amateur de cafés légers et fruités ou de saveurs puissantes et corsées, il y a un café moulu qui correspond à tes goûts !', '681a049464fca.jpg', '2025-05-06 14:46:12', 1, 11, 'validé'),
(19, 'Le Café Arabica', 'Le café Arabica est un incontournable pour les amateurs de café qui recherchent une boisson raffinée et complexe. Son goût délicat, ses arômes variés et sa douceur en bouche en font une véritable référence dans le monde du café.\r\n\r\nAlors, prêt à savourer un Arabica venu des plus belles plantations du monde ?', '681a081ff0cef.jpg', '2025-05-06 15:01:20', 1, 15, 'validé'),
(20, 'Les capsules', 'Le café en capsule est une révolution si le café est encapsuler dans les bonne matières. Praesent placerat, magna in vehicula vestibulum, felis urna cursus lorem, sed vestibulum quam eros vel libero. Vivamus commodo, odio sed fringilla pretium, sem nulla feugiat odio, in cursus elit dolor et ex.', '6827332dcbc9d.jpg', '2025-05-16 14:44:29', 1, 12, 'validé'),
(22, 'Du café avec du chocolat', 'Le mariage entre le café et le chocolat est une véritable symphonie de saveurs. Cette combinaison offre un équilibre parfait entre l’amertume du café et la douceur du chocolat, créant une boisson riche, veloutée et délicieusement réconfortante. Que ce soit en cappuccino, en moka ou en simple infusion, ce duo séduit les amateurs de plaisirs gourmands et raffinés.', '683069ec9389c.jpg', '2025-05-23 14:28:28', 3, 10, 'validé'),
(23, 'Les meilleures façons de déguster', 'Le café au chocolat est une invitation à la gourmandise et à la découverte de nouvelles saveurs. Cette combinaison sublime à la fois la puissance du café et la douceur du cacao, créant une boisson réconfortante et pleine de caractère.\r\nQuel Type de Café Choisir ?\r\nArabica  Pour un café plus doux et subtil, qui se marie bien avec le chocolat au lait.  Robusta  Idéal pour un café plus corsé et puissant, parfait avec du chocolat noir.  Cafés d’origine épicés (Guatemala, Éthiopie)  Ajoutent des notes complexes et raffinées.', '68306b82ecc04.jpg', '2025-05-23 14:35:14', 3, 11, 'validé'),
(24, 'Une Alliance Gourmande et Subtile', 'Le mariage entre le café et la noisette est une combinaison exquise qui associe la puissance torréfiée du café à la douceur légèrement sucrée et croquante de la noisette. Que ce soit sous forme de café aromatisé, de latte noisette ou de dessert gourmand, cette fusion crée une expérience sensorielle unique.', '68306c4f551fc.jpg', '2025-05-23 14:38:39', 3, 11, 'validé'),
(26, 'Impact Écologique des Capsules', 'La question environnementale est souvent soulevée concernant l’usage des capsules. Voici quelques solutions pour réduire leur impact : Recycler les capsules en aluminium. De nombreux fabricants proposent des points de collecte. Privilégier les capsules biodégradables. Alternatives plus respectueuses de l’environnement. Opter pour des capsules réutilisables → Permet d’utiliser du café moulu sans générer de déchets plastiques ou métalliques.\r\n\r\nLa prise en compte de l’impact environnemental est essentielle pour une consommation responsable du café en capsule.', '68306fb71d9e8.jpg', '2025-05-23 14:53:11', 2, 12, 'validé'),
(27, 'Pourquoi Choisir un Café d’Origine ?', 'Authenticité et traçabilité. Issu d’une seule plantation, il permet de découvrir les arômes typiques d’une région. Richesse aromatique. Chaque terroir influence les saveurs du café, allant des notes florales aux touches épicées. Production artisanale. Souvent cultivé selon des méthodes traditionnelles qui respectent l’environnement. Expérience immersive. Déguster un café d’origine, c’est partir en voyage sensoriel à travers les continents.', '6830705c41013.jpg', '2025-05-23 14:55:56', 2, 15, 'validé'),
(28, 'Une Invitation au Voyage des Saveurs', 'Le café d’origine, aussi appelé café de terroir, est un café provenant d’une seule région ou plantation, sans mélange avec d’autres variétés. Son goût reflète directement le climat, le sol et les méthodes de culture de son lieu d’origine, ce qui en fait une expérience gustative authentique et unique.', '683070cdc0c5c.jpg', '2025-05-23 14:57:49', 2, 15, 'validé'),
(33, 'Peut-on savourer un café de spécialité décaféiné ?', 'Le décaféiné fait son entrée dans le monde du café de spécialité. Focus sur des producteurs qui créent des décas aux profils sensoriels impressionnants.', '6834250966d32.jpg', '2025-05-23 15:28:41', 3, 13, 'validé'),
(34, ' Café moulu : l’équilibre parfait entre tradition et praticité', 'Le café moulu reste un choix incontournable pour les amateurs de café à la maison. Facile à utiliser, il permet de conserver les arômes d’un café fraîchement torréfié tout en étant compatible avec de nombreuses méthodes d’extraction (filtre, piston, moka).\r\nDans cet article, découvrez comment bien choisir votre café moulu selon sa finesse, sa torréfaction, et la méthode d’infusion que vous utilisez. Nous vous proposons également nos meilleures recommandations de cafés moulus, issus de terroirs uniques et moulus à la demande pour préserver leurs saveurs.\r\n', '6834211cd7994.jpg', '2025-05-26 10:06:52', 7, 11, 'validé'),
(35, 'Café décaféiné : du goût sans la caféine', 'Le café décaféiné a longtemps souffert d’une mauvaise réputation, mais les nouvelles méthodes d’extraction naturelles (comme à l’eau ou au CO2) permettent aujourd’hui de savourer un café riche en arômes, sans les effets stimulants de la caféine.\r\nIdéal pour une consommation en soirée ou pour les personnes sensibles, le décaféiné peut être tout aussi complexe et gourmand qu’un café classique. Explorez notre sélection de cafés décaféinés artisanaux, respectueux du goût et de la santé.\r\n', '683421aaba7f1.jpg', '2025-05-26 10:09:14', 7, 13, 'validé'),
(36, 'Café d’Origine (Single Origin)', 'Les cafés dits “d’origine” proviennent d’une seule région, ferme ou coopérative. Ils offrent une expression unique du terroir, influencée par le climat, l’altitude, le type de sol et les méthodes de culture.\r\nCes cafés sont idéals pour les amateurs qui souhaitent explorer des profils de saveurs spécifiques : floral et délicat pour un café éthiopien, chocolaté et rond pour un café colombien…\r\nPlongez dans l’univers des cafés d’origine avec notre sélection soigneusement sourcée auprès de producteurs engagés dans une agriculture durable.\r\n', '6834227f48937.jpg', '2025-05-26 10:12:47', 7, 15, 'validé'),
(37, 'Café en capsules : la rapidité sans compromis sur la qualité', 'Longtemps synonyme de commodité, le café en capsules évolue. Aujourd’hui, les torréfacteurs indépendants proposent des capsules compatibles (souvent compostables) contenant des cafés de spécialité.\r\nL’objectif ? Allier praticité et goût, sans négliger la fraîcheur ni l’engagement écologique.\r\nDécouvrez nos capsules artisanales, parfaites pour les amateurs pressés mais exigeants, avec des profils aromatiques variés et respectueux de l’environnement.\r\n', '683423f5a4022.jpg', '2025-05-26 10:19:01', 8, 12, 'validé'),
(38, 'Comment conserver son café moulu pour préserver les arômes ?', 'Découvrez les meilleures pratiques pour éviter l’oxydation de votre café moulu : types de contenants, conditions de conservation, erreurs fréquentes à éviter.', '6834245275d6d.jpg', '2025-05-26 10:20:34', 8, 11, 'validé'),
(39, 'Café de Colombie, d’Éthiopie ou du Guatemala : comment faire son choix ?', 'Un comparatif des profils aromatiques des grands pays producteurs, pour apprendre à choisir en fonction de ses préférences gustatives.', '683424a00f0d7.jpg', '2025-05-26 10:21:52', 8, 15, 'validé'),
(40, 'Mouture fine, moyenne ou grossière : quelle mouture pour quelle cafetière ?', 'Un guide pratique pour adapter la mouture de votre café à votre méthode d’infusion : Espresso, filtre, presse française, moka…', '68342a269a9e1.jpg', '2025-05-26 10:45:26', 2, 11, 'validé'),
(41, 'Qu’est-ce que le café en grains ?', 'Différences entre café en grains, moulu, soluble, capsules.\r\n\r\n\r\nAvantages du café en grains (fraîcheur, arômes, écologie…).\r\n\r\n\r\nPourquoi il est préféré par les amateurs de café.\r\n', '68342bab52e18.jpg', '2025-05-26 10:51:55', 2, 10, 'validé'),
(42, ' Café et chocolat : une alliance intemporelle', 'Les points communs entre le café et le chocolat (terroir, amertume, richesse aromatique).\r\n\r\n\r\nQuel chocolat avec quel café ?\r\n\r\n Ex. :\r\n\r\n\r\nEspresso + chocolat noir 70 %\r\n\r\n\r\nMoka éthiopien + chocolat au lait\r\n\r\n\r\nRobusta corsé + chocolat pimenté ou épicé\r\n\r\n\r\nRecette express : café moka maison avec ganache fondue.\r\n', '68342c288bac3.jpg', '2025-05-26 10:54:00', 2, 11, 'validé'),
(43, 'Café et biscuits : le duo réconfortant', 'Les biscuits classiques qui s’accordent avec un café filtre ou un cappuccino : sablés, cookies, amaretti, cantucci, shortbread…\r\n\r\n\r\nCombo par type de café :\r\n\r\n\r\nCafé doux (Colombie, Brésil) + cookies aux noix de pécan\r\n\r\n\r\nCafé fruité (Kenya) + sablés citron\r\n\r\n\r\nEspresso corsé + biscuits au gingembre ou aux épices\r\n\r\n\r\nRecette maison : biscuit noisette-café.\r\n', '68342cec553fd.jpg', '2025-05-26 10:57:16', 2, 13, 'validé'),
(44, 'Moudre ses grains : quel impact ?', 'Pourquoi moudre juste avant infusion est crucial.\r\n\r\n\r\nLes différents types de moulins (manuel vs électrique, à lames vs meules).\r\n\r\n\r\nQuelle mouture pour quelle méthode : espresso, filtre, French press, etc.\r\n', '68342d5545e52.jpg', '2025-05-26 10:59:01', 2, 11, 'validé'),
(45, ' Café et fruits secs : des associations élégantes', 'Pourquoi les fruits secs fonctionnent avec le café : croquant, intensité, richesse.\r\n\r\n\r\nExemples d’associations :\r\n\r\n\r\nNoix + café nature (Moka, Yirgacheffe)\r\n\r\n\r\nNoisettes grillées + café lacté (latte, cappuccino)\r\n\r\n\r\nAmandes + café doux ou décaféiné\r\n\r\n\r\nDattes, figues séchées ou pruneaux + café à l’arôme boisé\r\n\r\n\r\nIdée snack : energy balls café–amande–cacao.\r\n', '68342da6cf994.jpg', '2025-05-26 11:00:22', 2, 10, 'validé'),
(46, 'hvggvgujq vuyyu hjb', 'Etiam id velit feugiat, scelerisque velit a, scelerisque nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Integer dignissim risus non nibh scelerisque, sit amet tincidunt sapien rutrum.\r\n\r\nPraesent placerat, magna in vehicula vestibulum, felis urna cursus lorem, sed vestibulum quam eros vel libero. Vivamus commodo, odio sed fringilla pretium, sem nulla feugiat odio, in cursus elit dolor et ex.', '683db7cb3e4d2.jpg', '2025-06-02 16:40:11', 7, 10, 'non validé'),
(47, 'Pourquoi le Café Se Marie Bien ?', 'Comprendre pourquoi certains arômes s&#039;accordent est essentiel pour créer des combinaisons réussies. Le café est une boisson complexe, contenant des centaines de composés aromatiques. Ces composés interagissent avec ceux d&#039;autres aliments et boissons, créant de nouvelles saveurs ou en amplifiant d&#039;autres.\r\nLa chimie des saveurs du café : Pourquoi le café se marie bien avec le chocolat, les produits laitiers et les épices ?&quot; (Vous pouvez trouver des articles scientifiques sur ce sujet sur des bases de données comme PubMed ou Google Scholar en cherchant des mots-clés comme &quot;coffee flavor chemistry&quot; ou &quot;food pairing coffee&quot;). Cet article devrait explorer les profils aromatiques du café et comment ils interagissent avec d&#039;autres profils.', '683ead6d8f3cd.jpg', '2025-06-03 10:08:13', 9, 11, 'validé'),
(48, 'Café et Épices', 'Cannelle, cardamome, noix de muscade, anis étoilé... Les épices peuvent ajouter une dimension aromatique complexe et chaleureuse au café.\r\n\r\n\r\nOsez l&#039;Originalité : Des Combinaisons de Café Surprenantes à Essayer Absolument&quot; (Recherchez des articles de blogs de baristas, des sites dédiés aux cocktails et des magazines culinaires innovants. Des mots-clés comme &quot;unusual coffee pairings&quot; ou &quot;gourmet coffee recipes&quot; devraient vous donner des résultats).', '683eae08dac3b.jpg', '2025-06-03 10:10:48', 9, 15, 'validé'),
(49, 'Café et Boissons Alcoolisées', 'Pour les amateurs de découvertes, le café offre une toile de fond pour des expériences culinaires audacieuses.\r\nDu café irlandais classique au café infusé avec du rhum ou du brandy, ces combinaisons sont parfaites pour des moments de détente et des occasions spéciales.', '683eb27253c03.jpg', '2025-06-03 10:29:38', 10, 15, 'validé'),
(50, 'L&#039;Art de l&#039;Accord : Choisir le Bon Café pour Sa Viennoiserie', 'Accords Gourmands : Quel Café Choisir pour sublimer votre Croissant, Pain au Chocolat ou Chausson aux Pommes ?&quot; (Cherchez des articles de blogs de torréfacteurs, de baristas ou de sites spécialisés dans le café qui proposent des guides d&#039;accords. Des mots-clés comme &quot;coffee croissant pairing&quot;, &quot;best coffee for pastries&quot; ou &quot;accords café viennoiseries&quot; devraient vous donner des résultats pertinents.) Cet article pourrait explorer :\r\nPour un croissant nature ou un pain au chocolat : Un café doux et équilibré, un latte ou un cappuccino pour adoucir le côté beurré et la légère amertume du chocolat.\r\nPour une viennoiserie plus sucrée (chausson aux pommes, pain aux raisins) : Un café avec une acidité plus marquée, comme un Americano ou un café filtre avec des notes fruitées, pour couper le sucre et apporter de la vivacité.\r\nPour une viennoiserie à la frangipane ou aux amandes : Un café plus corsé, un espresso ou un ristretto, qui pourra tenir tête à la richesse de la frangipane.', '683eb31a6da27.jpg', '2025-06-03 10:32:26', 10, 13, 'validé'),
(51, 'La Viennoiserie Maison et le Café de Spécialité', 'Pour les passionnés de cuisine, l&#039;expérience peut être poussée plus loin en préparant ses propres viennoiseries et en sélectionnant un café de spécialité.\r\nDe la Graine à la Tasse, du Beurre au Feuilletage : Le Guide Ultime pour un Petit-Déjeuner Café-Viennoiserie Maison d&#039;Exception&quot; (Recherchez des blogs culinaires, des sites de recettes de boulangerie, des magazines de cuisine et des ressources sur le café de spécialité. Des mots-clés comme &quot;recette croissant maison&quot;, &quot;faire son pain au chocolat&quot;, &quot;café de spécialité préparation&quot; ou &quot;home barista pastry pairing&quot; seraient utiles.)', '683eb3c11e4a4.jpg', '2025-06-03 10:35:13', 10, 10, 'validé'),
(53, 'La Culture et le Traitement du Café', 'Le Voyage du Grain : De la Plantation à la Graine Verte – Processus de Culture, Récolte et Traitement du Café&quot; (Cherchez des ressources sur l&#039;agriculture du café, les méthodes de récolte et les processus de traitement des cerises de café. Des termes comme &quot;culture du café&quot;, &quot;méthodes de traitement du café&quot;, &quot;café lavé&quot;, &quot;café nature&quot;, ou &quot;café honey&quot; seraient utiles.)', '683ec2fb6c6a1.jpg', '2025-06-03 11:40:11', 1, 10, 'validé');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id_categorie` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_categorie`, `name`, `description`) VALUES
(10, 'Grains de café', 'Découvrez nos cafés en grains soigneusement sélectionnés auprès des meilleurs producteurs. Fraîchement torréfiés pour révéler toutes leurs subtilités, nos grains vous offrent une expérience de dégustation authentique, idéale pour les amateurs qui aiment moudre leur café à la minute.'),
(11, 'Café moulu', 'Notre sélection de cafés moulus est pensée pour s’adapter à toutes vos méthodes de préparation : filtre, expresso, presse française… Chaque mouture est réalisée avec précision pour préserver la fraîcheur, les arômes et la richesse du goût, prêts à être savourés en toute simplicité.'),
(12, 'Capsules compatibles', 'Praticité et qualité ne sont plus incompatibles ! Nos capsules compatibles avec les principales machines du marché contiennent nos meilleurs cafés torréfiés artisanalement. Elles offrent une extraction parfaite pour un café intense, aromatique et responsable.'),
(13, 'Décaféiné', 'Profitez d’un café aux arômes riches et équilibrés, sans la caféine. Notre gamme de cafés décaféinés respecte les grains et conserve toute la profondeur gustative grâce à des méthodes naturelles d’extraction de la caféine, pour un plaisir sans compromis.'),
(15, 'Cafés d’origine unique', 'Explorez le monde tasse après tasse avec nos cafés d’origine unique. Chaque café provient d’une région spécifique et raconte son terroir à travers des notes distinctives : fruitées, florales, épicées ou chocolatées. Une invitation au voyage sensoriel à travers les plantations les plus prestigieuses.');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id_commentaire` int NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_publication` datetime DEFAULT CURRENT_TIMESTAMP,
  `article_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id_commentaire`, `comment`, `date_publication`, `article_id`, `user_id`) VALUES
(1, 'uhfuhghguytrstyuhjljkzpùmgîrzuytcrvf', '2025-05-13 15:39:02', 18, 3),
(2, 'Le café est interculturel et très populaire dans différents pays.', '2025-05-15 09:51:05', 19, 3),
(3, 'jireuifhjfhsgfti- ègy_uhijopkl^m$ùm^lpkojhgfd', '2025-05-15 10:10:09', 18, 3),
(6, 'dfgvbgtoyyyyyyyyyyyyyyyyyyyyyyyyyyyqe&quot;prl^^^gyuiop^yuiop^$\r\nuiop^$', '2025-05-15 10:54:21', 18, 3),
(7, 'rdtfgyuhijkopl^$\r\npoaiyftyaguhjiourzeet', '2025-05-15 10:55:12', 18, 3),
(8, 'Le café en poudre toujours apprécier partout.', '2025-05-16 14:40:06', 18, 1),
(9, 'Le café d&#039;origine arabe a un goût particulière et succulent.', '2025-05-18 12:22:13', 19, 1),
(11, 'Le café noisette est apprécié pour son harmonie gustative et sa capacité à créer des boissons réconfortantes et gourmandes.', '2025-05-23 14:41:18', 24, 2),
(12, 'gfgyerygryruiruirohruàizyà-uoytz', '2025-05-23 15:28:13', 31, 3),
(13, 'Super comparatif. A voir après la dégustation des toutes ces cafés d&#039;origines.', '2025-05-26 10:37:08', 39, 2),
(14, 'Coup de cœur tester les associations de café se révèlent toujours surprenant.', '2025-06-02 11:55:37', 45, 1),
(15, 'Aliquam erat volutpat. Nullam scelerisque auctor libero, id volutpat est dignissim vitae. Aliquam erat volutpat. Integer laoreet, nisi a tincidunt tincidunt, odio nisl commodo libero, id ultricies sapien purus non odio. Phasellus ac ultricies ex, vel scelerisque libero.', '2025-06-02 11:57:38', 44, 1),
(16, 'Coup de cœur. Ce type de café est très réputer pour ses saveur.', '2025-06-03 10:12:21', 41, 9),
(17, 'J&#039;adore cette combinaison. le café est le chocolat ensemble détrônent tout.', '2025-06-03 10:36:47', 42, 10),
(18, 'Très envie de tester pour faire mon propre expérience.', '2025-06-03 10:41:03', 37, 10);

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE `contacts` (
  `id_contact` int NOT NULL,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`id_contact`, `nom`, `email`, `message`) VALUES
(3, 'test-test', 'delphine@gmail.com', 'Vivamus lacinia lacus vel neque egestas, vitae volutpat purus dapibus. Nullam nec ultricies erat. Etiam ac urna metus. Sed cursus libero id ullamcorper interdum. Donec non urna et erat vehicula porttitor. Vivamus a sagittis dolor. Nulla facilisi. Cras euismod orci at felis cursus, vel vulputate sapien suscipit.'),
(4, 'ugeuhurhuhhd', 'test@gmail.com', 'Curabitur at felis non libero suscipit fermentum. Duis volutpat, ante et scelerisque luctus, sem nulla placerat leo, at aliquet libero justo id nulla. Integer at dui nec magna posuere fringilla. Nunc euismod bibendum augue. Cras nec ligula velit. Donec in laoreet leo.'),
(5, 'Dujardin', 'dujardin@gmail.com', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.'),
(6, 'yyigriyyiryfiizeygiyigye', 'hawa.kone@colombbus.org', 'Fusce at nisi arcu. Quisque sed dolor nec dui scelerisque dapibus. Sed at purus at sem aliquet luctus. Sed non massa sit amet sapien porttitor ornare. Vivamus pretium, tortor at tempus ullamcorper, diam ligula lobortis quam, at scelerisque libero lectus ut risus.'),
(8, 'eersrerdt_ruioroiperporioqijrqk', 'test@gmail.com', 'quhuirhyiotjùoyk*^pikpèykoypposyuryttRDEXD');

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id_event` int NOT NULL,
  `titre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_event` datetime NOT NULL,
  `lieu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `nombre_places` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`id_event`, `titre`, `description`, `date_event`, `lieu`, `image`, `prix`, `nombre_places`) VALUES
(3, 'Visite de plantations de café', 'Une visite de plantation de café est une expérience exceptionnelle qui permet aux amateurs de café de découvrir l’origine de votre boisson favorite. Une visite de plantation de café est bien plus qu’une simple découverte agricole : c’est une véritable expérience immersive qui permet de voir chaque étape de la création du café, du grain à la tasse. L’occasion idéale pour échanger avec des producteurs passionnés, explorer des paysages magnifiques et déguster des cafés d’exception.', '2025-06-26 00:00:00', '10 rue des champs', '6819dca2554e2.jpg', 15.00, 9),
(5, 'égustation de café en pleine nature', 'Imaginez-vous installé au cœur d’un paysage apaisant, entouré de verdure et bercé par les bruits de la nature, tout en savourant un café fraîchement préparé. La dégustation de café en plein air est bien plus qu’un simple moment de plaisir : c’est une véritable immersion sensorielle, où chaque arôme prend vie différemment sous l’influence de l’environnement naturel.', '2025-06-19 00:00:00', '84 boulevard des parcs', '681a0b4ba64ca.jpg', 5.00, 10),
(9, 'Café-Rando (Randonnée &amp; Dégustation)', 'Une randonnée douce en nature ponctuée de haltes pour découvrir différents cafés d’origine.\r\nActivités :\r\nDégustations en pleine nature (avec cafetières nomades)\r\n\r\n\r\nDécouverte sensorielle (arômes, bouche, acidité)\r\n\r\n\r\nMini ateliers sur les terroirs du café\r\n', '2025-08-14 00:00:00', 'Sentiers forestiers', '683426c62fd62.jpg', 5.00, 10),
(10, 'Appartement moderne noir', 'Donec et urna vel risus feugiat pharetra. Proin id lacus vitae velit accumsan venenatis. Aenean non mi vel nisi lacinia maximus. Duis efficitur, sapien quis bibendum auctor, lectus risus feugiat sapien, ac pulvinar orci est a arcu. Integer id augue vitae urna tristique tempus.\r\n\r\nPhasellus ac eros at urna condimentum lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed bibendum, sapien a venenatis fermentum, mauris augue cursus turpis, vitae elementum massa orci sit amet massa. In hac habitasse platea dictumst.\r\n\r\nIn hac habitasse platea dictumst. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nam eu nunc non augue tincidunt suscipit. Suspendisse potenti. Aliquam erat volutpat. Integer vel turpis sed purus scelerisque euismod.\r\n\r\nVivamus lacinia lacus vel neque egestas, vitae volutpat purus dapibus. Nullam nec ultricies erat. Etiam ac urna metus. Sed cursus libero id ullamcorper interdum. Donec non urna et erat vehicula porttitor. Vivamus a sagittis dolor. Nulla facilisi. Cras euismod orci at felis cursus, vel vulputate sapien suscipit.\r\n\r\nCurabitur tincidunt, felis a elementum tincidunt, ex felis fermentum dui, eget pulvinar arcu eros eu eros. Vestibulum sollicitudin pretium velit, eget volutpat justo fermentum sit amet. Pellentesque in nulla in nisi dictum interdum.', '2025-07-14 00:00:00', '25 rue du jardin 77652', '684177f902d99.png', 15.00, 10);

-- --------------------------------------------------------

--
-- Structure de la table `favorites`
--

CREATE TABLE `favorites` (
  `id_favorite` int NOT NULL,
  `user` int NOT NULL,
  `article` int NOT NULL,
  `date_added` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `favorites`
--

INSERT INTO `favorites` (`id_favorite`, `user`, `article`, `date_added`) VALUES
(7, 1, 18, '2025-05-23 12:31:05'),
(14, 2, 24, '2025-05-23 14:56:20'),
(30, 2, 39, '2025-05-26 10:37:12'),
(31, 2, 35, '2025-05-26 10:37:27'),
(32, 2, 38, '2025-05-26 10:41:05'),
(33, 3, 9, '2025-05-27 14:10:50'),
(34, 3, 45, '2025-05-27 14:10:58'),
(35, 3, 44, '2025-06-02 11:50:36'),
(36, 3, 41, '2025-06-02 11:50:46'),
(37, 3, 38, '2025-06-02 11:51:11'),
(38, 1, 45, '2025-06-02 11:53:26'),
(39, 1, 44, '2025-06-02 11:53:34'),
(40, 1, 41, '2025-06-02 11:58:01'),
(42, 7, 41, '2025-06-02 16:03:32'),
(45, 7, 42, '2025-06-02 16:06:13'),
(47, 7, 40, '2025-06-02 16:07:25'),
(49, 7, 45, '2025-06-02 16:08:44'),
(50, 7, 44, '2025-06-02 16:09:01'),
(51, 7, 27, '2025-06-02 16:17:57'),
(52, 7, 38, '2025-06-02 16:18:18'),
(53, 7, 35, '2025-06-02 16:18:49'),
(54, 7, 39, '2025-06-02 16:25:54'),
(56, 7, 43, '2025-06-02 16:30:17'),
(57, 7, 37, '2025-06-02 16:30:24'),
(58, 9, 45, '2025-06-03 09:56:49'),
(59, 9, 38, '2025-06-03 09:57:15'),
(60, 9, 41, '2025-06-03 10:11:08'),
(61, 10, 45, '2025-06-03 10:25:51'),
(62, 10, 41, '2025-06-03 10:25:56'),
(63, 10, 44, '2025-06-03 10:25:58'),
(66, 10, 38, '2025-06-03 10:26:27'),
(67, 10, 42, '2025-06-03 10:36:50'),
(68, 10, 37, '2025-06-03 10:40:19'),
(69, 1, 9, '2025-06-03 11:24:54'),
(70, 1, 38, '2025-06-03 11:33:38'),
(71, 1, 19, '2025-06-03 11:33:46'),
(77, 3, 42, '2025-06-05 11:37:22'),
(78, 3, 43, '2025-06-05 11:37:24'),
(79, 3, 40, '2025-06-05 11:37:26'),
(80, 3, 36, '2025-06-05 11:37:33'),
(90, 3, 53, '2025-06-20 14:54:10'),
(91, 3, 49, '2025-06-20 14:54:12');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id_reservation` int NOT NULL,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_reservation` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `user_id`, `event_id`, `nom`, `email`, `date_reservation`) VALUES
(2, 3, 5, 'Martin', 'hgydgt@mail.com', '2025-05-12 14:18:56'),
(9, 1, 3, 'Gomis', 'test@gmail.com', '2025-06-03 11:28:02');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `lastName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `firstName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mdp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `civility` enum('h','f') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `birthday` date NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `zip` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `country` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('ROLE_USER','ROLE_ADMIN') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'ROLE_USER'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `lastName`, `firstName`, `pseudo`, `email`, `mdp`, `civility`, `birthday`, `address`, `zip`, `country`, `role`) VALUES
(1, 'Gomis', 'Luciana', 'Lucia', 'test@gmail.com', '$2y$10$S1mvY84tavhDdDzmLNVNxu18C5lAcl29Kyro3djIjVd/ypsQ9isOu', 'f', '2000-12-04', '14 rue des fleurs', '77123', 'France', 'ROLE_USER'),
(2, 'Dupont', 'Alexandre', 'Alex', 'Alexandre@gmail.com', '$2y$10$9JAZg9BlLdhoX7UrGQ5iJuvBvacWXAf1lptp2upvCej6v/iJE2hHW', 'h', '2000-03-16', '123 rue des parfums', '76345', 'France', 'ROLE_ADMIN'),
(3, 'Mendy', 'Delphine', 'Phina', 'delphine@gmail.com', '$2y$10$lSfDuPxnXGffRaD8A2mh1u/RKFb6WYpMauY8G9SGna9srQmyyxQNC', 'f', '2001-09-11', '87 rue des champs', '78345', 'France', 'ROLE_ADMIN'),
(7, 'Garcia', 'Nicolas', 'Nico', 'Nicolas@gmail.com', '$2y$12$dlER5.8V9AHEZhRWWyXmQePHvlqrE.6Dyv0NWVIfPEorIi9XpGnvi', 'h', '1999-01-26', '01 rue des tabac', '75014', 'France', 'ROLE_USER'),
(8, 'Fall', 'Khadija', 'Khady', 'Khadija@gmail.com', '$2y$12$xVuuMxbnaP9h4Zd9dR3.1.S3Hk523tj3zWRC1qV7e1c45.91hJan2', 'f', '2000-01-20', '09 rue de verdun', '93562', 'France', 'ROLE_ADMIN'),
(9, 'Nihal', 'Fatima', 'Faty', 'fatima@gmail.com', '$2y$12$l5qcKhk6rrBu3J/DdC/5ouWej1r1Jxe0zg.bnoNcrzXzoA.xTkag.', 'f', '2000-01-14', '10 rue des belle fort', '77369', 'France', 'ROLE_USER'),
(10, 'Takashi', 'Yorishuki', 'Yori', 'Yorishuki@gmail.com', '$2y$12$5yprV8aqXXDkD2zc84myE.9gyi9pin9TqjQtFRUJS2m9LChPB3gI2', 'h', '1999-05-13', '89 avenue des rires', '99456', 'Allemagne', 'ROLE_USER');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id_article`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `category_id` (`category_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `id_article` (`article_id`),
  ADD KEY `id_user` (`user_id`);

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id_contact`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id_event`);

--
-- Index pour la table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id_favorite`),
  ADD KEY `user_id` (`user`),
  ADD KEY `article_id` (`article`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `pseudo` (`pseudo`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id_article` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_categorie` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id_commentaire` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id_contact` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id_event` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id_favorite` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id_reservation` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id_categorie`);

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`article`) REFERENCES `articles` (`id_article`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id_event`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
