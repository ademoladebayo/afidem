-- MySQL dump 10.13  Distrib 8.0.26, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: sshub_db
-- ------------------------------------------------------
-- Server version	8.0.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cbt`
--

DROP TABLE IF EXISTS `cbt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cbt` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cbt_title` varchar(45) NOT NULL,
  `cbt_date` varchar(45) NOT NULL,
  `cbt_status` varchar(45) DEFAULT 'CLOSE',
  `start_time` varchar(45) NOT NULL,
  `cbt_duration` varchar(45) NOT NULL,
  `cbt_instruction` varchar(45) NOT NULL,
  `cbt_question` mediumtext NOT NULL,
  `cbt_options` mediumtext NOT NULL,
  `cbt_answer` mediumtext NOT NULL,
  `cbt_questions_number` mediumtext NOT NULL,
  `subject_id` varchar(45) NOT NULL,
  `class_id` varchar(45) NOT NULL,
  `session` varchar(45) NOT NULL,
  `term` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt`
--

LOCK TABLES `cbt` WRITE;
/*!40000 ALTER TABLE `cbt` DISABLE KEYS */;
INSERT INTO `cbt` VALUES (1,'FIRST CA','12/11/2021','OPEN','12:06','00:02:00','ANSWER ALL QUESTION','I am Ademola ⌑ what is my second name ?,I am a nigerian ⌑ what state am i from ?,what is your sister name ?','Ayobami ® Adebayo~james® moyo~Option C~Option D~,KwAra ⌑® kogi~Ondo ® okitipupa ⌑ ®~Option C~Option D~,christy~chrity and eliza~none~all~','A,B,B','0,1,2','1','12','2020/2021','FIRST TERM');
/*!40000 ALTER TABLE `cbt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbt_result`
--

DROP TABLE IF EXISTS `cbt_result`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cbt_result` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cbt_id` varchar(45) NOT NULL,
  `student_id` varchar(45) NOT NULL,
  `score` varchar(45) NOT NULL,
  `answer` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_result`
--

