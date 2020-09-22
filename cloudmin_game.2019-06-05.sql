
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
DROP TABLE IF EXISTS `animal_food`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `animal_food` (
  `animal_food_id` int(11) NOT NULL AUTO_INCREMENT,
  `plant_id` int(11) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `price_to_buy` decimal(10,2) DEFAULT NULL,
  `min_count` int(11) DEFAULT NULL,
  `energy` int(11) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  PRIMARY KEY (`animal_food_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Таблица корма животных';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `animal_pens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `animal_pens` (
  `animal_pens_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `price_to_buy` decimal(10,2) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  `energy` int(11) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  PRIMARY KEY (`animal_pens_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Таблица загонов животных';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `animals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `animals` (
  `animal_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `img1` varchar(255) DEFAULT NULL,
  `img2` varchar(255) DEFAULT NULL,
  `img3` varchar(255) DEFAULT NULL,
  `img4` varchar(255) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  `price_to_buy` decimal(10,2) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `energy` int(11) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  PRIMARY KEY (`animal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Таблица животных';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `auth_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Таблица авторизируемых пользователей с паролем без шифрования';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bakeries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bakeries` (
  `bakery_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `price_to_buy` decimal(10,2) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  `energy` int(11) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  PRIMARY KEY (`bakery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Таблица пекарний';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bonus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bonus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bonus_buy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bonus_buy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `summ` decimal(10,2) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bonus_total`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bonus_total` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bull_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bull_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `paddock_id` int(11) DEFAULT NULL,
  `status_id` smallint(6) NOT NULL DEFAULT '0',
  `user_id` smallint(6) NOT NULL DEFAULT '0',
  `position` smallint(6) NOT NULL DEFAULT '0',
  `time_start` int(11) NOT NULL DEFAULT '0',
  `time_finish` int(11) NOT NULL DEFAULT '0',
  `count_meat` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`),
  KEY `idx_bull_items_user_id` (`user_id`),
  KEY `idx_bull_items_status_id` (`status_id`),
  KEY `idx_bull_items_paddock_id` (`paddock_id`),
  KEY `idx_bull_items_time_fin` (`time_finish`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Таблица бычков';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `charity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `charity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `text` text,
  `need` varchar(255) DEFAULT NULL,
  `content` text,
  `img` varchar(255) DEFAULT NULL,
  `summ` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `charity_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `charity_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `charity_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `summ` decimal(10,2) NOT NULL DEFAULT '0.00',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `is_blocked` int(11) DEFAULT NULL,
  `text` text,
  `created_at` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_chat_username` (`username`),
  KEY `idx_chat_user_id` (`user_id`),
  KEY `idx_chat_created` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cheese_bakery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cheese_bakery` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `time_start` int(11) NOT NULL DEFAULT '0',
  `time_finish` int(11) NOT NULL DEFAULT '0',
  `count_product` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Таблица пекарни пирог с сыром';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `chicken_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chicken_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `paddock_id` int(11) DEFAULT NULL,
  `status_id` smallint(6) NOT NULL DEFAULT '0',
  `user_id` smallint(6) NOT NULL DEFAULT '0',
  `position` smallint(6) NOT NULL DEFAULT '0',
  `time_start` int(11) NOT NULL DEFAULT '0',
  `time_finish` int(11) NOT NULL DEFAULT '0',
  `count_eggs` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`),
  KEY `idx_c_items_user_id` (`user_id`),
  KEY `idx_c_items_padd_id` (`paddock_id`),
  KEY `idx_c_items_time_fin` (`time_finish`),
  KEY `idx_c_items_status_id` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Таблица кур';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cow_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cow_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `paddock_id` int(11) DEFAULT NULL,
  `status_id` smallint(6) NOT NULL DEFAULT '0',
  `user_id` smallint(6) NOT NULL DEFAULT '0',
  `position` smallint(6) NOT NULL DEFAULT '0',
  `time_start` int(11) NOT NULL DEFAULT '0',
  `time_finish` int(11) NOT NULL DEFAULT '0',
  `count_milk` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`),
  KEY `idx_cow_items_user_id` (`user_id`),
  KEY `idx_cow_items_paddock_id` (`paddock_id`),
  KEY `idx_cow_items_status_id` (`status_id`),
  KEY `idx_cow_items_time_fin` (`time_finish`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Таблица коров';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `curd_bakery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `curd_bakery` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `time_start` int(11) NOT NULL DEFAULT '0',
  `time_finish` int(11) NOT NULL DEFAULT '0',
  `count_product` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Таблица пекарни пирог с творогом';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `exchange`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exchange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(100) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `energy` int(11) NOT NULL DEFAULT '0',
  `experience` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `exchange_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exchange_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `fabric_product_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fabric_product_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `alias2` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `price_to_buy` decimal(10,2) DEFAULT NULL,
  `price_for_sell` decimal(10,2) DEFAULT NULL,
  `min_count` smallint(6) DEFAULT NULL,
  `min_count_for_sell` smallint(6) DEFAULT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  `energy` int(11) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Таблица собираемых продуктов';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `factories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factories` (
  `factory_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `price_to_buy` decimal(10,2) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  `energy` int(11) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  PRIMARY KEY (`factory_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Таблица фабрик';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `factory_cheese`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factory_cheese` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `time_start` int(11) NOT NULL DEFAULT '0',
  `time_finish` int(11) NOT NULL DEFAULT '0',
  `count_product` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='Таблица фабрики сыра';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `factory_curd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factory_curd` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `time_start` int(11) NOT NULL DEFAULT '0',
  `time_finish` int(11) NOT NULL DEFAULT '0',
  `count_product` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='Таблица фабрики творога';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `factory_dough`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factory_dough` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `time_start` int(11) NOT NULL DEFAULT '0',
  `time_finish` int(11) NOT NULL DEFAULT '0',
  `count_product` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='Таблица фабрики теста';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `factory_mince`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factory_mince` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `time_start` int(11) NOT NULL DEFAULT '0',
  `time_finish` int(11) NOT NULL DEFAULT '0',
  `count_product` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='Таблица фабрики фарша';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `farm_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `farm_storage` (
  `storage_id` int(11) NOT NULL AUTO_INCREMENT,
  `feed_chickens` int(11) NOT NULL DEFAULT '0',
  `feed_bulls` int(11) NOT NULL DEFAULT '0',
  `feed_goats` int(11) NOT NULL DEFAULT '0',
  `feed_cows` int(11) NOT NULL DEFAULT '0',
  `egg` int(11) NOT NULL DEFAULT '0',
  `meat` int(11) NOT NULL DEFAULT '0',
  `goat_milk` int(11) NOT NULL DEFAULT '0',
  `cow_milk` int(11) NOT NULL DEFAULT '0',
  `dough` int(11) NOT NULL DEFAULT '0',
  `mince` int(11) NOT NULL DEFAULT '0',
  `cheese` int(11) NOT NULL DEFAULT '0',
  `curd` int(11) NOT NULL DEFAULT '0',
  `money_storage` decimal(16,2) NOT NULL DEFAULT '0.00',
  `money_for_out` decimal(16,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`storage_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Таблица резерв ярмарки';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `friend_gifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friend_gifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to` varchar(255) DEFAULT NULL,
  `from` varchar(255) DEFAULT NULL,
  `gifts_id` int(11) DEFAULT NULL,
  `comment` text,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to` int(11) NOT NULL,
  `from` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `friends` (`to`),
  CONSTRAINT `friends` FOREIGN KEY (`to`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `gifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `goat_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goat_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `paddock_id` int(11) DEFAULT NULL,
  `status_id` smallint(6) NOT NULL DEFAULT '0',
  `user_id` smallint(6) NOT NULL DEFAULT '0',
  `position` smallint(6) NOT NULL DEFAULT '0',
  `time_start` int(11) NOT NULL DEFAULT '0',
  `time_finish` int(11) NOT NULL DEFAULT '0',
  `count_milk` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`),
  KEY `idx_goat_items_paddock_id` (`paddock_id`),
  KEY `idx_goat_items_status_id` (`status_id`),
  KEY `idx_goat_items_user_id` (`user_id`),
  KEY `idx_goat_items_time_fin` (`time_finish`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `instructions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instructions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `weight` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `land_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `land_items` (
  `land_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `position_number` int(11) DEFAULT NULL,
  `plant_alias` varchar(255) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `is_fertilized` tinyint(1) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `time_start` int(11) NOT NULL DEFAULT '0',
  `time_finish` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`land_item_id`),
  KEY `idx_l_items_user_id` (`user_id`),
  KEY `idx_l_items_plant_alias` (`plant_alias`),
  KEY `idx_l_items_status_id` (`status_id`),
  KEY `idx_l_items_is_fer` (`is_fertilized`),
  KEY `idx_l_items_time_f` (`time_finish`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `like`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `wall_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `login_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `login_ip` varchar(20) NOT NULL DEFAULT '0',
  `login_date` int(11) NOT NULL DEFAULT '0',
  `browser` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `mails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mails` (
  `mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) DEFAULT NULL,
  `from` varchar(255) DEFAULT NULL,
  `to` varchar(255) DEFAULT NULL,
  `message` text,
  `status` tinyint(1) DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`mail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `is_enabled` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `meat_bakery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meat_bakery` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `time_start` int(11) NOT NULL DEFAULT '0',
  `time_finish` int(11) NOT NULL DEFAULT '0',
  `count_product` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Таблица пекарни пирог с мясом';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) DEFAULT NULL,
  `to_id` int(11) DEFAULT NULL,
  `message` text,
  `viewed` tinyint(1) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `my_purchase_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `my_purchase_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `alias` varchar(20) NOT NULL DEFAULT '0',
  `count_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `count_product` int(11) NOT NULL DEFAULT '0',
  `comment` varchar(120) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_m_purchase_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='Таблица моей истории';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `teaser` text,
  `content` text,
  `weight` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `news_like_count` int(11) NOT NULL DEFAULT '0',
  `news_dislike_count` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `news_comment_like`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_comment_like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `news_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `news_id` int(11) DEFAULT NULL,
  `text` text,
  `like_count` int(11) NOT NULL DEFAULT '0',
  `dislike_count` int(11) NOT NULL DEFAULT '0',
  `date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_news_comm_user_id` (`user_id`),
  KEY `idx_news_comments_news_id` (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `news_like`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `paddock_bull_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paddock_bull_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`),
  KEY `idx_p_bull_items_status_id` (`status_id`),
  KEY `idx_p_bull_items_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Таблица загон бычков';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `paddock_chicken_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paddock_chicken_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '0',
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  KEY `idx_p_ch_items_status_id` (`status_id`),
  KEY `idx_p_ch_items_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Таблица загон кур';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `paddock_cow_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paddock_cow_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`),
  KEY `idx_p_cow_items_status_id` (`status_id`),
  KEY `idx_p_cow_items_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Таблица загон коров';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `paddock_goat_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paddock_goat_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`),
  KEY `idx_p_goat_items_status_id` (`status_id`),
  KEY `idx_p_goat_items_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Таблица загон коз';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pay_in`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pay_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `purse` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `m_sign` varchar(255) DEFAULT NULL,
  `fraud_count` int(11) DEFAULT NULL,
  `complete` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pay_out`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pay_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pay_type` varchar(255) DEFAULT NULL,
  `purse` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `plant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plant` (
  `plant_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `second_name` varchar(255) DEFAULT NULL,
  `img1` varchar(255) DEFAULT NULL,
  `img2` varchar(255) DEFAULT NULL,
  `img3` varchar(255) DEFAULT NULL,
  `img4` varchar(255) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  `price_to_buy` decimal(10,2) DEFAULT NULL,
  `price_for_sell` decimal(10,3) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `energy` int(11) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`plant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `product_for_bakery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_for_bakery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `alias2` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `price_to_buy` decimal(10,2) DEFAULT NULL,
  `price_for_sell` decimal(10,2) DEFAULT NULL,
  `min_count` smallint(6) DEFAULT NULL,
  `min_count_for_sell` smallint(6) DEFAULT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  `energy` int(11) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Таблица продуктов с/для фабрик/пекарний';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `purchase_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL DEFAULT '0',
  `alias` varchar(20) NOT NULL DEFAULT '0',
  `count_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `count_product` int(11) NOT NULL DEFAULT '0',
  `comment` varchar(120) NOT NULL DEFAULT '0',
  `time_buy` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='Таблица истории моего реферала';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `date` int(11) NOT NULL,
  `is_active` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sale_queue_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sale_queue_list` (
  `queue_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `sell_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`queue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица очереди пирогов на продажу';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `shop_bakery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_bakery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `alias2` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `price_for_sell` decimal(10,2) DEFAULT NULL,
  `price_to_buy` decimal(10,2) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  `min_count_for_sell` smallint(6) DEFAULT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  `energy` int(11) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `energy_in_food` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Таблица пирогов';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `min_paid` decimal(10,0) DEFAULT NULL,
  `ref_percent` int(11) DEFAULT NULL,
  `start_project` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `today_bought_feed_chickens` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_sold_feed_chickens` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_feed_chickens` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_sold_feed_chickens` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_feed_bulls` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_sold_feed_bulls` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_feed_bulls` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_sold_feed_bulls` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_feed_goats` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_sold_feed_goats` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_feed_goats` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_sold_feed_goats` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_feed_cows` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_sold_feed_cows` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_feed_cows` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_sold_feed_cows` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_eggs` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_sold_eggs` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_eggs` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_sold_eggs` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_meat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_sold_meat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_meat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_sold_meat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_goat_milk` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_sold_goat_milk` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_goat_milk` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_sold_goat_milk` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_cow_milk` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_sold_cow_milk` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_cow_milk` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_sold_cow_milk` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_dough` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_sold_dough` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_dough` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_sold_dough` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_mince` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_sold_mince` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_mince` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_sold_mince` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_cheese` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_sold_cheese` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_cheese` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_sold_cheese` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_curd` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_sold_curd` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_curd` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_sold_curd` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_chickens` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_chickens` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_bulls` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_bulls` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_goats` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_goats` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_cows` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_cows` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_paddock_chickens` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_paddock_chickens` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_paddock_bulls` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_paddock_bulls` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_paddock_goats` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_paddock_goats` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_paddock_cows` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_paddock_cows` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_factory_dough` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_factory_dough` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_factory_mince` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_factory_mince` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_factory_cheese` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_factory_cheese` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_factory_curd` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_factory_curd` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_meat_bakery` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_meat_bakery` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_cheese_bakery` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_cheese_bakery` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today_bought_curd_bakery` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_curd_bakery` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `all_bought_lands` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `support`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from` int(11) DEFAULT NULL,
  `to` int(11) DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci,
  `date` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `user_viewed` tinyint(1) DEFAULT NULL,
  `reply` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `transfer_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transfer_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `username` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `role` int(11) DEFAULT '3',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `sex` tinyint(1) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `about` text,
  `photo` varchar(255) NOT NULL DEFAULT 'ava.png',
  `level` int(11) NOT NULL DEFAULT '1',
  `for_pay` decimal(10,2) NOT NULL DEFAULT '0.00',
  `for_out` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pay_pass` int(11) NOT NULL DEFAULT '0',
  `experience` int(11) NOT NULL DEFAULT '0',
  `energy` int(11) NOT NULL DEFAULT '0',
  `phone` varchar(255) DEFAULT NULL,
  `chat_status` int(11) DEFAULT '1',
  `chat_music` tinyint(1) DEFAULT '1',
  `ref_id` int(11) NOT NULL DEFAULT '0',
  `ref_for_out` decimal(10,2) NOT NULL DEFAULT '0.00',
  `refLink` varchar(255) DEFAULT NULL,
  `is_subscribed` tinyint(1) DEFAULT '0',
  `banned` tinyint(1) DEFAULT '0',
  `banned_text` text,
  `need_experience` int(11) DEFAULT NULL,
  `signup_date` int(11) DEFAULT NULL,
  `login_date` int(11) DEFAULT NULL,
  `signup_ip` varchar(255) DEFAULT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `first_login` tinyint(1) DEFAULT '1',
  `outed` decimal(10,2) NOT NULL DEFAULT '0.00',
  `location` varchar(255) DEFAULT NULL,
  `last_visited` int(11) DEFAULT NULL,
  `pay_pass_date` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  KEY `idx_user_username` (`username`),
  KEY `idx_user_email` (`email`),
  KEY `idx_user_role` (`role`),
  KEY `idx_user_level` (`level`),
  KEY `idx_user_for_pay` (`for_pay`),
  KEY `idx_user_for_out` (`for_out`),
  KEY `idx_user_energy` (`energy`),
  KEY `idx_user_ref_id` (`ref_id`),
  KEY `idx_user_need_exp` (`need_experience`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 COMMENT='Таблица пользователей';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_storage` (
  `user_storage_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `wheat` int(11) NOT NULL DEFAULT '0',
  `clover` int(11) NOT NULL DEFAULT '0',
  `cabbage` int(11) NOT NULL DEFAULT '0',
  `beets` int(11) NOT NULL DEFAULT '0',
  `chicken` int(11) NOT NULL DEFAULT '0',
  `bull` int(11) NOT NULL DEFAULT '0',
  `goat` int(11) NOT NULL DEFAULT '0',
  `cow` int(11) NOT NULL DEFAULT '0',
  `feed_chickens` int(11) NOT NULL DEFAULT '0',
  `feed_bulls` int(11) NOT NULL DEFAULT '0',
  `feed_goats` int(11) NOT NULL DEFAULT '0',
  `feed_cows` int(11) NOT NULL DEFAULT '0',
  `egg` int(11) NOT NULL DEFAULT '0',
  `meat` int(11) NOT NULL DEFAULT '0',
  `goat_milk` int(11) NOT NULL DEFAULT '0',
  `cow_milk` int(11) NOT NULL DEFAULT '0',
  `egg_for_sell` int(11) NOT NULL DEFAULT '0',
  `meat_for_sell` int(11) NOT NULL DEFAULT '0',
  `goat_milk_for_sell` int(11) NOT NULL DEFAULT '0',
  `cow_milk_for_sell` int(11) NOT NULL DEFAULT '0',
  `dough` int(11) NOT NULL DEFAULT '0',
  `mince` int(11) NOT NULL DEFAULT '0',
  `cheese` int(11) NOT NULL DEFAULT '0',
  `curd` int(11) NOT NULL DEFAULT '0',
  `dough_for_sell` int(11) NOT NULL DEFAULT '0',
  `mince_for_sell` int(11) NOT NULL DEFAULT '0',
  `cheese_for_sell` int(11) NOT NULL DEFAULT '0',
  `curd_for_sell` int(11) NOT NULL DEFAULT '0',
  `paddock_chickens` int(11) NOT NULL DEFAULT '0',
  `paddock_bulls` int(11) NOT NULL DEFAULT '0',
  `paddock_goats` int(11) NOT NULL DEFAULT '0',
  `paddock_cows` int(11) NOT NULL DEFAULT '0',
  `factory_dough` int(11) NOT NULL DEFAULT '0',
  `factory_mince` int(11) NOT NULL DEFAULT '0',
  `factory_cheese` int(11) NOT NULL DEFAULT '0',
  `factory_curd` int(11) NOT NULL DEFAULT '0',
  `meat_bakery` int(11) NOT NULL DEFAULT '0',
  `cheese_bakery` int(11) NOT NULL DEFAULT '0',
  `curd_bakery` int(11) NOT NULL DEFAULT '0',
  `cakewithmeat` int(11) NOT NULL DEFAULT '0',
  `cakewithcheese` int(11) NOT NULL DEFAULT '0',
  `cakewithcurd` int(11) NOT NULL DEFAULT '0',
  `cakewithmeat_for_sell` int(11) NOT NULL DEFAULT '0',
  `cakewithcheese_for_sell` int(11) NOT NULL DEFAULT '0',
  `cakewithcurd_for_sell` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_storage_id`),
  KEY `idx_u_storage_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Таблица склад';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wall_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `wall_id` int(11) DEFAULT NULL,
  `text` varchar(150) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`),
  KEY `fk_wall_id` (`wall_id`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_wall_id` FOREIGN KEY (`wall_id`) REFERENCES `wall_post` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wall_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_wall_id` int(11) DEFAULT NULL,
  `content` varchar(150) DEFAULT NULL,
  `like_count` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


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

LOCK TABLES `animal_food` WRITE;
/*!40000 ALTER TABLE `animal_food` DISABLE KEYS */;
INSERT INTO `animal_food` VALUES (1,1,'feed_chickens',0.04,100,1,1),(2,2,'feed_bulls',0.06,100,1,1),(3,3,'feed_goats',0.09,100,1,1),(4,4,'feed_cows',0.16,100,1,1);
/*!40000 ALTER TABLE `animal_food` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `animal_pens` WRITE;
/*!40000 ALTER TABLE `animal_pens` DISABLE KEYS */;
INSERT INTO `animal_pens` VALUES (1,'Загон Кур','paddock_chickens','zagr1.png',20.00,1,1,1),(2,'Загон бычков','paddock_bulls','zagb1.png',40.00,5,1,1),(3,'Загон Коз','paddock_goats','zagz12.png',60.00,10,1,1),(4,'Загон Коров','paddock_cows','zagk1.png',150.00,15,1,1);
/*!40000 ALTER TABLE `animal_pens` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `animals` WRITE;
/*!40000 ALTER TABLE `animals` DISABLE KEYS */;
INSERT INTO `animals` VALUES (1,'Курица','chicken','sale.png','kur.png','kur1.png','kur2.png',1,5.00,10,1,1),(2,'Бычок','bull','sale.png','bichok.png','bichok1.png','bichok2.png',5,10.00,20,1,1),(3,'Коза','goat','sale.png','koz.png','koz1.png','koz2.png',10,20.00,30,1,1),(4,'Корова','cow','sale.png','kor.png','kor1.png','kor2.png',15,50.00,40,1,1);
/*!40000 ALTER TABLE `animals` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `auth_users` WRITE;
/*!40000 ALTER TABLE `auth_users` DISABLE KEYS */;
INSERT INTO `auth_users` VALUES (1,'test','123456'),(2,'test1','123456');
/*!40000 ALTER TABLE `auth_users` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `bakeries` WRITE;
/*!40000 ALTER TABLE `bakeries` DISABLE KEYS */;
INSERT INTO `bakeries` VALUES (1,'Пекарня пирог с мясом','meat_bakery','ppf1.png',1500.00,30,1700,10),(2,'Пекарня пирог с сыром','cheese_bakery','pps1.png',2200.00,40,2600,10),(3,'Пекарня пирог с творогом','curd_bakery','ppt1.png',3200.00,50,3400,10);
/*!40000 ALTER TABLE `bakeries` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `banner` WRITE;
/*!40000 ALTER TABLE `banner` DISABLE KEYS */;
/*!40000 ALTER TABLE `banner` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `bonus` WRITE;
/*!40000 ALTER TABLE `bonus` DISABLE KEYS */;
INSERT INTO `bonus` VALUES (1,'test',100.00,1559114139);
/*!40000 ALTER TABLE `bonus` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `bonus_buy` WRITE;
/*!40000 ALTER TABLE `bonus_buy` DISABLE KEYS */;
/*!40000 ALTER TABLE `bonus_buy` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `bonus_total` WRITE;
/*!40000 ALTER TABLE `bonus_total` DISABLE KEYS */;
INSERT INTO `bonus_total` VALUES (1,100.00);
/*!40000 ALTER TABLE `bonus_total` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `bull_items` WRITE;
/*!40000 ALTER TABLE `bull_items` DISABLE KEYS */;
INSERT INTO `bull_items` VALUES (2,1,2,98,1,0,0,0),(3,1,2,98,2,0,0,0),(4,1,2,98,3,0,0,0),(5,1,2,98,4,0,0,0),(6,1,2,98,5,0,0,0),(7,1,2,98,6,0,0,0),(8,1,2,98,7,0,0,0),(9,1,2,98,8,0,0,0),(10,1,2,98,9,0,0,0),(11,2,2,98,1,0,0,0),(12,2,2,98,2,0,0,0),(13,2,2,98,3,0,0,0),(14,2,2,98,4,0,0,0),(15,2,2,98,5,0,0,0),(16,2,2,98,6,0,0,0),(17,2,0,98,7,0,0,0),(18,2,0,98,8,0,0,0),(19,2,0,98,9,0,0,0),(20,3,0,98,1,0,0,0),(21,3,0,98,2,0,0,0),(22,3,0,98,3,0,0,0),(23,3,0,98,4,0,0,0),(24,3,0,98,5,0,0,0),(25,3,0,98,6,0,0,0),(26,3,0,98,7,0,0,0),(27,3,0,98,8,0,0,0),(28,3,0,98,9,0,0,0),(29,6,0,98,1,0,0,0),(30,6,0,98,2,0,0,0),(31,6,0,98,3,0,0,0),(32,6,0,98,4,0,0,0),(33,6,0,98,5,0,0,0),(34,6,0,98,6,0,0,0),(35,6,0,98,7,0,0,0),(36,6,0,98,8,0,0,0),(37,6,0,98,9,0,0,0),(38,5,0,98,1,0,0,0),(39,5,0,98,2,0,0,0),(40,5,0,98,3,0,0,0),(41,5,0,98,4,0,0,0),(42,5,0,98,5,0,0,0),(43,5,0,98,6,0,0,0),(44,5,0,98,7,0,0,0),(45,5,0,98,8,0,0,0),(46,5,0,98,9,0,0,0),(47,4,0,98,1,0,0,0),(48,4,0,98,2,0,0,0),(49,4,0,98,3,0,0,0),(50,4,0,98,4,0,0,0),(51,4,0,98,5,0,0,0),(52,4,0,98,6,0,0,0),(53,4,0,98,7,0,0,0),(54,4,0,98,8,0,0,0),(55,4,0,98,9,0,0,0),(56,7,0,98,1,0,0,0),(57,7,0,98,2,0,0,0),(58,7,0,98,3,0,0,0),(59,7,0,98,4,0,0,0),(60,7,0,98,5,0,0,0),(61,7,0,98,6,0,0,0),(62,7,0,98,7,0,0,0),(63,7,0,98,8,0,0,0),(64,7,0,98,9,0,0,0),(65,8,0,98,1,0,0,0),(66,8,0,98,2,0,0,0),(67,8,0,98,3,0,0,0),(68,8,0,98,4,0,0,0),(69,8,0,98,5,0,0,0),(70,8,0,98,6,0,0,0),(71,8,0,98,7,0,0,0),(72,8,0,98,8,0,0,0),(73,8,0,98,9,0,0,0),(74,9,0,98,1,0,0,0),(75,9,0,98,2,0,0,0),(76,9,0,98,3,0,0,0),(77,9,0,98,4,0,0,0),(78,9,0,98,5,0,0,0),(79,9,0,98,6,0,0,0),(80,9,0,98,7,0,0,0),(81,9,0,98,8,0,0,0),(82,9,0,98,9,0,0,0);
/*!40000 ALTER TABLE `bull_items` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `charity` WRITE;
/*!40000 ALTER TABLE `charity` DISABLE KEYS */;
/*!40000 ALTER TABLE `charity` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `charity_users` WRITE;
/*!40000 ALTER TABLE `charity_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `charity_users` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `chat` WRITE;
/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
INSERT INTO `chat` VALUES (1,'<span style=\"color: blue;\">test</span>','test',98,1,1,'test',1559115910,'2019-05-29 07:45:10'),(2,'<span style=\"color: blue;\">test</span>','test',98,1,1,'alert(\'ok\')',1559115944,'2019-05-29 07:45:44'),(3,'<span style=\"color: blue;\">test</span>','test',98,1,1,'<img src=\'/img/smile/13.gif\'>',1559664044,'2019-06-04 16:00:44');
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `cheese_bakery` WRITE;
/*!40000 ALTER TABLE `cheese_bakery` DISABLE KEYS */;
INSERT INTO `cheese_bakery` VALUES (1,98,2,40,0,0,0),(2,98,0,70,0,0,0),(3,98,0,100,0,0,0),(4,98,0,130,0,0,0),(5,98,0,160,0,0,0),(6,98,0,190,0,0,0),(7,98,0,220,0,0,0),(8,98,0,250,0,0,0),(9,98,0,280,0,0,0),(10,99,0,40,0,0,0),(11,99,0,70,0,0,0),(12,99,0,100,0,0,0),(13,99,0,130,0,0,0),(14,99,0,160,0,0,0),(15,99,0,190,0,0,0),(16,99,0,220,0,0,0),(17,99,0,250,0,0,0),(18,99,0,280,0,0,0);
/*!40000 ALTER TABLE `cheese_bakery` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `chicken_items` WRITE;
/*!40000 ALTER TABLE `chicken_items` DISABLE KEYS */;
INSERT INTO `chicken_items` VALUES (1,37,0,97,1,0,0,0),(10,1,0,98,1,0,0,0),(11,1,0,98,2,0,0,0),(12,1,0,98,3,0,0,0),(13,1,0,98,4,0,0,0),(14,1,0,98,5,0,0,0),(15,1,0,98,6,0,0,0),(16,1,0,98,7,0,0,0),(17,1,0,98,8,0,0,0),(18,1,0,98,9,0,0,0),(19,2,3,98,1,1559403483,1559422800,4),(20,2,0,98,2,0,0,0),(21,2,0,98,3,0,0,0),(22,2,0,98,4,0,0,0),(23,2,0,98,5,0,0,0),(24,2,0,98,6,0,0,0),(25,2,0,98,7,0,0,0),(26,2,0,98,8,0,0,0),(27,2,0,98,9,0,0,0),(28,10,0,99,1,0,0,0),(29,10,0,99,2,0,0,0),(30,10,0,99,3,0,0,0),(31,10,0,99,4,0,0,0),(32,10,0,99,5,0,0,0),(33,10,0,99,6,0,0,0),(34,10,0,99,7,0,0,0),(35,10,0,99,8,0,0,0),(36,10,0,99,9,0,0,0);
/*!40000 ALTER TABLE `chicken_items` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES (1,''),(2,'<p \"=\"><strong=\"><strong>1. Общие правила</strong></p><p>');
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `cow_items` WRITE;
/*!40000 ALTER TABLE `cow_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `cow_items` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `curd_bakery` WRITE;
/*!40000 ALTER TABLE `curd_bakery` DISABLE KEYS */;
INSERT INTO `curd_bakery` VALUES (1,98,0,50,0,0,0),(2,98,0,80,0,0,0),(3,98,0,110,0,0,0),(4,98,0,140,0,0,0),(5,98,0,170,0,0,0),(6,98,0,200,0,0,0),(7,98,0,230,0,0,0),(8,98,0,260,0,0,0),(9,98,0,290,0,0,0),(10,99,0,50,0,0,0),(11,99,0,80,0,0,0),(12,99,0,110,0,0,0),(13,99,0,140,0,0,0),(14,99,0,170,0,0,0),(15,99,0,200,0,0,0),(16,99,0,230,0,0,0),(17,99,0,260,0,0,0),(18,99,0,290,0,0,0);
/*!40000 ALTER TABLE `curd_bakery` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `exchange` WRITE;
/*!40000 ALTER TABLE `exchange` DISABLE KEYS */;
INSERT INTO `exchange` VALUES (1,'dough',2,15,10,1);
/*!40000 ALTER TABLE `exchange` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `exchange_history` WRITE;
/*!40000 ALTER TABLE `exchange_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `exchange_history` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `fabric_product_type` WRITE;
/*!40000 ALTER TABLE `fabric_product_type` DISABLE KEYS */;
INSERT INTO `fabric_product_type` VALUES (1,'Яйца','egg','egg_for_sell','316.png',0.21,0.18,100,100,'FabricProductType',3,0),(2,'Мясо','meat','meat_for_sell','314.png',0.35,0.32,100,100,'FabricProductType',3,0),(3,'Молоко козы','goat_milk','goat_milk_for_sell','318.png',0.59,0.56,100,100,'FabricProductType',3,0),(4,'Молоко коровы','cow_milk','cow_milk_for_sell','315.png',1.28,1.25,100,100,'FabricProductType',3,0);
/*!40000 ALTER TABLE `fabric_product_type` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `factories` WRITE;
/*!40000 ALTER TABLE `factories` DISABLE KEYS */;
INSERT INTO `factories` VALUES (1,'Фабрика теста','factory_dough','ftesta.png',400.00,10,400,10),(2,'Фабрика фарша','factory_mince','ffarsh.png',600.00,20,1,10),(3,'Фабрика сыра','factory_cheese','fsir.png',800.00,30,1,10),(4,'Фабрика творога','factory_curd','ftvor.png',1800.00,40,1,10);
/*!40000 ALTER TABLE `factories` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `factory_cheese` WRITE;
/*!40000 ALTER TABLE `factory_cheese` DISABLE KEYS */;
INSERT INTO `factory_cheese` VALUES (1,98,2,30,0,0,0),(2,98,0,70,0,0,0),(3,98,0,110,0,0,0),(4,98,0,150,0,0,0),(5,98,0,190,0,0,0),(6,98,0,230,0,0,0),(7,98,0,270,0,0,0),(8,98,0,310,0,0,0),(9,98,0,350,0,0,0),(10,99,0,30,0,0,0),(11,99,0,70,0,0,0),(12,99,0,110,0,0,0),(13,99,0,150,0,0,0),(14,99,0,190,0,0,0),(15,99,0,230,0,0,0),(16,99,0,270,0,0,0),(17,99,0,310,0,0,0),(18,99,0,350,0,0,0);
/*!40000 ALTER TABLE `factory_cheese` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `factory_curd` WRITE;
/*!40000 ALTER TABLE `factory_curd` DISABLE KEYS */;
INSERT INTO `factory_curd` VALUES (1,98,0,40,0,0,0),(2,98,0,80,0,0,0),(3,98,0,120,0,0,0),(4,98,0,160,0,0,0),(5,98,0,200,0,0,0),(6,98,0,240,0,0,0),(7,98,0,280,0,0,0),(8,98,0,320,0,0,0),(9,98,0,360,0,0,0),(10,99,0,40,0,0,0),(11,99,0,80,0,0,0),(12,99,0,120,0,0,0),(13,99,0,160,0,0,0),(14,99,0,200,0,0,0),(15,99,0,240,0,0,0),(16,99,0,280,0,0,0),(17,99,0,320,0,0,0),(18,99,0,360,0,0,0);
/*!40000 ALTER TABLE `factory_curd` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `factory_dough` WRITE;
/*!40000 ALTER TABLE `factory_dough` DISABLE KEYS */;
INSERT INTO `factory_dough` VALUES (1,98,2,10,0,0,0),(2,98,2,50,0,0,0),(3,98,0,90,0,0,0),(4,98,0,130,0,0,0),(5,98,0,170,0,0,0),(6,98,0,210,0,0,0),(7,98,0,250,0,0,0),(8,98,0,290,0,0,0),(9,98,0,330,0,0,0),(10,99,0,10,0,0,0),(11,99,0,50,0,0,0),(12,99,0,90,0,0,0),(13,99,0,130,0,0,0),(14,99,0,170,0,0,0),(15,99,0,210,0,0,0),(16,99,0,250,0,0,0),(17,99,0,290,0,0,0),(18,99,0,330,0,0,0);
/*!40000 ALTER TABLE `factory_dough` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `factory_mince` WRITE;
/*!40000 ALTER TABLE `factory_mince` DISABLE KEYS */;
INSERT INTO `factory_mince` VALUES (1,98,0,20,0,0,0),(2,98,0,60,0,0,0),(3,98,0,100,0,0,0),(4,98,0,140,0,0,0),(5,98,0,180,0,0,0),(6,98,0,220,0,0,0),(7,98,0,260,0,0,0),(8,98,0,300,0,0,0),(9,98,0,340,0,0,0),(10,99,0,20,0,0,0),(11,99,0,60,0,0,0),(12,99,0,100,0,0,0),(13,99,0,140,0,0,0),(14,99,0,180,0,0,0),(15,99,0,220,0,0,0),(16,99,0,260,0,0,0),(17,99,0,300,0,0,0),(18,99,0,340,0,0,0);
/*!40000 ALTER TABLE `factory_mince` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `faq` WRITE;
/*!40000 ALTER TABLE `faq` DISABLE KEYS */;
INSERT INTO `faq` VALUES (1,'Могу ли я зарабатывать не вкладывая денег?','<p \"=\"\">Да, можете! В нашей игре есть реферальная программа. Вы можете приглашать людей в нашу игру, предоставляя им для регистрации свою реферальную ссылку, найти её вы можете в разделе Друзья → Рекламные материалы. Таким образом вы будете получать 5-10% от покупок ваших рефералов. Чем больше рефералов Вы привлечёте, тем больше вы сможете заработать.</p>',1),(2,'Как я могу быстро набрать уровень?','<p>На Бирже опыта, Вы можете обменять продукцию купленную в ярмарке и энергию на опыт. Биржа опыта находится в меню. С помощью биржи, Вы можете за короткий срок поднять свой уровень.</p>',1),(3,'Кто такие друзья?','Друзья – это участники игры, которые пришли по Вашей реферальной ссылке. Друзья будут приносить Вам прибыль за счёт совершаемых ими покупок. Вы можете привлекать друзей на рекламных площадках, на просторах соц. сетей и т.д.',1),(4,'Выплаты','<p>Во вкладке Баланс → Вывод Вы можете заказать выплату на свой электронный кошелёк. Будьте внимательны при заказе выплат, указывайте точные данные и помните, что при отмене выплаты, средства возвращаются на баланс для оплаты.</p>',1),(5,'Как быстро я могу получить выплату?','<p>Выплаты происходят в ручную. Обычно выплаты производятся не позднее чем через 24 часа от момента заявки.</p>',1),(6,'Почему в игре 2 баланса?','В игре предусмотрено 2 баланса чтобы избежать обмен валют через нашу игру. 1. Баланс для оплаты - баланс, на который поступают деньги после пополнения. С него Вы можете осуществлять любые покупки в игре. 2. Баланс для вывода - баланс, на который поступают деньги с продажи товаров. С этого баланса Вы можете заказать выплаты или конвертировать на баланс для оплаты в разделе - Баланс → Обменный пункт',1),(7,'Как связаться с администрацией?','Вы можете написать в тех. поддержку или по указанным контактам. ',1),(8,'Почему я не могу продать корм в ярмарку?','В ярмарке стоит ограничение на выкуп корма. Ограничение составляет 10 000 единиц корма. Если в ярмарке нет места, то Вы не сможете продать корм. Вы сможете продать корм тогда, когда кто-то выкупит его из ярмарки.',1),(9,'Платёжный пароль','<p>Платёжный пароль высылается каждому игроку на почту при регистрации. Платёжный пароль создан для защиты ваших денежных средств, он требуется при выполнение финансовых операций. Данный пароль должен храниться в надёжном месте и быть извсетен только вам!  Вы можете заказать новый платёжный пароль в разделе \"Пользователь\"-&gt;\"Профиль\",</p>',1);
/*!40000 ALTER TABLE `faq` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `farm_storage` WRITE;
/*!40000 ALTER TABLE `farm_storage` DISABLE KEYS */;
INSERT INTO `farm_storage` VALUES (1,0,0,0,0,0,0,0,0,0,0,0,0,5728.46,0.00);
/*!40000 ALTER TABLE `farm_storage` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `friend_gifts` WRITE;
/*!40000 ALTER TABLE `friend_gifts` DISABLE KEYS */;
/*!40000 ALTER TABLE `friend_gifts` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `friends` WRITE;
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `gifts` WRITE;
/*!40000 ALTER TABLE `gifts` DISABLE KEYS */;
/*!40000 ALTER TABLE `gifts` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `goat_items` WRITE;
/*!40000 ALTER TABLE `goat_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `goat_items` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `instructions` WRITE;
/*!40000 ALTER TABLE `instructions` DISABLE KEYS */;
INSERT INTO `instructions` VALUES (1,'Начинаем играть','<p> <span style=\"color: rgb(149, 55, 52);\">Внимание! В нашей игре, вы можете делать сбор в любое удобное для вас время. У нас нет жёсткой привязки по времени!</span></p><p>Название игры - экономическая онлайн игра, прибыль в которой зависит от выбранной вами стратегии развития! Уйти в минус в игре невозможно, но от того как благоразумно вы будете вести своё фермерское хозяйство, зависит как быстро вы начнёте получать прибыль и какого размера будет ваша прибыль! </p><p>После регистрации, вы получаете подарки на общую сумму в 23 рубля, а именно: 1 поле для засева корма, загон кур и 100 ед. энергии. Для перехода на следующий уровень, вам нужно набирать опыт. Опыт в игре, вы получаете за покупку животных на ярмарке, за кормление животных и сбор продукции, за запуск фабрик, пекарен и сбор полуфабрикатов и пирогов, а также на бирже опыта, вы можете обменять продукты на опыт. Чтобы производить все эти действия, вам необходима энергия, пополнить энергию, вы можете в \"Пироговой\", съев несколько пирогов, пироговая находится на ярмарке. </p><p>Пополнение баланса.  Чтобы начать играть, вам необходимо пополнить свой баланс. Для внесения денежных средств перейдите по вкладке Баланс → Пополнить. В игре существует два вида баланса. Введённые в игру деньги поступают на Баланс для оплаты. Ваша прибыль полученная в ходе игры, поступает на баланс для вывода, вы можете вывести эти деньги или реинвестировать обменяв их в Баланс → Обменный пункт.  Предоставлено множество способов для пополнения и вывода баланса. Выбирайте платёжную систему, в которой комиссия за ваш перевод будет меньше всего. В системах Free-Kassa и Mykassa предоставлено множество вариантов для пополнения. Пополнить баланс, можно абсолютно всеми популярными способами: W1, Bitcoin, OOOPAY, Perfect Money, ZPayment, Visa, MasterCard/Maestro, МТС, Билайн, ТЕЛЕ2, Сбербанк, ВТБ 24, Тинькофф, и т.д. Также, обращаем ваше внимание на то, что мы можем провести ручное пополнение через Qiwi, чтобы вы не теряли комиссию, если сумма вашего пополнения от 2000 рублей и выше. Для ручного пополнения свяжитесь с администрацией, более подробно об этом написано на странице пополнения. </p><p>Обязательно посетите раздел F.A.Q. Из него вы узнаете как можно заработать без пополнения своего баланса, а также найдёте ответы на самые частые вопросы.<br></p>',NULL,1),(2,'Животные и загоны','<p style=\"text-align: justify;\"><strong><span style=\"color: #c0504d;\"><strong><span style=\"color: rgb(118, 146, 60);\"></span></strong></span></strong><span style=\"color: rgb(99, 36, 35);\"></span><span style=\"color: rgb(149, 55, 52);\">Внимание! В нашей игре, вы можете делать сбор в любое удобное для вас время. У нас нет жёсткой привязки по времени!</span><br></p><p style=\"text-align: justify;\">В игре существует 4 вида животных: куры, бычки, козы и коровы. Каждое животное имеет свою стоимость и свой уровень доступности. Животных нужно кормить и собирать 1 раз в день, в любое удобное для вас время. За 1 сбор животное потребляет 2 ед. корма и даёт 2 ед. продукции. Одно животное даёт 60 ед. продукции, после чего покидает игру, на его место Вы можете посадить другое животное<span class=\"redactor-invisible-space\">. Животных </span>можно купить на ярмарке. Продукцию полученную с животных, вы можете продать на складе. </p><p style=\"text-align: justify;\">Загоны. Для каждого животного существует свой определённый загон. Загоны нужно покупать на ярмарке, затем вы сможете их построить на доступных полях. Загоны покупаются навсегда. </p><p style=\"text-align: justify;\" rel=\"text-align: justify;\"><br></p><p><a target=\"_blank\" href=\"https://bitmoneyfarm.club/game/paddock-chickens\"><img rel=\"float: left; margin: 0px 10px 10px 0px;\" alt=\"\" \"=\"\" src=\"https://bitmoneyfarm.club/uploads/0/5/a/a/d05aada6c53e0d7cf8048c140dbc4543d.png\" style=\"float: left; margin: 0px 10px 10px 0px;\"></a> Загон кур доступен с 1-го уровня, стоимость 20 руб. Стоимость курицы 5 руб. Куры потребляют пшеницу. За 1 сбор, вы получаете 2 ед. продукта, за 30 сборов, вы получаете 60 ед. продукта. Прибыль с 1-го загона в месяц 9 руб. Каждое кормление одной курицы забирает 5 ед. энергии и дает 2 ед. опыта. Каждый сбор продукта забирает 5 ед. энергии и дает 2 ед. опыта. Потребление энергии кнопкой автосбора<span class=\"redactor-invisible-space\">: </span>Каждое кормление забирает 5 ед. энергии. Каждый сбор продукта забирает 6 ед. энергии.  <span class=\"redactor-invisible-space\"></span></p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\"><a target=\"_blank\" href=\"https://ferma.ru/game/paddock-bulls\"><img alt=\"\" src=\"https://ferma.ru/uploads/f/3/9/9/9f3999a86617741507fa42b89ec297385.png\" style=\"float: left; margin: 0px 10px 10px 0px;\"></a>Загон бычков доступен с 5-го уровня, стоимость 40 руб. Стоимость бычка 10 руб. Бычки потребляют клевер, за 1 сбор, вы получаете 2 ед. продукта, за 30 сборов, вы получаете 60 ед. продукта. Прибыль с 1-го загона в месяц 18 руб. Каждое кормление одного бычка забирает 6 ед. энергии и дает 2 ед. опыта. Каждый сбор продукта забирает 10 ед. энергии и дает 2 ед. опыта. Потребление энергии кнопкой автосбора<span class=\"redactor-invisible-space\">: Каждое кормление забирает 7 ед. энергии. Каждый сбор продукта забирает 11 ед. энергии. <span class=\"redactor-invisible-space\"> </span></span></p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\"><br></p><p><a target=\"_blank\" href=\"https://ferma.ru/game/paddock-goats\"><img rel=\"float: left; margin: 0px 10px 10px 0px;\" alt=\"\" src=\"https://ferma.ru/uploads/b/3/f/1/3b3f13f7d0b3721241c53728a65745818.png\" style=\"float: left; margin: 0px 10px 10px 0px;\"></a> Загон коз доступен с 10-го уровня, стоимость 60 руб. Стоимость козы 20 руб. Козы потребляют капусту, за 1 сбор, вы получаете 2 ед. продукта, за 30 сборов, вы получаете 60 ед. продукта. Прибыль с 1-го загона в месяц 27.9 руб. Каждое кормление одной козы забирает 7 ед. энергии и дает 2 ед. опыта. Каждый сбор продукта забирает 16 ед. энергии и дает 2 ед. опыта. Потребление энергии кнопкой автосбора<span class=\"redactor-invisible-space\">: </span>Каждое кормление забирает 8 ед<span class=\"redactor-invisible-space\">. энергии. Каждый сбор продукта забирает 17 ед. <span class=\"redactor-invisible-space\">энергии </span>. <span class=\"redactor-invisible-space\"></span></span></p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\"><br></p><p><a target=\"_blank\" href=\"https://ferma.ru/game/paddock-cows\"><img alt=\"\" src=\"https://ferma.ru/uploads/f/5/2/8/2f52828334214b2567994e3106a8ca75a.png\" style=\"float: left; margin: 0px 10px 10px 0px;\"></a>Загон коров доступен с 15-го уровня, стоимость 150 руб. Стоимость коровы 50 руб. Коровы потребляют свеклу, за 1 сбор, вы получаете 2 ед. продукта, за 30 сборов, вы получаете 60 ед. продукта. Прибыль с 1-го загона в месяц 73.8 руб. Каждое кормление одной коровы забирает 10 ед. энергии и дает 2 ед. опыта. Каждый сбор продукта забирает 22 ед. энергии и дает 2 ед. опыта. Потребление энергии кнопкой автосбора<span class=\"redactor-invisible-space\">:</span> Каждое кормление забирает 11 ед<span class=\"redactor-invisible-space\">. энергии. Каждый сбор продукта забирает 23 ед<span class=\"redactor-invisible-space\">.</span></span></p><p><span class=\"redactor-invisible-space\"><span class=\"redactor-invisible-space\">Учитывайте важные моменты! В игре существует 3 вида сбора и кормления: 1)Ручной сбор первого типа - когда вы открываете загон и кликаете по каждому животному 2)Ручной сбор второго типа - когда вы кликаете на загон и выбираете собрать/покормить 3)Автоматический сбор - зелёные кнопки справа от полей, собрать и покормить, при помощи них вы собираете и кормите сразу все загоны, но за это взимается дополнительная энергия.</span></span></p><p><span class=\"redactor-invisible-space\"><span class=\"redactor-invisible-space\"> Если вы, покупаете корм на ярмарке или выращиваете его с удобрениями, то ваша прибыль становится ниже. Если вы одновременно используете кнопку авто. сбора и покупаете корм на ярмарке или выращиваете его с удобрениями, ваша прибыль становится ниже!<br></span></span></p><span style=\"color: #c0504d;\"></span>',NULL,1),(3,'Фабрики','<p style=\"text-align: justify;\"><span style=\"color: rgb(149, 55, 52);\">Внимание! В нашей игре, вы можете делать сбор в любое удобное для вас время. У нас нет жёсткой привязки по времени!</span></p><p style=\"text-align: justify;\">В игре существует 4 вида фабрик: теста, фарша, сыра и творога. Каждая фабрика имеет свой уровень доступности, свою стоимость и тип перерабатываемой продукции. Фабрики покупаются на 365 сборов! После того, как вы произведёте последний сбор, фабрика рушится, после чего, на её месте, вы сможете построить точно такую же фабрику. Фабрики необходимо покупать на ярмарке, после чего, вы сможете построить их на доступных полях. Продукты для запуска фабрики необходимо покупать на ярмарке! Вы не сможете перерабатывать продукты, которые собрали со своих животных. Фабрики доступны с 10-го уровня и открываются каждые 10 уровней по цепочке, начиная с фабрики теста. </p><p style=\"text-align: justify;\">Каждый запуск любого вида фабрики потребляет 500 ед. энергии и даёт 10 ед. опыта.<br>Каждый сбор любого вида фабрики потребляет 500 ед. энергии и даёт 10 ед. опыта.</p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\"><a target=\"_blank\" href=\"https://ferma.ru/game/factory-dough\"><img rel=\"float: left; margin: 0px 10px 10px 0px;\" alt=\"\" src=\"https://ferma.ru/uploads/9/c/6/f/e9c6fedf45326e6f7c8f7f983923b1930.png\" style=\"float: left; margin: 0px 10px 10px 0px;\"></a> Фабрика «Тесто», доступна с 10 уровня, стоимость 400 рублей. 300 яиц перерабатывает в 200 теста. Прибыль за 30 сборов 210 руб. </p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\"><a target=\"_blank\" href=\"https://ferma.ru/game/factory-mince\"><img alt=\"\" src=\"https://ferma.ru/uploads/f/5/f/3/df5f3d9b7af72f3b2a989e6572cde607f.png\" style=\"float: left; margin: 0px 10px 10px 0px;\"></a> Фабрика «Фарш», доступна с 20 уровня, стоимость 600 рублей. 300 мяса перерабатывает в 200 фарша. Прибыль за 30 сборов 330 руб. </p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\"><a target=\"_blank\" href=\"https://ferma.ru/game/factory-cheese\"><img rel=\"float: left; margin: 0px 10px 10px 0px;\" alt=\"\" src=\"https://ferma.ru/uploads/7/2/6/9/2726928bb85f1c623a3ca340df2d6f130.png\" style=\"float: left; margin: 0px 10px 10px 0px;\"></a> Фабрика «Сыр», доступна с 30 уровня, стоимость 800 рублей. 300 молока козы перерабатывает в 200 сыра. Прибыль за 30 сборов 450 руб. </p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\"><a target=\"_blank\" href=\"https://ferma.ru/game/factory-curd\"><img alt=\"\" src=\"https://ferma.ru/uploads/3/f/9/3/53f9352fcc796d56562194d86ee956a46.png\" style=\"float: left; margin: 0px 10px 10px 0px;\"></a> Фабрика «Творог», доступна с 40 уровня, стоимость 1800 рублей. 300 молока коровы перерабатывает в 200 творога. Прибыль за 30 сборов 1140 руб.  </p>',NULL,1),(4,'Пекарни','<p style=\"text-align: justify;\"><span style=\"color: rgb(149, 55, 52);\">Внимание! В нашей игре, вы можете делать сбор в любое удобное для вас время. У нас нет жёсткой привязки по времени!</span></p><p style=\"text-align: justify;\">В игре существует 3 вида пекарен: пирог с мясом, пирог с сыром и пирог с творогом. Каждая пекарня имеет свой уровень доступности, свою стоимость и тип перерабатываемой продукции. Пекарни покупаются на 365 сборов! После того, как вы произведёте последний сбор, пекарня рушится, после чего, на её месте, вы сможете построить точно такую же пекарню. Пекарни необходимо покупать на ярмарке, после чего, вы сможете построить их на доступных полях. Продукты для запуска пекарни необходимо покупать на ярмарке!</p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\"><a target=\"_blank\" href=\"https://ferma.ru/game/meat-bakery\"><img rel=\"float: left; margin: 0px 10px 10px 0px;\" alt=\"\" src=\"https://ferma.ru/uploads/8/4/f/9/b84f9b916b4043b7c8d09409a5c1560fd.png\" style=\"float: left; margin: 0px 10px 10px 0px;\"></a> Пекарня «Пирог с мясом» доступна с 30-го уровня, стоимость 1500 руб. Из 70 теста и 200 фарша готовится 200 пирогов с мясом, со своего склада их можно выставить в очередь на продажу в пироговую. Прибыль за 30 сборов 675 руб. Каждый запуск забирает 1100 ед. энергии и даёт 10 ед. опыта. Каждый сбор забирает 1700 ед. энергии и даёт 10 ед. опыта.</p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\"><a target=\"_blank\" href=\"https://ferma.ru/game/cheese-bakery\"><img alt=\"\" src=\"https://ferma.ru/uploads/7/2/7/f/b727fbb9f83b22a3db79e0a077321f25e.png\" style=\"float: left; margin: 0px 10px 10px 0px;\"></a> Пекарня «Пирог с сыром» доступна с 40-го уровня, стоимость 2200 руб. Из 70 теста и 200 сыра готовится 200 пирогов с сыром, со своего склада их можно выставить в очередь на продажу в пироговую. Прибыль за 30 сборов 1065 руб. Каждый запуск забирает 1300 ед. энергии и даёт 10 ед. опыта. Каждый сбор забирает 2600 ед. энергии и даёт 10 ед. опыта.</p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\"><a target=\"_blank\" href=\"https://ferma.ru/game/curd-bakery\"><img rel=\"float: left; margin: 0px 10px 10px 0px;\" alt=\"\" src=\"https://ferma.ru/uploads/9/9/3/b/4993b47c84e72c8324d25ef163247f351.png\" style=\"float: left; margin: 0px 10px 10px 0px;\"></a> Пекарня «Пирог с творогом» доступна с 50-го уровня, стоимость 3200 руб. Из 70 теста и 200 творога готовится 200 пирогов с творогом, со своего склада их можно выставить в очередь на продажу в пироговую. Прибыль за 30 сборов 1725 руб. Каждый запуск забирает 1300 ед. энергии и даёт 10 ед. опыта. Каждый сбор забирает 3400 ед. энергии и даёт 10 ед. опыта.</p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\">Учитывайте, что ваши пироги продаются не сразу, а выставляются в очередь на продажу!</p>',NULL,1),(5,'Поля','<p><a target=\"_blank\" href=\"https://ferma.ru/game/land\"><img style=\"float: left; margin: 0px 10px 10px 0px;\" alt=\"\" src=\"https://ferma.ru/uploads/e/3/2/0/8e3208d161eee4b608e317332c4ec680b.png\"></a></p><p>На полях, вы можете выращивать корм для животных. Чтобы засеять поле, вам необходимо купить семена на ярмарке! С каждым уровнем, вам доступно +4 поля для покупки. У каждого вида корма своё время созревания. Для того чтобы ускорить процесс созревания, вы можете использовать удобрение, оно сокращает время созревания в 2 раза. Чтобы удобрить поле, выделите галочку возле \"удобрить\". В роли удобрения выступает энергия, удобрить 1 поле стоит 1 ед. энергии. <span style=\"color: rgb(99, 36, 35);\">Автосбор и автозасеивание полей не взимают дополнительной энергии!</span></p><p>Для покупки на ярмарке доступно 4 вида семян:</p><p>Пшеница. Необходима для кормления кур в загонах! Время созревания: 30 минут. Можно использовать 1 ед. энергии для уменьшения созревания на 15 минут. Стоимость семян пшеницы 0.01 руб.</p><p>Клевер. Необходим для кормления бычков в загонах! Время созревания: 45 минут. Можно использовать 1 ед. энергии для уменьшения созревания на 23 минут. Стоимость семян клевера 0.02 руб.</p><p>Капуста. Необходима для кормления коз в загонах! Время созревания: 60 минут. Можно использовать 1 ед. энергии для уменьшения созревания на 30 минут. КСтоимость семян<span class=\"redactor-invisible-space\"> капусты</span> 0.04 руб.</p><p>Свекла. Необходима для кормления коров в загонах! Время созревания: 135 минут. Можно использовать 1 ед. энергии для уменьшения созревания на 68 минут. Стоимость семян<span class=\"redactor-invisible-space\"> свеклы </span>0.10 руб.</p>',NULL,1),(6,'Ярмарка и склад','<p style=\"text-align: justify;\">Все игровые действия связанные с покупкой и продажей продукции, корма, загонов, животных, пирогов и т.д. происходят на ярмарке и на складе. </p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\"><img style=\"float: left; margin: 0px 10px 10px 0px;\" alt=\"\" src=\"https://ferma.ru/uploads/d/e/6/4/ade64a0dd20af4abfc7f00c22491a9243.png\"></p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\">Ярмарка. Если вы, хотите что то купить, то вам обязательно нужно посетить ярмарку, т.к. все покупки производятся только здесь. На ярмарке, вы покупаете семена для того чтобы засеять поля и получить корм - этот раздел так и называется \"семена\". </p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\">В разделе \"Животные\". Вы покупаете животных, за покупку каждого животного с вас снимается 1 ед. энергии и начисляется 1 ед. опыта.</p><p style=\"text-align: justify;\">Раздел \"Корм\". Здесь вы можете купить корм, если не хотите выращивать его сами. За каждую покупку корма, снимается 1 ед. энергии. </p><p style=\"text-align: justify;\">Раздел \"Продукция\". Обратите внимание, что он разделён на два отдела: в первом, вы покупаете продукцию для фабрик, во втором продукцию для пекарен! За каждую покупку продукции, снимается 3 ед. энергии. <br></p><p style=\"text-align: justify;\">Раздел \"Загоны\". Для того, чтобы построить загон на доступном поле, вам необходимо сначала купить его на ярмарке. </p><p style=\"text-align: justify;\">Раздел \"Фабрики\". Чтобы построить фабрику, необходимо купить её на ярмарке, в этом разделе.</p><p style=\"text-align: justify;\">Раздел \"Пекарни\", Чтобы построить пекарню, необходимо купить её на ярмарке, в этом разделе.</p><p style=\"text-align: justify;\">Раздел \"Пироговая\". В этом разделе, вы можете купить и съесть пироги, чтобы восполнить свою энергию. Пироги продаются в порядке очереди. Каждый пирог имеет свою цену и свою энергетическую ценность.<br></p><p style=\"text-align: justify;\"><br></p><p style=\"text-align: justify;\"><img style=\"float: left; margin: 0px 10px 10px 0px;\" alt=\"\" src=\"https://ferma.ru/uploads/5/e/d/f/b5edfb41fec459f2160c56ada6e0f6195.png\"></p><p style=\"text-align: justify;\"><br></p><p>Склад. На складе, вы можете увидеть всю продукцию, животных, загоны, корм, фабрики и т.д. которые у вас есть в наличии. Все действия по продаже, производятся исключительно на складе! В разделе \"Корм\", вы можете видеть какое количество корма у вас в наличии и также сразу продавать корм. За каждую продажу корма снимается 1 ед. энергии.</p><p>Раздел \"Семена\". В этом разделе, вы можете увидеть сколько семян для посева, у вас есть в  наличии.<br></p><p>Раздел \"Для продажи\". Здесь, вы можете видеть всю продукцию, которую вы собрали и можете продать. За каждую продажу снимается 3 ед. энергии.</p><p>Раздел \"Для переработки\". Здесь, вы можете посмотреть продукцию которую вы купили на ярмарке, эта продукция предназначена для переработки на фабриках и пекарнях.</p><p>Раздел \"Для употребления\". В этом разделе, вы можете увидеть сколько купленных пирогов у вас в наличии. Для того чтобы их съесть, вам необходимо зайти в пироговую, она находится на ярмарке. </p><p>Разделы: \"Животные\", \"Загоны\", \"Фабрики\", \"Пекарни\". Здесь, вы можете узнать число и наличие ваших животных и построек. <br></p>',NULL,1),(7,'Партнёрская программа','<p>В игре присутствует партнёрская программа. Приглашая в игру других участников, вы можете зарабатывать. Вы будете получать 10% от суммы пополнения вашего реферала.</p><p>Рефералы в нашей игре условно называются \"Друзья\". Чтобы игрок стал вашим рефералом, необходимо чтобы он перешёл на сайт по вашей ссылке для привлечения. Взять свою ссылку для привлечения, вы можете в разделе \"Друзья\"-&gt;\"Рекламные материалы\". </p><p>Таким образом, благодаря друзьям(рефералам), вы можете зарабатывать не вкладывая денег в игру или же и вовсе зарабатывать только на их привлечении! Деньги от приглашённых вами игроков, поступают сразу на баланс для вывода. </p><p>Посмотреть всех своих друзей(рефералов) вы можете в разделе \"Друзья\"-&gt;\"Ваши друзья\"</p><p>Вы можете приглашать друзей(рефералов) размещая рекламные баннеры на сайтах, создавая темы на форумах, создавать тематические группы в социальных сетях и т.д.<br></p>',NULL,1);
/*!40000 ALTER TABLE `instructions` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `land_items` WRITE;
/*!40000 ALTER TABLE `land_items` DISABLE KEYS */;
INSERT INTO `land_items` VALUES (1,98,1,'wheat',4,1,1,1559403499,1559404409),(2,98,2,NULL,3,0,1,0,0),(3,98,3,NULL,3,0,1,0,0),(4,98,4,NULL,3,0,1,0,0),(5,98,5,NULL,3,0,2,0,0),(6,98,6,NULL,3,0,2,0,0),(7,98,7,NULL,3,0,2,0,0),(8,98,8,NULL,3,0,2,0,0),(9,98,9,NULL,3,0,3,0,0),(10,98,1,NULL,1,0,3,0,0),(11,98,2,NULL,1,0,3,0,0),(12,98,3,NULL,1,0,3,0,0),(13,98,4,NULL,0,0,4,0,0),(14,98,5,NULL,0,0,4,0,0),(15,98,6,NULL,0,0,4,0,0),(16,98,7,NULL,0,0,4,0,0),(17,98,8,NULL,0,0,5,0,0),(18,98,9,NULL,0,0,5,0,0),(19,99,1,'0',3,0,1,0,0),(20,99,2,'0',1,0,1,0,0),(21,99,3,'0',1,0,1,0,0),(22,99,4,'0',1,0,1,0,0),(23,99,5,'0',0,0,2,0,0),(24,99,6,'0',0,0,2,0,0),(25,99,7,'0',0,0,2,0,0),(26,99,8,'0',0,0,2,0,0),(27,99,9,'0',0,0,3,0,0);
/*!40000 ALTER TABLE `land_items` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `like` WRITE;
/*!40000 ALTER TABLE `like` DISABLE KEYS */;
INSERT INTO `like` VALUES (1,97,10,0);
/*!40000 ALTER TABLE `like` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `login_history` WRITE;
/*!40000 ALTER TABLE `login_history` DISABLE KEYS */;
INSERT INTO `login_history` VALUES (1,2230,'127.0.0.1',1489650057,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.98 Safari/537.36'),(2,97,'91.234.78.218',1559065008,'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:67.0) Gecko/20100101 Firefox/67.0'),(3,98,'91.234.78.218',1559067422,'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:67.0) Gecko/20100101 Firefox/67.0'),(4,98,'185.211.158.253',1559110333,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36'),(5,98,'91.234.78.218',1559110523,'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:67.0) Gecko/20100101 Firefox/67.0'),(6,98,'91.234.78.218',1559115894,'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:67.0) Gecko/20100101 Firefox/67.0'),(7,98,'185.190.149.109',1559116017,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36'),(8,98,'178.74.238.17',1559123675,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36'),(9,98,'80.82.222.122',1559200083,'Mozilla/5.0 (Windows NT 6.1; rv:67.0) Gecko/20100101 Firefox/67.0'),(10,98,'91.234.79.218',1559566476,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36'),(11,98,'93.75.62.252',1559632841,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36'),(12,98,'91.210.10.6',1559634177,'Mozilla/5.0 (Windows NT 6.1; rv:67.0) Gecko/20100101 Firefox/67.0'),(13,98,'91.210.10.6',1559648318,'Mozilla/5.0 (Windows NT 6.1; rv:67.0) Gecko/20100101 Firefox/67.0'),(14,99,'91.210.10.6',1559648370,'Mozilla/5.0 (Windows NT 6.1; rv:67.0) Gecko/20100101 Firefox/67.0');
/*!40000 ALTER TABLE `login_history` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `mails` WRITE;
/*!40000 ALTER TABLE `mails` DISABLE KEYS */;
INSERT INTO `mails` VALUES (1,'alert(&#039;xxs&#039;)','test','test1','alert(&#039;xxs&#039;)',1,'2019-06-04 11:39:17');
/*!40000 ALTER TABLE `mails` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `materials` WRITE;
/*!40000 ALTER TABLE `materials` DISABLE KEYS */;
/*!40000 ALTER TABLE `materials` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `meat_bakery` WRITE;
/*!40000 ALTER TABLE `meat_bakery` DISABLE KEYS */;
INSERT INTO `meat_bakery` VALUES (1,98,0,30,0,0,0),(2,98,0,60,0,0,0),(3,98,0,90,0,0,0),(4,98,0,120,0,0,0),(5,98,0,150,0,0,0),(6,98,0,180,0,0,0),(7,98,0,210,0,0,0),(8,98,0,240,0,0,0),(9,98,0,270,0,0,0),(10,99,0,30,0,0,0),(11,99,0,60,0,0,0),(12,99,0,90,0,0,0),(13,99,0,120,0,0,0),(14,99,0,150,0,0,0),(15,99,0,180,0,0,0),(16,99,0,210,0,0,0),(17,99,0,240,0,0,0),(18,99,0,270,0,0,0);
/*!40000 ALTER TABLE `meat_bakery` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1455891091),('m130524_201442_init',1455891093),('m151208_102839_create_instructions_table',1455891094),('m151209_064556_create_attachments_table',1455891094),('m151211_063857_create_faq_table',1455891094),('m151215_092948_create_site_settings_table',1455891094),('m151223_053447_create_wall_post_table',1455891095),('m151224_112541_create_wall_comments_table',1455891095),('m151225_111646_create_like_table',1455891095),('m160105_040859_create_friends_table',1455891097),('m160107_060345_create_news_table',1455891097),('m160107_104504_create_news_comments_table',1455891097),('m160111_082019_create_reviews_table',1455891098),('m160112_102354_add_f_key_to_wall_comments',1455891100),('m160113_055345_create_message_table',1455891100),('m160114_161351_create_animals_table',1455891101),('m160114_181257_create_plant_table',1455891101),('m160115_063038_insert_animals',1455891101),('m160115_090225_insert_plant',1455891102),('m160115_103011_create_animal_food_table',1455891102),('m160115_103542_insert_animal_food',1455891102),('m160115_113554_create_mails_table',1455891103),('m160115_122012_create_fabric_product_type',1455891103),('m160115_122441_insert_fabric_product_type',1455891103),('m160115_170946_create_product_for_bakery',1455891104),('m160115_171146_insert_product_for_bakery',1455891104),('m160116_044933_create_animal_pens',1455891104),('m160116_045209_insert_animal_pens',1455891105),('m160116_051546_create_factories',1455891105),('m160116_051724_insert_factories',1455891106),('m160116_053527_create_bakeries',1455891106),('m160116_053645_insert_bakeries',1455891106),('m160116_161406_create_shop_bakery',1455891107),('m160116_162045_insert_shop_bakery',1455891107),('m160117_065426_create_ref_id_column_in_users',1455891107),('m160117_094110_create_sale_queue_list',1455891107),('m160117_094849_create_user_storage',1455891107),('m160120_061749_create_gifts_table',1455891108),('m160120_062129_create_friend_gifts_table',1455891108),('m160121_091105_create_chat_table',1455891108),('m160123_173421_create_materials_table',1455891109),('m160124_071851_create_support_table',1455891109),('m160124_131039_create_land_items_table',1455891109),('m160125_045945_create_bonus_table',1455891110),('m160125_082628_create_bonus_buy_table',1455891110),('m160125_090329_create_bonus_total_table',1455891110),('m160125_091203_create_paddock_chicken_items',1455891111),('m160125_123044_create_chicken_items',1455891111),('m160127_102222_create_contact_table',1455891112),('m160127_173513_create_paddock_bull_items',1455891112),('m160128_041628_create_bull_items',1455891112),('m160128_042452_create_banner_table',1455891113),('m160128_055721_create_news_comment_like_table',1455891113),('m160128_055821_create_paddock_goat_items',1455891113),('m160128_063239_create_goat_items',1455891114),('m160128_091121_create_paddock_cow_items',1455891114),('m160128_093702_create_cow_items',1455891114),('m160129_092533_create_factory_mince',1455891115),('m160129_092907_create_factory_cheese',1455891115),('m160129_093653_create_factory_curd',1455891115),('m160129_113731_create_meat_bakery',1455891116),('m160129_120158_create_curd_bakery',1455891116),('m160129_120213_create_cheese_bakery',1455891116),('m160201_122248_create_farm_storage',1455891117),('m160201_162834_insert_farm_storage',1455891117),('m160208_052531_create_factory_dough',1455891117),('m160208_104628_create_charity_table',1455891118),('m160208_121300_create_charity_users_table',1455891118),('m160210_100925_create_statistics_table',1455891118),('m160210_104617_insert_statistics',1455891118),('m160211_065342_create_purchase_history',1455891119),('m160214_140101_create_login_history',1455891119),('m160215_173913_create_exchange_table',1455891119),('m160215_180742_insert_exchange_row',1455891120),('m160216_055918_users_news_table',1455891120),('m160218_123234_create_session_table',1455891120),('m160219_100938_create_news_like_table',1455891121),('m160220_095751_create_my_purchase_history',1455962413),('m160229_104339_create_pay_out_table',1456809914),('m160301_053042_create_transfer_history',1456835284),('m160301_061226_create_exchange_history',1456835284);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `my_purchase_history` WRITE;
/*!40000 ALTER TABLE `my_purchase_history` DISABLE KEYS */;
INSERT INTO `my_purchase_history` VALUES (1,98,'feed_chickens',0.00,0,'Покупка корма животных: корм кур'),(2,98,'feed_bulls',0.00,0,'Покупка корма животных: корм бычков'),(3,98,'feed_goats',0.00,0,'Покупка корма животных: корм коз'),(4,98,'feed_cows',0.00,0,'Покупка корма животных: корм коров'),(5,98,'chicken',15.00,3,'Покупка животных: курица'),(6,98,'bull',2000.00,200,'Покупка животных: бычок'),(7,98,'goat',0.00,0,'Покупка животных: коза'),(8,98,'cow',0.00,0,'Покупка животных: корова'),(9,98,'paddock_chickens',20.00,1,'Покупка загона: загон кур'),(10,98,'paddock_bulls',400.00,10,'Покупка загона: загон бычков'),(11,98,'paddock_goats',0.00,0,'Покупка загона: загон коз'),(12,98,'paddock_cows',0.00,0,'Покупка загона: загон коров'),(13,98,'factory_dough',800.00,2,'Покупка фабрики: фабрика теста'),(14,98,'factory_mince',0.00,0,'Покупка фабрики: фабрика фарша'),(15,98,'factory_cheese',800.00,1,'Покупка фабрики: фабрика сыра'),(16,98,'factory_curd',0.00,0,'Покупка фабрики: фабрика творога'),(17,98,'meat_bakery',0.00,0,'Покупка пекарни: пекарня пирога с мясом'),(18,98,'cheese_bakery',2200.00,1,'Покупка перкарни: пекарня пирога с сыром'),(19,98,'curd_bakery',0.00,0,'Покупка пекарни: пекарня пирога с творогом'),(20,99,'feed_chickens',0.00,0,'Покупка корма животных: корм кур'),(21,99,'feed_bulls',0.00,0,'Покупка корма животных: корм бычков'),(22,99,'feed_goats',0.00,0,'Покупка корма животных: корм коз'),(23,99,'feed_cows',0.00,0,'Покупка корма животных: корм коров'),(24,99,'chicken',0.00,0,'Покупка животных: курица'),(25,99,'bull',0.00,0,'Покупка животных: бычок'),(26,99,'goat',0.00,0,'Покупка животных: коза'),(27,99,'cow',0.00,0,'Покупка животных: корова'),(28,99,'paddock_chickens',0.00,0,'Покупка загона: загон кур'),(29,99,'paddock_bulls',0.00,0,'Покупка загона: загон бычков'),(30,99,'paddock_goats',0.00,0,'Покупка загона: загон коз'),(31,99,'paddock_cows',0.00,0,'Покупка загона: загон коров'),(32,99,'factory_dough',0.00,0,'Покупка фабрики: фабрика теста'),(33,99,'factory_mince',0.00,0,'Покупка фабрики: фабрика фарша'),(34,99,'factory_cheese',0.00,0,'Покупка фабрики: фабрика сыра'),(35,99,'factory_curd',0.00,0,'Покупка фабрики: фабрика творога'),(36,99,'meat_bakery',0.00,0,'Покупка пекарни: пекарня пирога с мясом'),(37,99,'cheese_bakery',0.00,0,'Покупка перкарни: пекарня пирога с сыром'),(38,99,'curd_bakery',0.00,0,'Покупка пекарни: пекарня пирога с творогом');
/*!40000 ALTER TABLE `my_purchase_history` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `news_comment_like` WRITE;
/*!40000 ALTER TABLE `news_comment_like` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_comment_like` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `news_comments` WRITE;
/*!40000 ALTER TABLE `news_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_comments` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `news_like` WRITE;
/*!40000 ALTER TABLE `news_like` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_like` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `paddock_bull_items` WRITE;
/*!40000 ALTER TABLE `paddock_bull_items` DISABLE KEYS */;
INSERT INTO `paddock_bull_items` VALUES (1,98,2,5),(2,98,2,6),(3,98,2,7),(4,98,2,8),(5,98,2,9),(6,98,2,10),(7,98,2,11),(8,98,2,12),(9,98,2,13),(10,98,0,14),(11,98,0,15),(12,98,0,16),(13,98,0,17),(14,98,0,18),(15,98,0,19),(16,98,0,20),(17,98,0,21),(18,98,0,22),(19,99,0,5),(20,99,0,6),(21,99,0,7),(22,99,0,8),(23,99,0,9),(24,99,0,10),(25,99,0,11),(26,99,0,12),(27,99,0,13);
/*!40000 ALTER TABLE `paddock_bull_items` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `paddock_chicken_items` WRITE;
/*!40000 ALTER TABLE `paddock_chicken_items` DISABLE KEYS */;
INSERT INTO `paddock_chicken_items` VALUES (1,98,2,1),(2,98,2,2),(3,98,0,3),(4,98,0,4),(5,98,0,5),(6,98,0,6),(7,98,0,7),(8,98,0,8),(9,98,0,9),(10,99,2,1),(11,99,0,2),(12,99,0,3),(13,99,0,4),(14,99,0,5),(15,99,0,6),(16,99,0,7),(17,99,0,8),(18,99,0,9);
/*!40000 ALTER TABLE `paddock_chicken_items` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `paddock_cow_items` WRITE;
/*!40000 ALTER TABLE `paddock_cow_items` DISABLE KEYS */;
INSERT INTO `paddock_cow_items` VALUES (1,98,0,15),(2,98,0,16),(3,98,0,17),(4,98,0,18),(5,98,0,19),(6,98,0,20),(7,98,0,21),(8,98,0,22),(9,98,0,23),(10,99,0,15),(11,99,0,16),(12,99,0,17),(13,99,0,18),(14,99,0,19),(15,99,0,20),(16,99,0,21),(17,99,0,22),(18,99,0,23);
/*!40000 ALTER TABLE `paddock_cow_items` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `paddock_goat_items` WRITE;
/*!40000 ALTER TABLE `paddock_goat_items` DISABLE KEYS */;
INSERT INTO `paddock_goat_items` VALUES (1,98,0,10),(2,98,0,11),(3,98,0,12),(4,98,0,13),(5,98,0,14),(6,98,0,15),(7,98,0,16),(8,98,0,17),(9,98,0,18),(10,99,0,10),(11,99,0,11),(12,99,0,12),(13,99,0,13),(14,99,0,14),(15,99,0,15),(16,99,0,16),(17,99,0,17),(18,99,0,18);
/*!40000 ALTER TABLE `paddock_goat_items` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `pay_in` WRITE;
/*!40000 ALTER TABLE `pay_in` DISABLE KEYS */;
INSERT INTO `pay_in` VALUES (1,'test',NULL,'QIWI',1234.00,NULL,NULL,0),(2,'test',NULL,'freekassa',123.00,NULL,NULL,0),(3,'test',NULL,'Yandex',1234.00,NULL,NULL,0),(4,'test',NULL,'mykassa',1234.00,NULL,NULL,0);
/*!40000 ALTER TABLE `pay_in` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `pay_out` WRITE;
/*!40000 ALTER TABLE `pay_out` DISABLE KEYS */;
/*!40000 ALTER TABLE `pay_out` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `plant` WRITE;
/*!40000 ALTER TABLE `plant` DISABLE KEYS */;
INSERT INTO `plant` VALUES (1,'Пшеница','wheat','Корм кур','sp.png','wheat.png','','',1,0.01,0.037,10,4,2,'Plant'),(2,'Клевер','clover','Корм бычков','skl.png','clover.png','','',5,0.02,0.055,20,4,2,'Plant'),(3,'Капуста','cabbage','Корм коз','sk.png','cabbage.png','','',10,0.04,0.070,30,4,2,'Plant'),(4,'Свекла','beets','Корм коров','ss.png','beet.png','','',15,0.10,0.135,40,4,2,'Plant'),(5,'Поле','land','Поле','','','','',1,2.00,NULL,10,2,1,'Plant');
/*!40000 ALTER TABLE `plant` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `product_for_bakery` WRITE;
/*!40000 ALTER TABLE `product_for_bakery` DISABLE KEYS */;
INSERT INTO `product_for_bakery` VALUES (1,'Тесто','dough','dough_for_sell','313.png',0.45,0.40,70,1000,'ProductForBakery',3,0),(2,'Фарш','mince','mince_for_sell','317.png',0.68,0.63,100,1000,'ProductForBakery',3,0),(3,'Сыр','cheese','cheese_for_sell','312.png',1.06,1.01,100,1000,'ProductForBakery',3,0),(4,'Творог','curd','curd_for_sell','311.png',2.21,2.16,100,1000,'ProductForBakery',3,0);
/*!40000 ALTER TABLE `product_for_bakery` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `purchase_history` WRITE;
/*!40000 ALTER TABLE `purchase_history` DISABLE KEYS */;
INSERT INTO `purchase_history` VALUES (1,'test','chicken',0.00,0,'Покупка животных: курица',0),(2,'test','bull',0.00,0,'Покупка животных: бычок',0),(3,'test','goat',0.00,0,'Покупка животных: коза',0),(4,'test','cow',0.00,0,'Покупка животных: корова',0),(5,'test','paddock_chickens',0.00,0,'Покупка загона: загон кур',0),(6,'test','paddock_bulls',0.00,0,'Покупка загона: загон бычков',0),(7,'test','paddock_goats',0.00,0,'Покупка загона: загон коз',0),(8,'test','paddock_cows',0.00,0,'Покупка загона: загон коров',0),(9,'test','factory_dough',0.00,0,'Покупка фабрики: фабрика теста',0),(10,'test','factory_mince',0.00,0,'Покупка фабрики: фабрика фарша',0),(11,'test','factory_cheese',0.00,0,'Покупка фабрики: фабрика сыра',0),(12,'test','factory_curd',0.00,0,'Покупка фабрики: фабрика творога',0),(13,'test','meat_bakery',0.00,0,'Покупка пекарни: пекарня пирога с мясом',0),(14,'test','cheese_bakery',0.00,0,'Покупка перкарни: пекарня пирога с сыром',0),(15,'test','curd_bakery',0.00,0,'Покупка пекарни: пекарня пирога с творогом',0),(16,'test1','chicken',0.00,0,'Покупка животных: курица',0),(17,'test1','bull',0.00,0,'Покупка животных: бычок',0),(18,'test1','goat',0.00,0,'Покупка животных: коза',0),(19,'test1','cow',0.00,0,'Покупка животных: корова',0),(20,'test1','paddock_chickens',0.00,0,'Покупка загона: загон кур',0),(21,'test1','paddock_bulls',0.00,0,'Покупка загона: загон бычков',0),(22,'test1','paddock_goats',0.00,0,'Покупка загона: загон коз',0),(23,'test1','paddock_cows',0.00,0,'Покупка загона: загон коров',0),(24,'test1','factory_dough',0.00,0,'Покупка фабрики: фабрика теста',0),(25,'test1','factory_mince',0.00,0,'Покупка фабрики: фабрика фарша',0),(26,'test1','factory_cheese',0.00,0,'Покупка фабрики: фабрика сыра',0),(27,'test1','factory_curd',0.00,0,'Покупка фабрики: фабрика творога',0),(28,'test1','meat_bakery',0.00,0,'Покупка пекарни: пекарня пирога с мясом',0),(29,'test1','cheese_bakery',0.00,0,'Покупка перкарни: пекарня пирога с сыром',0),(30,'test1','curd_bakery',0.00,0,'Покупка пекарни: пекарня пирога с творогом',0);
/*!40000 ALTER TABLE `purchase_history` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,98,'cool site',1559664070,1);
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `sale_queue_list` WRITE;
/*!40000 ALTER TABLE `sale_queue_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `sale_queue_list` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `session` WRITE;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` VALUES (1,'cetqks1fae784hhr9k0aulu8r3',NULL,'Главная страница','1559067381'),(2,'9jquq30hhdf0123hbn95hjpr76','test','Главная страница','1559726969'),(3,'',NULL,'Главная страница','1559729234'),(4,'osjfk9s0hklrhorvnr2vvrk5e6',NULL,'Главная страница','1559078110'),(5,'brcssj7os3s9qrl08voqlr90n5',NULL,'Главная страница','1559110317'),(6,'kfn05lu74hplcf77u27j81eks4',NULL,'Главная страница','1559110282'),(7,'badrv94cac57a34qvcfeq6mk20',NULL,'Главная страница','1559115868'),(8,'jhmvcubap1l3g5lp4vr7ko68q1',NULL,'Главная страница','1559123624'),(9,'816bffc8aefce057549f6c5c589df886',NULL,'Главная страница','1559124392'),(10,'7c280a83f9f14fc832239b2c75780f5e',NULL,'Главная страница','1559124419'),(11,'706139c64cef3f8e39f7d0fc6b32c651',NULL,'Главная страница','1559124419'),(12,'3df943d736ac6dcc8a3e4c18abc0d4d6',NULL,'Пользовательское соглашение','1559124434'),(13,'78cdfe4fd538b6c42e494172d33d232b',NULL,'Главная страница','1559128343'),(14,'e5e0831b1edce50384e5ef01f98c5687',NULL,'Главная страница','1559128407'),(15,'1635e44da9238f2378b0b8af78954b44',NULL,'Главная страница','1559129799'),(16,'ec42df135d3ab920f368423d2d7e4eb0',NULL,'Главная страница','1559132207'),(17,'7b31b7047e245327c10619901babd16e',NULL,'Главная страница','1559147829'),(18,'509fe5b0b052b425a48f595053d0439c',NULL,'Главная страница','1559164729'),(19,'0ac0d33ac396861602adaf11093d6740',NULL,'Главная страница','1559180452'),(20,'8ecf260cc15089362152d092ab64ce4b',NULL,'Отзывы','1559210903'),(21,'05fa29c26d9d39e303d2e8c167f55291',NULL,'Отзывы','1559297415'),(22,'u2qaqc1bagl7l9v1ko1tov9ge5',NULL,'Главная страница','1559305641'),(23,'d09d200ef53ca589b954039b9a7de1a6',NULL,'Главная страница','1559348391'),(24,'0230e573fe904caa35a6b81fc348a796',NULL,'Главная страница','1559348393'),(25,'9bed4e2479ac73ec6059ff3606f19203',NULL,'Главная страница','1559348395'),(26,'3a795dd1ef87f2f6148a871691acfe82',NULL,'Главная страница','1559348396'),(27,'e7023a188a2f20537c0a8fcf0413b0af',NULL,'Главная страница','1559348397'),(28,'8dced40ce39790d441061ab82fe8506b',NULL,'Главная страница','1559348399'),(29,'2ba7ff2f332ab416356b0259a61b816f',NULL,'Отзывы','1559383892'),(30,'qenfnfrd4u6inciuaq3oo5kb11',NULL,'Главная страница','1559419545'),(31,'af96a76fb84e720a4c8e1fb291a02a47',NULL,'Отзывы','1559470374'),(32,'a6ed3d883ecec332f577c65a3cd663ef',NULL,'Главная страница','1559503113'),(33,'7270f4bc31b08943cb9b9e511ee260b5',NULL,'Отзывы','1559556792'),(34,'klns5d2e1vvig1msjlmvbjic06',NULL,'Главная страница','1559633789'),(35,'291b7b50c4aae204345b2cd4d83e4783',NULL,'Отзывы','1559643297'),(36,'45s47giintbcboji6ur54qag04',NULL,'Главная страница','1559648275'),(37,'1ju2pnho7kjotdp638o3vo9d23',NULL,'Главная страница','1559648359'),(38,'2rsksv1amnu7j6dvh0r9g3va87','test1','Рекламные материалы','1559648443'),(39,'f5862388c67517e44333335e59c6bea0',NULL,'Отзывы','1559729776'),(40,'3d0c87b88a4e16813330779878cc4d41',NULL,'Главная страница','1559733225');
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `shop_bakery` WRITE;
/*!40000 ALTER TABLE `shop_bakery` DISABLE KEYS */;
INSERT INTO `shop_bakery` VALUES (1,'Пирог с мясом','cakewithmeat','cakewithmeat_for_sell','pm.png',1.09,1.10,1,1000,'ShopBakery',1,1,110),(2,'Пирог с сыром','cakewithcheese','cakewithcheese_for_sell','ps.png',1.59,1.60,1,1000,'ShopBakery',1,1,160),(3,'Пирог с творогом','cakewithcurd','cakewithcurd_for_sell','pt.png',2.89,2.90,1,1000,'ShopBakery',1,1,290);
/*!40000 ALTER TABLE `shop_bakery` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES (1,'Ферма','',1,10,NULL);
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `statistics` WRITE;
/*!40000 ALTER TABLE `statistics` DISABLE KEYS */;
INSERT INTO `statistics` VALUES (1,'0:0.00','0:0.00','0:0.00','0:0.00','0:0.00','5784:318.12','1459726:87583.56','611605:29540.768','3475:312.75','2181:152.67','858760:77288.4','374970:35146.218','2098:335.68','2437:328.995','565098:90415.68','198072:25627.815','52600:11046','75478:13586.04','6537745:1372926.45','10122677:1822081.86','31500:11025','43457:13906.24','3962093.5:1386732.725','6070953:1942704.96','27400:16166','25300:14168','2432653:1435265.27','3311549:1854467.44','10300:13184','15770:19712.5','1361208:1742346.24','2572127:3215158.75','2380:1071','36000:14400','924427:415992.15','4130000:1652000','4600:3128','17800:11214','1119336:761148.48','2537000:1598310','2000:2120','17600:17776','502350:532491','1541400:1556814','800:1768','5400:11664','168700:372827','860800:1859328','679:3395','197473:987365','687:6870','114431:1144310','274:5480','62130:1242600','279:13950','48612:2430600','7:140','7567:151340','16:640','4838:193520','4:240','2496:189880','2:300','1780:267000','3:1200','274:109600','1:600','181:108600','1:800','131:104800','0:0.00','77:138600','0:0.00','90:135000','1:2200','43:94600','0:0.00','29:92800','49776:99552');
/*!40000 ALTER TABLE `statistics` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `support` WRITE;
/*!40000 ALTER TABLE `support` DISABLE KEYS */;
/*!40000 ALTER TABLE `support` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `transfer_history` WRITE;
/*!40000 ALTER TABLE `transfer_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `transfer_history` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','yVC_SGYouvgTkkrCHuEqH3y1OX3cGeTl','$2y$13$8gDhGCZzVMH6uGoOZMseFux2YFJPQYiMdze703Y7jRdYv1pJqXrC.',NULL,'ferma@gmail.com',10,1,0,1559634312,'','',1,'1970-12-01','','','','9eb60bc8bf2b004e4db7d1cc0d5f1d8c.png',3,0.00,80541.46,4444,27,243,'',1,1,0,0.00,'',0,0,'',80,1425049591,1460023242,'127.0.0.1','92.46.21.40',0,0.00,'Главная страница',1462245100,0),(98,'test','LOAKEKRerbEnwWcahmUXjDw6Nll7rI3p','$2y$13$uSvPB/CBuT6AA7oTwzzrjupOsTgPgr6V/S8HFOwmYRE50GXMd3Mey',NULL,'test@test.com',10,3,1559067411,1559634312,'','',1,NULL,'','','','ava.png',55,43648.79,50000.00,6340,163,49735,'',1,1,0,0.00,NULL,1,0,NULL,2510,1559067410,1559648318,'91.234.78.218','91.210.10.6',0,0.00,'Главная страница',1559726969,0),(99,'test1','qtV-JS6sLC6DGLwlOMOc41-9qvEhNFJA','$2y$13$SengZoTz0vp/8cJsrgaeCOwMbnSx5A/qQK5jJmGccN3oK/Q54ZLM6',NULL,'test1@twtw.wi',10,3,1559648300,1559648300,'','',1,NULL,'','','','ava.png',1,0.00,0.00,4828,0,100,'',1,1,0,0.00,NULL,1,0,NULL,10,1559648299,1559648370,'91.210.10.6','91.210.10.6',0,0.00,'Рекламные материалы',1559648443,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `user_storage` WRITE;
/*!40000 ALTER TABLE `user_storage` DISABLE KEYS */;
INSERT INTO `user_storage` VALUES (1,98,0,0,0,0,2,185,0,0,4,0,0,1,0,0,0,0,4,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(2,99,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `user_storage` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `users_news` WRITE;
/*!40000 ALTER TABLE `users_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_news` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `wall_comments` WRITE;
/*!40000 ALTER TABLE `wall_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `wall_comments` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `wall_post` WRITE;
/*!40000 ALTER TABLE `wall_post` DISABLE KEYS */;
/*!40000 ALTER TABLE `wall_post` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

