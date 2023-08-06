-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-08-2023 a las 00:18:38
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sonicwaves`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `album`
--

CREATE TABLE `album` (
  `id` int(4) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `foto` varchar(500) NOT NULL,
  `activo` tinyint(1) DEFAULT NULL CHECK (`activo` >= 0 and `activo` <= 1),
  `grupo` int(4) DEFAULT NULL,
  `lanzamiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `album`
--

INSERT INTO `album` (`id`, `titulo`, `foto`, `activo`, `grupo`, `lanzamiento`) VALUES
(22, 'Master Of Puppets', '../media/img_grupos/met@gm.com/master of puppets.jpg', 1, 7, '1986-02-13'),
(24, '...And Justice for All', '../media/img_grupos/met@gm.com/and justice for all.jpg', 1, 7, '1988-09-07'),
(29, 'The Works Singles', '../media/img_grupos/Queen_12/the works singles.jpg', 1, 12, '2023-04-01'),
(30, 'Closure / Continuation', '../media/img_grupos/Porcupine Tree_11/closurecontinuation.jpg', 1, 11, '2022-06-03'),
(31, 'Selling England by the Pound', '../media/img_grupos/genesis@genesis.com/selling england by the pound.jpg', 1, 13, '1974-07-19'),
(36, 'Swagger and Stroll Down the Rabbit Hole', '../media/img_grupos/dso@gmail.com/swagger and stroll down the rabbit hole.jpg', 1, 21, '2023-05-04'),
(39, 'Wish You Were Here', '../media/img_grupos/pinkfloyd@gmail.com/wish you were here.jpg', 1, 19, '1975-09-12'),
(42, 'Abbey Road', '../media/img_grupos/The Beatles_22/abbey road.jpg', 1, 22, '1969-06-19'),
(44, 'Will Of The People', '../media/img_grupos/Muse_15/will of the people.jpg', 1, 15, '2022-06-16'),
(49, '72 Seasons', '../media/img_grupos/meta@gm.com/72 seasons.jpg', 1, 7, '2023-04-21'),
(50, 'Pacifisticuffs', '../media/img_grupos/dso@gmail.com/pacifisticuffs.webp', 1, 21, '2017-07-06'),
(54, 'Goodbye Yellow Brick Road', '../media/img_grupos/Elton John_20/goodbye yellow brick road.jpg', 1, 20, '1973-10-05'),
(55, 'Let It Be', '../media/img_grupos/The Beatles_22/let it be.jpg', 1, 22, '1970-05-08'),
(60, 'Revolver', '../media/img_grupos/The Beatles_22/revolver.jpg', 1, 22, '1966-08-05'),
(61, 'Wasting Light', '../media/img_grupos/Foo Fighters_23/wasting light.jpg', 1, 23, '2011-05-12'),
(62, 'I\'m With You', '../media/img_grupos/Red Hot Chili Peppers_24/im with you.jpg', 1, 24, '2011-08-26'),
(65, 'Stadium Arcadium', '../media/img_grupos/Red Hot Chili Peppers_24/stadium arcadium.webp', 1, 24, '2006-05-09'),
(66, 'OK Computer', '../media/img_grupos/radiohead@gmail.com/ok computer.jpg', 1, 25, '1997-05-21'),
(67, 'Beyond Magnetic: Greatest Hits', '../media/img_grupos/Metallica_7/beyondmagneticgreatesthits.webp', 1, 7, '2010-04-12'),
(68, 'Multipolar', '../media/img_grupos/lasudadera@gmail.com/multipolar.jpg', 1, 17, '2019-11-15'),
(69, 'Life Is But A Dream...', '../media/img_grupos/Avenged Sevenfold_29/life is but a dream.jpg', 1, 29, '2023-06-02'),
(70, 'The Stage (Deluxe Edition)', '../media/img_grupos/Avenged Sevenfold_29/the stage (deluxe edition).jpg', 1, 29, '2016-10-28'),
(71, 'Face Value', '../media/img_grupos/Phil Collins_30/face value.jpg', 1, 30, '1981-02-13'),
(103, 'The Last Of Us', '../media/img_grupos/Gustavo Santaolalla_31/the last of us original soundtrack.jpg', 1, 31, '2013-07-17'),
(104, 'Hello, I Must Be Going!', '../media/img_grupos/Phil Collins_30/hello, i must be going!.jpg', 1, 30, '1982-11-05'),
(105, 'Absolution', '../media/img_grupos/Muse_15/absolution.png', 1, 15, '2003-09-29'),
(106, 'Rize Of The Fenix', '../media/img_grupos/tenaciousd@gmail.com/rize of the fenix.jpg', 1, 32, '2012-05-15'),
(108, 'The Pick Of Destiny', '../media/img_grupos/tenaciousd@gmail.com/the pick of destiny.jpg', 1, 32, '2006-11-14'),
(111, 'Sonic Highways', '../media/img_grupos/Foo Fighters_23/sonic highways.jpg', 1, 23, '2014-11-10'),
(112, 'Use Your Illusion I', '../media/img_grupos/Guns N Roses_36/use your illusion i.jpg', 1, 36, '1991-09-17'),
(113, 'Use Your Illusion II', '../media/img_grupos/Guns N Roses_36/use your illusion ii.jpg', 1, 36, '1991-09-17'),
(114, 'La La Land (Original Motion Picture Soundtrack)', '../media/img_grupos/Justin Hurwitz_37/la la land (original motion picture soundtrack).jpg', 1, 37, '2017-01-13'),
(115, 'Babylon (Music From the Motion Picture)', '../media/img_grupos/Justin Hurwitz_37/babylon (music from the motion picture).jpg', 1, 37, '2023-01-13'),
(116, 'Whiplash (Original Motion Picture Soundtrack)', '../media/img_grupos/Justin Hurwitz_37/whiplash (original motion picture soundtrack).jpg', 1, 37, '2014-01-16'),
(117, 'Moving Pictures 40th Anniversary', '../media/img_grupos/Rush_27/moving pictures 40th anniversary.jpg', 1, 27, '1981-02-12'),
(118, 'Invisible Touch', '../media/img_grupos/genesis@genesis.com/invisible touch.jpg', 1, 13, '1986-06-06'),
(119, 'Octavarium', '../media/img_grupos/dreamt@gmail.com/octavarium.webp', 1, 38, '2005-06-07'),
(124, 'The Miracle', '../media/img_grupos/Queen_12/the miracle.jpg', 1, 12, '1989-05-22'),
(125, 'A Night At The Opera', '../media/img_grupos/Queen_12/a night at the opera.jpg', 1, 12, '1975-11-21'),
(126, 'Wicked Game (Single)', '../media/img_grupos/tenaciousd@gmail.com/wicked game (single).jpg', 1, 32, '2023-06-08'),
(127, 'Greatest Hits', '../media/img_grupos/Queen_12/greatest hits.jpg', 1, 12, '1979-05-12'),
(133, 'Outer Wilds OST', '../media/img_grupos/Justin Hurwitz_37/outer wilds ost.jpg', 1, 37, '2011-05-05'),
(134, 'Rabbit Craziness: Greatest Hits', '../media/img_grupos/dso@gmail.com/rabbit craziness greatest hits.png', 1, 21, '2222-12-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cancion`
--

CREATE TABLE `cancion` (
  `id` int(4) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `duracion` char(5) DEFAULT NULL,
  `archivo` varchar(500) NOT NULL,
  `estilo` int(2) DEFAULT NULL,
  `times_played` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cancion`
--

INSERT INTO `cancion` (`id`, `titulo`, `duracion`, `archivo`, `estilo`, `times_played`) VALUES
(33, 'Battery', '05:12', '../media/audio/met@gm.com/master of puppets/battery.mp3', 2, 0),
(34, 'Master of Puppets', '08:36', '../media/audio/met@gm.com/master of puppets/master of puppets.mp3', 2, 0),
(35, 'The Thing That Should Not Be', '06:36', '../media/audio/met@gm.com/master of puppets/the thing that should not be.mp3', 2, 0),
(36, 'Welcome Home (Sanitarium)', '06:27', '../media/audio/met@gm.com/master of puppets/welcome home sanitarium.mp3', 2, 0),
(37, 'Disposable Heroes', '08:17', '../media/audio/met@gm.com/master of puppets/disposable heroes.mp3', 2, 0),
(38, 'Lepper Mesiah', '05:40', '../media/audio/met@gm.com/master of puppets/lepper messiah.mp3', 2, 0),
(39, 'Orion', '08:27', '../media/audio/met@gm.com/master of puppets/orion.mp3', 2, 0),
(40, 'Damage, Inc.', '05:33', '../media/audio/met@gm.com/master of puppets/damage inc.mp3', 2, 0),
(50, 'Blackened', '06:41', '../media/audio/met@gm.com/and justice for all/blackened.mp3', 9, 0),
(51, '...And Justice for All', '09:47', '../media/audio/met@gm.com/and justice for all/andjusticeforall.mp3', 9, 0),
(52, 'Eye of the Beholder', '06:26', '../media/audio/met@gm.com/and justice for all/eyeofthebeholder.mp3', 9, 0),
(53, 'One', '07:26', '../media/audio/met@gm.com/and justice for all/one.mp3', 9, 0),
(54, 'The Shortest Straw', '06:35', '../media/audio/met@gm.com/and justice for all/theshorteststraw.mp3', 9, 0),
(55, 'Harvester of Sorrow', '05:44', '../media/audio/met@gm.com/and justice for all/harvesterofsorrow.mp3', 9, 0),
(56, 'The Frayed Ends of Sanity', '07:43', '../media/audio/met@gm.com/and justice for all/thefrayedendsofsanity.mp3', 9, 0),
(57, 'To Live is to Die', '09:49', '../media/audio/met@gm.com/and justice for all/toliveistodie.mp3', 9, 0),
(58, 'Dyers Eve', '05:13', '../media/audio/met@gm.com/and justice for all/dyerseve.mp3', 9, 0),
(82, 'Hammer To Fall', '04:26', '../media/audio/Queen_12/the works singles/hammertofall.mp3', 4, 0),
(83, 'Radio Ga Ga', '05:50', '../media/audio/Queen_12/the works singles/radiogaga.mp3', 1, 0),
(84, 'Harridan', '08:08', '../media/audio/Porcupine Tree_11/closurecontinuation/harridan.mp3', 10, 0),
(85, 'Of The New Day', '04:43', '../media/audio/Porcupine Tree_11/closurecontinuation/ofthenewday.mp3', 10, 0),
(86, 'Rats Return', '05:41', '../media/audio/Porcupine Tree_11/closurecontinuation/ratsreturn.mp3', 10, 0),
(87, 'Dignity', '08:23', '../media/audio/Porcupine Tree_11/closurecontinuation/dignity.mp3', 10, 0),
(88, 'Herd Culling', '07:04', '../media/audio/Porcupine Tree_11/closurecontinuation/herdculling.mp3', 10, 0),
(89, 'Walk The Plank', '04:27', '../media/audio/Porcupine Tree_11/closurecontinuation/walktheplank.mp3', 10, 0),
(90, 'Chimera\'s Wreck', '09:41', '../media/audio/Porcupine Tree_11/closurecontinuation/chimeraswreck.mp3', 10, 0),
(91, 'Population Three', '06:52', '../media/audio/Porcupine Tree_11/closurecontinuation/populationthree.mp3', 10, 0),
(92, 'Never Have', '05:09', '../media/audio/Porcupine Tree_11/closurecontinuation/neverhave.mp3', 10, 0),
(93, 'Love In The Past Tense', '05:50', '../media/audio/Porcupine Tree_11/closurecontinuation/loveinthepasttense.mp3', 10, 0),
(94, 'Dancing With the Moonlit Knight', '08:03', '../media/audio/genesis@genesis.com/selling england by the pound/snapsave.io - genesis - dancing with the moonlight knight (official audio) (320 kbps).mp3', 10, 0),
(95, 'I Know What I Like (In Your Wardrobe)', '04:11', '../media/audio/genesis@genesis.com/selling england by the pound/snapsave.io - genesis - i know what i like (in your wardrobe) [official audio] (128 kbps).mp3', 10, 0),
(96, 'Firth of Fifth', '09:35', '../media/audio/genesis@genesis.com/selling england by the pound/snapsave.io - genesis - firth of fifth (official audio) (320 kbps).mp3', 10, 0),
(97, 'More Fool Me', '03:11', '../media/audio/genesis@genesis.com/selling england by the pound/snapsave.io - genesis - more fool me (official audio) (320 kbps).mp3', 10, 0),
(98, 'The Battle of Epping Forest', '11:44', '../media/audio/genesis@genesis.com/selling england by the pound/snapsave.io - genesis - the battle of epping forest (official audio) (192 kbps).mp3', 10, 0),
(99, 'After the Ordeal', '04:15', '../media/audio/genesis@genesis.com/selling england by the pound/snapsave.io - genesis - after the ordeal (official audio) (256 kbps).mp3', 10, 0),
(100, 'The Cinema Show', '10:42', '../media/audio/genesis@genesis.com/selling england by the pound/snapsave.io - genesis - the cinema show (official audio) (192 kbps).mp3', 10, 0),
(101, 'Aisle of Plenty', '01:58', '../media/audio/genesis@genesis.com/selling england by the pound/snapsave.io - genesis - aisle of plenty (official audio) (320 kbps).mp3', 10, 0),
(102, 'Sightseeing in the Apocalypse', '02:17', '../media/audio/dso@gmail.com/swagger and stroll down the rabbit hole/sightseeing.mp3', 3, 0),
(103, 'War Painted Valentine', '04:02', '../media/audio/dso@gmail.com/swagger and stroll down the rabbit hole/warpaintedvalentine.mp3', 3, 0),
(104, 'Celebremos Lo Inevitable', '05:01', '../media/audio/dso@gmail.com/swagger and stroll down the rabbit hole/celebremosloinevitable.mp3', 3, 0),
(105, 'Speed Dating An Arsonist', '05:35', '../media/audio/dso@gmail.com/swagger and stroll down the rabbit hole/speeddatinganarsonist.mp3', 3, 0),
(106, 'Jig Of The Century', '04:34', '../media/audio/dso@gmail.com/swagger and stroll down the rabbit hole/jigofthecentury.mp3', 3, 0),
(107, 'The Sound of an Unconditional Surrender', '05:31', '../media/audio/dso@gmail.com/swagger and stroll down the rabbit hole/thesoundof.mp3', 3, 0),
(108, 'Malign Monologues', '05:01', '../media/audio/dso@gmail.com/swagger and stroll down the rabbit hole/malignmonologues.mp3', 3, 0),
(109, 'Out Came the Hummingbirds', '04:27', '../media/audio/dso@gmail.com/swagger and stroll down the rabbit hole/outcamethe.mp3', 3, 0),
(110, 'Snake Oil Baptism', '04:42', '../media/audio/dso@gmail.com/swagger and stroll down the rabbit hole/snakeoilbaptism.mp3', 3, 0),
(111, 'Les Invulnérables', '06:03', '../media/audio/dso@gmail.com/swagger and stroll down the rabbit hole/lesinvulnerables.mp3', 3, 0),
(112, 'Saluting the Reckoning', '04:53', '../media/audio/dso@gmail.com/swagger and stroll down the rabbit hole/salutingthereckoning.mp3', 3, 0),
(113, 'The Prima Donna Gauntlet', '05:05', '../media/audio/dso@gmail.com/swagger and stroll down the rabbit hole/theprimadonna.mp3', 3, 0),
(114, 'Overture to a Ceasefire', '04:05', '../media/audio/dso@gmail.com/swagger and stroll down the rabbit hole/overturetoaceasefire.mp3', 3, 0),
(121, 'Shine On You Crazy Diamond, Pts I-V', '13:33', '../media/audio/pinkfloyd@gmail.com/wish you were here/shineonyoui.mp3', 10, 0),
(122, 'Welcome To The Machine', '07:44', '../media/audio/pinkfloyd@gmail.com/wish you were here/welcome.mp3', 10, 0),
(123, 'Have A Cigar', '05:08', '../media/audio/pinkfloyd@gmail.com/wish you were here/cigar.mp3', 10, 0),
(124, 'Wish You Were Here', '05:35', '../media/audio/pinkfloyd@gmail.com/wish you were here/wish.mp3', 10, 0),
(125, 'Shine On You Crazy Diamond, Pts VI-IX', '12:30', '../media/audio/pinkfloyd@gmail.com/wish you were here/shineonyouii.mp3', 10, 0),
(128, 'Come Together', '04:22', '../media/audio/The Beatles_22/abbey road/01 - come together.mp3', 4, 0),
(129, 'Something', '03:03', '../media/audio/The Beatles_22/abbey road/02 - something.mp3', 4, 0),
(130, 'Maxwell\'s Silver Hammer', '03:29', '../media/audio/The Beatles_22/abbey road/03 - maxwells silver hammer.mp3', 4, 0),
(131, 'Oh! Darling', '03:27', '../media/audio/The Beatles_22/abbey road/04 - oh! darling.mp3', 4, 0),
(132, 'Octopus\'s Garden', '02:52', '../media/audio/The Beatles_22/abbey road/05 - octopuss garden.mp3', 4, 0),
(133, 'I Want You (She\'s So Heavy)', '07:49', '../media/audio/The Beatles_22/abbey road/06 - i want you (shes so heavy).mp3', 10, 0),
(134, 'Here Comes The Sun', '03:06', '../media/audio/The Beatles_22/abbey road/07 - here comes the sun.mp3', 4, 0),
(135, 'Because', '02:45', '../media/audio/The Beatles_22/abbey road/08 - because.mp3', 10, 0),
(136, 'You Never Give Me Your Money', '03:58', '../media/audio/The Beatles_22/abbey road/09 - you never give me your money.mp3', 10, 0),
(137, 'Sun King', '02:32', '../media/audio/The Beatles_22/abbey road/10 - sun king.mp3', 4, 0),
(138, 'Mean Mr. Mustard', '01:07', '../media/audio/The Beatles_22/abbey road/11 - mean mr. mustard.mp3', 4, 0),
(139, 'Polythene Pam', '00:48', '../media/audio/The Beatles_22/abbey road/12 - polythene pam.mp3', 4, 0),
(140, 'She Came In Through The Bathroom Window', '02:23', '../media/audio/The Beatles_22/abbey road/13 - she came in through the bathroom window.mp3', 4, 0),
(141, 'Golden Slumbers', '01:32', '../media/audio/The Beatles_22/abbey road/14 - golden slumbers.mp3', 10, 0),
(142, 'Carry That Weight', '01:36', '../media/audio/The Beatles_22/abbey road/15 - carry that weight.mp3', 10, 0),
(143, 'The End', '02:22', '../media/audio/The Beatles_22/abbey road/16 - the end.mp3', 4, 0),
(144, 'Her Majesty', '00:38', '../media/audio/The Beatles_22/abbey road/17 - her majesty.mp3', 4, 0),
(146, 'Will Of The People', '03:18', '../media/audio/Muse_15/will of the people/01. will of the people.mp3', 14, 0),
(147, 'Compliance', '04:10', '../media/audio/Muse_15/will of the people/02. compliance.mp3', 1, 0),
(148, 'Liberation', '03:09', '../media/audio/Muse_15/will of the people/03. liberation.mp3', 4, 0),
(149, 'Won\'t Stand Down', '03:29', '../media/audio/Muse_15/will of the people/04. won’t stand down.mp3', 10, 0),
(150, 'Ghosts (How Can I Move On)', '03:37', '../media/audio/Muse_15/will of the people/05. ghosts (how can i move on).mp3', 1, 0),
(151, 'You Make Me Feel Like It\'s Halloween', '03:00', '../media/audio/Muse_15/will of the people/06. you make me feel like its halloween.mp3', 14, 0),
(152, 'Kill Or Be Killed', '04:59', '../media/audio/Muse_15/will of the people/07. kill or be killed.mp3', 2, 0),
(153, 'Verona', '04:58', '../media/audio/Muse_15/will of the people/08. verona.mp3', 14, 0),
(154, 'Euphoria', '03:20', '../media/audio/Muse_15/will of the people/09. euphoria.mp3', 14, 0),
(155, 'We Are Fucking Fucked', '03:36', '../media/audio/Muse_15/will of the people/10. we are fucking fucked.mp3', 2, 0),
(157, '72 Seasons', '07:39', '../media/audio/meta@gm.com/72 seasons/01. 72 seasons.mp3', 9, 0),
(158, 'Shadows Follow', '06:12', '../media/audio/meta@gm.com/72 seasons/02. shadows follow.mp3', 9, 0),
(159, 'Screaming Suicide', '05:31', '../media/audio/meta@gm.com/72 seasons/03. screaming suicide.mp3', 9, 0),
(160, 'Sleepwalk My Life Away', '06:56', '../media/audio/meta@gm.com/72 seasons/04. sleepwalk my life away.mp3', 9, 0),
(161, 'You Must Burn!', '07:03', '../media/audio/meta@gm.com/72 seasons/05. you must burn!.mp3', 9, 0),
(162, 'Lux Æterna', '03:22', '../media/audio/meta@gm.com/72 seasons/06. lux Æterna.mp3', 9, 0),
(163, 'Crown of Barbed Wire', '05:49', '../media/audio/meta@gm.com/72 seasons/07. crown of barbed wire.mp3', 9, 0),
(164, 'Chasing Light', '06:45', '../media/audio/meta@gm.com/72 seasons/08. chasing light.mp3', 9, 0),
(165, 'If Darkness Had a Son', '06:36', '../media/audio/meta@gm.com/72 seasons/09. if darkness had a son.mp3', 9, 0),
(166, 'Too Far Gone', '04:34', '../media/audio/meta@gm.com/72 seasons/10. too far gone-.mp3', 9, 0),
(167, 'Room of Mirrors', '05:34', '../media/audio/meta@gm.com/72 seasons/11. room of mirrors.mp3', 9, 0),
(168, 'Inamorata', '11:10', '../media/audio/meta@gm.com/72 seasons/12. inamorata.mp3', 9, 0),
(169, 'Knucklehugs (Arm Yourself With Love)', '02:27', '../media/audio/dso@gmail.com/pacifisticuffs/knucklehugs.mp3', 3, 0),
(170, 'The Age of Vulture Culture', '05:00', '../media/audio/dso@gmail.com/pacifisticuffs/ageofvulture.mp3', 3, 0),
(171, 'Superhero Jagganath', '05:46', '../media/audio/dso@gmail.com/pacifisticuffs/jagganath.mp3', 3, 0),
(172, 'Vision of the Purblind', '01:01', '../media/audio/dso@gmail.com/pacifisticuffs/vision.mp3', 3, 0),
(173, 'Lady Clandestine Chainbreaker', '04:50', '../media/audio/dso@gmail.com/pacifisticuffs/lady.mp3', 3, 0),
(174, 'Jigsaw Hustle', '05:17', '../media/audio/dso@gmail.com/pacifisticuffs/jigsaw.mp3', 3, 0),
(175, 'Pulse of the Incipient', '00:35', '../media/audio/dso@gmail.com/pacifisticuffs/pulse.mp3', 3, 0),
(176, 'Ode to the Innocent', '03:49', '../media/audio/dso@gmail.com/pacifisticuffs/ode.mp3', 3, 0),
(177, 'Interruption', '05:21', '../media/audio/dso@gmail.com/pacifisticuffs/interruption.mp3', 3, 0),
(178, 'Cul-De-Sac Semantics', '01:09', '../media/audio/dso@gmail.com/pacifisticuffs/culdesac.mp3', 3, 0),
(179, 'Karma Bonfire', '04:15', '../media/audio/dso@gmail.com/pacifisticuffs/karma.mp3', 3, 0),
(180, 'Climbing The Eyewall', '04:41', '../media/audio/dso@gmail.com/pacifisticuffs/climbing.mp3', 3, 0),
(181, 'Porch Of Perception', '00:44', '../media/audio/dso@gmail.com/pacifisticuffs/porch.mp3', 3, 0),
(185, 'Funeral For A Friend / Love Lies Bleeding', '11:07', '../media/audio/Elton John_20/goodbye yellow brick road/01. funeral for a friend (love lies bleeding).mp3', 10, 0),
(186, 'Candle In The Wind', '03:49', '../media/audio/Elton John_20/goodbye yellow brick road/02. candle in the wind.mp3', 4, 0),
(187, 'Bennie And The Jets', '05:23', '../media/audio/Elton John_20/goodbye yellow brick road/03. bennie and the jets.mp3', 4, 0),
(188, 'Goodbye Yellow Brick Road', '03:13', '../media/audio/Elton John_20/goodbye yellow brick road/04. goodbye yellow brick road.mp3', 4, 0),
(189, 'This Song Has No Title', '02:23', '../media/audio/Elton John_20/goodbye yellow brick road/05. this song has no title.mp3', 4, 0),
(190, 'Grey Seal', '04:00', '../media/audio/Elton John_20/goodbye yellow brick road/06. grey seal.mp3', 4, 0),
(191, 'Jamaica Jerk-Off', '03:38', '../media/audio/Elton John_20/goodbye yellow brick road/07. jamaica jerk-off.mp3', 1, 0),
(192, 'I\'ve Seen That Movie Too', '05:58', '../media/audio/Elton John_20/goodbye yellow brick road/08. ive seen that movie too.mp3', 4, 0),
(193, 'Sweet Painted Lady', '03:54', '../media/audio/Elton John_20/goodbye yellow brick road/09. sweet painted lady.mp3', 4, 0),
(194, 'The Ballad Of Danny Bailey', '04:23', '../media/audio/Elton John_20/goodbye yellow brick road/10. the ballad of danny bailey (1909-34).mp3', 4, 0),
(195, 'Dirty Little Girl', '05:00', '../media/audio/Elton John_20/goodbye yellow brick road/11. dirty little girl.mp3', 4, 0),
(196, 'All The Girls Love Alice', '05:08', '../media/audio/Elton John_20/goodbye yellow brick road/12. all the girls love alice.mp3', 4, 0),
(197, 'Your Sister Can\'t Twist (But She Can Rock\'n\' Roll)', '02:42', '../media/audio/Elton John_20/goodbye yellow brick road/13. your sister cant twist (but she can rock n roll).mp3', 4, 0),
(198, 'Saturday Night\'s Alright (For Fighting)', '04:56', '../media/audio/Elton John_20/goodbye yellow brick road/14. saturday nights alright for fighting.mp3', 4, 0),
(199, 'Roy Rogers', '04:07', '../media/audio/Elton John_20/goodbye yellow brick road/15. roy rogers.mp3', 4, 0),
(200, 'Social Disease', '03:43', '../media/audio/Elton John_20/goodbye yellow brick road/16. social disease.mp3', 4, 0),
(201, 'Harmony', '02:47', '../media/audio/Elton John_20/goodbye yellow brick road/17. harmony.mp3', 4, 0),
(202, 'Two Of Us', '03:36', '../media/audio/The Beatles_22/let it be/01. two of us.mp3', 4, 0),
(203, 'Dig A Pony', '03:54', '../media/audio/The Beatles_22/let it be/02. dig a pony.mp3', 4, 0),
(204, 'Across The Universe', '03:48', '../media/audio/The Beatles_22/let it be/03. across the universe.mp3', 4, 0),
(205, 'I Me Mine', '02:25', '../media/audio/The Beatles_22/let it be/04. i me mine.mp3', 4, 0),
(206, 'Dig It', '00:50', '../media/audio/The Beatles_22/let it be/05. dig it.mp3', 4, 0),
(207, 'Let It Be', '04:03', '../media/audio/The Beatles_22/let it be/06. let it be.mp3', 4, 0),
(208, 'Maggie Mae', '00:40', '../media/audio/The Beatles_22/let it be/07. maggie mae.mp3', 4, 0),
(209, 'I\'ve Got A Feeling', '03:37', '../media/audio/The Beatles_22/let it be/08. ive got a feeling.mp3', 4, 0),
(210, 'One After 909', '02:54', '../media/audio/The Beatles_22/let it be/09. one after 909.mp3', 4, 0),
(211, 'The Long And Winding Road', '03:37', '../media/audio/The Beatles_22/let it be/10. the long and winding road.mp3', 4, 0),
(212, 'For You Blue', '02:32', '../media/audio/The Beatles_22/let it be/11. for you blue.mp3', 4, 0),
(213, 'Get Back', '03:08', '../media/audio/The Beatles_22/let it be/12. get back.mp3', 4, 0),
(244, 'Taxman', '02:55', '../media/audio/The Beatles_22/revolver/01. taxman (2022 mix).mp3', 4, 0),
(245, 'Eleanor Rigby', '02:24', '../media/audio/The Beatles_22/revolver/02. eleanor rigby (2022 mix).mp3', 4, 0),
(246, 'I\'m Only Sleeping', '03:17', '../media/audio/The Beatles_22/revolver/03. im only sleeping (2022 mix).mp3', 4, 0),
(247, 'Love You To', '03:17', '../media/audio/The Beatles_22/revolver/04. love you to (2022 mix).mp3', 4, 0),
(248, 'Here, There And Everywhere', '02:42', '../media/audio/The Beatles_22/revolver/05. here, there and everywhere (2022 mix).mp3', 4, 0),
(249, 'Yellow Submarine', '02:56', '../media/audio/The Beatles_22/revolver/06. yellow submarine (2022 mix).mp3', 4, 0),
(250, 'She Said She Said', '02:53', '../media/audio/The Beatles_22/revolver/07. she said she said (2022 mix).mp3', 4, 0),
(251, 'Good Day Sunshine', '02:26', '../media/audio/The Beatles_22/revolver/08. good day sunshine (2022 mix).mp3', 4, 0),
(252, 'And Your Bird Can Sing', '02:18', '../media/audio/The Beatles_22/revolver/09. and your bird can sing (2022 mix).mp3', 4, 0),
(253, 'For No One', '02:17', '../media/audio/The Beatles_22/revolver/10. for no one (2022 mix).mp3', 4, 0),
(254, 'Doctor Robert', '02:32', '../media/audio/The Beatles_22/revolver/11. doctor robert (2022 mix).mp3', 4, 0),
(255, 'I Want To Tell You', '02:45', '../media/audio/The Beatles_22/revolver/12. i want to tell you (2022 mix).mp3', 4, 0),
(256, 'Got To Get You Into My Life', '02:47', '../media/audio/The Beatles_22/revolver/13. got to get you into my life (2022 mix).mp3', 4, 0),
(257, 'Tomorrow Never Knows', '03:15', '../media/audio/The Beatles_22/revolver/14. tomorrow never knows (2022 mix).mp3', 4, 0),
(258, 'Bridge Burning', '04:46', '../media/audio/Foo Fighters_23/wasting light/01 - foo fighters - bridge burning.mp3', 12, 0),
(259, 'Rope', '04:19', '../media/audio/Foo Fighters_23/wasting light/02 - foo fighters - rope.mp3', 12, 0),
(260, 'Dear Rosemary', '04:27', '../media/audio/Foo Fighters_23/wasting light/03 - foo fighters - dear rosemary.mp3', 12, 0),
(261, 'White Limo', '03:22', '../media/audio/Foo Fighters_23/wasting light/04 - foo fighters - white limo.mp3', 12, 0),
(262, 'Arlandria', '04:28', '../media/audio/Foo Fighters_23/wasting light/05 - foo fighters - arlandria.mp3', 12, 0),
(263, 'These Days', '04:58', '../media/audio/Foo Fighters_23/wasting light/06 - foo fighters - these days.mp3', 12, 0),
(264, 'Back & Forth', '03:53', '../media/audio/Foo Fighters_23/wasting light/07 - foo fighters - back & forth.mp3', 12, 0),
(265, 'A Matter Of Time', '04:36', '../media/audio/Foo Fighters_23/wasting light/08 - foo fighters - a matter of time.mp3', 12, 0),
(266, 'Miss The Misery', '04:31', '../media/audio/Foo Fighters_23/wasting light/09 - foo fighters - miss the misery.mp3', 12, 0),
(267, 'I Should Have Known', '04:16', '../media/audio/Foo Fighters_23/wasting light/10 - foo fighters - i should have known.mp3', 12, 0),
(268, 'Walk', '04:16', '../media/audio/Foo Fighters_23/wasting light/11 - foo fighters - walk.mp3', 12, 0),
(269, 'Monarchy Of Roses', '04:12', '../media/audio/Red Hot Chili Peppers_24/im with you/01 - monarchy of roses.mp3', 4, 0),
(270, 'Factory Of Faith', '04:19', '../media/audio/Red Hot Chili Peppers_24/im with you/02 - factory of faith.mp3', 13, 0),
(271, 'Brendan\'s Death Song', '05:37', '../media/audio/Red Hot Chili Peppers_24/im with you/03 - brendans death song.mp3', 4, 0),
(272, 'Ethiopia', '03:49', '../media/audio/Red Hot Chili Peppers_24/im with you/04 - ethiopia.mp3', 13, 0),
(273, 'Annie Wants A Baby', '03:40', '../media/audio/Red Hot Chili Peppers_24/im with you/05 - annie wants a baby.mp3', 13, 0),
(274, 'Look Around', '03:28', '../media/audio/Red Hot Chili Peppers_24/im with you/06 - look around.mp3', 13, 0),
(275, 'The Adventures Of Rain Dance Maggie', '04:46', '../media/audio/Red Hot Chili Peppers_24/im with you/07 - the adventures of rain dance maggie.mp3', 13, 0),
(276, 'Did I Let You Know', '04:21', '../media/audio/Red Hot Chili Peppers_24/im with you/08 - did i let you know.mp3', 4, 0),
(277, 'Goodbye Hooray', '03:52', '../media/audio/Red Hot Chili Peppers_24/im with you/09 - goodbye hooray.mp3', 13, 0),
(278, 'Happiness Love Company', '03:33', '../media/audio/Red Hot Chili Peppers_24/im with you/10 - happiness loves company.mp3', 13, 0),
(279, 'Police Station', '05:35', '../media/audio/Red Hot Chili Peppers_24/im with you/11 - police station.mp3', 13, 0),
(280, 'Even You, Brutus', '04:02', '../media/audio/Red Hot Chili Peppers_24/im with you/12 - even you, brutus.mp3', 4, 0),
(281, 'Meet Me At The Corner', '04:20', '../media/audio/Red Hot Chili Peppers_24/im with you/13 - meet me at the corner.mp3', 4, 0),
(282, 'Dance, Dance, Dance', '03:47', '../media/audio/Red Hot Chili Peppers_24/im with you/14 - dance, dance, dance.mp3', 13, 0),
(331, 'Dani California', '04:42', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/01. dani california.mp3', 13, 0),
(332, 'Snow ((Hey Oh))', '05:35', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/02. snow ((hey oh)).mp3', 13, 0),
(333, 'Charlie', '04:38', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/03. charlie.mp3', 13, 0),
(334, 'Stadium Arcadium', '05:16', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/04. stadium arcadium.mp3', 4, 0),
(335, 'Hump de Bump', '03:33', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/05. hump de bump.mp3', 13, 0),
(336, 'She\'s Only 18', '03:25', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/06. shes only 18.mp3', 13, 0),
(337, 'Slow Cheetah', '05:20', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/07. slow cheetah.mp3', 4, 0),
(338, 'Torture Me', '03:45', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/08. torture me.mp3', 13, 0),
(339, 'Strip My Mind', '04:19', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/09. strip my mind.mp3', 13, 0),
(340, 'Especially In Michigan', '04:01', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/10. especially in michigan.mp3', 4, 0),
(341, 'Warlocks', '03:26', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/11. warlocks.mp3', 13, 0),
(342, 'C\'mon Girl', '03:49', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/12. cmon girl.mp3', 4, 0),
(343, 'Wet Sand', '05:10', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/13. wet sand.mp3', 4, 0),
(344, 'Hey', '05:39', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/14. hey.mp3', 4, 0),
(345, 'Desecration Smile', '05:02', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/01. desecration smile.mp3', 13, 0),
(346, 'Tell Me Baby', '04:08', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/02. tell me baby.mp3', 13, 0),
(347, 'Hard To Concentrate', '04:02', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/03. hard to concentrate.mp3', 4, 0),
(348, '21st Century', '04:23', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/04. 21st century.mp3', 13, 0),
(349, 'She Looks To Me', '04:06', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/05. she looks to me.mp3', 13, 0),
(350, 'Readymade', '04:31', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/06. readymade.mp3', 12, 0),
(351, 'If', '02:53', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/07. if.mp3', 13, 0),
(352, 'Make You Feel Better', '03:52', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/08. make you feel better.mp3', 13, 0),
(353, 'Animal Bar', '05:25', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/09. animal bar.mp3', 4, 0),
(354, 'So Match I', '03:45', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/10. so match i.mp3', 13, 0),
(355, 'Storm In A Teacup', '03:45', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/11. storm in a teacup.mp3', 4, 0),
(356, 'We Believe', '03:36', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/12. we believe.mp3', 13, 0),
(357, 'Turn It Again', '06:06', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/13. turn it again.mp3', 4, 0),
(358, 'Death Of A Martian', '04:25', '../media/audio/Red Hot Chili Peppers_24/stadium arcadium/14. death of a martion.mp3', 13, 0),
(359, 'Airbag', '04:44', '../media/audio/radiohead@gmail.com/ok computer/01 airbag.mp3', 14, 0),
(360, 'Paranoid Android', '06:24', '../media/audio/radiohead@gmail.com/ok computer/02 paranoid android.mp3', 14, 0),
(361, 'Subterranean Homesick Alien', '04:28', '../media/audio/radiohead@gmail.com/ok computer/03 subterranean homesick alien.mp3', 14, 0),
(362, 'Exit Music (For A Film)', '04:25', '../media/audio/radiohead@gmail.com/ok computer/04 exit music (for a film).mp3', 14, 0),
(363, 'Let Down', '04:59', '../media/audio/radiohead@gmail.com/ok computer/05 let down.mp3', 14, 0),
(364, 'Karma Police', '04:22', '../media/audio/radiohead@gmail.com/ok computer/06 karma police.mp3', 4, 0),
(365, 'Fitter Happier', '01:57', '../media/audio/radiohead@gmail.com/ok computer/07 fitter happier.mp3', 14, 0),
(366, 'Electioneering', '03:51', '../media/audio/radiohead@gmail.com/ok computer/08 electioneering.mp3', 14, 0),
(367, 'Climbing Up The Walls', '04:45', '../media/audio/radiohead@gmail.com/ok computer/09 climbing up the walls.mp3', 14, 0),
(368, 'No Surprises', '03:49', '../media/audio/radiohead@gmail.com/ok computer/10 no surprises.mp3', 14, 0),
(369, 'Lucky', '04:20', '../media/audio/radiohead@gmail.com/ok computer/11 lucky.mp3', 14, 0),
(370, 'The Tourist', '05:25', '../media/audio/radiohead@gmail.com/ok computer/12 the tourist.mp3', 14, 0),
(371, 'A Kilómetros', '03:14', '../media/audio/lasudadera@gmail.com/multipolar/la-sudadera-del-manager-cristal-01-a-kilómetros.mp3', 4, 0),
(372, 'Mejor Que Tú', '04:21', '../media/audio/lasudadera@gmail.com/multipolar/la-sudadera-del-manager-cristal-02-mejor-que-tú.mp3', 4, 0),
(373, 'Quién', '03:56', '../media/audio/lasudadera@gmail.com/multipolar/la sudadera del manager - cristal - 03 - quien.mp3', 4, 0),
(374, 'Mundos De Cristal', '04:36', '../media/audio/lasudadera@gmail.com/multipolar/la-sudadera-del-manager-cristal-04-mundos-de-cristal.mp3', 4, 0),
(375, 'Cosidas A Los Pantalones', '03:50', '../media/audio/lasudadera@gmail.com/multipolar/la-sudadera-del-manager-cristal-05-cosidas-a-los-pantalones.mp3', 1, 0),
(376, 'Multipolar', '03:51', '../media/audio/lasudadera@gmail.com/multipolar/la-sudadera-del-manager-cristal-06-multipolar.mp3', 4, 0),
(377, 'Preludio', '00:59', '../media/audio/lasudadera@gmail.com/multipolar/la-sudadera-del-manager-cristal-07-preludio.mp3', 4, 0),
(378, 'Sin Mirarte A La Cara', '03:50', '../media/audio/lasudadera@gmail.com/multipolar/la-sudadera-del-manager-cristal-08-sin-mirarte-a-la-cara.mp3', 10, 0),
(379, 'La Historia Que Nunca Supimos', '04:13', '../media/audio/lasudadera@gmail.com/multipolar/la-sudadera-del-manager-cristal-09-la-historia-que-nunca-supimos.mp3', 4, 0),
(380, 'Dos Locos', '04:03', '../media/audio/lasudadera@gmail.com/multipolar/la-sudadera-del-manager-cristal-10-dos-locos.mp3', 13, 0),
(381, 'Game Over', '03:49', '../media/audio/Avenged Sevenfold_29/life is but a dream.../01. game over.mp3', 16, 0),
(382, 'Mattel', '05:32', '../media/audio/Avenged Sevenfold_29/life is but a dream.../02. mattel.mp3', 16, 0),
(383, 'Nobody', '05:56', '../media/audio/Avenged Sevenfold_29/life is but a dream.../03. nobody.mp3', 16, 0),
(384, 'We Love You', '06:17', '../media/audio/Avenged Sevenfold_29/life is but a dream.../04. we love you.mp3', 16, 0),
(385, 'Cosmic', '07:33', '../media/audio/Avenged Sevenfold_29/life is but a dream.../05. cosmic.mp3', 10, 0),
(386, 'Beautiful Morning', '06:34', '../media/audio/Avenged Sevenfold_29/life is but a dream.../06. beautiful morning.mp3', 10, 0),
(387, 'Easier', '03:40', '../media/audio/Avenged Sevenfold_29/life is but a dream.../07. easier.mp3', 2, 0),
(388, 'G', '03:40', '../media/audio/Avenged Sevenfold_29/life is but a dream.../08. g.mp3', 16, 0),
(389, '(O)rdinary', '02:54', '../media/audio/Avenged Sevenfold_29/life is but a dream.../09. (o)rdinary.mp3', 13, 0),
(390, '(D)eath', '03:22', '../media/audio/Avenged Sevenfold_29/life is but a dream.../10. (d)eath.mp3', 3, 0),
(391, 'Life Is But A Dream...', '04:34', '../media/audio/Avenged Sevenfold_29/life is but a dream.../11. life is but a dream.mp3', 15, 0),
(392, 'The Stage', '08:32', '../media/audio/Avenged Sevenfold_29/the stage (deluxe edition)/01. the stage.mp3', 16, 0),
(393, 'Paradigm', '04:19', '../media/audio/Avenged Sevenfold_29/the stage (deluxe edition)/02. paradigm.mp3', 16, 0),
(394, 'Sunny Disposition', '06:41', '../media/audio/Avenged Sevenfold_29/the stage (deluxe edition)/03. sunny disposition.mp3', 16, 0),
(395, 'God Damn', '03:42', '../media/audio/Avenged Sevenfold_29/the stage (deluxe edition)/04. god damn.mp3', 2, 0),
(396, 'Creating God', '05:35', '../media/audio/Avenged Sevenfold_29/the stage (deluxe edition)/05. creating god.mp3', 2, 0),
(397, 'Angels', '05:41', '../media/audio/Avenged Sevenfold_29/the stage (deluxe edition)/06. angels.mp3', 12, 0),
(398, 'Simulation', '05:31', '../media/audio/Avenged Sevenfold_29/the stage (deluxe edition)/07. simulation.mp3', 2, 0),
(399, 'Higher', '06:29', '../media/audio/Avenged Sevenfold_29/the stage (deluxe edition)/08. higher.mp3', 10, 0),
(400, 'Roman Sky', '05:00', '../media/audio/Avenged Sevenfold_29/the stage (deluxe edition)/09. roman sky.mp3', 10, 0),
(401, 'Fermi Paradox', '06:31', '../media/audio/Avenged Sevenfold_29/the stage (deluxe edition)/10. fermi paradox.mp3', 2, 0),
(402, 'Exist', '15:39', '../media/audio/Avenged Sevenfold_29/the stage (deluxe edition)/11. exist.mp3', 16, 0),
(403, 'Malagueña Salerosa', '04:15', '../media/audio/Avenged Sevenfold_29/the stage (deluxe edition)/14. malaguena salerosa.mp3', 16, 0),
(404, 'Wish You Were Here', '05:14', '../media/audio/Avenged Sevenfold_29/the stage (deluxe edition)/17. wish you were here.mp3', 10, 0),
(405, 'God Only Knows', '03:34', '../media/audio/Avenged Sevenfold_29/the stage (deluxe edition)/18. god only knows.mp3', 4, 0),
(406, 'In The Air Tonight', '05:37', '../media/audio/Phil Collins_30/face value/1-01. in the air tonight (2015 remastered).mp3', 1, 0),
(407, 'This Must Be Love', '03:56', '../media/audio/Phil Collins_30/face value/1-02. this must be love (2015 remastered).mp3', 1, 0),
(408, 'Behind The Lines', '03:56', '../media/audio/Phil Collins_30/face value/1-03. behind the lines (2015 remastered).mp3', 1, 0),
(409, 'The Roof Is Leaking', '03:17', '../media/audio/Phil Collins_30/face value/1-04. the roof is leaking (2015 remastered).mp3', 1, 0),
(410, 'Droned', '02:50', '../media/audio/Phil Collins_30/face value/1-05. droned (2015 remastered).mp3', 1, 0),
(411, 'Hand In Hand', '05:23', '../media/audio/Phil Collins_30/face value/1-06. hand in hand (2015 remastered).mp3', 1, 0),
(412, 'I Missed Again', '03:46', '../media/audio/Phil Collins_30/face value/1-07. i missed again (2015 remastered).mp3', 1, 0),
(413, 'You Know What I Mean', '02:33', '../media/audio/Phil Collins_30/face value/1-08. you know what i mean (2015 remastered).mp3', 1, 0),
(414, 'Thunder And Lightning', '04:14', '../media/audio/Phil Collins_30/face value/1-09. thunder and lightning (2015 remastered).mp3', 1, 0),
(415, 'I\'m Not Moving', '02:35', '../media/audio/Phil Collins_30/face value/1-10. im not moving (2015 remastered).mp3', 1, 0),
(416, 'If Leaving Me Is Easy', '04:55', '../media/audio/Phil Collins_30/face value/1-11. if leaving me is easy (2015 remastered).mp3', 1, 0),
(417, 'Tomorrow Never Knows', '04:52', '../media/audio/Phil Collins_30/face value/1-12. tomorrow never knows (2015 remastered).mp3', 1, 0),
(526, 'The Quarantine Zone (20 Years Later)', '03:40', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/01-the quarantine zone (20 years later).mp3', 15, 0),
(527, 'The Hour', '01:01', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/02-the hour.mp3', 15, 0),
(528, 'The Last Of Us', '03:03', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/03-the last of us.mp3', 15, 0),
(529, 'Forgotten Memories', '01:07', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/04-forgotten memories.mp3', 15, 0),
(530, 'The Outbreak', '01:31', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/05-the outbreak.mp3', 15, 0),
(531, 'Vanishing Grace', '02:06', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/06-vanishing grace.mp3', 15, 0),
(532, 'The Hunters', '01:59', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/07-the hunters.mp3', 15, 0),
(533, 'All Gone', '01:13', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/08-all gone.mp3', 15, 0),
(534, 'Vanishing Grace (Innocence)', '00:55', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/09-vanishing grace (innocence).mp3', 15, 0),
(535, 'By Any Means', '01:53', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/10-by any means.mp3', 15, 0),
(536, 'The Choice', '01:42', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/11-the choice.mp3', 15, 0),
(537, 'Smugglers', '01:38', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/12-smugglers.mp3', 15, 0),
(538, 'The Last Of Us (Never Again)', '01:01', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/13-the last of us (never again).mp3', 15, 0),
(539, 'The Last Of Us (Goodnight)', '00:51', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/14-the last of us (goodnight).mp3', 15, 0),
(540, 'I Know What You Are', '01:21', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/15-i know what you are.mp3', 15, 0),
(541, 'Home', '03:07', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/16-home.mp3', 15, 0),
(542, 'Infected', '01:16', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/17-infected.mp3', 15, 0),
(543, 'All Gone (Aftermath)', '01:04', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/18-all gone (aftermath).mp3', 15, 0),
(544, 'The Last Of Us (A New Dawn)', '02:28', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/19-the last of us (a new dawn).mp3', 15, 0),
(545, 'The Last Of Us (You and Me)', '02:08', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/27-the last of us (you and me).mp3', 15, 0),
(546, 'All Gone (Alone)', '01:22', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/23-all gone (alone).mp3', 15, 0),
(547, 'The Path (A New Beggining)', '02:47', '../media/audio/Gustavo Santaolalla_31/the last of us original soundtrack/29-the path (a new beginning).mp3', 15, 0),
(548, 'I Don\'t Care Anymore', '05:06', '../media/audio/Phil Collins_30/hello, i must be going!/01. i dont care anymore (2016 remastered).mp3', 1, 0),
(549, 'I Cannot Believe It\'s True', '05:17', '../media/audio/Phil Collins_30/hello, i must be going!/02. i cannot believe its true (2016 remastered).mp3', 1, 0),
(550, 'Like China', '05:09', '../media/audio/Phil Collins_30/hello, i must be going!/03. like china (2016 remastered).mp3', 1, 0),
(551, 'Do You Know, Do You Care', '04:58', '../media/audio/Phil Collins_30/hello, i must be going!/04. do you know, do you care (2016 remastered).mp3', 1, 0),
(552, 'You Can\'t Hurry Love', '02:56', '../media/audio/Phil Collins_30/hello, i must be going!/05. you cant hurry love (2016 remastered).mp3', 1, 0),
(553, 'It Doesn\'t Matter To Me', '04:17', '../media/audio/Phil Collins_30/hello, i must be going!/06. it dont matter to me (2016 remastered).mp3', 1, 0),
(554, 'Thru These Walls', '05:05', '../media/audio/Phil Collins_30/hello, i must be going!/07. thru these walls (2016 remastered).mp3', 1, 0),
(555, 'Don\'t Let Him Steal Your Heart Away', '04:45', '../media/audio/Phil Collins_30/hello, i must be going!/08. dont let him steal your heart away (2016 remastered).mp3', 1, 0),
(556, 'The West Side', '05:02', '../media/audio/Phil Collins_30/hello, i must be going!/09. the west side (2016 remastered).mp3', 1, 0),
(557, 'Why Can\'t It Wait \'Til Morning', '03:12', '../media/audio/Phil Collins_30/hello, i must be going!/10. why cant it wait til morning (2016 remastered).mp3', 1, 0),
(558, 'Intro', '00:23', '../media/audio/Muse_15/absolution/01 - intro.mp3', 14, 0),
(559, 'Apocalypse Please', '04:13', '../media/audio/Muse_15/absolution/02 - apocalypse please.mp3', 14, 0),
(560, 'Time Is Running Out', '03:56', '../media/audio/Muse_15/absolution/03 - time is running out.mp3', 14, 0),
(561, 'Sing For Absolution', '04:55', '../media/audio/Muse_15/absolution/04 - sing for absolution.mp3', 4, 0),
(562, 'Stockholm Syndrome', '04:59', '../media/audio/Muse_15/absolution/05 - stockholm syndrome.mp3', 10, 0),
(563, 'Falling Away With You', '04:41', '../media/audio/Muse_15/absolution/06 - falling away with you.mp3', 4, 0),
(564, 'Interlude', '00:38', '../media/audio/Muse_15/absolution/07 - interlude.mp3', 14, 0),
(565, 'Hysteria', '03:47', '../media/audio/Muse_15/absolution/08 - hysteria.mp3', 14, 0),
(566, 'Blackout', '04:22', '../media/audio/Muse_15/absolution/09 - blackout.mp3', 14, 0),
(567, 'Butterflies & Hurricanes', '05:02', '../media/audio/Muse_15/absolution/10 - butterflies & hurricanes.mp3', 10, 0),
(568, 'The Small Print', '03:29', '../media/audio/Muse_15/absolution/11 - the small print.mp3', 14, 0),
(569, 'Endlessly', '03:49', '../media/audio/Muse_15/absolution/12 - endlessly.mp3', 4, 0),
(570, 'Thoughts Of A Dying Atheist', '03:11', '../media/audio/Muse_15/absolution/13 - thoughts of a dying atheist.mp3', 14, 0),
(571, 'Ruled By Secrecy', '04:54', '../media/audio/Muse_15/absolution/14 - ruled by secrecy.mp3', 4, 0),
(572, 'Rize Of The Fenix', '05:54', '../media/audio/tenaciousd@gmail.com/rize of the fenix/01 - tenacious d - rize of the fenix.mp3', 12, 0),
(573, 'Low Hangin\' Fruit', '02:31', '../media/audio/tenaciousd@gmail.com/rize of the fenix/02 - tenacious d - low hangin fruit.mp3', 4, 0),
(574, 'Classical Teacher', '03:23', '../media/audio/tenaciousd@gmail.com/rize of the fenix/03 - tenacious d - classical teacher.mp3', 14, 0),
(575, 'Señorita', '03:08', '../media/audio/tenaciousd@gmail.com/rize of the fenix/04 - tenacious d - señorita.mp3', 12, 0),
(576, 'Deth Starr', '04:45', '../media/audio/tenaciousd@gmail.com/rize of the fenix/05 - tenacious d - deth starr.mp3', 4, 0),
(577, 'Roadie', '02:59', '../media/audio/tenaciousd@gmail.com/rize of the fenix/06 - tenacious d - roadie.mp3', 13, 0),
(578, 'Flutes & Trombones', '01:28', '../media/audio/tenaciousd@gmail.com/rize of the fenix/07 - tenacious d - flutes & trombones.mp3', 15, 0),
(579, 'The Ballad Of Hollywood Jack and the Rage Kage', '05:06', '../media/audio/tenaciousd@gmail.com/rize of the fenix/08 - tenacious d - the ballad of hollywood jack and the rage kage.mp3', 4, 0),
(580, 'Throwdown', '02:57', '../media/audio/tenaciousd@gmail.com/rize of the fenix/09 - tenacious d - throwdown.mp3', 4, 0),
(581, 'Rock Is Dead', '01:43', '../media/audio/tenaciousd@gmail.com/rize of the fenix/10 - tenacious d - rock is dead.mp3', 12, 0),
(582, 'They Fucked Our Asses', '01:07', '../media/audio/tenaciousd@gmail.com/rize of the fenix/11 - tenacious d - they fucked our asses.mp3', 14, 0),
(583, 'To Be The Best', '01:01', '../media/audio/tenaciousd@gmail.com/rize of the fenix/12 - tenacious d - to be the best.mp3', 13, 0),
(584, '39', '05:17', '../media/audio/tenaciousd@gmail.com/rize of the fenix/13 - tenacious d - 39.mp3', 4, 0),
(585, 'Hidden Track', '01:36', '../media/audio/tenaciousd@gmail.com/rize of the fenix/14 - tenacious d - hidden track.mp3', 4, 0),
(586, 'Kickapoo', '04:14', '../media/audio/tenaciousd@gmail.com/the pick of destiny/snapsave.io - kickapoo (320 kbps).mp3', 17, 0),
(587, 'Classico', '00:59', '../media/audio/tenaciousd@gmail.com/the pick of destiny/snapsave.io - classico (320 kbps).mp3', 17, 0),
(588, 'Baby', '01:36', '../media/audio/tenaciousd@gmail.com/the pick of destiny/snapsave.io - baby (320 kbps).mp3', 17, 0),
(589, 'Destiny', '00:37', '../media/audio/tenaciousd@gmail.com/the pick of destiny/snapsave.io - destiny (320 kbps).mp3', 17, 0),
(590, 'History', '01:42', '../media/audio/tenaciousd@gmail.com/the pick of destiny/snapsave.io - history (320 kbps).mp3', 4, 0),
(591, 'The Government Totally Sucks', '01:35', '../media/audio/tenaciousd@gmail.com/the pick of destiny/snapsave.io - the government totally sucks (320 kbps).mp3', 12, 0),
(592, 'Master Exploder', '02:25', '../media/audio/tenaciousd@gmail.com/the pick of destiny/snapsave.io - master exploder (320 kbps).mp3', 12, 0),
(593, 'The Divide', '00:22', '../media/audio/tenaciousd@gmail.com/the pick of destiny/snapsave.io - the divide (320 kbps).mp3', 17, 0),
(594, 'Papagenu (He\'s My Sassafrass)', '02:24', '../media/audio/tenaciousd@gmail.com/the pick of destiny/snapsave.io - papagenu (hes my sassafrass) (320 kbps).mp3', 4, 0),
(595, 'Dude (I Totally Miss You)', '02:54', '../media/audio/tenaciousd@gmail.com/the pick of destiny/snapsave.io - dude (i totally miss you) (320 kbps).mp3', 4, 0),
(596, 'Break In-City (Storm The Gate!)', '01:22', '../media/audio/tenaciousd@gmail.com/the pick of destiny/snapsave.io - break in-city (storm the gate!) (320 kbps).mp3', 17, 0),
(597, 'Car Chase City', '02:42', '../media/audio/tenaciousd@gmail.com/the pick of destiny/snapsave.io - car chase city (320 kbps).mp3', 17, 0),
(598, 'Beelzeboss (The Final Showdown)', '05:36', '../media/audio/tenaciousd@gmail.com/the pick of destiny/snapsave.io - beelzeboss (the final showdown) (320 kbps).mp3', 12, 0),
(599, 'The Pick Of Destiny', '02:32', '../media/audio/tenaciousd@gmail.com/the pick of destiny/snapsave.io - the pick of destiny (320 kbps).mp3', 17, 0),
(600, 'The Metal', '02:46', '../media/audio/tenaciousd@gmail.com/the pick of destiny/snapsave.io - the metal (320 kbps).mp3', 2, 0),
(617, 'Something From Nothing', '04:48', '../media/audio/Foo Fighters_23/sonic highways/01 - something from nothing.mp3', 12, 0),
(618, 'The Feast And The Famine', '03:49', '../media/audio/Foo Fighters_23/sonic highways/02 - the feast and the famine.mp3', 12, 0),
(619, 'Congregation', '05:11', '../media/audio/Foo Fighters_23/sonic highways/03 - congregation.mp3', 17, 0),
(620, 'What Did I Do?/God As My Witness', '05:43', '../media/audio/Foo Fighters_23/sonic highways/04 - what did i do-god as my witness.mp3', 12, 0),
(621, 'Outside', '05:14', '../media/audio/Foo Fighters_23/sonic highways/05 - outside.mp3', 12, 0),
(622, 'In The Clear', '04:03', '../media/audio/Foo Fighters_23/sonic highways/06 - in the clear.mp3', 17, 0),
(623, 'Subterranean', '06:07', '../media/audio/Foo Fighters_23/sonic highways/07 - subterranean.mp3', 17, 0),
(624, 'I Am A River', '07:08', '../media/audio/Foo Fighters_23/sonic highways/08 - i am a river.mp3', 12, 0),
(625, 'Right Next Door To Hell', '03:02', '../media/audio/Guns N\' Roses_36/use your illusion i/01. right next door to hell (2022 remaster)(explicit).mp3', 12, 0),
(626, 'Dust N\' Bones', '04:59', '../media/audio/Guns N\' Roses_36/use your illusion i/02. dust n bones (2022 remaster)(explicit).mp3', 12, 0),
(627, 'Live And Let Die', '03:03', '../media/audio/Guns N\' Roses_36/use your illusion i/03. live and let die (2022 remaster).mp3', 17, 0),
(628, 'Don\'t Cry', '04:44', '../media/audio/Guns N\' Roses_36/use your illusion i/04. dont cry (original) (2022 remaster).mp3', 17, 0),
(629, 'Perfect Crime', '02:23', '../media/audio/Guns N\' Roses_36/use your illusion i/05. perfect crime (2022 remaster)(explicit).mp3', 12, 0),
(630, 'You Ain\'t The First', '02:36', '../media/audio/Guns N\' Roses_36/use your illusion i/06. you aint the first (2022 remaster).mp3', 12, 0),
(631, 'Bad Obsession', '05:28', '../media/audio/Guns N\' Roses_36/use your illusion i/07. bad obsession (2022 remaster)(explicit).mp3', 17, 0),
(632, 'Back Off Bitch', '05:02', '../media/audio/Guns N\' Roses_36/use your illusion i/08. back off bitch (2022 remaster)(explicit).mp3', 12, 0),
(633, 'Double Talkin\' Jive', '03:24', '../media/audio/Guns N\' Roses_36/use your illusion i/09. double talkin jive (2022 remaster)(explicit).mp3', 12, 0),
(634, 'November Rain', '08:56', '../media/audio/Guns N\' Roses_36/use your illusion i/10. november rain (2022 version).mp3', 10, 0),
(635, 'The Garden', '05:21', '../media/audio/Guns N\' Roses_36/use your illusion i/11. the garden (2022 remaster).mp3', 17, 0),
(636, 'Garden Of Eden', '02:43', '../media/audio/Guns N\' Roses_36/use your illusion i/12. garden of eden (2022 remaster)(explicit).mp3', 12, 0),
(637, 'Don\'t Damn Me', '05:19', '../media/audio/Guns N\' Roses_36/use your illusion i/13. dont damn me (2022 remaster)(explicit).mp3', 12, 0),
(638, 'Bad Apples', '04:28', '../media/audio/Guns N\' Roses_36/use your illusion i/14. bad apples (2022 remaster)(explicit).mp3', 17, 0),
(639, 'Dead Horse', '04:17', '../media/audio/Guns N\' Roses_36/use your illusion i/15. dead horse (2022 remaster).mp3', 17, 0),
(640, 'Coma', '10:13', '../media/audio/Guns N\' Roses_36/use your illusion i/16. coma (2022 remaster)(explicit).mp3', 12, 0),
(641, 'Civil War', '07:40', '../media/audio/Guns N\' Roses_36/use your illusion ii/01. civil war (2022 remaster).mp3', 12, 0),
(642, '14 Years', '04:23', '../media/audio/Guns N\' Roses_36/use your illusion ii/02. 14 years (2022 remaster).mp3', 17, 0),
(643, 'Yesterdays', '03:17', '../media/audio/Guns N\' Roses_36/use your illusion ii/03. yesterdays (2022 remaster).mp3', 17, 0),
(644, 'Knockin\' On Heavens Door', '05:35', '../media/audio/Guns N\' Roses_36/use your illusion ii/04. knockin on heavens door (2022 remaster).mp3', 17, 0),
(645, 'Get In The Ring', '05:40', '../media/audio/Guns N\' Roses_36/use your illusion ii/05. get in the ring (2022 remaster)(explicit).mp3', 12, 0),
(646, 'Shotgun Blues', '03:22', '../media/audio/Guns N\' Roses_36/use your illusion ii/06. shotgun blues (2022 remaster)(explicit).mp3', 17, 0),
(647, 'Breakdown', '07:03', '../media/audio/Guns N\' Roses_36/use your illusion ii/07. breakdown (2022 remaster).mp3', 17, 0),
(648, 'Pretty Tied Up', '04:47', '../media/audio/Guns N\' Roses_36/use your illusion ii/08. pretty tied up (the perils of rock n roll decadence) (2022 remaster).mp3', 12, 0),
(649, 'Locomotive (Complicity)', '08:41', '../media/audio/Guns N\' Roses_36/use your illusion ii/09. locomotive (complicity) (2022 remaster).mp3', 12, 0),
(650, 'So Fine', '04:07', '../media/audio/Guns N\' Roses_36/use your illusion ii/10. so fine (2022 remaster).mp3', 17, 0),
(651, 'Estranged', '09:22', '../media/audio/Guns N\' Roses_36/use your illusion ii/11. estranged (2022 remaster).mp3', 10, 0),
(652, 'You Could Be Mine', '05:43', '../media/audio/Guns N\' Roses_36/use your illusion ii/12. you could be mine (2022 remaster).mp3', 12, 0),
(653, 'Don\'t Cry (Alternate Version)', '04:48', '../media/audio/Guns N\' Roses_36/use your illusion ii/13. dont cry (alternate lyrics - 2022 remaster).mp3', 17, 0),
(654, 'My World', '01:27', '../media/audio/Guns N\' Roses_36/use your illusion ii/14. my world (2022 remaster)(explicit).mp3', 14, 0),
(655, 'Another Day Of Sun', '03:48', '../media/audio/Justin Hurwitz_37/la la land (original motion picture soundtrack)/01 another day of sun (from _la la land_ soundtrack).mp3', 15, 0),
(656, 'Someone In The Crowd', '04:20', '../media/audio/Justin Hurwitz_37/la la land (original motion picture soundtrack)/02 someone in the crowd (from _la la land_ soundtrack).mp3', 15, 0),
(657, 'Mia & Sebastian\'s Theme', '01:38', '../media/audio/Justin Hurwitz_37/la la land (original motion picture soundtrack)/03 mia & sebastian_s theme (from _la la land_ soundtrack).mp3', 15, 0),
(658, 'A Lovely Night', '03:57', '../media/audio/Justin Hurwitz_37/la la land (original motion picture soundtrack)/04 a lovely night (from _la la land_ soundtrack).mp3', 15, 0),
(659, 'Herman\'s Habit', '01:52', '../media/audio/Justin Hurwitz_37/la la land (original motion picture soundtrack)/05 herman_s habit (from _la la land_ soundtrack).mp3', 15, 0),
(660, 'City Of Stars (Pier)', '01:51', '../media/audio/Justin Hurwitz_37/la la land (original motion picture soundtrack)/06 city of stars (pier).mp3', 15, 0),
(661, 'Planetarium', '04:17', '../media/audio/Justin Hurwitz_37/la la land (original motion picture soundtrack)/07 planetarium (from _la la land_ soundtrack).mp3', 15, 0),
(662, 'Summer Montage', '02:05', '../media/audio/Justin Hurwitz_37/la la land (original motion picture soundtrack)/08 summer montage _ madeline (from _la la land_ soundtrack).mp3', 15, 0),
(663, 'City Of Stars', '02:30', '../media/audio/Justin Hurwitz_37/la la land (original motion picture soundtrack)/09 city of stars (from _la la land_ soundtrack).mp3', 15, 0),
(664, 'Start A Fire', '03:12', '../media/audio/Justin Hurwitz_37/la la land (original motion picture soundtrack)/snapsave.io - start a fire (320 kbps).mp3', 1, 0),
(665, 'Engagement Party', '01:27', '../media/audio/Justin Hurwitz_37/la la land (original motion picture soundtrack)/11 engagement party (from _la la land_ soundtrack).mp3', 15, 0),
(666, 'Audition (The Fools Who Dream)', '03:48', '../media/audio/Justin Hurwitz_37/la la land (original motion picture soundtrack)/12 audition (the fools who dream) (from _la la land_ soundtrack).mp3', 15, 0),
(667, 'Epilogue', '07:40', '../media/audio/Justin Hurwitz_37/la la land (original motion picture soundtrack)/13 epilogue (from _la la land_ soundtrack).mp3', 15, 0),
(668, 'The End', '00:46', '../media/audio/Justin Hurwitz_37/la la land (original motion picture soundtrack)/14 the end (from _la la land_ soundtrack).mp3', 15, 0),
(669, 'City Of Stars (Humming)', '02:43', '../media/audio/Justin Hurwitz_37/la la land (original motion picture soundtrack)/15 city of stars (humming) (from _la la land_ soundtrack).mp3', 15, 0),
(670, 'Welcome', '04:04', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/01. welcome.mp3', 15, 0),
(671, 'Manny and Nellie\'s Theme', '00:58', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/02. manny and nellies theme.mp3', 15, 0);
INSERT INTO `cancion` (`id`, `titulo`, `duracion`, `archivo`, `estilo`, `times_played`) VALUES
(672, 'King Of The Circus', '02:32', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/03. king of the circus.mp3', 15, 0),
(673, 'Jub Jub', '01:00', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/04. jub jub.mp3', 15, 0),
(674, 'Coke Room', '02:35', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/05. coke room.mp3', 15, 0),
(675, 'My Girl\'s Pussy', '02:33', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/06. my girls pussy.mp3', 15, 0),
(676, 'Miss Idaho', '00:59', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/07. miss idaho.mp3', 15, 0),
(677, 'Voodoo Mama', '04:03', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/08. voodoo mama.mp3', 15, 0),
(678, 'Babylon', '00:34', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/11. babylon.mp3', 15, 0),
(679, 'Morning', '02:05', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/12. morning.mp3', 15, 0),
(680, 'Kinescope Ragtime Piano', '00:39', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/13. kinescope ragtime piano.mp3', 15, 0),
(681, 'Kinescope Carnival Music', '00:53', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/15. kinescope carnival music.mp3', 15, 0),
(682, 'Gold Coast Sunset', '02:05', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/19. gold coast sunset.mp3', 15, 0),
(683, 'Singin\' In The Rain', '01:26', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/28. singin in the rain.mp3', 15, 0),
(684, 'Te Amo Nellie', '01:36', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/45. te amo nellie.mp3', 15, 0),
(685, 'Gold Coast Rhythm (Sidney\'s Solo)', '02:51', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/46. gold coast rhythm (sidneys solo).mp3', 15, 0),
(686, 'Gold Coast Rhythm (Juan Bonilla)', '03:00', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/44. gold coast rhythm (juan bonilla).mp3', 15, 0),
(687, 'Manny and Nellie\'s Theme (Reprise)', '00:49', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/47. manny and nellies theme (reprise).mp3', 15, 0),
(688, 'Finale', '03:55', '../media/audio/Justin Hurwitz_37/babylon (music from the motion picture)/48. finale.mp3', 15, 0),
(689, 'Overture', '03:20', '../media/audio/Justin Hurwitz_37/whiplash (original motion picture soundtrack)/snapsave.io - overture - from _whiplash_ (320 kbps).mp3', 15, 0),
(690, 'Whiplash', '01:55', '../media/audio/Justin Hurwitz_37/whiplash (original motion picture soundtrack)/snapsave.io - whiplash (320 kbps).mp3', 15, 0),
(691, 'Fletcher\'s Song In Club', '01:29', '../media/audio/Justin Hurwitz_37/whiplash (original motion picture soundtrack)/snapsave.io - fletchers song in club (320 kbps).mp3', 15, 0),
(692, 'Caravan', '09:15', '../media/audio/Justin Hurwitz_37/whiplash (original motion picture soundtrack)/snapsave.io - caravan (320 kbps).mp3', 15, 0),
(693, 'When I Wake', '03:52', '../media/audio/Justin Hurwitz_37/whiplash (original motion picture soundtrack)/snapsave.io - when i wake (320 kbps).mp3', 15, 0),
(694, 'Casey\'s Song', '01:57', '../media/audio/Justin Hurwitz_37/whiplash (original motion picture soundtrack)/snapsave.io - caseys song (320 kbps).mp3', 15, 0),
(695, 'Upswingin\'', '02:13', '../media/audio/Justin Hurwitz_37/whiplash (original motion picture soundtrack)/snapsave.io - upswingin (320 kbps).mp3', 15, 0),
(696, 'Tom Sawyer', '04:41', '../media/audio/Rush_27/moving pictures 40th anniversary/01. tom sawyer.mp3', 10, 0),
(697, 'Red Barchetta', '06:16', '../media/audio/Rush_27/moving pictures 40th anniversary/02. red barchetta.mp3', 10, 0),
(698, 'YYZ', '04:31', '../media/audio/Rush_27/moving pictures 40th anniversary/03. yyz.mp3', 10, 0),
(699, 'Limelight', '04:23', '../media/audio/Rush_27/moving pictures 40th anniversary/04. limelight.mp3', 10, 0),
(700, 'The Camera Eye', '11:03', '../media/audio/Rush_27/moving pictures 40th anniversary/05. the camera eye.mp3', 10, 0),
(701, 'Witch Hunt', '04:50', '../media/audio/Rush_27/moving pictures 40th anniversary/06. witch hunt.mp3', 10, 0),
(702, 'Vital Signs', '04:50', '../media/audio/Rush_27/moving pictures 40th anniversary/07. vital signs.mp3', 10, 0),
(703, 'Invisible Touch', '03:30', '../media/audio/genesis@genesis.com/invisible touch/01. invisible touch.mp3', 1, 0),
(704, 'Tonight, Tonight, Tonight', '08:54', '../media/audio/genesis@genesis.com/invisible touch/02. tonight, tonight, tonight.mp3', 1, 0),
(705, 'Land Of Confusion', '04:46', '../media/audio/genesis@genesis.com/invisible touch/03. land of confusion.mp3', 1, 0),
(706, 'In Too Deep', '05:03', '../media/audio/genesis@genesis.com/invisible touch/04. in too deep.mp3', 1, 0),
(707, 'Anything She Does', '04:21', '../media/audio/genesis@genesis.com/invisible touch/05. anything she does.mp3', 1, 0),
(708, 'Domino', '10:45', '../media/audio/genesis@genesis.com/invisible touch/06. domino.mp3', 1, 0),
(709, 'Throwing It All Away', '03:51', '../media/audio/genesis@genesis.com/invisible touch/07. throwing it all away.mp3', 1, 0),
(710, 'The Brazilian', '05:04', '../media/audio/genesis@genesis.com/invisible touch/08. the brazilian.mp3', 1, 0),
(711, 'The Root Of All Evil', '08:26', '../media/audio/dreamt@gmail.com/octavarium/snapsave.io - the root of all evil (320 kbps).mp3', 16, 0),
(712, 'The Answer Lies Within', '05:33', '../media/audio/dreamt@gmail.com/octavarium/snapsave.io - the answer lies within (320 kbps).mp3', 16, 0),
(713, 'These Walls', '07:36', '../media/audio/dreamt@gmail.com/octavarium/snapsave.io - these walls (320 kbps).mp3', 16, 0),
(714, 'I Walk Beside You', '04:29', '../media/audio/dreamt@gmail.com/octavarium/snapsave.io - i walk beside you (320 kbps).mp3', 16, 0),
(715, 'Panic Attack', '08:13', '../media/audio/dreamt@gmail.com/octavarium/snapsave.io - panic attack (320 kbps).mp3', 16, 0),
(716, 'Never Enough', '06:47', '../media/audio/dreamt@gmail.com/octavarium/snapsave.io - never enough (320 kbps).mp3', 16, 0),
(717, 'Sacrificed Sons', '10:43', '../media/audio/dreamt@gmail.com/octavarium/snapsave.io - sacrificed sons (320 kbps).mp3', 16, 0),
(718, 'Octavarium', '24:00', '../media/audio/dreamt@gmail.com/octavarium/snapsave.io - octavarium (320 kbps).mp3', 16, 0),
(735, 'Party', '02:26', '../media/audio/Queen_12/the miracle/01. party (remastered 2011).mp3', 17, 0),
(736, 'Khashoggi\'s Ship', '02:51', '../media/audio/Queen_12/the miracle/02. khashoggis ship (remastered 2011).mp3', 12, 0),
(737, 'The Miracle', '05:05', '../media/audio/Queen_12/the miracle/03. the miracle (remastered 2011).mp3', 4, 0),
(738, 'I Want It All', '04:44', '../media/audio/Queen_12/the miracle/04. i want it all (remastered 2011).mp3', 17, 0),
(739, 'The Invisible Man', '04:05', '../media/audio/Queen_12/the miracle/05. the invisible man (remastered 2011).mp3', 17, 0),
(740, 'Breakthru', '04:11', '../media/audio/Queen_12/the miracle/06. breakthru (remastered 2011).mp3', 4, 0),
(741, 'Rain Must Fall', '04:26', '../media/audio/Queen_12/the miracle/07. rain must fall (remastered 2011).mp3', 4, 0),
(742, 'Scandal', '04:45', '../media/audio/Queen_12/the miracle/08. scandal (remastered 2011).mp3', 4, 0),
(743, 'My Baby Does Me', '03:25', '../media/audio/Queen_12/the miracle/09. my baby does me (remastered 2011).mp3', 1, 0),
(744, 'Was It All Worth It', '05:48', '../media/audio/Queen_12/the miracle/10. was it all worth it (remastered 2011).mp3', 1, 0),
(745, 'Death On Two Legs (Dedicated To)', '03:43', '../media/audio/Queen_12/a night at the opera/queen - death on two legs (dedicated to...).mp3', 10, 0),
(746, 'Lazin On A Sunday Afternoon', '01:07', '../media/audio/Queen_12/a night at the opera/queen - lazing on a sunday afternoon.mp3', 17, 0),
(747, 'I\'m In Love With My Car', '03:05', '../media/audio/Queen_12/a night at the opera/queen - im in love with my car.mp3', 17, 0),
(748, 'You\'re My Best Friend', '02:51', '../media/audio/Queen_12/a night at the opera/queen - youre my best friend.mp3', 4, 0),
(749, '\'39', '03:31', '../media/audio/Queen_12/a night at the opera/queen - 39.mp3', 4, 0),
(750, 'Sweet Lady', '04:02', '../media/audio/Queen_12/a night at the opera/queen - sweet lady.mp3', 17, 0),
(751, 'Seaside Rendezvous', '02:14', '../media/audio/Queen_12/a night at the opera/queen - seaside rendezvous.mp3', 4, 0),
(752, 'The Prophet\'s Song', '08:21', '../media/audio/Queen_12/a night at the opera/queen - the prophets song.mp3', 10, 0),
(753, 'Love Of My Life', '03:37', '../media/audio/Queen_12/a night at the opera/queen - love of my life.mp3', 4, 0),
(754, 'Good Company', '03:23', '../media/audio/Queen_12/a night at the opera/queen - good company.mp3', 4, 0),
(755, 'Bohemian Rhapsody', '05:54', '../media/audio/Queen_12/a night at the opera/queen - bohemian rhapsody.mp3', 10, 0),
(756, 'God Save The Queen', '01:15', '../media/audio/Queen_12/a night at the opera/queen - god save the queen.mp3', 17, 0),
(757, 'Wicked Game', '01:50', '../media/audio/tenaciousd@gmail.com/wicked game (single)/snapsave.io - wicked game (320 kbps).mp3', 1, 0),
(769, 'Timber Hearth', '03:25', '../media/audio/Justin Hurwitz_37/outer wilds ost/snapsave.io - timber hearth 320 kbps.mp3', 15, 0),
(770, 'End Times', '01:59', '../media/audio/Justin Hurwitz_37/outer wilds ost/snapsave.io - end times 320 kbps.mp3', 15, 0),
(771, 'Travelers', '03:30', '../media/audio/Justin Hurwitz_37/outer wilds ost/snapsave.io - travelers 320 kbps.mp3', 15, 0),
(772, 'Outer Wilds', '02:27', '../media/audio/Justin Hurwitz_37/outer wilds ost/snapsave.io - outer wilds 320 kbps.mp3', 15, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contiene`
--

CREATE TABLE `contiene` (
  `lista` int(4) NOT NULL,
  `cancion` int(4) NOT NULL,
  `orden` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contiene`
--

INSERT INTO `contiene` (`lista`, `cancion`, `orden`) VALUES
(12, 104, 6),
(12, 108, 5),
(12, 123, 1),
(12, 269, 7),
(12, 392, 8),
(12, 560, 9),
(13, 34, 3),
(13, 40, 4),
(13, 51, 1),
(13, 86, 2),
(13, 91, 6),
(13, 124, 12),
(13, 171, 8),
(13, 392, 13),
(13, 393, 14),
(13, 404, 11),
(13, 560, 15),
(53, 573, 1),
(56, 573, 2),
(56, 574, 3),
(56, 575, 4),
(56, 582, 5),
(56, 670, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `discografica`
--

CREATE TABLE `discografica` (
  `id` int(4) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `foto_avatar` varchar(150) NOT NULL DEFAULT '../media/image_user_default.png',
  `activo` tinyint(1) NOT NULL DEFAULT 0,
  `pendiente_aprobacion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `discografica`
--

INSERT INTO `discografica` (`id`, `nombre`, `correo`, `pass`, `foto_avatar`, `activo`, `pendiente_aprobacion`) VALUES
(0, 'Autogestionado', '', '', '../media/image_user_default.png', 0, 1),
(1, 'Universal', 'universal@gmail.com', 'universal', '../media/img_discografica/universal@gmail.com/universal@gmail.com_avatar.png', 1, 0),
(3, 'Pollos Hermanos Records', 'pollos@gmail.com', 'pollos', '../media/img_discografica/pollos@gmail.com/pollos@gmail.com_avatar.jpg', 1, 0),
(4, 'Montana Records', 'tony@tony.com', 'uni', '../media/image_user_default.png', 0, 0),
(6, 'Apple Corps', 'applecorps@gmail.com', 'apple', '../media/image_user_default.png', 1, 0),
(7, 'Sony Music', 'sony@gmail.com', 'sony', '../media/image_user_default.png', 1, 0),
(8, 'Warner Music', 'warner@gmail.com', 'warner', '../media/img_discografica/warner@gmail.com/warner@gmail.com_avatar.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estilo`
--

CREATE TABLE `estilo` (
  `id` int(2) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estilo`
--

INSERT INTO `estilo` (`id`, `nombre`) VALUES
(3, 'Avant-garde'),
(18, 'Brit Rock'),
(15, 'BSO'),
(13, 'Funk-rock'),
(12, 'Hard Rock'),
(2, 'Metal'),
(16, 'Metal progresivo'),
(1, 'Pop'),
(17, 'Rock'),
(14, 'Rock alternativo'),
(10, 'Rock progresivo'),
(4, 'Rock-pop'),
(0, 'sin estilo'),
(9, 'Thrash metal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorito`
--

CREATE TABLE `favorito` (
  `usuario` int(4) NOT NULL,
  `album` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `favorito`
--

INSERT INTO `favorito` (`usuario`, `album`) VALUES
(1, 65),
(1, 68),
(1, 69),
(1, 105),
(1, 116),
(5, 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foto_grupo`
--

CREATE TABLE `foto_grupo` (
  `id` int(4) NOT NULL,
  `enlace` varchar(100) NOT NULL,
  `grupo` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `foto_grupo`
--

INSERT INTO `foto_grupo` (`id`, `enlace`, `grupo`) VALUES
(45, '../media/img_grupos/pinkfloyd@gmail.com/pinkfloyd@gmail.comfotoextra45.webp', 19),
(52, '../media/img_grupos/meta@gm.com/meta@gm.comfotoextra52.jpg', 7),
(59, '../media/img_grupos/meta@gm.com/meta@gm.comfotoextra59.jpg', 7),
(60, '../media/img_grupos/dso@gmail.com/dso@gmail.comfotoextra60.jpg', 21),
(61, '../media/img_grupos/dso@gmail.com/dso@gmail.comfotoextra61.jpg', 21),
(62, '../media/img_grupos/pinkfloyd@gmail.com/pinkfloyd@gmail.comfotoextra62.png', 19),
(63, '../media/img_grupos/pinkfloyd@gmail.com/pinkfloyd@gmail.comfotoextra63.jpg', 19),
(66, '../media/img_grupos/tenaciousd@gmail.com/tenaciousd@gmail.comfotoextra66.jpg', 32),
(67, '../media/img_grupos/tenaciousd@gmail.com/tenaciousd@gmail.comfotoextra67.jpg', 32),
(68, '../media/img_grupos/oasis@gmail.com/oasis@gmail.comfotoextra68.jpg', 39);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foto_publicacion`
--

CREATE TABLE `foto_publicacion` (
  `id` int(4) NOT NULL,
  `enlace` varchar(100) NOT NULL,
  `publicacion` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `foto_publicacion`
--

INSERT INTO `foto_publicacion` (`id`, `enlace`, `publicacion`) VALUES
(22, '../media/img_posts/dso@gmail.com/foto1post23.jpg', 23),
(23, '../media/img_posts/radiohead@gmail.com/foto1post24.jpg', 24),
(24, '../media/img_posts/radiohead@gmail.com/foto2post24.jpg', 24),
(25, '../media/img_posts/radiohead@gmail.com/foto1post25.jpg', 25),
(27, '../media/img_posts/tenaciousd@gmail.com/foto1post27.jpg', 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `id` int(4) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `biografia` varchar(5000) DEFAULT NULL,
  `pass` varchar(20) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 0,
  `foto` varchar(500) DEFAULT NULL,
  `foto_avatar` varchar(500) NOT NULL DEFAULT '../media/image_user_default.png',
  `discografica` int(4) DEFAULT NULL,
  `pendiente_aprobacion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id`, `nombre`, `biografia`, `pass`, `correo`, `activo`, `foto`, `foto_avatar`, `discografica`, `pendiente_aprobacion`) VALUES
(0, 'sin grupo', NULL, NULL, NULL, 0, NULL, '../media/image_user_default.png', NULL, 1),
(7, 'Metallica', 'Metallica es un grupo estadounidense de thrash metal1​ originario de Los Ángeles, pero con base en San Francisco desde febrero de 1983. Fue fundado en 1981 en Los Ángeles por Lars Ulrich y James Hetfield, a los que se les unirían Dave Mustaine y Ron McGovney. Estos dos músicos fueron después sustituidos por el guitarrista Kirk Hammett y el bajista Cliff Burton respectivamente, Dave Mustaine fue despedido un año después de ingresar en la banda debido a su excesiva adicción al alcohol y su actitud violenta, siendo sustituido por Kirk Hammett (exguitarrista de Exodus).', NULL, NULL, 1, '../media/img_grupos/meta@gm.com/meta@gm.com.png', '../media/img_grupos/met@gm.com/met@gm.comavatar.jpg', 1, 0),
(11, 'Porcupine Tree', 'Porcupine Tree es una banda de rock progresivo formada en Hemel Hempstead, Reino Unido. Esta banda es el proyecto más exitoso del músico Steven Wilson y han desarrollado piezas musicales que se caracterizan por su diversidad y la calidad distintiva del sonido en sus grabaciones. Wilson, un músico autodidacta amante de diversos géneros musicales, comenzó con el proyecto a fines de la década de los 80s como una aventura musical en solitario.\r\n\r\nLa música de Porcupine Tree se engloba habitualmente dentro del rock progresivo, aunque Steven Wilson ha expresado su disconformidad con esta etiqueta: \"La música de Porcupine Tree es muy muy simple. No hay nada complejo en ella. Lo complejo está en la producción. La complejidad está en que los álbumes están firmemente construidos. Todo el trabajo consiste en crear la textura y el sonido, y hacer que suene bien. No hay nada de complicado en nuestra música en absoluto. Y por eso es por lo que no me gusta que la gente nos describa como rock progresivo. No creo que seamos una banda progresiva. Creo que sólo somos una banda de rock. Creo que lo que lleva a la gente a darnos la categoría de progresiva es la manera en la que las canciones están producidas\".\r\n\r\nSin embargo, en una entrevista en ProgArchives, Wilson explicó que el término \"rock progresivo\" está cada vez más extendido: \"Se ha convertido en un término mucho más extendido que hace cinco años\".', NULL, NULL, 1, '../media/img_grupos/Porcupine Tree_11/Porcupine Tree_11_.jpg', '../media/img_grupos/Porcupine Tree_11/Porcupine Tree_11_avatar.jpg', 1, 0),
(12, 'Queen', 'Queen es una banda británica de rock formada en 1970 en Londres, integrada por el cantante y pianista Freddie Mercury, el guitarrista Brian May, el baterista Roger Taylor y el bajista John Deacon (el cual llegaría un año después al grupo para completar la formación clásica). Sus primeros trabajos estuvieron influenciados por el rock progresivo y el hard rock, pero la banda se aventuró gradualmente en trabajos más convencionales y amigables con la radio incorporando más estilos, como arena rock y pop rock.\r\n\r\nAntes de formar Queen, May y Taylor habían tocado juntos en la banda Smile. Mercury se apegó a la banda y los animó a experimentar con técnicas escénicas y de grabación más elaboradas. Se unió en 1970 y sugirió el nombre de «Queen». Deacon fue reclutado en febrero de 1971, antes de que la banda lanzara su álbum debut homónimo en 1973. Queen apareció por primera vez en las listas de éxitos del Reino Unido con su segundo álbum, Queen II, en 1974. Sheer Heart Attack más tarde ese año y A Night at the Opera en 1975 trajeron a ellos el éxito internacional. Este último presentó «Bohemian Rhapsody», que se mantuvo en el número uno en el Reino Unido durante nueve semanas y ayudó a popularizar el formato de video musical.\r\n\r\nEl álbum de 1977 de la banda, News of the World, contenía «We Will Rock You» y «We Are the Champions», que se han convertido en himnos en los eventos deportivos. A principios de la década de 1980, Queen era una de las bandas de arena rock más importantes del mundo. «Another One Bites the Dust» de The Game (1980) se convirtió en su sencillo más vendido, mientras que su álbum recopilatorio de 1981 Greatest Hits es uno de los álbumes más vendido a nivel mundial con más de 50 millones de copias y en el Reino Unido es el álbum más vendido con más de 7 millones de copias y está certificado nueve veces platino en los EE. UU. Su actuación en el concierto Live Aid de 1985 y su concierto en Wembley Stadium en el año de 1986 están clasificadas entre las mejores de la historia del rock por varias publicaciones. En agosto de 1986, Freddie Mercury dio su última actuación con Queen en Knebworth, Inglaterra. En 1991 murió de bronconeumonía, una complicación del sida. Deacon se retiró en 1997. Desde 2004, May y Taylor han realizado giras como «Queen +», con los vocalistas Paul Rodgers y Adam Lambert.\r\n\r\n\r\nLA GENTE ES MUY PESADA CON DON\'T STOP ME NOW.', NULL, NULL, 1, '../media/img_grupos/Queen_12/Queen_12_.webp', '../media/img_grupos/Queen_12/Queen_12_foto.jpg', 3, 0),
(13, 'Genesis', 'Genesis fue un grupo de rock (pop posteriormente) británico creado en 1967 por Tony Banks, Mike Rutherford, Peter Gabriel y Anthony Phillips.\r\n\r\nTras la partida de uno de sus principales fundadores, el guitarrista y compositor Anthony Phillips (quien fue brevemente reemplazado por Mick Barnard) y tras varios cambios de bateristas, el grupo quedó conformado en su primera formación \"clásica\" (1970-1975) por Peter Gabriel (voz y flauta), Tony Banks (teclados), Mike Rutherford (bajo y guitarras), Phil Collins (batería y percusión) y Steve Hackett (guitarra líder).​ Tras la salida de Gabriel -en 1975-​ y de Hackett -en 1977- el grupo quedó reducido a un cuarteto, y posteriormente a un trío, con Collins como cantante y baterista, Rutherford como guitarrista y bajista y Banks como tecladista. A partir de la década de 1980, la música de Genesis vería un cambio fundamental de estilo, del rock progresivo hacia el pop-rock, coincidiendo con la época de mayor éxito comercial y con Phil Collins como su líder más visible.\r\n\r\nEn 1996 Phil Collins abandonó oficialmente Genesis, para centrarse en su carrera solista, y Ray Wilson fue su reemplazo como vocalista por un breve lapso de tiempo. Genesis se separó definitivamente en 1998. Sin embargo en 2007 realizaron una exitosa gira de conciertos por Europa y los Estados Unidos, llamada \"Turn It On Again\", tras la cual en varias ocasiones se ha comentado una posible vuelta a los estudios de grabación.​ En el 2020 se anunció su regreso a los escenarios con la gira \"The Last Domino?\", que además de Collins, Banks y Rutherford, incluye al bajista/guitarrista y colaborador Daryl Struemer y al hijo de Phil, Nicholas Collins en batería en reemplazo de Chester Thompson. El 26 de marzo del 2022 dieron su último concierto de la gira de despedida en la ciudad de Londres, poniendo punto final a la actividad de la banda.', 'genesis', 'genesis@genesis.com', 1, '../media/img_grupos/genesis@genesis.com/genesis@genesis.com.jpg', '../media/img_grupos/genesis@genesis.com/genesis@genesis.comavatar.jpg', 0, 0),
(15, 'Muse', 'Muse es una banda de rock británica formada en 1994, en Teignmouth, Devon. Desde su formación, sus integrantes son: Matt Bellamy (voz, guitarra, teclados), Christopher Wolstenholme (bajo, coros) y Dominic Howard (batería).\r\n\r\nTras el lanzamiento de Black Holes and Revelations, Morgan Nicholls comenzó a colaborar con la banda durante las presentaciones en vivo, haciéndose cargo de teclados, samples, de algunos coros, rara vez del bajo y últimamente de la segunda guitarra.​ La banda es conocida por sus extravagantes espectáculos en vivo, por fusionar géneros musicales como el rock alternativo, rock espacial, rock progresivo, rock sinfónico y electrónica,5​ además por los atípicos intereses de Bellamy en la conspiración global, la revolución, la astrofísica, vida extraterrestre, los fantasmas, la teología y el apocalipsis; temas que se ven reflejados en sus letras.\r\n\r\nHasta el día de hoy, Muse ha lanzado nueve álbumes de estudio: Showbiz (1999), Origin of Symmetry (2001). Absolution (2003), Black Holes and Revelations (2006), The Resistance (2009), The 2nd Law (2012), Drones (2015), Simulation Theory (2018) y Will of the People (2022).\r\nTambién han publicado tres álbumes en vivo: Hullabaloo Soundtrack (2001), el cual también contiene una compilación de lados B; HAARP (2008), que documenta las presentaciones de la banda en el Estadio de Wembley en 2007; Live at Rome Olympic Stadium (2013), una presentación de la banda ante más de 60 000 personas en Italia; Simulation Theory film filmado en agosto de 2019 en dos presentaciones en el O2 Arena, y tras un año, fue estrenado en agosto de 2020 para el cine IMAX.\r\n\r\nBlack Holes and Revelations le otorgó a Muse una nominación al Mercury Prize y un tercer lugar en la lista de sus mejores álbumes del año según la revista NME en 2006. Muse también ganó diversos premios a lo largo de su carrera, incluyendo cinco MTV Europe Music Awards, seis Q Awards, ocho NME Awards, dos Brit Awards (premio a la «mejor actuación británica en vivo»', NULL, NULL, 1, '../media/img_grupos/Muse_15/Muse_15_.jpg', '../media/img_grupos/Muse_15/Muse_15_avatar.jpg', 1, 0),
(17, 'La Sudadera Del Manager', 'La Sudadera Del Manager es un grupo de rock nacido en Motril, Granada en 2012. A lo largo de los años, su música ha ido evolucionando y pasando por distintos estilos. Está formado por Manuel Morales a la voz, Josué Díaz al bajo y coros, Alberto Herrera a la guitarra, piano y coros, Álvaro Blanco a la guitarra y Joaquín Moreno a la batería y percusión. \r\n\r\nLas primeras grabaciones reflejan un rock duro, compuesto por canciones rápidas y contundentes, incluso con mensajes reivindicativos; un estilo típico de un grupo de amigos jóvenes que se juntan para tocar. Con el paso de los años, se fue produciendo un cambio de sonido, motivado en parte por la mezcla de estilos que cada miembro aportaba, desde el rock español más clásico por parte de Josué, hasta pequeñas pinceladas de rock progresivo por parte de Álvaro, pasando incluso por el jazz introducido por Alberto, el pianista. \r\n\r\nEn abril de 2013 presentaron en el Teatro Calderón de Motril su primer trabajo autoproducido, \'No Nos Pararán\', más una serie de temas inéditos. Tras este concierto, dieron una amplia gira de verano por distintos locales de la Costa Tropical Granadina, para, a finales de ese mismo año, volver a entrar al estudio a grabar otros 4 temas bajo el título de \'Hasta Siempre\'. Tras esto, hubo un largo período de conciertos y de intensa búsqueda musical para evolucionar en su sonido, lo que les llevaría a grabar su primer disco, \'Multipolar\', con 10 temas, que verá la luz en 2019.', 'lasudadera', 'lasudadera@gmail.com', 1, '../media/img_grupos/lasudadera@gmail.com/lasudadera@gmail.com.jpg', '../media/img_grupos/lasudadera@gmail.com/lasudadera@gmail.comavatar.jpg', 0, 0),
(19, 'Pink Floyd', 'Pink Floyd es una banda de rock británica, fundada en Londres en 1965. Considerada un icono cultural del siglo XX y una de las bandas más influyentes, exitosas y aclamadas en la historia de la música popular, obtuvo gran popularidad dentro del circuito underground gracias a su música psicodélica y espacial, que con el paso del tiempo evolucionó hacia el rock progresivo y el rock sinfónico adquiriendo la popularidad con la que hoy son recordados. Es conocida por sus canciones de alto contenido filosófico, a veces de crítica política, junto a la experimentación sonora, las innovadoras portadas de sus discos y sus elaborados espectáculos en vivo. Sus ventas sobrepasan los 280 millones de álbumes vendidos en todo el mundo,​ 97,5 millones de ellos solamente en los Estados Unidos,​ convirtiéndose en una de las bandas con más ventas en la historia.\r\n\r\nInicia', 'pinkfloyd', 'pinkfloyd@gmail.com', 1, '../media/img_grupos/pinkfloyd@gmail.com/pinkfloyd@gmail.com.jpg', '../media/img_grupos/pinkfloyd@gmail.com/pinkfloyd@gmail.comavatar.jpg', 0, 0),
(20, 'Elton John', 'Elton Hercules John (nacido como Reginald Kenneth Dwight; Pinner, Middlesex, Inglaterra, 25 de marzo de 1947) es un cantautor y pianista inglés.5​6​7​ Con una carrera de más de 60 años, ha lanzado 32 álbumes de estudio y ha vendido más de 300 millones de copias en todo el mundo, siendo uno de los artistas musicales más exitosos de la historia.8​9​\r\n\r\nHa colaborado con el letrista Bernie Taupin desde 1967 y muchas de sus canciones han alcanzado la cima de las listas de éxito en el mundo. Es el único artista en mantener al menos una canción dentro del Billboard Hot 100 durante 30 años consecutivos, desde 1970 hasta 2000. Su canción «Candle in the Wind 1997», reescrita en ocasión de la muerte de Diana de Gales vendió más de 33 millones de copias y es el segundo sencillo más vendido en la historia.10​11​ Su trabajo también se ha extendido hacia la composición, la producción y, en ocasiones, la actuación.', NULL, NULL, 1, '../media/img_grupos/Elton John_20/Elton John_20_.jpg', '../media/img_grupos/Elton John_20/Elton John_20_avatar.jpg', 1, 0),
(21, 'Diablo Swing Orchestra', 'Diablo Swing Orchestra es una banda sueca de avant-garde metal que se formó en 2003. Han publicado cuatro álbumes: The Butcher\'s Ballroom (2006), Sing Along Songs for the Damned & Delirious (2009),Pandora\'s Piñata (2012), Pacifisticuffs (2017) y Swagger & Stroll Down The Rabbit Hole (2021).\r\n\r\nLa banda mezcla numerosas influencias de heavy metal, diversos subgéneros del metal (incluyendo progresivo y sinfónico), música clásica y jazz. Fue creada como un sexteto, pero se convirtió en un octeto en 2011, tras la adición de un trombón y un trompetista. To wapos.', 'dso', 'dso@gmail.com', 1, '../media/img_grupos/dso@gmail.com/dso@gmail.com.jpg', '../media/img_grupos/dso@gmail.com/dso@gmail.comavatar.jpg', 0, 0),
(22, 'The Beatles', 'The Beatles (pronunciado [ðə ˈbiːtlz]), también conocida en el mundo hispano como los Beatles, fue una banda de rock británica formada en Liverpool durante los años 1960, estando integrada desde 1962 a su separación en 1970 por John Lennon, Paul McCartney, George Harrison y Ringo Starr. Está considerada como una de las bandas más importantes del movimiento contracultural de la década de 1960 y de la historia de la música.1​2​3​4​5​6​ Enraizada en el skiffle, la música beat y el rock and roll de los años 1950, su sonido incorporaría a menudo elementos de la música clásica y del pop tradicional, entre otros, de forma innovadora en sus canciones; la banda posteriormente llegaría a trabajar con un extenso rango de estilos musicales, yendo desde las baladas y la música de India, hasta la psicodelia y el hard rock. Como pioneros en las formas de grabación, composición y presentación artística; la naturaleza de su enorme popularidad, que había emergido primeramente con la moda de la «beatlemanía», se transformó al tiempo que sus composiciones se volvieron más sofisticadas, revolucionando diversos aspectos de la industria musical y llegando a ser percibidos como la encarnación de los ideales progresistas de las juventudes de la época y sus movimientos sociales y culturales.7​\r\n\r\nLiderados por la dupla Lennon-McCartney, construirían su reputación en la escena underground de Liverpool y Hamburgo sobre un período de tres años a partir de 1960, inicialmente con Stuart Sutcliffe en el bajo. El trío central de Lennon, McCartney y Harrison, juntos desde 1958 como parte de The Quarry Men, tocarían junto a múltiples baterías (incluido Pete Best) antes de pedirle a Richard Starkey, más conocido como Ringo Starr que se les uniera en 1962. Establecidos como un grupo profesional después de que Brian Epstein les ofreciera ser su representante, y con su potencial musical mejorado por la creatividad del productor George Martin, lograrían el éxito comercial en el Reino Unido a finales de 19', NULL, NULL, 1, '../media/img_grupos/The Beatles_22/The Beatles_22_.jpg', '../media/img_grupos/The Beatles_22/The Beatles_22_avatar.webp', 6, 0),
(23, 'Foo Fighters', 'Foo Fighters es un grupo de rock estadounidense formada en la ciudad de Seattle en 1994 por el exbaterista de Nirvana, Dave Grohl.\r\n\r\nEl grupo debe su nombre a los ovnis y los diversos fenómenos aéreos que fueron reportados por los pilotos de los aviones aliados en la Segunda Guerra Mundial, que se conocen colectivamente como foo fighter. Antes del lanzamiento de su álbum debut en 1995, Grohl, como único miembro oficial, reclutó al bajista Nate Mendel y el baterista William Goldsmith, ambos anteriormente miembros de Sunny Day Real Estate, así como su compañero en las giras de Nirvana, Pat Smear como guitarrista para completar la alineación.\r\n\r\nLa banda comenzó con actuaciones en Portland, Oregón. Goldsmith renunció durante la grabación del segundo álbum del grupo, The Colour and the Shape (1997), cuando la mayoría de las partes de batería fueron regrabadas por el propio Grohl, hasta que luego se unió Taylor Hawkins como baterista. La partida de Smear siguió poco después.\r\n\r\nFue reemplazado por Franz Stahl, respectivamente, aunque fue despedido antes de la grabación del tercer álbum del grupo, There Is Nothing Left to Lose (1999). La banda continuó brevemente como trío hasta que Chris Shiflett se unió como guitarrista principal de la banda después de la finalización de There Is Nothing Left to Lose. La banda lanzó su cuarto álbum, One by One, en 2002. El grupo siguió esa versión con la de dos discos In Your Honor (2005), que se divide entre canciones acústicas y material más pesado. Pat Smear volvió a la banda en ese mismo año, y se sumó el tecladista Rami Jaffee.\r\n\r\nFoo Fighters han vendido más de 15 millones de discos en todo el mundo. Foo Fighters lanzó su sexto álbum, Echoes, Silence, Patience & Grace, en 2007. En 2010, se confirmó que Smear se había unido oficialmente a la banda después de la gira con Foo Fighters como un miembro no oficial entre 2006 y 2009. En el transcurso de la carrera de la banda, cuatro de sus álbumes han ganado el Premio Grammy al mejor á', NULL, NULL, 1, '../media/img_grupos/Foo Fighters_23/Foo Fighters_23_.jpg', '../media/img_grupos/Foo Fighters_23/Foo Fighters_23_avatar.png', 1, 0),
(24, 'Red Hot Chili Peppers', 'Red Hot Chili Peppers es una banda de rock estadounidense formada en 1983 en Los Ángeles, California. Sus integrantes son el vocalista Anthony Kiedis, el guitarrista John Frusciante, el bajista Flea y el baterista Chad Smith. El estilo musical de la banda fusiona el funk tradicional con el rock y el rock alternativo incluyendo elementos de otros géneros como el rap, pop rock, heavy metal, dance, punk, hip hop e indie rock.1​2​ Además, también suelen ser considerados los inventores del punk funk. Son considerados una de las bandas más exitosas y más influyentes del rock alternativo en su historia.\r\n\r\nAdemás de Kiedis y Flea, la formación original del grupo la completaban el baterista Jack Irons y el guitarrista Hillel Slovak. En las grabaciones de los primeros discos hubo diversos cambios en la formación, y solo en The Uplift Mofo Party Plan (1987) coincidieron los cuatro miembros fundadores en el estudio. En 1988 el guitarrista Hillel Slovak murió de una sobredosis de heroína, lo que provocó la salida de Irons del grupo.3​ Tras la llegada de Chad Smith y John Frusciante a finales de 1988 como sustitutos de Irons y Slovak, esta formación grabaría los álbumes Mother\'s Milk (1989), Blood Sugar Sex Magik (1991), Californication (1999), By the Way (2002), Stadium Arcadium (2006), Unlimited Love (2022) y Return of the Dream Canteen (2022). Mientras los Red Hot Chili Peppers estaban de gira por Japón en 1992, Frusciante dejó la banda, y no volvería hasta 1998. Dave Navarro se convirtió en su sustituto durante ese periodo, y con él lanzaron el álbum One Hot Minute (1995). Blood Sugar Sex Magik fue el gran salto al éxito internacional del grupo, siendo un referente claro de la fusión estilística que caracterizaría a la banda durante los \'90.4​ Tras el regreso de Frusciante en 1998, el cuarteto volvió a reunirse en el estudio para grabar Californication, disco que llegó a vender quince millones de copias, convirtiéndose en su álbum de más éxito comercial hasta la fecha. By th', NULL, NULL, 1, '../media/img_grupos/Red Hot Chili Peppers_24/Red Hot Chili Peppers_24_.webp', '../media/img_grupos/Red Hot Chili Peppers_24/Red Hot Chili Peppers_24_avatar.jpg', 1, 0),
(25, 'Radiohead', 'Radiohead es una banda británica de rock alternativo originaria de Abingdon-on-Thames, Inglaterra, formada en 1985 inicialmente como una banda de versiones. Está integrada por Thom Yorke (voz, guitarra, piano), Jonny Greenwood (guitarra solista, teclados, otros instrumentos), Ed O\'Brien (guitarra, segunda voz), Colin Greenwood (bajo, teclados) y Phil Selway (batería, percusión).\r\n\r\nRadiohead lanzó su primer sencillo, «Creep», en 1992. Si bien la canción fue en un comienzo un fracaso comercial, se convirtió en un éxito mundial tras el lanzamiento de su álbum debut, Pablo Honey (1993) debido al auge comercial del rock alternativo. La popularidad de Radiohead en el Reino Unido aumentó con su segundo álbum, The Bends (1995). El tercero, OK Computer (1997), con un sonido expansivo y temáticas como la alienación y la globalización, les dio fama mundial y ha sido aclamado como un disco histórico de la década de 1990 y uno de los mejores álbumes de todos los tiempos.1​2​3​4​\r\n\r\nKid A (2000) y Amnesiac (2001) significaron una evolución en su estilo musical, al incorporar música electrónica, experimental, música clásica del siglo XX, trip-hop y cool jazz. A pesar de la división inicial de fanes y crítica, Kid A fue nombrado mejor álbum de la década por Rolling Stone, Pitchfork y The Times.5​ El álbum Hail to the Thief (2003), una mezcla de rock y música electrónica con letras inspiradas en la guerra al terror, fue el último de la banda con el sello discográfico ', 'radio', 'radiohead@gmail.com', 1, '../media/img_grupos/radiohead@gmail.com/radiohead@gmail.com.webp', '../media/img_grupos/radiohead@gmail.com/radiohead@gmail.comavatar.png', 0, 0),
(27, 'Rush', 'Rush fue una banda canadiense de rock progresivo formada en 1968 en Toronto, Ontario. La formación se mantuvo estable desde 1974, cuando Neil Peart reemplazó al baterista original, John Rutsey, antes de su primera gira estadounidense. Estuvo integrada por el bajista, teclista y cantante Geddy Lee, el guitarrista Alex Lifeson y el batería y letrista Neil Peart.1​\r\n\r\nDesde el lanzamiento de su primer sencillo en 1973 y álbum debut homónimo en marzo de 1974, han sido reconocidos por su maestría musical, por sus complejas composiciones y por la ecléctica temática de sus letras, dominadas por la ciencia ficción, la fantasía, la filosofía libertaria y desarrollando también temas humanitarios, sociales, emocionales y medioambientales.2​3​\r\n\r\nMusicalmente, su estilo ha evolucionado a lo largo de los años; en sus primeros álbumes muestran una influencia del heavy metal inspirado en el blues muy semejante a los primeros trabajos hechos por Budgie. Luego incursionaron en el hard rock y rock progresivo, y tuvieron un período en el que predominó el uso de sintetizadores. Han influido a numerosos artistas y bandas, como Metallica,4​5​ The Smashing Pumpkins6​ y Primus,6​ además de bandas de metal progresivo como Queensrÿche,1​ Dream Theater4​ y Symphony X.7​\r\n\r\nEn 2004, sus ventas totales a nivel mundial se estimaron en cuarenta millones de copias.8​ Hasta 2009, la banda había vendido solo en los Estados Unidos veinticinco millones de álbumes, según la agencia de certificación RIAA, que los sitúa en su lista de artistas con más ventas,9​ y que les ha otorgado 24 discos de oro y 14 de platino, 3 de ellos de multiplatino (más de dos millones de copias vendidas) por los álbumes de estudio 2112 (1976), Moving Pictures (1981) y el recopilatorio doble Chronicles (1990).10​ Según la RIAA, son también una de las bandas en obtener más certificaciones de oro o platino consecutivas detrás de bandas como The Beatles, The Rolling Stones o Aerosmith. Desde 1974 a 2012 han editado 20 álbumes de ', NULL, NULL, 1, '../media/img_grupos/Rush_27/Rush_27_.webp', '../media/img_grupos/Rush_27/Rush_27_avatar.jpg', 3, 0),
(29, 'Avenged Sevenfold', 'Avenged Sevenfold (frecuentemente abreviado como A7X) es una banda estadounidense de heavy metal1​ originaria de Huntington Beach, California, fundada en 1999. Avenged Sevenfold comenzó como una banda de género metalcore con su álbum debut Sounding the Seventh Trumpet de 2001 y más tarde con su segundo álbum Waking The Fallen de 2003, en el que The Rev y M. Shadows utilizaron el estilo vocal screaming en muchas canciones de este álbum. La banda es principalmente conocida por la versatilidad de sus estilos musicales, sus dramáticas portadas en cada uno de sus álbumes​ y su logotipo: Deathbat.\r\n\r\nSus integrantes son M. Shadows (vocalista), Synyster Gates (guitarrista líder y coros), Zacky Vengeance (guitarrista rítmico y coros), Johnny Christ (bajista).5​ Anteriormente, el baterista y vocalista era The Rev hasta su muerte en diciembre de 2009. Asimismo, el exbaterista de Dream Theater, Mike Portnoy, entró temporalmente a Avenged Sevenfold para ayudar a sus miembros en sus próximos conciertos, incluyendo la gira Nightmare After Christmas durante el 2010 y salió de la banda el 16 de diciembre de ese mismo año tras concluirla.\r\n\r\nDespués del lanzamiento de su tercer álbum de estudio y primer éxito City of Evil de 2005, Avenged Sevenfold fue transformando su estilo hacia un género más limpio y sin gritos. Posteriormente lanzaron el DVD All Excess que cuenta la historia de la banda desde su formación hasta 2007. En julio de 2010 publicaron su quinto álbum de estudio titulado Nightmare que debutó en la posición #1 en la cartelera Billboard 200.​ Este fue el último álbum de la banda con su fundador The Rev, ya que sus grabaciones vocales fueron incluidas,​ mientras que sus demos en la batería fueron reproducidos en esencia por Mike Portnoy.​ El 11 de abril de 2011 la banda ganó el premio al mejor grupo en directo en el festival Revolver Golden Gods9​ El 26 de agosto de 2013 lanzaron Hail to the King​ que marcó el debut del baterista Arin Ilejay y también el segundo logro con', NULL, NULL, 1, '../media/img_grupos/Avenged Sevenfold_29/Avenged Sevenfold_29_.jpg', '../media/img_grupos/Avenged Sevenfold_29/Avenged Sevenfold_29_avatar.jpg', 3, 0),
(30, 'Phil Collins', 'Philip David Charles Collins (Chiswick, Middlesex, Inglaterra; 30 de enero de 1951),2​ conocido por su nombre artístico Phil Collins, es un baterista, cantante, compositor, productor y actor británico, y uno de los artistas de mayor éxito de la música rock. Fue nombrado teniente de la Real Orden Victoriana (LVO).\r\n\r\nEntre 1984 y 1989 Phil Collins ha liderado la lista de éxitos estadounidense Billboard Top 100 como cantante en ocho ocasiones, siete como solista y una con Genesis, banda de la que fue miembro entre 1970 y 1996.\r\n\r\nTras la salida de Peter Gabriel en 1975 se convirtió en el cantante solista del grupo, con el que ha tenido alguna colaboración esporádica desde 2007.\r\n\r\nSus canciones a menudo tratan de amores perdidos, temas personales y sobre el problema mundial de la pobreza y el consumo de drogas. Según datos de Atlantic Records (de 2002) las ventas correspondientes a su carrera en solitario han alcanzado los 150 millones de discos en todo el mundo.3​ Collins ha ganado numerosos premios musicales a lo largo de toda su carrera, incluyendo siete Premios Grammy, cinco Premios Brit, entre ellos mejor artista británico en tres ocasiones, un Premio de la Academia y dos Globo de Oro por su trabajo en bandas sonoras.4​5​\r\n\r\nCollins es uno de los tres artistas pop, junto con Paul McCartney y Michael Jackson, que han vendido más de 100 millones de álbumes en todo el mundo tanto en su carrera en solitario como formando parte de una banda. Contando su trabajo con Genesis, sus contribuciones con otros artistas, y su exitosa carrera en solitario, Collins obtuvo más de cuarenta éxitos que encabezaron la lista del «Billboard Hot 100» durante la década de 1980.6​\r\n\r\nEn 2008 Collins ocupó el puesto número 22 en la lista de «Los 100 mejores artistas de todos los tiempos según el Billboard Hot 100».7​ Fue incluido en el Salón de la Fama del Rock como miembro de Genesis en 2010.\r\n\r\nEl 7 de marzo de 2011 se hizo pública su retirada del mundo musical por problemas de salud y por no sentir', NULL, NULL, 1, '../media/img_grupos/Phil Collins_30/Phil Collins_30_.jpg', '../media/img_grupos/Phil Collins_30/Phil Collins_30_avatar.jpg', 3, 0),
(31, 'Gustavo Santaolalla', 'Gustavo Alfredo Santaolalla (El Palomar, Buenos Aires; 19 de agosto de 1951) es un compositor, músico y productor musical argentino ganador en dos ocasiones consecutivas del Premio Óscar a la mejor banda sonora original en 2005 y 2006 por las películas Brokeback Mountain y Babel respectivamente.\r\n\r\nTrabajó en la casa de la cultura en Ciudad Bolívar, Venezuela, hasta finales de 2022 donde combinó música rock, folk, pop, new wave, ritmos africanos y folklore, entre otros. En los años setenta, lideró Arco Iris, banda pionera del rock nacional argentino en fusionar música popular latinoamericana con rock.\r\n\r\nEn los años noventa, su producción con diversos artistas fue clave en el boom del rock latinoamericano de la época.\r\n\r\nComo músico, su álbum Santaolalla (1982) fue elegido en el puesto 86 de los 100 mejores álbumes de rock argentino por la Rolling Stone Argentina en 2007,​ y su canción «Empujando tinta» (1995) fue elegida en el puesto 487° de las 500 mejores canciones del rock iberoamericano por la revista estadounidense Al Borde en 2006.\r\n\r\nEncima el tío ha compuesto la banda sonora de The Last Of Us. Es un absoluto maestro.', NULL, NULL, 1, '../media/img_grupos/Gustavo Santaolalla_31/Gustavo Santaolalla_31_.jpg', '../media/img_grupos/Gustavo Santaolalla_31/Gustavo Santaolalla_31_avatar.jpg', 7, 0),
(32, 'Tenacious D', 'This band asked me not to write this but... goddammit, I\'m going to write it anyway, because I fucking know it, and it\'s the truth.\r\n\r\nI FUCKING LOVE THIS BAND, THEY ARE THE BEST BAND EVER. PERIOD. LADIES AND GENTLEMEN....\r\n\r\n                                                                                  TENACIOUS D!!!!!!!!', 'tenacious', 'tenaciousd@gmail.com', 1, '../media/img_grupos/tenaciousd@gmail.com/tenaciousd@gmail.com.png', '../media/img_grupos/tenaciousd@gmail.com/tenaciousd@gmail.comavatar.jpg', 0, 0),
(36, 'Guns N Roses', 'Guns N\' Roses es una banda estadounidense de hard rock formada en Hollywood, Los Ángeles en la zona de Sunset Strip, en 1985. El grupo musical fue fundado por el vocalista Axl Rose y el guitarrista Izzy Stradlin.6​7​\r\n\r\nEs una de las bandas de rock más exitosas de todos los tiempos, habiendo vendido más de cien millones de discos, es considerada icono global de la música y forma parte del prestigioso Salón de la Fama del Rock and Roll. Asimismo, la banda es uno de los números artísticos con más galardones, legado y repercusión mundial hasta la fecha. También Guns N\' Roses es considerada por muchos como una de las bandas más influyentes de la historia debido a su gran legado musical.1​8​9​10​\r\n\r\nDe igual forma en el año 2011 fueron posicionados en el puesto 21 en la lista de \"los 100 mejores artistas de la historia\",11​ elaborada por la revista Rolling Stone en conjunto con diversos productores y críticos musicales especializados.8​9​10​\r\n\r\nLa formación actual cuenta con el vocalista Axl Rose, el guitarrista rítmico Richard Fortus, los tecladistas Dizzy Reed y Melissa Reese, el baterista Frank Ferrer, el bajista Duff McKagan y el guitarrista líder Slash. Estos dos últimos son considerados miembros clásicos de la agrupación y luego de una ausencia de 23 años, retomaron su lugar en la banda.\r\n\r\nLa banda ha vendido más de 150 millones de álbumes en todo el mundo,12​13​ incluyendo más de 60 millones de álbumes solo en los Estados Unidos,14​ lo que los posiciona en el puesto n°18 en la lista de los artistas con más ventas y éxito de todos los tiempos. Su álbum de estudio debut Appetite for Destruction de 1987 ha vendido más de 35 millones de copias a nivel mundial y alcanzó el número 1 en el Billboard 200 en Estados Unidos. Además, cuatro canciones del álbum ingresaron en el Top 10 en la Billboard Hot 100, y «Sweet Child o\' Mine» quedó en el ', NULL, NULL, 1, '../media/img_grupos/Guns N Roses_36/Guns N Roses_36_.webp', '../media/img_grupos/Guns N Roses_36/Guns N Roses_36_avatar.jpg', 8, 0),
(37, 'Justin Hurwitz', 'Justin Hurwitz (Condado de Los Ángeles, California, 22 de enero de 1985) es un compositor y guionista estadounidense, conocido por sus colaboraciones con el guionista y director Damien Chazelle en las películas Whiplash (2014) y La La Land (2016), además de Babylon (2022)​ Hurwitz es un crack y me hace llorar. Cabrón.', NULL, NULL, 1, '../media/img_grupos/Justin Hurwitz_37/Justin Hurwitz_37_.jpg', '../media/img_grupos/Justin Hurwitz_37/Justin Hurwitz_37_avatar.jpg', 8, 0),
(38, 'Dream Theater', 'Dream Theater es una banda estadounidense de metal progresivo, formada en 1985 con el nombre de Majesty por Mike Portnoy, John Myung y John Petrucci durante su estadía en el Berklee College of Music de Massachusetts. Poco a poco, fueron dejando sus estudios para dedicar más atención a la banda que terminaría llamándose Dream Theater. A pesar de que se sucedieron algunos cambios en la formación inicial, los tres miembros originales permanecieron junto a James LaBrie y Jordan Rudess hasta el 8 de septiembre de 2010, cuando Portnoy abandonó el grupo. En octubre de ese mismo año, la banda organizó unas audiciones para el reemplazo del puesto de batería. El 29 de abril de 2011 se reveló que Mike Mangini sería el nuevo baterista permanente del grupo.\r\n\r\nLa banda es conocida por el virtuosismo técnico de sus instrumentistas, quienes han ganado numerosos premios a lo largo de su carrera. John Petrucci ha sido elegido como el tercer guitarrista de la gira G3 en seis ocasiones, más que ningún otro invitado. En 2009 fue también nombrado el segundo mejor guitarrista de metal por Joel McIver en su libro «The 100 Greatest Metal Guitarists», así como uno de los «10 mejores guitarristas de shred de toda la historia» por la revista GuitarOne.5​ El exbaterista Mike Portnoy ha ganado 23 premios de la revista Modern Drummer y fue la persona más joven (con 37 años) en ser incluida en el Rock Drummer Hall of Fame. Por su parte, su sustituto, Mike Mangini, tiene en su haber 5 récords en el World\'s Fastest Drummer Extreme Sport Drumming, que lo acreditan como el baterista más rápido del mundo.6​ En una encuesta dirigida por el sitio de música especializado MusicRadar entre agosto y septiembre de 2010, John Myung fue elegido como el mejor bajista de todos los tiempos. Por su parte, los usuarios de la misma web eligieron a Jordan Rudess como el mejor teclista de la historia.7​ Además, Rudess obtuvo en 1994 el galardón de Best New Talent («mejor talento nuevo») de la revista especializada Keyboard Magazine y se le califica como una leyenda en los teclados.8​ La banda fue, asimismo, incluida en el Long Island Music Hall of Fame en 2010.9​\r\n\r\nEl álbum más vendido de la banda es Images and Words, de 1992, que obtuvo un disco de oro y alcanzó el número 61 en la cartelera Billboard 200.10​ Tanto su disco de 1994, Awake, como el de 2002, Six Degrees of Inner Turbulence, entraron también en las listas en los puestos 32 y 46 respectivamente, y recibieron críticas mayoritariamente positivas. Por otro lado, Six Degrees of Inner Turbulence hizo que Dream Theater fuese elegida como banda inicial para la sección musical de Entertainment Weekly durante la semana de su publicación, a pesar de que la revista suele decantarse por música mainstream. En 2007 Systematic Chaos entró en la lista Billboard estadounidense en el puesto 19.10​ Hasta 2008 Dream Theater había vendido más de 2,1 millones de copias en Estados Unidos y, hasta 2011, más de 12 millones en todo el mundo.11​', 'dreamt', 'dreamt@gmail.com', 1, '../media/img_grupos/dreamt@gmail.com/dreamt@gmail.com.jpg', '../media/img_grupos/dreamt@gmail.com/dreamt@gmail.comavatar.jpg', 0, 0),
(39, 'Oasis', 'Oasis fue una banda inglesa de rock alternativo, formada en Mánchester en 1990. En sus inicios, conocidos como Rain (Español: La Lluvia), el grupo contaba en sus filas con el cantante Chris Hutton, el guitarrista Paul Arthurs, el bajista Paul McGuigan y el baterista Daniel Alexander, a los que más tarde se unirían, en 1991, Liam Gallagher en la voz y Tony McCarroll como batería. El último en unírseles fue el hermano mayor de Liam, Noel Gallagher (a petición de su hermano) quien obtuvo el papel de compositor principal, guitarrista principal y cantante secundario.\r\n\r\nDebido a las 15 millones de copias vendidas de su álbum debut Definitely Maybe, a las 30 millones de copias vendidas de su segundo álbum (What\'s the Story) Morning Glory?1​ y al hecho de que su tercer álbum Be Here Now se convirtiera en el disco más rápidamente vendido en la historia del Reino Unido con 520 000 copias vendidas tan solo el día de su puesta a la venta, Oasis ha sido considerado como uno de los grupos musicales más importantes en la historia musical de Reino Unido, habiendo entrado en varias ocasiones en el Libro Guinness de los récords (actualmente siguen teniendo uno de ellos en su haber). Publicaron 33 singles, de los cuales 9 alcanzaron el puesto n.º 1 de las listas británicas y 2 el puesto n.º 1 de las listas estadounidenses.2​\r\n\r\nLos hermanos Gallagher fueron los líderes y compositores de la banda. Vendieron más de 100 millones de copias a nivel mundial3​ y, hasta antes de la separación de la banda, Liam Gallagher era el único miembro original que había permanecido en él hasta que su hermano disuelve Oasis. Los hermanos Gallagher fueron también reconocidos por sus constantes peleas entre sí y con otros grupos y artistas, como Blur y Robbie Williams, las cuales propiciaron su aparición en múltiples ocasiones en la prensa sensacionalista.4​ Tras la deserción de Paul Arthurs, Paul McGuigan, y más tarde la salida de Alan White, la alineación final se completaría con el guitarrista Gem Archer, el bajista Andy Bell y el baterista Chris Sharrock, aunque finalmente el último miembro en abandonar el grupo, ocasionando así su disolución, fue Noel Gallagher.5​', 'oasis', 'oasis@gmail.com', 1, '../media/img_grupos/oasis@gmail.com/oasis@gmail.com.jpg', '../media/img_grupos/oasis@gmail.com/oasis@gmail.comavatar.jpg', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incluye`
--

CREATE TABLE `incluye` (
  `album` int(4) DEFAULT NULL,
  `cancion` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `incluye`
--

INSERT INTO `incluye` (`album`, `cancion`) VALUES
(22, 33),
(22, 34),
(22, 35),
(22, 36),
(22, 37),
(22, 38),
(22, 39),
(22, 40),
(24, 50),
(24, 51),
(24, 52),
(24, 53),
(24, 54),
(24, 55),
(24, 56),
(24, 57),
(24, 58),
(29, 82),
(29, 83),
(30, 84),
(30, 85),
(30, 86),
(30, 87),
(30, 88),
(30, 89),
(30, 90),
(30, 91),
(30, 92),
(30, 93),
(31, 94),
(31, 95),
(31, 96),
(31, 97),
(31, 98),
(31, 99),
(31, 100),
(31, 101),
(36, 102),
(36, 103),
(36, 104),
(36, 105),
(36, 106),
(36, 107),
(36, 108),
(36, 109),
(36, 110),
(36, 111),
(36, 112),
(36, 113),
(36, 114),
(39, 121),
(39, 122),
(39, 123),
(39, 124),
(39, 125),
(42, 128),
(42, 129),
(42, 130),
(42, 131),
(42, 132),
(42, 133),
(42, 134),
(42, 135),
(42, 136),
(42, 137),
(42, 138),
(42, 139),
(42, 140),
(42, 141),
(42, 142),
(42, 143),
(42, 144),
(44, 146),
(44, 147),
(44, 148),
(44, 149),
(44, 150),
(44, 151),
(44, 152),
(44, 153),
(44, 154),
(44, 155),
(49, 157),
(49, 158),
(49, 159),
(49, 160),
(49, 161),
(49, 162),
(49, 163),
(49, 164),
(49, 165),
(49, 166),
(49, 167),
(49, 168),
(50, 169),
(50, 170),
(50, 171),
(50, 172),
(50, 173),
(50, 174),
(50, 175),
(50, 176),
(50, 177),
(50, 178),
(50, 179),
(50, 180),
(50, 181),
(54, 185),
(54, 186),
(54, 187),
(54, 188),
(54, 189),
(54, 190),
(54, 191),
(54, 192),
(54, 193),
(54, 194),
(54, 195),
(54, 196),
(54, 197),
(54, 198),
(54, 199),
(54, 200),
(54, 201),
(55, 202),
(55, 203),
(55, 204),
(55, 205),
(55, 206),
(55, 207),
(55, 208),
(55, 209),
(55, 210),
(55, 211),
(55, 212),
(55, 213),
(60, 244),
(60, 245),
(60, 246),
(60, 247),
(60, 248),
(60, 249),
(60, 250),
(60, 251),
(60, 252),
(60, 253),
(60, 254),
(60, 255),
(60, 256),
(60, 257),
(61, 258),
(61, 259),
(61, 260),
(61, 261),
(61, 262),
(61, 263),
(61, 264),
(61, 265),
(61, 266),
(61, 267),
(61, 268),
(62, 269),
(62, 270),
(62, 271),
(62, 272),
(62, 273),
(62, 274),
(62, 275),
(62, 276),
(62, 277),
(62, 278),
(62, 279),
(62, 280),
(62, 281),
(62, 282),
(65, 331),
(65, 332),
(65, 333),
(65, 334),
(65, 335),
(65, 336),
(65, 337),
(65, 338),
(65, 339),
(65, 340),
(65, 341),
(65, 342),
(65, 343),
(65, 344),
(65, 345),
(65, 346),
(65, 347),
(65, 348),
(65, 349),
(65, 350),
(65, 351),
(65, 352),
(65, 353),
(65, 354),
(65, 355),
(65, 356),
(65, 357),
(65, 358),
(66, 359),
(66, 360),
(66, 361),
(66, 362),
(66, 363),
(66, 364),
(66, 365),
(66, 366),
(66, 367),
(66, 368),
(66, 369),
(66, 370),
(67, 34),
(67, 37),
(67, 51),
(67, 50),
(67, 53),
(67, 162),
(68, 371),
(68, 372),
(68, 373),
(68, 374),
(68, 375),
(68, 376),
(68, 377),
(68, 378),
(68, 379),
(68, 380),
(69, 381),
(69, 382),
(69, 383),
(69, 384),
(69, 385),
(69, 386),
(69, 387),
(69, 388),
(69, 389),
(69, 390),
(69, 391),
(70, 392),
(70, 393),
(70, 394),
(70, 395),
(70, 396),
(70, 397),
(70, 398),
(70, 399),
(70, 400),
(70, 401),
(70, 402),
(70, 403),
(70, 404),
(70, 405),
(71, 406),
(71, 407),
(71, 408),
(71, 409),
(71, 410),
(71, 411),
(71, 412),
(71, 413),
(71, 414),
(71, 415),
(71, 416),
(71, 417),
(103, 526),
(103, 527),
(103, 528),
(103, 529),
(103, 530),
(103, 531),
(103, 532),
(103, 533),
(103, 534),
(103, 535),
(103, 536),
(103, 537),
(103, 538),
(103, 539),
(103, 540),
(103, 541),
(103, 542),
(103, 543),
(103, 544),
(103, 545),
(103, 546),
(103, 547),
(104, 548),
(104, 549),
(104, 550),
(104, 551),
(104, 552),
(104, 553),
(104, 554),
(104, 555),
(104, 556),
(104, 557),
(105, 558),
(105, 559),
(105, 560),
(105, 561),
(105, 562),
(105, 563),
(105, 564),
(105, 565),
(105, 566),
(105, 567),
(105, 568),
(105, 569),
(105, 570),
(105, 571),
(106, 572),
(106, 573),
(106, 574),
(106, 575),
(106, 576),
(106, 577),
(106, 578),
(106, 579),
(106, 580),
(106, 581),
(106, 582),
(106, 583),
(106, 584),
(106, 585),
(108, 586),
(108, 587),
(108, 588),
(108, 589),
(108, 590),
(108, 591),
(108, 592),
(108, 593),
(108, 594),
(108, 595),
(108, 596),
(108, 597),
(108, 598),
(108, 599),
(108, 600),
(111, 617),
(111, 618),
(111, 619),
(111, 620),
(111, 621),
(111, 622),
(111, 623),
(111, 624),
(112, 625),
(112, 626),
(112, 627),
(112, 628),
(112, 629),
(112, 630),
(112, 631),
(112, 632),
(112, 633),
(112, 634),
(112, 635),
(112, 636),
(112, 637),
(112, 638),
(112, 639),
(112, 640),
(113, 641),
(113, 642),
(113, 643),
(113, 644),
(113, 645),
(113, 646),
(113, 647),
(113, 648),
(113, 649),
(113, 650),
(113, 651),
(113, 652),
(113, 653),
(113, 654),
(114, 655),
(114, 656),
(114, 657),
(114, 658),
(114, 659),
(114, 660),
(114, 661),
(114, 662),
(114, 663),
(114, 664),
(114, 665),
(114, 666),
(114, 667),
(114, 668),
(114, 669),
(115, 670),
(115, 671),
(115, 672),
(115, 673),
(115, 674),
(115, 675),
(115, 676),
(115, 677),
(115, 678),
(115, 679),
(115, 680),
(115, 681),
(115, 682),
(115, 683),
(115, 684),
(115, 685),
(115, 686),
(115, 687),
(115, 688),
(116, 689),
(116, 690),
(116, 691),
(116, 692),
(116, 693),
(116, 694),
(116, 695),
(117, 696),
(117, 697),
(117, 698),
(117, 699),
(117, 700),
(117, 701),
(117, 702),
(118, 703),
(118, 704),
(118, 705),
(118, 706),
(118, 707),
(118, 708),
(118, 709),
(118, 710),
(119, 711),
(119, 712),
(119, 713),
(119, 714),
(119, 715),
(119, 716),
(119, 717),
(119, 718),
(124, 735),
(124, 736),
(124, 737),
(124, 738),
(124, 739),
(124, 740),
(124, 741),
(124, 742),
(124, 743),
(124, 744),
(125, 745),
(125, 746),
(125, 747),
(125, 748),
(125, 749),
(125, 750),
(125, 751),
(125, 752),
(125, 753),
(125, 754),
(125, 755),
(125, 756),
(126, 757),
(127, 83),
(127, 755),
(127, 745),
(127, 738),
(127, 746),
(133, 769),
(133, 770),
(133, 771),
(133, 772),
(134, 105),
(134, 108),
(134, 169),
(134, 171);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista`
--

CREATE TABLE `lista` (
  `id` int(4) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `usuario` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lista`
--

INSERT INTO `lista` (`id`, `nombre`, `foto`, `fecha_creacion`, `usuario`) VALUES
(12, 'Mornings', '../media/img_users/cydonia8/cydonia8lista.webp', '2023-05-16', 1),
(13, 'Awachupin', '../media/img_users/cydonia8/cydonia8lista13.jpeg', '2023-05-16', 1),
(53, 'Across the sky', '../media/img_users/cydonia8/cydonia8lista3.webp', '2023-06-08', 1),
(56, 'songs for painting', '../media/img_users/painteater/painteaterlista1.webp', '2023-06-11', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `id` int(4) NOT NULL,
  `contenido` varchar(500) NOT NULL,
  `fecha` date DEFAULT NULL,
  `grupo` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_promotores`
--

CREATE TABLE `mensajes_promotores` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promotores`
--

CREATE TABLE `promotores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion`
--

CREATE TABLE `publicacion` (
  `id` int(4) NOT NULL,
  `contenido` varchar(5000) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `fecha` date DEFAULT NULL,
  `grupo` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicacion`
--

INSERT INTO `publicacion` (`id`, `contenido`, `foto`, `titulo`, `fecha`, `grupo`) VALUES
(19, 'Confirmada la gira de Diablo Swing Orchestra para el próximo mes de noviembre.\r\n\r\nUna gira de la banda sueca Diablo Swing Orchestra, una referencia por su originalidad del Avant-garde Metal mundial. Diablo Swing Orchesta  mezcla numerosas influencias del Heavy Metal así como diversos subgéneros del metal y música clásica y jazz.\r\n\r\nLas fechas de la Gira de Diablo Swing Orchestra son:\r\n\r\n16/11/2023 – Sala Boveda (Barcelona)\r\n17/11/2023- The Bassement Club (Madrid)\r\n18/11/2023- Sala Rebullón (Mos)\r\n19/11/2023- Zorrotzako Gaztetxea (Bilbao)\r\nLas entradas de Barcelona, Madrid y Bilbao están a la venta en Metaltrip.com.', '../media/img_posts/dso@gmail.com/fotoPrincipalpost19.jpg', 'Confirmada la Gira de Diablo Swing Orchestra en España', '2023-05-24', 21),
(22, 'Uno de los lanzamientos más esperados ha tenido lugar estos últimos días. Se trata de la remezcla del álbum “Animals” de Pink Floyd, un disco que siguió a los emblemáticos “The dark side of the moon” y “Wish you were here” que vio la luz allá por enero de 1977.\r\n\r\nPor fin tenemos en 2022 la publicación de la remezcla de este álbum que se realizó en 2018 y que estaba paralizada por la negativa de David Gilmour (guitarra) a su publicación, al no estar de acuerdo con las notas escritas por Mark Blake que iban a aparecer en el libreto de este lanzamiento.\r\n\r\nSobre las notas en cuestión, Gilmour no manifestó que fueran falsas, si bien, prefería que los hechos que reflejaban se mantuvieran en secreto. La réplica de Roger Waters a la negativa de Gilmour, al no permitírsele publicarla en la web de Pink Floyd , la hizo a través de su propia web. El texto de la controversia lo podéis leer en este enlace https://rogerwaters.com/animals-new-mix-update/.\r\n\r\n“Animals” se ha reeditado posteriormente varias veces, incluso en 2016 contó con la remasterización de James Guthrie, Joel Plante y Bernie Grudman, tirando de las grabaciones analógicas originales, donde pudieron conseguir cierta mejoría en el sonido.\r\n\r\nPero el trío de remezcladores lejos de estar conformes con ese trabajo, perseveró llegando a esta remezcla de 2018, donde se percibe una diferencia más que notable respecto de la grabación inicial. Ahora después de 4 años podemos disfrutar de ella, sin el texto de la discordia, que en el fondo, es lo que menos importa.\r\n\r\nEn el Remix 2018, los instrumentos suenan más limpios y más naturales, llegando a conseguir una excelente producción, nada que ver con la primera grabación editada. Esto sitúa a este disco al nivel sonoro que se merece. Probablemente, prestando atención en esta versión, escucharás cosas que no habías oído nunca. No es necesario llegar a la grabación en 5.1 que también se ofrece en algunos formatos de este lanzamiento, para darse cuenta de la excelencia que supone esta entrega respecto de su original.', '../media/img_posts/pinkfloyd@gmail.com/fotoPrincipalpost22.jpg', 'Pink Floyd lanza el remix de su legendario disco Animals', '2023-11-02', 24),
(23, 'Diablo Swing Orchestra ha anunciado de manera oficial y a través de sus redes sociales el lanzamiento de su nuevo disco, «Swagger & Stroll Down The Rabbit Hole» para la primavera del 2021. La portada fue realizada por Sebastian Kowoll.\r\n\r\nTracklist y portada de «Swagger & Stroll Down The Rabbit Hole»\r\n1. “Sightseeing In The Apocalypse”\r\n2. “War Painted Valentine”\r\n3. “Celebremos Lo Inevitable”\r\n4. “Speed Dating An Arsonist”\r\n5. “Jig Of The Century”\r\n6. “The Sound Of An Unconditional Surrender”\r\n7. “Malign Monologues”\r\n8. “Out Came The Hummingbirds”\r\n9. “Snake Oil Baptism”\r\n10. “Les Invulnéables”\r\n11. “Saluting The Reckoning”\r\n12. “The Prima Donna Gauntlet”\r\n13. “Overture To A Ceasefire”', '../media/img_posts/dso@gmail.com/fotoPrincipalpost23.jpg', 'Diablo Swing Orchestra revela detalles de su nuevo álbum «Swagger & Stroll Down The Rabbit Hole»', '2023-08-12', 21),
(24, 'Los enmascarados Imperial Triumphant nos han sorprendido con una peculiar versión de ‘Paranoid Android’, el clásico de OK Computer de Radiohead. El vídeo animado que lo acompaña inspirado en Metropolis de Fritz Lang es igual de alucinante.\r\n\r\n«Somos grandes admiradores de Radiohead y su manera de trabajar», ha comentado el vocalista y guitarrista Zachary Ezrin. «Creemos que Radiohead tienen un enfoque diverso y único para la creación de canciones y el lirismo que siempre nos ha atraído, y la canción ‘Paranoid Android’ presenta un lienzo perfecto para que juguemos y creemos… Fue un placer reinterpretando este gran clásico del rock, y esperamos que lo encontréis inmensamente placentero».', '../media/img_posts/radiohead@gmail.com/fotoPrincipalpost24.webp', 'Imperial Triumphant comparten una versión de ‘Paranoid Androdid’ de Radiohead', '2023-07-12', 25),
(25, 'En el año 1993, una parte importante de la juventud occidental no estaba muy animada. La música grunge todavía sonaba a todo volumen en las habitaciones de adolescentes vestidos con camisas de cuadros y pelo desordenado que vivían sumidos en la angustia y la desesperanza. Toda esa energía se tradujo en una buena lista de álbumes en la que, además de clásicos como el In Utero de Nirvana o el Siamese Dream de Smashing Pumpkins, se encuentra el Pablo Honey de Radiohead. Fue el disco con el que se dieron a conocer, y también el que, contra todo pronóstico, les llevó al estrellato hace justo treinta años gracias a un tema que todo el mundo conoce: Creep.\n\nSin embargo, tuvo que pasar un tiempo entre su aparición en la escena y los conciertos a rebosar a lo largo del mundo. Porque ese primer disco, que poco tiene que ver con sus sucesores, no tuvo un éxito fulgurante. “Todo fue mucho más lento de lo que da la sensación”, dice Joan S. Luna, jefe de redacción de Mondosonoro, a este periódico. Era su primer álbum y contenía un hit pero, en aquel momento, “nadie hablaba del gran grupo que iba a cambiar la historia del pop rock del Reino Unido y todo lo que llegaría después. Fundamentalmente porque con aquel disco no iban a conseguirlo. Se les vio como una suerte de réplica británica de la fórmula Pixies/Nirvana, aderezado con un sonido más pulido a lo U2 de los primeros tiempos”, sostiene.', '../media/img_posts/radiohead@gmail.com/fotoPrincipalpost25.jpg', 'Radiohead, 30 años siendo los raros de la clase', '2023-06-07', 25),
(26, 'La Sudadera del Manager anuncia que tocará el próximo sábado 17 de junio a partir de las 10 de la noche en la Sala Partium, situada en la calle Melchor Almagro nº4 en Granada.\r\n\r\nA continuación os dejamos una lista de las personas que tienen pase VIP para el concierto:\r\n\r\nInmaculada Montejano Seco\r\nAitor Fernández Arguiñano \r\nMiguel Manzano.\r\n\r\nEntrada prohibida a:\r\n\r\nJosé María Escalera\r\n', '../media/img_posts/lasudadera@gmail.com/fotoPrincipalpost26.jpg', 'La Sudadera Del Manager anuncia concierto el 17 de junio en el Pub Partium', '2023-06-13', 17),
(27, 'Tenacious D ha publicado un videoclip para estrenar su versión de “Wicked Game”, clásico lanzado por Chris Isaak en 1990 y popularizado también por HIM en 1997.\r\n\r\nPor supuesto, Tenacious D nos tiene que hacer reír de alguna forma y, por eso, han parodiado el estilo de los videoclips de Isaak, que llegaron a ser reconocidos como algunos de los más sexys jamás grabados. Por eso, Jack Black y Kyle Gass, bien fofisanos, nos muestran, corriendo a cámara lenta por la playa, que ellos también pueden deleitarnos con su imagen. En el videolcip original, Isaak aparecía en la playa junto a la modelo Helena Christensen.', '../media/img_posts/tenaciousd@gmail.com/fotoPrincipalpost27.jpg', 'Tenacious D publica una gloriosa versión de “Wicked Game”', '2023-06-12', 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibe`
--

CREATE TABLE `recibe` (
  `usuario` int(4) NOT NULL,
  `mensaje` int(4) NOT NULL,
  `estado` tinyint(1) DEFAULT 0 CHECK (`estado` >= 0 and `estado` <= 1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseña`
--

CREATE TABLE `reseña` (
  `id` int(4) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `contenido` varchar(3000) NOT NULL,
  `fecha` date DEFAULT NULL,
  `usuario` int(4) DEFAULT NULL,
  `album` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reseña`
--

INSERT INTO `reseña` (`id`, `titulo`, `contenido`, `fecha`, `usuario`, `album`) VALUES
(2, 'El disco más influyente de mi vida', 'no veas los temazos que se marcan aquí los colegas. no hay disonancia ludonarrativa', '2023-05-17', 5, 42),
(3, 'Este disco lo hice yo. ', 'Pues el mejor de la historia. Qué voy a decir si lo hice yo. Ah, si lo escuchas, lo pagas. Venga, apoquina.', '2023-05-03', 6, 42),
(11, 'Riff rápidos', 'Aquí los solos están mejor. Ensayen más, coño.', '2023-05-20', 5, 22),
(12, 'Canciones de calidad', 'Y esa sale en stranger things foo to wapo', '2023-05-23', 1, 22),
(13, 'No es mi estilo pero mola', 'Yo la verdad es que no soy mucho de metal, me va más la madera, pero aún así está guay. Jefe tráete otro botellín de cerveza, que este me lo has traído pinchado.', '2023-05-23', 6, 22),
(14, 'Pero qué locura es esta', 'tROMPETAs y de to madr e mía esta peña maneja', '2023-05-24', 5, 36),
(21, 'Como que 28 canciones', 'PEro como que 28 canciones primos, que eso son 2 horas y pico, el disco está to guapo pero muchas canciones, no me caben tantas en el mp3.', '2023-05-26', 1, 65),
(23, 'to raro', 'esta peña es rara, mola', '2023-05-30', 1, 66),
(24, 'Wasting Light: Una patada en la cabeza a los puristas', 'Pocos discos de rock alternativo suenan tan contundentes como «Wasting Light». Solo hace falta reproducir unos segundos del primer tema del álbum – «Burning Bridges» – o de ‘White Limo’ para darse cuenta que los Foos han conseguido dar una patada en los mismísimos a todos sus detractores. El fichaje de Smear ha añadido un toque de extrema agresividad al conjunto de un sonido que sitúa a las baquetas de un furioso Taylor Hawkins en el eje del huracán. Pese a que no existe ningún single tan claro como ‘Times Like These’ o ‘My Hero’, el nivel medio de todos los temas del trabajo está muy por encima del 99% de los discos que se suelen editar cada año. Esto, se quiera o no, es algo extremadamente elogiable para un grupo que está cerca de cumplir los 20 años en activo.  «Wasting Light» no posee la diversidad de «One By One» o «There Is Nothing Left To Lose», pero aún y así cada uno de sus temas tienen unos matices que los diferencian del resto. Los hay de divertidos (‘Back & Forth’, ‘These Days’), rabiosos (‘White Limo’, ‘Miss The Misery’), melancólicos (‘I Should Have Know, la pieza donde colabora Novoselic) y sónicos (‘Matter Of Time’). Todos los temas rallan a un nivel excelente, pero si nos tuviésemos quedar con alguno nos quedaríamos, subjetivamente, con ‘Walk’. Esta pieza es un medio tiempo ejemplar que crece segundo a segundo y que estalla al final con un Grohl de lo más desgarrador.  «Echoes, Silence, Patience And Grace» nos gustó pero «Wasting Light» es, de forma definitiva, el mejor disco que han editado Foo Fighters en este nuevo siglo. Es potente, adictivo, accesible y perenne, adjetivo que deja entrever que este LP reinará durante mucho y mucho tiempo. ¿El mejor disco del 2011? Aún es muy pronto para afirmarlo pero todo hace apuntar que este año «Wasting Light» va a arrasar con todo.', '2023-05-30', 1, 61),
(30, 'Obra maestra de los de Devon', 'Este álbum contiene todo lo que hace que la gente ame a Muse. Sin duda una banda revolucionaria a tener en cuenta.', '2023-06-07', 1, 105),
(32, 'Mi madre ha entrado mientras veía el videoclip.', 'Ahora no sabe qué pensar de mí, le he dicho que es sólo música pero se piensa que tengo alguna especie de obsesión con los señores mayores. Por favor, ayudadme.', '2023-06-11', 1, 126),
(33, 'Pero qué dice el tonto de abajo', 'Que sí, que el álbum está guapo fiera pero tampoco te flipes. Voy a gastar mi comentario sólo para meterme contigo, acaso hay algo más español?', '2023-06-11', 8, 61),
(34, 'Buen disco', 'Esta gente toca de puta madre.', '2023-06-14', 1, 68);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(4) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `foto_avatar` varchar(150) NOT NULL DEFAULT '../media/image_user_default.png',
  `correo` varchar(50) NOT NULL,
  `f_nac` date DEFAULT NULL,
  `low_eq` float DEFAULT NULL,
  `midlows_eq` float DEFAULT NULL,
  `mids_eq` float DEFAULT NULL,
  `midhighs_eq` float DEFAULT NULL,
  `high_eq` float DEFAULT NULL,
  `estilo` int(2) DEFAULT NULL,
  `grupo` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `apellidos`, `usuario`, `pass`, `foto_avatar`, `correo`, `f_nac`, `low_eq`, `midlows_eq`, `mids_eq`, `midhighs_eq`, `high_eq`, `estilo`, `grupo`) VALUES
(0, '', '', 'admin', 'c3284d0f94606de1fd2af172aba15bf3', '../media/image_user_default.png', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1, 'Pakito', 'Gutierrez', 'cydonia8', 'ede94ef301964849f8c40564943bbd13', '../media/img_users/cydonia8/cydonia8avatar.jpeg', 'alvaro@gmail.com', '1996-07-17', -12.96, 12.91, -24.38, 14.48, -0.98, 13, 21),
(5, 'John', 'Petrucci', 'jpetrucci', '36cc27d277e52a7a674a820d303586a8', '../media/img_users/jpetrucci/jpetrucciavatar.jpeg', 'jpetrucci@gmail.com', '2023-05-18', NULL, NULL, NULL, NULL, NULL, 2, 21),
(6, 'Paul', 'McCartney', 'pmccartney', '8b7497c7394491548a338f78608ac283', '../media/img_users/pmccartney/pmccartneyavatar.jpeg', 'pmccartney@gmail.com', '2023-05-19', NULL, NULL, NULL, NULL, NULL, 4, 25),
(8, 'Will', 'Paint', 'painteater', '6c15519f6ad015b47156dc38875ad53d', '../media/img_users/painteater/painteateravatar.png', 'paint@gmail.com', '1945-12-12', NULL, NULL, NULL, NULL, NULL, 12, 0),
(10, 'Feldespato', 'Wild', 'feldespato', 'd994ac901c2b818714430acb7a85f8aa', '../media/img_users/feldespato/feldespatoavatar.jpeg', 'feldespato@gmail.com', '1998-02-04', NULL, NULL, NULL, NULL, NULL, 16, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_alb_gru` (`grupo`);

--
-- Indices de la tabla `cancion`
--
ALTER TABLE `cancion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_canc_est` (`estilo`);

--
-- Indices de la tabla `contiene`
--
ALTER TABLE `contiene`
  ADD PRIMARY KEY (`lista`,`cancion`),
  ADD KEY `ce_cont_canc` (`cancion`);

--
-- Indices de la tabla `discografica`
--
ALTER TABLE `discografica`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estilo`
--
ALTER TABLE `estilo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD UNIQUE KEY `nombre_2` (`nombre`);

--
-- Indices de la tabla `favorito`
--
ALTER TABLE `favorito`
  ADD PRIMARY KEY (`usuario`,`album`),
  ADD KEY `ce_fav_alb` (`album`);

--
-- Indices de la tabla `foto_grupo`
--
ALTER TABLE `foto_grupo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_fotgru_gru` (`grupo`);

--
-- Indices de la tabla `foto_publicacion`
--
ALTER TABLE `foto_publicacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_fotpubl_publ` (`publicacion`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_gru_disc` (`discografica`);

--
-- Indices de la tabla `incluye`
--
ALTER TABLE `incluye`
  ADD KEY `ce_inclu_canc` (`cancion`),
  ADD KEY `ce_inclu_alb` (`album`);

--
-- Indices de la tabla `lista`
--
ALTER TABLE `lista`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_list_usu` (`usuario`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_mens_gru` (`grupo`);

--
-- Indices de la tabla `mensajes_promotores`
--
ALTER TABLE `mensajes_promotores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `promotores`
--
ALTER TABLE `promotores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_publ_gru` (`grupo`);

--
-- Indices de la tabla `recibe`
--
ALTER TABLE `recibe`
  ADD PRIMARY KEY (`usuario`,`mensaje`),
  ADD KEY `ce_rec_mens` (`mensaje`);

--
-- Indices de la tabla `reseña`
--
ALTER TABLE `reseña`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_res_usu` (`usuario`),
  ADD KEY `ce_res_gru` (`album`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `ce_us_est` (`estilo`),
  ADD KEY `ce_us_grup` (`grupo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `album`
--
ALTER TABLE `album`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT de la tabla `cancion`
--
ALTER TABLE `cancion`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=773;

--
-- AUTO_INCREMENT de la tabla `discografica`
--
ALTER TABLE `discografica`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `estilo`
--
ALTER TABLE `estilo`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `foto_grupo`
--
ALTER TABLE `foto_grupo`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `foto_publicacion`
--
ALTER TABLE `foto_publicacion`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `lista`
--
ALTER TABLE `lista`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensajes_promotores`
--
ALTER TABLE `mensajes_promotores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `promotores`
--
ALTER TABLE `promotores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `reseña`
--
ALTER TABLE `reseña`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `ce_alb_gru` FOREIGN KEY (`grupo`) REFERENCES `grupo` (`id`);

--
-- Filtros para la tabla `cancion`
--
ALTER TABLE `cancion`
  ADD CONSTRAINT `ce_canc_est` FOREIGN KEY (`estilo`) REFERENCES `estilo` (`id`);

--
-- Filtros para la tabla `contiene`
--
ALTER TABLE `contiene`
  ADD CONSTRAINT `ce_cont_canc` FOREIGN KEY (`cancion`) REFERENCES `cancion` (`id`),
  ADD CONSTRAINT `ce_cont_list` FOREIGN KEY (`lista`) REFERENCES `lista` (`id`);

--
-- Filtros para la tabla `favorito`
--
ALTER TABLE `favorito`
  ADD CONSTRAINT `ce_fav_alb` FOREIGN KEY (`album`) REFERENCES `album` (`id`),
  ADD CONSTRAINT `ce_fav_usu` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `foto_grupo`
--
ALTER TABLE `foto_grupo`
  ADD CONSTRAINT `ce_fotgru_gru` FOREIGN KEY (`grupo`) REFERENCES `grupo` (`id`);

--
-- Filtros para la tabla `foto_publicacion`
--
ALTER TABLE `foto_publicacion`
  ADD CONSTRAINT `ce_fotpubl_publ` FOREIGN KEY (`publicacion`) REFERENCES `publicacion` (`id`);

--
-- Filtros para la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD CONSTRAINT `ce_gru_disc` FOREIGN KEY (`discografica`) REFERENCES `discografica` (`id`);

--
-- Filtros para la tabla `incluye`
--
ALTER TABLE `incluye`
  ADD CONSTRAINT `ce_inclu_alb` FOREIGN KEY (`album`) REFERENCES `album` (`id`),
  ADD CONSTRAINT `ce_inclu_canc` FOREIGN KEY (`cancion`) REFERENCES `cancion` (`id`);

--
-- Filtros para la tabla `lista`
--
ALTER TABLE `lista`
  ADD CONSTRAINT `ce_list_usu` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD CONSTRAINT `ce_mens_gru` FOREIGN KEY (`grupo`) REFERENCES `grupo` (`id`);

--
-- Filtros para la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD CONSTRAINT `ce_publ_gru` FOREIGN KEY (`grupo`) REFERENCES `grupo` (`id`);

--
-- Filtros para la tabla `recibe`
--
ALTER TABLE `recibe`
  ADD CONSTRAINT `ce_rec_mens` FOREIGN KEY (`mensaje`) REFERENCES `mensaje` (`id`),
  ADD CONSTRAINT `ce_rec_usu` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `reseña`
--
ALTER TABLE `reseña`
  ADD CONSTRAINT `ce_res_gru` FOREIGN KEY (`album`) REFERENCES `album` (`id`),
  ADD CONSTRAINT `ce_res_usu` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `ce_us_est` FOREIGN KEY (`estilo`) REFERENCES `estilo` (`id`),
  ADD CONSTRAINT `ce_us_grup` FOREIGN KEY (`grupo`) REFERENCES `grupo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
