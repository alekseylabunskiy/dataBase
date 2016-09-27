-- MySQL dump 10.13  Distrib 5.6.22, for Win32 (x86)
--
-- Host: localhost    Database: users
-- ------------------------------------------------------
-- Server version	5.6.22-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `parent` varchar(45) NOT NULL,
  `child` varchar(45) NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES (1,'3','4'),(3,'1','2'),(5,'2','3');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_image` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (69,'57e8d93075c6b48a5ba0a7951d86a91168cd7e3b046db.jpg',2,'2016-09-26 11:15:44'),(70,'57e8d9362659d414a46ee9b6929702a20d74f2616e7c0.jpg',2,'2016-09-26 11:15:50'),(73,'57e8da0d749ffd40e64d97f0cd7a02e299a2d5a419c80.jpg',1,'2016-09-26 11:19:25'),(79,'57e8db93073b7652a6217efd0af62daf1d44f0c11927c.jpg',3,'2016-09-26 11:25:55'),(80,'57e8dbaabbcd0658db3c2532e139d2e74c310962981e5.jpg',4,'2016-09-26 11:26:18'),(81,'57e8dbbab7c50980c2dfd9caa6cb0a4eccb0de395f146.jpg',2,'2016-09-26 11:26:34'),(82,'57e8dcf5cd5a09cf62d5f2dcb1f113d8b8ba71ba904d4.jpg',1,'2016-09-26 11:31:49'),(83,'57e8e0407f19d0116353a58f0901f26c93ef47380fabb.jpg',1,'2016-09-26 11:45:52'),(84,'57e8e04d0daafd84e0cb101decfdd712f150c2a179376.png',2,'2016-09-26 11:46:05'),(85,'57e91344caf95728d3eab03f0130b3d110de77fac459f.jpg',3,'2016-09-26 15:23:32'),(88,'57e95465767b588db12bf334226a4fc94b70bc09a3f6e.jpg',56,'2016-09-26 20:01:25'),(93,'57ea045e6cb8af281e1724cbe05d6afb055e673868f51.jpg',56,'2016-09-27 08:32:14'),(94,'57ea047be3c9d81cb4c8a9c792e40517fce8daff7682b.jpg',56,'2016-09-27 08:32:43'),(96,'57ea06a56e71dc527c71b918c8118f9641d4ef624848e.jpg',56,'2016-09-27 08:41:57'),(97,'57ea06d81b59b5849962ddd8bbf6b563bce302e6e39b8.jpg',56,'2016-09-27 08:42:48'),(98,'57ea071da1266192e23fc8ab25e8e45c9751107f0b2b6.jpg',56,'2016-09-27 08:43:57'),(99,'57ea088544bd2b8cacc24ab3d8de067bc89a794d73455.jpg',56,'2016-09-27 08:49:57'),(100,'57ea0ac4bf87c7b9cf74d6dcb4a0b84abc7eee7c30323.jpg',56,'2016-09-27 08:59:32'),(101,'57ea0be3a854fef43f0f3894e0bd2dcb1d4fad2dfacde.jpg',56,'2016-09-27 09:04:19'),(102,'57ea0e046666eed1aba07aa718713114b774c505ad558.jpg',3,'2016-09-27 09:13:24'),(103,'57ea0e2018abcb059b9844bd2cdbb4d524bac4f6e099b.jpg',2,'2016-09-27 09:13:52'),(104,'57ea116de93327fbaf4258276c62c69fca02d4e655de4.png',56,'2016-09-27 09:27:57'),(105,'57ea1193cd85b80ac64153c2368c52341a9321cf9ff69.jpg',56,'2016-09-27 09:28:35');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `privs`
--

DROP TABLE IF EXISTS `privs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `privs` (
  `priv_id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `controller_name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`priv_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `privs`
--

LOCK TABLES `privs` WRITE;
/*!40000 ALTER TABLE `privs` DISABLE KEYS */;
INSERT INTO `privs` VALUES (1,'ROLE_UPDATE','roles','може керувати ролями'),(2,'USER_UPDATE','add_user','може додавати, переглядати список, видаляти і редагувати користувачів'),(3,'USER_STATUS','user_status','може переглядати список користувачів, змінювати статус користувача'),(4,'USER_INDEX','main_list','може тільки переглядати користувачів і сторінку власного профілю'),(5,'PRIV_INDEX','privs','може керувати привілегіями'),(6,'ROLE_INDEX','null','Дозвіл на перегляд сторінки ролей'),(7,'ROLE_CREATE','','Дає право доступу до створення ролі');
/*!40000 ALTER TABLE `privs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `privs2roles`
--

DROP TABLE IF EXISTS `privs2roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `privs2roles` (
  `pr_id` int(11) NOT NULL AUTO_INCREMENT,
  `priv_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`pr_id`),
  KEY `priv_id` (`priv_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `privs2roles_ibfk_1` FOREIGN KEY (`priv_id`) REFERENCES `privs` (`priv_id`) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `privs2roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `privs2roles`
--

LOCK TABLES `privs2roles` WRITE;
/*!40000 ALTER TABLE `privs2roles` DISABLE KEYS */;
INSERT INTO `privs2roles` VALUES (1,1,1),(2,5,1),(3,2,2),(4,3,3),(5,4,4),(6,6,1),(7,7,1);
/*!40000 ALTER TABLE `privs2roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `role_id` int(5) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'root','може керувати ролями та привілегіями'),(2,'admin','може додавати, переглядати список, видаляти і редагувати користувачів'),(3,'moderator','може переглядати список користувачів, змінювати статус користувача.'),(4,'user','може тільки переглядати користувачів і сторінку власного профілю.');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id_session` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sid` varchar(10) NOT NULL,
  `time_start` datetime NOT NULL,
  `time_last` datetime NOT NULL,
  PRIMARY KEY (`id_session`),
  UNIQUE KEY `sid` (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=959 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES (958,1,'HItJyPhHNq','2016-09-27 07:37:42','2016-09-27 09:33:17');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(5) NOT NULL AUTO_INCREMENT,
  `password` varchar(32) NOT NULL,
  `role_id` int(5) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_avatar` varchar(255) DEFAULT NULL,
  `user_status` int(11) NOT NULL,
  `user_date_register` datetime DEFAULT NULL,
  `user_last_active` datetime NOT NULL,
  `user_time_update` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'f9eb2327784f3c18d1e84ea47a267280',1,'test','test@test.ru','57e8e0407f19d0116353a58f0901f26c93ef47380fabb.jpg',1,'2015-05-20 16:00:00','2018-06-20 16:00:00','2016-09-24 16:40:49'),(2,'0ed610b5d2394763730ec36053749047',2,'two','two@two.ua','57ea0e2018abcb059b9844bd2cdbb4d524bac4f6e099b.jpg',1,'2014-02-20 15:00:00','2016-05-20 16:00:00','2016-09-27 09:13:54'),(3,'0ce44545033c317ac7c358cb940c9070',3,'three','three@three.ua','57ea0e046666eed1aba07aa718713114b774c505ad558.jpg',1,'2025-02-20 13:00:00','2025-08-20 15:00:00','2016-09-27 09:13:28'),(4,'e97412a5a29d228e81ab6ae8656cfb78',4,'for','for@for.ua','57e8dbaabbcd0658db3c2532e139d2e74c310962981e5.jpg',1,'2015-03-20 14:00:00','0000-00-00 00:00:00','2016-09-25 18:37:39'),(56,'124cdd1c657fa7f3d680a8dff1c14cb0',4,'aca','test2@tesgggrg2.fd','57ea1193cd85b80ac64153c2368c52341a9321cf9ff69.jpg',1,'2016-09-26 18:49:31','0000-00-00 00:00:00','2016-09-27 09:33:01');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `delete images` BEFORE DELETE ON `users` FOR EACH ROW DELETE FROM images WHERE user_id = OLD.user_id */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-27  9:38:29
