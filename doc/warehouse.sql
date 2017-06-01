# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.1.20-MariaDB)
# Database: warehouse
# Generation Time: 2017-06-01 13:51:55 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table article
# ------------------------------------------------------------

DROP TABLE IF EXISTS `article`;

CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `primary_ean` varchar(255) DEFAULT NULL,
  `secondary_ean` varchar(255) DEFAULT NULL,
  `description` text,
  `category_id` int(11) NOT NULL,
  `producer_product_code` varchar(255) DEFAULT NULL,
  `purchase_price` decimal(14,2) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `measurement_unit` varchar(255) DEFAULT NULL,
  `primary_supplier_id` int(11) DEFAULT NULL,
  `vat_rate` decimal(4,2) DEFAULT NULL,
  `sale_price` decimal(14,2) DEFAULT NULL,
  `weight` decimal(14,2) DEFAULT NULL,
  `height` decimal(14,2) DEFAULT NULL,
  `width` decimal(14,2) DEFAULT NULL,
  `length` decimal(14,2) DEFAULT NULL,
  `factor` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `type` enum('product','service') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_article_company1_idx` (`company_id`),
  KEY `fk_article_category1_idx` (`category_id`),
  KEY `fk_article_partner1_idx` (`primary_supplier_id`),
  CONSTRAINT `fk_article_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_article_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_article_partner1` FOREIGN KEY (`primary_supplier_id`) REFERENCES `partner` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;

INSERT INTO `article` (`id`, `company_id`, `name`, `primary_ean`, `secondary_ean`, `description`, `category_id`, `producer_product_code`, `purchase_price`, `brand`, `measurement_unit`, `primary_supplier_id`, `vat_rate`, `sale_price`, `weight`, `height`, `width`, `length`, `factor`, `is_active`, `type`)
VALUES
	(2,1,'SmartRobby 2000','','',NULL,12,'',NULL,'',NULL,17,0.00,1999.00,0.00,0.00,0.00,0.00,'',NULL,NULL),
	(22,1,'Zāles pļāvējs Bosch Rotak RT600','4752221112221','','Zāles pļāvējs Bosch Rotak RT600, 56cm, 1500cc, pašgājējs',12,'RT600',111.11,'Bosch','pc',22,21.00,199.99,23.00,0.55,0.55,0.90,'1',NULL,NULL),
	(32,1,'Robots zāles pļāvējs SmartRobby Advanced +','4752221115555','',' Robots zāles pļāvējs SmartRobby Advanced +, 2600m2, 6,6Ah Lion batereja, 100m vads, 100 tapas, 10 konektori komplektā.',12,'SR_20',777.00,'SmartRobby','pc',17,21.00,1495.00,19.00,0.45,0.45,0.80,'1',NULL,NULL),
	(62,1,'fghfcg','Marcis','hffhfc','jgjgv',92,'jfjg',111.11,'aaa','pc',17,21.00,111111.00,0.00,0.00,0.00,0.00,'1',NULL,NULL),
	(72,1,'Figūrzāģis 400W BJS400 BESK','4750959018156','','Elektriskais figūrzāģis, 230V / 50 Hz, 400W, slodzes ātrums 0-3000r/min, griešanas dziļums 55mm. CE sertifikāts',122,'BJS400',13.69,'BESK','pc',32,21.00,19.00,2.00,0.20,0.40,0.60,'4',NULL,NULL),
	(82,1,'Skrūvgriezis ar akum. 2x14.4V 10mm BESK','4750959018132','','Abpusēja urbjmašīna - skrūvgrieznis ar akumulatoru, 14.4V, 1.2Ah, NiCd, Bez atslēgas urbjpatrona 0,8-10mm, 0-550r/min (ātrums), 3-5 stundas max, 2 baterijas. CE sertifikāts.',132,'AAA',25.27,'BESK','pc',32,21.00,39.99,1.00,1.00,1.00,1.00,'4',NULL,NULL),
	(83,1,'Zāles pļāvējs Bosch Rotak RT600','4752221112221','','Zāles pļāvējs Bosch Rotak RT600, 56cm, 1500cc, pašgājējs',122,'RT600',111.11,'Bosch','pc',22,21.00,199.99,23.00,0.55,0.55,0.90,'1',NULL,NULL);

/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table brand
# ------------------------------------------------------------

DROP TABLE IF EXISTS `brand`;

CREATE TABLE `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `producer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_brand_company1_idx` (`company_id`),
  CONSTRAINT `fk_brand_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `brand` WRITE;
/*!40000 ALTER TABLE `brand` DISABLE KEYS */;

INSERT INTO `brand` (`id`, `company_id`, `name`, `producer`)
VALUES
	(1,1,'Samsung',NULL),
	(4,1,'Bosch',NULL),
	(5,1,'SmartRobby',NULL);

/*!40000 ALTER TABLE `brand` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category_company1_idx` (`company_id`),
  KEY `fk_category_category1_idx` (`parent_id`),
  CONSTRAINT `fk_category_category1` FOREIGN KEY (`parent_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_category_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;

INSERT INTO `category` (`id`, `name`, `company_id`, `parent_id`)
VALUES
	(1,'Zāles pļāvēji',1,NULL),
	(12,'Roboti zāles pļāvēji',1,1),
	(22,'Mauriņa traktori',1,NULL),
	(32,'Zāles pļāvēju piederumi',1,1),
	(42,'Trimmeri, krūmgrieži',1,1),
	(52,'Bezvadu dārza instrumenti',1,NULL),
	(62,'Ķēdes zāģi',1,112),
	(72,'Zaru smalcinātāji',1,NULL),
	(82,'Dārza sūkņi',1,NULL),
	(92,'Lapu pūtēji',1,52),
	(102,'Lapu suceji',1,52),
	(112,'Elektroinstrumenti',1,NULL),
	(122,'Figūrzāģi',1,112),
	(132,'Ripzāģi',1,112),
	(133,'Parastie Zales Plaveji',1,1);

/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table company
# ------------------------------------------------------------

DROP TABLE IF EXISTS `company`;

CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;

INSERT INTO `company` (`id`, `name`)
VALUES
	(1,'SmartRobby');

/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table document
# ------------------------------------------------------------

DROP TABLE IF EXISTS `document`;

CREATE TABLE `document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `ref` varchar(255) DEFAULT NULL,
  `total_net` decimal(14,2) DEFAULT NULL,
  `total_vat` decimal(14,2) DEFAULT NULL,
  `total_gross` decimal(14,2) DEFAULT NULL,
  `currency` char(3) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_document_company1_idx` (`company_id`),
  CONSTRAINT `fk_document_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `document` WRITE;
/*!40000 ALTER TABLE `document` DISABLE KEYS */;

INSERT INTO `document` (`id`, `company_id`, `type`, `date`, `ref`, `total_net`, `total_vat`, `total_gross`, `currency`, `status`)
VALUES
	(1,1,'purchase','2017-05-01','INV1',NULL,NULL,NULL,'USD','posted'),
	(3,1,'sale','2017-05-05','SL12',NULL,NULL,NULL,'EUR','draft'),
	(12,1,'purchase','2017-05-30','DIA 001100',NULL,NULL,NULL,'EUR','validated'),
	(22,1,'purchase','2017-05-22','DIA222222',NULL,NULL,NULL,'EUR','posted'),
	(32,1,'sale','2017-05-30','SR1122',NULL,NULL,NULL,'EUR','draft');

/*!40000 ALTER TABLE `document` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table invoice
# ------------------------------------------------------------

DROP TABLE IF EXISTS `invoice`;

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `partner_id` int(11) NOT NULL,
  `ref` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_document1_idx` (`document_id`),
  KEY `fk_invoice_contact1_idx` (`partner_id`),
  CONSTRAINT `fk_invoice_document1` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_invoice_partner1` FOREIGN KEY (`partner_id`) REFERENCES `partner` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `invoice` WRITE;
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;

INSERT INTO `invoice` (`id`, `document_id`, `partner_id`, `ref`)
VALUES
	(3,3,18,NULL),
	(12,12,32,NULL),
	(22,22,32,NULL),
	(32,32,18,NULL);

/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table line
# ------------------------------------------------------------

DROP TABLE IF EXISTS `line`;

CREATE TABLE `line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qty` int(11) DEFAULT NULL,
  `article_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `price` decimal(14,2) DEFAULT NULL,
  `vat_rate` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_line_article1_idx` (`article_id`),
  KEY `fk_line_document1_idx` (`document_id`),
  CONSTRAINT `fk_line_article1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_line_document1` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `line` WRITE;
/*!40000 ALTER TABLE `line` DISABLE KEYS */;

INSERT INTO `line` (`id`, `qty`, `article_id`, `document_id`, `price`, `vat_rate`)
VALUES
	(2,4,2,1,10.00,21.10),
	(12,4,72,22,10.00,21.00),
	(22,4,72,22,20.00,21.00);

/*!40000 ALTER TABLE `line` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table partner
# ------------------------------------------------------------

DROP TABLE IF EXISTS `partner`;

CREATE TABLE `partner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_producer` tinyint(1) DEFAULT NULL,
  `is_supplier` tinyint(1) DEFAULT NULL,
  `is_client` tinyint(1) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `reg_nr` varchar(255) DEFAULT NULL,
  `vat_nr` varchar(255) DEFAULT NULL,
  `address` text,
  `bank_name` text,
  `bank_swift` varchar(255) DEFAULT NULL,
  `bank_iban` varchar(255) DEFAULT NULL,
  `bank_extra` text,
  `contact_info` text,
  `subsidiary_of_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contact_company1_idx` (`company_id`),
  KEY `fk_partner_partner1_idx` (`subsidiary_of_id`),
  CONSTRAINT `fk_partner_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_partner_partner1` FOREIGN KEY (`subsidiary_of_id`) REFERENCES `partner` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `partner` WRITE;
/*!40000 ALTER TABLE `partner` DISABLE KEYS */;

INSERT INTO `partner` (`id`, `company_id`, `name`, `is_producer`, `is_supplier`, `is_client`, `phone`, `reg_nr`, `vat_nr`, `address`, `bank_name`, `bank_swift`, `bank_iban`, `bank_extra`, `contact_info`, `subsidiary_of_id`)
VALUES
	(17,1,'SmartRoby SIA',0,1,0,'','','',NULL,'','','',NULL,NULL,NULL),
	(18,1,'Romans',0,0,1,'','','',NULL,'','','',NULL,NULL,NULL),
	(19,1,'Bosch',1,NULL,NULL,'','','',NULL,'','','',NULL,NULL,NULL),
	(22,1,'Robert Bosch SIA',NULL,1,NULL,'88888888','893274892374','LV04590-57349','AAAAAAAAAAAA','Swed','SSSS','HABA-BLABLA',NULL,'Janis',NULL),
	(32,1,'DIANA SIA',NULL,1,NULL,'+371 63622991','11111111111','LV11111111111','Andreja 5','SwedBank','HABA22LV','HABA-BLABLA',NULL,'Janis',NULL);

/*!40000 ALTER TABLE `partner` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table production
# ------------------------------------------------------------

DROP TABLE IF EXISTS `production`;

CREATE TABLE `production` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `destination_stock_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_production_document1_idx` (`document_id`),
  KEY `fk_production_stock1_idx` (`destination_stock_id`),
  CONSTRAINT `fk_production_document1` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_production_stock1` FOREIGN KEY (`destination_stock_id`) REFERENCES `stock` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table related
# ------------------------------------------------------------

DROP TABLE IF EXISTS `related`;

CREATE TABLE `related` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_related_document1_idx` (`document_id`),
  KEY `fk_related_stock1_idx` (`stock_id`),
  CONSTRAINT `fk_related_document1` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_related_stock1` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `related` WRITE;
/*!40000 ALTER TABLE `related` DISABLE KEYS */;

INSERT INTO `related` (`id`, `document_id`, `stock_id`)
VALUES
	(2,1,12),
	(12,1,22),
	(22,22,32),
	(32,22,42);

/*!40000 ALTER TABLE `related` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table stock
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stock`;

CREATE TABLE `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `article_id` int(11) NOT NULL,
  `qty_increase` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_stock_article1_idx` (`article_id`),
  CONSTRAINT `fk_stock_article1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `stock` WRITE;
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;

INSERT INTO `stock` (`id`, `type`, `article_id`, `qty_increase`, `date`, `description`)
VALUES
	(1,'inventory',2,10,'2017-05-02',NULL),
	(2,'inventory',2,5,'2017-05-01',NULL),
	(3,'write-off',2,-3,'2017-05-01',NULL),
	(4,'inventory',2,60,'2017-05-18',NULL),
	(5,'inventory',2,1,'2017-05-01',NULL),
	(6,'inventory',2,-30,'2017-05-24','perished'),
	(12,'effect',2,4,'2017-05-30','Invoice INV1 now live'),
	(22,'effect',2,4,'2017-05-30','Invoice INV1 now live'),
	(32,'effect',72,4,'2017-05-30','Invoice DIA222222 now live'),
	(42,'effect',72,4,'2017-05-30','Invoice DIA222222 now live'),
	(52,'inventory',72,5,'2017-05-30',''),
	(62,'inventory',72,-5,'2017-05-30','');

/*!40000 ALTER TABLE `stock` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_company_idx` (`company_id`),
  CONSTRAINT `fk_user_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `company_id`, `email`, `password`)
VALUES
	(1,1,'test','test');

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
