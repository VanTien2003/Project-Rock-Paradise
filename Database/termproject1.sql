-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 28, 2022 at 02:25 AM
-- Server version: 5.7.25
-- PHP Version: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `termproject1`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `role` varchar(30) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `address` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `code` int(11) NOT NULL DEFAULT '0',
  `status` varchar(20) NOT NULL DEFAULT 'verified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `role`, `fullname`, `email`, `password`, `phone`, `address`, `created_at`, `code`, `status`) VALUES
(1, 'admin', 'Phung Van Tien', 'phungtien07062003@gmail.com', '55dd2c486a15be691eb9f66cd8c43bdf49e80011', '0386875502', 'Ha Noi', '2022-09-11 08:00:04', 0, 'verified'),
(21, 'user', 'Do Van Hao', 'hao.dv.2151@aptechlearning.edu.vn', '8cb2237d0679ca88db6464eac60da96345513964', '0123456789', 'Ha Noi', '2022-09-24 15:58:52', 0, 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand_name`) VALUES
(1, 'Swarovski'),
(2, 'Tiffany'),
(3, 'Pandora'),
(4, 'Saga'),
(5, 'Sokolov'),
(6, 'BvLgari'),
(7, 'Cartier'),
(8, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`) VALUES
(1, 'Pendant '),
(2, 'Necklace'),
(3, 'Bangle'),
(4, 'Rings'),
(5, 'Leather Belt'),
(6, 'Errings'),
(7, 'crown'),
(8, 'keyring'),
(9, 'nhan');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `account_id`, `product_id`, `content`, `created_at`, `status`) VALUES
(1, 21, 6, '', '2022-09-27 13:58:13', 0),
(2, 21, 1, 'comment1', '2022-09-27 13:58:36', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `phone`, `email`, `subject`, `message`) VALUES
(1, 'Tien', '0386875502', 'phungtien07062003@gmail.com', 'information', 'Please contact with me , I need more information about page web');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `product_id`, `image`) VALUES
(1, 1, 'uploads/Sunshine-ring-1.jpg'),
(2, 1, 'uploads/Sunshine-ring-2.jpg'),
(3, 2, 'uploads/Constella-cocktail-ring-1.jpg'),
(4, 2, 'uploads/Constella-cocktail-ring-2.jpg'),
(5, 2, 'uploads/Constella-cocktail-ring-3.jpg'),
(6, 2, 'uploads/Constella-cocktail-ring-4.jpg'),
(8, 4, 'uploads/White-gold-pendant-with-diamond-1.jpg'),
(9, 4, 'uploads/White-gold-pendant-with-diamond-2.jpg'),
(10, 4, 'uploads/White-gold-pendant-with-diamond-3.jpg'),
(11, 4, 'uploads/White-gold-pendant-with-diamond-4.jpg'),
(12, 5, 'uploads/DIVAS-DREAM-EARRINGS-1.jpg'),
(13, 5, 'uploads/DIVAS-DREAM-EARRINGS-2.jpg'),
(14, 5, 'uploads/DIVAS-DREAM-EARRINGS-3.jpg'),
(15, 5, 'uploads/DIVAS-DREAM-EARRINGS-4.jpg'),
(16, 6, 'uploads/Amethyst-Point-Comb-Hairpiece-OOAK-1.jpg'),
(17, 6, 'uploads/Amethyst-Point-Comb-Hairpiece-OOAK-2.jpg'),
(18, 6, 'uploads/Amethyst-Point-Comb-Hairpiece-OOAK-3.jpg'),
(19, 6, 'uploads/Amethyst-Point-Comb-Hairpiece-OOAK-4.jpg'),
(20, 7, 'uploads/Tumbled-Stone-Key-Chain-sets-Assorted-Stones-with-silver-tone-keyring-Pack-of-10-1.jpg'),
(21, 7, 'uploads/Tumbled-Stone-Key-Chain-sets-Assorted-Stones-with-silver-tone-keyring-Pack-of-11-2.jpg'),
(22, 7, 'uploads/Tumbled-Stone-Key-Chain-sets-Assorted-Stones-with-silver-tone-keyring-Pack-of-12-3.jpg'),
(23, 7, 'uploads/Tumbled-Stone-Key-Chain-sets-Assorted-Stones-with-silver-tone-keyring-Pack-of-13-4.jpg'),
(24, 7, 'uploads/Tumbled-Stone-Key-Chain-sets-Assorted-Stones-with-silver-tone-keyring-Pack-of-14-5.jpg'),
(25, 8, 'uploads/Crystal-Quartz-Pendant-on-Tiger-Eye-Crystal-Quartz-Mala-beads-1.jpg'),
(26, 8, 'uploads/Crystal-Quartz-Pendant-on-Tiger-Eye-Crystal-Quartz-Mala-beads-2.jpg'),
(27, 8, 'uploads/Crystal-Quartz-Pendant-on-Tiger-Eye-Crystal-Quartz-Mala-beads-3.jpg'),
(28, 8, 'uploads/Crystal-Quartz-Pendant-on-Tiger-Eye-Crystal-Quartz-Mala-beads-4.jpg'),
(29, 9, 'uploads/Crown-Gold-and-Silver-Crowns-with-5-or-7-Stone-Accents-Princess-DOOAK-S26BOX-1.jpg'),
(30, 9, 'uploads/Crown-Gold-and-Silver-Crowns-with-5-or-7-Stone-Accents-Princess-DOOAK-S26BOX-2.jpg'),
(31, 9, 'uploads/Crown-Gold-and-Silver-Crowns-with-5-or-7-Stone-Accents-Princess-DOOAK-S26BOX-3.jpg'),
(32, 9, 'uploads/Crown-Gold-and-Silver-Crowns-with-5-or-7-Stone-Accents-Princess-DOOAK-S26BOX-4.jpg'),
(33, 10, 'uploads/Lapis-and-Crystal-Quartz-layered-Necklace-1.jpg'),
(34, 10, 'uploads/Lapis-and-Crystal-Quartz-layered-Necklace-2.jpg'),
(35, 10, 'uploads/Lapis-and-Crystal-Quartz-layered-Necklace-3.jpg'),
(36, 10, 'uploads/Lapis-and-Crystal-Quartz-layered-Necklace-4.jpg'),
(37, 10, 'uploads/Lapis-and-Crystal-Quartz-layered-Necklace-5.jpg'),
(38, 11, 'uploads/Labradorite-Pendant-Necklace-OOAK-1.jpg'),
(39, 11, 'uploads/Labradorite-Pendant-Necklace-OOAK-2.jpg'),
(40, 11, 'uploads/Labradorite-Pendant-Necklace-OOAK-3.jpg'),
(41, 11, 'uploads/Labradorite-Pendant-Necklace-OOAK-4.jpg'),
(42, 11, 'uploads/Labradorite-Pendant-Necklace-OOAK-5.jpg'),
(43, 12, 'uploads/Drilled-AGATE-SLICES-BY-COLOR-Art-Projects-Supplies-Brazilian-Agate-Pendant-Size-0-Black2.jpg'),
(44, 12, 'uploads/Drilled-AGATE-SLICES-BY-COLOR-Art-Projects-Supplies-Brazilian-Agate-Pendant-Size-0-Blue.jpg'),
(45, 12, 'uploads/Drilled-AGATE-SLICES-BY-COLOR-Art-Projects-Supplies-Brazilian-Agate-Pendant-Size-0-Green.jpg'),
(46, 12, 'uploads/Drilled-AGATE-SLICES-BY-COLOR-Art-Projects-Supplies-Brazilian-Agate-Pendant-Size-0-Natural.jpg'),
(47, 13, 'uploads/Palm-Stones-Pocket-Stones-with-Moon-Phase-2Brownshelf-Black.jpg'),
(48, 13, 'uploads/Palm-Stones-Pocket-Stones-with-Moon-Phase-2Brownshelf-White.jpg'),
(49, 13, 'uploads/Palm-Stones-Pocket-Stones-with-Moon-Phase-2Brownshelf-Green.jpg'),
(50, 13, 'uploads/Palm-Stones-Pocket-Stones-with-Moon-Phase-2Brownshelf-Rose.jpg'),
(51, 14, 'uploads/Natural-Stone-Place-Card-Holder-Small-Picture-Stand-WRHS2-3000-Placecard-Rose.jpg'),
(52, 14, 'uploads/Natural-Stone-Place-Card-Holder-Small-Picture-Stand-WRHS2-3000-Placecard-White.jpg'),
(53, 14, 'uploads/Natural-Stone-Place-Card-Holder-Small-Picture-Stand-WRHS2-3000-Placecard-Black.jpg'),
(54, 14, 'uploads/Natural-Stone-Place-Card-Holder-Small-Picture-Stand-WRHS2-3000-Placecard-Green.jpg'),
(55, 15, 'uploads/Agate-Lamp-Agate-Geode-Cut-Base-Light-Assorted-Colors-With-USB-Cord-HW1-Blue.jpg'),
(56, 15, 'uploads/Agate-Lamp-Agate-Geode-Cut-Base-Light-Assorted-Colors-With-USB-Cord-HW1-Pink.jpg'),
(57, 15, 'uploads/Agate-Lamp-Agate-Geode-Cut-Base-Light-Assorted-Colors-With-USB-Cord-HW1-Purple.jpg'),
(58, 15, 'uploads/Agate-Lamp-Agate-Geode-Cut-Base-Light-Assorted-Colors-With-USB-Cord-HW1-natural.jpg'),
(59, 16, 'uploads/Agate-Coasters-3-to-5.5-Mixed-Colors-Sets-or-Singles-Pink.jpg'),
(60, 16, 'uploads/Agate-Coasters-3-to-5.5-Mixed-Colors-Sets-or-Singles-Blue.jpg'),
(61, 16, 'uploads/Agate-Coasters-3-to-5.5-Mixed-Colors-Sets-or-Singles-Natural.jpg'),
(62, 17, 'uploads/Drilled-Half-Moon-Agate-Wire-Wrapping-Crystal-Healing-Pendant-settings-Crescent-shape-RK21B26-B27-Pink.jpg'),
(63, 17, 'uploads/Drilled-Half-Moon-Agate-Wire-Wrapping-Crystal-Healing-Pendant-settings-Crescent-shape-RK21B26-B27-Green.jpg'),
(64, 17, 'uploads/Drilled-Half-Moon-Agate-Wire-Wrapping-Crystal-Healing-Pendant-settings-Crescent-shape-RK21B26-B27-Blue.jpg'),
(65, 17, 'uploads/Drilled-Half-Moon-Agate-Wire-Wrapping-Crystal-Healing-Pendant-settings-Crescent-shape-RK21B26-B27-Orange.jpg'),
(66, 18, 'uploads/Rough-Stone-Pendants-Rose-Quartz-Citrine-Amethyst-Sodalite-Tourmaline-11BROWNSHELF-Rose.jpg'),
(67, 18, 'uploads/Rough-Stone-Pendants-Rose-Quartz-Citrine-Amethyst-Sodalite-Tourmaline-11BROWNSHELF-white.jpg'),
(68, 18, 'uploads/Rough-Stone-Pendants-Rose-Quartz-Citrine-Amethyst-Sodalite-Tourmaline-11BROWNSHELF-Orange.jpg'),
(69, 19, 'uploads/Drilled-AGATE-SLICES-BY-COLOR-Art-Projects-Supplies-Brazilian-Agate-Pendant-Size-0-Blue2.jpg'),
(70, 19, 'uploads/Drilled-AGATE-SLICES-BY-COLOR-Art-Projects-Supplies-Brazilian-Agate-Pendant-Size-0-Green2.jpg'),
(71, 19, 'uploads/Drilled-AGATE-SLICES-BY-COLOR-Art-Projects-Supplies-Brazilian-Agate-Pendant-Size-0-Natural2.jpg'),
(72, 19, 'uploads/Drilled-AGATE-SLICES-BY-COLOR-Art-Projects-Supplies-Brazilian-Agate-Pendant-Size-0-Orange2.jpg'),
(73, 20, 'uploads/Stone-Pendulum-Point-Metaphysical-RK22-Blue.jpg'),
(74, 20, 'uploads/Stone-Pendulum-Point-Metaphysical-RK22-Green.jpg'),
(75, 20, 'uploads/Stone-Pendulum-Point-Metaphysical-RK22-Natural.jpg'),
(76, 22, 'uploads/Stone-Tree-on-Amethyst-Base-Home-Decor-CHOOSE-your-Crystal-HW-Black.jpg'),
(77, 22, 'uploads/Stone-Tree-on-Amethyst-Base-Home-Decor-CHOOSE-your-Crystal-HW-Orange.jpg'),
(78, 22, 'uploads/Stone-Tree-on-Amethyst-Base-Home-Decor-CHOOSE-your-Crystal-HW-Violet.jpg'),
(79, 22, 'uploads/Stone-Tree-on-Amethyst-Base-Home-Decor-CHOOSE-your-Crystal-HW-White.jpg'),
(80, 23, 'uploads/Gemstone-Soap-Dispenser-Rose.jpg'),
(81, 23, 'uploads/Gemstone-Soap-Dispenser-White.jpg'),
(82, 23, 'uploads/Gemstone-Soap-Dispenser-Green.jpg'),
(83, 23, 'uploads/Gemstone-Soap-Dispenser-Violet.jpg'),
(84, 24, 'uploads/Agate-Rings-Colorful-Dyed-Agate-Ad.jpg'),
(85, 24, 'uploads/Agate-Rings-Colorful-Dyed-Agate-Adjustable-Rings-Pink.jpg'),
(86, 24, 'uploads/Agate-Rings-Colorful-Dyed-Agate-Adjustable-Rings-Purple.jpg'),
(87, 25, 'uploads/Stone-Bracelet-YOU-CHOOSE-Electroplated-Silver-or-Gold-Cuff-Marquise-Cut-Gray.jpg'),
(88, 25, 'uploads/Stone-Bracelet-YOU-CHOOSE-Electroplated-Silver-or-Gold-Cuff-Marquise-Cut-Natural.jpg'),
(89, 25, 'uploads/Stone-Bracelet-YOU-CHOOSE-Electroplated-Silver-or-Gold-Cuff-Marquise-Cut-Rose.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `gemstone`
--

CREATE TABLE `gemstone` (
  `id` int(11) NOT NULL,
  `gemstone_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gemstone`
--

INSERT INTO `gemstone` (`id`, `gemstone_name`) VALUES
(1, 'Rhodium plated'),
(2, 'aventurine '),
(3, 'Diamond'),
(4, 'Amethyst'),
(5, 'Crystal Quartz'),
(6, 'Rose Quartz'),
(7, 'Lapis'),
(8, 'Labradorite');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `price`, `quantity`) VALUES
(1, 6, 1, 50, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_method`
--

CREATE TABLE `order_method` (
  `id` int(11) NOT NULL,
  `orderName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_method`
--

INSERT INTO `order_method` (`id`, `orderName`) VALUES
(1, 'Payment to the shipper'),
(2, 'Payment at the store'),
(3, 'Banking '),
(4, 'Paypal');

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE `price` (
  `id` int(11) NOT NULL,
  `rangePrice` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `price`
--

INSERT INTO `price` (`id`, `rangePrice`) VALUES
(1, '0-2 $'),
(2, '2-5 $'),
(3, '5-10 $'),
(4, '10-20 $'),
(5, 'over 20 $');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `sold` varchar(30) DEFAULT NULL,
  `sale` varchar(100) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `gemstone_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `avatar`, `name`, `description`, `price`, `sold`, `sale`, `category_id`, `brand_id`, `gemstone_id`) VALUES
(1, 'uploads/sunshine-ring--pink--rhodium-plated-swarovski-5642966.png', 'Sunshine ring', 'Radiating warmth and light, this Sunshine ring features an exquisite clear stone surrounded by rays of pink stones finished with a rhodium plated setting. It’s sure to put a spring in your step.\r\n', 50, '55', '5%', 4, 1, 1),
(2, 'uploads/constella-cocktail-ring--princess-cut--white--rhodium-plated-swarovski-5638529.png', 'Constella cocktail ring', 'Shining like the first star in the sky at night, this Constella ring is set to become your new favorite. An elegant princess-cut stone in a double-prong setting is enhanced with a pavé gallery and sits on sleek rhodium plated band. Wear solo or stack wit', 35, '85', '10%', 4, 1, 1),
(4, 'uploads/04AF3460E010416DA17561B094BB.jpg', 'White gold pendant with diamond ', 'Material White gold 585 Approximate weight 0.31 Insert Diamond (1 piece, 0.132 carats) The actual characteristics of the product may differ slightly from those presented on the website', 22, '67', '20%', 1, 5, 3),
(5, 'uploads/1360054.png', 'DIVAS DREAM EARRINGS', 'Inspired by feminine elegance, their refined fan-shaped motif is portrayed through malachite inserts framed by pavé diamonds: an unmistakable signature conjuring the sensual pattern of Rome’s Caracalla mosaics and a tribute to Italian beauty. The DIVAS\' D', 32, '55', '20%', 6, 6, 3),
(6, 'uploads/IMG_E8773_900x.png', 'Amethyst Point Comb Hairpiece - OOAK', 'This listing is for ONE (1) Amethyst Point Comb Hairpiece (UOOAK-S4-212).\r\n\r\nThis is a ONE OF A KIND item. You will receive this exact Amethyst Point Comb Hairpiece as pictured. \r\n\r\nThis is a stunning piece to add to your collection! It features five Amet', 21, '110', '5%', 7, 8, 4),
(7, 'uploads/tumbled-crystal-quartz-silver-toned-key-chain-natural-crystal-quartz-stone-keychain-rk45b2b-01-1_900x_371860d4-d54a-46aa-bcdf-aa67010167a8_900x.png', 'Tumbled Stone Key Chain sets', 'Listing is for ONE (1) Set of 10 pack of assorted Tumbled Stone Key Chains with silver tone keyring\r\n\r\nSold in Sets of 10 assorted stones. Stones can include: rose quartz, amethyst, crystal quartz, smoky quartz, citrine, tiger eye\r\n\r\nSTOCK PHOTOS. EACH KE', 45, '98', NULL, 8, 8, 4),
(8, 'uploads/IMG_E6303_55047c3d-3eea-4d0e-86fa-51286acaebe2_900x.png', 'Crystal Quartz Pendant on Tiger Eye', 'This Listing is for 1 (ONE) Crystal Quartz Pendant on Tiger Eye /Crystal Quartz Mala beads.\r\n\r\nThis a beautiful combination of Tiger Eye and Crystal Quartz Mala beds with gold. \r\nIt comes with a small Crystal Quartz Pendant with gold. A elegant neck to we', 32, '78', NULL, 1, 8, 5),
(9, 'uploads/crown-princess-crown-gold-and-silver-crowns-with-5-or-7-stone-accents-22_900x.png', 'Crown Gold and Silver Crowns', 'This listing is for ONE (1) crown gold or silver with 5 or 7 stone accents.  (DOOAK-S26BOX)\r\n\r\nSTOCK PHOTO. Each stone will vary slightly in size and characteristics. \r\n\r\n5 piece crown measures approx. : 4.25\"\" x 3.25 x 1.75\"\"\r\n\r\n7 piece crown measures ap', 18, '66', NULL, 7, 8, 6),
(10, 'uploads/IMG_7152_900x.png', 'Lapis and Crystal Quartz layered Necklace', 'This is a STOCK PHOTO. Each item will vary slightly in size, color, and characteristics. \r\n\r\n* necklace length has been shortened in some imaged to fit on bust display\r\n\r\nThis Three Tier Stone Pendant Necklace is the statement piece for you! Complete any ', 32, '90', NULL, 2, 8, 7),
(11, 'uploads/IMG_7098_900x.png', 'Labradorite Pendant Necklace - OOAK', 'This is a ONE OF A KIND item. You will receive this exact Labradorite Pendant Necklace as pictured.\r\n\r\nThis beautiful Labradorite Pendant Necklace is the perfect piece for you! Complete any outfit by adding the properties of labradorite with this necklace', 25, '99', NULL, 1, 8, 8),
(12, 'uploads/Drilled-AGATE-SLICES-BY-COLOR-Art-Projects-Supplies-Brazilian-Agate-Pendant-Size-0.jpg', 'Drilled AGATE SLICES', 'Drilled agate slice from Brazil.BUY IN BULK AND SAVE!If you need large quantity, message us for wholesale pricing. We can provide agates in all sizes and colors in large volume.', 22, '95', '15%', 1, 8, 8),
(13, 'uploads/Palm-Stones-Pocket-Stones-with-Moon-Phase-2Brownshelf.jpg', 'Palm Stones Pocket Stones with Moon Phase', 'This listing is for ONE Palm Stones with Engraved Moon Phases STOCK PHOTO. These palm stones may vary slightly in size and characteristics due to them being natural.These are great little stones to keep in your pocket, meditation space, gifting to so', 15, '69', '10%', 7, 8, 2),
(14, 'uploads/Natural-Stone-Place-Card-Holder-Small-Picture-Stand-WRHS2-3000-Placecard.jpg', 'Natural Stone Place Card Holder', 'You will receive One Natural Stone Business Card Holder - Rough Chunks YOU CHOOSE the Stone STOCK PHOTO. Each piece will vary slightly in size and in characteristics.See photos for varying shapes and photos with hands for sizing.', 15, '27', NULL, 6, 8, 8),
(15, 'uploads/Agate-Lamp-Agate-Geode-Cut-Base-Light-Assorted-Colors-With-USB-Cord-HW1.jpg', 'Agate Lamp - Agate Geode Cut Base Light', 'This listing is for ONE (1) Agate Lamp - Agate Geode Cut Base Light - Assorted Colors - Dyed Agates Amazing Dyed Agate Cut Base stones that stands over a tealight to create a glowing light of awesome wonders of nature. Perfect for your Home or spe', 68, '23', NULL, 2, 8, 6),
(16, 'uploads/Agate-Coasters-3-to-5.5-Mixed-Colors-Sets-or-Singles.jpg', 'Agate Coasters - Mixed Colors Sets', 'Mixed Color Coaster Sets or Singles Buy in Bulk and Save! Select the quantity you would like to receive. Each agate will vary slightly in size and characteristics and overall characteristics.Druzy crystals in the open center, great light ca', 14, '85', '10%', 3, 7, 7),
(17, 'uploads/Drilled-Half-Moon-Agate-Wire-Wrapping-Crystal-Healing-Pendant-settings-Crescent-shape-RK21B26-B27.jpg', 'Drilled Half Moon Agate', 'This Listing is for ONE (1) Drilled Half Moon Shaped Agate. Each agate will vary slightly in size and characteristics.Each agate measures approx. 40mm x 15-16mm\nIdeal to get creative and make wire-wrapping, pendants, etc.', 35, '48', '10%', 1, 8, 7),
(18, 'uploads/Rough-Stone-Pendants-Rose-Quartz-Citrine-Amethyst-Sodalite-Tourmaline-11BROWNSHELF.jpg', 'Rough Stone Pendants', 'Rough Stone Pendants - Natural Raw Beauties! You Choose Stone: Rose Quartz, Citrine(heat treated) Amethyst, Rose Quartz, Sodalite, Tourmaline, Rutilated Quartz You Choose Bail - Gold or Silver. Each s', 35, '94', NULL, 1, 8, 6),
(19, 'uploads/Drilled-AGATE-SLICES-BY-COLOR-Art-Projects-Supplies-Brazilian-Agate-Pendant-Size-0.jpg', 'Drilled AGATE SLICES', 'Drilled agate slice from Brazil!!! Select 6, 12, 24 or 48 pieces. BUY IN BULK AND SAVE!!! If you need large quantity, message us for wholesale pricing. We can provide agates in all sizes and colors in large volume. ', 29, '63', NULL, 1, 8, 7),
(20, 'uploads/Stone-Pendulum-Point-Metaphysical-RK22.jpg', 'Stone Pendulum Point - Metaphysical', 'Amazing points, grab them while they last!. Each stone will vary slightly in size and characteristics. Please note some may have a hole on top.\nThe measurement of these points is approx.: 38-45mm x 17-21mm .These points may have slight i', 32, '88', '5%', 2, 6, 6),
(22, 'uploads/Stone-Tree-on-Amethyst-Base-Home-Decor-CHOOSE-your-Crystal-HW.jpg', 'Stone Tree on Amethyst Base', 'Listing is for ONE (1) Stone Tree on Amethyst Base - Home Decor - CHOOSE your Crystal (HW)STOCK PHOTO. These trees will vary in size and characteristics. YOU CHOOSE Crystal Stone: Amethyst PointCitrine Point (heat treated)Crystal Quartz PointBlack Tourm', 32, '95', NULL, 1, 2, 4),
(23, 'uploads/Gemstone-Soap-Dispenser.jpg', 'Gemstone Soap Dispenser', 'Our gemstone soap dispensers are handcrafted by crystal artisans using natural stone. Take your home decor to the next level and impress any visitors with these dazzling pieces which perfectly blend form and function. They can be used with soap, lotion or', 68, '79', NULL, 2, 5, 7),
(24, 'uploads/Agate-Rings-Colorful-Dyed-Agate-Adjustable-Rings.jpg', 'Agate Rings - Colorful Dyed Agate Adjustable Rings', 'This listing is for ONE (1) Colored Agate Druzy Gold Adjustable Ring (UP5-12).This is a STOCK PHOTO. Each item will vary slightly in size, color, and characteristics. These Colored Agate Druzy Gold Adjustable Rings would make a great addition to your col', 48, '27', NULL, 4, 6, 5),
(25, 'uploads/Stone-Bracelet-YOU-CHOOSE-Electroplated-Silver-or-Gold-Cuff-Marquise-Cut.jpg', 'Stone Bracelet - Electroplated Silver', 'This listing is for ONE (1) Stone Bracelet - Electroplated Silver or Gold Cuff - Marquise Cut - Polished stones in a Marquise Cut. Each stone is from nature and will vary slightly in characteristics.', 30, '28', NULL, 6, 8, 8);

-- --------------------------------------------------------

--
-- Table structure for table `product_order`
--

CREATE TABLE `product_order` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `orderMethod_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 : no process; 2 : processing; 3: processed; 4: cancel'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_order`
--

INSERT INTO `product_order` (`id`, `account_id`, `orderMethod_id`, `order_date`, `status`) VALUES
(1, 21, 2, '2022-09-26 15:29:31', 1),
(2, 21, 2, '2022-09-26 15:29:51', 1),
(3, 21, 1, '2022-09-27 13:55:54', 1),
(4, 21, 1, '2022-09-27 13:56:16', 1),
(5, 21, 1, '2022-09-27 13:56:59', 1),
(6, 21, 1, '2022-09-27 14:05:57', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `gemstone`
--
ALTER TABLE `gemstone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_method`
--
ALTER TABLE `order_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `gemstone_id` (`gemstone_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_order`
--
ALTER TABLE `product_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `gemstone`
--
ALTER TABLE `gemstone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_method`
--
ALTER TABLE `order_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `price`
--
ALTER TABLE `price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `product_order`
--
ALTER TABLE `product_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `product_order` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`gemstone_id`) REFERENCES `gemstone` (`id`),
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `product_order`
--
ALTER TABLE `product_order`
  ADD CONSTRAINT `product_order_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
