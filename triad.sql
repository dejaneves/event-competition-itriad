-- MySQL dump 10.13  Distrib 5.7.15, for Linux (x86_64)
--
-- Host: localhost    Database: triad
-- ------------------------------------------------------
-- Server version	5.7.15-0ubuntu0.16.04.1

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'Jaime Neves','admin@gmail.com','123');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `competicao`
--

DROP TABLE IF EXISTS `competicao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competicao` (
  `competicao_id` int(11) NOT NULL AUTO_INCREMENT,
  `homenagiado_id` int(11) DEFAULT NULL,
  `titulo` varchar(80) DEFAULT NULL,
  `descricao` text,
  `data` varchar(50) DEFAULT NULL,
  `qtd_ingresso` int(11) DEFAULT NULL,
  `local` text,
  `status` enum('ativo','inativo') DEFAULT NULL,
  PRIMARY KEY (`competicao_id`),
  KEY `fk_competicao_1_idx` (`homenagiado_id`),
  CONSTRAINT `fk_competicao_1` FOREIGN KEY (`homenagiado_id`) REFERENCES `homenagiado` (`homenagiado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `competicao`
--

LOCK TABLES `competicao` WRITE;
/*!40000 ALTER TABLE `competicao` DISABLE KEYS */;
INSERT INTO `competicao` VALUES (1,1,'Festival Amazonense de Natação','Apesar de não ser um exercício tão natural para o ser humano como caminhar ou correr, a natação existe há milênios.','Novembro 12, 2016',800,'Aquática Amazonas, Av. Efigênio Sales','ativo');
/*!40000 ALTER TABLE `competicao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `competicao_has_modalidade`
--

DROP TABLE IF EXISTS `competicao_has_modalidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competicao_has_modalidade` (
  `competicao_has_modalidade_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_modalidade_id` int(11) DEFAULT NULL,
  `fk_competicao_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`competicao_has_modalidade_id`),
  KEY `fk_competicao_has_modalidade_1_idx` (`fk_competicao_id`),
  KEY `fk_competicao_has_modalidade_2_idx` (`fk_modalidade_id`),
  CONSTRAINT `fk_competicao_has_modalidade_1` FOREIGN KEY (`fk_competicao_id`) REFERENCES `competicao` (`competicao_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_competicao_has_modalidade_2` FOREIGN KEY (`fk_modalidade_id`) REFERENCES `modalidade` (`modalidade_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `competicao_has_modalidade`
--

LOCK TABLES `competicao_has_modalidade` WRITE;
/*!40000 ALTER TABLE `competicao_has_modalidade` DISABLE KEYS */;
INSERT INTO `competicao_has_modalidade` VALUES (1,1,1),(2,2,1),(3,3,1),(4,4,1);
/*!40000 ALTER TABLE `competicao_has_modalidade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `homenagiado`
--

DROP TABLE IF EXISTS `homenagiado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `homenagiado` (
  `homenagiado_id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `historia` text,
  PRIMARY KEY (`homenagiado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `homenagiado`
--

LOCK TABLES `homenagiado` WRITE;
/*!40000 ALTER TABLE `homenagiado` DISABLE KEYS */;
INSERT INTO `homenagiado` VALUES (1,'Michael Phelps','1985-06-30','Michael Fred Phelps II (Baltimore, 30 de junho de 1985) é um ex- nadador norte-americano. Considerado um dos maiores atletas de todos os tempos, conquistou trinta e sete recordes mundiais e conquistou o maior número de medalhas de ouro (nove) olímpicas em uma única edição, feito este realizado nos Jogos de Pequim, na China, em agosto de 2008.');
/*!40000 ALTER TABLE `homenagiado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscricao`
--

DROP TABLE IF EXISTS `inscricao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inscricao` (
  `inscricao_id` int(11) NOT NULL AUTO_INCREMENT,
  `participante_id` int(11) DEFAULT NULL,
  `data` int(11) DEFAULT NULL,
  `participou_anterior` enum('sim','nao') DEFAULT NULL,
  PRIMARY KEY (`inscricao_id`),
  KEY `fk_inscricao_1_idx` (`participante_id`),
  CONSTRAINT `fk_inscricao_1` FOREIGN KEY (`participante_id`) REFERENCES `participante` (`participante_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscricao`
--

LOCK TABLES `inscricao` WRITE;
/*!40000 ALTER TABLE `inscricao` DISABLE KEYS */;
INSERT INTO `inscricao` VALUES (1,38,1475342197,'sim'),(2,39,1475342634,'sim'),(3,40,1475342756,'sim'),(4,41,1475342807,'sim'),(5,42,1475342862,'sim'),(6,43,1475342930,'sim'),(7,44,1475343240,'sim'),(8,45,1475343245,'sim'),(9,46,1475343794,'sim'),(10,47,1475343831,'sim'),(11,48,1475343860,'sim'),(12,49,1475343877,'sim'),(13,50,1475343943,'sim'),(14,51,1475344378,'sim'),(15,52,1475344409,'sim'),(16,53,1475344487,'sim'),(17,54,1475344531,'sim'),(18,55,1475344562,'sim'),(19,56,1475344638,'sim'),(20,57,1475344714,'sim'),(21,58,1475344771,'sim'),(22,59,1475344853,'sim'),(23,60,1475344909,'sim'),(24,61,1475344921,'sim'),(25,62,1475348398,'sim'),(26,63,1475351817,'sim'),(27,64,1475356218,'sim');
/*!40000 ALTER TABLE `inscricao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscricao_has_modalidade`
--

DROP TABLE IF EXISTS `inscricao_has_modalidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inscricao_has_modalidade` (
  `inscricao_id` int(11) NOT NULL,
  `competicao_has_modalidade_id` int(11) NOT NULL,
  PRIMARY KEY (`inscricao_id`,`competicao_has_modalidade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscricao_has_modalidade`
--

LOCK TABLES `inscricao_has_modalidade` WRITE;
/*!40000 ALTER TABLE `inscricao_has_modalidade` DISABLE KEYS */;
INSERT INTO `inscricao_has_modalidade` VALUES (1,1),(2,1),(3,1),(4,2),(5,2),(6,2),(7,3);
/*!40000 ALTER TABLE `inscricao_has_modalidade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modalidade`
--

DROP TABLE IF EXISTS `modalidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modalidade` (
  `modalidade_id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) DEFAULT NULL,
  `descricao` text,
  PRIMARY KEY (`modalidade_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modalidade`
--

LOCK TABLES `modalidade` WRITE;
/*!40000 ALTER TABLE `modalidade` DISABLE KEYS */;
INSERT INTO `modalidade` VALUES (1,'Estilo Livre','Neste estilo o nadador pode optar pelo estilo de nado que preferir. Na prática o estilo usado com maior frequência é o crawl, em que o atleta nada em posição ventral (barriga voltada para o fundo da piscina) e move os braços, paralelamente ao corpo, num movimento rotativo (quando um braço avança o outro recua), enquanto bate as pernas, também alternadamente.'),(2,'Estilo Costas','O estilo costas tem uma técnica semelhante ao crawl, excepto que é praticado com as costas voltadas para o fundo da piscina. O estilo costas compete-se em distâncias de 50m,100m e 200m.'),(3,'Estilo Bruços','O estilo costas tem uma técnica semelhante ao crawl, excepto que é praticado com as costas voltadas para o fundo da piscina. O estilo costas compete-se em distâncias de 50m,100m e 200m.'),(4,'Estilo Mariposa','No estilo mariposa, o nadador está com a barriga voltada para o fundo da piscina, rodando os braços lateral e simultaneamente e batendo as pernas juntas. É para muito o estilo mais complicado de nadar e que requer maiores indices de força, mas de londe o mais bonito de se ver por ser parecido com o nado de um golfinho.');
/*!40000 ALTER TABLE `modalidade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participante`
--

DROP TABLE IF EXISTS `participante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participante` (
  `participante_id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) DEFAULT NULL,
  `sobrenome` varchar(80) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `senha` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`participante_id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participante`
--

LOCK TABLES `participante` WRITE;
/*!40000 ALTER TABLE `participante` DISABLE KEYS */;
INSERT INTO `participante` VALUES (18,'Jaime','Neves','jaimebarrosoneves@gmail.com','123'),(21,'João','Carlos','jaimebarrosoneves@gmail.com','123'),(22,'Maria','Silva','jaimebarrosoneves@gmail.com','123'),(23,'Domingos','Vieira','jaimebarrosoneves@gmail.com','123'),(24,'Joana','Vieira','jaimebarrosoneves@gmail.com','123'),(27,'Victor','Moreira','jaimebarrosoneves@gmail.com','123'),(28,'Marcos','Almeida','jaimebarrosoneves@gmail.com','123'),(29,'Cristovam','Moreira','jaimebarrosoneves@gmail.com','123'),(38,'Mariana','Domingues','jaimebarrosoneves@gmail.com','123'),(39,'Luciana','Novo','jaimebarrosoneves@gmail.com','123'),(40,'Anderson','Silva','jaimebarrosoneves@gmail.com','123'),(41,'Silvio','Santos','jaimebarrosoneves@gmail.com','123'),(42,'Mario','Novo','mario@gmail.com','123'),(43,'Jaime','Neves','jaimebarrosoneves@gmail.com','123'),(44,'Sergio','Malandro','sergio@gmail.com','123'),(45,'Eliana','Ribeiro','eliana@gmail.com','123'),(46,'Junior','Neves','jaimebarrosoneves@gmail.com','123'),(47,'Marcelo','neves','jaimebarrosoneves@gmail.com','123'),(48,'Celso','Andrade','celso@gmail.com','123'),(49,'Jairo','Barroso','jaimebarrosoneves@gmail.com','123'),(50,'Daniel','Pinheiro','jaimebarrosoneves@gmail.com','123'),(51,'Ane','Santos','jaimebarrosoneves@gmail.com','123'),(52,'Júlio','Cabral','jaimebarrosoneves@gmail.com','123'),(53,'Nira','Santos','jaimebarrosoneves@gmail.com','123'),(54,'Helder','Barroso','helder@gmail.com','123'),(55,'Liliane','Paiva','sdfdsf','123'),(56,'Gabriel','Paiva','jaimebarrosoneves@gmail.com','123'),(57,'Jucenildo','Junior','jaimebarrosoneves@gmail.com','123'),(58,'Vinicius','Santos','vinicius@gmail.com','123'),(59,'Marco','Antonio','jaimebarrosoneves@gmail.com','123'),(60,'Venancio','Filho','jaimebarrosoneves@gmail.com','123'),(61,'Diego','Neves','jaimebarrosoneves@gmail.com','123'),(62,'Bruno','Mendonça','bruno@gmail.com','123'),(63,'Kelly','Neves','kelly@gmail.com','123'),(64,'Ana Telma','Barroso','jaimebarrosoneves@gmail.com','123');
/*!40000 ALTER TABLE `participante` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-03 10:02:04
