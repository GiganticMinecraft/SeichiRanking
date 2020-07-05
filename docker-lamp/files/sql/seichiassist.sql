DROP SCHEMA IF EXISTS seichiassist;
CREATE SCHEMA seichiassist;
USE seichiassist;

DROP TABLE IF EXISTS playerdata;
CREATE TABLE `playerdata` (
 `name` varchar(30) DEFAULT NULL,
 `uuid` varchar(128) DEFAULT NULL,
 `effectflag` tinyint(4) DEFAULT '0',
 `minestackflag` tinyint(1) DEFAULT '1',
 `messageflag` tinyint(1) DEFAULT '0',
 `activemineflagnum` int(11) DEFAULT '0',
 `assaultflag` tinyint(1) DEFAULT '0',
 `activeskilltype` int(11) DEFAULT '0',
 `activeskillnum` int(11) DEFAULT '1',
 `assaultskilltype` int(11) DEFAULT '0',
 `assaultskillnum` int(11) DEFAULT '0',
 `arrowskill` int(11) DEFAULT '0',
 `multiskill` int(11) DEFAULT '0',
 `breakskill` int(11) DEFAULT '0',
 `condenskill` int(11) DEFAULT '0',
 `effectnum` int(11) DEFAULT '0',
 `gachapoint` int(11) DEFAULT '0',
 `gachaflag` tinyint(1) DEFAULT '1',
 `level` int(11) DEFAULT '1',
 `numofsorryforbug` int(11) DEFAULT '0',
 `inventory` blob,
 `rgnum` int(11) DEFAULT '0',
 `totalbreaknum` bigint(20) DEFAULT '0',
 `lastquit` datetime DEFAULT NULL,
 `displayTypeLv` tinyint(1) DEFAULT '1',
 `displayTitleNo` int(11) DEFAULT '0',
 `TitleFlags` text,
 `giveachvNo` int(11) DEFAULT '0',
 `playtick` int(11) DEFAULT '0',
 `killlogflag` tinyint(1) DEFAULT '0',
 `worldguardlogflag` tinyint(1) DEFAULT '1',
 `multipleidbreakflag` tinyint(1) DEFAULT '0',
 `pvpflag` tinyint(1) DEFAULT '0',
 `loginflag` tinyint(1) DEFAULT '0',
 `p_vote` int(11) DEFAULT '0',
 `p_givenvote` int(11) DEFAULT '0',
 `effectpoint` int(11) DEFAULT '0',
 `premiumeffectpoint` int(11) DEFAULT '0',
 `mana` double DEFAULT '0',
 `expvisible` tinyint(1) DEFAULT '1',
 `totalexp` int(11) DEFAULT '0',
 `expmarge` tinyint(3) unsigned DEFAULT '0',
 `shareinv` blob,
 `everysound` tinyint(1) DEFAULT '1',
 `build_lv` int(11) DEFAULT '1',
 `build_count` int(11) DEFAULT '0',
 `build_count_flg` tinyint(3) unsigned DEFAULT '0',
 `lastcheckdate` varchar(12) DEFAULT NULL,
 `ChainJoin` int(11) DEFAULT '0',
 `TotalJoin` int(11) DEFAULT '0',
 `displayTitle1No` int(11) DEFAULT '0',
 `displayTitle2No` int(11) DEFAULT '0',
 `displayTitle3No` int(11) DEFAULT '0',
 `achvPointMAX` int(11) DEFAULT '0',
 `achvPointUSE` int(11) DEFAULT '0',
 `achvChangenum` int(11) DEFAULT '0',
 UNIQUE KEY `name` (`name`),
 UNIQUE KEY `uuid` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO playerdata (name, uuid, totalbreaknum, lastquit, build_count, p_vote)
VALUES ('TestUser1', '000000001', 999, NOW(), 888, 777);


DROP TABLE IF EXISTS daily_ranking_table;
CREATE TABLE `daily_ranking_table` (
 `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
 `count_date` date NOT NULL,
 `name` varchar(30) NOT NULL,
 `uuid` varchar(128) NOT NULL,
 `break_count` bigint(20) NOT NULL DEFAULT '0',
 `build_count` bigint(20) NOT NULL DEFAULT '0',
 `playtick_count` bigint(20) NOT NULL DEFAULT '0',
 `vote_count` int(11) NOT NULL DEFAULT '0',
 `previous_break_count` bigint(20) NOT NULL,
 `previous_build_count` bigint(20) NOT NULL,
 `previous_playtick_count` bigint(20) NOT NULL,
 `previous_vote_count` int(11) NOT NULL,
 `deleted_at` timestamp,
 `created_at` datetime NOT NULL,
 `updated_at` datetime NOT NULL,
 UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO daily_ranking_table (id, count_date, name, uuid, break_count, playtick_count, previous_break_count, updated_at, previous_build_count, previous_vote_count, created_at, previous_playtick_count )
VALUES (1, NOW(), 'test_user', '000000001', 999, 110, 11, NOW(), 777, 1, NOW(), 50);

DROP TABLE IF EXISTS weekly_ranking_table;
CREATE TABLE `weekly_ranking_table` LIKE daily_ranking_table;

DROP TABLE IF EXISTS monthly_ranking_table;
CREATE TABLE `monthly_ranking_table` LIKE daily_ranking_table;

INSERT INTO monthly_ranking_table (id, count_date, name, uuid, break_count, previous_break_count, updated_at, previous_build_count, previous_vote_count, created_at, previous_playtick_count )
VALUES (1, NOW(), 'TestUser3', '000000003', 999, 11, NOW(), 777, 1, NOW(), 50);

DROP TABLE IF EXISTS yearly_ranking_table;
CREATE TABLE `yearly_ranking_table` LIKE daily_ranking_table;

INSERT INTO yearly_ranking_table (id, count_date, name, uuid, break_count, previous_break_count, updated_at, previous_build_count, previous_vote_count, created_at, previous_playtick_count )
VALUES (1, NOW(), 'TestUser4', '000000004', 999, 11, NOW(), 777, 1, NOW(), 50);