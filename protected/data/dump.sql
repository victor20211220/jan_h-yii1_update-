-- MySQL dump 10.13  Distrib 8.0.23, for Linux (x86_64)
--
-- Host: localhost    Database: directory
-- ------------------------------------------------------
-- Server version	8.0.23-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `directory_authassignment`
--

DROP TABLE IF EXISTS `directory_authassignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  CONSTRAINT `directory_authassignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `directory_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directory_authassignment`
--

LOCK TABLES `directory_authassignment` WRITE;
/*!40000 ALTER TABLE `directory_authassignment` DISABLE KEYS */;
/*!40000 ALTER TABLE `directory_authassignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directory_authitem`
--

DROP TABLE IF EXISTS `directory_authitem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_authitem` (
  `name` varchar(64) NOT NULL,
  `type` int NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directory_authitem`
--

LOCK TABLES `directory_authitem` WRITE;
/*!40000 ALTER TABLE `directory_authitem` DISABLE KEYS */;
INSERT INTO `directory_authitem` VALUES ('admin_category_create',0,'admin_category_create',NULL,'N;'),('admin_category_createroot',0,'admin_category_createroot',NULL,'N;'),('admin_category_deletesuggest',0,'admin_category_deletesuggest',NULL,'N;'),('admin_category_dropdowncategory',0,'admin_category_dropdowncategory',NULL,'N;'),('admin_category_manage',0,'admin_category_manage',NULL,'N;'),('admin_category_move',0,'admin_category_move',NULL,'N;'),('admin_category_node',0,'admin_category_node',NULL,'N;'),('admin_category_remove',0,'admin_category_remove',NULL,'N;'),('admin_category_roots',0,'admin_category_roots',NULL,'N;'),('admin_category_suggest',0,'admin_category_suggest',NULL,'N;'),('admin_category_update',0,'admin_category_update',NULL,'N;'),('admin_tools_clearcache',0,'admin_tools_clearcache',NULL,'N;'),('admin_tools_generatesitemap',0,'admin_tools_generatesitemap',NULL,'N;'),('admin_tools_generatewebsitecount',0,'admin_tools_generatewebsitecount',NULL,'N;'),('admin_tools_index',0,'admin_tools_index',NULL,'N;'),('admin_url_brokenlinks',0,'admin_url_brokenlinks',NULL,'N;'),('admin_url_delete',0,'admin_url_delete',NULL,'N;'),('admin_url_deletebrokenlinks',0,'admin_url_deletebrokenlinks',NULL,'N;'),('admin_url_deletecustomupdate',0,'admin_url_deletecustomupdate',NULL,'N;'),('admin_url_index',0,'admin_url_index',NULL,'N;'),('admin_url_update',0,'admin_url_update',NULL,'N;'),('admin_url_updatereport',0,'admin_url_updatereport',NULL,'N;'),('admin_url_view',0,'admin_url_view',NULL,'N;'),('admin_url_viewupdate',0,'admin_url_viewupdate',NULL,'N;');
/*!40000 ALTER TABLE `directory_authitem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directory_authitemchild`
--

DROP TABLE IF EXISTS `directory_authitemchild`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `directory_authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `directory_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `directory_authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `directory_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directory_authitemchild`
--

LOCK TABLES `directory_authitemchild` WRITE;
/*!40000 ALTER TABLE `directory_authitemchild` DISABLE KEYS */;
/*!40000 ALTER TABLE `directory_authitemchild` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directory_brokenlink`
--

DROP TABLE IF EXISTS `directory_brokenlink`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_brokenlink` (
  `website_id` int unsigned NOT NULL,
  `ip` varchar(64) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`website_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directory_brokenlink`
--

LOCK TABLES `directory_brokenlink` WRITE;
/*!40000 ALTER TABLE `directory_brokenlink` DISABLE KEYS */;
/*!40000 ALTER TABLE `directory_brokenlink` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directory_category`
--

DROP TABLE IF EXISTS `directory_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_category` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `root` int unsigned DEFAULT NULL,
  `lft` int unsigned NOT NULL,
  `rgt` int unsigned NOT NULL,
  `level` smallint unsigned NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lang_id` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ix_lft_rgt_root` (`lft`,`rgt`,`root`),
  KEY `root` (`root`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directory_category`
--

LOCK TABLES `directory_category` WRITE;
/*!40000 ALTER TABLE `directory_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `directory_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directory_category_count`
--

DROP TABLE IF EXISTS `directory_category_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_category_count` (
  `category_id` int unsigned NOT NULL,
  `website_count` int unsigned DEFAULT '0',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directory_category_count`
--

LOCK TABLES `directory_category_count` WRITE;
/*!40000 ALTER TABLE `directory_category_count` DISABLE KEYS */;
/*!40000 ALTER TABLE `directory_category_count` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directory_premiumcheck`
--

DROP TABLE IF EXISTS `directory_premiumcheck`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_premiumcheck` (
  `website_id` int unsigned NOT NULL,
  `attempts` int unsigned DEFAULT '0',
  PRIMARY KEY (`website_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directory_premiumcheck`
--

LOCK TABLES `directory_premiumcheck` WRITE;
/*!40000 ALTER TABLE `directory_premiumcheck` DISABLE KEYS */;
/*!40000 ALTER TABLE `directory_premiumcheck` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directory_profile`
--

DROP TABLE IF EXISTS `directory_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_profile` (
  `owner_id` int unsigned NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directory_profile`
--

LOCK TABLES `directory_profile` WRITE;
/*!40000 ALTER TABLE `directory_profile` DISABLE KEYS */;
INSERT INTO `directory_profile` VALUES (1,'Administrator','admin@mail.com');
/*!40000 ALTER TABLE `directory_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directory_statistic`
--

DROP TABLE IF EXISTS `directory_statistic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_statistic` (
  `website_id` int unsigned NOT NULL,
  `hits` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`website_id`),
  KEY `ix_hits` (`hits`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directory_statistic`
--

LOCK TABLES `directory_statistic` WRITE;
/*!40000 ALTER TABLE `directory_statistic` DISABLE KEYS */;
/*!40000 ALTER TABLE `directory_statistic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directory_suggest`
--

DROP TABLE IF EXISTS `directory_suggest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_suggest` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `comments` mediumtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directory_suggest`
--

LOCK TABLES `directory_suggest` WRITE;
/*!40000 ALTER TABLE `directory_suggest` DISABLE KEYS */;
/*!40000 ALTER TABLE `directory_suggest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directory_system_log`
--

DROP TABLE IF EXISTS `directory_system_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_system_log` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `module` varchar(255) NOT NULL,
  `log` mediumtext NOT NULL,
  `params` mediumtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `visible` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_visisble_created` (`visible`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directory_system_log`
--

LOCK TABLES `directory_system_log` WRITE;
/*!40000 ALTER TABLE `directory_system_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `directory_system_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directory_update`
--

DROP TABLE IF EXISTS `directory_update`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_update` (
  `website_id` int unsigned NOT NULL,
  `lang_id` varchar(5) NOT NULL,
  `url` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `country_id` varchar(2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comments` mediumtext NOT NULL,
  `changes` mediumtext NOT NULL,
  `ip` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`website_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directory_update`
--

LOCK TABLES `directory_update` WRITE;
/*!40000 ALTER TABLE `directory_update` DISABLE KEYS */;
/*!40000 ALTER TABLE `directory_update` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directory_user`
--

DROP TABLE IF EXISTS `directory_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `super_user` tinyint(1) NOT NULL,
  `salt` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ix_login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directory_user`
--

LOCK TABLES `directory_user` WRITE;
/*!40000 ALTER TABLE `directory_user` DISABLE KEYS */;
INSERT INTO `directory_user` VALUES (1,'admin','8a23307a0c66a9441025ba2c3e959906','2013-09-15 06:22:33','2013-09-14 18:00:00',1,1,'77c10f8a4b497c0a0ea2cb821ceba17b');
/*!40000 ALTER TABLE `directory_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directory_user_upload`
--

DROP TABLE IF EXISTS `directory_user_upload`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_user_upload` (
  `website_id` int unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comments` mediumtext NOT NULL,
  `ip` varchar(64) NOT NULL,
  PRIMARY KEY (`website_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directory_user_upload`
--

LOCK TABLES `directory_user_upload` WRITE;
/*!40000 ALTER TABLE `directory_user_upload` DISABLE KEYS */;
/*!40000 ALTER TABLE `directory_user_upload` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directory_website`
--

DROP TABLE IF EXISTS `directory_website`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_website` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int unsigned NOT NULL,
  `lang_id` varchar(5) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` mediumtext NOT NULL,
  `md5url` varchar(32) NOT NULL,
  `url` text NOT NULL,
  `type` tinyint unsigned NOT NULL,
  `country_id` varchar(2) NOT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ix_status_lang_created` (`status`,`lang_id`,`created_at`),
  KEY `ix_category_status_lang` (`category_id`,`status`,`lang_id`),
  KEY `ix_md5url` (`md5url`),
  KEY `ix_country_status_lang_created` (`country_id`,`status`,`lang_id`,`created_at`),
  FULLTEXT KEY `ix_description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directory_website`
--

LOCK TABLES `directory_website` WRITE;
/*!40000 ALTER TABLE `directory_website` DISABLE KEYS */;
/*!40000 ALTER TABLE `directory_website` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-06-14  7:48:53
