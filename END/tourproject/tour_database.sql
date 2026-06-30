-- MySQL dump 10.13  Distrib 8.4.10, for Linux (x86_64)
--
-- Host: localhost    Database: tour
-- ------------------------------------------------------
-- Server version	8.4.10-0ubuntu0.26.04.1

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
-- Table structure for table `blog_images`
--

DROP TABLE IF EXISTS `blog_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` bigint unsigned NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_images_blog_id_foreign` (`blog_id`),
  CONSTRAINT `blog_images_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_images`
--

LOCK TABLES `blog_images` WRITE;
/*!40000 ALTER TABLE `blog_images` DISABLE KEYS */;
INSERT INTO `blog_images` VALUES (14,6,'blogs/6a4114faebffb.webp','2026-06-28 09:35:07','2026-06-28 09:35:07'),(15,6,'blogs/6a4114fb66ba0.webp','2026-06-28 09:35:07','2026-06-28 09:35:07'),(16,6,'blogs/6a4114fb839ef.webp','2026-06-28 09:35:07','2026-06-28 09:35:07'),(17,6,'blogs/6a4114fb99d23.webp','2026-06-28 09:35:07','2026-06-28 09:35:07'),(18,7,'blogs/6a41226a6461b.webp','2026-06-28 10:32:26','2026-06-28 10:32:26'),(19,7,'blogs/6a41226a8da87.webp','2026-06-28 10:32:26','2026-06-28 10:32:26');
/*!40000 ALTER TABLE `blog_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blogs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'General',
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `seo_meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_meta_description` text COLLATE utf8mb4_unicode_ci,
  `focus_keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `author_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blogs_slug_unique` (`slug`),
  KEY `blogs_author_id_foreign` (`author_id`),
  CONSTRAINT `blogs_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
INSERT INTO `blogs` VALUES (6,'exploring the stone town\'s sun set','exploring-the-stone-towns-sun-set','this is the most enjoyable tour in zanzibar., travellers feels so pretty to stay in this position.','As the day draws to a close in Stone Town, Zanzibar\'s historic heart, something magical unfolds along the ancient coral stone walls and narrow alleyways. The sunset here isn\'t just a daily occurrence—it\'s a spectacle that has captivated travelers, traders, and locals for centuries. Join me as I take you through an unforgettable evening watching the sun dip below the Indian Ocean horizon from one of Africa\'s most enchanting destinations.','Zanzibar, Tanzania','Travel Tips','[\"tour\",\"enjoy\",\"explore\"]','3 HRS','published','best tour','Stone Town, a UNESCO World Heritage Site, is a labyrinth of winding streets where Arabian, Persian, Indian, and European influences blend seamlessly. Built primarily from coral rag and lime mortar, the town\'s distinctive architecture tells stories of its rich trading history dating back over a thousand years.','tour zanzibar','2026-06-28 09:35:05','2026-06-28 09:35:05',3),(7,'exploring the beautiful beach with a company','exploring-the-beautiful-beach-with-a-company','this is a perfect adventure travellers was never expected','starting with a breakfast , a litle hot coffee and some water','Zanzibar, Tanzania','General','[\"tour\",\"enjoy\",\"explore\"]','7 Hrs','published','best tour zanzibar','enjoy our hospitality','tour zanzibar','2026-06-28 10:32:26','2026-06-28 10:32:26',3);
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tour_id` bigint unsigned DEFAULT NULL,
  `safari_id` bigint unsigned DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special_requests` longtext COLLATE utf8mb4_unicode_ci,
  `number_of_tourists` int NOT NULL,
  `children_count` int NOT NULL DEFAULT '0',
  `booking_date` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bookings_tour_id_foreign` (`tour_id`),
  KEY `bookings_safari_id_foreign` (`safari_id`),
  CONSTRAINT `bookings_safari_id_foreign` FOREIGN KEY (`safari_id`) REFERENCES `safaris` (`id`) ON DELETE SET NULL,
  CONSTRAINT `bookings_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-77de68daecd823babbb58edb1c8e14d7106e83bb','i:1;',1782317792),('laravel-cache-77de68daecd823babbb58edb1c8e14d7106e83bb:timer','i:1782317792;',1782317792),('laravel-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0','i:1;',1782225946),('laravel-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0:timer','i:1782225946;',1782225946),('laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6','i:1;',1782318697),('laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer','i:1782318697;',1782318697);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` VALUES (1,'ashraf','sharif','sharifbeyy@gmail.com','does the price fluctuate?','2026-06-20 12:56:30','2026-06-21 17:42:36'),(2,'John','Doe','test@test.com','Test','2026-06-20 13:02:49','2026-06-20 13:02:49');
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_06_20_075153_create_tours_table',1),(5,'2026_06_20_075154_create_safaris_table',1),(6,'2026_06_20_075154_create_tour_images_table',1),(7,'2026_06_20_075155_create_blogs_table',1),(8,'2026_06_20_075155_create_safari_images_table',1),(9,'2026_06_20_075156_create_blog_images_table',1),(10,'2026_06_20_075156_create_bookings_table',1),(11,'2026_06_20_075156_create_contacts_table',1),(12,'2026_06_20_075157_add_is_admin_to_users_table',2),(13,'2026_06_25_000000_add_status_to_bookings_table',3),(14,'2026_06_28_000001_create_reviews_table',4),(15,'2026_06_28_000002_create_review_images_table',4),(16,'2026_06_28_000003_add_booking_date_to_bookings_table',4),(17,'2026_06_28_000004_add_included_excluded_to_tours_table',4),(18,'2026_06_28_000005_add_excluded_to_safaris_table',4),(19,'2026_06_28_000003_add_whatsapp_number_to_reviews_table',5),(21,'2026_06_28_000000_expand_blogs_table',6),(22,'2026_06_28_000004_add_children_count_to_bookings_table',7),(23,'2026_06_28_100000_add_seo_fields_to_blogs_and_tours_tables',8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review_images`
--

