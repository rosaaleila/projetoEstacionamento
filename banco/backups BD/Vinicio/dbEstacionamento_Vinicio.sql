CREATE DATABASE  IF NOT EXISTS `dbfastparking` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `dbfastparking`;
-- MySQL dump 10.13  Distrib 8.0.20, for Win64 (x86_64)
--
-- Host: localhost    Database: dbfastparking
-- ------------------------------------------------------
-- Server version	8.0.20

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
-- Table structure for table `tblcliente`
--

DROP TABLE IF EXISTS `tblcliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblcliente` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `documento` varchar(25) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcliente`
--

LOCK TABLES `tblcliente` WRITE;
/*!40000 ALTER TABLE `tblcliente` DISABLE KEYS */;
INSERT INTO `tblcliente` VALUES (1,'Vinicio','01.000.000.00','11 98005-4891','viniciojesus@gmail.com'),(2,'Ricardo','02.000.000.00','11 88335-7891','eduardojesus@gmail.com'),(3,'Ricardo','03.000.000.00','11 77335-7891','ricardo@gmail.com'),(4,'Leandro','04.000.000.00','11 67335-7891','leandro@gmail.com'),(6,'Joao','06.000.000.00','11 75943-7891','joao@gmail.com'),(7,'jandkasj','06.000.000.00','11 46975-7891','jlaks@gmail.com'),(9,'Carlos','99.666.000.00','11 95765-7823','Carlos@gmail.com');
/*!40000 ALTER TABLE `tblcliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbldia`
--

DROP TABLE IF EXISTS `tbldia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbldia` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbldia`
--

