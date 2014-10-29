-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2014 at 06:32 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ravenstorm`
--

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE IF NOT EXISTS `matches` (
  `matchId` bigint(20) unsigned NOT NULL,
  `matchCreation` bigint(20) unsigned NOT NULL,
  `matchDuration` bigint(20) unsigned NOT NULL,
  `mapId` smallint(5) unsigned NOT NULL,
  `matchMode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `matchType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `matchVersion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `queueType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `season` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `frameInterval` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`matchId`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_09_17_171111_create_users_table', 1),
('2014_09_17_171546_create_matches_table', 1),
('2014_09_17_171840_create_participants_table', 1),
('2014_09_17_174043_create_participants_stats_table', 1),
('2014_09_17_182114_add_foreign_keys', 1);

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE IF NOT EXISTS `participants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `matchId` bigint(20) unsigned NOT NULL,
  `summonerId` int(10) unsigned DEFAULT NULL,
  `championId` smallint(5) unsigned NOT NULL,
  `spell1Id` smallint(5) unsigned NOT NULL,
  `spell2Id` smallint(5) unsigned NOT NULL,
  `teamId` smallint(5) unsigned NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lane` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `participants_matchid_index` (`matchId`),
  KEY `participants_summonerid_index` (`summonerId`),
  KEY `participants_role_index` (`role`),
  KEY `participants_lane_index` (`lane`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `participants_stats`
--

CREATE TABLE IF NOT EXISTS `participants_stats` (
  `participantTableId` int(10) unsigned NOT NULL,
  `assists` int(10) unsigned NOT NULL,
  `champLevel` int(10) unsigned NOT NULL,
  `deaths` int(10) unsigned NOT NULL,
  `doubleKills` int(10) unsigned NOT NULL,
  `firstBloodAssist` tinyint(4) DEFAULT NULL,
  `firstBloodKill` tinyint(4) DEFAULT NULL,
  `firstInhibitorAssist` tinyint(4) DEFAULT NULL,
  `firstInhibitorKill` tinyint(4) DEFAULT NULL,
  `firstTowerAssist` tinyint(4) DEFAULT NULL,
  `firstTowerKill` tinyint(4) DEFAULT NULL,
  `goldEarned` int(10) unsigned NOT NULL,
  `goldSpent` int(10) unsigned NOT NULL,
  `inhibitorKills` int(10) unsigned NOT NULL,
  `item0` int(10) unsigned NOT NULL,
  `item1` int(10) unsigned NOT NULL,
  `item2` int(10) unsigned NOT NULL,
  `item3` int(10) unsigned NOT NULL,
  `item4` int(10) unsigned NOT NULL,
  `item5` int(10) unsigned NOT NULL,
  `item6` int(10) unsigned NOT NULL,
  `killingSprees` int(10) unsigned NOT NULL,
  `kills` int(10) unsigned NOT NULL,
  `largestCriticalStrike` int(10) unsigned NOT NULL,
  `largestKillingSpree` int(10) unsigned NOT NULL,
  `largestMultiKill` int(10) unsigned NOT NULL,
  `magicDamageDealt` int(10) unsigned NOT NULL,
  `magicDamageDealtToChampions` int(10) unsigned NOT NULL,
  `magicDamageTaken` int(10) unsigned NOT NULL,
  `minionsKilled` int(10) unsigned NOT NULL,
  `neutralMinionsKilled` int(10) unsigned NOT NULL,
  `neutralMinionsKilledEnemyJungle` int(10) unsigned NOT NULL,
  `neutralMinionsKilledTeamJungle` int(10) unsigned NOT NULL,
  `nodeCapture` int(10) unsigned DEFAULT NULL,
  `nodeCaptureAssist` int(10) unsigned DEFAULT NULL,
  `nodeNeutralize` int(10) unsigned DEFAULT NULL,
  `nodeNeutralizeAssist` int(10) unsigned DEFAULT NULL,
  `objectivePlayerScore` int(10) unsigned DEFAULT NULL,
  `pentaKills` int(10) unsigned NOT NULL,
  `physicalDamageDealt` int(10) unsigned NOT NULL,
  `physicalDamageDealtToChampions` int(10) unsigned NOT NULL,
  `physicalDamageTaken` int(10) unsigned NOT NULL,
  `quadraKills` int(10) unsigned NOT NULL,
  `sightWardsBoughtInGame` int(10) unsigned NOT NULL,
  `teamObjective` int(10) unsigned DEFAULT NULL,
  `totalDamageDealt` int(10) unsigned NOT NULL,
  `totalDamageDealtToChampions` int(10) unsigned NOT NULL,
  `totalDamageTaken` int(10) unsigned NOT NULL,
  `totalHeal` int(10) unsigned NOT NULL,
  `totalTimeCrowdControlDealt` int(10) unsigned NOT NULL,
  `totalUnitsHealed` int(10) unsigned NOT NULL,
  `towerKills` int(10) unsigned NOT NULL,
  `tripleKills` int(10) unsigned NOT NULL,
  `trueDamageDealt` int(10) unsigned NOT NULL,
  `trueDamageDealtToChampions` int(10) unsigned NOT NULL,
  `trueDamageTaken` int(10) unsigned NOT NULL,
  `unrealKills` int(10) unsigned NOT NULL,
  `visionWardsBoughtInGame` int(10) unsigned NOT NULL,
  `wardsKilled` int(10) unsigned NOT NULL,
  `wardsPlaced` int(10) unsigned NOT NULL,
  `winner` tinyint(4) NOT NULL,
  PRIMARY KEY (`participantTableId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `summonerId` int(10) unsigned NOT NULL,
  `summonerName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `ravenscore` float(8,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`summonerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_matchid_foreign` FOREIGN KEY (`matchId`) REFERENCES `matches` (`matchId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `participants_stats`
--
ALTER TABLE `participants_stats`
  ADD CONSTRAINT `participants_stats_participanttableid_foreign` FOREIGN KEY (`participantTableId`) REFERENCES `participants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