LOCK TABLES `cbt_result` WRITE;
/*!40000 ALTER TABLE `cbt_result` DISABLE KEYS */;
INSERT INTO `cbt_result` VALUES (1,'1','3','3','A,B,B');
/*!40000 ALTER TABLE `cbt_result` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `class_name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_teacher` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class`
--

LOCK TABLES `class` WRITE;
/*!40000 ALTER TABLE `class` DISABLE KEYS */;
INSERT INTO `class` VALUES (1,'JSS 1A','13'),(9,'JSS 1B','1'),(10,'JSS 2A','1'),(12,'JSS 2C','12'),(14,'JSS 3A','8'),(16,'JSS 1D','4'),(18,'JSS 2B','-');
/*!40000 ALTER TABLE `class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2021_09_11_175000_student_table',1),(2,'2021_09_12_110341_class_table',1),(7,'2021_09_14_084352_teacher_table',3),(8,'2021_09_26_152532_subject_table',4),(9,'2019_12_14_000001_create_personal_access_tokens_table',5);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=284 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Model\\TeacherModel',14,'token','99aa52e1be26fa5a880008e9e8caa2a9ae9011e29f2a675fdf79ba4f18c7393f','[\"*\"]',NULL,'2021-10-15 18:21:51','2021-10-15 18:21:51'),(2,'App\\Model\\TeacherModel',14,'token','8101a08288ade3ed6d51b1eb93fd6c95be245c1f2fdce310a569849ad9bbadea','[\"*\"]',NULL,'2021-10-15 18:24:13','2021-10-15 18:24:13'),(3,'App\\Model\\TeacherModel',14,'token','abcfd8e02cc2b36816fa5fb0ccbee723974bec659aa661f8401bafce5c3438a8','[\"*\"]',NULL,'2021-10-15 18:26:34','2021-10-15 18:26:34'),(4,'App\\Model\\TeacherModel',14,'token','a28bb412960f346e34e5577753fddffcf645676f5a31ea1dbc837e217ded11b1','[\"*\"]',NULL,'2021-10-15 19:03:04','2021-10-15 19:03:04'),(5,'App\\Model\\TeacherModel',14,'token','60c8ff491cde5d5aa35afdceedadf68f2839da2d1b82b265f9d2f1bae54a842a','[\"*\"]','2021-10-15 19:08:08','2021-10-15 19:07:20','2021-10-15 19:08:08'),(6,'App\\Model\\TeacherModel',14,'token','fe61373f98d027d2903451687c93250f71a5e932c837f73ac410861009199d3e','[\"*\"]','2021-10-15 19:31:08','2021-10-15 19:10:24','2021-10-15 19:31:08'),(7,'App\\Model\\TeacherModel',14,'token','741e536149c004c9a179be69ebcc83725a01f64cc8816e3855b2d0412a2477ea','[\"*\"]','2021-10-15 19:34:05','2021-10-15 19:33:58','2021-10-15 19:34:05'),(8,'App\\Model\\TeacherModel',14,'token','6b579baae358a9d9cd9e9b0e7d39591bfea5b5ef85a8b9848eb4cebb8f0e3228','[\"*\"]','2021-10-15 19:42:00','2021-10-15 19:38:04','2021-10-15 19:42:00'),(9,'App\\Model\\TeacherModel',14,'token','07f10bd99fad15ed3a9ce437736fd330b9803f93f7ba3e615c018d359e069566','[\"*\"]','2021-10-15 19:44:42','2021-10-15 19:42:07','2021-10-15 19:44:42'),(10,'App\\Model\\TeacherModel',14,'token','0146137fe22b9f34bb5b6d3dcc24d6fee489311ad34c4d589147fcb7c5a0f95b','[\"*\"]','2021-10-15 19:48:35','2021-10-15 19:47:40','2021-10-15 19:48:35'),(11,'App\\Model\\TeacherModel',15,'token','7a968c3ee801717ae4b700d5368c9a9b01fc2c7e0fdda9416c641afdd5a644e7','[\"*\"]',NULL,'2021-10-17 15:06:43','2021-10-17 15:06:43'),(12,'App\\Model\\TeacherModel',15,'token','05a499d29e33ff97bb68e085060ebe63701f9b700432632b6c27b5a653bffc29','[\"*\"]',NULL,'2021-10-17 15:48:19','2021-10-17 15:48:19'),(13,'App\\Model\\TeacherModel',15,'token','6606f33405da45294730b075fbcd640d0103cb096059687bb9b1144c58c562ae','[\"*\"]',NULL,'2021-10-17 15:52:14','2021-10-17 15:52:14'),(14,'App\\Model\\TeacherModel',15,'token','8a3353ae2b4b71f8a777c8923853c7822a3434c260b1f389e6034cc866c90c49','[\"*\"]',NULL,'2021-10-17 15:54:43','2021-10-17 15:54:43'),(15,'App\\Model\\TeacherModel',15,'token','ee282a8b29bea262fd57ee13b32281877e86cc3acb07f4f798b30b80f3a46dcf','[\"*\"]',NULL,'2021-10-18 10:01:19','2021-10-18 10:01:19'),(16,'App\\Model\\TeacherModel',12,'token','b318ad72a9f7f5fad010c69f155e7e03c3d34285698cd2650bbba923942e6987','[\"*\"]',NULL,'2021-10-18 10:05:07','2021-10-18 10:05:07'),(17,'App\\Model\\TeacherModel',12,'token','c6ac5ab9b725f39cef3a0db54e9bfa116cce59bcd7c2e23ae23d31d8597746e4','[\"*\"]',NULL,'2021-10-18 10:09:41','2021-10-18 10:09:41'),(18,'App\\Model\\TeacherModel',12,'token','5e7c87c264cab63de6988cc450debf570b8f760b01353596b341472dfc1bd9da','[\"*\"]',NULL,'2021-10-18 10:10:10','2021-10-18 10:10:10'),(19,'App\\Model\\TeacherModel',12,'token','b70df91cb4f79f514275c329ad9db6b2f36e65c7b8b3f163167555615651471d','[\"*\"]',NULL,'2021-10-18 10:11:07','2021-10-18 10:11:07'),(20,'App\\Model\\TeacherModel',12,'token','383a430948b55e0acf88e1cba611579357dae2ab987a388f7ed6339533c5cd97','[\"*\"]',NULL,'2021-10-18 10:12:49','2021-10-18 10:12:49'),(21,'App\\Model\\TeacherModel',12,'token','acf30d9821298dbaadba49598a5148c31934b63ea2e53a6d216b21c757be71d3','[\"*\"]',NULL,'2021-10-18 10:16:17','2021-10-18 10:16:17'),(22,'App\\Model\\TeacherModel',12,'token','9937c8e52b0233077a7852ffe90600a3c5a1f2ea2c059c56e7228d9db00f5d55','[\"*\"]',NULL,'2021-10-18 10:16:56','2021-10-18 10:16:56'),(23,'App\\Model\\TeacherModel',12,'token','a77963a5ad26aef2256cbab90500e8648d8ee722ec263a4f3caea17d45edb628','[\"*\"]',NULL,'2021-10-18 10:22:25','2021-10-18 10:22:25'),(24,'App\\Model\\TeacherModel',12,'token','92348d2b3ed253a9fb3d1e73589ae84b030425c7113735c62882753c1a18bc10','[\"*\"]',NULL,'2021-10-18 10:29:28','2021-10-18 10:29:28'),(25,'App\\Model\\TeacherModel',12,'token','774ef2d7f89b9a639075f3764ad5b9904c26ce4fc4b4ed5855942766e9db5706','[\"*\"]',NULL,'2021-10-18 10:30:05','2021-10-18 10:30:05'),(26,'App\\Model\\TeacherModel',12,'token','897850733dcd7f16529080034f7593ff224c78136924679cb59e11fdf8cb6e0b','[\"*\"]',NULL,'2021-10-18 10:43:42','2021-10-18 10:43:42'),(27,'App\\Model\\TeacherModel',12,'token','e840d14059a5d82f8332d511c677c01884e6397d0743f23a4b9191b64cd4fb94','[\"*\"]','2021-10-18 14:27:12','2021-10-18 14:27:02','2021-10-18 14:27:12'),(28,'App\\Model\\TeacherModel',12,'token','368803a6a145b8394f9480708a4931e82d2dd90c40cd40a9656a78e4167057c5','[\"*\"]','2021-10-18 14:29:08','2021-10-18 14:28:49','2021-10-18 14:29:08'),(29,'App\\Model\\TeacherModel',12,'token','e218d7ee60ef26c2886d55ec20320f7dcaab701f89ad2736e3e0653fcfa44a5c','[\"*\"]',NULL,'2021-10-18 14:30:17','2021-10-18 14:30:17'),(30,'App\\Model\\TeacherModel',12,'token','b3fcd2ae24c403efb539459ebd28ff18c245404a3e04ca4da98eb3961b71f7cb','[\"*\"]','2021-10-18 14:40:44','2021-10-18 14:40:38','2021-10-18 14:40:44'),(31,'App\\Model\\TeacherModel',12,'token','9d53ed8143a14a0d4beaf32887f840bd0820f38ce0f962ea6c4648a30b683737','[\"*\"]',NULL,'2021-10-18 14:41:51','2021-10-18 14:41:51'),(32,'App\\Model\\TeacherModel',12,'token','f7864fea7e0bbe75dbe74e24aaab8c44fae96826c47af99bf45f2aa71983d8c1','[\"*\"]',NULL,'2021-10-18 14:43:22','2021-10-18 14:43:22'),(33,'App\\Model\\TeacherModel',12,'token','573346c019f127b2187c6f695b8d188245a804cc12d8f20a17d62980584d1610','[\"*\"]','2021-10-18 14:51:20','2021-10-18 14:51:00','2021-10-18 14:51:20'),(34,'App\\Model\\TeacherModel',12,'token','424cd170b42e6a7c252b66521da6779873873f45bd37e50a66c1f64dac240d54','[\"*\"]',NULL,'2021-10-18 14:51:53','2021-10-18 14:51:53'),(35,'App\\Model\\TeacherModel',12,'token','96e2c63bdd2d60825e87cfd2bdefe49c796ee46e3ff61207ed626fcc14c73d0d','[\"*\"]',NULL,'2021-10-18 15:21:22','2021-10-18 15:21:22'),(36,'App\\Model\\TeacherModel',12,'token','e0705385f5eb41ad89120a2094a3666504844d67c83cdf26431de991047d3280','[\"*\"]',NULL,'2021-10-18 15:22:00','2021-10-18 15:22:00'),(37,'App\\Model\\TeacherModel',12,'token','28ca409f2d1d162af08de08027655bfde248b08e41c192dcedd404e880dac25c','[\"*\"]',NULL,'2021-10-18 15:22:46','2021-10-18 15:22:46'),(38,'App\\Model\\TeacherModel',12,'token','796daad5a13c86f1cc8389f694f1b19ea639c57ec5dcd9d50e7c9946865f9aa4','[\"*\"]','2021-10-18 15:24:11','2021-10-18 15:24:04','2021-10-18 15:24:11'),(39,'App\\Model\\TeacherModel',12,'token','b084bdee30eeeb1317f184b4a45e9e514d2cb08e51e93be6e6e33f0228c01e88','[\"*\"]',NULL,'2021-10-18 15:26:27','2021-10-18 15:26:27'),(40,'App\\Model\\TeacherModel',12,'token','db54171442322d28812d7da3464aa0df0faa14bc971a8f1e8799e039fbbf44e7','[\"*\"]',NULL,'2021-10-18 15:28:05','2021-10-18 15:28:05'),(41,'App\\Model\\TeacherModel',12,'token','6171191dc8f0035bd094130af0491d99a4b9557567dd1c0dc84a280e65af7eef','[\"*\"]',NULL,'2021-10-18 15:43:33','2021-10-18 15:43:33'),(42,'App\\Model\\TeacherModel',12,'token','09255da9e9b04fb350dfd0020ba375e813e29c4c79ce89055980207cdcb2e0cb','[\"*\"]','2021-10-18 15:53:42','2021-10-18 15:43:40','2021-10-18 15:53:42'),(43,'App\\Model\\TeacherModel',12,'token','23e0f0501e2d0ad504de5769a47ebb587ef4fc79902eb02a94958d2c22665ab4','[\"*\"]','2021-10-18 15:55:44','2021-10-18 15:54:56','2021-10-18 15:55:44'),(44,'App\\Model\\TeacherModel',12,'token','a460d6a192534906d624c6a7952ff4836b1e3a8a9f0c2684d0f5341dd1b7b6ae','[\"*\"]','2021-10-18 16:02:35','2021-10-18 16:02:31','2021-10-18 16:02:35'),(45,'App\\Model\\TeacherModel',12,'token','f4897c65642c8b12d892956c49daa867bc09c954f6d62f48d3cc2aedaca1edfa','[\"*\"]','2021-10-18 16:05:00','2021-10-18 16:04:13','2021-10-18 16:05:00'),(46,'App\\Model\\TeacherModel',12,'token','274b022ab8766ae5be6fddc18e60e84d9b8793865f7541afe5bbd10be889f7e9','[\"*\"]','2021-10-18 16:08:47','2021-10-18 16:07:49','2021-10-18 16:08:47'),(47,'App\\Model\\TeacherModel',12,'token','187792c931e5b585e836513ab87d8ee17973c0ba390f5bd24f2f3788877d05ad','[\"*\"]','2021-10-19 11:50:33','2021-10-19 11:50:31','2021-10-19 11:50:33'),(48,'App\\Model\\TeacherModel',12,'token','3092d805b988bc56a0feb195fef5b8d29b820cef93a5bdec1ce4133d9f235f85','[\"*\"]',NULL,'2021-10-19 13:26:31','2021-10-19 13:26:31'),(49,'App\\Model\\TeacherModel',12,'token','aed3169ef86f0fdb6ad6b3b62db174db3c130ad3d2d00c5da5ca62aef34ce3be','[\"*\"]',NULL,'2021-10-19 13:40:59','2021-10-19 13:40:59'),(50,'App\\Model\\TeacherModel',12,'token','18b76f4ce64bdd73fa9059413a77d501867f5eddc328a55a5cf49522113c8788','[\"*\"]',NULL,'2021-10-19 14:23:38','2021-10-19 14:23:38'),(51,'App\\Model\\TeacherModel',12,'token','5e128c7b7656f1d19a831bb802db33a06cba77d6e066f0a40ce5330332011cdc','[\"*\"]','2021-10-21 14:08:52','2021-10-21 13:38:53','2021-10-21 14:08:52'),(52,'App\\Model\\TeacherModel',12,'token','67df139b667d54db5c32402353a4bae784c8c9471bfa1c00b050735793ed89d7','[\"*\"]',NULL,'2021-10-21 13:57:20','2021-10-21 13:57:20'),(53,'App\\Model\\TeacherModel',12,'token','21ffb1da7db379d8fe118a3144409ccf500b4630bb662dc307b4ef876cf1f4a1','[\"*\"]','2021-10-21 14:39:19','2021-10-21 14:10:57','2021-10-21 14:39:19'),(54,'App\\Model\\TeacherModel',12,'token','cdef8d186c63aa8977c002a272e27f418190e00f8f8a348f1070f8717e3e6f34','[\"*\"]','2021-10-22 10:54:44','2021-10-22 10:26:30','2021-10-22 10:54:44'),(55,'App\\Model\\TeacherModel',12,'token','c1a839d2deacc348ac20b34da3df0d9b6f3f8cb0fb38e8abe6bb3bdc955abe07','[\"*\"]','2021-10-22 11:26:12','2021-10-22 10:59:48','2021-10-22 11:26:12'),(56,'App\\Model\\TeacherModel',12,'token','3b7d04ab58006b60bc0318443b4e6d413bee843551a1e03429aa23a458c16ccf','[\"*\"]',NULL,'2021-10-22 11:40:17','2021-10-22 11:40:17'),(57,'App\\Model\\TeacherModel',12,'token','e6af048d4052fdb9a7c01adbed8913e53687fd95d433d9b632a2facd9b2ebb69','[\"*\"]','2021-10-22 12:10:53','2021-10-22 11:41:09','2021-10-22 12:10:53'),(58,'App\\Model\\TeacherModel',12,'token','5e71767fd391e4a7ccdc935192f0c3295095e57b6dbefda0a6374785c3c6472c','[\"*\"]','2021-10-22 12:13:07','2021-10-22 12:12:06','2021-10-22 12:13:07'),(59,'App\\Model\\TeacherModel',12,'token','3fcba184f81125be270947d57e5d148cbc6d6b2933327af5d665ecdd7aa3f603','[\"*\"]','2021-10-22 12:14:16','2021-10-22 12:13:39','2021-10-22 12:14:16'),(60,'App\\Model\\TeacherModel',12,'token','292ba805410cc4d3e05022542a1a758cf008f2dceafa15d39d936cfbe1288198','[\"*\"]',NULL,'2021-10-22 14:23:04','2021-10-22 14:23:04'),(61,'App\\Model\\TeacherModel',12,'token','664b3bedd224240a5f3a859ac44f50c6d863a660619a0d3099bfc0cb7d7c6d17','[\"*\"]','2021-10-22 14:24:29','2021-10-22 14:24:07','2021-10-22 14:24:29'),(62,'App\\Model\\TeacherModel',12,'token','2082af40fd0ea10be15478b6f49f035dfbbc45de1d7a12967e5e9416453ae357','[\"*\"]','2021-10-22 15:39:30','2021-10-22 15:10:01','2021-10-22 15:39:30'),(63,'App\\Model\\TeacherModel',12,'token','f015bc1ad3eefce29a8fc556ff2a088fa3cb120f483a4632cc67f5c504f9812c','[\"*\"]','2021-10-22 16:10:01','2021-10-22 15:40:22','2021-10-22 16:10:01'),(64,'App\\Model\\TeacherModel',12,'token','8ef7c4eb63e2f5bf228f474a9002dbdc9bb5fd0a8f0b18da49fe5b762780f346','[\"*\"]','2021-10-22 16:39:18','2021-10-22 16:13:11','2021-10-22 16:39:18'),(65,'App\\Model\\TeacherModel',14,'token','7eff11fefb685e8109e469db9cdd512f29d5ac773f1886f486fc67939a16852a','[\"*\"]','2021-10-22 16:48:51','2021-10-22 16:44:49','2021-10-22 16:48:51'),(66,'App\\Model\\TeacherModel',12,'token','89885fb276f071b35c831d163bb797e5c8dae660454e6bb2705696a5ec846f2c','[\"*\"]','2021-10-22 16:49:43','2021-10-22 16:49:37','2021-10-22 16:49:43'),(67,'App\\Model\\TeacherModel',12,'token','c5e3cce9ec1892a163879c79c2b4ed4dfcf143abe2c38da66844069497295034','[\"*\"]','2021-10-22 16:54:04','2021-10-22 16:53:32','2021-10-22 16:54:04'),(68,'App\\Model\\TeacherModel',12,'token','ca45c9bb121c1a7a994902b7d81c2ab9a9ed6ea47c452be0172c29a9a89ca8cc','[\"*\"]','2021-10-23 07:36:44','2021-10-23 07:08:34','2021-10-23 07:36:44'),(69,'App\\Model\\TeacherModel',12,'token','9776cef55399ecd2cc2c537ff6346f8099c1bb14c2e6da92192f693720f6e552','[\"*\"]','2021-10-23 07:59:50','2021-10-23 07:42:36','2021-10-23 07:59:50'),(70,'App\\Model\\TeacherModel',12,'token','b4e53b78b77105ddaa735df0bf56d4d553191d357702a794a5e68eb9c2bc0068','[\"*\"]','2021-10-23 08:58:29','2021-10-23 08:32:01','2021-10-23 08:58:29'),(71,'App\\Model\\TeacherModel',12,'token','3e918a3cb7d5666456aa5d573c87dd43e07e493fe3c28b951af817dd0a968208','[\"*\"]',NULL,'2021-10-23 09:19:59','2021-10-23 09:19:59'),(72,'App\\Model\\TeacherModel',12,'token','72ae399b5bebf5714a1ec917767dfcafd306d288d9c0eb7794c62b1e81370fe5','[\"*\"]','2021-10-23 09:45:18','2021-10-23 09:20:26','2021-10-23 09:45:18'),(73,'App\\Model\\TeacherModel',12,'token','63f14ebdbcf8d8a8ce95e78a1802463f3dcca25df92179bed1a47f5b3ab59df9','[\"*\"]','2021-10-23 10:07:14','2021-10-23 09:52:43','2021-10-23 10:07:14'),(74,'App\\Model\\TeacherModel',12,'token','3607601d610819196df03651415bffe05f8cf585420445da89c9080c0fa8954e','[\"*\"]','2021-10-23 10:33:47','2021-10-23 10:23:32','2021-10-23 10:33:47'),(75,'App\\Model\\TeacherModel',12,'token','8ae0de60cff91b8ec0a59477b46124270680a7db4de3044a8fbe6d65ae06449a','[\"*\"]','2021-10-23 10:53:43','2021-10-23 10:42:49','2021-10-23 10:53:43'),(76,'App\\Model\\TeacherModel',12,'token','35423cc192ffa775c78701dd1cd740156bdccc61fb2db186679e0fb7795c0232','[\"*\"]','2021-10-23 11:18:52','2021-10-23 11:11:28','2021-10-23 11:18:52'),(77,'App\\Model\\TeacherModel',12,'token','3ed831c6c37aa45f268f0a60656c037ca4597b4dffdbe3866bf5ce854f08d5ca','[\"*\"]','2021-10-23 11:44:39','2021-10-23 11:14:46','2021-10-23 11:44:39'),(78,'App\\Model\\TeacherModel',12,'token','74d45fe029affd63e8815106a2eddd9d3499297b67a54da0ccd2aeb94c3da6e6','[\"*\"]','2021-10-23 12:08:39','2021-10-23 11:47:40','2021-10-23 12:08:39'),(79,'App\\Model\\TeacherModel',12,'token','e074fa7982134236b56e8b153928849a5dcb8b8eaff2fa34c00573fb149f20a8','[\"*\"]',NULL,'2021-10-23 12:14:13','2021-10-23 12:14:13'),(80,'App\\Model\\TeacherModel',12,'token','a9db943d679490d3f09f9c902030c12f9e1a9ba399b6e16e89c8b3c1a2065aa1','[\"*\"]','2021-10-23 12:32:11','2021-10-23 12:14:33','2021-10-23 12:32:11'),(81,'App\\Model\\TeacherModel',12,'token','02195c070fe0cf1f40bc593ee505f3fc37b659dcc7d0d59b2e9634a7a46d9ab2','[\"*\"]','2021-10-23 13:09:05','2021-10-23 12:50:39','2021-10-23 13:09:05'),(82,'App\\Model\\StudentModel',3,'token','84d13a6855b81e35d2030ac3887c3ca591bf93ad41ba25495fcf1bf90ffa32ef','[\"*\"]','2021-10-23 14:04:46','2021-10-23 13:54:33','2021-10-23 14:04:46'),(83,'App\\Model\\StudentModel',3,'token','2a0d7cd419549e846ff766ef284bf7003e9e94abac30790e5d534f70ed261eb5','[\"*\"]','2021-10-23 14:36:03','2021-10-23 14:06:06','2021-10-23 14:36:03'),(84,'App\\Model\\StudentModel',3,'token','6fc575f67def348f3e272f819b2771079e80305d6eed44cffc66c80dd042ed62','[\"*\"]','2021-10-23 14:42:24','2021-10-23 14:36:53','2021-10-23 14:42:24'),(85,'App\\Model\\TeacherModel',12,'token','5fb1b3b5a205d93ecfb9f6155b34b96b9eaa37ab7c6e948da5c4a5db2ce1a70a','[\"*\"]','2021-10-23 18:24:50','2021-10-23 18:01:43','2021-10-23 18:24:50'),(86,'App\\Model\\StudentModel',3,'token','c37333a0d10050629e2f177427e2745c8676ac7da783f87c77f42d7903f8e0bd','[\"*\"]','2021-10-23 18:49:10','2021-10-23 18:26:17','2021-10-23 18:49:10'),(87,'App\\Model\\StudentModel',3,'token','b528340c0d6134070f71ac75d835bc0cd57f887c33877d574d72783cf51d2d7b','[\"*\"]','2021-10-23 19:09:47','2021-10-23 18:57:19','2021-10-23 19:09:47'),(88,'App\\Model\\TeacherModel',12,'token','23ade4e9aae3b7bb8b948ae5f23451023e992cc3903777d2204da1362f06e32b','[\"*\"]','2021-10-24 12:32:05','2021-10-24 12:31:45','2021-10-24 12:32:05'),(89,'App\\Model\\StudentModel',3,'token','f1b1f095bd674e20dfbdd1d619c8e05632a86455dab94fa3378e9fa0479a97e6','[\"*\"]','2021-10-24 12:33:07','2021-10-24 12:33:02','2021-10-24 12:33:07'),(90,'App\\Model\\TeacherModel',12,'token','a4bcc80fe1cb6e9dcd484f43356f6ec5920ba29dde309d07c33a156a659558f8','[\"*\"]','2021-10-24 12:34:18','2021-10-24 12:34:00','2021-10-24 12:34:18'),(91,'App\\Model\\StudentModel',3,'token','d69cd8d6f82ad7272b18178e6cf6c702690fef4f041ce77822e0d365ee3ecb43','[\"*\"]','2021-10-24 12:40:44','2021-10-24 12:35:08','2021-10-24 12:40:44'),(92,'App\\Model\\TeacherModel',12,'token','aa6f1d13084d015af2402fc764ac1d53398c09fe71f86b38ead769325828e729','[\"*\"]','2021-10-24 12:41:42','2021-10-24 12:41:10','2021-10-24 12:41:42'),(93,'App\\Model\\StudentModel',3,'token','9456367a23917c36729b752819964a31bef9c7ae9a8e8af9f307282a7de09b2f','[\"*\"]','2021-10-24 17:36:16','2021-10-24 17:27:44','2021-10-24 17:36:16'),(94,'App\\Model\\TeacherModel',12,'token','e344eebb92e6c2e6e40797948072a4f9da4722a6aa4f4cd385d529c8e568513d','[\"*\"]','2021-10-24 17:32:52','2021-10-24 17:31:08','2021-10-24 17:32:52'),(95,'App\\Model\\TeacherModel',12,'token','c48508192ab53b2a63e8de19edd37b3e082aee349f8a8543ff081ce876781061','[\"*\"]','2021-10-24 17:38:15','2021-10-24 17:37:39','2021-10-24 17:38:15'),(96,'App\\Model\\StudentModel',3,'token','92b927cb699bddc602a57dd8641d9a9364172f6a250534bfa57ba5f5697e1368','[\"*\"]','2021-10-24 17:40:16','2021-10-24 17:38:49','2021-10-24 17:40:16'),(97,'App\\Model\\TeacherModel',12,'token','b036a26bd38a1090b137b90150ba27cd4a506f4eef39252a80acd7aec450325d','[\"*\"]','2021-10-24 17:48:19','2021-10-24 17:48:13','2021-10-24 17:48:19'),(98,'App\\Model\\StudentModel',3,'token','35d10a58f4b5fbf573e9119b6ff8d0f0f10ede23d8771bee99a33f52985f01af','[\"*\"]',NULL,'2021-10-24 18:30:45','2021-10-24 18:30:45'),(99,'App\\Model\\StudentModel',3,'token','d41c4d03371f4e11615f8e9eec25f9300e74f6c6e026a088acd8dc1fda855d5a','[\"*\"]','2021-10-24 18:34:48','2021-10-24 18:30:45','2021-10-24 18:34:48'),(100,'App\\Model\\TeacherModel',12,'token','be637d8f4ff469088c3956fa78ac1e08d46fe718db6e22fdc98cca1a4b2538ff','[\"*\"]','2021-10-24 19:42:23','2021-10-24 19:13:32','2021-10-24 19:42:23'),(101,'App\\Model\\TeacherModel',12,'token','2df5b29310bb731403d822bc63a4b37a09797bfbf8799be2ca094056c8064807','[\"*\"]','2021-10-24 20:17:38','2021-10-24 19:49:12','2021-10-24 20:17:38'),(102,'App\\Model\\TeacherModel',12,'token','fe2da95b535d476cb77e6fa31cee7e21cc3287f7584dbd24edec423cd75c8e46','[\"*\"]','2021-10-24 20:28:07','2021-10-24 20:27:52','2021-10-24 20:28:07'),(103,'App\\Model\\TeacherModel',12,'token','84a04fed41ec7ee5100c51638074221aac26fb740b8f849c236c3542f0732525','[\"*\"]','2021-10-25 07:47:45','2021-10-25 07:36:57','2021-10-25 07:47:45'),(104,'App\\Model\\StudentModel',3,'token','1e3a2ad5b20476013008dfbccb45e5b79c4da93dd2af4c7819bcad7454b41606','[\"*\"]','2021-10-25 07:58:46','2021-10-25 07:41:23','2021-10-25 07:58:46'),(105,'App\\Model\\TeacherModel',12,'token','6fdc915144cdd7a636bd71ba6d6046cf16cd9996ad5feb5fcd49102b6bdd2569','[\"*\"]','2021-10-25 08:00:44','2021-10-25 07:59:54','2021-10-25 08:00:44'),(106,'App\\Model\\StudentModel',3,'token','e44c48fb9c9e5d4b403ea785e4d7e6b494429ccfeefca99a8d14b6ab9ee5ff1f','[\"*\"]','2021-10-25 08:05:17','2021-10-25 08:01:12','2021-10-25 08:05:17'),(107,'App\\Model\\StudentModel',3,'token','a6ae6d95449f7cfc5cbb0f73bc8a835378e90535950e0c19cd88df4363978fd9','[\"*\"]','2021-10-25 08:37:05','2021-10-25 08:36:41','2021-10-25 08:37:05'),(108,'App\\Model\\StudentModel',3,'token','eb2272e209a292079607a391559d9a206c2424614424a5f073dcdd40b59904ee','[\"*\"]','2021-10-25 09:38:36','2021-10-25 09:20:23','2021-10-25 09:38:36'),(109,'App\\Model\\TeacherModel',12,'token','060027d6af52956e81e94f10b5c75e5ac11252451af45d91b5058e2151564005','[\"*\"]','2021-10-25 10:27:15','2021-10-25 10:07:19','2021-10-25 10:27:15'),(110,'App\\Model\\StudentModel',3,'token','4483f4a09698f4a830cb9f4cab36148ffc406139997e6d0ad663e3c293a0a849','[\"*\"]','2021-10-25 14:56:26','2021-10-25 14:55:29','2021-10-25 14:56:26'),(111,'App\\Model\\TeacherModel',12,'token','dc925ca1cb315cce10c8c5a4d9a6e8c19eafd56013c1723927ec5a3fe8cc5003','[\"*\"]',NULL,'2021-10-25 14:57:55','2021-10-25 14:57:55'),(112,'App\\Model\\TeacherModel',12,'token','0f1942a06b668de816b4389c5921bf0991ead2af2b97a3465fa4ef2fa3d2b9f8','[\"*\"]','2021-10-25 14:58:06','2021-10-25 14:57:55','2021-10-25 14:58:06'),(113,'App\\Model\\StudentModel',3,'token','981c6431348bd20ed9a9152866e2a66d0b99f1eb6d92f97e18f27dcb7bdc8cc9','[\"*\"]','2021-10-25 15:13:54','2021-10-25 14:59:55','2021-10-25 15:13:54'),(114,'App\\Model\\StudentModel',3,'token','8dc106cee738190a542bebd78f4a60b7059146b44d6718f066c91170ae84b5af','[\"*\"]','2021-10-25 16:00:43','2021-10-25 15:35:41','2021-10-25 16:00:43'),(115,'App\\Model\\StudentModel',3,'token','cbf44c523c165e83cafc8874af7609f0e11017d1fbe3525add29136506707028','[\"*\"]','2021-10-25 16:51:48','2021-10-25 16:48:20','2021-10-25 16:51:48'),(116,'App\\Model\\StudentModel',3,'token','59a61a7858d8ebc904c658e70214403e384fc5dca94624a53f6f88047bc7bd91','[\"*\"]','2021-10-25 17:51:21','2021-10-25 17:34:33','2021-10-25 17:51:21'),(117,'App\\Model\\StudentModel',3,'token','288902aa6778e8798495dee0b35fcef4e442d835d4791dee1950dc749a547c47','[\"*\"]','2021-10-25 18:11:13','2021-10-25 17:52:25','2021-10-25 18:11:13'),(118,'App\\Model\\StudentModel',3,'token','2dcd8d79d74d77910ae650e88ca4106c040b06069128bc72058d529499cf5afa','[\"*\"]','2021-10-26 07:40:16','2021-10-26 07:25:03','2021-10-26 07:40:16'),(119,'App\\Model\\StudentModel',3,'token','3364860c32af600fd071b5b11c097d689d616a6732ff92a0de606c05a26d83e7','[\"*\"]','2021-10-26 08:09:05','2021-10-26 08:00:38','2021-10-26 08:09:05'),(120,'App\\Model\\StudentModel',3,'token','5220d49f01f2e68fb7376f67165158b24a1d53d6d5aea133761029242a410342','[\"*\"]','2021-10-26 09:18:19','2021-10-26 09:12:48','2021-10-26 09:18:19'),(121,'App\\Model\\StudentModel',3,'token','848cfa60cdfdb4b335cb01a12bc62bb90b988119ee214402cb60d4a007bc5f2f','[\"*\"]','2021-10-26 10:13:48','2021-10-26 09:59:26','2021-10-26 10:13:48'),(122,'App\\Model\\StudentModel',3,'token','e442c2d6fb0341dc8beb4cff3fc0f5d70fdf075518c6389feaa50ec1a835ac4c','[\"*\"]','2021-10-26 11:37:31','2021-10-26 11:21:06','2021-10-26 11:37:31'),(123,'App\\Model\\StudentModel',3,'token','4f393d8476f1d8b65ab811e9ec3de47451c05c1e51ce170efd996484efd2bec0','[\"*\"]','2021-10-26 12:12:34','2021-10-26 11:56:18','2021-10-26 12:12:34'),(124,'App\\Model\\StudentModel',3,'token','22adcb24192fbef55a4620414b01867d4d41d4c9881a5539d17f3b5d67b3e4c7','[\"*\"]','2021-10-26 20:45:08','2021-10-26 20:45:02','2021-10-26 20:45:08'),(125,'App\\Model\\StudentModel',3,'token','87ab89705230d03297941f3c706671989f41a4a00e8123221490bb60f2f8f309','[\"*\"]','2021-10-27 08:42:36','2021-10-27 08:22:20','2021-10-27 08:42:36'),(126,'App\\Model\\StudentModel',3,'token','f471c6e5560f6d42722e548d20693d0cb76dd39906f8e0873b6db1cb83edb190','[\"*\"]','2021-10-27 09:45:47','2021-10-27 09:27:24','2021-10-27 09:45:47'),(127,'App\\Model\\StudentModel',3,'token','2499cc13f90d8c45b6e16295a1b699dbe21ed5876bc42da5341d62c0b85d215a','[\"*\"]',NULL,'2021-10-27 10:28:00','2021-10-27 10:28:00'),(128,'App\\Model\\StudentModel',3,'token','78850523a3fba2da05180fad5fe2f20dd999eff998c2f185fbc65e8e75310254','[\"*\"]','2021-10-27 10:54:09','2021-10-27 10:28:01','2021-10-27 10:54:09'),(129,'App\\Model\\StudentModel',3,'token','0980ce728eef92e317b439bdba93f3c15529c4c2c7bffd7987e0133341626a49','[\"*\"]','2021-10-27 11:47:33','2021-10-27 11:19:35','2021-10-27 11:47:33'),(130,'App\\Model\\TeacherModel',12,'token','35287be02da61e19ddd2ccb98dff09bd588479c2d526d3b776d336ec07cae758','[\"*\"]',NULL,'2021-10-27 11:33:46','2021-10-27 11:33:46'),(131,'App\\Model\\TeacherModel',12,'token','236c9a794095c40a28fd32f466fcfdab099de784c226c2928f9074927bfa4d88','[\"*\"]','2021-10-27 11:35:23','2021-10-27 11:34:02','2021-10-27 11:35:23'),(132,'App\\Model\\StudentModel',3,'token','ed768db77fc0ac05a990cbab35b58f1c2b03896e889a4df49cafcd469faf00d7','[\"*\"]',NULL,'2021-10-27 11:52:18','2021-10-27 11:52:18'),(133,'App\\Model\\StudentModel',3,'token','370f9199d6ccaa7fc4ec7ddeac6c4b80eff1385a4bc699209132e527f1c450a2','[\"*\"]','2021-10-27 12:08:40','2021-10-27 11:52:19','2021-10-27 12:08:40'),(134,'App\\Model\\StudentModel',3,'token','2693c34e08b162002e6a44733381d87635fb1bc0c06ea910923866c60baab7d5','[\"*\"]','2021-10-27 12:31:02','2021-10-27 12:30:24','2021-10-27 12:31:02'),(135,'App\\Model\\StudentModel',3,'token','1a3b5bdcefbd88ca451393894b9c255d79d6621de1963daf7df64ddd0cbdb965','[\"*\"]','2021-10-27 14:48:57','2021-10-27 14:37:12','2021-10-27 14:48:57'),(136,'App\\Model\\StudentModel',3,'token','521d221910e1e96e0514f99039c1af1f85c470e06dab57f07334dd045830fd6f','[\"*\"]','2021-10-28 13:02:40','2021-10-28 12:42:47','2021-10-28 13:02:40'),(137,'App\\Model\\TeacherModel',12,'token','163d7400ef70560e9e3ab36fe974c1df17d30672538d976ffda73afc685db6b4','[\"*\"]',NULL,'2021-10-28 15:56:37','2021-10-28 15:56:37'),(138,'App\\Model\\TeacherModel',12,'token','39210546b6f8e683f6d95c8ba24b38c571c39c6794c23b4ea6cb195d82c82f8b','[\"*\"]','2021-10-28 16:12:26','2021-10-28 15:56:38','2021-10-28 16:12:26'),(139,'App\\Model\\TeacherModel',12,'token','7fc04e20b4abe951adf6bfb9c877b139fc597a42f228449825f9020687f2e71a','[\"*\"]','2021-10-28 16:30:39','2021-10-28 16:16:37','2021-10-28 16:30:39'),(140,'App\\Model\\TeacherModel',12,'token','43499632387b4897f98d1341c7228bdf1566b8b24bafc51565ce418b84d1dbf3','[\"*\"]','2021-10-28 17:43:18','2021-10-28 17:13:30','2021-10-28 17:43:18'),(141,'App\\Model\\TeacherModel',12,'token','aa9e5c52ad98023ea5e5f9d4cdd83917e7740eadebb1273d41763a7fbb46c3e9','[\"*\"]','2021-10-28 18:00:24','2021-10-28 17:43:38','2021-10-28 18:00:24'),(142,'App\\Model\\TeacherModel',12,'token','f8cc70f0ba4ceba00cc4f7cb01462453df8afc1131c808ca2d21ef0a4daaca50','[\"*\"]','2021-10-28 18:22:07','2021-10-28 18:22:04','2021-10-28 18:22:07'),(143,'App\\Model\\TeacherModel',12,'token','b2bc6ba3a497fb0555ac57aa9264fa0392eadafd1700ced2dfc66f548a6e0bae','[\"*\"]','2021-10-28 18:53:37','2021-10-28 18:24:50','2021-10-28 18:53:37'),(144,'App\\Model\\TeacherModel',12,'token','1e03934278a93499637868c3b07854296967dae06326f54c86aa33f387b3e959','[\"*\"]','2021-10-29 07:07:46','2021-10-29 07:07:20','2021-10-29 07:07:46'),(145,'App\\Model\\TeacherModel',12,'token','48d92f2108f354e8b35e55c417f9d82b6f19b6bb2710d9dd120e60183e94a308','[\"*\"]','2021-10-29 07:44:26','2021-10-29 07:43:41','2021-10-29 07:44:26'),(146,'App\\Model\\TeacherModel',12,'token','ca58aa5e2e46256b2480f6a65e86fbcf873227463a9583057fa614ecd7af2f20','[\"*\"]','2021-10-29 10:47:27','2021-10-29 10:19:25','2021-10-29 10:47:27'),(147,'App\\Model\\TeacherModel',12,'token','96d60d5b060e6671871bda876ad539ef0d1b98f39c4d0b082b42337fb0ca0d63','[\"*\"]','2021-10-31 12:53:20','2021-10-31 12:27:34','2021-10-31 12:53:20'),(148,'App\\Model\\TeacherModel',12,'token','3c63cad853dde00e567ca59594e1d8cebe904717b5dd61637e1f95db9b7dca89','[\"*\"]','2021-10-31 13:39:46','2021-10-31 13:13:02','2021-10-31 13:39:46'),(149,'App\\Model\\TeacherModel',12,'token','a221978109c786585452c93394677518adc7cee94ad7542048663aafddb8157a','[\"*\"]','2021-10-31 14:01:17','2021-10-31 13:52:15','2021-10-31 14:01:17'),(150,'App\\Model\\TeacherModel',12,'token','c9129ced8edfdb038523c4e8cba5be82560fab7a8b2e1b1099a3df7e06a605b9','[\"*\"]','2021-10-31 14:37:38','2021-10-31 14:37:32','2021-10-31 14:37:38'),(151,'App\\Model\\TeacherModel',12,'token','bb081282b77930f3ca9bbe8716fdbd29f81200b7d3952f04d24838e3cac19fdc','[\"*\"]','2021-11-01 09:23:08','2021-11-01 08:54:23','2021-11-01 09:23:08'),(152,'App\\Model\\TeacherModel',12,'token','882dbef51f5f41ba257d2a534615c96b280bfab1a6c98b86f59e8c1de93430f8','[\"*\"]','2021-11-01 09:30:35','2021-11-01 09:30:28','2021-11-01 09:30:35'),(153,'App\\Model\\TeacherModel',12,'token','554a024c1375ab9d3b8faf550fe24287e8fa894c24e71fa6216d48ec0b2f883d','[\"*\"]','2021-11-01 11:43:56','2021-11-01 11:27:32','2021-11-01 11:43:56'),(154,'App\\Model\\TeacherModel',12,'token','c826b0e086ea8181a7c62afb9b1073013b8584e08b1db80d178074b109e89deb','[\"*\"]','2021-11-01 17:36:53','2021-11-01 17:07:22','2021-11-01 17:36:53'),(155,'App\\Model\\TeacherModel',12,'token','7add82f3e0af46e5480160bfff9fc2f27ba8bd88d511db7fcba9028a3e1d4f8c','[\"*\"]','2021-11-03 20:06:31','2021-11-03 19:59:02','2021-11-03 20:06:31'),(156,'App\\Model\\TeacherModel',12,'token','8596084aefa83cb32dde5b63cff2d4affab3d81ef53561df3db5d85ef52d2355','[\"*\"]','2021-11-03 21:48:39','2021-11-03 21:41:57','2021-11-03 21:48:39'),(157,'App\\Model\\TeacherModel',12,'token','11fdfa18e042925ff5143e640aa858f4739ee51e8b5239f706e952f2f80cff30','[\"*\"]','2021-11-04 15:40:15','2021-11-04 15:31:00','2021-11-04 15:40:15'),(158,'App\\Model\\TeacherModel',12,'token','e3a344e97d6299c7ee193757122f9597e26bb82e327186ca92f2bc29c4f4f246','[\"*\"]','2021-11-04 15:46:31','2021-11-04 15:45:54','2021-11-04 15:46:31'),(159,'App\\Model\\TeacherModel',12,'token','a9ced78acfd32b7f0e88e2d9577d7745d925d2997094dbcbda9e2ba2a185efbf','[\"*\"]','2021-11-04 15:48:53','2021-11-04 15:48:08','2021-11-04 15:48:53'),(160,'App\\Model\\TeacherModel',12,'token','64cc72b52d93ec85e67afecd8d1920f02d985ec841d7974d0b7651e7da746b24','[\"*\"]','2021-11-04 16:07:32','2021-11-04 16:01:00','2021-11-04 16:07:32'),(161,'App\\Model\\TeacherModel',12,'token','7d6f3c9299cc1b045b4d5c06bceb2869c4c12029e0fed2598ac90187e5346287','[\"*\"]','2021-11-04 16:43:26','2021-11-04 16:32:49','2021-11-04 16:43:26'),(162,'App\\Model\\TeacherModel',12,'token','9bf739c7576bc1794a449dc811c4a19568fce0fbcafa98a7fe68893f21f03466','[\"*\"]','2021-11-04 20:00:53','2021-11-04 19:59:11','2021-11-04 20:00:53'),(163,'App\\Model\\TeacherModel',12,'token','04f0204714b8c017c5ebfba18cf39c5587a7b8143e974477a9ca831bc585fd69','[\"*\"]','2021-11-04 20:51:57','2021-11-04 20:48:54','2021-11-04 20:51:57'),(164,'App\\Model\\TeacherModel',12,'token','63e637093bd62ca6dec983bb2fe8fb29db0d997df6334de5dd3cd50641556a61','[\"*\"]','2021-11-04 21:59:39','2021-11-04 21:30:30','2021-11-04 21:59:39'),(165,'App\\Model\\TeacherModel',12,'token','3d6c0e419123af312e0b2be4b3f1ace0a42c20cb24decba24435b9deae83d589','[\"*\"]','2021-11-05 10:09:50','2021-11-05 09:54:19','2021-11-05 10:09:50'),(166,'App\\Model\\TeacherModel',12,'token','7fef85330bbb0af99e71f7695b69b8c498f0b291c2bfc44ed222aeb51f821c6b','[\"*\"]','2021-11-05 11:54:07','2021-11-05 11:24:09','2021-11-05 11:54:07'),(167,'App\\Model\\TeacherModel',12,'token','73b6b5bd6e669ac818a35644cd98dd5a59d2653d76ab23203ca1a441255bc488','[\"*\"]','2021-11-05 12:11:31','2021-11-05 11:57:31','2021-11-05 12:11:31'),(168,'App\\Model\\TeacherModel',12,'token','258ea67c1c95c035cae0f4d9b04bad48f1aa02765039b1207fb3a863dd458e35','[\"*\"]','2021-11-05 12:58:25','2021-11-05 12:28:46','2021-11-05 12:58:25'),(169,'App\\Model\\TeacherModel',12,'token','241bb6278d5c32da074ddcf912fff4ad240d62873aae3ec227f417e177c9cafe','[\"*\"]','2021-11-05 13:28:49','2021-11-05 12:59:25','2021-11-05 13:28:49'),(170,'App\\Model\\TeacherModel',12,'token','88c8acaeb0d1db377a42bf6a889d3ceb3a4566d5340374a63d4ad88a95e4680e','[\"*\"]','2021-11-05 13:41:12','2021-11-05 13:38:13','2021-11-05 13:41:12'),(171,'App\\Model\\TeacherModel',12,'token','26e3db2ec0e25aab66d0b48aee18be262fc5c1fd9c2aa0c475b17ca3a33c872b','[\"*\"]','2021-11-05 15:18:21','2021-11-05 15:17:09','2021-11-05 15:18:21'),(172,'App\\Model\\TeacherModel',12,'token','2cad8f82d018ae82bce98969de91c8163dfdf130ceae0577d27c701fe074545e','[\"*\"]','2021-11-05 19:20:33','2021-11-05 18:53:30','2021-11-05 19:20:33'),(173,'App\\Model\\TeacherModel',12,'token','8b205aa1f3dea376c6deb67be1eb0ecddb17d9807474925bd9f8c0d18db888a1','[\"*\"]','2021-11-05 20:03:31','2021-11-05 19:42:46','2021-11-05 20:03:31'),(174,'App\\Model\\TeacherModel',12,'token','10de41f5b69736ebc204b3c9f2eb74ee94a279557323a2bb878e5638e6489020','[\"*\"]','2021-11-05 20:37:12','2021-11-05 20:21:49','2021-11-05 20:37:12'),(175,'App\\Model\\TeacherModel',12,'token','234397c40847f02f1e686d54ab99e9e9c9cf583094f55b87520c44d573415516','[\"*\"]','2021-11-06 07:44:46','2021-11-06 07:35:16','2021-11-06 07:44:46'),(176,'App\\Model\\TeacherModel',12,'token','d8ea6b4f1efa7b6faa52ba675bf47a8d1c23f9c48a8b6f010dfd1a8d7a900e46','[\"*\"]','2021-11-06 10:26:54','2021-11-06 10:26:24','2021-11-06 10:26:54'),(177,'App\\Model\\TeacherModel',12,'token','d43a50573b1d936d376aaeded1dc66be4ae4ffd9555ecabe1d4c336dcee9ded4','[\"*\"]','2021-11-06 11:53:04','2021-11-06 11:33:36','2021-11-06 11:53:04'),(178,'App\\Model\\TeacherModel',12,'token','003e495ff8588f31eab418687852d1351a11b915f26bc9c9d36383d9999333c0','[\"*\"]','2021-11-06 18:10:03','2021-11-06 18:09:59','2021-11-06 18:10:03'),(179,'App\\Model\\TeacherModel',12,'token','602e9f8231a0354ccb8a4ee6addbfe99a5aae334ba0e060248b3a0f56ca75101','[\"*\"]','2021-11-06 18:33:48','2021-11-06 18:10:19','2021-11-06 18:33:48'),(180,'App\\Model\\TeacherModel',12,'token','f81761900a287ea452c173ec1b4142feaf329072787814a9ee98e2feaaab2928','[\"*\"]','2021-11-06 18:51:00','2021-11-06 18:47:31','2021-11-06 18:51:00'),(181,'App\\Model\\TeacherModel',12,'token','49dd34daf96841e3021f5dd89e894908d0488d49c5fa505acd569bb3cdbf63ba','[\"*\"]','2021-11-07 09:59:13','2021-11-07 09:59:09','2021-11-07 09:59:13'),(182,'App\\Model\\StudentModel',3,'token','705a7afc52d35dbd6d0e50ce0cc0f8acf29f0c699199c3be7a8ed8009fb01ef1','[\"*\"]','2021-11-07 10:32:18','2021-11-07 10:15:58','2021-11-07 10:32:18'),(183,'App\\Model\\TeacherModel',12,'token','1954ae0989cc20b8e19c430512bab53cf556c9c22b77220f81b8abdd3f7fbaf8','[\"*\"]','2021-11-07 10:45:28','2021-11-07 10:32:29','2021-11-07 10:45:28'),(184,'App\\Model\\StudentModel',3,'token','8b8f3a32dadb1b6defd740b497ef39cb392bf88a7d711076de9eb8ca890dbfcf','[\"*\"]',NULL,'2021-11-07 19:09:18','2021-11-07 19:09:18'),(185,'App\\Model\\StudentModel',3,'token','b746753e84a8f519868aaeab50e9d11c9fb193bdd982170e660d083cba66ca4e','[\"*\"]',NULL,'2021-11-07 19:10:56','2021-11-07 19:10:56'),(186,'App\\Model\\StudentModel',3,'token','600b3c25e156ab60eea6d673dd79b3fadadc2d688c89777704863f4d451e711b','[\"*\"]',NULL,'2021-11-07 19:15:29','2021-11-07 19:15:29'),(187,'App\\Model\\StudentModel',3,'token','b423f8213c3e1d82640472d64ec516dce42b9b579900419616eaa5548aa33a58','[\"*\"]',NULL,'2021-11-07 19:16:07','2021-11-07 19:16:07'),(188,'App\\Model\\TeacherModel',12,'token','3e670a31eccac4d4566c7352437c7d9614c9869f72961377453b6a263926a6cb','[\"*\"]',NULL,'2021-11-07 19:28:53','2021-11-07 19:28:53'),(189,'App\\Model\\TeacherModel',12,'token','fbf6b5b2d6c0cc519f7dc9807524098c90547b206305772b9cbbf0339b2c58f6','[\"*\"]',NULL,'2021-11-07 19:28:54','2021-11-07 19:28:54'),(190,'App\\Model\\StudentModel',3,'token','c975681b778efb42e2a9c32435e2b94009057d910dd910a88394e44919b2da2a','[\"*\"]',NULL,'2021-11-07 19:36:58','2021-11-07 19:36:58'),(191,'App\\Model\\StudentModel',3,'token','9f8d76f9da0341db268d757d3cdf215a480e02d65c67a9e165f8fa5694f5f866','[\"*\"]',NULL,'2021-11-07 19:39:10','2021-11-07 19:39:10'),(192,'App\\Model\\StudentModel',3,'token','45baa3370401ef258cadea1d491976d7d9a42c1f8d11fbae10b27ffd9d6cebab','[\"*\"]','2021-11-07 20:06:22','2021-11-07 20:03:35','2021-11-07 20:06:22'),(193,'App\\Model\\TeacherModel',12,'token','2cb97827c65709ab4abbf56a1670fcfcd6c9f954b6878f081b4647d9d467fa48','[\"*\"]',NULL,'2021-11-07 20:18:48','2021-11-07 20:18:48'),(194,'App\\Model\\TeacherModel',12,'token','24c9ed90a0c62d03114b6a8a87109bd3dbf2cfb1483654df489029b6bbfd50ea','[\"*\"]',NULL,'2021-11-07 20:34:32','2021-11-07 20:34:32'),(195,'App\\Model\\StudentModel',3,'token','663f088711d4699f8e218666973ed352010804e589f50b4efc3c6c7a03db3558','[\"*\"]','2021-11-08 07:25:08','2021-11-08 07:25:05','2021-11-08 07:25:08'),(196,'App\\Model\\StudentModel',3,'token','a609d1cdf551cc6aaaf54a7b22a2f3452da8ce912e6feb1226beb1e797f727c0','[\"*\"]',NULL,'2021-11-08 11:07:59','2021-11-08 11:07:59'),(197,'App\\Model\\StudentModel',3,'token','f838d0060606777922241625ff6fd1e5880e557c2eebd960b788f86476b299ef','[\"*\"]',NULL,'2021-11-08 11:10:21','2021-11-08 11:10:21'),(198,'App\\Model\\StudentModel',3,'token','c378cee3c59566db863b685ae4749c9508d0176375be36bc1bc4a6c3c2132a00','[\"*\"]',NULL,'2021-11-08 15:02:51','2021-11-08 15:02:51'),(199,'App\\Model\\TeacherModel',12,'token','cc3795ff6df890fc74146c9e368b964edebdb522568ed2a951e12f9c47d71772','[\"*\"]','2021-11-08 15:33:49','2021-11-08 15:05:56','2021-11-08 15:33:49'),(200,'App\\Model\\TeacherModel',12,'token','7c7f7bce02ba543d1706ba0a1c06f14a9ff4b31cc1e84e3392c7bf030397c759','[\"*\"]','2021-11-08 15:39:13','2021-11-08 15:37:24','2021-11-08 15:39:13'),(201,'App\\Model\\TeacherModel',12,'token','035d17b5f36f1b6d741813bd5a1025bb94deac46e4862459993dc03b7e3b9b32','[\"*\"]','2021-11-08 16:36:29','2021-11-08 16:25:02','2021-11-08 16:36:29'),(202,'App\\Model\\TeacherModel',12,'token','9c68289b8a19239b87a95ccdf3e0d291f03185dda6752466a63e8e3583389f9f','[\"*\"]','2021-11-08 17:57:19','2021-11-08 17:28:37','2021-11-08 17:57:19'),(203,'App\\Model\\TeacherModel',12,'token','63e2aa7137ec83aff34a16b66ae804ae0bdb0d05f85333897b27ba425b0770d3','[\"*\"]','2021-11-08 18:25:18','2021-11-08 17:59:11','2021-11-08 18:25:18'),(204,'App\\Model\\TeacherModel',12,'token','dfea42fceaf11acbac567e9df6b412ad13b080be99880049c3fb4e5027e869d2','[\"*\"]','2021-11-08 18:48:53','2021-11-08 18:31:37','2021-11-08 18:48:53'),(205,'App\\Model\\TeacherModel',12,'token','8b7726047bf597febc96c624a1b6e923589996ab817b95c6b920f2026efdbe8c','[\"*\"]','2021-11-09 09:46:22','2021-11-09 09:16:40','2021-11-09 09:46:22'),(206,'App\\Model\\TeacherModel',12,'token','bb93edcbab8c2f0c9fe3d72746cf59e643699d5b2e0524ce250126362f207f1f','[\"*\"]','2021-11-09 09:51:54','2021-11-09 09:47:41','2021-11-09 09:51:54'),(207,'App\\Model\\TeacherModel',12,'token','a242c0456cb5c5585b7955882b2258262780f001507bb23f98257f9172906362','[\"*\"]','2021-11-09 11:27:38','2021-11-09 11:03:48','2021-11-09 11:27:38'),(208,'App\\Model\\StudentModel',3,'token','e9659048ade6fdea107afd7b5162d25f19fa7abe4aac8e1f5b932a6da9fb1c88','[\"*\"]','2021-11-09 11:40:20','2021-11-09 11:37:42','2021-11-09 11:40:20'),(209,'App\\Model\\TeacherModel',12,'token','d95e1f8c8a695174b4af0a536a1490face0979dce830e0c281608c70eb1b613f','[\"*\"]','2021-11-09 11:43:14','2021-11-09 11:43:06','2021-11-09 11:43:14'),(210,'App\\Model\\StudentModel',3,'token','eb50904a5f44bb316a510e062f0a7562101e9d585714ef11a430787a8df20dfb','[\"*\"]','2021-11-09 12:16:09','2021-11-09 11:48:47','2021-11-09 12:16:09'),(211,'App\\Model\\StudentModel',3,'token','386ca8bf88ecf51b1aa7ec645a0e07542c4cb17e2b6fda0a72525470c7726567','[\"*\"]','2021-11-09 18:51:50','2021-11-09 18:43:30','2021-11-09 18:51:50'),(212,'App\\Model\\TeacherModel',12,'token','5c861d9bb404d1fd2cc06e07be1c4a2cc3a0f554ee6c5da2ac90d280f718dab6','[\"*\"]','2021-11-09 19:07:12','2021-11-09 18:51:59','2021-11-09 19:07:12'),(213,'App\\Model\\StudentModel',3,'token','338c50b176b9e7987ce9734c1a1fc0117e83cc8541466f09d899f216227a726a','[\"*\"]','2021-11-09 19:26:29','2021-11-09 19:07:29','2021-11-09 19:26:29'),(214,'App\\Model\\StudentModel',3,'token','4601c9c157caf5505de8fef0be914e5d3ccd904a3908241ad222e410941962cb','[\"*\"]','2021-11-09 20:07:51','2021-11-09 19:39:28','2021-11-09 20:07:51'),(215,'App\\Model\\StudentModel',3,'token','823242c54ac5bfca5fbefc44cbddbdfc612686841edf19f3d247b31073f1ef90','[\"*\"]','2021-11-09 20:20:29','2021-11-09 20:10:02','2021-11-09 20:20:29'),(216,'App\\Model\\StudentModel',3,'token','e161f97e19e0f076dd9401b819694c56a50db3a4e8cf012924200e17a9971d6c','[\"*\"]','2021-11-09 23:34:00','2021-11-09 23:16:50','2021-11-09 23:34:00'),(217,'App\\Model\\TeacherModel',12,'token','69f2ef7927062fbcb6e384e4ffc1501eff0e579116236712b3d23a3ce87b0941','[\"*\"]','2021-11-09 23:34:21','2021-11-09 23:34:12','2021-11-09 23:34:21'),(218,'App\\Model\\StudentModel',3,'token','5a0dabe3aa7f874ea4c5d889d091e3eef867a986f0db1338b847e06b805be614','[\"*\"]','2021-11-09 23:37:48','2021-11-09 23:34:56','2021-11-09 23:37:48'),(219,'App\\Model\\TeacherModel',12,'token','5e4145fcac611e6ab2d5de30335ec3490301b6280fd962b457831bffbec51e23','[\"*\"]','2021-11-09 23:38:45','2021-11-09 23:37:57','2021-11-09 23:38:45'),(220,'App\\Model\\StudentModel',3,'token','4c8468776bf9937a7301f9f91a43dada6b73b2cb44b6f98f7f7e61d06cf1bf48','[\"*\"]','2021-11-09 23:53:25','2021-11-09 23:39:00','2021-11-09 23:53:25'),(221,'App\\Model\\StudentModel',3,'token','d825754f0310c994ef084ac026f85a53d9f46e1827d8e0fb863c40f355b8f0e0','[\"*\"]','2021-11-10 14:57:40','2021-11-10 14:32:53','2021-11-10 14:57:40'),(222,'App\\Model\\StudentModel',3,'token','99c09615039193e422389f15e0b2fd5a1186762fc6b1494141348762d4dd5196','[\"*\"]','2021-11-10 17:00:13','2021-11-10 16:53:42','2021-11-10 17:00:13'),(223,'App\\Model\\StudentModel',3,'token','5dad737d193cad0a0e6a608f3c366bd1c1ba3c54ce4d6186ad5cbf3feaf46b2f','[\"*\"]','2021-11-10 19:54:47','2021-11-10 19:54:45','2021-11-10 19:54:47'),(224,'App\\Model\\StudentModel',3,'token','14873ede156cfe339f44427d78c6ed7409310baaabf98746b9b52ed39a8ac22d','[\"*\"]','2021-11-14 11:15:11','2021-11-14 10:51:23','2021-11-14 11:15:11'),(225,'App\\Model\\TeacherModel',12,'token','34b461560aaf096d67a6e0301f7b4f1ddc545de3ed2aad86d786c669f3deeaf3','[\"*\"]','2021-11-14 15:00:31','2021-11-14 14:48:05','2021-11-14 15:00:31'),(226,'App\\Model\\TeacherModel',12,'token','ad6af0a78469ec7236c5858d08bfcb4ae3a5b35e7e24a879f5d3a1e9ed308c84','[\"*\"]','2021-11-14 16:37:35','2021-11-14 16:34:09','2021-11-14 16:37:35'),(227,'App\\Model\\TeacherModel',12,'token','54b7a3e3f4f413ac78e7ccc4bca3c50d7626a89315f69e27408235ad5ad2d7f2','[\"*\"]','2021-11-15 15:43:46','2021-11-15 15:32:55','2021-11-15 15:43:46'),(228,'App\\Model\\StudentModel',3,'token','3b468e49c06ee36ef563f4afc5f9728ece61beeab0c1de3268b244069f3a0ab1','[\"*\"]','2021-11-16 10:08:52','2021-11-16 10:07:19','2021-11-16 10:08:52'),(229,'App\\Model\\TeacherModel',12,'token','7c4edf5ded4aa474f512ae5c60c7f35819109fde9188f25adc6653ebf3e58045','[\"*\"]',NULL,'2021-11-16 10:09:11','2021-11-16 10:09:11'),(230,'App\\Model\\TeacherModel',12,'token','73e9fbe9d933102bae67a433d7e404a0f89d7e405636966d8f7069e36a3a48be','[\"*\"]','2021-11-16 10:11:20','2021-11-16 10:09:12','2021-11-16 10:11:20'),(231,'App\\Model\\StudentModel',3,'token','26147b80aa82b3524219d6abca503fe0ad84ca287e58d8b0b49050b98104c021','[\"*\"]','2021-11-16 10:18:47','2021-11-16 10:12:07','2021-11-16 10:18:47'),(232,'App\\Model\\TeacherModel',12,'token','457e2efff8b48e1571c8c6a28ad96168496ba344078f02ca39109498f098c43f','[\"*\"]','2021-11-16 10:22:25','2021-11-16 10:22:20','2021-11-16 10:22:25'),(233,'App\\Model\\TeacherModel',12,'token','09670602b03be7dd166737cbe2717f21030bb91c5733d698833b43dc8accb163','[\"*\"]','2021-11-16 11:28:59','2021-11-16 11:05:23','2021-11-16 11:28:59'),(234,'App\\Model\\TeacherModel',12,'token','510f849f726df5545ae56ba18f34fdb8411f900e32ac9f91fdc186c07b7f8c29','[\"*\"]','2021-11-16 13:31:17','2021-11-16 13:19:06','2021-11-16 13:31:17'),(235,'App\\Model\\TeacherModel',12,'token','00c9d671210dbd79e61f09d83513d399044821f963cde153cb5cb44fdcdf01a6','[\"*\"]','2021-11-16 13:31:35','2021-11-16 13:31:23','2021-11-16 13:31:35'),(236,'App\\Model\\StudentModel',3,'token','41cf4e3fe1a745789b49e8f321d4b7243c552e3aadc2df17c501b11645872578','[\"*\"]','2021-11-16 13:32:10','2021-11-16 13:32:00','2021-11-16 13:32:10'),(237,'App\\Model\\StudentModel',3,'token','2ca772491590cb1d520401b235ce762b260980ded4061b94180ed2bfeb91c7a7','[\"*\"]','2021-11-16 15:07:54','2021-11-16 15:06:25','2021-11-16 15:07:54'),(238,'App\\Model\\TeacherModel',12,'token','96bd2b55f03a6aca11542e4f601acc4ed29fae92c5b55467d8b1780548e886f5','[\"*\"]','2021-11-16 15:11:53','2021-11-16 15:08:05','2021-11-16 15:11:53'),(239,'App\\Model\\TeacherModel',12,'token','79bc85ab696a820be6059ccd142f1ce69298d4e4f3645f9633f4705782b6a8f3','[\"*\"]',NULL,'2021-11-22 08:53:12','2021-11-22 08:53:12'),(240,'App\\Model\\TeacherModel',12,'token','a86a694e1bbf52762e152c0d6b3dff3b00c11aa6ddaf53c2b2e7a5530581dbc9','[\"*\"]','2021-11-22 08:53:21','2021-11-22 08:53:15','2021-11-22 08:53:21'),(241,'App\\Model\\TeacherModel',12,'token','83898564b39966735466e58b0c8177f2c60703f13146b8dc9866595bf42ea0f4','[\"*\"]','2021-11-22 17:27:11','2021-11-22 17:25:58','2021-11-22 17:27:11'),(242,'App\\Model\\TeacherModel',12,'token','ff457e865dfae6fc3a0ab40acf90bf5f1141daadb3355f320da8c35c014fa8a0','[\"*\"]','2021-11-23 08:48:10','2021-11-23 08:47:57','2021-11-23 08:48:10'),(243,'App\\Model\\TeacherModel',12,'token','88e1f1401ba4e29510ad8b1b5246e23005f649d874ccf2ddf7393fd1c5e71fca','[\"*\"]','2021-11-23 11:00:45','2021-11-23 10:33:31','2021-11-23 11:00:45'),(244,'App\\Model\\TeacherModel',12,'token','0916d7d4d0ce7ee53375b164ec1aedff002355f4e3d36b116b2238db92ae3c32','[\"*\"]','2021-11-23 11:11:06','2021-11-23 11:07:59','2021-11-23 11:11:06'),(245,'App\\Model\\TeacherModel',12,'token','8d7be1015e74bf5df7216c8bfa1598867e8a31b4e9c108e58c897005fcb3fb90','[\"*\"]','2021-11-23 13:20:23','2021-11-23 12:50:31','2021-11-23 13:20:23'),(246,'App\\Model\\TeacherModel',12,'token','f6493ea37d784708841dd10aebd6dbafb2c022bafdc1ba4a544af6fea060438c','[\"*\"]','2021-11-23 13:33:25','2021-11-23 13:20:50','2021-11-23 13:33:25'),(247,'App\\Model\\TeacherModel',12,'token','79aa5e426fd3346d73734e684642b8d27b210e689ae6c855530a618f2a410227','[\"*\"]','2021-11-23 14:20:23','2021-11-23 14:19:26','2021-11-23 14:20:23'),(248,'App\\Model\\TeacherModel',12,'token','69cc6a6089a905b41a4cae67ea09abf513c9e025bae70ee7c4a529f37d418e76','[\"*\"]','2021-11-23 17:01:00','2021-11-23 16:33:04','2021-11-23 17:01:00'),(249,'App\\Model\\TeacherModel',12,'token','db99b96a465588d43abd12f8fac07c40791c91744481b1b0094d5a0b173a090e','[\"*\"]','2021-11-23 17:25:58','2021-11-23 17:07:00','2021-11-23 17:25:58'),(250,'App\\Model\\TeacherModel',12,'token','f31bc68f519ed1eeb4f2238848c8853f63ed12b86127e33f8e51446f58a79c37','[\"*\"]','2021-11-23 19:14:56','2021-11-23 18:45:14','2021-11-23 19:14:56'),(251,'App\\Model\\TeacherModel',12,'token','66467d1c3e6ebcf7c3d2f4b1218055d1e417776a074216417026e12328587575','[\"*\"]','2021-11-23 19:32:51','2021-11-23 19:15:18','2021-11-23 19:32:51'),(252,'App\\Model\\TeacherModel',12,'token','86c6213d6555d2b237696387d3fb762c333927cc650fd4616429822309d7c158','[\"*\"]','2021-11-23 20:17:25','2021-11-23 19:51:13','2021-11-23 20:17:25'),(253,'App\\Model\\TeacherModel',12,'token','76dbd8b77e5ae6d0cf8f373d8ee3bdcdb3fd06a620b2841fa163ee7a6d42333c','[\"*\"]','2021-11-23 20:25:49','2021-11-23 20:22:27','2021-11-23 20:25:49'),(254,'App\\Model\\TeacherModel',12,'token','e59b312faeaa0ea7db246103c3302d6c8b585bf9f48b594142fb0cc733fec1da','[\"*\"]','2021-11-24 06:45:15','2021-11-24 06:44:45','2021-11-24 06:45:15'),(255,'App\\Model\\TeacherModel',12,'token','d3232232c954244b9732e2137df09e6a5193cb13665f283e4f1adfd11afa56a9','[\"*\"]','2021-11-24 09:04:20','2021-11-24 08:58:33','2021-11-24 09:04:20'),(256,'App\\Model\\TeacherModel',12,'token','669f7a88a1ceb52cd1107ac634e982828f05c4382369862490d95e9779bc318b','[\"*\"]','2021-11-24 10:49:46','2021-11-24 10:49:22','2021-11-24 10:49:46'),(257,'App\\Model\\TeacherModel',12,'token','84b08a1ef0aece03d29fb24c54e43d7d9e1e2976b37dfbe19f45d90d66f3c183','[\"*\"]','2021-11-24 12:11:16','2021-11-24 12:07:25','2021-11-24 12:11:16'),(258,'App\\Model\\TeacherModel',12,'token','6c1e8936a110684fa0772a407946da060e7f611eb879abafdbaa31ee63ac18fa','[\"*\"]','2021-11-24 17:58:09','2021-11-24 17:58:00','2021-11-24 17:58:09'),(259,'App\\Model\\TeacherModel',12,'token','a1e43a5e62f5f5cb7ad7b2145a80ce8f28801fc65db733935c93c1763556da7d','[\"*\"]','2021-11-25 16:23:13','2021-11-25 15:55:46','2021-11-25 16:23:13'),(260,'App\\Model\\TeacherModel',12,'token','c553f98a8c7bcf06bafc4c496d683a762888a978660d3dc6b654edea3e7583ec','[\"*\"]','2021-11-25 16:51:45','2021-11-25 16:29:10','2021-11-25 16:51:45'),(261,'App\\Model\\TeacherModel',12,'token','e625b8c4a16e6394d802cc3abfc60801b50c103a2c8d390446f7542a8ee34822','[\"*\"]','2021-11-25 17:31:01','2021-11-25 17:03:14','2021-11-25 17:31:01'),(262,'App\\Model\\StudentModel',3,'token','759bbb16a828bd758e890e9bbab4da3a367b81d08b47928701de23c4db53faeb','[\"*\"]','2021-11-25 19:45:50','2021-11-25 19:45:17','2021-11-25 19:45:50'),(263,'App\\Model\\TeacherModel',12,'token','feeda18d6230e2d062b0ba196677c6da609861238b9f7556ce51d11dc9643817','[\"*\"]','2021-11-25 19:47:53','2021-11-25 19:46:17','2021-11-25 19:47:53'),(264,'App\\Model\\TeacherModel',12,'token','bbe152fe86162f6ee0bf1729b7ebc08ad8fd948d85f66b9d45ff5cd352562846','[\"*\"]','2021-11-25 20:53:11','2021-11-25 20:23:39','2021-11-25 20:53:11'),(265,'App\\Model\\TeacherModel',12,'token','e5f6399cd912a550dc85efdfcbca600cc2f7ae07c1ac4859040f630fa6afbda9','[\"*\"]','2021-11-25 21:14:21','2021-11-25 20:53:58','2021-11-25 21:14:21'),(266,'App\\Model\\TeacherModel',12,'token','7a8762564f84fea4d0156318afb8d513433adfe6cd7a7be03a15a4228ad1fa66','[\"*\"]','2021-11-25 22:13:15','2021-11-25 21:48:50','2021-11-25 22:13:15'),(267,'App\\Model\\TeacherModel',12,'token','c5ba60a704b56aba9b1b936c2ee0ed80f5da6ae6a9ad7c9d71e343536018c660','[\"*\"]','2021-11-25 22:19:07','2021-11-25 22:18:56','2021-11-25 22:19:07'),(268,'App\\Model\\TeacherModel',12,'token','e3350ceb33bbaff650549b1e7be9a4faa979f939ac2eed6017446554160a3f52','[\"*\"]','2021-11-26 07:12:18','2021-11-26 06:42:44','2021-11-26 07:12:18'),(269,'App\\Model\\TeacherModel',12,'token','f2df45fe2caa418016bf970df4775f6a418078104e8d0063f901b73ba545e5bf','[\"*\"]','2021-11-26 07:34:58','2021-11-26 07:14:47','2021-11-26 07:34:58'),(270,'App\\Model\\TeacherModel',12,'token','a712553538c979af1c5f3dc370a85ca0e6f3c9528e574514d5d07ef560fd2f1f','[\"*\"]','2021-11-26 08:19:21','2021-11-26 07:50:25','2021-11-26 08:19:21'),(271,'App\\Model\\TeacherModel',12,'token','072691d627b7b180b1207bc86541530425be6112656f8e75413d008dbfcb359e','[\"*\"]','2021-11-26 08:45:39','2021-11-26 08:20:35','2021-11-26 08:45:39'),(272,'App\\Model\\TeacherModel',12,'token','addf8ce45ea1d323eff69176e685bc502fc2f2c086d9d04ebde079b85a1dd33a','[\"*\"]','2021-11-26 09:18:15','2021-11-26 08:51:50','2021-11-26 09:18:15'),(273,'App\\Model\\TeacherModel',12,'token','78d23344df70ec22c40c39aeba7f6bbe9173f73479ccc139343163456b9fc6e1','[\"*\"]','2021-11-26 09:59:41','2021-11-26 09:35:00','2021-11-26 09:59:41'),(274,'App\\Model\\TeacherModel',12,'token','3cb79b863c1f256df6fdd64b751d101b4a5f8039386eac1598939fb1d43210d7','[\"*\"]','2021-11-26 14:53:29','2021-11-26 14:51:57','2021-11-26 14:53:29'),(275,'App\\Model\\TeacherModel',12,'token','30896489dcd4687cedaf8e8569e422a2be6e9ccdc76146cba02e41bcee58f3d5','[\"*\"]','2021-11-27 14:13:31','2021-11-27 14:12:03','2021-11-27 14:13:31'),(276,'App\\Model\\StudentModel',3,'token','0d928fcc4d20cf64b9cfc34d58a7b2ed60d3e635c0794be09e7e451f948aafaa','[\"*\"]','2021-11-27 14:16:29','2021-11-27 14:13:39','2021-11-27 14:16:29'),(277,'App\\Model\\TeacherModel',12,'token','4f591c0c913efa7580f0b84e515fc6074ba62e46ad6b8acf40a33a323f89bb8b','[\"*\"]','2021-11-27 14:19:46','2021-11-27 14:16:39','2021-11-27 14:19:46'),(278,'App\\Model\\TeacherModel',12,'token','b7557443270ea23b80a66f02ec3b85cc623faa722d3807b0c0b1e9d6caba20b4','[\"*\"]','2021-11-27 14:23:49','2021-11-27 14:19:59','2021-11-27 14:23:49'),(279,'App\\Model\\StudentModel',3,'token','f99308e77e780cd695abaeeb28c376880689ff72f2fa2a6848571ab6e7d465d2','[\"*\"]','2021-11-27 14:24:17','2021-11-27 14:24:02','2021-11-27 14:24:17'),(280,'App\\Model\\StudentModel',3,'token','cf791c17e76454b8e9034aa09b3529c285437079e7a5399894cabea50ec5005c','[\"*\"]','2021-11-27 14:55:05','2021-11-27 14:54:35','2021-11-27 14:55:05'),(281,'App\\Model\\TeacherModel',12,'token','2c30310c1361bc48114beb0c4fa6ae8787756c61c1b94a60ac52c5370cea686b','[\"*\"]','2021-11-27 15:28:22','2021-11-27 14:58:30','2021-11-27 15:28:22'),(282,'App\\Model\\TeacherModel',12,'token','cebc8c8094e0accbc97d5992e43a41243c93aa1a973b49c6b0ffb18420f9a5c0','[\"*\"]','2021-11-27 18:37:16','2021-11-27 18:28:28','2021-11-27 18:37:16'),(283,'App\\Model\\TeacherModel',12,'token','5248a929110791c68523b1dd2b76ec0d617956672709345db2bee02f0d5faaf4','[\"*\"]','2021-11-28 09:19:55','2021-11-28 09:18:55','2021-11-28 09:19:55');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session` varchar(45) NOT NULL,
  `term` varchar(45) NOT NULL,
  `session_status` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session`
--

LOCK TABLES `session` WRITE;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` VALUES (1,'2017/2018','FIRST TERM','PAST'),(2,'2018/2020','FIRST TERM','PAST'),(3,'2018/2019','SECOND TERM','PAST'),(4,'2020/2021','FIRST TERM','CURRENT');
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `student_id` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `religion` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `joining_date` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `joining_session` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_address` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '/no-image',
  `class` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guardian_name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guardian_phone` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guardian_email` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guardian_address` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_status` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (2,'2021-STD-002','LANRE','FEMI BRO','ADEYEMI','MALE','MUSLIM','31/05/2021','28/09/2021','2016/2017','BLOCK 12A','ADAMAWA','/no-image','12','MR ADEYEMI TIMOTHY','08133968949','olushola@gmail.com','BLOK 10','DISABLE','lanre.adeyemi'),(3,'2021-STD-003','FINKE','KEMO','ALOA','FEMALE','CHRISTIAN','27/12/1999','29/09/2021','2017/2018','B3','ABIA','/no-image','12','MRS ALOS','08133968949','olushola@gmail.com','BK7','ENABLED','finke.aloa');
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_attendance`
--

DROP TABLE IF EXISTS `student_attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `class_id` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `time` varchar(45) NOT NULL,
  `term` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `session` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=armscii8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_attendance`
--

LOCK TABLES `student_attendance` WRITE;
/*!40000 ALTER TABLE `student_attendance` DISABLE KEYS */;
INSERT INTO `student_attendance` VALUES (1,'2','12','23/11/2021','17:54','FIRST TERM','2020/2021'),(2,'2','12','24/11/2021','10:4','FIRST TERM','2020/2021'),(3,'2','12','27/11/2021','19:28','FIRST TERM','2020/2021'),(4,'2','12','28/11/2021','10:19','FIRST TERM','2020/2021');
/*!40000 ALTER TABLE `student_attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_result_comment`
--

DROP TABLE IF EXISTS `student_result_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_result_comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` varchar(45) NOT NULL,
  `class_teacher_comment` varchar(255) NOT NULL DEFAULT '-',
  `principal_comment` varchar(255) NOT NULL DEFAULT '-',
  `session` varchar(45) NOT NULL,
  `term` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_result_comment`
--

LOCK TABLES `student_result_comment` WRITE;
/*!40000 ALTER TABLE `student_result_comment` DISABLE KEYS */;
INSERT INTO `student_result_comment` VALUES (1,'2','-','-','2020/2021','FIRST TERM'),(2,'3','-','-','2020/2021','FIRST TERM');
/*!40000 ALTER TABLE `student_result_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_result_rating`
--

DROP TABLE IF EXISTS `student_result_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_result_rating` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` varchar(45) NOT NULL,
  `handwriting` varchar(45) NOT NULL DEFAULT '5',
  `fluency` varchar(45) NOT NULL DEFAULT '5',
  `games` varchar(45) NOT NULL DEFAULT '5',
  `sport` varchar(45) NOT NULL DEFAULT '5',
  `handling_tools` varchar(45) NOT NULL DEFAULT '5',
  `drawing_painting` varchar(45) NOT NULL DEFAULT '5',
  `musical_skill` varchar(45) NOT NULL DEFAULT '5',
  `neatness` varchar(45) NOT NULL DEFAULT '5',
  `politeness` varchar(45) NOT NULL DEFAULT '5',
  `cooperation` varchar(45) NOT NULL DEFAULT '5',
  `leadership` varchar(45) NOT NULL DEFAULT '5',
  `helping_others` varchar(45) NOT NULL DEFAULT '5',
  `health` varchar(45) NOT NULL DEFAULT '5',
  `attitude` varchar(45) NOT NULL DEFAULT '5',
  `perseverance` varchar(45) NOT NULL DEFAULT '5',
  `session` varchar(45) NOT NULL,
  `term` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_result_rating`
--

LOCK TABLES `student_result_rating` WRITE;
/*!40000 ALTER TABLE `student_result_rating` DISABLE KEYS */;
INSERT INTO `student_result_rating` VALUES (1,'2','5','5','5','5','5','5','5','5','5','5','5','5','5','5','5','2020/2021','FIRST TERM'),(2,'3','5','5','5','5','5','5','5','5','5','5','5','5','5','5','5','2020/2021','FIRST TERM');
/*!40000 ALTER TABLE `student_result_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subject` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ref_to_teacher_on_subject_idx` (`teacher`),
  CONSTRAINT `ref_to_teacher_on_subject` FOREIGN KEY (`teacher`) REFERENCES `teacher` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` VALUES (1,'ENGLISH LANGUAGE','12',12),(2,'PHYSICAL HEALTH EDUCATION','12',14),(3,'CIVICS EDUCATION','12',12);
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject_registration`
--

DROP TABLE IF EXISTS `subject_registration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subject_registration` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject_id` varchar(45) NOT NULL,
  `student_id` varchar(45) NOT NULL,
  `subject_type` varchar(45) NOT NULL,
  `term` varchar(45) NOT NULL,
  `session` varchar(45) NOT NULL,
  `class_id` varchar(45) NOT NULL,
  `first_ca` varchar(45) NOT NULL DEFAULT '-',
  `second_ca` varchar(45) NOT NULL DEFAULT '-',
  `examination` varchar(45) NOT NULL DEFAULT '-',
  `total` int DEFAULT '0',
  `grade` varchar(45) NOT NULL DEFAULT '-',
  `remark` varchar(45) NOT NULL DEFAULT '-',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject_registration`
--

LOCK TABLES `subject_registration` WRITE;
/*!40000 ALTER TABLE `subject_registration` DISABLE KEYS */;
INSERT INTO `subject_registration` VALUES (72,'3','3','ELECTIVE','FIRST TERM','2020/2021','12','-','-','-',0,'-','-'),(89,'2','2','COMPULSORY','FIRST TERM','2020/2021','12','-','-','-',0,'-','-'),(90,'3','2','COMPULSORY','FIRST TERM','2020/2021','12','-','-','-',0,'-','-'),(91,'2','3','COMPULSORY','FIRST TERM','2020/2021','12','-','-','-',0,'-','-'),(92,'3','3','COMPULSORY','FIRST TERM','2020/2021','12','-','-','-',0,'-','-');
/*!40000 ALTER TABLE `subject_registration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teacher`
--

DROP TABLE IF EXISTS `teacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teacher` (
  `id` int NOT NULL AUTO_INCREMENT,
  `teacher_id` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `religion` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `joining_date` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_address` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT '/no-image',
  `assigned_class` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `profile_status` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher`
--

LOCK TABLES `teacher` WRITE;
/*!40000 ALTER TABLE `teacher` DISABLE KEYS */;
INSERT INTO `teacher` VALUES (12,'2020-STF-000','Miss','THERESA','TOFUNMI','OYEBANJI','FEMALE','CHRISTIAN','05/10/2021','08133968949','','28/09/2021','BLK 12','EKITI','/no-image','12','DISABLE','THERESA.OYEBANJI'),(14,'2021-STF-014','Mr','AMINU','ADAMU','AKEEM','MALE','MUSLIM','28/09/2021','08133968949','ialtenwerth@gmail.com','04/10/2021','IMODE','KADUNA','/no-image','-','ENABLED','AMINU.ADAMU'),(15,'2021-STF-015','Miss','ADEOLA','LONGE','BIDEMI','FEMALE','MUSLIM','05/10/2021','08133968949','ialtenwerth@gmail.com','04/10/2021','HONEY MOON','KOGI','/no-image','-','DISABLE','ADEOLA.BIDEMI');
/*!40000 ALTER TABLE `teacher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_profile`
--

DROP TABLE IF EXISTS `user_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_profile` (
  `id` int NOT NULL AUTO_INCREMENT,
  `profile_status` varchar(45) NOT NULL,
  `password` varchar(500) NOT NULL DEFAULT '1234567890',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profile`
--

LOCK TABLES `user_profile` WRITE;
/*!40000 ALTER TABLE `user_profile` DISABLE KEYS */;
INSERT INTO `user_profile` VALUES (1,'ENABLED','THERESA.OYENBANJI'),(2,'DISABLE','ADEBAYO.BADRU'),(3,'ENABLED','AMINU.AKEEM');
/*!40000 ALTER TABLE `user_profile` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-28 12:20:10
