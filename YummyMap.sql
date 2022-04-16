-- MariaDB dump 10.19  Distrib 10.4.21-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: yummymap
-- ------------------------------------------------------
-- Server version	10.4.21-MariaDB

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
-- Table structure for table `backup`
--

DROP TABLE IF EXISTS `backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup` (
  `file` char(10) DEFAULT NULL,
  `form` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup`
--

LOCK TABLES `backup` WRITE;
/*!40000 ALTER TABLE `backup` DISABLE KEYS */;
INSERT INTO `backup` VALUES ('2020.06.04','Manual'),('2020.06.03','Manual'),('2020.06.05','Manual'),('2020.06.10','Manual');
/*!40000 ALTER TABLE `backup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `storeaccount`
--

DROP TABLE IF EXISTS `storeaccount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `storeaccount` (
  `account` char(10) DEFAULT NULL,
  `password` char(53) DEFAULT NULL,
  `storeIDs` char(40) DEFAULT NULL,
  `banned` int(1) DEFAULT NULL,
  `lastLogin` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `storeaccount`
--

LOCK TABLES `storeaccount` WRITE;
/*!40000 ALTER TABLE `storeaccount` DISABLE KEYS */;
INSERT INTO `storeaccount` VALUES ('manager','221e747d3c7fbe301f8a2um.XW2PO1Kkr8GUdcbjiMCDAPInHDap.','0',0,'2022/04/16'),('Store02','54e1bd05b507a2e750112OrH2CfClu0RxqX5B9RmGIg4DGviY63k6','3@4',0,'2022/04/16'),('Store','a596ebb2dd34c9659fbb3O4oXw/w5ejKM6eIfFK9jYA.1hw95/.xO','1@2',0,'2022/04/16'),('store03','7c78b87c7a87a1a25938au9PaRpIcOXUGlOkIZ6QXqbBqg/9smWCu','5',NULL,'2020/06/1');
/*!40000 ALTER TABLE `storeaccount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `storeinfo`
--

DROP TABLE IF EXISTS `storeinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `storeinfo` (
  `name` char(20) DEFAULT NULL,
  `introduce` char(200) DEFAULT NULL,
  `id` int(3) DEFAULT NULL,
  `position` char(6) DEFAULT NULL,
  `menu` char(250) DEFAULT NULL,
  `hours` char(63) DEFAULT NULL,
  `lastModified` char(10) DEFAULT NULL,
  `Logo` char(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `storeinfo`
--

LOCK TABLES `storeinfo` WRITE;
/*!40000 ALTER TABLE `storeinfo` DISABLE KEYS */;
INSERT INTO `storeinfo` VALUES ('阿灶伯當歸羊肉','當歸羊肉湯($70)是以生羊肉片直接川燙後，再放入當歸湯頭中，跟一般羊肉爐使用肉塊熬煮方式不同。',1,'037062','當歸羊肉湯-70@臭豆腐-40@乾麵線-40@魯肉飯-25','16000100@16000100@00000000@16000100@16000100@16000100@16000100','2020/06/2','1.png'),('東山鴨頭','基本上這家的口味偏甜，味道算有滷進食材裡，大腸頭外酥內嫩，再配上三星蔥的清香，十分對味；而鴨腳骨還是第一次吃到，喜歡啃骨頭的朋友應該會很愛。',3,'042062',NULL,'00000000@00000000@00000000@00000000@00000000@00000000@00000000',NULL,NULL),('嚐味鮮湯包','店家標榜不添加修飾澱粉、吉利丁等化學品，以真材實料的麵皮、溫體豬後腿瘦肉等新鮮食材應戰，共八種口味只要60元起、現點現蒸。',2,'075042',NULL,'00000000@00000000@00000000@00000000@00000000@00000000@00000000',NULL,NULL),('台灣沙茶','台灣黃牛肉的油花不多，但吃起來算是有彈性不會\"潤潤\"(台語)的，搭著獨門沙茶醬吃，挺不賴的。',4,'068075',NULL,'00000000@00000000@00000000@00000000@00000000@00000000@00000000',NULL,NULL),('臭臭鍋','香噴噴',5,'050050','臭臭鍋-120','00000000@00000000@00000000@00000000@00000000@00000000@00000000','2020/06/1','');
/*!40000 ALTER TABLE `storeinfo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-16 21:56:33
