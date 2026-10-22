-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: smecone_music
-- ------------------------------------------------------
-- Server version	8.4.3

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
-- Table structure for table `borrowings`
--

DROP TABLE IF EXISTS `borrowings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `borrowings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `instrument_id` bigint unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `permission_letter_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected','returned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `borrowings_user_id_foreign` (`user_id`),
  KEY `borrowings_instrument_id_foreign` (`instrument_id`),
  CONSTRAINT `borrowings_instrument_id_foreign` FOREIGN KEY (`instrument_id`) REFERENCES `instruments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `borrowings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borrowings`
--

LOCK TABLES `borrowings` WRITE;
/*!40000 ALTER TABLE `borrowings` DISABLE KEYS */;
/*!40000 ALTER TABLE `borrowings` ENABLE KEYS */;
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
-- Table structure for table `divisions`
--

DROP TABLE IF EXISTS `divisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `divisions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pengurus Harian',
  `description` text COLLATE utf8mb4_unicode_ci,
  `cover_image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `divisions_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `divisions`
--

LOCK TABLES `divisions` WRITE;
/*!40000 ALTER TABLE `divisions` DISABLE KEYS */;
INSERT INTO `divisions` VALUES (1,'Pengurus Inti','pengurus-inti','Pimpinan & Pengurus Inti','Pemegang amanah tertinggi dalam pengambilan kebijakan strategis dan penentu arah gerak organisasi Smecone Music.','divisions/r3i5Phb3gj83lBGGbS6E7TNU7g0ha2uq8qnR1ZAE.jpg',1,'2026-10-21 07:06:47','2026-10-21 07:34:07'),(2,'Divisi Humas','humas','Pengurus Harian','Menjalin komunikasi, membangun relasi publik, serta menjaga citra positif organisasi Smecone Music.','divisions/rhNi5iQsKsG3FtX1tLeIgryP28oVc0hq449y35VU.jpg',2,'2026-10-21 07:06:47','2026-10-21 07:35:38'),(3,'Divisi Alat Musik','alat-musik','Pengurus Harian','Mengelola forum alat musik, pemeliharaan, dan optimalisasi seluruh peralatan serta fasilitas musik.','divisions/3jCoGH3uq2623ZprHUzXtVn4CCj8mv4bmOFzO2sA.jpg',3,'2026-10-21 07:06:47','2026-10-21 07:37:16'),(4,'Divisi Vocal','vocal','Pengurus Harian','Mengembangkan bakat vokal, tata aransemen nada, dan keharmonisan paduan suara.','divisions/ZsImy3tKHjVzh9T4SMryDFfnm1KqxC3IGYnFFYGy.jpg',4,'2026-10-21 07:06:47','2026-10-21 07:38:46'),(5,'Divisi Kegiatan','kegiatan','Pengurus Harian','Merencanakan dan mengeksekusi berbagai program kerja, event, serta pertunjukan.','divisions/womug3IAGYYzFayaaMzwVUNBnP9JnyHUJx853qEd.jpg',5,'2026-10-21 07:06:47','2026-10-21 07:39:45'),(6,'Divisi PDD','pdd','Pengurus Harian','Publikasi, Dekorasi, & Dokumentasi. Mengabadikan setiap momen dan merancang ide visual.','divisions/nWFhJIQR4I6uNOQIDsPyn9rg613MmCaCeWRKRUBC.jpg',6,'2026-10-21 07:06:47','2026-10-21 07:41:07'),(7,'Divisi Perkap','perkap','Pengurus Harian','Menyiapkan perlengkapan teknis, logistik, dan manajemen inventaris.','divisions/ZBwl1yT5tT33ZBXwquA9fY1oywagwYtQazBpxHOa.jpg',7,'2026-10-21 07:06:47','2026-10-21 07:42:32'),(8,'Divisi Wirausaha','wirausaha','Pengurus Harian','Mengelola usaha kreatif organisasi dan ketersediaan dana mandiri operasional.','divisions/Deau1WHAarZ88rodtTOW4RI0KEJqZLkbyOHRD3nU.jpg',8,'2026-10-21 07:06:47','2026-10-21 07:44:03');
/*!40000 ALTER TABLE `divisions` ENABLE KEYS */;
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
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `galleries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `event_date` date DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleries`
--