LOCK TABLES `tbldia` WRITE;
/*!40000 ALTER TABLE `tbldia` DISABLE KEYS */;
INSERT INTO `tbldia` VALUES (1,'Domingo'),(2,'Segunda-feira'),(3,'Terça-feira'),(4,'Quarta-feira'),(5,'Quinta-feira'),(6,'Sexta-feira'),(7,'Sábado');
/*!40000 ALTER TABLE `tbldia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblemail_estacionamento`
--

DROP TABLE IF EXISTS `tblemail_estacionamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblemail_estacionamento` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `idEstacionamento` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_Email_Estacionamento` (`idEstacionamento`),
  CONSTRAINT `FK_Email_Estacionamento` FOREIGN KEY (`idEstacionamento`) REFERENCES `tblestacionamento` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblemail_estacionamento`
--

LOCK TABLES `tblemail_estacionamento` WRITE;
/*!40000 ALTER TABLE `tblemail_estacionamento` DISABLE KEYS */;
INSERT INTO `tblemail_estacionamento` VALUES (2,'vinicio@gmaisl.com',1),(3,'joao@gmail.com',3);
/*!40000 ALTER TABLE `tblemail_estacionamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblestacionamento`
--

DROP TABLE IF EXISTS `tblestacionamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblestacionamento` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `logradouro` varchar(100) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `bairro` varchar(80) NOT NULL,
  `cidade` varchar(60) NOT NULL,
  `estado` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblestacionamento`
--

LOCK TABLES `tblestacionamento` WRITE;
/*!40000 ALTER TABLE `tblestacionamento` DISABLE KEYS */;
INSERT INTO `tblestacionamento` VALUES (1,'Fast Parking','AV. Monteiro Lobato','4250','07180-000','Cidade Jardim Cumbica','Guarulhos','São Paulo'),(2,'Fast Parking','AV. Monteiro Lobato','4250','07180-000','Cidade Jardim Cumbica','Guarulhos','São Paulo'),(3,'Fast Parking','AV. Monteiro Lobato','4250','07180-000','Cidade Jardim Cumbica','Guarulhos','São Paulo'),(4,'Fast Parking','AV. Monteiro Lobato','4250','07180-000','Cidade Jardim Cumbica','Guarulhos','São Paulo');
/*!40000 ALTER TABLE `tblestacionamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblfuncionamento`
--

DROP TABLE IF EXISTS `tblfuncionamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblfuncionamento` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `horaAbertura` time NOT NULL,
  `horaFechamento` time NOT NULL,
  `idEstacionamento` int unsigned NOT NULL,
  `idDia` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_Funcionamento_Dia` (`idDia`),
  KEY `FK_Funcionamento_Estacionamento` (`idEstacionamento`),
  CONSTRAINT `FK_Funcionamento_Dia` FOREIGN KEY (`idDia`) REFERENCES `tbldia` (`id`),
  CONSTRAINT `FK_Funcionamento_Estacionamento` FOREIGN KEY (`idEstacionamento`) REFERENCES `tblestacionamento` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblfuncionamento`
--

LOCK TABLES `tblfuncionamento` WRITE;
/*!40000 ALTER TABLE `tblfuncionamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblfuncionamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblplano`
--

DROP TABLE IF EXISTS `tblplano`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblplano` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `primeiraHora` float NOT NULL,
  `horasAdicionais` float NOT NULL,
  `diaria` float NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblplano`
--

LOCK TABLES `tblplano` WRITE;
/*!40000 ALTER TABLE `tblplano` DISABLE KEYS */;
INSERT INTO `tblplano` VALUES (1,'Bronze',20,15,300),(2,'Barro',25,5,105),(5,'Teste',22,4,1000),(6,'Teste',22,4,1000),(7,'Teste',22,4,1000),(8,'Teste',22,4,1000);
/*!40000 ALTER TABLE `tblplano` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblregistro`
--

DROP TABLE IF EXISTS `tblregistro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblregistro` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `horaEntrada` time NOT NULL,
  `horaSaida` time DEFAULT NULL,
  `precoFinal` float DEFAULT NULL,
  `diaEntrada` date NOT NULL,
  `diaSaida` date DEFAULT NULL,
  `idVagas` int unsigned NOT NULL,
  `idVeiculo` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_Registro_Vagas` (`idVagas`),
  KEY `FK_Registro_Veiculo` (`idVeiculo`),
  CONSTRAINT `FK_Registro_Vagas` FOREIGN KEY (`idVagas`) REFERENCES `tblvagas` (`id`),
  CONSTRAINT `FK_Registro_Veiculo` FOREIGN KEY (`idVeiculo`) REFERENCES `tblveiculo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblregistro`
--

LOCK TABLES `tblregistro` WRITE;
/*!40000 ALTER TABLE `tblregistro` DISABLE KEYS */;
INSERT INTO `tblregistro` VALUES (1,'14:00:00','16:56:51',22,'2022-06-08','2022-06-09',2,1),(4,'13:18:00',NULL,NULL,'2022-06-08',NULL,2,2),(5,'08:37:00',NULL,NULL,'2022-06-08',NULL,4,5);
/*!40000 ALTER TABLE `tblregistro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblsetor`
--

DROP TABLE IF EXISTS `tblsetor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblsetor` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsetor`
--

LOCK TABLES `tblsetor` WRITE;
/*!40000 ALTER TABLE `tblsetor` DISABLE KEYS */;
INSERT INTO `tblsetor` VALUES (1,'A'),(2,'D'),(4,'E'),(5,'F'),(6,'C');
/*!40000 ALTER TABLE `tblsetor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbltelefone_estacionamento`
--

DROP TABLE IF EXISTS `tbltelefone_estacionamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbltelefone_estacionamento` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `telefone` varchar(20) NOT NULL,
  `idEstacionamento` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_Telefone_Estacionamento` (`idEstacionamento`),
  CONSTRAINT `FK_Telefone_Estacionamento` FOREIGN KEY (`idEstacionamento`) REFERENCES `tblestacionamento` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbltelefone_estacionamento`
--

LOCK TABLES `tbltelefone_estacionamento` WRITE;
/*!40000 ALTER TABLE `tbltelefone_estacionamento` DISABLE KEYS */;
INSERT INTO `tbltelefone_estacionamento` VALUES (3,'20 00000-0000',1);
/*!40000 ALTER TABLE `tbltelefone_estacionamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblvagas`
--

DROP TABLE IF EXISTS `tblvagas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblvagas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `numero` int NOT NULL,
  `idSetor` int unsigned NOT NULL,
  `idEstacionamento` int unsigned NOT NULL,
  `idPlano` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_Vagas_Setor` (`idSetor`),
  KEY `FK_Vagas_Estacionamento` (`idEstacionamento`),
  KEY `FK_Vagas_Plano` (`idPlano`),
  CONSTRAINT `FK_Vagas_Estacionamento` FOREIGN KEY (`idEstacionamento`) REFERENCES `tblestacionamento` (`id`),
  CONSTRAINT `FK_Vagas_Plano` FOREIGN KEY (`idPlano`) REFERENCES `tblplano` (`id`),
  CONSTRAINT `FK_Vagas_Setor` FOREIGN KEY (`idSetor`) REFERENCES `tblsetor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblvagas`
--

LOCK TABLES `tblvagas` WRITE;
/*!40000 ALTER TABLE `tblvagas` DISABLE KEYS */;
INSERT INTO `tblvagas` VALUES (2,7,2,1,1),(3,3,1,1,1),(4,30,1,1,1),(5,18,1,1,1),(6,6,1,1,1),(7,7,1,1,1),(9,9,1,1,1),(10,10,1,1,1),(12,12,1,1,1),(13,25,1,1,1),(14,25,1,1,1);
/*!40000 ALTER TABLE `tblvagas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblveiculo`
--

DROP TABLE IF EXISTS `tblveiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblveiculo` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `placa` varchar(8) NOT NULL,
  `idCliente` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_Veiculo_Cliente` (`idCliente`),
  CONSTRAINT `FK_Veiculo_Cliente` FOREIGN KEY (`idCliente`) REFERENCES `tblcliente` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblveiculo`
--

LOCK TABLES `tblveiculo` WRITE;
/*!40000 ALTER TABLE `tblveiculo` DISABLE KEYS */;
INSERT INTO `tblveiculo` VALUES (1,'ABC-1234',1),(2,'BRE-4897',2),(4,'JFK-4557',4),(5,'JFK-4557',6),(6,'DCE-2222',1);
/*!40000 ALTER TABLE `tblveiculo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'dbfastparking'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-09 16:59:21