DROP TABLE IF EXISTS `review_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `review_id` bigint unsigned NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `review_images_review_id_foreign` (`review_id`),
  CONSTRAINT `review_images_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review_images`
--

LOCK TABLES `review_images` WRITE;
/*!40000 ALTER TABLE `review_images` DISABLE KEYS */;
INSERT INTO `review_images` VALUES (2,2,'reviews/6a40d0717b091.webp','2026-06-28 04:42:41','2026-06-28 04:42:41');
/*!40000 ALTER TABLE `review_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `traveler_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsapp_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tour_id` bigint unsigned DEFAULT NULL,
  `safari_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` tinyint unsigned NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_tour_id_foreign` (`tour_id`),
  KEY `reviews_safari_id_foreign` (`safari_id`),
  CONSTRAINT `reviews_safari_id_foreign` FOREIGN KEY (`safari_id`) REFERENCES `safaris` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reviews_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (2,'tukuf jr','0776585347','morocco',NULL,4,'amazing experience of stone town',4,'mundir is better guider in Zanzibar','approved','2026-06-28 04:42:41','2026-06-28 04:53:27');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `safari_images`
--

DROP TABLE IF EXISTS `safari_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `safari_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `safari_id` bigint unsigned NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `safari_images_safari_id_foreign` (`safari_id`),
  CONSTRAINT `safari_images_safari_id_foreign` FOREIGN KEY (`safari_id`) REFERENCES `safaris` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `safari_images`
--

LOCK TABLES `safari_images` WRITE;
/*!40000 ALTER TABLE `safari_images` DISABLE KEYS */;
INSERT INTO `safari_images` VALUES (6,4,'safaris/8WDVLYslXSY4E6mk88Te3LSkgMGi9FlR0OIKavbS.png','2026-06-24 17:53:50','2026-06-24 17:53:50'),(7,4,'safaris/SgLnevrC1ZCfJNlCr3pI4LoFzHikaIZySoi4SmGf.png','2026-06-24 17:53:50','2026-06-24 17:53:50');
/*!40000 ALTER TABLE `safari_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `safaris`
--

DROP TABLE IF EXISTS `safaris`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `safaris` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `highlights` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `included` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `excluded` longtext COLLATE utf8mb4_unicode_ci,
  `itinerary` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `safaris`
--