LOCK TABLES `galleries` WRITE;
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;
INSERT INTO `galleries` VALUES (2,'Foto Kepengurusan 2026','foto-kepengurusan-2025','Dokumentasi resmi seluruh pengurus dan anggota Smecone Music periode 2026/2027.','2025-02-18','MARA Studio','galleries/Zpw8LeJlrge6gEEJHzvOPQ0oaDSBTg2GX07izOYK.jpg','2026-09-19 05:32:20','2026-10-21 07:50:43'),(6,'Wariso at SAF 2026','wariso-at-saf-2026','Penampilan terakhir The Wariso Band pada pagelaran pentas seni SAF di SMK Negeri 1 Purwokerto.','2026-10-21','Lapangan Belakang SMK','galleries/rMy2EcRtqE62DJb6dLAdftEJVjCW2efzro04vCCE.jpg','2026-10-21 08:02:42','2026-10-21 08:02:42'),(7,'Buka Bersama Smecone Music 2026','buka-bersama-smecone-music-2026','Acara penuh berkah dengan buka bersama dengan anggota, pengurus, serta alumni Smecone Music.','2026-03-12','Kemangi Cafe & Resto','galleries/kWgvv0iaYwVuCHW9qtDozhBd5kNbapvTnkzQW01C.jpg','2026-10-21 08:09:50','2026-10-21 08:09:50'),(8,'Smecone Music Band at Demos 2026','smecone-music-band-at-demos-2026','Smecone Music Band pada acara Demonstrasi Ekstrakurikuler (Demos) 2026','2026-07-14','Lapangan Basket SMK','galleries/EfhNbuzqnHsRWJwPW6RHoLgVU7Vy3ybtrwl8p9O1.jpg','2026-10-21 09:05:18','2026-10-21 09:05:18'),(9,'Wariso at SAF 2025','wariso-at-saf-2025','Penampilan The Wariso Band pada pentas seni SAF 2025 dengan membawakan 3 lagu cover.','2025-08-21','Lapangan Belakang SMK','galleries/0I8guome2HmsJGid7W4jS1m01R91k04e7YTsw1rV.jpg','2026-10-21 09:06:45','2026-10-21 09:06:45');
/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_photos`
--

DROP TABLE IF EXISTS `gallery_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery_photos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gallery_id` bigint unsigned NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_photos_gallery_id_foreign` (`gallery_id`),
  CONSTRAINT `gallery_photos_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_photos`
--

