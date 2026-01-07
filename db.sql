/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.1.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: GESTION_VENTE_VIN
-- ------------------------------------------------------
-- Server version	12.1.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `CLIENT`
--

DROP TABLE IF EXISTS `CLIENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `CLIENT` (
  `num_client` varchar(25) NOT NULL,
  `type_client` char(100) NOT NULL,
  `nom_client` char(100) NOT NULL,
  `adresse_client` char(100) NOT NULL,
  `telephone_client` varchar(25) NOT NULL,
  `email_client` char(100) NOT NULL,
  PRIMARY KEY (`num_client`),
  UNIQUE KEY `num_client` (`num_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CLIENT`
--

LOCK TABLES `CLIENT` WRITE;
/*!40000 ALTER TABLE `CLIENT` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `CLIENT` VALUES
('CLI-001','Detaillant','Kenainy','Ankofafa','032555773','kenainy@gmail.com'),
('CLI-002','Consommateur','Mario','ISADA','0331808985','mario@gmail.com'),
('CLI-003','Consommateur','Rakoto','Antaradolo','0342518945','rakoto@gmail.com'),
('CLI-004','Grossiste','Isaia','Andrainjato','0381244690','isaia@gmail.com'),
('CLI-005','Grossiste','Jeremie','Anjoma','0345678923','jeremie@gmail.com'),
('CLI-006','Detaillant','Vanillien','Sahalava','0330732719','kimsey@gmail.com'),
('CLI-007','Detaillant','Mika','Ampasabazaha','0345623457','elkami@gmail.com'),
('CLI-008','Detaillant','Johny','Tanambao','0325678912','jackson@gmail.com'),
('CLI-009','Grossiste','Narovana','isaha','0325678912','kilonga@gmail.com'),
('CLI-010','Consommateur','Andry','Ambalapaiso','0340947823','rado@gmail.com'),
('CLI-011','Detaillant','Rabenja','Mahamanina','0345672943','benja@gmail.com');
/*!40000 ALTER TABLE `CLIENT` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `COMMANDE`
--

DROP TABLE IF EXISTS `COMMANDE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `COMMANDE` (
  `num_bon_commande` varchar(25) NOT NULL,
  `date_commande` date NOT NULL,
  `statut` char(100) NOT NULL,
  `num_client` varchar(25) NOT NULL,
  PRIMARY KEY (`num_bon_commande`),
  UNIQUE KEY `num_bon_commande` (`num_bon_commande`),
  KEY `num_client` (`num_client`),
  CONSTRAINT `COMMANDE_ibfk_1` FOREIGN KEY (`num_client`) REFERENCES `CLIENT` (`num_client`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `COMMANDE`
--

LOCK TABLES `COMMANDE` WRITE;
/*!40000 ALTER TABLE `COMMANDE` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `COMMANDE` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `FACTURE`
--

DROP TABLE IF EXISTS `FACTURE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `FACTURE` (
  `num_facture` varchar(25) NOT NULL,
  `date_facture` date NOT NULL,
  `num_client` varchar(25) NOT NULL,
  `montant_total` int(11) NOT NULL,
  PRIMARY KEY (`num_facture`),
  KEY `num_client` (`num_client`),
  CONSTRAINT `FACTURE_ibfk_1` FOREIGN KEY (`num_client`) REFERENCES `CLIENT` (`num_client`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `FACTURE`
--

LOCK TABLES `FACTURE` WRITE;
/*!40000 ALTER TABLE `FACTURE` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `FACTURE` VALUES
('FAC-001','2025-11-14','CLI-001',174000),
('FAC-002','2025-11-14','CLI-003',877000),
('FAC-003','2025-11-14','CLI-006',948000),
('FAC-004','2025-11-14','CLI-004',650000),
('FAC-005','2025-11-14','CLI-008',680000),
('FAC-006','2025-11-14','CLI-010',36000),
('FAC-007','2025-11-14','CLI-005',45000),
('FAC-008','2025-11-14','CLI-007',500000),
('FAC-009','2025-11-14','CLI-002',360000),
('FAC-010','2025-11-14','CLI-009',400000);
/*!40000 ALTER TABLE `FACTURE` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `LIGNE_COMMANDE`
--

DROP TABLE IF EXISTS `LIGNE_COMMANDE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `LIGNE_COMMANDE` (
  `num_produit` varchar(25) NOT NULL,
  `num_commande` varchar(25) NOT NULL,
  `quantite` int(11) NOT NULL,
  PRIMARY KEY (`num_produit`,`num_commande`),
  KEY `num_commande` (`num_commande`),
  CONSTRAINT `LIGNE_COMMANDE_ibfk_1` FOREIGN KEY (`num_commande`) REFERENCES `COMMANDE` (`num_bon_commande`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `LIGNE_COMMANDE_ibfk_2` FOREIGN KEY (`num_produit`) REFERENCES `PRODUIT` (`num_produit`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LIGNE_COMMANDE`
--

LOCK TABLES `LIGNE_COMMANDE` WRITE;
/*!40000 ALTER TABLE `LIGNE_COMMANDE` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `LIGNE_COMMANDE` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `LIGNE_FACTURE`
--

DROP TABLE IF EXISTS `LIGNE_FACTURE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `LIGNE_FACTURE` (
  `num_facture` varchar(25) NOT NULL,
  `num_produit` varchar(25) NOT NULL,
  `quantite` int(11) NOT NULL,
  PRIMARY KEY (`num_facture`,`num_produit`),
  KEY `num_produit` (`num_produit`),
  CONSTRAINT `LIGNE_FACTURE_ibfk_1` FOREIGN KEY (`num_facture`) REFERENCES `FACTURE` (`num_facture`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `LIGNE_FACTURE_ibfk_2` FOREIGN KEY (`num_produit`) REFERENCES `PRODUIT` (`num_produit`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LIGNE_FACTURE`
--

LOCK TABLES `LIGNE_FACTURE` WRITE;
/*!40000 ALTER TABLE `LIGNE_FACTURE` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `LIGNE_FACTURE` VALUES
('FAC-001','PRO-001',2),
('FAC-001','PRO-003',10),
('FAC-001','PRO-004',2),
('FAC-002','PRO-001',10),
('FAC-002','PRO-003',1),
('FAC-002','PRO-005',12),
('FAC-002','PRO-009',20),
('FAC-002','PRO-010',12),
('FAC-003','PRO-002',2),
('FAC-003','PRO-016',12),
('FAC-003','PRO-017',30),
('FAC-004','PRO-005',50),
('FAC-005','PRO-010',12),
('FAC-005','PRO-016',20),
('FAC-006','PRO-010',2),
('FAC-007','PRO-009',3),
('FAC-008','PRO-012',15),
('FAC-008','PRO-013',10),
('FAC-009','PRO-008',12),
('FAC-010','PRO-002',40);
/*!40000 ALTER TABLE `LIGNE_FACTURE` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `PRODUIT`
--

DROP TABLE IF EXISTS `PRODUIT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `PRODUIT` (
  `num_produit` varchar(25) NOT NULL,
  `design` char(100) NOT NULL,
  `nombre` int(11) NOT NULL,
  `prix_detaillant` int(11) NOT NULL,
  `prix_consommateur` int(11) NOT NULL,
  `prix_gros` int(11) NOT NULL,
  PRIMARY KEY (`num_produit`),
  UNIQUE KEY `num_produit` (`num_produit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PRODUIT`
--

LOCK TABLES `PRODUIT` WRITE;
/*!40000 ALTER TABLE `PRODUIT` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `PRODUIT` VALUES
('PRO-001','VIN BLANC L 75CL',40,12000,11000,10000),
('PRO-002','VIN ROSE L',160,12000,11000,10000),
('PRO-003','VIN GRIS L 75CL',39,12000,11000,11000),
('PRO-004','VIN ROUGE 75CL',123,15000,13000,12000),
('PRO-005','VIN GRIS FHORM 75CL',60,17000,15000,13000),
('PRO-006','VIN ROUGE PRESTIGE',60,17000,15000,13000),
('PRO-007','VIN BLANC SPECIAL',69,17000,15000,13000),
('PRO-008','VIN MOUSSEUX',53,35000,30000,28000),
('PRO-009','VIN BLANC MOUELLEUX',57,20000,18000,15000),
('PRO-010','VIN APERITIF (au coco)',116,20000,18000,15000),
('PRO-011','VIN ROUGE DOUX (Nature)',45,20000,18000,15000),
('PRO-012','APERITIF LETCHIS',41,20000,18000,15000),
('PRO-013','APERITIF TAPIA',80,20000,18000,15000),
('PRO-014','APERITIF VOAROY',30,20000,18000,15000),
('PRO-015','EAU DE VIVE DE VIN',75,22000,20000,18000),
('PRO-016','LIQUEUR A L\'ORANGE',18,22000,20000,18000),
('PRO-017','LIQUEUR A LA MANDARINE',170,22000,20000,18000),
('PRO-018','VIN APERITIF (au coco)',80,1000,1000,899);
/*!40000 ALTER TABLE `PRODUIT` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `REGLEMENT`
--

DROP TABLE IF EXISTS `REGLEMENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `REGLEMENT` (
  `num_reglement` varchar(25) NOT NULL,
  `num_facture` varchar(25) NOT NULL,
  `date_reglement` date NOT NULL,
  `mode_paiement` varchar(25) NOT NULL,
  `montant_reglement` int(11) NOT NULL,
  `nom_personne_reglement` char(100) NOT NULL,
  PRIMARY KEY (`num_reglement`),
  KEY `num_facture` (`num_facture`),
  CONSTRAINT `REGLEMENT_ibfk_1` FOREIGN KEY (`num_facture`) REFERENCES `FACTURE` (`num_facture`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `REGLEMENT`
--

LOCK TABLES `REGLEMENT` WRITE;
/*!40000 ALTER TABLE `REGLEMENT` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `REGLEMENT` VALUES
('REG-001','FAC-001','2025-11-14','Cheque',10000,'Kenainy'),
('REG-002','FAC-002','2025-11-14','Espece',20000,'Rakoto'),
('REG-003','FAC-001','2025-11-20','Carte',40000,'Kenainy'),
('REG-004','FAC-002','2025-11-14','Cheque',300000,'Rakoto'),
('REG-005','FAC-003','2025-11-14','Cheque',670000,'Vanillien'),
('REG-006','FAC-001','2025-11-14','Espece',12000,'Kenainy'),
('REG-007','FAC-004','2025-11-14','Cheque',650000,'Isaia'),
('REG-008','FAC-005','2025-11-14','Espece',680000,'Johny'),
('REG-009','FAC-006','2025-11-14','Espece',36000,'Andry'),
('REG-010','FAC-007','2025-11-14','Cheque',45000,'Jeremie'),
('REG-011','FAC-008','2025-11-14','Carte',40000,'Mika'),
('REG-012','FAC-009','2025-11-14','Cheque',360000,'Mario'),
('REG-013','FAC-010','2025-11-14','Cheque',200000,'Narovana'),
('REG-014','FAC-003','2025-11-15','Carte',100000,'Vanillien');
/*!40000 ALTER TABLE `REGLEMENT` ENABLE KEYS */;
UNLOCK TABLES;
commit;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-01-06 22:56:31
