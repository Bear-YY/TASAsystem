-- MariaDB dump 10.18  Distrib 10.4.16-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: tasa2021
-- ------------------------------------------------------
-- Server version	10.4.16-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tb_answer`
--

DROP TABLE IF EXISTS `tb_answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_answer` (
  `ans_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stu_id` char(7) NOT NULL,
  `que_id` int(10) unsigned NOT NULL,
  `ans_day` date DEFAULT NULL,
  `ans_value` int(11) DEFAULT NULL,
  PRIMARY KEY (`ans_id`,`stu_id`,`que_id`),
  UNIQUE KEY `ans_id` (`ans_id`),
  KEY `stu_id` (`stu_id`),
  KEY `que_id` (`que_id`),
  CONSTRAINT `tb_answer_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `tb_student` (`stu_id`),
  CONSTRAINT `tb_answer_ibfk_2` FOREIGN KEY (`que_id`) REFERENCES `tb_questionnaire` (`que_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_answer`
--

LOCK TABLES `tb_answer` WRITE;
/*!40000 ALTER TABLE `tb_answer` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_application`
--

DROP TABLE IF EXISTS `tb_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_application` (
  `app_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stu_id` char(7) NOT NULL,
  `rec_id` int(10) unsigned NOT NULL,
  `app_day` date DEFAULT NULL,
  `app_comment` text DEFAULT NULL,
  `app_result` int(11) DEFAULT NULL,
  PRIMARY KEY (`app_id`,`stu_id`,`rec_id`),
  UNIQUE KEY `app_id` (`app_id`),
  KEY `stu_id` (`stu_id`),
  KEY `rec_id` (`rec_id`),
  CONSTRAINT `tb_application_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `tb_student` (`stu_id`),
  CONSTRAINT `tb_application_ibfk_2` FOREIGN KEY (`rec_id`) REFERENCES `tb_recruitment` (`rec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_application`
--

LOCK TABLES `tb_application` WRITE;
/*!40000 ALTER TABLE `tb_application` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_category`
--

DROP TABLE IF EXISTS `tb_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_category` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_category`
--

LOCK TABLES `tb_category` WRITE;
/*!40000 ALTER TABLE `tb_category` DISABLE KEYS */;
INSERT INTO `tb_category` VALUES (1,'ソフトウェア'),(2,'ハードウェア'),(3,'数学'),(4,'インターネット・WEB'),(5,'情報処理');
/*!40000 ALTER TABLE `tb_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_config`
--

DROP TABLE IF EXISTS `tb_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_config` (
  `tt_id` int(10) unsigned NOT NULL,
  `que_id` int(10) unsigned NOT NULL,
  `con_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `con_value` int(11) DEFAULT NULL,
  PRIMARY KEY (`con_id`,`tt_id`,`que_id`),
  UNIQUE KEY `con_id` (`con_id`),
  KEY `tt_id` (`tt_id`),
  KEY `que_id` (`que_id`),
  CONSTRAINT `tb_config_ibfk_1` FOREIGN KEY (`tt_id`) REFERENCES `tb_timetable` (`tt_id`),
  CONSTRAINT `tb_config_ibfk_2` FOREIGN KEY (`que_id`) REFERENCES `tb_questionnaire` (`que_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_config`
--

LOCK TABLES `tb_config` WRITE;
/*!40000 ALTER TABLE `tb_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_course`
--

DROP TABLE IF EXISTS `tb_course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_course` (
  `cou_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stu_id` char(7) NOT NULL,
  `sub_id` int(10) unsigned NOT NULL,
  `grade` int(11) DEFAULT NULL,
  `cou_year` int(11) DEFAULT NULL,
  PRIMARY KEY (`cou_id`,`stu_id`,`sub_id`),
  UNIQUE KEY `cou_id` (`cou_id`),
  KEY `stu_id` (`stu_id`),
  KEY `sub_id` (`sub_id`),
  CONSTRAINT `tb_course_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `tb_student` (`stu_id`),
  CONSTRAINT `tb_course_ibfk_2` FOREIGN KEY (`sub_id`) REFERENCES `tb_subject` (`sub_id`)
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_course`
--

LOCK TABLES `tb_course` WRITE;
/*!40000 ALTER TABLE `tb_course` DISABLE KEYS */;
INSERT INTO `tb_course` VALUES (1,'30RS001',1,2,2030),(2,'30RS001',2,2,2031),(3,'30RS001',3,2,2030),(4,'30RS001',6,4,2030),(5,'30RS001',7,3,2030),(6,'30RS001',8,1,2031),(7,'30RS001',10,3,2030),(8,'30RS001',12,4,2030),(9,'30RS001',16,2,2030),(10,'30RS001',17,3,2030),(11,'30RS001',4,4,2030),(12,'30RS001',18,4,2032),(13,'30RS001',11,2,2031),(14,'30RS001',9,4,2030),(15,'30RS001',13,3,2031),(16,'30RS002',1,2,2030),(17,'30RS002',2,2,2031),(18,'30RS002',3,3,2030),(19,'30RS002',6,2,2030),(20,'30RS002',7,1,2030),(21,'30RS002',8,1,2031),(22,'30RS002',10,4,2030),(23,'30RS002',12,3,2030),(24,'30RS002',16,2,2030),(25,'30RS002',17,2,2030),(26,'30RS002',11,4,2031),(27,'30RS002',4,3,2030),(28,'30RS002',9,3,2030),(29,'30RS002',14,1,2031),(30,'30RS002',5,3,2031),(31,'30RS003',1,3,2030),(32,'30RS003',2,3,2031),(33,'30RS003',3,4,2030),(34,'30RS003',6,2,2030),(35,'30RS003',7,3,2030),(36,'30RS003',8,1,2031),(37,'30RS003',10,2,2030),(38,'30RS003',12,1,2030),(39,'30RS003',16,2,2030),(40,'30RS003',17,2,2030),(41,'30RS003',20,3,2030),(42,'30RS003',13,4,2031),(43,'30RS003',9,4,2030),(44,'30RS003',11,3,2031),(45,'30RS003',5,3,2031),(46,'30RS004',1,4,2030),(47,'30RS004',2,3,2031),(48,'30RS004',3,4,2030),(49,'30RS004',6,2,2030),(50,'30RS004',7,2,2030),(51,'30RS004',8,3,2031),(52,'30RS004',10,4,2030),(53,'30RS004',12,3,2030),(54,'30RS004',16,4,2030),(55,'30RS004',17,3,2030),(56,'30RS004',9,4,2030),(57,'30RS004',19,4,2030),(58,'30RS004',4,1,2030),(59,'30RS004',11,3,2031),(60,'30RS004',5,1,2031),(61,'30RS005',1,1,2030),(62,'30RS005',2,1,2031),(63,'30RS005',3,4,2030),(64,'30RS005',6,4,2030),(65,'30RS005',7,3,2030),(66,'30RS005',8,2,2031),(67,'30RS005',10,1,2030),(68,'30RS005',12,1,2030),(69,'30RS005',16,1,2030),(70,'30RS005',17,2,2030),(71,'30RS005',5,3,2031),(72,'30RS005',15,3,2030),(73,'30RS005',18,2,2032),(74,'30RS005',13,3,2031),(75,'30RS005',9,1,2030),(76,'30RS006',1,2,2030),(77,'30RS006',2,4,2031),(78,'30RS006',3,2,2030),(79,'30RS006',6,1,2030),(80,'30RS006',7,4,2030),(81,'30RS006',8,1,2031),(82,'30RS006',10,3,2030),(83,'30RS006',12,2,2030),(84,'30RS006',16,4,2030),(85,'30RS006',17,2,2030),(86,'30RS006',9,2,2030),(87,'30RS006',14,2,2031),(88,'30RS006',5,2,2031),(89,'30RS006',15,1,2030),(90,'30RS006',4,2,2030),(91,'30RS007',1,4,2030),(92,'30RS007',2,3,2031),(93,'30RS007',3,4,2030),(94,'30RS007',6,3,2030),(95,'30RS007',7,2,2030),(96,'30RS007',8,4,2031),(97,'30RS007',10,4,2030),(98,'30RS007',12,2,2030),(99,'30RS007',16,2,2030),(100,'30RS007',17,1,2030),(101,'30RS007',20,1,2030),(102,'30RS007',9,2,2030),(103,'30RS007',5,3,2031),(104,'30RS007',13,1,2031),(105,'30RS007',11,2,2031),(106,'30RS008',1,1,2030),(107,'30RS008',2,4,2031),(108,'30RS008',3,3,2030),(109,'30RS008',6,3,2030),(110,'30RS008',7,2,2030),(111,'30RS008',8,1,2031),(112,'30RS008',10,3,2030),(113,'30RS008',12,4,2030),(114,'30RS008',16,3,2030),(115,'30RS008',17,4,2030),(116,'30RS008',20,2,2030),(117,'30RS008',9,2,2030),(118,'30RS008',5,2,2031),(119,'30RS008',13,2,2031),(120,'30RS008',11,2,2031),(121,'30RS009',1,2,2030),(122,'30RS009',2,4,2031),(123,'30RS009',3,3,2030),(124,'30RS009',6,4,2030),(125,'30RS009',7,3,2030),(126,'30RS009',8,4,2031),(127,'30RS009',10,4,2030),(128,'30RS009',12,2,2030),(129,'30RS009',16,4,2030),(130,'30RS009',17,2,2030),(131,'30RS009',9,4,2030),(132,'30RS009',4,3,2030),(133,'30RS009',13,4,2031),(134,'30RS009',5,2,2031),(135,'30RS009',11,2,2031),(136,'30RS010',1,2,2030),(137,'30RS010',2,4,2031),(138,'30RS010',3,1,2030),(139,'30RS010',6,1,2030),(140,'30RS010',7,4,2030),(141,'30RS010',8,1,2031),(142,'30RS010',10,3,2030),(143,'30RS010',12,4,2030),(144,'30RS010',16,3,2030),(145,'30RS010',17,2,2030),(146,'30RS010',20,1,2030),(147,'30RS010',18,4,2032),(148,'30RS010',13,4,2031),(149,'30RS010',9,1,2030),(150,'30RS010',5,3,2031),(151,'30RS999',1,1,2030),(152,'30RS999',2,1,2031),(153,'30RS999',3,1,2030),(154,'30RS999',4,1,2030),(155,'30RS999',5,1,2031),(156,'30RS999',6,1,2030),(157,'30RS999',7,1,2030),(158,'30RS999',8,1,2031),(159,'30RS999',9,1,2030),(160,'30RS999',10,1,2030),(161,'30RS999',11,1,2031),(162,'30RS999',12,1,2030),(163,'30RS999',13,1,2031),(164,'30RS999',14,1,2031),(165,'30RS999',15,1,2030),(166,'30RS999',16,1,2030),(167,'30RS999',17,1,2030),(168,'30RS999',18,1,2032),(169,'30RS999',19,1,2030),(170,'30RS999',20,1,2030);
/*!40000 ALTER TABLE `tb_course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_department`
--

DROP TABLE IF EXISTS `tb_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_department` (
  `dpt_id` char(2) NOT NULL,
  `fct_id` char(1) NOT NULL,
  `dpt_name` varchar(16) NOT NULL,
  PRIMARY KEY (`dpt_id`,`fct_id`),
  KEY `fct_id` (`fct_id`),
  CONSTRAINT `tb_department_ibfk_1` FOREIGN KEY (`fct_id`) REFERENCES `tb_faculty` (`fct_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_department`
--

LOCK TABLES `tb_department` WRITE;
/*!40000 ALTER TABLE `tb_department` DISABLE KEYS */;
INSERT INTO `tb_department` VALUES ('RS','R','情報科学科');
/*!40000 ALTER TABLE `tb_department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_faculty`
--

DROP TABLE IF EXISTS `tb_faculty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_faculty` (
  `fct_id` char(1) NOT NULL,
  `fct_name` varchar(16) NOT NULL,
  PRIMARY KEY (`fct_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_faculty`
--

LOCK TABLES `tb_faculty` WRITE;
/*!40000 ALTER TABLE `tb_faculty` DISABLE KEYS */;
INSERT INTO `tb_faculty` VALUES ('R','理工学部');
/*!40000 ALTER TABLE `tb_faculty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_questionnaire`
--

DROP TABLE IF EXISTS `tb_questionnaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_questionnaire` (
  `que_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `que_title` text DEFAULT NULL,
  PRIMARY KEY (`que_id`),
  UNIQUE KEY `que_id` (`que_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_questionnaire`
--

LOCK TABLES `tb_questionnaire` WRITE;
/*!40000 ALTER TABLE `tb_questionnaire` DISABLE KEYS */;
INSERT INTO `tb_questionnaire` VALUES (1,'プログラミングに自信がある'),(2,'コミュニケーションが得意である'),(3,'教えることが好き'),(4,'数学が得意である'),(5,'プログラミングが好き');
/*!40000 ALTER TABLE `tb_questionnaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_recommend`
--

DROP TABLE IF EXISTS `tb_recommend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_recommend` (
  `rcm_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tea_id` varchar(16) NOT NULL,
  `stu_id` char(7) NOT NULL,
  `rec_id` int(10) unsigned NOT NULL,
  `rcm_day` date DEFAULT NULL,
  `rcm_result` int(11) DEFAULT NULL,
  `rcm_deadline` datetime NOT NULL,
  `rcm_comment` text DEFAULT NULL,
  `rcm_acomment` text DEFAULT NULL,
  PRIMARY KEY (`rec_id`,`tea_id`,`stu_id`,`rcm_id`),
  UNIQUE KEY `rcm_id` (`rcm_id`),
  KEY `tea_id` (`tea_id`),
  KEY `stu_id` (`stu_id`),
  CONSTRAINT `tb_recommend_ibfk_1` FOREIGN KEY (`tea_id`) REFERENCES `tb_teacher` (`tea_id`),
  CONSTRAINT `tb_recommend_ibfk_2` FOREIGN KEY (`stu_id`) REFERENCES `tb_student` (`stu_id`),
  CONSTRAINT `tb_recommend_ibfk_3` FOREIGN KEY (`rec_id`) REFERENCES `tb_recruitment` (`rec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_recommend`
--

LOCK TABLES `tb_recommend` WRITE;
/*!40000 ALTER TABLE `tb_recommend` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_recommend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_recruitment`
--

DROP TABLE IF EXISTS `tb_recruitment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_recruitment` (
  `rec_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tt_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `tea_id` varchar(16) NOT NULL,
  `rec_day` date DEFAULT NULL,
  `rec_comment` text DEFAULT NULL,
  `rec_num` int(11) DEFAULT NULL,
  PRIMARY KEY (`rec_id`,`tt_id`,`role_id`,`tea_id`),
  UNIQUE KEY `rec_id` (`rec_id`),
  KEY `tt_id` (`tt_id`),
  KEY `role_id` (`role_id`),
  KEY `tea_id` (`tea_id`),
  CONSTRAINT `tb_recruitment_ibfk_1` FOREIGN KEY (`tt_id`) REFERENCES `tb_timetable` (`tt_id`),
  CONSTRAINT `tb_recruitment_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `tb_role` (`role_id`),
  CONSTRAINT `tb_recruitment_ibfk_3` FOREIGN KEY (`tea_id`) REFERENCES `tb_teacher` (`tea_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_recruitment`
--

LOCK TABLES `tb_recruitment` WRITE;
/*!40000 ALTER TABLE `tb_recruitment` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_recruitment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_role`
--

DROP TABLE IF EXISTS `tb_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_role` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_kind` varchar(2) DEFAULT NULL,
  `role_condition` text DEFAULT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_role`
--

LOCK TABLES `tb_role` WRITE;
/*!40000 ALTER TABLE `tb_role` DISABLE KEYS */;
INSERT INTO `tb_role` VALUES (1,'SA','学部生,成績A以上'),(2,'TA','院生,成績A以上');
/*!40000 ALTER TABLE `tb_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_schedule`
--

DROP TABLE IF EXISTS `tb_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_schedule` (
  `sch_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stu_id` char(7) NOT NULL,
  `sch_name` varchar(16) NOT NULL,
  `sch_weekday` int(11) DEFAULT NULL,
  `sch_timed` int(11) DEFAULT NULL,
  `sch_detail` text DEFAULT NULL,
  `sch_semester` int(11) DEFAULT NULL,
  PRIMARY KEY (`sch_id`,`stu_id`),
  UNIQUE KEY `sch_id` (`sch_id`),
  KEY `stu_id` (`stu_id`),
  CONSTRAINT `tb_schedule_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `tb_student` (`stu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_schedule`
--

LOCK TABLES `tb_schedule` WRITE;
/*!40000 ALTER TABLE `tb_schedule` DISABLE KEYS */;
INSERT INTO `tb_schedule` VALUES (21,'30RS002','用事が...あるんだ...',2,1,'だから...俺が帰ってくるまで待ってくれないか？',2),(22,'30RS002','なんと',3,1,'用事があります。',2),(25,'30RS001','基礎数学',2,1,'まぁ大変',1),(26,'30RS999','アルバイト',2,1,'アルバイトしたいなー',1),(28,'30RS005','アルバイト',2,2,'アルバイトしたいなー',1),(29,'30RS005','病院',4,1,'午前中に病院に通う必要がある',2);
/*!40000 ALTER TABLE `tb_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_student`
--

DROP TABLE IF EXISTS `tb_student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_student` (
  `stu_id` char(7) NOT NULL,
  `dpt_id` char(2) NOT NULL,
  `usr_id` varchar(16) NOT NULL,
  `stu_name` varchar(16) NOT NULL,
  `stu_sex` int(11) DEFAULT NULL,
  `stu_phoneno` varchar(16) DEFAULT NULL,
  `stu_mail` varchar(32) DEFAULT NULL,
  `ad_year` int(11) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `stu_gpa` float DEFAULT NULL,
  `stu_unit` int(11) DEFAULT NULL,
  PRIMARY KEY (`stu_id`,`dpt_id`,`usr_id`),
  KEY `dpt_id` (`dpt_id`),
  KEY `usr_id` (`usr_id`),
  CONSTRAINT `tb_student_ibfk_1` FOREIGN KEY (`dpt_id`) REFERENCES `tb_department` (`dpt_id`),
  CONSTRAINT `tb_student_ibfk_2` FOREIGN KEY (`usr_id`) REFERENCES `tb_user` (`usr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_student`
--

LOCK TABLES `tb_student` WRITE;
/*!40000 ALTER TABLE `tb_student` DISABLE KEYS */;
INSERT INTO `tb_student` VALUES ('30RS001','RS','k30rs001','田中 亮',1,'090-5918-5777',NULL,2030,NULL,2.13,NULL),('30RS002','RS','k30rs002','伊藤 英樹',1,'090-1935-5508',NULL,2030,NULL,2.6,NULL),('30RS003','RS','k30rs003','山田 剛',1,'090-2300-9542',NULL,2030,NULL,2.3,NULL),('30RS004','RS','k30rs004','渡邉 和彦',1,'090-1935-5508',NULL,2030,NULL,2,NULL),('30RS005','RS','k30rs005','吉田 宏之',1,'090-8055-6286',NULL,2030,NULL,2.87,NULL),('30RS006','RS','k30rs006','田中 一男',1,'090-5918-5779',NULL,2030,NULL,2.73,NULL),('30RS007','RS','k30rs007','木村 友里',2,'090-0441-9923',NULL,2030,NULL,2.47,NULL),('30RS008','RS','k30rs008','山内 洋子',2,'090-2625-6453',NULL,2030,NULL,2.46,NULL),('30RS009','RS','k30rs009','藤田 絵里',2,'090-8055-6286',NULL,2030,NULL,1.87,NULL),('30RS010','RS','k30rs010','松下 直美',2,'090-0808-0949',NULL,2030,NULL,2.47,NULL),('30RS999','RS','k30rs999','完璧 太郎',1,'090-5918-5778',NULL,2030,NULL,4,NULL);
/*!40000 ALTER TABLE `tb_student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_subject`
--

DROP TABLE IF EXISTS `tb_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_subject` (
  `sub_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dpt_id` char(2) NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `sub_name` varchar(16) NOT NULL,
  `sub_unit` int(11) DEFAULT NULL,
  `get_year` int(11) DEFAULT NULL,
  `sub_section` int(11) DEFAULT NULL,
  PRIMARY KEY (`sub_id`,`dpt_id`,`category_id`),
  UNIQUE KEY `sub_id` (`sub_id`),
  KEY `dpt_id` (`dpt_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `tb_subject_ibfk_1` FOREIGN KEY (`dpt_id`) REFERENCES `tb_department` (`dpt_id`),
  CONSTRAINT `tb_subject_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `tb_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_subject`
--

LOCK TABLES `tb_subject` WRITE;
/*!40000 ALTER TABLE `tb_subject` DISABLE KEYS */;
INSERT INTO `tb_subject` VALUES (1,'RS',1,'プログラミング基礎Ⅰ',2,1,1),(2,'RS',1,'プログラミング基礎Ⅱ',2,2,1),(3,'RS',1,'データ構造とアルゴリズムⅠ',2,1,1),(4,'RS',1,'ゲームプログラミング演習',2,1,2),(5,'RS',2,'組込みソフトウェア',2,2,2),(6,'RS',2,'ハードウェア設計Ⅰ',2,1,1),(7,'RS',2,'計算機構成論Ⅰ',2,1,1),(8,'RS',2,'ハードウェア設計Ⅱ',2,2,1),(9,'RS',3,'統計学',2,1,2),(10,'RS',3,'離散数学Ⅰ',2,1,1),(11,'RS',3,'離散数学Ⅱ',2,2,2),(12,'RS',3,'線形代数Ⅰ',2,1,1),(13,'RS',4,'データベース',2,2,2),(14,'RS',4,'WEBプログラミング演習',2,2,2),(15,'RS',4,'クラウドプログラミング演習',2,1,2),(16,'RS',4,'コンピュータネットワーク',2,1,1),(17,'RS',5,'情報リテラシー',2,1,1),(18,'RS',5,'プロジェクトデザイン管理',2,3,2),(19,'RS',5,'情報処理技術Ⅰ',2,1,2),(20,'RS',5,'技術者倫理',2,1,2);
/*!40000 ALTER TABLE `tb_subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_teacher`
--

DROP TABLE IF EXISTS `tb_teacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_teacher` (
  `tea_id` varchar(16) NOT NULL,
  `usr_id` varchar(16) NOT NULL,
  `dpt_id` char(2) NOT NULL,
  `tea_name` varchar(16) NOT NULL,
  `tea_mail` varchar(32) DEFAULT NULL,
  `tea_phoneno` varchar(16) DEFAULT NULL,
  `tea_room` varchar(16) DEFAULT NULL,
  `tea_sex` int(11) DEFAULT NULL,
  PRIMARY KEY (`tea_id`,`usr_id`,`dpt_id`),
  KEY `usr_id` (`usr_id`),
  KEY `dpt_id` (`dpt_id`),
  CONSTRAINT `tb_teacher_ibfk_1` FOREIGN KEY (`usr_id`) REFERENCES `tb_user` (`usr_id`),
  CONSTRAINT `tb_teacher_ibfk_2` FOREIGN KEY (`dpt_id`) REFERENCES `tb_department` (`dpt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_teacher`
--

LOCK TABLES `tb_teacher` WRITE;
/*!40000 ALTER TABLE `tb_teacher` DISABLE KEYS */;
INSERT INTO `tb_teacher` VALUES ('higuchi','higuchi','RS','樋口 憲一',NULL,'090-9635-5073',NULL,1),('kato','kato','RS','加藤　亮輔',NULL,'090-6929-6453',NULL,1),('konishi','konishi','RS','小西 英樹',NULL,'090-3465-8946',NULL,1),('matumoto','matumoto','RS','松本 敏之',NULL,'090-7069-6114',NULL,1),('thuchiya','thuchiya','RS','土屋 愛子',NULL,'090-4390-2387',NULL,2),('yamagishi','yamagishi','RS','山岸 茂',NULL,'090-9713-6390',NULL,1);
/*!40000 ALTER TABLE `tb_teacher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_timetable`
--

DROP TABLE IF EXISTS `tb_timetable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_timetable` (
  `tt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tea_id` varchar(16) NOT NULL,
  `sub_id` int(10) unsigned NOT NULL,
  `semester` int(11) DEFAULT NULL,
  `tt_weekday` int(11) DEFAULT NULL,
  `tt_timed` int(11) DEFAULT NULL,
  `tt_year` int(11) DEFAULT NULL,
  `tt_classnum` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`tt_id`,`tea_id`,`sub_id`) USING BTREE,
  UNIQUE KEY `tt_id` (`tt_id`),
  KEY `tea_id` (`tea_id`),
  KEY `sub_id` (`sub_id`),
  CONSTRAINT `tb_timetable_ibfk_1` FOREIGN KEY (`tea_id`) REFERENCES `tb_teacher` (`tea_id`),
  CONSTRAINT `tb_timetable_ibfk_2` FOREIGN KEY (`sub_id`) REFERENCES `tb_subject` (`sub_id`),
  CONSTRAINT `tb_timetable_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `tb_role` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_timetable`
--

LOCK TABLES `tb_timetable` WRITE;
/*!40000 ALTER TABLE `tb_timetable` DISABLE KEYS */;
INSERT INTO `tb_timetable` VALUES (1,'kato',1,1,2,1,2030,'12104'),(2,'kato',2,2,2,2,2031,'12104'),(3,'kato',3,2,3,1,2030,'12107'),(4,'kato',4,1,3,3,2030,'12107'),(5,'matumoto',5,1,1,3,2031,'12203'),(6,'matumoto',6,2,1,1,2030,'12201'),(7,'matumoto',7,1,3,2,2030,'12103'),(8,'matumoto',8,2,3,3,2031,'12203'),(9,'konishi',9,1,4,4,2030,'12106'),(10,'konishi',10,1,4,3,2030,'12109'),(11,'konishi',11,2,5,4,2031,'12107'),(12,'konishi',12,2,5,2,2030,'12108'),(13,'yamagishi',13,2,2,1,2031,'12109'),(14,'yamagishi',14,1,2,2,2031,'12201'),(15,'yamagishi',15,2,5,3,2030,'12104'),(16,'yamagishi',16,1,5,1,2030,'12105'),(17,'thuchiya',17,2,3,4,2030,'12103'),(18,'thuchiya',18,1,2,1,2032,'12107'),(19,'thuchiya',19,2,4,3,2030,'12208'),(20,'thuchiya',20,1,1,4,2030,'12209');
/*!40000 ALTER TABLE `tb_timetable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_user`
--

DROP TABLE IF EXISTS `tb_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_user` (
  `usr_id` varchar(16) NOT NULL,
  `usr_name` varchar(16) NOT NULL,
  `passwd` varchar(16) NOT NULL,
  `usr_kind` int(11) DEFAULT NULL,
  `usr_mail` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`usr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_user`
--

LOCK TABLES `tb_user` WRITE;
/*!40000 ALTER TABLE `tb_user` DISABLE KEYS */;
INSERT INTO `tb_user` VALUES ('higuchi','樋口 憲一','9876',9,'admin@ad.kyusan.ac.jp'),('k30rs001','田中 亮','30001',1,'k30rs001@st.kyusan.ac.jp'),('k30rs002','伊藤 英樹','30002',1,'k30rs002@st.kyusan.ac.jp'),('k30rs003','山田 剛','30003',1,'k30rs003@st.kyusan.ac.jp'),('k30rs004','渡邉 和彦','30004',1,'k30rs004@st.kyusan.ac.jp'),('k30rs005','吉田 宏之','30005',1,'k30rs005@st.kyusan.ac.jp'),('k30rs006','田中 一男','30006',1,'k30rs006@st.kyusan.ac.jp'),('k30rs007','木村 友里','30007',1,'k30rs007@st.kyusan.ac.jp'),('k30rs008','山内 洋子','30008',1,'k30rs008@st.kyusan.ac.jp'),('k30rs009','藤田 絵里','30009',1,'k30rs009@st.kyusan.ac.jp'),('k30rs010','松下 直美','30010',1,'k30rs010@st.kyusan.ac.jp'),('k30rs999','完璧 太郎','30999',1,'k30rs999@st.kyusan.ac.jp'),('kato','加藤 亮輔','1234',2,'kato@is.kyusan.ac.jp'),('konishi','小西 英樹','3456',2,'konishi@is.kyusan.ac.jp'),('matumoto','松本 敏之','2345',2,'matumoto@is.kyusan.ac.jp'),('thuchiya','土屋 愛子','5678',2,'thuchiya@is.kyusan.ac.jp'),('yamagishi','山岸 茂','4567',2,'yamagishi@is.kyusan.ac.jp');
/*!40000 ALTER TABLE `tb_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-10-13 19:12:50