LOCK TABLES `gallery_photos` WRITE;
/*!40000 ALTER TABLE `gallery_photos` DISABLE KEYS */;
INSERT INTO `gallery_photos` VALUES (3,2,'galleries/Zpw8LeJlrge6gEEJHzvOPQ0oaDSBTg2GX07izOYK.jpg','Foto bersama seluruh kabinet pengurus 2025/2026',1,'2026-10-19 22:38:54','2026-10-19 22:38:54'),(6,2,'galleries/lAor0oBFT6HVmki9peYrl0KpIl1ep11caxIL3ghv.jpg',NULL,2,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(7,2,'galleries/5WQS88fFXIShLK4AmxL8L4KOgrRjwdGBIFMvjtXJ.jpg',NULL,3,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(8,2,'galleries/5ewAUTbZBj6XkSLjFDyrenLNDHuRIJyhK06UaXiy.jpg',NULL,4,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(9,2,'galleries/oukTS9AJh2cxhrK2gNixNZQsQJkiAwxTtoqja8Te.jpg',NULL,5,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(10,2,'galleries/2pWnk9Yd6tGJF7vnkHeRqr7FwVdH6irQuO4e1ByB.jpg',NULL,6,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(11,2,'galleries/7MTqMjQGwtb7QbWNY4Lv4lLYqUe2hsd2QGkup2vT.jpg',NULL,7,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(12,2,'galleries/Xo94oiVMcc4a2TWmCv7RZTTalEiKcuFqDKg19lLB.jpg',NULL,8,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(13,2,'galleries/qVaSn9ukMtqJEevTPdINHqPtiD4xO9hu2Jidt8E8.jpg',NULL,9,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(14,2,'galleries/2DgF7GEfSVfkM8jgyjjcDizymqFr1FMDJNiAz5bs.jpg',NULL,10,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(15,2,'galleries/YoFtEGphdcxSNAyzrDiLRd4rVKp2laJzWKQ7qj9s.jpg',NULL,11,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(16,2,'galleries/aZPlfbjC4r29Kq927g2LgxDLpCp6iqMzcpeeOxNy.jpg',NULL,12,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(17,2,'galleries/1pPZmpsnEbtgNDD14QRaN16XxWqD57zpOSo8F5RU.jpg',NULL,13,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(18,2,'galleries/McsUOLFPLamjLa6eoKcx1K8bT9d5IqjqmV8MgBFO.jpg',NULL,14,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(19,2,'galleries/e1kCW22q9ZijQjK0ZUpihjg4ibjQD9Em76d0TS89.jpg',NULL,15,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(20,2,'galleries/BgmegGejbUwf3WVajWl8FLMGoupW09j91D4Y8CJ3.jpg',NULL,16,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(21,2,'galleries/3j92UNMx7j1zmdjLCt3mQWPZYeSBIqSrJ7ZTg5zc.jpg',NULL,17,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(22,2,'galleries/FZjpWVmtg0UdbX9yDWu0nalzkbvYZmDwR2M6Zfpj.jpg',NULL,18,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(23,2,'galleries/RuqTkaL6Jq1nnFS2zxuEajYuYy1Thpv6ueLChxHK.jpg',NULL,19,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(24,2,'galleries/K7ToV5wKIO72sRwqK4WpEO1uv0wRBJfq6HWaeRZE.jpg',NULL,20,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(25,2,'galleries/HNGvkUoImxIf6FBhUPb61gMoi9GAxVXesO6OOgCS.jpg',NULL,21,'2026-10-21 07:50:43','2026-10-21 07:50:43'),(26,6,'galleries/rMy2EcRtqE62DJb6dLAdftEJVjCW2efzro04vCCE.jpg','Foto Utama',1,'2026-10-21 08:02:42','2026-10-21 08:02:42'),(27,7,'galleries/kWgvv0iaYwVuCHW9qtDozhBd5kNbapvTnkzQW01C.jpg','Foto Utama',1,'2026-10-21 08:09:50','2026-10-21 08:09:50'),(33,6,'galleries/T8GyicI8fCpkV5hVJfJ79QQtUc55OVbAl3nDodv6.jpg',NULL,2,'2026-10-21 08:35:25','2026-10-21 08:35:25'),(34,6,'galleries/4hfVYzOiZG2Xyo2Ma0XKyIgV8WyAWYv5nHlXVDfQ.jpg',NULL,3,'2026-10-21 08:45:19','2026-10-21 08:45:19'),(35,6,'galleries/IXAW0cJGTIg8mbSnX5EGule5fSkcbuPmXP5LHpop.jpg',NULL,4,'2026-10-21 08:48:37','2026-10-21 08:48:37'),(37,8,'galleries/EfhNbuzqnHsRWJwPW6RHoLgVU7Vy3ybtrwl8p9O1.jpg','Foto Utama',1,'2026-10-21 09:05:18','2026-10-21 09:05:18'),(38,9,'galleries/0I8guome2HmsJGid7W4jS1m01R91k04e7YTsw1rV.jpg','Foto Utama',1,'2026-10-21 09:06:45','2026-10-21 09:06:45'),(39,9,'galleries/uxfjNQLzt2RTghdsXtJCsInedwKantb9ndEDe9VL.jpg',NULL,2,'2026-10-21 09:06:45','2026-10-21 09:06:45'),(40,9,'galleries/a8ZWcQ5VUwxSI2MpA7AysH5OqxuFSXneejqv3uBp.jpg',NULL,3,'2026-10-21 09:06:45','2026-10-21 09:06:45'),(41,9,'galleries/xVwlznSwCOjxJ5CT6sZIsKu2aMoHFMxgu7NVRVHK.jpg',NULL,4,'2026-10-21 09:06:45','2026-10-21 09:06:45'),(42,9,'galleries/NJQhKsfaLz4lmqkhS9g90QygCgR2iEPSXBRhPNmp.jpg',NULL,5,'2026-10-21 09:06:45','2026-10-21 09:06:45'),(43,9,'galleries/YYBLiSMsNHxaVLpXZu2Xa9AWm61v0iaCRdauslgY.jpg',NULL,6,'2026-10-21 09:07:10','2026-10-21 09:07:10');
/*!40000 ALTER TABLE `gallery_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instruments`
--

DROP TABLE IF EXISTS `instruments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `instruments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instruments`
--

LOCK TABLES `instruments` WRITE;
/*!40000 ALTER TABLE `instruments` DISABLE KEYS */;
INSERT INTO `instruments` VALUES (1,'Gitar Listrik Yamaha Pacifica (Red)','Kondisi gitar masih bisa berfungsi dengan baik.','instruments/dSZB5Q20u8WpRccwGnl3CPUJ2pq8E79hr0Pg6pN0.webp',1,1,'2026-10-14 18:07:31','2026-10-14 18:28:13'),(2,'Gitar Listrik Yamaha Pacifica (Sunburst)','Kondisi gitar masih berfungsi dengan baik.','instruments/wIrwM5Lif7TCZ49uCWlynmAtZ4C8QC3EUsN2GgQk.webp',1,1,'2026-10-14 18:08:52','2026-10-14 18:28:05'),(3,'Gitar Listrik Yamaha Pacifica (Black)','Kondisi gitar berfungsi dengan baik.','instruments/aQfGDmFbldGdJM7FFaFFVWQdcjzAK61FZDHXi7XX.jpg',1,1,'2026-10-14 18:10:44','2026-10-14 18:27:56'),(4,'Gitar Klasik Yamaha C315','Kondisi gitar pertama cukup baik, namun bagian senar dan tuner perlu diganti. \r\nKondisi gitar kedua kurang baik, bagian senar, tuner perlu diganti.','instruments/3u9mHtcyjgfptUvAd07BtdMwEvMbxOu1skAuGTsC.jpg',2,1,'2026-10-14 18:13:28','2026-10-14 18:13:28'),(5,'Drum Set','Kondisi Kurang Baik','instruments/5vkja5G2xULKE9eiU9Fpc7tTd45SyHc3axq572d8.jpg',1,1,'2026-10-14 18:24:28','2026-10-14 18:24:28'),(6,'Bass Yamaha TRBX305 5-String (White)','Kondisi bass masih sangat baik. bass mendat mendut','instruments/kmASk7UcZ9qVQvkPJzVIY4HpWdgJqMEzxzVvTLpK.jpg',1,1,'2026-10-14 18:27:42','2026-10-21 17:47:26'),(7,'Keyboard Yamaha PSR-S750','Kondisi masih baik.','instruments/NUP6vOreSlbrOQqVHFGXogSxM4nucNFPJNdBMUaP.jpg',1,1,'2026-10-14 19:10:48','2026-10-14 19:10:48');
/*!40000 ALTER TABLE `instruments` ENABLE KEYS */;
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
-- Table structure for table `member_structures`
--

DROP TABLE IF EXISTS `member_structures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `member_structures` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `division_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_structures_division_id_foreign` (`division_id`),
  CONSTRAINT `member_structures_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_structures`
--

LOCK TABLES `member_structures` WRITE;
/*!40000 ALTER TABLE `member_structures` DISABLE KEYS */;
INSERT INTO `member_structures` VALUES (2,1,'Zed Haniin Waafi El Haq','Wakil','members/mnoY5aTq9yyty2NwcoUiJja1BSlJC6lRA4MiEWNJ.jpg',20,'2026-09-19 06:19:29','2026-09-19 08:06:07'),(3,1,'Ayudia Mutiara Ramadhani','Sekretaris 1','members/JS1QZdBLfocOhoop4yPhGHzvsX1aqnd6CDZtfRVn.jpg',30,'2026-09-19 06:19:29','2026-09-19 08:28:39'),(4,1,'Najwa Azizah','Sekretaris 2','members/WtUV7yxXYnC12xUygBKzWILxUoNyZAtxLVrvBVti.jpg',31,'2026-09-19 06:19:29','2026-09-19 08:17:41'),(5,1,'Gandes Ayu Putri Irawan','Bendahara 1','members/ySZoIkuU71MRQgPEUnODk5AZxrrpcTjC9s2hkU9U.jpg',40,'2026-09-19 06:19:29','2026-09-19 08:30:22'),(6,1,'Imanuella Gizel Meily Tjoa','Bendahara 2','members/An3ESmayWZoIjyNvF2uDsMaf7mgo38XnqcEIZW30.jpg',41,'2026-09-19 06:19:29','2026-09-19 08:29:57'),(7,2,'Chelsa Aleya Namira','Humas (Koordinator)','members/8GSdXnUoJ6kdiy8scbO5xIWYTrp0VD4UHSEgX73C.jpg',50,'2026-09-19 06:19:29','2026-09-19 08:18:21'),(8,2,'Sabilla Kinan Winata','Anggota Humas','members/pmwHXATVz7EoFSWVoBWcX0QVLdEmQJx992ekpCjo.jpg',51,'2026-09-19 06:19:29','2026-09-19 08:18:51'),(9,2,'Winanti Sekarwanda','Anggota Humas','members/1Wv5X8PpMwYwNLQZYhhMWDID4WLsiwlbvRm9lemb.jpg',51,'2026-09-19 06:19:29','2026-09-19 08:17:17'),(10,3,'Hilmi Althaf Rahil Fadlillah','Alat Musik (Koordinator)','members/qH07Lh4spEWnW93alPALn6jx4mIkQCz5BUFhJogE.jpg',60,'2026-09-19 06:19:29','2026-09-19 08:30:33'),(11,3,'Fahri Azzam Mandriva','Anggota Alat Musik','members/QDPtQja9rew3QiGcOUZZE9UzpM6qkuz5S4pT6UG4.jpg',61,'2026-09-19 06:19:29','2026-09-19 08:12:23'),(12,3,'Galang Ma\'ruf Sherinian','Anggota Alat Musik','members/emUPZ92MgOYqumPKLMSL29YJ5Hol9k2wUT1CSqfW.jpg',61,'2026-09-19 06:19:29','2026-09-19 08:12:50'),(13,4,'Aznah Zaskiah Keimaswari','Vocal (Koordinator)','members/ybq1jzK4KGIazFk0hKo8k4aqirVryTlTdqIlK9Uo.jpg',70,'2026-09-19 06:19:29','2026-09-19 08:28:56'),(14,4,'Yusuf Hengki Fernando I.','Anggota Vocal','members/WtyWybQmgU1Y6FQpILl3NOMobbdOpa0Uh1UvGUuw.jpg',71,'2026-09-19 06:19:29','2026-09-19 08:19:05'),(15,4,'Florisa Sabria Zahra','Anggota Vocal','members/fvLYDd3uIZWR0NBgztpbRYRRHg7N9hS8iKqUbFve.jpg',71,'2026-09-19 06:19:29','2026-09-19 08:25:58'),(16,5,'Nadissa Syifa Ramadhani','Kegiatan (Koordinator)','members/e4x8njXsk9xd0U0p9TWDGiEdqrJTXnYeYrNUhIfp.jpg',80,'2026-09-19 06:19:29','2026-09-19 08:29:07'),(17,5,'Aziz Syarif Putra Q.','Anggota Kegiatan','members/HOv6j96B6UIg5qy4MXcYwkkhcCWJfAG6UPlXAOaQ.jpg',81,'2026-09-19 06:19:29','2026-09-19 08:31:07'),(18,5,'Dara Zerlinda Krisa N.','Anggota Kegiatan','members/jmsUuH0Lolpql4Ig0UPL2GqNFTtJ42ACq7KyRObk.jpg',81,'2026-09-19 06:19:29','2026-09-19 08:19:41'),(19,6,'Shelly Oktaviani','PDD (Koordinator)','members/ULl2f2cMAOuOWpalHiFqQHApKWliXgFtnaVuavQw.jpg',90,'2026-09-19 06:19:29','2026-09-19 08:20:19'),(20,6,'Fidella Kalya Nanda','Anggota PDD','members/MPHmZUeseMiUZtoZVvFdfNwbvl3QU2qa4RInCQEZ.jpg',91,'2026-09-19 06:19:29','2026-09-19 08:20:39'),(21,6,'Fadila Ristianingsih','Anggota PDD','members/M4Cu15xyfdxQkA70qSqa3O49cH4xVvmE24eiERjr.jpg',91,'2026-09-19 06:19:29','2026-09-19 08:26:19'),(22,7,'Ahmad Syihabullail Fakhrullah','Perkap (Koordinator)','members/XkIZoKQ7Qgwu7cPBPTXOtvcWVgVLJhKxsvFZ1QME.jpg',100,'2026-09-19 06:19:29','2026-09-19 08:29:47'),(23,7,'Inez Titis Anarizka','Anggota Perkap','members/zqDRPjJvzq5aGoAb0Te5eQVM8F7wC3fVd7lYhnWl.jpg',101,'2026-09-19 06:19:29','2026-09-19 08:22:03'),(24,7,'Hosea Erdivn Nainggolan','Anggota Perkap','members/m71mbH6BXP8znfhq342yDNSNxeXC1Quxgz2etoU7.jpg',101,'2026-09-19 06:19:29','2026-09-19 08:22:32'),(25,8,'Virzza Ditry Amarta','Wirausaha (Koordinator)','members/IkwCndZyjxjNdf0rQa4LFaUchWZyemzGVrTMDP4t.jpg',110,'2026-09-19 06:19:29','2026-09-19 08:22:57'),(26,8,'Benita Aprilia Sugiarto','Anggota Wirausaha','members/frxlsj750NvWik4EzizeceMpdcGtmnEHnrZ5Oz5A.jpg',111,'2026-09-19 06:19:29','2026-09-19 08:23:35'),(27,8,'Rafeifa Assyla Siti F.','Anggota Wirausaha','members/rm6feSbVQVrZwSxaAxlXzPOGDaOwtvCiYWu8DHMv.jpg',111,'2026-09-19 06:19:29','2026-09-19 08:23:55'),(28,1,'Sheren Olivia Kembaren','Ketua','members/IdcqJWCGYtFGb2S6Nhy9OTRcdV2kKejlATDPLAib.jpg',10,'2026-09-19 07:38:38','2026-09-19 07:38:38');
/*!40000 ALTER TABLE `member_structures` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_09_19_005859_create_instruments_table',1),(5,'2026_09_19_005900_create_borrowings_table',1),(6,'2026_09_19_005901_create_studio_bookings_table',1),(7,'2026_09_19_005902_create_galleries_table',1),(8,'2026_09_19_005903_create_showcases_table',1),(9,'2026_09_19_005904_create_member_structures_table',1),(10,'2026_10_20_000001_upgrade_galleries_and_create_gallery_photos_table',2),(11,'2026_10_21_000002_create_divisions_table_and_update_member_structures',3),(12,'2026_10_22_000001_create_roles_and_permissions_system',4),(13,'2026_10_22_000002_add_otp_to_users_and_letter_to_studio_bookings',5),(14,'2026_10_22_000003_add_profile_fields_to_users_table',6);
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
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'view_users','Lihat Daftar User','Akun User','Melihat daftar pengguna terdaftar','2026-10-21 19:14:01','2026-10-21 19:14:01'),(2,'approve_users','Setujui / Nonaktifkan User','Akun User','Menyetujui pendaftaran atau menonaktifkan akun','2026-10-21 19:14:01','2026-10-21 19:14:01'),(3,'edit_users','Ubah Role User','Akun User','Mengubah hak akses/role pengguna','2026-10-21 19:14:01','2026-10-21 19:14:01'),(4,'delete_users','Hapus User','Akun User','Menghapus akun pengguna dari sistem','2026-10-21 19:14:01','2026-10-21 19:14:01'),(5,'view_members','Lihat Struktur Pengurus','Kepengurusan','Melihat bagan dan daftar anggota pengurus','2026-10-21 19:14:01','2026-10-21 19:14:01'),(6,'create_members','Tambah Anggota Pengurus','Kepengurusan','Menambahkan data anggota pengurus baru','2026-10-21 19:14:01','2026-10-21 19:14:01'),(7,'edit_members','Edit Anggota & Divisi','Kepengurusan','Mengubah foto, deskripsi divisi, dan data pengurus','2026-10-21 19:14:01','2026-10-21 19:14:01'),(8,'delete_members','Hapus Anggota Pengurus','Kepengurusan','Menghapus anggota dari struktur kepengurusan','2026-10-21 19:14:01','2026-10-21 19:14:01'),(9,'view_instruments','Lihat Inventaris Alat','Inventaris Alat','Melihat katalog dan daftar inventaris alat musik','2026-10-21 19:14:01','2026-10-21 19:14:01'),(10,'create_instruments','Tambah Alat Musik','Inventaris Alat','Menambahkan alat musik baru ke inventaris','2026-10-21 19:14:01','2026-10-21 19:14:01'),(11,'edit_instruments','Edit Alat Musik','Inventaris Alat','Mengubah info, jumlah, atau foto alat musik','2026-10-21 19:14:01','2026-10-21 19:14:01'),(12,'delete_instruments','Hapus Alat Musik','Inventaris Alat','Menghapus alat musik dari inventaris','2026-10-21 19:14:01','2026-10-21 19:14:01'),(13,'view_borrowings','Lihat Peminjaman Alat','Peminjaman Alat','Melihat daftar permohonan peminjaman alat','2026-10-21 19:14:01','2026-10-21 19:14:01'),(14,'approve_borrowings','Approval Peminjaman Alat','Peminjaman Alat','Menyetujui, menolak, atau menandai alat telah dikembalikan','2026-10-21 19:14:01','2026-10-21 19:14:01'),(15,'view_bookings','Lihat Booking Studio','Booking Studio','Melihat jadwal dan pengajuan booking studio STM','2026-10-21 19:14:01','2026-10-21 19:14:01'),(16,'approve_bookings','Approval Booking Studio','Booking Studio','Menyetujui atau menolak permohonan booking studio','2026-10-21 19:14:01','2026-10-21 19:14:01'),(17,'view_galleries','Lihat Galeri Foto','Galeri Foto','Melihat album dan foto dokumentasi kegiatan','2026-10-21 19:14:01','2026-10-21 19:14:01'),(18,'create_galleries','Tambah Album Galeri','Galeri Foto','Membuat event galeri baru & upload foto','2026-10-21 19:14:01','2026-10-21 19:14:01'),(19,'edit_galleries','Edit Album & Foto Galeri','Galeri Foto','Mengubah informasi galeri dan menambah/menghapus foto','2026-10-21 19:14:01','2026-10-21 19:14:01'),(20,'delete_galleries','Hapus Album Galeri','Galeri Foto','Menghapus album kegiatan galeri','2026-10-21 19:14:01','2026-10-21 19:14:01'),(21,'view_showcases','Lihat Showcase Prestasi','Showcase Prestasi','Melihat daftar prestasi dan penghargaan','2026-10-21 19:14:01','2026-10-21 19:14:01'),(22,'create_showcases','Tambah Prestasi','Showcase Prestasi','Menambahkan portofolio atau prestasi baru','2026-10-21 19:14:01','2026-10-21 19:14:01'),(23,'delete_showcases','Hapus Prestasi','Showcase Prestasi','Menghapus data prestasi','2026-10-21 19:14:01','2026-10-21 19:14:01'),(24,'manage_roles','Kelola Hak Akses Role','Manajemen Role','Mengatur dan mengubah hak akses setiap role pengurus','2026-10-21 19:14:01','2026-10-21 19:14:01');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_permissions` (
  `role_id` bigint unsigned NOT NULL,
  `permission_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `role_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_permissions`
--

LOCK TABLES `role_permissions` WRITE;
/*!40000 ALTER TABLE `role_permissions` DISABLE KEYS */;
INSERT INTO `role_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(1,2),(2,2),(3,2),(4,2),(1,3),(2,3),(3,3),(4,3),(1,4),(2,4),(1,5),(2,5),(3,5),(4,5),(5,5),(6,5),(7,5),(8,5),(1,6),(2,6),(3,6),(4,6),(6,6),(1,7),(2,7),(3,7),(4,7),(6,7),(1,8),(2,8),(3,8),(4,8),(6,8),(1,9),(2,9),(3,9),(4,9),(5,9),(6,9),(7,9),(8,9),(1,10),(2,10),(5,10),(7,10),(1,11),(2,11),(5,11),(7,11),(1,12),(2,12),(5,12),(7,12),(1,13),(2,13),(3,13),(4,13),(5,13),(6,13),(7,13),(8,13),(1,14),(2,14),(3,14),(4,14),(5,14),(1,15),(2,15),(3,15),(4,15),(5,15),(6,15),(7,15),(8,15),(1,16),(2,16),(3,16),(4,16),(5,16),(1,17),(2,17),(3,17),(4,17),(5,17),(6,17),(7,17),(8,17),(1,18),(2,18),(6,18),(1,19),(2,19),(6,19),(1,20),(2,20),(6,20),(1,21),(2,21),(3,21),(4,21),(5,21),(6,21),(7,21),(8,21),(1,22),(2,22),(6,22),(1,23),(2,23),(6,23),(1,24),(2,24);
/*!40000 ALTER TABLE `role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pengurus Divisi',
  `badge_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'brand',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Ketua','ketua','Pengurus Inti','amber','Ketua Umum Smecone Music. Memiliki hak akses penuh ke seluruh fitur dan pengaturan hak akses role.','2026-10-21 19:14:00','2026-10-21 19:14:00'),(2,'Wakil Ketua','wakil','Pengurus Inti','amber','Wakil Ketua Smecone Music. Memiliki hak akses penuh ke seluruh fitur dan pengaturan hak akses role.','2026-10-21 19:14:00','2026-10-21 19:14:00'),(3,'Sekretaris','sekretaris','Pengurus Inti','indigo','Pengurus Inti. Dapat mengelola akun user, struktur kepengurusan, dan persetujuan peminjaman/booking.','2026-10-21 19:14:00','2026-10-21 19:14:00'),(4,'Bendahara','bendahara','Pengurus Inti','indigo','Pengurus Inti. Dapat mengelola akun user, struktur kepengurusan, dan persetujuan peminjaman/booking.','2026-10-21 19:14:00','2026-10-21 19:14:00'),(5,'Pengurus (Perkap)','pengurus_perkap','Pengurus Divisi','blue','Divisi Perlengkapan. Dapat menambah/mengedit inventaris alat musik & menyetujui peminjaman alat serta booking studio.','2026-10-21 19:14:00','2026-10-21 19:14:00'),(6,'Pengurus (PDD)','pengurus_pdd','Pengurus Divisi','purple','Divisi Publikasi, Desain & Dokumentasi. Dapat mengelola kepengurusan, galeri foto, dan showcase prestasi.','2026-10-21 19:14:00','2026-10-21 19:14:00'),(7,'Pengurus (Alat Musik)','pengurus_alat_musik','Pengurus Divisi','emerald','Divisi Alat Musik. Dapat mengelola dan memelihara data inventaris alat musik.','2026-10-21 19:14:00','2026-10-21 19:14:00'),(8,'Pengurus (Divisi Lain)','pengurus','Pengurus Divisi','slate','Pengurus Divisi Lainnya (Humas, Vocal, Kegiatan, Wirausaha). Memiliki akses melihat seluruh data di panel admin (View-Only).','2026-10-21 19:14:01','2026-10-21 19:14:01'),(9,'Anggota (User)','user','Anggota','slate','Anggota Biasa Smecone Music. Mengakses panel anggota untuk peminjaman alat dan booking studio.','2026-10-21 19:14:01','2026-10-21 19:14:01');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('5hERgwU9WazpSOBQnrpekyK7bxhTtq4SWmfisM6q',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.22621.6133','eyJfdG9rZW4iOiJFczN3SlpNT2UwS0QwOEJ3MngxUkJpR2xBajFCUnFmZ25MTnpnek16IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1792673129),('gNdtOQD8crzZHR0X7u2zrchwaKkp8BmAu1PFZmeM',7,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJQVUdBbEswN2ZyY1N3OE5ZNlR3cDU2VWFPWHNyQWt4dGVXN0lNdGZCIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9kYXNoYm9hcmRcL2luc3RydW1lbnRzIiwicm91dGUiOiJ1c2VyLmluc3RydW1lbnRzLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjd9',1792677380),('J5CqLVZ07gqRUjaFUN0d3aqPdYZ5E4jmkPvBrLDi',5,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJlc3RFV0FsdXZkZDlQZHlZd3hmdnRabk5tS29lYWdrWnpTM3Q2SHJDIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC91c2VycyIsInJvdXRlIjoiYWRtaW4udXNlcnMuaW5kZXgifSwicmVzZXRfZW1haWwiOiJ6ZWRoYW5paW5AZ21haWwuY29tIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjV9',1792677386),('lPPQk9ZTXIPZmQGJZmYQA2gUTztQnyYVfjKxf0YW',NULL,'127.0.0.1','curl/8.13.0','eyJfdG9rZW4iOiJJSWhENlZvdHA1MnNpZ2NvdktzaDVzeHVjWHJmczM3TkM2WXJXcWpFIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792673200);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `showcases`
--

DROP TABLE IF EXISTS `showcases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `showcases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `embed_type` enum('youtube','instagram') COLLATE utf8mb4_unicode_ci NOT NULL,
  `embed_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `showcases`
--

LOCK TABLES `showcases` WRITE;
/*!40000 ALTER TABLE `showcases` DISABLE KEYS */;
INSERT INTO `showcases` VALUES (1,'SMKN 1 Purwokerto|FLS3N 2025 - Percakapan Rindu',NULL,'youtube','https://youtu.be/9P2EwJjvNzk?si=YR0RKR-GbZVWsSca','2026-09-18 18:28:22','2026-09-18 18:28:22'),(2,'Sheren Olivia Kembaren - Juara 2 FLS3N Cipta Lagu Tingkat Provinsi Jawa Tengah 2026',NULL,'instagram','https://www.instagram.com/p/DbVBF0TBBxQ/?utm_source=ig_web_copy_link&stkn=MzRlODBiNWFlZA==','2026-09-18 18:33:22','2026-09-18 18:33:22');
/*!40000 ALTER TABLE `showcases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studio_bookings`
--

DROP TABLE IF EXISTS `studio_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `studio_bookings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `purpose` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_letter_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `studio_bookings_user_id_foreign` (`user_id`),
  CONSTRAINT `studio_bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studio_bookings`
--

LOCK TABLES `studio_bookings` WRITE;
/*!40000 ALTER TABLE `studio_bookings` DISABLE KEYS */;
/*!40000 ALTER TABLE `studio_bookings` ENABLE KEYS */;
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
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instrument_division` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `management_division` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_code` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (5,'Zed Haniin Waafi El Haq','zedhaniin@gmail.com','0895385054592','XII PPLG 2','Divisi Alat Musik','Pengurus Inti','2026-10-21 23:10:03','$2y$12$cm0rnEnKMnFZSYNapakExOajn2zS/5eZIT63K/Dxtz9q4qMId5k3O','wakil',1,NULL,NULL,NULL,'2026-10-21 23:09:24','2026-10-22 06:25:53'),(6,'Ahmad Syihabullail Fakhrullah','fakhrulkunn@gmail.com',NULL,NULL,NULL,NULL,'2026-10-21 23:33:39','$2y$12$dRH71UfCyfHUCO2Jiq.qbOtiqCGmJ09TVHbIj3Rgj2jK1hO4owgdC','pengurus_perkap',1,NULL,NULL,NULL,'2026-10-21 23:31:14','2026-10-21 23:35:26'),(7,'Haniin (Dummy User)','zedhaniin23@gmail.com',NULL,'X PPLG 2','Divisi Alat Musik',NULL,'2026-10-22 06:55:50','$2y$12$eHmQJIOkgT.FM765y13rhOkO8nOn9YJYEgwbTn8dRuLDJrcUZHbPa','user',1,NULL,NULL,NULL,'2026-10-22 06:52:41','2026-10-22 06:56:20');
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

-- Dump completed on 2026-10-22 21:00:27