LOCK TABLES `safaris` WRITE;
/*!40000 ALTER TABLE `safaris` DISABLE KEYS */;
INSERT INTO `safaris` VALUES (4,'Mikumi National Park 2-Day Safari','Fourth largest park in Tanzania; high concentration of lions & elephants; Mkata Floodplain resembles Serengeti; baobab-lined roads; excellent birdwatching (400+ species); less crowded than northern parks.','Journey to Mikumi National Park, part of the vast Selous ecosystem, for an immersive 2-day safari adventure. The Mkata Floodplain offers Serengeti-like plains teeming with wildlife, and the park’s accessibility from Zanzibar makes it ideal for travelers seeking authentic wilderness without flying north.',200.00,'2 day 1 night','All transfers (ferry + 4x4), park fees, 1 night tented lodge accommodation, all meals (breakfast, lunch, dinner), professional guide, game drives, drinking water, camping/lodge equipment, taxes.',NULL,'05:00 AM: Pickup & ferry to mainland.\r\n08:00 AM: Drive to Mikumi (4 hrs via scenic route).\r\n12:00 PM: Arrive lodge; lunch & rest.\r\n02:00 PM: Afternoon game drive in Mkata Floodplain.\r\n06:00 PM: Return to lodge; sundowners.\r\n07:30 PM: Dinner under stars.','2026-06-24 17:53:50','2026-06-24 17:53:50');
/*!40000 ALTER TABLE `safaris` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('HXKfZ4CYzWaebEDwh7nCman0w4LpUFhQQ1FAWMWp',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.118.1 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36','eyJfdG9rZW4iOiJmM1F5ZlJ2blFZTG5HWmN6NWhYQU1tV2lld0QwSFVQTDV1V0tERlhjIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9sb2dpbiIsInJvdXRlIjoiZmlsYW1lbnQuYWRtaW4uYXV0aC5sb2dpbiJ9fQ==',1782318883);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tour_images`
--

DROP TABLE IF EXISTS `tour_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tour_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tour_id` bigint unsigned NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tour_images_tour_id_foreign` (`tour_id`),
  CONSTRAINT `tour_images_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tour_images`
--

LOCK TABLES `tour_images` WRITE;
/*!40000 ALTER TABLE `tour_images` DISABLE KEYS */;
INSERT INTO `tour_images` VALUES (7,4,'tours/8fiLSXQbm0dKncUZsl5Dt7g8eUTzGxw06kcfSKnL.jpg','2026-06-24 17:44:17','2026-06-24 17:44:17'),(8,4,'tours/eViTLEn7TzEV6tx5R1DbX6sfzAUnGAYjhERFar0N.jpg','2026-06-24 17:44:17','2026-06-24 17:44:17'),(16,6,'tours/y6uk9j1nq7l9tlSPLuXdeln66DqCcFEOsIjID66E.jpg','2026-06-24 17:50:39','2026-06-24 17:50:39'),(17,6,'tours/F78KF8yEIqI711u3tj2Uk4vR0Cwwm2vqo3fdPIhN.jpg','2026-06-24 17:50:39','2026-06-24 17:50:39'),(18,6,'tours/BK46ztm2qf1AwpCzZHm5oYU26Ufde5Va84VOuQRh.jpg','2026-06-24 17:50:39','2026-06-24 17:50:39'),(25,8,'tours/6a4121752433d.webp','2026-06-28 10:28:21','2026-06-28 10:28:21'),(26,8,'tours/6a412175c9a9b.webp','2026-06-28 10:28:21','2026-06-28 10:28:21');
/*!40000 ALTER TABLE `tour_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tours`
--

DROP TABLE IF EXISTS `tours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tours` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `itinerary` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `included` longtext COLLATE utf8mb4_unicode_ci,
  `excluded` longtext COLLATE utf8mb4_unicode_ci,
  `seo_meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_meta_description` text COLLATE utf8mb4_unicode_ci,
  `focus_keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tours_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tours`
--

LOCK TABLES `tours` WRITE;
/*!40000 ALTER TABLE `tours` DISABLE KEYS */;
INSERT INTO `tours` VALUES (4,'Mnemba Atoll Snorkeling & Dolphin Adventure','mnemba-atoll-snorkeling-dolphin-adventure','Experience the crystal-clear waters of Mnemba Atoll, a protected marine conservation area famous for its vibrant coral reefs and diverse marine life. This tour combines world-class snorkeling with the chance to spot wild dolphins in their natural habitat off the coast of Matemwe.',12.00,'2','08:00 AM: Hotel pickup and transfer to Matemwe Beach.\r\n09:00 AM: Speedboat ride to Mnemba Atoll.\r\n09:30 AM: First snorkeling session at the \"Garden\" reef.\r\n11:00 AM: Dolphin watching cruise along the channel.\r\n12:30 PM: Second snorkeling stop at a deeper reef site.\r\n01:30 PM: Relaxation time on a private sandbank.\r\n02:30 PM: Return boat ride and beachside lunch.\r\n03:30 PM: Transfer back to hotel.',NULL,NULL,NULL,NULL,NULL,'2026-06-24 17:44:17','2026-06-24 17:44:17'),(6,'Jozani Forest & Red Colobus Monkey Trek','jozani-forest-red-colobus-monkey-trek','Explore Zanzibar’s only national park, the ancient Jozani Chwaka Bay National Park. Walk through mangrove boardwalks and indigenous forest to encounter the rare and endemic Zanzibar Red Colobus monkeys, found nowhere else on Earth.',3.00,'1 day','08:30 AM: Pickup from Nungwi or Kendwa area.\r\n09:30 AM: Arrival at Jozani Forest entrance.\r\n09:45 AM: Guided walk through the main forest trail.\r\n10:30 AM: Observation of Red Colobus monkey troops.\r\n11:15 AM: Mangrove boardwalk nature walk.\r\n12:00 PM: Visit to the butterfly garden and herbal medicine section.\r\n12:30 PM: Departure from park.\r\n01:30 PM: Drop-off at hotel.',NULL,NULL,NULL,NULL,NULL,'2026-06-24 17:50:39','2026-06-24 17:50:39'),(8,'Safari Blue Full-Day Ocean Adventure','safari-blue-full-day-ocean-adventure','A full-day sailing experience on a traditional dhow exploring the crystal-clear waters, sandbanks, snorkeling spots, and mangrove lagoons. Ideal for swimming, seafood lovers, and ocean relaxation.',45.00,'5 Hrs','Morning pickup from hotel\r\nSailing by traditional dhow boat\r\nSnorkeling at coral reefs\r\nVisit sandbank for swimming & photos\r\nKayaking in mangrove lagoon\r\nSeafood BBQ lunch (fish, rice, tropical fruits)\r\nSunset sailing return','Boat transport (dhow)\r\nSnorkeling gear\r\nSeafood lunch + fruits\r\nDrinking water\r\nGuide service','Private luxury boat upgrade\r\nAlcoholic drinks\r\nProfessional photography service\r\nTips & personal expenses\r\nHotel upgrade transfers (VIP transport)','Zanzibar Beach','A full-day sailing experience on a traditional','zanzibar beach holiday','2026-06-28 10:28:20','2026-06-28 10:28:20');
/*!40000 ALTER TABLE `tours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test User','test@example.com','2026-06-20 15:12:10','$2y$12$VaIeHOzBjPIQRDc.D/YKn.o8G9L5GPF7SqT/p0rEDiQlztTqYIZcS',0,'0SsXoIeyKK','2026-06-20 15:12:10','2026-06-20 15:12:10'),(2,'Administrator','othmanbeyy@gmail.com','2026-06-20 15:12:11','$2y$12$pBPE81nwKqmePkm2T9n8LOpLxz5HGRvr.8vgwPXDe34qa9dfEU0q6',1,NULL,'2026-06-20 15:12:11','2026-06-23 10:48:59'),(3,'admin','sharifbeyy@gmail.com',NULL,'$2y$12$DLg50vLbkm1ngBc3yOx9N.eQpyxcPODmSNmiv0p9zAXNdIN0lEYJK',1,'MCR9RZEKJfHPONz8RamUmhAyNxIs8AgQhcweNnBUDemMFGUYyURpR88yegYv','2026-06-21 08:36:30','2026-06-24 13:34:08');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-28 22:05:38
