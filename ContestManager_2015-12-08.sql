# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# (MySQL 5.5.46-cll)
# Database: quilleng_ContestManager
# Generation Time: 2015-12-08 13:31:42 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table link_contestsTocategory
# ------------------------------------------------------------

CREATE TABLE `link_contestsTocategory` (
  `contestsID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  UNIQUE KEY `indexUniq` (`categoryID`,`contestsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table lk_category
# ------------------------------------------------------------

CREATE TABLE `lk_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `desc` text,
  `edited_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table lk_classLevel
# ------------------------------------------------------------

CREATE TABLE `lk_classLevel` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `desc` text NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table lk_contests
# ------------------------------------------------------------

CREATE TABLE `lk_contests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `shortName` varchar(45) NOT NULL DEFAULT 'noShortNameSet',
  `applicationTypeID` int(11) NOT NULL DEFAULT '1',
  `eligibilityRules` text,
  `isTranscriptReqd` tinyint(1) NOT NULL DEFAULT '0',
  `maxApplicantEntries` int(11) NOT NULL DEFAULT '1',
  `termAvailableID` int(11) NOT NULL,
  `freshmanEligible` tinyint(1) NOT NULL DEFAULT '0',
  `sophmoreEligible` tinyint(1) NOT NULL DEFAULT '0',
  `juniorEligible` tinyint(1) NOT NULL DEFAULT '0',
  `seniorEligible` tinyint(1) NOT NULL DEFAULT '0',
  `graduateEligible` tinyint(1) NOT NULL DEFAULT '0',
  `contests_notes` varchar(255) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(10) NOT NULL DEFAULT '',
  `edited_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edited_by` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table lk_status
# ------------------------------------------------------------

CREATE TABLE `lk_status` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(20) NOT NULL DEFAULT '',
  `value` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `value` (`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table lk_termAvailable
# ------------------------------------------------------------

CREATE TABLE `lk_termAvailable` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `abbreviation` varchar(2) NOT NULL DEFAULT '',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `edited_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tbl_applicant
# ------------------------------------------------------------

CREATE TABLE `tbl_applicant` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userFname` varchar(255) NOT NULL DEFAULT '',
  `userLname` varchar(255) NOT NULL DEFAULT '',
  `umid` varchar(8) NOT NULL DEFAULT '',
  `uniqname` varchar(10) NOT NULL,
  `streetL` varchar(255) NOT NULL DEFAULT '',
  `cityL` varchar(255) NOT NULL DEFAULT 'AnnArbor',
  `stateL` varchar(100) NOT NULL DEFAULT 'Michigan',
  `zipL` varchar(5) NOT NULL DEFAULT '',
  `usrtelL` varchar(12) DEFAULT NULL,
  `streetH` varchar(255) NOT NULL DEFAULT '',
  `cityH` varchar(255) NOT NULL DEFAULT '',
  `stateH` varchar(100) NOT NULL DEFAULT '',
  `zipH` varchar(5) NOT NULL DEFAULT '',
  `usrtelH` varchar(12) DEFAULT NULL,
  `classLevel` int(11) NOT NULL,
  `school` varchar(255) NOT NULL DEFAULT '',
  `major` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `gradYearMonth` varchar(8) NOT NULL DEFAULT '',
  `degree` varchar(255) NOT NULL DEFAULT '',
  `finAid` tinyint(1) NOT NULL DEFAULT '0',
  `finAidDesc` text,
  `namePub` varchar(255) DEFAULT NULL,
  `homeNewspaper` varchar(255) DEFAULT NULL,
  `penName` varchar(255) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(10) NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `edited_by` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tbl_contest
# ------------------------------------------------------------

CREATE TABLE `tbl_contest` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contestsID` int(11) DEFAULT NULL,
  `date_open` datetime NOT NULL,
  `date_closed` datetime NOT NULL,
  `notes` text,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(10) NOT NULL DEFAULT '',
  `edited_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edited_by` varchar(10) NOT NULL DEFAULT '',
  `judgingOpen` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tbl_contestadmin
# ------------------------------------------------------------

CREATE TABLE `tbl_contestadmin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniqname` varchar(10) DEFAULT NULL,
  `edited_by` varchar(25) DEFAULT NULL,
  `edited_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tbl_contestjudge
# ------------------------------------------------------------

CREATE TABLE `tbl_contestjudge` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniqname` varchar(10) NOT NULL DEFAULT '',
  `categoryID` int(3) NOT NULL,
  `contestsID` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tbl_entry
# ------------------------------------------------------------

CREATE TABLE `tbl_entry` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contestID` int(11) NOT NULL,
  `applicantID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `classLevelID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `documentName` varchar(255) NOT NULL,
  `courseNameNum` varchar(45) DEFAULT 'NA',
  `instrName` varchar(255) DEFAULT 'NA',
  `termYear` varchar(45) DEFAULT 'NA',
  `recletter1Name` varchar(255) DEFAULT 'NA',
  `recLetter2Name` varchar(255) DEFAULT 'NA',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(10) NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edited_by` varchar(10) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tbl_evaluations
# ------------------------------------------------------------

CREATE TABLE `tbl_evaluations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `evaluator` varchar(10) NOT NULL DEFAULT '',
  `rating` int(2) NOT NULL,
  `comment` text NOT NULL,
  `entry_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tbl_ranking
# ------------------------------------------------------------

CREATE TABLE `tbl_ranking` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rankedby` varchar(10) NOT NULL DEFAULT '',
  `entryid` int(11) NOT NULL,
  `contestID` int(11) NOT NULL,
  `rank` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table vw_contestlisting
# ------------------------------------------------------------

CREATE TABLE `vw_contestlisting` (
   `contestid` INT(11) UNSIGNED NOT NULL DEFAULT '0',
   `id` INT(11) NULL DEFAULT NULL,
   `date_open` DATETIME NOT NULL,
   `date_closed` DATETIME NOT NULL,
   `ContestsName` VARCHAR(255) NOT NULL DEFAULT '',
   `shortname` VARCHAR(45) NOT NULL DEFAULT 'noShortNameSet',
   `contests_notes` VARCHAR(255) NULL DEFAULT NULL,
   `freshmanEligible` TINYINT(1) NOT NULL DEFAULT '0',
   `sophmoreEligible` TINYINT(1) NOT NULL DEFAULT '0',
   `juniorEligible` TINYINT(1) NOT NULL DEFAULT '0',
   `seniorEligible` TINYINT(1) NOT NULL DEFAULT '0',
   `graduateEligible` TINYINT(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM;



# Dump of table vw_contestlistingfuturedated
# ------------------------------------------------------------

CREATE TABLE `vw_contestlistingfuturedated` (
   `contestid` INT(11) UNSIGNED NOT NULL DEFAULT '0',
   `id` INT(11) NULL DEFAULT NULL,
   `date_open` DATETIME NOT NULL,
   `date_closed` DATETIME NOT NULL,
   `ContestsName` VARCHAR(255) NOT NULL DEFAULT '',
   `shortname` VARCHAR(45) NOT NULL DEFAULT 'noShortNameSet',
   `contests_notes` VARCHAR(255) NULL DEFAULT NULL,
   `freshmanEligible` TINYINT(1) NOT NULL DEFAULT '0',
   `sophmoreEligible` TINYINT(1) NOT NULL DEFAULT '0',
   `juniorEligible` TINYINT(1) NOT NULL DEFAULT '0',
   `seniorEligible` TINYINT(1) NOT NULL DEFAULT '0',
   `graduateEligible` TINYINT(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM;



# Dump of table vw_conteststocategory
# ------------------------------------------------------------

CREATE TABLE `vw_conteststocategory` (
   `contestsID` INT(11) NOT NULL,
   `categoryID` INT(11) NOT NULL,
   `CategoryName` VARCHAR(100) NOT NULL DEFAULT '',
   `ContestsName` VARCHAR(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM;



# Dump of table vw_entrydetail
# ------------------------------------------------------------

CREATE TABLE `vw_entrydetail` (
   `EntryId` INT(11) UNSIGNED NOT NULL DEFAULT '0',
   `title` VARCHAR(255) NOT NULL DEFAULT '',
   `document` VARCHAR(255) NOT NULL,
   `status` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
   `uniqname` VARCHAR(10) NOT NULL,
   `firstname` VARCHAR(255) NOT NULL DEFAULT '',
   `lastname` VARCHAR(255) NOT NULL DEFAULT '',
   `penName` VARCHAR(255) NULL DEFAULT NULL,
   `manuscriptType` VARCHAR(100) NOT NULL DEFAULT '',
   `contestName` VARCHAR(255) NOT NULL DEFAULT '',
   `datesubmitted` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
   `date_open` DATETIME NOT NULL,
   `date_closed` DATETIME NOT NULL,
   `ContestInstance` INT(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM;



# Dump of table vw_entrydetail_with_applicantdetail
# ------------------------------------------------------------

CREATE TABLE `vw_entrydetail_with_applicantdetail` (
   `uniqname` VARCHAR(10) NOT NULL,
   `Name` VARCHAR(511) NOT NULL DEFAULT '',
   `Local_Address` TEXT NOT NULL,
   `Home_Address` TEXT NOT NULL,
   `Degree/College` TEXT NULL DEFAULT NULL,
   `manuscript_title` VARCHAR(255) NOT NULL DEFAULT '',
   `contestName` VARCHAR(255) NOT NULL DEFAULT '',
   `datesubmitted` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
   `hometown_newspaper` VARCHAR(255) NULL DEFAULT NULL
) ENGINE=MyISAM;



# Dump of table vw_kitchensink
# ------------------------------------------------------------

CREATE TABLE `vw_kitchensink` (
   `uniqname` VARCHAR(20) NOT NULL DEFAULT '',
   `UMid` VARCHAR(8) NOT NULL DEFAULT '',
   `Name` VARCHAR(511) NOT NULL DEFAULT '',
   `Local_Address` TEXT NOT NULL,
   `Home_Address` TEXT NOT NULL,
   `ClassLevel` VARCHAR(8) NOT NULL DEFAULT '',
   `Grad_Yr-Mo/School/Dept/Major` TEXT NULL DEFAULT NULL,
   `Financial Aid` VARCHAR(3) NOT NULL DEFAULT '',
   `Financial Aid Desciption` TEXT NULL DEFAULT NULL,
   `manuscript_title` VARCHAR(255) NOT NULL DEFAULT '',
   `manuscriptType` VARCHAR(100) NOT NULL DEFAULT '',
   `contestName` VARCHAR(255) NOT NULL DEFAULT '',
   `Qualifying-Course` VARCHAR(45) NULL DEFAULT NULL,
   `Qualifying-Instructor` VARCHAR(255) NULL DEFAULT NULL,
   `Qualifying-term_year` VARCHAR(45) NULL DEFAULT NULL,
   `hometown_newspaper` VARCHAR(255) NULL DEFAULT NULL,
   `publication_name` VARCHAR(255) NULL DEFAULT NULL,
   `Pen_Name` VARCHAR(255) NULL DEFAULT NULL
) ENGINE=MyISAM;





# Replace placeholder table for vw_entrydetail_with_applicantdetail with correct view syntax
# ------------------------------------------------------------

DROP TABLE `vw_entrydetail_with_applicantdetail`;

CREATE VIEW `vw_entrydetail_with_applicantdetail`
AS SELECT
   `tbl_applicant`.`uniqname` AS `uniqname`,concat(`tbl_applicant`.`userFname`,' ',`tbl_applicant`.`userLname`) AS `Name`,concat(`tbl_applicant`.`streetL`,', ',`tbl_applicant`.`cityL`,', ',`tbl_applicant`.`stateL`,' ',`tbl_applicant`.`zipL`) AS `Local_Address`,concat(`tbl_applicant`.`streetH`,', ',`tbl_applicant`.`cityH`,', ',`tbl_applicant`.`stateH`,' ',`tbl_applicant`.`zipH`) AS `Home_Address`,concat(`tbl_applicant`.`gradYearMonth`,' ',`tbl_applicant`.`school`,' ',`tbl_applicant`.`major`) AS `Degree/College`,
   `tbl_entry`.`title` AS `manuscript_title`,
   `lk_contests`.`name` AS `contestName`,
   `tbl_entry`.`created_on` AS `datesubmitted`,
   `tbl_applicant`.`homeNewspaper` AS `hometown_newspaper`
FROM ((((`tbl_entry` join `tbl_applicant` on((`tbl_entry`.`applicantID` = `tbl_applicant`.`id`))) join `lk_category` on((`tbl_entry`.`categoryID` = `lk_category`.`id`))) join `tbl_contest` on((`tbl_entry`.`contestID` = `tbl_contest`.`id`))) join `lk_contests` on((`tbl_contest`.`contestsID` = `lk_contests`.`id`))) order by `tbl_applicant`.`uniqname`;


# Replace placeholder table for vw_kitchensink with correct view syntax
# ------------------------------------------------------------

DROP TABLE `vw_kitchensink`;

CREATE VIEW `vw_kitchensink`
AS SELECT
   concat(`tbl_applicant`.`uniqname`,'@umich.edu') AS `uniqname`,
   `tbl_applicant`.`umid` AS `UMid`,concat(`tbl_applicant`.`userFname`,' ',`tbl_applicant`.`userLname`) AS `Name`,concat(`tbl_applicant`.`streetL`,', ',`tbl_applicant`.`cityL`,', ',`tbl_applicant`.`stateL`,' ',`tbl_applicant`.`zipL`) AS `Local_Address`,concat(`tbl_applicant`.`streetH`,', ',`tbl_applicant`.`cityH`,', ',`tbl_applicant`.`stateH`,' ',`tbl_applicant`.`zipH`) AS `Home_Address`,(case `tbl_applicant`.`classLevel` when 9 then 'Freshman' when 10 then 'Sophmore' when 11 then 'Junior' when 12 then 'Senior' else 'Graduate' end) AS `ClassLevel`,concat(`tbl_applicant`.`gradYearMonth`,' ',`tbl_applicant`.`school`,' ',`tbl_applicant`.`major`,' ',`tbl_applicant`.`department`) AS `Grad_Yr-Mo/School/Dept/Major`,(case `tbl_applicant`.`finAid` when 1 then 'Yes' else ' ' end) AS `Financial Aid`,
   `tbl_applicant`.`finAidDesc` AS `Financial Aid Desciption`,
   `tbl_entry`.`title` AS `manuscript_title`,
   `lk_category`.`name` AS `manuscriptType`,
   `lk_contests`.`name` AS `contestName`,(case `tbl_entry`.`courseNameNum` when 'NoValue' then ' ' else `tbl_entry`.`courseNameNum` end) AS `Qualifying-Course`,(case `tbl_entry`.`instrName` when 'NoValue' then ' ' else `tbl_entry`.`instrName` end) AS `Qualifying-Instructor`,(case `tbl_entry`.`termYear` when 'NoValue' then ' ' else `tbl_entry`.`termYear` end) AS `Qualifying-term_year`,
   `tbl_applicant`.`homeNewspaper` AS `hometown_newspaper`,
   `tbl_applicant`.`namePub` AS `publication_name`,
   `tbl_applicant`.`penName` AS `Pen_Name`
FROM ((((`tbl_entry` join `tbl_applicant` on((`tbl_entry`.`applicantID` = `tbl_applicant`.`id`))) join `lk_category` on((`tbl_entry`.`categoryID` = `lk_category`.`id`))) join `tbl_contest` on((`tbl_entry`.`contestID` = `tbl_contest`.`id`))) join `lk_contests` on((`tbl_contest`.`contestsID` = `lk_contests`.`id`))) order by `tbl_applicant`.`uniqname`;


# Replace placeholder table for vw_conteststocategory with correct view syntax
# ------------------------------------------------------------

DROP TABLE `vw_conteststocategory`;

CREATE VIEW `vw_conteststocategory`
AS SELECT
   `C2C`.`contestsID` AS `contestsID`,
   `C2C`.`categoryID` AS `categoryID`,
   `C1`.`name` AS `CategoryName`,
   `C2`.`name` AS `ContestsName`
FROM ((`link_contestsTocategory` `C2C` join `lk_category` `C1` on((`C2C`.`categoryID` = `C1`.`id`))) join `lk_contests` `C2` on((`C2C`.`contestsID` = `C2`.`id`))) order by `C2C`.`contestsID`,`C2C`.`categoryID`;


# Replace placeholder table for vw_entrydetail with correct view syntax
# ------------------------------------------------------------

DROP TABLE `vw_entrydetail`;

CREATE VIEW `vw_entrydetail`
AS SELECT
   `tbl_entry`.`id` AS `EntryId`,
   `tbl_entry`.`title` AS `title`,
   `tbl_entry`.`documentName` AS `document`,
   `tbl_entry`.`status` AS `status`,
   `tbl_applicant`.`uniqname` AS `uniqname`,
   `tbl_applicant`.`userFname` AS `firstname`,
   `tbl_applicant`.`userLname` AS `lastname`,
   `tbl_applicant`.`penName` AS `penName`,
   `lk_category`.`name` AS `manuscriptType`,
   `lk_contests`.`name` AS `contestName`,
   `tbl_entry`.`created_on` AS `datesubmitted`,
   `tbl_contest`.`date_open` AS `date_open`,
   `tbl_contest`.`date_closed` AS `date_closed`,
   `tbl_contest`.`id` AS `ContestInstance`
FROM ((((`tbl_entry` join `tbl_applicant` on((`tbl_entry`.`applicantID` = `tbl_applicant`.`id`))) join `lk_category` on((`tbl_entry`.`categoryID` = `lk_category`.`id`))) join `tbl_contest` on((`tbl_entry`.`contestID` = `tbl_contest`.`id`))) join `lk_contests` on((`tbl_contest`.`contestsID` = `lk_contests`.`id`)));


# Replace placeholder table for vw_contestlistingfuturedated with correct view syntax
# ------------------------------------------------------------

DROP TABLE `vw_contestlistingfuturedated`;

CREATE VIEW `vw_contestlistingfuturedated`
AS SELECT
   `tbl_contest`.`id` AS `contestid`,
   `tbl_contest`.`contestsID` AS `id`,
   `tbl_contest`.`date_open` AS `date_open`,
   `tbl_contest`.`date_closed` AS `date_closed`,
   `lk_contests`.`name` AS `ContestsName`,
   `lk_contests`.`shortName` AS `shortname`,
   `lk_contests`.`contests_notes` AS `contests_notes`,
   `lk_contests`.`freshmanEligible` AS `freshmanEligible`,
   `lk_contests`.`sophmoreEligible` AS `sophmoreEligible`,
   `lk_contests`.`juniorEligible` AS `juniorEligible`,
   `lk_contests`.`seniorEligible` AS `seniorEligible`,
   `lk_contests`.`graduateEligible` AS `graduateEligible`
FROM (`tbl_contest` join `lk_contests` on((`tbl_contest`.`contestsID` = `lk_contests`.`id`))) where (`tbl_contest`.`date_open` > cast(now() as date));


# Replace placeholder table for vw_contestlisting with correct view syntax
# ------------------------------------------------------------

DROP TABLE `vw_contestlisting`;

CREATE VIEW `vw_contestlisting`
AS SELECT
   `tbl_contest`.`id` AS `contestid`,
   `tbl_contest`.`contestsID` AS `id`,
   `tbl_contest`.`date_open` AS `date_open`,
   `tbl_contest`.`date_closed` AS `date_closed`,
   `lk_contests`.`name` AS `ContestsName`,
   `lk_contests`.`shortName` AS `shortname`,
   `lk_contests`.`contests_notes` AS `contests_notes`,
   `lk_contests`.`freshmanEligible` AS `freshmanEligible`,
   `lk_contests`.`sophmoreEligible` AS `sophmoreEligible`,
   `lk_contests`.`juniorEligible` AS `juniorEligible`,
   `lk_contests`.`seniorEligible` AS `seniorEligible`,
   `lk_contests`.`graduateEligible` AS `graduateEligible`
FROM (`tbl_contest` join `lk_contests` on((`tbl_contest`.`contestsID` = `lk_contests`.`id`))) where ((`tbl_contest`.`date_closed` > cast(now() as date)) and (`tbl_contest`.`date_open` <= cast(now() as date)));

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
